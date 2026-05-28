# PRAGMA Website v2.0 — C-Suite Architecture Brief

**Date:** 2026-05-19
**Domain:** prag-ma.ai
**Brand reference:** v1.1 deck (math-invisible mark, locked tagline "We don't write the plan. We run it.")
**Aesthetic target:** Centurion-grade exclusivity — and beyond. Patek Philippe institutional weight + Linear atmospheric motion + Bridgewater editorial restraint + Anthropic terminal-friendly precision.

---

## The C-suite at the table

| Agent | What they own |
|---|---|
| **Vector** (graphic-designer) | Visual identity, atmospheric direction, motion, mark application |
| **Keystone** (CSO) | Positioning, defensibility, wedge-to-empire, the "Coca-Cola" tests |
| **brand-review** (marketing) | Voice/tone consistency, claim screening, legal flag detection |
| **content-creation** (marketing) | Blog pillars, SEO copy, headline architecture |
| **design-system** (design) | Tokens, component grammar, modular consistency |
| **ux-copy** (design) | Every microcopy decision — CTAs, errors, empty states, form labels |

What follows is the unified call. Each agent's perspective is collapsed into the singular architecture below.

---

## Strategic frame (Keystone)

### The website's job
PRAGMA is **inbound only in Year 1.** The website is not a lead-generation funnel. It is **proof-of-life for a thesis** — a destination senior operators land on, read for three minutes, and either apply or close the tab. There is no middle state. There is no nurture sequence. The Mailchimp-style "subscribe for our newsletter" pattern is contra-positioning and explicitly forbidden.

### What this means structurally
- **No pricing on the website.** Centurion doesn't publish the annual fee. Patek Philippe doesn't publish list price. PRAGMA doesn't either. The application form collects budget range; PRAGMA responds.
- **No "Contact us" page.** Only **Apply.** This frames the relationship: PRAGMA reviews applications, not leads.
- **No live chat widget.** No cookie banner unless legally required. No exit-intent popup. No newsletter modal. No "We use cookies" disclaimer covering the bottom edge of the design. Every dark pattern is forbidden by brand decree.
- **No client logos farm.** Year 1, PRAGMA has zero closed clients to display. Don't fake it with "as featured in" walls. The institutional spine (HBS AI Institute, Microsoft WTI, Lakhani) carries the credibility.
- **No social proof testimonials yet.** Same reason. Year 2 expansion.

### The wedge restated for the site
"We built this on ourselves first." That single claim is the brand's hardest competitive moat. It separates PRAGMA from every AI consulting firm that sells what they haven't operated. Every page reinforces it — directly or by implication.

---

## Visual direction (Vector)

### The atmosphere
The site should feel like landing in **the lobby of a private investment club** at 11 PM. Dim, intentional, alive but not loud. The user senses they're somewhere selective before they read a word.

### The math discipline (locked principle)
Per the v1.1 lock: **math governs scale and distance between elements; math is never drawn.** This applies site-wide:
- Layout grids use Fibonacci spacing (8, 13, 21, 34, 55, 89, 144 px)
- Typography scale is φ-based (16 → 26 → 42 → 68 → 110 px)
- Section vertical rhythm is φ-proportioned
- The cursor mark on every page is the locked single-form mark — no inner rings

### The palette
| Token | Value | Use |
|---|---|---|
| `--void` | #0A0A0A | Primary background. Everywhere. |
| `--void-2` | #0E0E0E | Section alternation (barely perceptible) |
| `--void-3` | #141414 | Card / pillar block surfaces |
| `--signal` | #1FE07E | The pulse. Used sparingly. |
| `--signal-dim` | rgba(31,224,126,0.08) | Card glows, hairline borders |
| `--signal-line` | rgba(31,224,126,0.18) | Borders that ARE the brand |
| `--output` | #FFFFFF | Display text on dark |
| `--output-65` | rgba(255,255,255,0.65) | Body text |
| `--output-45` | rgba(255,255,255,0.45) | Subtitles, meta |
| `--output-30` | rgba(255,255,255,0.30) | Tertiary / hint |
| `--output-12` | rgba(255,255,255,0.12) | Hairline rules |

**No grays.** Pure white text drops to opacity values against Void. This is what gives the brand its "vault" feel — the dark is RICH dark, the light is precise white. No mushy mid-tones.

