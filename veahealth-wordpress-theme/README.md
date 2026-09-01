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

### Reading

A page of marketing sections and 1,500 words of prose are not the same design
problem, so articles get their own surface, type scale and behaviour. What
changed, and the measurements it was changed against:

| | Before | Now |
|---|---|---|
| Body size | 16.5px everywhere | 17px phone, 18px desktop |
| Line measure | ~93 characters | ~70 |
| Contrast, light | 6.3:1 | 7.8:1 |
| Contrast, dark | 9.2:1 | 8.7:1 |
| `h2` on a phone | 28.4px | 22.7px |

Two of those need explaining. The dark contrast went **down** on purpose:
maximum contrast is not maximum legibility, pure white on black measures 21:1
and glare bleeds into the letterforms over a long read. Both themes now sit
around 8-9:1, which is the comfortable band.

And the measure is capped at `54ch`, not the `68ch` the guidance suggests,
because `ch` is the width of the zero glyph and this face's zero is much
narrower than its average letter — 68ch measured out at 93 real characters a
line.

The article also sits on its own reading surface: a warm off-white rather than
pure white in light mode, a lifted ink rather than the near-black marketing
ground in dark mode.

**The short answer.** Every article opens with three lines giving the actual
answer, not a teaser. Somebody who reads only that box should leave knowing what
they came for — which is also the shape Google lifts for a featured snippet.

**On scroll.** A progress bar that measures the article rather than the page, so
it reaches 100% when you have read the last line rather than when the footer
arrives. A contents list that tracks the section you are in — a sticky rail
beside the text on a wide screen, a fold above it on a phone, closed there so it
never becomes the whole first screen. And each block lifting slightly as it
arrives, kept small on purpose: text that animates hard is text you have to wait
for. Reduced motion keeps the progress bar and the tracking, which are
wayfinding, and drops the reveal. With no JavaScript the contents is still a
working `<details>` fold and every word is on the page.

### HubSpot

Every enquiry the site takes is pushed into HubSpot: the person becomes a
contact, and the message, the treatments and the page they enquired from become
a note on their timeline. Optionally it also opens a deal, so leads land on a
pipeline board rather than only in the contact list.

**Connecting it.** Enquiries → HubSpot in the admin. In HubSpot go to Settings →
Integrations → Private Apps, create an app with the `crm.objects.contacts.read`,
`crm.objects.contacts.write` and (for deals) `crm.objects.deals.write` scopes,
copy the token, paste it in and press **Test the connection** — you get a yes or
no immediately rather than having to send a test enquiry.

Better still, put it in `wp-config.php` and leave the field blank:

```php
define( 'VEAHEALTH_HUBSPOT_TOKEN', 'pat-eu1-…' );
```

The constant wins over the setting, and a secret in a file outside the database
does not travel in every database backup.

**Assigning the leads.** The *Assign leads to* field takes a numeric HubSpot user
id (Settings → Users & Teams, open the user, take the number at the end of the
address bar) and puts it on every new contact and deal. An unassigned lead sits
in the list with nobody notified and nobody accountable, which on a lead pipeline
is close to not having one. The owner and the lead status are written when the
contact is created and never touched again: a returning enquirer whose status the
clinic has already moved to *In Progress* is not dropped back to *New*, and a
contact another rep owns is not reassigned by a second enquiry.

**Three rules the code holds to:**

- **The lead is never lost.** The enquiry is stored and emailed before HubSpot is
  contacted, and the push is queued rather than run inline — measured, a
  submission returns in 86 ms having made zero outbound calls. HubSpot being
  slow, rate-limited or down changes nothing the visitor sees.
- **The token is never printed.** Not in a log, not in an error, not in the
  admin. Transport errors are reduced to an error code before they are stored,
  because a raw error string is exactly the sort of thing that ends up in a log
  with a header in it.
- **Failures are visible and retryable.** The Enquiries list has a HubSpot column
  showing queued, retrying, failed or in-HubSpot with the reason, and a *Send
  again* link. Silent failure on a lead pipeline is worse than no integration.

