# Deploy 2026-05-22 — Install/Build offering restructure

## What changed

Two files updated to reflect the new product structure (PRAGMA Operator OS as the underlying product, sold via PRAGMA Install for SMB and PRAGMA Build for Enterprise):

| File | Change |
|---|---|
| `index.html` | Home page hero lede now introduces **PRAGMA Operator OS** by name. Adds "You own the OS at handoff" closing line. |
| `offerings/index.html` | New section **"How the work gets to you"** between the deliverables and the "never receive" block. Introduces PRAGMA Install (3 tiers) and PRAGMA Build (enterprise, by inquiry). Install 1 published at **"Starting at $7,500"** as a qualifying filter. Install 2/3 + Build pricing kept opaque. Meta description + keywords updated. Adds PRAGMA On-Call mention for post-handoff support. |

No new pages created. No nav changes. No URL changes. Existing links unchanged.

## Why these specific edits

Per [[project_pragma_install_build_product_structure]] (memory captured this morning):
- Bobby's call: PRAGMA Operator OS becomes the front-door product narrative
- Install track productizes the SMB engagement; Build track preserves enterprise bespoke work
- Pricing opacity intentional — except the $7,500 published floor on Install 1, which serves as a qualifying filter (eliminates prospects looking for sub-$500 SaaS subs, anchors qualified prospects at the right expectation level)
- Full pricing publication deferred to Day ~90 after 3-5 case studies validate unit economics

## How to deploy

The DreamHost File Manager tab in Bobby's Chrome (us-east-files.dreamhost.com) should already be open from prior PRAGMA deploys.

**Files to upload:**

1. `/Users/alfredpennyworth/Documents/Claude/Projects/Harvard Skills - Content/pragma-launch/website-v2/index.html` → `/prag-ma.ai/index.html` (overwrite)
2. `/Users/alfredpennyworth/Documents/Claude/Projects/Harvard Skills - Content/pragma-launch/website-v2/offerings/index.html` → `/prag-ma.ai/offerings/index.html` (overwrite)

After upload:
- Visit https://prag-ma.ai/ — verify hero lede says "PRAGMA Operator OS" and "You own the OS at handoff"
- Visit https://prag-ma.ai/offerings/ — scroll to "How the work gets to you" section, verify Install 1 / 2 / 3 + Build blocks render with $7,500 floor on Install 1

No cache to purge (DreamHost shared, no Sucuri-style WAF).

## Rollback

The pre-change versions are still in Git history. If anything looks wrong, the rollback is:

```bash
cd ~/Documents/Claude/Projects/Harvard\ Skills\ -\ Content/pragma-launch/website-v2
git log --oneline | head -5      # find the pre-2026-05-22 commit
git checkout <pre-commit-hash> -- index.html offerings/index.html
# re-upload to DreamHost
```

## Verification checklist

- [ ] Home page hero shows "PRAGMA Operator OS" in bold
- [ ] Home page hero closes with "You own the OS at handoff"
- [ ] Offerings page shows new "How the work gets to you" H2
- [ ] PRAGMA Install block describes "OS install + ownership at handoff"
- [ ] Install 1 block shows "Starting at $7,500" in deliverable-tag
- [ ] Install 2 + Install 3 show "Custom — by discovery"
- [ ] PRAGMA Build block shows "By inquiry" + $150K-$500K+ indicative range
- [ ] Callout about PRAGMA On-Call appears after the Build block
- [ ] No broken layouts on mobile (test at 720px breakpoint)

## What didn't change (deliberately)

- /how-it-works/ page — still works as the SMB-plain-English Operator explainer
- /the-operating-system/ page — still the OS deep-dive (supports the new product narrative)
- /trust/ page — security/data section unchanged
- /thinking/ blog — content stack unchanged
- /apply/ form — Formspree integration unchanged
- Top nav — no new items (the new product fits inside /offerings/)
- /about/ — no edits

The site narrative still leads with operator-first, experience-as-a-service, and the 8-Operator stack. The Install/Build framing slots in as the engagement-type layer below the brand promise — not above it.