### Typography (v2.0 upgrade from system fonts)
Loaded from Google Fonts (one stylesheet, fast):
- **Inter** (display + body) — modern, neutral, every weight from 300 to 900
- **Fraunces** (editorial accents, pull quotes) — variable serif with optical sizing; gives editorial moments their weight
- **JetBrains Mono** (terminal / accent) — the canonical AI-era mono

Scale (φ-based):
| Role | Size | Weight | Line height |
|---|---|---|---|
| Display | clamp(56px, 9vw, 144px) | 900 | 0.95 |
| H1 | clamp(40px, 6vw, 89px) | 800 | 1.05 |
| H2 | clamp(32px, 4.5vw, 55px) | 700 | 1.1 |
| H3 | clamp(22px, 3vw, 34px) | 700 | 1.2 |
| Pull quote | clamp(24px, 3.5vw, 42px) | 400 (Fraunces) | 1.4 |
| Lede | clamp(18px, 2vw, 26px) | 300 | 1.55 |
| Body | 17px | 400 | 1.75 |
| Eyebrow | 11px | 500 | letter-spacing 0.25em uppercase |
| Mono caption | 12px JetBrains Mono | 500 | 1.6 |

### Motion (subtle, earned)
- **Atmospheric gradient drift** — the top-right Signal glow slowly rotates over 60s. Imperceptible per second. The page feels alive.
- **Scroll-revealed sections** — every section fades in over 800ms when 30% in viewport. Uses Intersection Observer; no library.
- **Cursor companion** (desktop only) — a soft 320px-radius radial glow follows the cursor on the home hero. Very faint. Hidden below md breakpoint.
- **Hover states** are deliberate — buttons translate up 1px and the Signal accent strengthens. No opacity flicker.
- **No parallax.** No video backgrounds. No splash screens. No loaders.

### What's NOT in the visual system
- No stock photography
- No team headshots in body content (founder photo lives only in `/about`)
- No iconography farms (Lucide / FontAwesome). Icons are custom or absent.
- No gradient backgrounds beyond the single corner glow
- No drop shadows. No blur effects beyond the cursor companion. No skeuomorphism.

---

## Voice & messaging (brand-review)

### The four locked tone principles
1. **Decisive** — no "perhaps" / "consider"
2. **Precise** — numbers when claims are made
3. **Warm** — operator-to-operator respect, not coldness
4. **Plain** — SMB vocabulary, no consultant jargon