Rate limits, 5xx and network errors are retried three times with a widening gap;
a validation error is recorded and left alone because it will not fix itself. A
returning enquirer is patched onto their existing contact rather than duplicated,
and a blank field never overwrites a value they gave last time.

**Privacy.** Sending an enquirer's details to HubSpot makes HubSpot a processor,
which has to be disclosed. While a token is configured the theme adds that
paragraph to the privacy policy automatically and removes it again if you
disconnect, so the policy never names a company you are not using.

### The hero clip

Scroll-scrubbed, which forces one constraint: every frame has to be a keyframe,
because scrubbing seeks to arbitrary points and a frame that depends on its
neighbours cannot be shown alone. All-intra is expensive, and the first cut
spent that budget on H.264 — which gave each frame about **9.7 KB** where a
clean 1280-wide intra frame wants four to eight times that. The footage was
never the problem; the encode was starving it.

Measured against the ungraded original, the same five frames each time:

| | size | SSIM |
|---|---|---|
| H.264 all-intra, 20 fps (was live) | 959 KB | 0.867 |
| H.264 all-intra, 12 fps, crf 23 | 2 982 KB | 0.969 |
| **AV1 all-intra, 12 fps, crf 34** | **1 313 KB** | **0.946** |
| AV1 all-intra, 12 fps, crf 38 | 988 KB | 0.931 |

AV1 reaches at 1.3 MB what H.264 needs 3 MB for — and at the *same* weight as
the old file it still scores 0.931. Twelve frames a second rather than twenty
is the other half of it: scrubbing follows the scroll, not a clock, so the
budget is better spent on fewer, better frames than on more, worse ones.

Modern browsers get AV1; Safari before 17 and older Android cannot decode it
and fall back to H.264. One file is fetched, never both.

### Phone alerts

HubSpot notifies, but only after the lead has synced, only through its own app,
and only to somebody logged in — and the first clinic to reply is usually the
one that gets the patient. So the site rings the coordinator directly: the
moment an enquiry is stored, a Telegram message lands on their phone with the
treatment, the country, the message, and the visitor's number already built
into a WhatsApp button. Replying is one tap; no login anywhere.

**Connecting it.** Enquiries → Phone alerts. Make a bot with @BotFather, paste
the token, have each coordinator press Start on the bot (or add it to a group),
press *Find the chats* to read the ids straight off the bot, save, then *Send a
test alert* — the phone should buzz. A `VEAHEALTH_TELEGRAM_TOKEN` constant in
`wp-config.php` overrides the stored one, same as the CRM token.

**Why it is not on WP-Cron.** The CRM push is queued, because a minute either
way costs nothing there. Here a minute is the entire feature, and cron on a
quiet site fires on the next page view. So the alert goes out on the tail of the
same request: the REST response is written, output buffers flushed,
`fastcgi_finish_request()` (or LiteSpeed's equivalent) closes the connection,
and only then is Telegram called. Measured end to end, the form returns in 53 ms
having made **zero** outbound calls, and both alerts are delivered ~600 ms later
with the visitor already looking at the thank-you.

A chat that has been delivered to is recorded, so a retry for one coordinator
never sends the same lead twice to another. Rate limits, 5xx and network drops
are retried; a blocked bot or a chat that does not exist is recorded and left
alone, because neither fixes itself. The Enquiries list carries an *Alert*
column with the reason and a *Send again* link.

**On the token.** Telegram authenticates in the request URL rather than a
header, which makes it far easier to leak through an error string than a bearer
token — a cURL failure will quote the whole URL back at you. Every message
stored or displayed goes through a scrubber that removes both the token and the
bot id first.

**Privacy.** Enquiry details reaching a Telegram chat makes Telegram a processor,
so the theme adds that paragraph to the privacy policy while alerts are
configured and removes it again if they are turned off — the same contract the
HubSpot disclosure follows.

### Four languages

English keeps the root; French, Arabic and Spanish sit behind `/fr/`, `/ar/`
and `/es/`. No plugin — the prefix is taken off the request before WordPress
parses it, so every permalink and rewrite the site already has resolves
unchanged, and a translated post is an ordinary post carrying its language and
a group id. No meta means English, which leaves every existing post correct
with no migration.

**The vocabulary is fixed before the prose.** `inc/glossary.php` holds the 44
clinical terms that carry the treatment pages. Arabic keeps two forms of each:
the word patients search for leads, the precise one is given beside it on first
use — write only غَرْسة سنّية and nobody finds the page, write only زراعة and it
reads as an advert. Nine entries carry a note, three of which correct this
market's usual wording rather than copying it (a graft is not a follicle; the
sapphire is the blade, not the graft; shock loss is always said to be
temporary).

