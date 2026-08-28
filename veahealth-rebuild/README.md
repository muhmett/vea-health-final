# VeaHealth Turkey — rebuilt site

A static rebuild of veahealthturkey.com. Every page is plain HTML, CSS and
vanilla JavaScript: no WordPress, no plugins, no build step needed to deploy,
and no third-party requests at runtime.

```
dist/                the site — this is what you upload
  index.html         home
  services/          21 treatment pages
  before-after/      patient results with a drag-to-compare slider
  gallery/  journey/  about/  contact/  blog/
  privacy-policy/  cookie-policy/  terms/
  404.html
  assets/            css · js · img · video · fonts
  send.php           enquiry handler (see step 3)
  .htaccess          redirects, security headers, caching
  sitemap.xml  robots.txt

src/                 the generator, if you ever want to rebuild
  build.py           run: python3 src/build.py   → rewrites dist/
  site_data.py       contact details, treatment list, patient results
  pages.py           home, about, contact, journey, gallery, blog, legal
  new_services.py    the five treatment pages written from scratch
  extract.py         salvages the long-form content from the old pages
  layout.py          shared <head>, header, footer, structured data
```

---

## 1. Deploy

Upload **everything inside `dist/`** to `public_html/` on Hostinger. That is
the whole deployment — there is nothing to install and nothing to configure.

Keep `.htaccess`: it forces HTTPS, strips `www.`, 301-redirects every old
WordPress URL to its new home, sets the security headers, and caches assets
for a year.

> **Before you upload, decide what happens to WordPress.** The current site is
> WordPress on Hostinger. Take a full backup first (hPanel → Files → Backups).
> If you want to keep WordPress reachable while you check the new site, upload
> to a subfolder or a staging subdomain and move it across once you are happy.
> The `.htaccess` returns `410 Gone` for `/wp-admin`, `/wp-json`, `/wp-login.php`
> and friends — that is deliberate, and it closes the username-enumeration hole
> the old site had.

## 2. Set your Google Analytics ID

Open `src/site_data.py`, put your ID in `ga_id`, and run `python3 src/build.py`.

```python
"ga_id": "G-XXXXXXXXXX",
```

Leave it empty and no analytics loads at all. Either way **nothing loads before
the visitor accepts cookies** — the tag is injected by `assets/js/site.js` only
after consent, which is what the GDPR requires.

## 3. Point the enquiry form at a real mailbox

`dist/send.php` receives the form. Open it and set:

```php
$TO   = 'info@veahealthturkey.com';      // where enquiries arrive
$FROM = 'website@veahealthturkey.com';   // must be on this domain
$LOG  = __DIR__ . '/../enquiries.csv';   // keep this OUTSIDE public_html
```

Every enquiry is written to the CSV **before** the email is attempted, so a
lead is never lost if mail delivery fails. Send yourself a test enquiry and
confirm both the email and the CSV row before you go live.

Prefer a hosted form service? Put its URL in `form_endpoint` in
`src/site_data.py` and rebuild — the form posts JSON, which Formspree, Basin
and Web3Forms all accept.

## 4. Tell Google about the move

1. Search Console → **Sitemaps** → submit `https://veahealthturkey.com/sitemap.xml`
2. Search Console → **Removals** is not needed; the 301s in `.htaccess` handle it
3. Use **URL Inspection → Request indexing** on the homepage and on
   `/services/` — the rest follows from the sitemap

Expect two to six weeks for the treatment pages to re-rank. The titles that
Google will now read are the ones that were written months ago and never
reached the `<head>`, so this is where most of the gain is.

---

## What was fixed

Every finding from the audit, plus what turned up during the rebuild.

