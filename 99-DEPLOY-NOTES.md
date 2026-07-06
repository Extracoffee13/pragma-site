# PRAGMA Website v2.0 — Deployment Manifest

**Built:** 2026-05-19
**Domain:** prag-ma.ai (registered on DreamHost, pending provisioning ~15 min)
**Stack:** Pure static HTML — no WordPress, no CMS, no DB. Path A locked.

---

## Files in this build

```
website-v2/
├── 00-ARCHITECTURE.md                                      C-suite brief
├── 99-DEPLOY-NOTES.md                                      this file
│
├── index.html                                              HOME (spectacular)
├── apply/index.html                                        APPLICATION questionnaire
├── about/index.html                                        ABOUT (Bobby, HC, thesis)
├── the-operating-system/index.html                         OS deep-dive (SEO/GEO crown jewel)
│
├── thinking/index.html                                     BLOG index
├── thinking/most-ai-projects-end-in-a-report/index.html    First post (thesis pillar)
│
├── robots.txt                                              Crawler directives (allow GPTBot, ClaudeBot, PerplexityBot, Google-Extended)
├── sitemap.xml                                             SEO sitemap
└── llms.txt                                                GEO directives (AI-crawler standard)
```

All files self-contained — every page has its own inline CSS and embedded SVG mark. Zero external dependencies except Google Fonts (Inter, Fraunces, JetBrains Mono).

---

## Pre-deploy: one swap Bobby must make

The application form has a placeholder Formspree URL. Before deploying `/apply/index.html`:

1. Sign up free at https://formspree.io (50 submissions/month — sufficient for inbound-only)
2. Create a form — set notifications to robert@prag-ma.ai
3. Formspree gives you a form ID like `xrgvabcd`
4. In `apply/index.html`, find this line:
   ```
   <form id="applicationForm" action="https://formspree.io/f/YOUR_FORMSPREE_ID" method="POST" novalidate>
   ```
5. Replace `YOUR_FORMSPREE_ID` with your actual ID
6. Test with a fake submission — confirm email arrives

Total time: 10 minutes.

If you'd rather use a different backend (Basin, Web3Forms, DreamHost's own form handler) — same swap, different URL.

---

## Deploy steps (once prag-ma.ai DNS provisions)

1. **DreamHost panel → Domains → Manage Domains → Add Hosting** for prag-ma.ai. Assign your existing hosting plan.

2. **DreamHost panel → Files → File Manager.** Navigate to the web root for prag-ma.ai (typically `/home/youruser/prag-ma.ai/`).

3. **Upload all files from `website-v2/`** preserving the folder structure:
   - `index.html` → web root
   - `apply/index.html` → web-root/apply/
   - `about/index.html` → web-root/about/
   - `the-operating-system/index.html` → web-root/the-operating-system/
   - `thinking/index.html` → web-root/thinking/
   - `thinking/most-ai-projects-end-in-a-report/index.html` → web-root/thinking/most-ai-projects-end-in-a-report/
   - `robots.txt` → web root
   - `sitemap.xml` → web root
   - `llms.txt` → web root
   - **Do NOT upload** `00-ARCHITECTURE.md` or `99-DEPLOY-NOTES.md` — those are internal docs.

4. **Enable Force HTTPS.** DreamHost panel → Domains → Manage → Secure Hosting for prag-ma.ai. Let's Encrypt auto-provisions in 5-15 min.

5. **QA pass** (open in incognito):
   - https://prag-ma.ai loads
   - https://prag-ma.ai/apply/ loads, form fields focus correctly, validation triggers on submit with empty fields
   - https://prag-ma.ai/about/ loads
   - https://prag-ma.ai/the-operating-system/ loads
   - https://prag-ma.ai/thinking/ loads
   - https://prag-ma.ai/thinking/most-ai-projects-end-in-a-report/ loads
   - https://prag-ma.ai/robots.txt returns the txt
   - https://prag-ma.ai/sitemap.xml returns the XML
   - https://prag-ma.ai/llms.txt returns the txt
   - Mobile rendering passes on iPhone
   - Favicon renders in browser tab

6. **Submit sitemap to Google Search Console** at https://search.google.com/search-console — verify ownership via DNS TXT record or HTML file, then submit `https://prag-ma.ai/sitemap.xml`.

7. **Submit to Bing Webmaster Tools** at https://www.bing.com/webmasters — same submit flow, same sitemap URL.

---

## Post-deploy expectations

- **Day 0–2:** Google starts crawling. Sitemap submitted. Pages indexed within a week typically.
- **Day 7–14:** First branded searches ("PRAGMA AI") return the site in top results.
- **Month 1–2:** Long-tail keyword rankings begin ("Frontier Firm Operating System", "AI deployment SMB"). AI search engines (ChatGPT, Claude, Perplexity) start citing the OS deep-dive page.
- **Month 3–6:** First inbound applications from organic search + AI-search citation. Track via Formspree submissions tagged by "How did you hear about PRAGMA?".

---

## Update workflow (for blog posts going forward)

When you want a new post on `/thinking/`:

1. Decide the post topic (pillar 1-5 per `09-social-media-strategy.md`)
2. Brief me in chat (key arguments, citations to include, target length)
3. I draft the post in PRAGMA voice using the template from the first post
4. You review, edit, approve
5. I generate `/thinking/[slug]/index.html` matching the brand template
6. I update `sitemap.xml` with the new URL
7. You upload both files to DreamHost
8. Cross-post on LinkedIn personal + PRAGMA company page per the social strategy

~5 minutes of your time per post once it's drafted.

---

## What this build deliberately doesn't include

- No `/pricing` page (Centurion doesn't publish; the application asks budget range)
- No `/contact` page (only `/apply` — the relationship is application, not contact)
- No cookie banner (no tracking installed; nothing to disclose)
- No newsletter modal (inbound-only positioning)
- No live chat widget (contra-positioning)
- No client logo wall (no closed clients yet — won't fake it)
- No "as featured in" press wall (no press yet)
- No JavaScript frameworks (vanilla JS only, sub-200 lines total)
- No build step (write HTML, upload HTML)
- No analytics by default (recommend adding Plausible — privacy-respecting, no cookie banner needed — once first traffic shows up)

---

## What ships next (after Bobby reviews)

In priority order, as the work demands:

1. **Brand-aligned OG image** — currently the OG description loads; a 1200×630 image with the wordmark + tagline strengthens link sharing. Vector renders.
2. **Two more blog posts** to seed the `/thinking/` index — Pillar 1 (operator proof) and Pillar 2 (research synthesis on Lakhani).
3. **404 page** — branded "not found" page (currently DreamHost default).
4. **Plausible Analytics** integration (privacy-first, no cookie banner, one script tag).
5. **The thank-you page** at `/apply/received/` — currently the form redirects to a Formspree default; needs a branded confirmation page.
6. **Vector's motion identity** assets — the three video clips per the brand deck v1.1 (cursor pulse, convergence build, terminal compile).

---

## Cross-references

- [Brand deck v1.1](../pragma-brand-deck-v1.1.html) — the visual + verbal source of truth
- [Architecture brief](00-ARCHITECTURE.md) — the C-suite huddle output that drove this build
- [LinkedIn rework](../08-linkedin-rework.md) — companion launch package
- [Social strategy](../09-social-media-strategy.md) — content cadence and pillars
- [DreamHost playbook](../10-dreamhost-deployment-playbook.md) — domain + DNS + email setup steps
