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
3. **The content installs itself.** Activation writes the 21 treatments, the
   company and legal pages, the menus and the homepage setting, then rebuilds
   the permalinks. A green notice at the top of the admin tells you what was
   created.
4. Open the site. Everything is there.

Nothing already on your site is deleted. Pages are matched by slug: if one
already exists it is left alone unless you tick the overwrite box on
**Appearance → VeaHealth setup**.

> Earlier builds waited for you to find an **Install the content** button.
> If you never pressed it you got a header, a hero and a page of empty
> sections — which is exactly what happened. Activation now does it for you,
> and the setup screen is only there for re-running the import or overwriting
> pages on purpose.

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

### Treatment pages, rebuilt

Every treatment page on the old site had been pasted into the editor as a
complete HTML document — `<head>`, stylesheet and all. That is what was serving
Google duplicate titles and duplicate canonicals, two of which pointed at
somebody else's domain, and it is why the pages carried **384 KB of CSS across
sixteen files**, one per treatment, each styled slightly differently.

The words were worth keeping. The markup was not. All twenty-one treatments were
read back into structure and are now drawn by the theme's own components, from
**one 19 KB stylesheet** shared across all of them:

| Section | What it does |
|---|---|
| Hero | Headline, lead, four checked claims, and the price card |
| Key facts | Price, procedure type and the two figures that matter, scannable in three seconds |
| On this page | A contents rail that sticks beside you and marks the section you are reading — built from the sections that page actually has, not a fixed list |
| Why this treatment | The clinical case, numbered |
| How it compares | A real table on a desk; the same rows as cards on a phone, because a wide table in a horizontal scroller hides the comparison rather than showing it |
| The procedure | A timeline whose spine fills as you read down it |
| What it costs | Bars drawn to scale with the saving worked out, and a caveat saying the figures are indicative |
| Recovery | Week by week |
| The evidence | Published figures, each with its source |
| Questions | Built on `<details>`, so every answer opens without JavaScript and every answer is in the page for Google to read |
| Enquiry bar | Rises once the hero has gone; drops again at the closing call to action so it never covers the form it points at |

**Nothing here needs JavaScript.** The cost bars carry their widths in the
markup and are only collapsed for the animation when scripting is running; the
questions are `<details>`; the table is a table. With JavaScript off a treatment
page is still 1,495 words with the comparison intact.

**Editing still works.** The installer writes these sections into the post as
ordinary content, so what the theme renders and what you edit in the admin are
the same thing. Rewrite a paragraph and your words are what appears — nothing
reads the source data back to overrule you.

### The treatment room

Every treatment page has a second way in: **Enter the treatment** opens a lit
space with that treatment's own object suspended in it and notes pinned in the
air around it. Move the pointer and the light, the object and the notes all
shift by different amounts, which is what makes a still image read as depth.
Open a note and it tells you something real — the material and its numbers, the
step where the actual intervention happens, what it costs and against what, the
published figure and its source, what the first days afterwards are like.

All 21 treatments have one.

**The notes are not written separately.** They are read out of the same
structured data the page is built from, so a room can never drift out of step
with the page it belongs to, and editing a procedure step in the admin changes
what the room says about it.

Three decisions worth knowing, because they are what make this appropriate for
a medical site rather than a fashion campaign:

- **It is a layer, not a route.** The page underneath keeps its URL, its 1,500
  words and its structured data. Google sees the page; the room is something a
  visitor opens on purpose. An immersive experience that *replaced* the page
  would cost exactly the rankings the page exists to win.
- **It is clearly a diagram, not a photograph.** The space is drawn — a lit
  volume with the treatment's own render floating in it — and every room says so
  on screen. It never implies it is a photograph of the partner clinic, because
  somebody who flies to Istanbul on the strength of a room that does not exist
  has been misled.
- **There is no game.** No counter, no "three left to find", no reward for
  completing it. Sites that do that are selling something you can put back;
  somebody deciding whether to have their jaw operated on abroad is not playing.
  Every note is information and you can leave at any point.

**Weight and fallbacks.** `room.js` is 15 KB and draws four full-screen quads —
a volume, a light, the object, a grain pass — with no library at all. It also
watches its own frame rate and drops the render resolution rather than the frame
rate when it cannot keep up, because a room at 30 fps feels broken and one at
0.75 device pixels does not. If WebGL is unavailable the room still opens and
still reads, as a dark panel rather than a lit one. Under reduced motion the same
markup lays out as a plain scrollable list of notes with nothing animating. With
JavaScript off the room cannot open at all, so the button that opens it is not
shown — the treatment page is the no-script experience, and it is complete.

