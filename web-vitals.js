/* PRAGMA — Web Vitals harness
 * Vanilla JS · no external library · no cookies · no third-party
 * Captures LCP / CLS / INP / TTFB · logs to console + sessionStorage
 * Plausible /api/event stub ready for when account exists
 * Inline-safe; works without bundler or framework
 */
(function () {
  if (typeof window === 'undefined' || typeof PerformanceObserver === 'undefined') return;

  var vitals = {};
  var session = (function () {
    try {
      return JSON.parse(sessionStorage.getItem('pragma_vitals') || '{}');
    } catch (e) { return {}; }
  })();

  function report(name, value, id) {
    var rounded = Math.round(value * 100) / 100;
    vitals[name] = { value: rounded, id: id || '', ts: Date.now() };
    session[name] = vitals[name];
    try { sessionStorage.setItem('pragma_vitals', JSON.stringify(session)); } catch (e) {}
    if (window.console && console.info) {
      console.info('%c[web-vitals] ' + name + ': ' + rounded, 'color:#1FE07E;font-family:monospace');
    }
    // Plausible hook — uncomment when account exists + script.js loaded
    // if (typeof window.plausible === 'function') {
    //   window.plausible('Web Vitals', { props: { metric: name, value: Math.round(value), page: location.pathname } });
    // }
  }

  // LCP — Largest Contentful Paint
  try {
    new PerformanceObserver(function (list) {
      var entries = list.getEntries();
      var last = entries[entries.length - 1];
      report('LCP', last.startTime, last.id || (last.element && last.element.tagName));
    }).observe({ type: 'largest-contentful-paint', buffered: true });
  } catch (e) {}

  // CLS — Cumulative Layout Shift
  try {
    var clsValue = 0;
    var clsSession = [];
    new PerformanceObserver(function (list) {
      list.getEntries().forEach(function (entry) {
        if (!entry.hadRecentInput) {
          var firstSessionEntry = clsSession[0];
          var lastSessionEntry = clsSession[clsSession.length - 1];
          if (clsSession.length && entry.startTime - lastSessionEntry.startTime < 1000 && entry.startTime - firstSessionEntry.startTime < 5000) {
            clsSession.push(entry);
          } else {
            clsSession = [entry];
          }
          var sessionValue = clsSession.reduce(function (sum, e) { return sum + e.value; }, 0);
          if (sessionValue > clsValue) {
            clsValue = sessionValue;
            report('CLS', clsValue, '');
          }
        }
      });
    }).observe({ type: 'layout-shift', buffered: true });
  } catch (e) {}

  // INP — Interaction to Next Paint
  try {
    var maxInp = 0;
    new PerformanceObserver(function (list) {
      list.getEntries().forEach(function (entry) {
        if (entry.interactionId && entry.duration > maxInp) {
          maxInp = entry.duration;
          report('INP', entry.duration, String(entry.interactionId));
        }
      });
    }).observe({ type: 'event', buffered: true, durationThreshold: 16 });
  } catch (e) {}

  // TTFB — Time to First Byte
  try {
    var nav = performance.getEntriesByType('navigation')[0];
    if (nav) report('TTFB', nav.responseStart - nav.requestStart, '');
  } catch (e) {}

  // Expose for ad-hoc inspection
  window.pragmaVitals = function () { return vitals; };
})();