### The locked vocabulary
| Use | Don't use |
|---|---|
| "we run it" / "we deploy" | "we advise" / "we recommend" |
| "report," "plan," "slides" (re: competition) | "deck" (consultant jargon SMBs don't share) |
| "AI agents working continuously as your operations team" (gloss) | bare "Frontier Firm Operating System" with no gloss |
| "agent map" (client-facing) | "routing table" (internal only) |
| "the work that used to require 3-5 specialized hires" | "doing the work of entire departments" |
| "Our pay depends on yours" | "Skin in the game" (cliché) |
| "AI that runs the work" | "AI that does the work" |

### Forbidden phrases site-wide
- "Cutting-edge" / "bleeding-edge" / "best-in-class" / "leveraging" / "synergies"
- "Disrupt" / "disruptor" / "game-changer"
- "Empower" / "unlock" / "unleash"
- "We are pleased to announce" — never. PRAGMA does not announce. PRAGMA ships.

---

## Information architecture

```
prag-ma.ai/                          [HOME]
├── /apply/                          [Application questionnaire — the conversion event]
├── /thinking/                       [Blog index — pillar content]
│   └── /thinking/[post-slug]/       [Individual posts with full schema]
├── /about/                          [Bobby, HC parent, PRAGMA thesis]
├── /the-operating-system/           [Deep dive — the Frontier Firm OS]
├── /robots.txt                      [Crawler directives]
├── /sitemap.xml                     [SEO map]
├── /llms.txt                        [AI-crawler standard — GEO]
└── /favicon.svg                     [PRAGMA mark]
```

**No `/services` page.** No `/pricing`. No `/contact`. The architecture says: read the thesis, apply, or leave.

---

## Page-by-page intent

### `/` (Home)
Goal: in 90 seconds, the operator either feels the brand or doesn't. If they feel it, they click Apply.

Sections (in scroll order):
1. **Hero** — Locked tagline + 30-word lede. Cursor companion glow. Single CTA: "Apply"
2. **The cut** — Most AI projects end in a report. PRAGMA ends with a running system. Three short paragraphs, pull-quote treatment.
3. **The contrast** — Them vs. PRAGMA (refined from v1.0, more atmospheric)
4. **The pillar** — "Built on the operator." The wedge.
5. **The research** — HBS / Microsoft / Lakhani institutional spine. One paragraph, citation-dense.
6. **The shape of an engagement** — Four phases in 30 days. Brief.
7. **Apply** — Manufactured scarcity ("Currently considering N applications for [next quarter]"). Single CTA.
8. **Footer** — minimal. Mark, prag-ma.ai, "A Hartley Capital company", year.

### `/apply` (Application questionnaire)
Goal: feels like applying to YC or Harvard, not filling out a contact form. Bobby reviews each application personally; questionnaire produces enough signal to score against the Frontier Firm Readiness rubric (see `02-client-discovery-questionnaire.md`).

Six sections — see "Application form spec" below.

### `/thinking` (Blog)
Pillar content per the social strategy. Index page lists posts in editorial card layout (date, headline, dek, eyebrow tag, read time).

First three posts (templates ready):
1. "The Frontier Firm Operating System, explained" (Pillar 2 — research synthesis)
2. "What we learned running it on ourselves first" (Pillar 1 — operator proof)
3. "Why most AI projects end in a report" (Pillar 3 — thesis)

Each post page: hero, body (long-form, 1500-2500 words), pull quotes, citations, author byline, FAQ schema block, related posts.

### `/about`
Bobby's operating record (30+ years), Hartley Capital parent attribution, the relationship between HC and PRAGMA, the team of one (Robert + the Construct), HBS AI Institute affiliation.

Includes:
- Author markup (Schema.org Person)
- E-E-A-T signals (Experience / Expertise / Authoritativeness / Trust)
- A single founder portrait (the ONLY photo on the site)

### `/the-operating-system`
The deep-dive product page. The four phases, the five PRAGMA Operators (Keystone, Vector, Atlas, Lens, Scout) plus custom domain-specific Operators, the routing-table-now-called-agent-map, the Self-Improving Loop, the LISTEN/READ/WATCH output discipline.

This page exists because Google + AI search engines want depth. A 2,000-word authoritative page on "Frontier Firm Operating System" earns rankings + citations.

---

## SEO architecture

### Primary keyword targets (rank within 6 months)
| Keyword | Search intent | Target page |
|---|---|---|
| "Frontier Firm Operating System" | Brand-defining; PRAGMA owns this term | Home + `/the-operating-system` |
| "AI agents for small business" | High-intent commercial | `/the-operating-system` |
| "AI deployment consulting" | Commercial | Home |
| "Frontier Firm definition" | Informational, leads to brand | `/thinking/frontier-firm-explained` |
| "multi-agent AI for SMB" | Commercial | `/the-operating-system` |
| "Cybernetic Teammate Lakhani" | Informational, institutional | `/thinking/lakhani-cybernetic-teammate-translated` |

### On-page SEO baseline (every page)
- Title tag: under 60 chars, includes primary keyword, ends with " · PRAGMA"
- Meta description: under 160 chars, hooks click
- One H1, multiple H2s, H3s where natural
- Image alt text on every image (descriptive, keyword-natural)
- 2-3 internal links per page (within-site discovery)
- 1-2 outbound citations to HBR / HBS AI Institute / Microsoft when relevant
- Canonical URL set
- Open Graph + Twitter Card meta (with branded OG image)
- Schema.org JSON-LD per page type

### Schema.org markup (per page type)
| Page | Schema types |
|---|---|
| Home | Organization, WebSite, BreadcrumbList |
| /about | Person (Robert Hartley), Organization (PRAGMA, HC) |
| /the-operating-system | Service, FAQPage, BreadcrumbList |
| /thinking/[post] | Article, Person (author), BreadcrumbList, FAQPage (if Q&A) |
| /apply | WebPage, BreadcrumbList |

### Core Web Vitals targets
- LCP (Largest Contentful Paint): under 1.8s on 4G
- INP (Interaction to Next Paint): under 200ms
- CLS (Cumulative Layout Shift): under 0.1

Achieved by: zero external JS frameworks, system+Google fonts preloaded, SVG marks inline, single-file CSS, lazy-load images below the fold (none expected in v1).

---

## GEO architecture (Generative Engine Optimization)

GEO is the 2026 discipline: getting cited by ChatGPT, Claude, Perplexity, Gemini, Google AI Overviews. Different from classical SEO because the goal isn't a click — it's a citation.

### GEO principles applied to PRAGMA
1. **Citable factual statements with attribution.** "Karim Lakhani's 791-person P&G study (HBS, 2025)" → an AI quoting that line credits the source naturally.
2. **Definitive Q&A structures.** FAQPage schema on every relevant page. AI engines synthesize answers from these.
3. **Author bylines + credentials.** Schema.org Person on every authored post. Builds E-E-A-T for AI evaluation.
4. **`llms.txt` file at root.** Emerging standard for telling LLM crawlers which content is canonical. PRAGMA ships one.
5. **High-quality outbound citations.** Link to HBR / HBS AI Institute / Microsoft Work Trend Index / Lakhani's papers. AI engines trust pages that cite authoritative sources.
6. **Conversational headers.** "What is a Frontier Firm Operating System?" — direct question-as-heading. AI engines match these to user prompts.
7. **Direct answers in the first paragraph.** AI engines prefer pages where the answer comes first, supporting detail second. Inverted-pyramid is back.

### `llms.txt` content
A single Markdown file at root that says:
- Who PRAGMA is (one sentence)
- The institutional research foundation
- The canonical pages to cite
- The locked vocabulary (so AI engines reproduce the brand's language correctly)
- The contact for further inquiry (application URL)

### What the GEO play looks like
By Month 6, when an SMB founder types into Claude / ChatGPT: *"What's the difference between AI consulting and AI deployment?"* — PRAGMA's `/thinking/most-ai-projects-end-in-a-report` should be a cited source. By Month 12: when they type *"How do small businesses operationalize AI?"* — PRAGMA's `/the-operating-system` should be cited.

This is the long game. SEO ranks pages; GEO gets the brand named.

---

## Application form spec

The conversion event of the entire site. Six sections, no surveymonkey vibes.

### Section A — You
- Full name (required)
- Title at company (required)
- Company name (required)
- Email (required, email validation)
- Phone (optional)
- LinkedIn URL (optional)

### Section B — Your business
- Revenue range (radio): $0-1M / $1-5M / $5-25M / $25-100M / $100M+
- Team size (radio): 1-5 / 5-25 / 25-100 / 100+
- Business model (radio): Recurring revenue / Project-based / Transactional / Hybrid
- Industry (free text, 60 char)
- Founded (year, 4-digit numeric)
- Headquartered (city, state/country — free text)

### Section C — Where you are with AI
- Current AI deployment (radio): None / Trying tools individually / Have one workflow running / Multiple workflows / Other
- Tools used (free text, optional)
- What's worked (free text, optional)
- What hasn't (free text, optional)

### Section D — What you want
- Biggest constraint on growth right now (free text, ~300 char)
- If capacity doubled tomorrow without doubling headcount, what would you do with the room? (free text, ~300 char)
- 90-day outcome you want from PRAGMA (free text)
- 12-month outcome you want from PRAGMA (free text)

### Section E — Fit signals
- Commitment to operational reinvention (1-5 scale, framed as: "How willing are you to redesign how your business actually operates, not just add tools on top?")
- Decision speed (1-5, framed: "How quickly do you typically move from decision-made to decision-acted?")
- Budget capability (radio): $25-75K Year 1 / $75-150K Year 1 / $150K+ / Need to discuss
- Engagement timing (radio): This quarter / Next quarter / 6+ months out

### Section F — Final
- How did you hear about PRAGMA? (radio + "other" text)
- Anything else (free text, optional)
- Acknowledgment (required checkbox): "I understand PRAGMA reviews each application personally and takes a small number of engagements. I'll receive a response within 5 business days regardless of fit."

### Form backend
- Use Formspree free tier (50/month — sufficient for inbound-only) at `https://formspree.io/f/{FORM_ID}`
- Bobby registers Formspree account, swaps placeholder ID once
- Honeypot field for spam
- On submit: redirect to `/apply/received` thank-you page (NOT a modal — full page transition signals weight)

### The thank-you page
Single short message: "We've received your application. Robert reviews each one personally. You'll hear back within 5 business days. Until then — read our thinking." Link to `/thinking`. No upsell.

---

## Component grammar (design-system)

Reusable components that compose the entire site:

### `<Mark />` — the locked single-form mark
- Sizes: 16 / 32 / 64 / 96 / 128 / 192 / 256 / 384 px
- States: default, muted (opacity 0.6)
- Implementation: inline SVG, single ring + cursor

### `<Eyebrow />` — section labels
- "**>_** [number] — [section name]" in JetBrains Mono, Signal green, 11px, letter-spacing 0.25em uppercase

### `<DisplayText />` — hero headline
- Inter 900, clamp(56px, 9vw, 144px), tight letter-spacing, two-line layouts with Signal-green accent on key word

### `<Lede />` — supporting paragraph
- Inter 300, clamp(18px, 2vw, 26px), max-width 740px, line-height 1.55, opacity 0.65

### `<PullQuote />` — editorial moments
- Fraunces 400, clamp(24px, 3.5vw, 42px), italic optional, decorative left rule, Signal-green key word

### `<Pillar />` — the gradient bordered block (from v1.1 deck)
- Background: linear-gradient(135deg, signal-dim 0%, near-transparent 100%)
- Border: signal-line 1px
- Top-right radial Signal glow (subtle)
- 1-2 per page max — overuse cheapens it

### `<CTAPrimary />` — the apply button
- Background: Signal green
- Color: Void
- Padding: 22px 56px
- Border-radius: 100px (pill)
- Hover: translateY(-1px), brightness shift
- Font: Inter 700, 16px

### `<CTASecondary />` — supporting links
- Background: transparent, 1px output-12 border
- Color: output-30 → output-65 on hover
- Font: JetBrains Mono 13px, letter-spacing 0.05em
- Prefixed with `>_ `

### `<NavMinimal />` — the top navigation
- Fixed, 72px tall, backdrop-blur(20px), bg rgba(10,10,10,0.7), border-bottom output-12
- Left: Mark + wordmark (links home)
- Right: links to /thinking, /the-operating-system, /about, /apply (apply is CTAPrimary-style)

### `<FooterMinimal />` — the footer
- 60px height, single line: PRAGMA. mark, "A Hartley Capital company", prag-ma.ai, year. Nothing else.

### `<SchemaJSON />` — invisible per-page JSON-LD
- Inserted in `<head>`, page-type appropriate

---

## Build manifest (this turn)

Files this turn delivers:

```
website-v2/
├── 00-ARCHITECTURE.md                    [this file — the C-suite brief]
├── index.html                            [home v2.0 — spectacular]
├── apply/index.html                      [application questionnaire]
├── thinking/index.html                   [blog index]
├── thinking/most-ai-projects-end-in-a-report/index.html  [first post template]
├── about/index.html                      [Bobby / HC / thesis]
├── the-operating-system/index.html       [Frontier Firm OS deep dive]
├── robots.txt                            [crawler directives]
├── sitemap.xml                           [SEO sitemap]
├── llms.txt                              [GEO directives]
└── 99-DEPLOY-NOTES.md                    [how to ship to DreamHost]
```

After Bobby reviews — Vector iterates on motion, brand-review re-runs against copy, content-creation drafts next two pillar posts.

---

## What "spectacular and beyond Centurion" means in execution

Centurion-grade is the floor. Beyond it means:
1. **Every detail is on-brand.** The favicon. The 404 page. The cursor on hover. The mailto subject line. The form's loading-state copy. The font of the byline. All designed.
2. **The user moves through the site as if entering rooms in a museum, not browsing tabs.** Each section earns its own moment. No tabs, no carousels, no accordions hiding content.
3. **The brand teaches itself.** A first-time visitor leaves with: the vocabulary ("Frontier Firm OS"), the wedge ("built on the operator"), the verbal posture ("we don't write the plan, we run it"), the institutional anchor (HBS / Microsoft / Lakhani). Even if they never apply.
4. **Restraint over excess.** Every page is shorter than the version PRAGMA was tempted to build. The cuts are the design.
5. **The application is the prize.** The form isn't a hurdle to clear; it's the proof you're being taken seriously. Bobby reads each one personally, and the form's design says so.

That's the floor and the ceiling. Building now.