### Content that was written, not salvaged

Five hair pages arrived with almost nothing — a recovery table with the wrong
heading over it and a handful of questions, about 550 words each. They now carry
the same sections as the rest, and six dental pages that had no recovery
timeline have one.

Two rules held while writing it, and they are worth knowing about because they
constrain what the pages claim:

- **No invented prices.** Where the clinic has not given a figure the page says
  the price is quoted after assessment and gives no number.
- **No invented citations.** The evidence section is absent on pages with no
  published figures behind them rather than filled with plausible references.

The clinical descriptions are of standard technique and each of those pages says
so. **Have a partner clinician read them before you go live.**

### The journal — 20 articles

The blog was three posts, one of which was WordPress's own “Hello world!”, and
none of them were categorised. It now carries **20 articles, about 12,800
words**, written for the questions people actually type into Google before they
book treatment abroad.

| Category | Articles | What they cover |
|---|---|---|
| Costs and money | 4 | Itemised implant and graft pricing, why Turkey is cheaper, the costs quotes leave out |
| Safety and choosing a clinic | 4 | Verifying a clinic, health tourism authorisation, red flags, what happens if it goes wrong |
| Choosing a treatment | 5 (+2 carried over) | All-on-4 vs All-on-6, zirconia vs e.max, DHI vs Sapphire FUE, graft numbers, grafting decisions |
| Planning your trip | 4 | Days needed per treatment, flying after surgery, packing, Istanbul for patients |
| Recovery and aftercare | 3 | The first fortnight after a transplant, making implants last, realistic timelines |

**The architecture is deliberate.** Each article ends by linking to the
treatment pages it concerns: the article catches the search, the treatment page
converts it. Five articles aimed at competitive head terms run to 950–1,570
words; the rest answer long-tail questions in 400–560, which is the right length
for a question with one answer.

**Two things were not invented.** No prices beyond what the treatment pages
already quote, and no citations — where a claim would need a study behind it,
the article makes the weaker claim it can support instead.

### Where the article images came from

Four covers are CC0 photographs from Openverse, credited under each one in the
page. The other sixteen are built from the theme's own artwork.

That split is a finding, not a preference. A free-licence image search for
“dental clinic” returns 1946 railway archive photographs; one for “hair
transplant” returns another clinic's marketing photographs of their own named
surgeon. Of the ten searches run, six produced nothing usable and two produced
images of identifiable people at unrelated events. Those were discarded rather
than published.

Everything, both sources, goes through one grading pass — cooled towards the
brand teal, exposure normalised to a common target so a bright hotel room and a
near-black 3D render sit in the same tonal band, vignetted and lightly grained.
The result is that the archive reads as one publication rather than a folder of
found images. If you replace a cover, run it through the same grade or it will
stand out.

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


### Motion

The theme ships its own motion layer. Nothing is loaded from a CDN and nothing
is required for the site to work.

| Effect | Where |
|---|---|
| Scroll-scrubbed hero film | Homepage. A golden-hour push over the Bosphorus that does not autoplay — its playback position is your scroll position, and the thin rail at the bottom of the hero is how far through it you are |
| Line-by-line headline reveal | Every `h1`/`h2` marked `data-lines`, split on measured line breaks so it re-splits correctly when the text rewraps |
| Custom cursor | A ring that lags a dot and takes a label from whatever it is over. Mouse and wide screens only |
| Fullscreen menu | Wipes open, the eight links rise in sequence, and the panel on the right previews the section you are pointing at |
| Pinned horizontal journey | The four journey steps travel sideways while the page scrolls down |
| Velocity marquee | The trust strip speeds up and reverses with the scroll |
| Card hover, in WebGL | A treatment card's photograph bends toward the pointer with a faint chromatic split |
| WebGL menu preview | One preview picture displaces out of frame as the next displaces in |
| Page transitions | A dark veil wipes over on navigation |

**How it loads.** `assets/js/motion.js` is a 22 KB loader. It checks the visit
before it fetches anything, and only then pulls GSAP, ScrollTrigger and Lenis
from `assets/js/vendor/`. `assets/js/gl.js` comes last and separately.

**Who gets nothing, on purpose:**

- anyone whose system asks for **reduced motion** — no libraries are fetched at all
- anyone on a **phone or a touch screen** — no cursor, no WebGL, and the lighter
  video encode
