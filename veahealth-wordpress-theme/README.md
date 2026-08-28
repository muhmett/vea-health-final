# VeaHealth Turkey — WordPress theme

A complete theme for veahealthturkey.com. Upload the ZIP, activate it, press one
button, and the site is there: 21 treatment pages with the full long-form
content, the company pages, the legal pages, the menus and the homepage.

No page builder, no extra plugins, no external services at runtime.

---

## Install

1. **Back up first.** hPanel → Files → Backups. This changes your homepage
   setting, your permalinks and your menus.
2. **Appearance → Themes → Add New → Upload Theme**, choose
   `veahealth-wordpress-theme.zip`, **Install**, then **Activate**.
3. A blue notice appears at the top of the admin. Click **Open setup** — or go
   to **Appearance → VeaHealth setup**.
4. Press **Install the content**. It takes a few seconds.
5. Open the site. Everything is there.

Nothing already on your site is deleted. Pages are matched by slug: if one
already exists it is left alone unless you tick the overwrite box.

## Then set these four things

**Appearance → Customize → VeaHealth**

| Section | What to set |
|---|---|
| Contact details | Email, phone, WhatsApp number, street address |
| Social profiles | Your real Facebook / Instagram / YouTube URLs — these feed the `sameAs` in your structured data, so the placeholders are left empty on purpose |
| Enquiries | The mailbox that should receive new enquiries |
| Analytics | Your Google tag ID, if you use one |

Then **send yourself a test enquiry** from the Free assessment page and check it
lands under **Enquiries** in the admin.

---

## What you get

### Treatments — a proper post type

**Treatments** in the admin sidebar. 21 of them, grouped into Oral surgery &
implants, Crowns & veneers, and Hair restoration. Each one is an ordinary
WordPress post you can edit, reorder, or unpublish. URLs stay at
`/services/<slug>/`, exactly as before, so no inbound link or ranking is lost.

Five of them — Manual FUE, OxyCure, Beard & Mustache, Eyebrow Restoration,
Female Hair Transplant — are new. They were in your old menu, but the menu items
had the *label* typed into the URL field (`http://OxyCure`), so there was never
a page behind them. **Have your clinical partner read these five before you
publish**, and replace “price on request” with your real figures.

### Enquiries — leads that cannot get lost

The old form had no `action`, no backend and no email or phone field. It opened
WhatsApp and nothing else, so any visitor who did not complete that hand-off
vanished with no way to follow up.

Now: three validated steps, **email and phone required**, and every submission
is **saved as a post before any email is attempted**. Open **Enquiries** and you
see name, email, phone, country, treatments and timing in the list itself. The
menu shows a badge for anything you have not opened. WhatsApp still opens
afterwards — as a second channel, not the only one.

If your host blocks `wp_mail()` the lead is still recorded; the enquiry shows
`mailed: no` so you know to install an SMTP plugin.

### Cookie consent that actually blocks

No Google tag is loaded until a visitor presses “Accept analytics”. Not
deferred, not queued — not loaded. Privacy policy, cookie policy and terms of
use are created for you; your old site had none of the three while Google Tag
Manager ran unconditionally.

### Structured data

Organization + MedicalBusiness with your address and opening hours,
MedicalWebPage, MedicalProcedure per treatment, FAQPage generated from each
page's own questions, BreadcrumbList, Article on posts. Open Graph and a single
correct canonical on every page.

Your old site had eleven pages carrying a **second** canonical inside the page
body — two of them pointing at `veahealth.com`, a live domain you do not own.
That is what was telling Google those treatment pages belonged somewhere else.

### Security

- The REST users endpoint, `?author=1` and author archives no longer expose the
  administrator username. Yours was public as `wildness08gmail-com`.
- XML-RPC off, WordPress version hidden, security headers sent.
- 301 redirects from every old URL: `/service/`, `/about-us/`, `/contact-us/`,
  `/the-journey/`, `/portail/`, `/home/`, `/services_category/…` and the two
  mis-cased treatment slugs.

---

## Editing

| What | Where |
|---|---|
| Treatment copy, prices, FAQs | Treatments → edit |
| The order treatments appear in | Treatments → Quick Edit → Order |
| Which group a treatment is in | Treatments → edit → Groups |
| Card image for a treatment | Set a Featured image; otherwise the supplied artwork is used |
| Homepage headline and intro | Customize → VeaHealth → Homepage hero |
| Homepage background image | Customize → VeaHealth → Homepage hero |
| Legal pages, About | Pages → edit |
| Articles | Posts |
| Menus | Appearance → Menus |
| Logo | Customize → Site Identity |

The Home, Before & after, Clinic, The journey and Free assessment pages are
laid out by templates rather than the editor, because their sections
(comparison sliders, the video, the step timeline, the multi-step form) are not
things a text editor can hold. Their text lives in the templates and in the
Customizer. Everything else is ordinary editable content.

---

## Verified

Tested on WordPress 7.1 with PHP 8.4 before shipping:

- 35 pages render, 0 PHP notices, 0 JavaScript errors, 0 failed requests
- **0 accessibility violations** (axe-core, WCAG 2.1 AA, 11 pages × light and dark)
- Enquiry form: validation, storage, admin listing and the WhatsApp hand-off all
  exercised end to end
- Admin screens — setup, treatments, enquiries, customizer, menus — all clean
- Permalinks rebuild themselves on activation, and again if anything wipes them

---

## Things worth your attention

**Patient photograph consent.** The before/after images are your real patients
and the pages say they are published with permission. Make sure you hold written
consent for web publication for each one.

**Prices** carried over from the old pages (£180 for a zirconium crown, and so
on). Confirm they are current.

**The two blog articles** were carried over as they were. Worth knowing: the one
titled “Are cosmetic dentistry operations age-restricted?” never actually
answers that question — the text is generic oral-hygiene advice. It is worth
rewriting.

**Claims not carried over.** “20 K+ happy patients”, “15+ partner clinics”,
“25+ board-certified surgeons” appeared on the old homepage. They are not on the
new one. If you can evidence them, add them back; if not, leaving them out is
the safer position for a medical advertiser.

**Your logo** had a “Let's Enhance.io” watermark baked into it on every page of
the old site. The theme ships a clean SVG mark instead. If you have the original
unwatermarked file, upload it under Customize → Site Identity.

---

## If something looks wrong

**Treatment pages 404** — Settings → Permalinks → Save Changes. The theme
rebuilds the rules on activation and heals them automatically, but saving that
screen forces it.

**No styling** — a caching plugin serving an old page. Purge the cache.

**Enquiry emails not arriving** — check an enquiry's `mailed` value. If it says
`no`, your host is blocking `wp_mail()`; install an SMTP plugin. The lead is
still saved either way.

**Fonts look wrong** — the theme serves its own fonts from
`assets/fonts/`. Nothing is fetched from Google, which is deliberate: the Google
Fonts CDN receives every visitor's IP address, and German courts have ruled that
a GDPR breach.