| # | Old site | Now |
|---|---|---|
| 1 | 11 pages carried a second `<canonical>`, two pointing at `veahealth.com` — a domain you do not own | One canonical per page, all correct |
| 2 | 17 optimised SEO titles were pasted into the page body, invisible to Google | All 17 now in the real `<head>` |
| 3 | Contact form saved nothing; no email or phone field; WhatsApp only | Validated 3-step form, email + phone required, writes to CSV, emails you, then offers WhatsApp |
| 4 | No privacy policy, terms or cookie page; GTM loading without consent | All three published; no tag loads before consent |
| 5 | 5 menu items pointed at `http://OxyCure` and similar; `/home/` was a 404 | Menu rebuilt; the 5 missing treatments now have full pages |
| 6 | No `<h1>` on 20 of 32 pages | Exactly one `<h1>` on every page |
| 7 | Homepage was configured as a blog feed | Purpose-built homepage |
| 8 | No Organization / MedicalClinic schema; no reviews or FAQ markup | Full graph: Organization + MedicalBusiness, MedicalWebPage, MedicalProcedure, FAQPage, BreadcrumbList |
| 9 | 26 of 26 gallery images had no `alt` | Every image on the site has descriptive alt text |
| 10 | `/portail/`, `/the-journey/`, `/service/` vs `/services/`, indexed author archive | Merged or removed, all 301-redirected |
| 11 | “Working Hours” block repeated 4×; “Premium Materiels” typo | Gone |
| 12 | 197 kB of CSS inline in 214 `<style>` blocks on the homepage | One cached stylesheet plus one small per-treatment sheet |
| 13 | 1.5 MB and 1.3 MB PNGs; 157 kB logo | All imagery WebP; logo is now a 1.3 kB SVG |
| 14 | JavaScript lazy-load applied even to the logo and hero image | Native lazy loading; hero preloaded with `fetchpriority` |
| 15 | TTFB 0.42–0.75 s even on a cache hit | Static files; LCP measured at 0.17–0.60 s |
| 16 | `WhatsApp-Image-2026-02-14-at-16.52.48.jpeg`, `dd.jpeg`, `330.png` | Descriptive, keyword-bearing filenames |
| 17 | `/wp-json/wp/v2/users` exposed the admin username `wildness08gmail-com` | No WordPress surface at all; those paths return 410 |
| 18 | No HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy or CSP | All set in `.htaccess`, including a CSP |
| 19 | `readme.html` published the exact WordPress version | Gone |

### Also found and fixed during the rebuild

- **The logo had a “Let's Enhance.io” watermark baked into it**, on every page
  of the live site. Replaced with a clean SVG.
- **Google Fonts was loaded from Google's CDN.** That sends every visitor's IP
  address to Google, which German courts have ruled a GDPR breach. The fonts
  are now served from your own domain (213 kB, Latin + Latin Extended only, so
  Turkish characters render).
- **Body text on the treatment pages was 3.65:1** against white, below the
  4.5:1 WCAG requires. Raised, along with the accent teal, the WhatsApp green
  and the muted greys.
- **Heading levels skipped steps** (`h2` → `h4`) on several treatment pages.
  Normalised.
- **Two treatment pages linked to `/contact-us/` and one to `www.`**, both
  costing a redirect hop. Rewritten to the live paths.

### Verified

- 35 pages, 54 internal links, **0 broken**
- **0 accessibility violations** (axe-core, WCAG 2.1 AA, 11 pages × light and dark)
- **0 console errors, 0 failed requests**
- LCP 0.17–0.60 s · CLS 0.0000–0.0004 · 8–16 requests per page
- Works with JavaScript disabled: all content readable, all links functional

---

## Things you should look at

**Patient photograph consent.** The before/after images are your real patients.
Make sure you hold written consent for web publication for each one. The pages
say the photographs are published with permission — that needs to be true.

**The five new treatment pages** (Manual FUE, OxyCure, Beard & Mustache,
Eyebrow Restoration, Female Hair Transplant) are written from general clinical
knowledge because the old site had no content for them. **Have your clinical
partner read them before they go live**, and replace “price on request” with
your real figures. Nothing in them is invented about your clinic specifically —
that is exactly why the prices are left open.

**Social links** in `src/site_data.py` currently point at the bare
facebook.com / instagram.com / youtube.com domains. Put your real profile URLs
in and rebuild, so the `sameAs` in your structured data is correct.

**Prices** carried over from the old pages (£180 for a zirconium crown, and so
on). Confirm they are current before publishing.

**The old site's own claims** — “20 K+ happy patients”, “15+ partner clinics”,
“25+ board-certified surgeons” — were not carried over onto the new homepage.
If you can evidence them, they are worth adding back. If not, leaving them out
is the safer position for a medical advertiser.

---

## Rebuilding

```bash
python3 src/build.py     # needs only the standard library
```

`dist/assets/` is left untouched between builds — the generator rewrites HTML,
the sitemap, `robots.txt`, `.htaccess` and `send.php` only. Edit copy in
`src/pages.py` and `src/site_data.py`; the long-form treatment content is
salvaged from the saved pages in `../pages/` at build time.
