<?php
/**
 * PRAGMA AAIR Checker v5 — multi-engine (LLM + SLM) endpoint on DreamHost.
 * POST JSON or form: { business, city, service, email }
 * Returns JSON: { ok, aair_pct, llm_pct, slm_pct, fraction, engines{}, market_line }
 * Runs the AAIR probe across many OpenRouter chat engines in parallel and scores
 * whether the business is named. Reads the key from aair-config.php.
 * URL: https://prag-ma.ai/aair-checker.php
 *
 * RULER PRINCIPLE (locked 2026-07-15):
 * Every denominator is counted from scored results at write time.
 * Never derive fractions from the panel dimensions.
 * An unrecoverable cell is a NO-READ, not an absence: it is excluded from the
 * denominator, reported separately, and NEVER counted as entity_found=false.
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { exit; }

@set_time_limit(180); ignore_user_abort(true); // finish + log even if the client disconnects

require __DIR__ . '/aair-config.php';

$raw = file_get_contents('php://input');
$in = json_decode($raw, true);
if (!is_array($in)) { $in = $_POST; }
$business = trim(substr($in['business'] ?? '', 0, 120));
$city     = trim(substr($in['city']     ?? '', 0, 80));
$service  = trim(substr($in['service']  ?? '', 0, 60));
$email    = trim(substr($in['email']    ?? '', 0, 120));
if ($service === '') { $service = 'service'; }
if ($business === '' || $city === '') {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'business and city are required']); exit;
}

if (!isset($OPENROUTER_KEY) || $OPENROUTER_KEY === '' || strpos($OPENROUTER_KEY,'PASTE_') === 0) {
  if (!empty($FORMSPREE_URL)) { @post_json($FORMSPREE_URL, $in); }
  echo json_encode(['ok'=>true,'queued'=>true,'message'=>'Scan requested — we’ll email your AAIR score shortly.']); exit;
}

// The engine panel: Mirror tier = the LLMs buyers actually ask; SLM tier = small/on-device models.
// 16 engines across every major model family. All IDs verified live on OpenRouter (2026-07-13).
$ENGINES = [
  // Mirror tier (LLMs)
  ['id'=>'gpt4o',       'label'=>'ChatGPT (GPT-4o)',      'tier'=>'llm', 'model'=>'openai/gpt-4o'],
  ['id'=>'gpt4omini',   'label'=>'ChatGPT (GPT-4o mini)', 'tier'=>'llm', 'model'=>'openai/gpt-4o-mini'],
  ['id'=>'claudesonnet','label'=>'Claude Sonnet 4.5',     'tier'=>'llm', 'model'=>'anthropic/claude-sonnet-4.5'],
  ['id'=>'claudehaiku', 'label'=>'Claude Haiku 4.5',      'tier'=>'llm', 'model'=>'anthropic/claude-haiku-4.5'],
  ['id'=>'gemini',      'label'=>'Google Gemini 2.5',     'tier'=>'llm', 'model'=>'google/gemini-2.5-flash'],
  ['id'=>'perplexity',  'label'=>'Perplexity (Sonar)',    'tier'=>'llm', 'model'=>'perplexity/sonar'],
  ['id'=>'grok',        'label'=>'xAI Grok 4.5',          'tier'=>'llm', 'model'=>'x-ai/grok-4.5'],
  ['id'=>'deepseek',    'label'=>'DeepSeek V3.1',         'tier'=>'llm', 'model'=>'deepseek/deepseek-chat-v3.1'],
  ['id'=>'llama4',      'label'=>'Llama 4 Maverick',      'tier'=>'llm', 'model'=>'meta-llama/llama-4-maverick'],
  ['id'=>'qwen72b',     'label'=>'Qwen 2.5 72B',          'tier'=>'llm', 'model'=>'qwen/qwen-2.5-72b-instruct'],
  // SLM tier (small models)
  ['id'=>'llama3b',     'label'=>'Llama 3.2 3B',          'tier'=>'slm', 'model'=>'meta-llama/llama-3.2-3b-instruct'],
  ['id'=>'llama8b',     'label'=>'Llama 3.1 8B',          'tier'=>'slm', 'model'=>'meta-llama/llama-3.1-8b-instruct'],
  ['id'=>'gemma4b',     'label'=>'Gemma 3 4B',            'tier'=>'slm', 'model'=>'google/gemma-3-4b-it'],
  ['id'=>'phi4',        'label'=>'Microsoft Phi-4',       'tier'=>'slm', 'model'=>'microsoft/phi-4'],
  ['id'=>'qwen7b',      'label'=>'Qwen 2.5 7B',           'tier'=>'slm', 'model'=>'qwen/qwen-2.5-7b-instruct'],
  ['id'=>'ministral8b', 'label'=>'Ministral 8B',          'tier'=>'slm', 'model'=>'mistralai/ministral-8b-2512'],
];
$TEMPLATES = [
  "best {s} near {c}", "top rated {s} company {c}", "who is the best {s} in {c}",
  "recommended {s} near me {c}", "{s} near me {c}", "who should I hire for {s} in {c}",
];
$prompts = array_map(function($t) use ($service,$city){ return str_replace(['{s}','{c}'], [$service,$city], $t); }, $TEMPLATES);

// Probe each (engine, prompt) once with retries, recording status = 'scored' | 'no_read'.
// Retry up to 3 attempts with exponential backoff: ~2s, 4s, 8s before declaring no_read.
$MAX_RETRIES = 3;
$BACKOFF_BASE_S = 2;
$cells = [];
foreach ($ENGINES as $eng) {
  foreach ($prompts as $p) {
    $cells[] = [
      'engine_id' => $eng['id'],
      'engine'    => $eng,
      'prompt'    => $p,
      'status'    => 'no_read',
      'text'      => '',
      'error'     => null,
    ];
  }
}

$mh = curl_multi_init();
$inFlight = [];
function makeCellHandle(&$cell, $OPENROUTER_KEY) {
  $q = "A person searches: \"" . $cell['prompt'] . "\". Name the top 3 specific local businesses you would recommend, by business name. Be concrete.";
  $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Authorization: *** '.$OPENROUTER_KEY,'Content-Type: application/json','HTTP-Referer: https://prag-ma.ai','X-Title: PRAGMA AAIR Checker'],
    CURLOPT_POSTFIELDS => json_encode(['model'=>$cell['engine']['model'],'messages'=>[['role'=>'user','content'=>$q]],'max_tokens'=>400,'temperature'=>0]),
  ]);
  return $ch;
}

// Seed first attempt for all cells.
foreach ($cells as $idx => &$cell) {
  $ch = makeCellHandle($cells[$idx], $OPENROUTER_KEY);
  curl_multi_add_handle($mh, $ch);
  $inFlight[(int)$ch] = ['idx'=>$idx, 'attempt'=>1, 'ch'=>$ch, 'next_us'=>0];
}
unset($cell);

$bizLower = mb_strtolower($business); $core = aair_core($business);
do {
  $running = null;
  curl_multi_exec($mh, $running);
  curl_multi_select($mh, 1.0);
  // Collect completed handles.
  while (($info = curl_multi_info_read($mh)) !== false) {
    if (!isset($info['handle']) || $info['msg'] !== CURLMSG_DONE) continue;
    $ch = $info['handle'];
    $key = (int)$ch;
    if (!isset($inFlight[$key])) continue;
    $flight = $inFlight[$key];
    $idx = $flight['idx'];
    $attempt = $flight['attempt'];
    $resp = curl_multi_getcontent($ch);
    curl_multi_remove_handle($mh, $ch); curl_close($ch);
    unset($inFlight[$key]);

    $j = json_decode($resp, true);
    $errorStr = null;
    $text = '';
    if (isset($j['choices'][0]['message']['content'])) {
      $text = $j['choices'][0]['message']['content'];
    } else {
      $errorStr = '';
      if (isset($j['error']['message'])) { $errorStr .= $j['error']['message']; }
      if (isset($j['error']['code'])) { $errorStr .= ($errorStr ? ' / ' : '') . 'code '.$j['error']['code']; }
      if ($errorStr === '') { $errorStr = 'no choices in response'; }
    }
    $isRecoverable = preg_match('/rate.?limit|429|too many requests/i', $errorStr . ' ' . json_encode($j));

    if ($text !== '' || (!$isRecoverable && $attempt >= $MAX_RETRIES)) {
      // Final state for this cell.
      $cells[$idx]['text'] = $text;
      $cells[$idx]['error'] = $errorStr;
      $cells[$idx]['status'] = ($text !== '') ? 'scored' : 'no_read';
    } else {
      // Retry transient errors up to MAX_RETRIES
      $nextAttempt = $attempt + 1;
      if ($nextAttempt <= $MAX_RETRIES) {
        $delay = $BACKOFF_BASE_S * (1 << ($nextAttempt - 1));
        usleep(min($delay * 1000000, 12000000));
        $newCh = makeCellHandle($cells[$idx], $OPENROUTER_KEY);
        curl_multi_add_handle($mh, $newCh);
        $inFlight[(int)$newCh] = ['idx'=>$idx, 'attempt'=>$nextAttempt, 'ch'=>$newCh];
      } else {
        $cells[$idx]['error'] = $errorStr;
        $cells[$idx]['status'] = 'no_read';
      }
    }
  }
  $stillQueued = count(array_filter($inFlight, function($f){ return !isset($f['queued_retry']); }));
} while ($running > 0 || count($inFlight) > 0);
curl_multi_close($mh);

// Aggregate results from scored cells only.
$engines = [];
foreach ($ENGINES as $e) {
  $engines[$e['id']] = [
    'label'=>$e['label'], 'tier'=>$e['tier'],
    'attempted'=>0, 'scored'=>0, 'no_read'=>0, 'cited'=>0,
  ];
}
$attempted=0; $scored=0; $no_read=0; $cited=0;
$llmA=0; $llmS=0; $llmNR=0; $llmC=0;
$slmA=0; $slmS=0; $slmNR=0; $slmC=0;

foreach ($cells as $cell) {
  $eid = $cell['engine_id'];
  $tier = $engines[$eid]['tier'];
  $engines[$eid]['attempted']++;
  $attempted++;
  if ($tier === 'llm') { $llmA++; } else { $slmA++; }

  if ($cell['status'] === 'scored') {
    $t = mb_strtolower($cell['text']);
    $hit = ($bizLower!=='' && mb_strpos($t,$bizLower)!==false) || ($core!=='' && mb_strlen($core)>=4 && mb_strpos($t,$core)!==false);
    $engines[$eid]['scored']++; $scored++;
    if ($tier === 'llm') { $llmS++; } else { $slmS++; }
    if ($hit) {
      $engines[$eid]['cited']++; $cited++;
      if ($tier === 'llm') { $llmC++; } else { $slmC++; }
    }
  } else {
    $engines[$eid]['no_read']++; $no_read++;
    if ($tier === 'llm') { $llmNR++; } else { $slmNR++; }
  }
}

$aair = $scored ? (int)round(($cited/$scored)*100) : 0;
$llm  = $llmS ? (int)round(($llmC/$llmS)*100) : 0;
$slm  = $slmS ? (int)round(($slmC/$slmS)*100) : 0;
$fraction = "$cited/$scored";

@file_put_contents(__DIR__.'/aair-leads.log',
  json_encode([
    'business'=>$business,'city'=>$city,'service'=>$service,'email'=>$email,
    'aair'=>$aair,'llm'=>$llm,'slm'=>$slm,
    'attempted'=>$attempted,'scored'=>$scored,'no_read'=>$no_read,'cited'=>$cited,
    'ts'=>time()
  ])."\n", FILE_APPEND|LOCK_EX);
if (!empty($FORMSPREE_URL)) { @post_json($FORMSPREE_URL, array_merge($in, ['aair_pct'=>$aair,'llm_pct'=>$llm,'slm_pct'=>$slm])); }

echo json_encode([
  'ok'=>true, 'business'=>$business, 'city'=>$city,
  'schema_version'=>'v5',
  'aair_pct'=>$aair, 'llm_pct'=>$llm, 'slm_pct'=>$slm,
  'fraction'=>$fraction,
  'attempted'=>$attempted, 'scored'=>$scored, 'no_read'=>$no_read, 'cited'=>$cited,
  'llm'=>['attempted'=>$llmA,'scored'=>$llmS,'no_read'=>$llmNR,'cited'=>$llmC],
  'slm'=>['attempted'=>$slmA,'scored'=>$slmS,'no_read'=>$slmNR,'cited'=>$slmC],
  'engines'=>$engines,
  'market_line'=>'Absolute AAIR across '.count($ENGINES).' engines. Metro median publishes once baseline reaches N≥20.',
]);

function aair_core($name){
  $n=mb_strtolower($name); $n=str_replace('&',' and ',$n);
  $n=preg_replace('/\b(inc|llc|ltd|co|company|the|services?|signs?|lawn|care|air|hvac|heating|cooling|plumbing|electric(al)?)\b/',' ',$n);
  $n=preg_replace('/[^a-z0-9 ]+/',' ',$n); return trim(preg_replace('/\s+/',' ',$n));
}
function post_json($url,$payload){
  $ch=curl_init($url);
  curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_TIMEOUT=>15,CURLOPT_POST=>true,CURLOPT_HTTPHEADER=>['Content-Type: application/json'],CURLOPT_POSTFIELDS=>json_encode($payload)]);
  curl_exec($ch); curl_close($ch);
}