**Interface strings** are compiled to `languages/*.mo`. Written by hand rather
than by msgfmt, which is not always on the box and is not needed for a format
this small. Arabic takes six plural forms, not two, so a plural entry there is
six strings — the difference between ٣ علاجات and ٣ علاج.

Of 434 translatable strings, 156 are admin-only and are never rendered in
another language: the locale filter returns the site's own locale inside
wp-admin. The 278 the visitor can actually see are what gets translated.

### The particle field

A drifting field that answers the pointer, takes momentum from the scroll, and
in the footer gathers into shapes from this business: a molar, an implant
fixture, a follicle, the Istanbul skyline, the brand mark. The shapes are five
SVG paths, rasterised and rejection-sampled so density follows area — which is
why a tooth root reads as solid and a minaret reads as thin, rather than every
outline coming out as wire.

**On the count.** The brief was a billion. A billion points is around a thousand
times what a browser can rasterise at sixty frames a second, so what is here is
the largest number that holds the frame budget on the device actually looking at
it, and every field thins itself automatically when it misses:

Counts are derived from the area being covered, not fixed — one point per ~55
CSS pixels for the ambient layer, one per ~22 for the swarm — and clamped:

| | Ambient ceiling | Swarm ceiling | Typical total | Measured |
|---|---|---|---|---|
| Desktop | 26,000 | 6,000 | ~20,000 | 57fps |
| Phone | 6,000 | 3,200 | ~9,000 | 61fps |

Density has to follow area or the effect destroys itself at the moment it
succeeds: a count sized for a footer-width canvas put roughly eight points on
every pixel of a 300px square, and once the shapes finished gathering the whole
square rendered as a solid teal block.

Those frame rates are on **software rendering** — SwiftShader, no GPU at all —
so they are a floor rather than a typical figure.

**On not covering the text**, which is the constraint that shaped the design.
Two separate layers, because one layer cannot be both dense and safe:

- The **ambient** layer is a whisper — one to two pixels, five to twenty per cent
  opacity — because it passes behind body copy. Every readable surface is also
  given an opaque background so nothing drifts under a sentence. Measured: with
  the field on versus off, 0.17% of pixels in a text-heavy region differ at all,
  mean change 0.03 of 255.
- The **footer swarm** is dense and bright, and it lives in a reserved square
  beside the links rather than across the whole footer. It used to settle its
  shapes directly on the Company column. Giving it a box makes the overlap
  impossible by construction instead of by tuning opacity until it looks
  survivable. Verified: zero footer text elements intersect the swarm.

The field removes itself entirely for reduced motion, for Save-Data and slow
connections, and it never starts without JavaScript — in which case the empty
stage collapses rather than holding a gap open.

### The footer

Short. The previous one listed all twenty-one treatments in a column; nobody
reads a link dump and Google has the sitemap. It now links the three treatment
groups, keeps the company and legal menus, and gives the recovered space to what
somebody at the bottom of a page actually wants — a way to reach a person, the
street address, and one clear call to action.

### Cache busting

Assets are versioned by their own modification time, not by the theme constant
alone. This is here because it cost a live site a day: the journal shipped with
new rules appended to `site.css`, the constant was not bumped, and every browser
and the host's page cache went on serving the previous stylesheet at the same
`?ver=`. The markup updated and the CSS did not, so a production site showed
unstyled tables and contents lists. The constant still identifies the release;
the mtime guarantees a changed file is a changed URL.

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