- anyone on **Save-Data**, a 2G connection, or a device reporting under 4 GB of
  memory — no WebGL
- anyone with **JavaScript off** — the page is complete without it

Reveals, counters, the burger menu and the enquiry form all live in `site.js`,
never in `motion.js`. That is deliberate: if the motion layer fails to load,
nothing that matters can end up stuck at opacity zero.

**No Three.js.** The two WebGL effects are two full-screen quads with one
fragment shader each. Three.js would be 160 KB gzipped of scene graph, camera
and material system to draw them; `gl.js` is 14 KB and writes the WebGL calls
directly. On a site whose leads depend on how fast a treatment page opens, that
is worth the extra boilerplate.

**One shared context.** The card hover uses a single canvas that moves to
whichever card the pointer is over. Browsers cap live WebGL contexts — Chrome
drops the oldest past sixteen — and the treatments archive shows twenty-one
cards, so one canvas per card would start losing contexts as you scrolled.

### The hero film, if you ever re-encode it

The clip is seeked, not played, so **every frame has to be a keyframe** —
otherwise the browser decodes forward from the last keyframe on each scroll tick
and the film stutters:

```
ffmpeg -i source.mp4 -an -vf "scale=1280:-2,fps=20" \
       -c:v libx264 -crf 35 -g 1 -bf 0 -pix_fmt yuv420p \
       -movflags +faststart hero-scrub-1280.mp4
```

`-g 1 -bf 0` is the important part: one keyframe group, no B-frames. It also
means the file is close to a stack of stills, so **frame rate and duration cost
you linearly** — 20 fps over five seconds is 101 frames, and that is what keeps
the file under a megabyte. Keep the camera moving in one direction for the whole
clip; a scrub over footage that barely changes gives the visitor nothing back.

Three encodes ship: H.264 at 1280 px and 900 px, plus one VP9 file for the rare
browser build without proprietary codecs. VP9 is three times the size at
all-keyframe, so that fallback is the narrow encode whatever the screen.
`motion.js` picks exactly one and assigns it. There are deliberately **no
`<source>` children** on the element: with them the browser starts fetching
before the choice is made and the clip arrives twice — on the homepage that
meant 2.8 MB instead of 960 KB.

**The frames are painted into a `<canvas>`, not shown by the `<video>`.** A
paused, never-played, seek-only video is not something every browser composites:
the element can hold a perfectly good decoded frame — readable with `drawImage`
— and still paint as a black box. iOS Safari is the known case; it also showed
up in testing here. Copying each frame out with `drawImage` removes the question
entirely. The `<video>` stays in the page as a decoder and never becomes visible.

The still `<img>` underneath is the first frame of the film, and it is the
element search engines index and the one shown when the motion layer does not
run — so if you replace the film, replace
`assets/img/art/hero-istanbul-bosphorus-1600.webp` with its first frame too, or
the crossfade will jump.

Your host must answer HTTP `Range` requests for scrubbing to work. Apache and
LiteSpeed do; Hostinger is fine.

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
- **0 accessibility violations** (axe-core, WCAG 2.1 AA, 11 pages × light and dark,
  with the motion and WebGL layers running)
- Enquiry form: validation, storage, admin listing and the WhatsApp hand-off all
  exercised end to end
- Admin screens — setup, treatments, enquiries, customizer, menus — all clean
- Permalinks rebuild themselves on activation, and again if anything wipes them
- Content installs on activation, verified against a clean WordPress install
- The three degraded paths, each checked in a real browser:
  - **Reduced motion** — 0 bytes of GSAP, Lenis or WebGL fetched, every element
    visible, the burger menu opens and navigates
  - **No JavaScript** — 1,099 words and 123 working links on the homepage,
    headline intact
  - **Phone** — the 310 KB video encode, no custom cursor, no WebGL
- One hover canvas at most across a 21-card archive: no context thrashing
- All 21 treatment pages: one `h1` each, every image with alt text, no old
  markup left, no JavaScript errors, 1,141–1,730 words each
- The room: 0 axe violations with it open and every note expanded, 3 treatments
  × light and dark; opens and reads with WebGL unavailable; hidden entirely
  when JavaScript is off
- All 22 articles: one `h1` each, cover loaded, category assigned, Article
  schema carrying an image, and internal links resolved — no unexpanded tokens
- Sitemap: 59 URLs across posts, pages, treatments and both taxonomies

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
