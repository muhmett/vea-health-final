# -*- coding: utf-8 -*-
"""Body markup for every non-treatment page."""

from layout import esc, icon, SITE, url
from site_data import SERVICES, GROUP_ORDER, RESULTS, CLINIC, JOURNEY, TRUST, POSTS


def svc_title(s):
    return s.get("nav_title") or s["slug"].replace("-", " ").title()


# --------------------------------------------------------------------------
# reusable fragments
# --------------------------------------------------------------------------
def crumbs_html(items):
    out = []
    for label, href in items:
        out.append('<li><a href="%s">%s</a></li>' % (href, esc(label)) if href
                   else '<li><span aria-current="page">%s</span></li>' % esc(label))
    return '<nav aria-label="Breadcrumb"><ol class="crumbs">%s</ol></nav>' % "".join(out)


def page_hero(eyebrow, h1, lede, crumbs=None):
    return """
<section class="page-hero">
  <div class="shell">
    %s
    <p class="eyebrow" data-anim="fade">%s</p>
    <h1 data-anim="up">%s</h1>
    <p class="lede" data-anim="up" style="--d:90ms">%s</p>
  </div>
</section>
""" % (crumbs_html(crumbs) if crumbs else "", esc(eyebrow), h1, lede)


def ba_block(r, idx, sizes="(min-width: 900px) 50vw, 100vw"):
    """One before/after comparison figure built on a range input."""
    base = "/assets/img/results/" + r["img"]
    return """
<figure data-anim="up">
  <div class="ba" role="group" aria-label="Before and after: %s">
    <img class="ba-img" src="%s-900.webp" srcset="%s-500.webp 500w, %s-900.webp 900w, %s.webp 1600w"
         sizes="%s" alt="%s" loading="lazy" decoding="async">
    <div class="ba-top"><img src="%s-900.webp" alt="" aria-hidden="true" loading="lazy" decoding="async"></div>
    <input class="ba-range" type="range" min="0" max="100" value="50" step="0.1"
           aria-label="Reveal the before image for %s">
    <div class="ba-handle" aria-hidden="true"><span class="ba-knob">%s</span></div>
    <span class="ba-label ba-label--l">Before</span>
    <span class="ba-label ba-label--r">After</span>
  </div>
  <figcaption class="ba-caption"><b>%s</b> — %s · %s</figcaption>
</figure>
""" % (esc(r["title"]), base, base, base, base, sizes, esc(r["alt"]),
       base, esc(r["title"]), icon("compare"),
       esc(r["title"]), esc(r["meta"]), esc(r["detail"]))


def cta_band(title, text, note=None):
    return """
<section class="section">
  <div class="shell">
    <div class="cta-band" data-anim="up">
      <h2>%s</h2>
      <p>%s</p>
      <div class="hero-actions">
        <a class="btn btn--primary btn--lg magnet" href="/contact/">Get a free assessment %s</a>
        <a class="btn btn--wa btn--lg" href="%s" rel="noopener">%s WhatsApp us</a>
      </div>
      %s
    </div>
  </div>
</section>
""" % (esc(title), esc(text), icon("arrow"), SITE["whatsapp"], icon("wa"),
       '<p style="font-size:.84rem;margin-top:20px">%s</p>' % esc(note) if note else "")


def marquee():
    items = "".join('<span class="marquee-item">%s %s</span>' % (icon("check"), esc(t))
                    for t in TRUST)
    return '<div class="marquee" aria-hidden="true"><div class="marquee-track">%s%s</div></div>' % (items, items)


def service_cards(limit=None, exclude=None):
    out = []
    items = [s for s in SERVICES if s["slug"] != exclude]
    if limit:
        items = items[:limit]
    for s in items:
        out.append("""
<a class="card svc-card" href="/services/%s/" data-anim="up">
  <div class="svc-media">
    <img src="/assets/img/art/%s-800.webp" alt="%s" width="800" height="520" loading="lazy" decoding="async">
  </div>
  <div class="svc-body">
    <p class="svc-tag">%s</p>
    <h3>%s</h3>
    <p>%s</p>
    <span class="card-arrow">Read the full guide %s</span>
  </div>
</a>""" % (s["slug"], s["art"], esc(s["alt"]), esc(s["group"]),
           esc(svc_title(s)), esc(s["blurb"]), icon("arrow")))
    return "".join(out)


# --------------------------------------------------------------------------
# home
# --------------------------------------------------------------------------
def home():
    results = "".join(ba_block(r, i) for i, r in enumerate(RESULTS[:2]))
    steps = "".join("""
<article class="step" data-anim="up">
  <div class="step-n"></div>
  <div>
    <p class="step-meta">%s</p>
    <h3>%s</h3>
    <p>%s</p>
  </div>
</article>""" % (esc(j["m"]), esc(j["t"]), esc(j["d"])) for j in JOURNEY)

    return """
<section class="hero">
  <div class="hero-media">
    <img src="/assets/img/art/hero-istanbul-bosphorus-1600.webp"
         srcset="/assets/img/art/hero-istanbul-bosphorus-1100.webp 1100w,
                 /assets/img/art/hero-istanbul-bosphorus-1600.webp 1600w,
                 /assets/img/art/hero-istanbul-bosphorus.webp 2400w"
         sizes="100vw"
         alt="The Bosphorus at dawn with the Istanbul skyline in the distance"
         width="2400" height="1005" fetchpriority="high" decoding="async">
  </div>
  <div class="shell">
    <div class="hero-inner">
      <p class="eyebrow" data-anim="fade">Istanbul · Türkiye</p>
      <h1 class="reveal-lines">Dental and hair restoration<br>in Istanbul, coordinated<br>from first message to<br>the flight home.</h1>
      <p class="lede" data-anim="up" style="--d:520ms">VeaHealth works with verified Istanbul clinics.
      You get a written treatment plan and a fixed price before you travel, airport transfers and a hotel
      arranged around your appointments, and a coordinator who stays reachable after you fly home.</p>
      <div class="hero-actions" data-anim="up" style="--d:640ms">
        <a class="btn btn--primary btn--lg magnet" href="/contact/">Get a free assessment %s</a>
        <a class="btn btn--ghost btn--lg" href="/before-after/">See patient results</a>
      </div>
      <div class="hero-stats" data-anim="fade" style="--d:760ms">
        <div class="hero-stat"><div class="v num"><span data-count="17" data-suffix="">0</span></div><div class="k">Treatments documented</div></div>
        <div class="hero-stat"><div class="v num"><span data-count="70" data-suffix="%%">0</span></div><div class="k">Typical saving vs UK</div></div>
        <div class="hero-stat"><div class="v num">7/24</div><div class="k">WhatsApp coordination</div></div>
      </div>
    </div>
  </div>
</section>

%s

<section class="section">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">What we coordinate</p>
      <h2 data-anim="up">Two disciplines, one coordinator, one plan.</h2>
      <p class="lede" data-anim="up">Every treatment page below carries the full protocol — technique,
      materials, day-by-day procedure, recovery timeline, published evidence and the price in writing.
      Read them before you enquire; that is what they are for.</p>
    </div>
    <div class="grid g-3" data-stagger="90">%s</div>
    <p class="mt-32"><a class="btn btn--ghost" href="/services/">All 21 treatments %s</a></p>
  </div>
</section>

<section class="section section--tint">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">Real patients</p>
      <h2 data-anim="up">Results from the clinic, not from a stock library.</h2>
      <p class="lede" data-anim="up">Drag the handle to compare. Every photograph on this site was taken
      at a VeaHealth partner clinic and published with the patient's permission.</p>
    </div>
    <div class="grid g-2" data-stagger="120">%s</div>
    <p class="mt-32"><a class="btn btn--ghost" href="/before-after/">See every documented case %s</a></p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="grid g-2" style="align-items:center;gap:clamp(32px,6vw,72px)">
      <div>
        <p class="eyebrow" data-anim="fade">Inside the clinic</p>
        <h2 data-anim="up">A one-minute walk through the facilities.</h2>
        <p class="lede mt-24" data-anim="up">Filmed at the partner clinic in Istanbul — treatment rooms,
        sterilisation, the laboratory and the patient areas. No narration, no music bed over a slideshow
        of somebody else's clinic.</p>
        <ul class="checklist mt-24" data-anim="up">
          <li>%s Filmed on site, unedited walkthrough</li>
          <li>%s The rooms you will actually be treated in</li>
          <li>%s Ask your coordinator for a live video tour any time</li>
        </ul>
      </div>
      <div class="media-frame" data-anim="scale">
        <video controls preload="none" playsinline
               poster="/assets/img/film/clinic-film-poster.webp"
               width="1280" height="720"
               aria-label="Walkthrough film of the VeaHealth partner clinic in Istanbul">
          <source src="/assets/video/veahealth-clinic-film.mp4" type="video/mp4">
          <p>Your browser cannot play this video. <a href="/assets/video/veahealth-clinic-film.mp4">Download the film</a>.</p>
        </video>
      </div>
    </div>
  </div>
</section>

<section class="section section--sand">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">The journey</p>
      <h2 data-anim="up">What actually happens, in order.</h2>
      <p class="lede" data-anim="up">No treatment is booked before you have a written plan and a fixed
      price. Everything after that is logistics, and the logistics are ours.</p>
    </div>
    <div class="steps">%s</div>
    <p class="mt-32"><a class="btn btn--ghost" href="/journey/">The journey in detail %s</a></p>
  </div>
</section>

%s
""" % (icon("arrow"), marquee(), service_cards(limit=6), icon("arrow"),
       results, icon("arrow"),
       icon("check"), icon("check"), icon("check"),
       steps, icon("arrow"),
       cta_band("Send your photographs. Get a written plan.",
                "A partner dentist reviews your photographs and any recent X-rays, then returns an "
                "itemised treatment plan with a fixed price. There is no charge for the assessment "
                "and no obligation afterwards.",
                "We reply to every enquiry within one working day."))


# --------------------------------------------------------------------------
# services hub
# --------------------------------------------------------------------------
def services_hub():
    blocks = ""
    for g in GROUP_ORDER:
        items = [s for s in SERVICES if s["group"] == g]
        cards = "".join("""
<a class="card svc-card" href="/services/%s/" data-anim="up">
  <div class="svc-media"><img src="/assets/img/art/%s-800.webp" alt="%s" width="800" height="520" loading="lazy" decoding="async"></div>
  <div class="svc-body"><h3>%s</h3><p>%s</p><span class="card-arrow">Read the guide %s</span></div>
</a>""" % (s["slug"], s["art"], esc(s["alt"]), esc(svc_title(s)), esc(s["blurb"]), icon("arrow"))
                        for s in items)
        blocks += """
<section class="section%s">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">%d treatments</p>
      <h2 data-anim="up">%s</h2>
    </div>
    <div class="grid g-3" data-stagger="80">%s</div>
  </div>
</section>""" % (" section--tint" if g == "Crowns & veneers" else "", len(items), esc(g), cards)

    return page_hero(
        "Treatments",
        "Every treatment, documented in full.",
        "Twenty-one treatments across dentistry and hair restoration. Each page carries the technique, "
        "the materials, the day-by-day procedure, the recovery timeline, the published evidence and the "
        "Istanbul price — so you can decide before you speak to anyone.",
        [("Home", "/"), ("Treatments", None)],
    ) + blocks + cta_band(
        "Not sure which treatment applies to you?",
        "Send photographs and any recent X-rays. A partner dentist reviews them and tells you what is "
        "actually indicated — including when the answer is that you do not need what you asked about.")


# --------------------------------------------------------------------------
# before / after
# --------------------------------------------------------------------------
def before_after():
    grid = "".join(ba_block(r, i) for i, r in enumerate(RESULTS))
    stories = ""
    for n, label in ((2, "Patient after full smile restoration"),
                     (4, "Patient after smile design treatment")):
        stories += """
<figure class="media-frame" data-anim="up">
  <video controls preload="none" playsinline poster="/assets/img/film/patient-story-%d-poster.webp"
         width="460" height="816" aria-label="%s">
    <source src="/assets/video/patient-story-%d.mp4" type="video/mp4">
  </video>
</figure>""" % (n, esc(label), n)

    return page_hero(
        "Patient results",
        "Before and after, with the handle in your hand.",
        "Drag across each image to compare. These are photographs of VeaHealth patients, taken at the "
        "partner clinic and published with permission — not stock photography and not generated images.",
        [("Home", "/"), ("Results", None)],
    ) + """
<section class="section">
  <div class="shell">
    <div class="grid g-2" data-stagger="110">%s</div>
    <p class="mt-48" style="font-size:.88rem;color:var(--ink-2);max-width:70ch">
      Results vary between individuals. Bone quality, gum health, healing response and aftercare all
      affect the outcome, and no clinic can guarantee that your result will match another patient's.
      What you see here is what was achieved for these patients, photographed under the clinic's own
      lighting conditions.
    </p>
  </div>
</section>

<section class="section section--tint">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">In motion</p>
      <h2 data-anim="up">Patients, filmed at the clinic.</h2>
      <p class="lede" data-anim="up">Short clips recorded after treatment, with the patients' permission.</p>
    </div>
    <div class="grid g-3" data-stagger="120" style="max-width:760px">%s</div>
  </div>
</section>
""" % (grid, stories) + cta_band(
        "See what is achievable in your case.",
        "Send photographs of your current smile and any recent X-rays. You will get a written plan "
        "showing what is realistic — not a sales pitch built on somebody else's results.")


# --------------------------------------------------------------------------
# gallery / clinic
# --------------------------------------------------------------------------
def gallery():
    figs = ""
    for c in CLINIC:
        base = "/assets/img/clinic/" + c["img"]
        figs += """
<figure data-anim="up">
  <img src="%s-900.webp" srcset="%s-500.webp 500w, %s-900.webp 900w, %s.webp 1600w"
       sizes="(min-width:900px) 33vw, 100vw" alt="%s" loading="lazy" decoding="async">
  <figcaption>%s</figcaption>
</figure>""" % (base, base, base, base, esc(c["alt"]), esc(c["alt"]))

    for name, alt in (("dsd-consultation-room", "Consultation room with digital smile design on screen"),
                      ("journey-hotel-bosphorus-suite", "Partner hotel suite overlooking the Bosphorus"),
                      ("journey-vip-transfer-istanbul", "Private transfer waiting at Istanbul Airport")):
        figs += """
<figure data-anim="up">
  <img src="/assets/img/art/%s-900.webp" alt="%s" loading="lazy" decoding="async">
  <figcaption>%s — illustration</figcaption>
</figure>""" % (name, esc(alt), esc(alt))

    return page_hero(
        "Clinic & facilities",
        "Where you will actually be treated.",
        "Photographs and film from the VeaHealth partner clinic in Istanbul: treatment rooms, "
        "laboratory, patient areas. Ask your coordinator for a live video tour before you commit "
        "to anything.",
        [("Home", "/"), ("Clinic", None)],
    ) + """
<section class="section">
  <div class="shell">
    <div class="media-frame mb-32" data-anim="scale" style="margin-bottom:clamp(28px,4vw,48px)">
      <video controls preload="none" playsinline poster="/assets/img/film/clinic-film-poster.webp"
             width="1280" height="720" aria-label="Walkthrough film of the partner clinic in Istanbul">
        <source src="/assets/video/veahealth-clinic-film.mp4" type="video/mp4">
      </video>
    </div>
    <div class="masonry">%s</div>
    <p class="mt-32" style="font-size:.84rem;color:var(--ink-3);max-width:70ch">
      Images marked “illustration” depict the standard of accommodation and transfer arranged for
      patients; the clinic photographs and the film are of the partner facility itself.
    </p>
  </div>
</section>
""" % figs + cta_band(
        "Want to see it live before you decide?",
        "Your coordinator can walk you through the clinic on a video call, in English, at a time that "
        "suits you — before any deposit and before any booking.")


# --------------------------------------------------------------------------
# the journey
# --------------------------------------------------------------------------
def journey():
    blocks = ""
    for i, j in enumerate(JOURNEY):
        media = """
<div class="media-frame ratio-16-9" data-anim="scale">
  <img src="/assets/img/art/%s-900.webp" alt="%s" width="900" height="506" loading="lazy" decoding="async">
</div>""" % (j["img"], esc(j["alt"]))
        text = """
<div>
  <p class="step-meta" data-anim="fade">%s</p>
  <h2 data-anim="up">%s</h2>
  <p class="lede mt-24" data-anim="up">%s</p>
  <ul class="checklist mt-24" data-anim="up">%s</ul>
</div>""" % (esc(j["m"]), esc(j["t"]), esc(j["d"]),
             "".join("<li>%s %s</li>" % (icon("check"), esc(x)) for x in j["list"]))
        order = (text + media) if i % 2 == 0 else (media + text)
        blocks += """
<section class="section%s">
  <div class="shell">
    <div class="grid g-2" style="align-items:center;gap:clamp(28px,5vw,64px)">%s</div>
  </div>
</section>""" % (" section--tint" if i % 2 else "", order)

    return page_hero(
        "The journey",
        "From your first message to the flight home.",
        "Medical travel goes wrong in the gaps — the transfer nobody booked, the plan that changed "
        "price on arrival, the clinic that stopped replying once you landed back home. This is how "
        "each of those gaps is closed.",
        [("Home", "/"), ("The journey", None)],
    ) + blocks + """
<section class="section">
  <div class="shell shell-narrow">
    <h2 data-anim="up">After you fly home</h2>
    <p class="lede mt-24" data-anim="up">Aftercare is where medical tourism most often fails patients.
    Your coordinator stays reachable on the same WhatsApp number you used before treatment. If something
    needs reviewing, you send photographs and the treating clinician looks at them — you are not handed
    to a general inbox.</p>
    <ul class="checklist mt-24" data-anim="up">
      <li>%s Same coordinator, same number, after you land</li>
      <li>%s Written aftercare protocol before you leave Istanbul</li>
      <li>%s Follow-up photograph reviews at agreed intervals</li>
      <li>%s Warranty terms issued in writing with your treatment plan</li>
    </ul>
  </div>
</section>
""" % (icon("check"), icon("check"), icon("check"), icon("check")) + cta_band(
        "Start with the assessment, not the booking.",
        "Nothing is scheduled and no deposit is taken until you have read a written plan with a fixed "
        "price and decided you want to go ahead.")


# --------------------------------------------------------------------------
# about
# --------------------------------------------------------------------------
def about():
    return page_hero(
        "About",
        "A coordinator, not a clinic.",
        "VeaHealth is a medical tourism coordinator based in Istanbul. We do not perform treatment — "
        "licensed partner clinics and their clinical teams do. Being clear about that is the first "
        "thing a patient deserves.",
        [("Home", "/"), ("About", None)],
    ) + """
<section class="section">
  <div class="shell">
    <div class="grid g-2" style="gap:clamp(32px,6vw,72px);align-items:start">
      <div>
        <h2 data-anim="up">What we do</h2>
        <p class="lede mt-24" data-anim="up">We sit between you and the clinic. That means reviewing your
        photographs with a partner dentist before you travel, getting the treatment plan and the price in
        writing, booking the transfers and the hotel around your appointments, translating in the chair,
        and staying reachable once you are home.</p>
        <p class="mt-24" data-anim="up">It also means telling you when a treatment is not indicated. An
        assessment that comes back saying you do not need what you asked about is a good assessment, and
        you will get those from us.</p>
      </div>
      <div>
        <h2 data-anim="up">What we do not do</h2>
        <ul class="checklist mt-24" data-anim="up">
          <li>%s We do not perform treatment — partner clinics and their clinicians do</li>
          <li>%s We do not quote a price that changes once you land</li>
          <li>%s We do not publish stock photography as patient results</li>
          <li>%s We do not guarantee an outcome; no honest clinic can</li>
          <li>%s We do not take a deposit before you have a written plan</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="section section--tint">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">How to judge us</p>
      <h2 data-anim="up">Questions worth asking any coordinator.</h2>
      <p class="lede" data-anim="up">Including this one. If a question below cannot be answered plainly
      and in writing, that tells you something.</p>
    </div>
    <div class="grid g-2" data-stagger="80">
      <div class="card" data-anim="up"><h3>Who performs the treatment?</h3>
        <p>Ask for the name and registration of the treating clinician, not the name of the agency.
        You are entitled to know who will be operating on you.</p></div>
      <div class="card" data-anim="up"><h3>Is the quote itemised and fixed?</h3>
        <p>A quote should list every component — implants, abutments, crowns, grafting materials,
        laboratory work — and state what happens if the plan changes once you are in the chair.</p></div>
      <div class="card" data-anim="up"><h3>Are these results your own patients?</h3>
        <p>Ask directly whether before-and-after images are the clinic's own cases. Stock and generated
        images are common in this industry and are worth nothing to you.</p></div>
      <div class="card" data-anim="up"><h3>What happens if something goes wrong at home?</h3>
        <p>Ask what the warranty covers, what it excludes, who reviews a problem, and whether return
        flights are included in a revision. Get the answer in writing.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell shell-narrow">
    <h2 data-anim="up">Contact</h2>
    <p class="lede mt-24" data-anim="up">Istanbul, Türkiye. Monday to Saturday, 09:00–18:00 local time.
    WhatsApp is answered seven days a week.</p>
    <ul class="checklist mt-24" data-anim="up">
      <li>%s <a href="mailto:%s">%s</a></li>
      <li>%s <a href="tel:%s">%s</a></li>
      <li>%s <a href="%s" rel="noopener">WhatsApp</a></li>
    </ul>
  </div>
</section>
""" % (icon("check"), icon("check"), icon("check"), icon("check"), icon("check"),
       icon("mail"), esc(SITE["email"]), esc(SITE["email"]),
       icon("phone"), esc(SITE["phone_href"]), esc(SITE["phone"]),
       icon("wa"), SITE["whatsapp"]) + cta_band(
        "Ask us anything before you commit.",
        "No deposit, no booking and no pressure until you have a written plan you are happy with.")


# --------------------------------------------------------------------------
# contact — the form that actually captures a lead
# --------------------------------------------------------------------------
def contact():
    treatments = ["Dental implants", "All-on-4 / All-on-6", "Zirconium crowns",
                  "Veneers / Hollywood smile", "Full mouth restoration",
                  "Sapphire FUE hair transplant", "DHI hair transplant",
                  "Beard or eyebrow restoration", "Not sure yet"]
    chips = "".join(
        '<label class="chip"><input type="checkbox" name="treatments" value="%s">%s</label>'
        % (esc(t), esc(t)) for t in treatments)

    return page_hero(
        "Free assessment",
        "Send your photographs. Get a written plan.",
        "A partner dentist reviews what you send and returns an itemised treatment plan with a fixed "
        "price. No charge, and no obligation afterwards.",
        [("Home", "/"), ("Contact", None)],
    ) + """
<section class="section">
  <div class="shell">
    <div class="grid g-2" style="gap:clamp(30px,5vw,64px);align-items:start">
      <div class="form-card" data-anim="up">
        <form id="enquiry-form" novalidate
              data-endpoint="%s"
              data-whatsapp="%s">
          <div class="form-steps" aria-hidden="true">
            <span class="fs is-active"></span><span class="fs"></span><span class="fs"></span>
          </div>

          <!-- honeypot: hidden from people, filled by bots -->
          <div style="position:absolute;left:-9999px" aria-hidden="true">
            <label>Company<input type="text" name="company" tabindex="-1" autocomplete="off"></label>
          </div>

          <fieldset class="form-step is-active" style="border:0;padding:0;margin:0">
            <h2 style="font-size:var(--step-2)">How can we reach you?</h2>
            <p class="muted" style="font-size:.9rem;margin:8px 0 22px">
              We need an email and a phone number so a coordinator can send your plan and follow up —
              even if WhatsApp does not open on your device.
            </p>
            <div class="row-2">
              <div class="field">
                <label for="firstName">First name <span class="req">*</span></label>
                <input class="input" id="firstName" name="firstName" type="text" autocomplete="given-name" required>
                <span class="field-error" role="alert"></span>
              </div>
              <div class="field">
                <label for="lastName">Last name <span class="req">*</span></label>
                <input class="input" id="lastName" name="lastName" type="text" autocomplete="family-name" required>
                <span class="field-error" role="alert"></span>
              </div>
            </div>
            <div class="field">
              <label for="email">Email <span class="req">*</span></label>
              <input class="input" id="email" name="email" type="email" autocomplete="email" required
                     placeholder="name@example.com">
              <span class="field-error" role="alert"></span>
            </div>
            <div class="row-2">
              <div class="field">
                <label for="phone">Phone, with country code <span class="req">*</span></label>
                <input class="input" id="phone" name="phone" type="tel" autocomplete="tel" required
                       placeholder="+44 7700 900000">
                <span class="field-error" role="alert"></span>
              </div>
              <div class="field">
                <label for="country">Country <span class="req">*</span></label>
                <input class="input" id="country" name="country" type="text" autocomplete="country-name" required>
                <span class="field-error" role="alert"></span>
              </div>
            </div>
            <button class="btn btn--primary btn--block" type="button" data-step="next">Continue %s</button>
          </fieldset>

          <fieldset class="form-step" style="border:0;padding:0;margin:0">
            <h2 style="font-size:var(--step-2)">What are you considering?</h2>
            <p class="muted" style="font-size:.9rem;margin:8px 0 22px">
              Pick anything that applies, or “not sure yet” — the assessment will tell you what is
              actually indicated.
            </p>
            <div class="chip-grid">%s</div>
            <div class="field" style="margin-top:26px">
              <label for="timing">When are you planning to travel?</label>
              <select class="select" id="timing" name="timing">
                <option>As soon as possible</option>
                <option selected>In 1–3 months</option>
                <option>In 3–6 months</option>
                <option>Later than 6 months</option>
                <option>Just researching for now</option>
              </select>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
              <button class="btn btn--ghost" type="button" data-step="prev">Back</button>
              <button class="btn btn--primary" style="flex:1" type="button" data-step="next">Continue %s</button>
            </div>
          </fieldset>

          <fieldset class="form-step" style="border:0;padding:0;margin:0">
            <h2 style="font-size:var(--step-2)">Anything you want us to know?</h2>
            <p class="muted" style="font-size:.9rem;margin:8px 0 22px">
              Existing dental work, past surgery, medical conditions, medication — anything that helps
              the dentist assess your case. You can also email photographs to
              <a href="mailto:%s">%s</a>.
            </p>
            <div class="field">
              <label for="message">Your message</label>
              <textarea class="textarea" id="message" name="message" rows="5"
                        placeholder="For example: upper molars missing for two years, considering implants."></textarea>
            </div>
            <label class="consent">
              <input type="checkbox" name="consent" required>
              <span>I agree that VeaHealth may store these details and contact me about my enquiry,
              as described in the <a href="/privacy-policy/">privacy policy</a>. <span class="req">*</span></span>
            </label>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
              <button class="btn btn--ghost" type="button" data-step="prev">Back</button>
              <button class="btn btn--primary" style="flex:1" type="submit">Send my enquiry %s</button>
            </div>
            <p class="form-note">Your details are sent to the clinic coordinator. We do not sell or share
            them with anyone else. WhatsApp opens afterwards as a second channel — your enquiry is already
            recorded either way.</p>
            <div class="form-status" role="status" aria-live="polite"></div>
          </fieldset>
        </form>
      </div>

      <div>
        <h2 data-anim="up">Prefer to talk first?</h2>
        <p class="lede mt-24" data-anim="up">WhatsApp is answered seven days a week, in English.
        Call or email during Istanbul office hours.</p>
        <div class="stack-16 mt-32" data-anim="up" style="display:flex;flex-direction:column;gap:12px">
          <a class="btn btn--wa btn--lg" href="%s" rel="noopener">%s WhatsApp %s</a>
          <a class="btn btn--ghost btn--lg" href="tel:%s">%s %s</a>
          <a class="btn btn--ghost btn--lg" href="mailto:%s">%s %s</a>
        </div>
        <div class="card mt-48" data-anim="up">
          <h3>What to send</h3>
          <ul class="checklist mt-24">
            <li>%s A photograph of your smile, relaxed and wide</li>
            <li>%s A photograph from the side, if you can</li>
            <li>%s Any panoramic X-ray taken in the last two years</li>
            <li>%s A note of any medication or medical condition</li>
          </ul>
          <p class="mt-24" style="font-size:.86rem;color:var(--ink-2)">Photographs taken on a phone in
          daylight are fine. You do not need professional images for the assessment.</p>
        </div>
        <div class="card mt-24" data-anim="up">
          <h3>Opening hours</h3>
          <p>Monday – Saturday · 09:00 – 18:00 (Istanbul, GMT+3)<br>Sunday · closed<br>
          WhatsApp answered seven days a week.</p>
        </div>
      </div>
    </div>
  </div>
</section>
""" % (SITE["form_endpoint"], SITE["whatsapp"], icon("arrow"), chips, icon("arrow"),
       esc(SITE["email"]), esc(SITE["email"]), icon("arrow"),
       SITE["whatsapp"], icon("wa"), esc(SITE["phone"]),
       esc(SITE["phone_href"]), icon("phone"), esc(SITE["phone"]),
       esc(SITE["email"]), icon("mail"), esc(SITE["email"]),
       icon("check"), icon("check"), icon("check"), icon("check"))


# --------------------------------------------------------------------------
# blog
# --------------------------------------------------------------------------
def blog_index():
    cards = "".join("""
<a class="card svc-card" href="/blog/%s/" data-anim="up">
  <div class="svc-media"><img src="/assets/img/art/%s-900.webp" alt="%s" width="900" height="506" loading="lazy" decoding="async"></div>
  <div class="svc-body">
    <p class="svc-tag"><time datetime="%s">%s</time></p>
    <h3>%s</h3><p>%s</p>
    <span class="card-arrow">Read %s</span>
  </div>
</a>""" % (p["slug"], p["cover"], esc(p["alt"]), p["date"], p["date"],
           esc(p["title"]), esc(p["desc"]), icon("arrow")) for p in POSTS)

    return page_hero(
        "Journal",
        "Notes on treatment, travel and judgement.",
        "Written for patients deciding whether to travel, and what to ask when they get there.",
        [("Home", "/"), ("Journal", None)],
    ) + """
<section class="section">
  <div class="shell">
    <h2 class="visually-hidden">Latest articles</h2>
    <div class="grid g-2" data-stagger="90">%s</div>
  </div>
</section>
""" % cards + cta_band(
        "Have a question the journal does not answer?",
        "Send it to your coordinator. If it is a clinical question, a partner dentist answers it.")


# --------------------------------------------------------------------------
# legal
# --------------------------------------------------------------------------
LEGAL_CSS = "max-width:72ch"


def _legal(title, lede, sections, crumb):
    body = ""
    for h, paras in sections:
        body += '<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">%s</h2>' % esc(h)
        for p in paras:
            body += '<p class="mt-24" data-anim="up">%s</p>' % p
    return page_hero("Legal", title, lede, [("Home", "/"), (crumb, None)]) + """
<section class="section"><div class="shell shell-narrow">%s
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Last updated 28 August 2026.
Questions about this page: <a href="mailto:%s">%s</a>.</p>
</div></section>""" % (body, esc(SITE["email"]), esc(SITE["email"]))


def privacy():
    return _legal(
        "Privacy policy",
        "What we collect when you enquire, why we hold it, how long we keep it and how to get it deleted.",
        [
            ("Who is responsible", [
                "VeaHealth, based in Istanbul, Türkiye, is the controller of the personal data collected "
                "through this website. You can reach us at <a href=\"mailto:%s\">%s</a> or on %s."
                % (esc(SITE["email"]), esc(SITE["email"]), esc(SITE["phone"])),
            ]),
            ("What we collect", [
                "<b>When you use the enquiry form:</b> your name, email address, telephone number, country, "
                "the treatments you selected, your indicated travel timing and anything you write in the "
                "message field.",
                "<b>When you send photographs or X-rays:</b> images of your teeth, mouth, scalp or face, and "
                "any clinical information you choose to include. Under Article 9 of the GDPR this is health "
                "data, a special category of personal data. We process it only on the basis of your explicit "
                "consent, given when you submit the form or send the images, and only to prepare and discuss "
                "a treatment assessment.",
                "<b>When you accept analytics cookies:</b> aggregated usage data about which pages are "
                "visited. No analytics tag loads until you accept — see the "
                "<a href=\"/cookie-policy/\">cookie policy</a>.",
            ]),
            ("Why we use it", [
                "To review your case with a partner clinic, prepare a treatment plan and a quote, arrange "
                "travel and appointments if you decide to proceed, and to answer you afterwards. We do not "
                "sell your data and we do not share it for advertising.",
            ]),
            ("Who we share it with", [
                "The partner clinic and treating clinicians involved in preparing or delivering your "
                "treatment plan, and the hotel or transfer provider where a booking is being made for you. "
                "Our email and hosting providers process data on our behalf under contract.",
                "Türkiye is outside the European Economic Area. Where you are in the EEA or the UK, your "
                "data is transferred to Türkiye on the basis of your explicit consent to the assessment, "
                "which is necessary for us to provide what you asked for.",
            ]),
            ("How long we keep it", [
                "Enquiries that do not lead to treatment are deleted within 24 months. Where treatment goes "
                "ahead, records are kept for the period required by Turkish healthcare record-keeping "
                "obligations, held by the treating clinic.",
            ]),
            ("Your rights", [
                "You can ask for a copy of the data we hold about you, ask us to correct it, ask us to "
                "delete it, ask us to restrict how we use it, or withdraw your consent at any time — "
                "including consent to hold clinical photographs. Withdrawing consent does not affect "
                "processing already carried out.",
                "Write to <a href=\"mailto:%s\">%s</a> and we will respond within 30 days. If you are in "
                "the EEA or the UK and are not satisfied with our response, you can complain to your "
                "national data protection authority." % (esc(SITE["email"]), esc(SITE["email"])),
            ]),
            ("Security", [
                "This site is served over HTTPS. Enquiry data is transmitted encrypted and access to it is "
                "limited to the coordinators and clinicians who need it to handle your case.",
            ]),
        ],
        "Privacy",
    )


def cookies():
    return _legal(
        "Cookie policy",
        "Which cookies this site sets, which ones wait for your consent, and how to change your mind.",
        [
            ("Essential storage", [
                "This site stores one value in your browser, <code>vh-consent</code>, recording the cookie "
                "choice you made so the banner does not reappear on every page. It contains no identifier "
                "and is never sent to us.",
            ]),
            ("Analytics — only with consent", [
                "If you choose “Accept analytics”, we load Google Analytics to see which pages help "
                "patients decide. IP addresses are anonymised. If you choose “Essential only”, or ignore "
                "the banner, no analytics script is loaded at all — not deferred, not queued: not loaded.",
            ]),
            ("Advertising", [
                "This site sets no advertising or cross-site tracking cookies.",
            ]),
            ("Changing your choice", [
                "Clear this site's data in your browser settings and the banner will appear again on your "
                "next visit, letting you choose differently.",
            ]),
            ("Embedded content", [
                "Video on this site is served from our own server and sets no third-party cookies. "
                "Following a link to Facebook, Instagram, YouTube or WhatsApp takes you to those services, "
                "which set their own cookies under their own policies.",
            ]),
        ],
        "Cookies",
    )


def terms():
    return _legal(
        "Terms of use",
        "What this website is, what it is not, and the limits of what is published here.",
        [
            ("What VeaHealth is", [
                "VeaHealth is a medical tourism coordinator based in Istanbul. We arrange assessments, "
                "treatment plans, appointments, transfers and accommodation with licensed partner clinics. "
                "<b>We do not provide medical or dental treatment ourselves.</b> Treatment is provided by "
                "the partner clinic and its clinicians, who are responsible for the clinical care they give.",
            ]),
            ("This site is not medical advice", [
                "The treatment pages on this site describe procedures in general terms. They are not a "
                "diagnosis, not a treatment plan and not a substitute for examination by a qualified "
                "clinician. Whether a procedure is appropriate for you can only be determined by a "
                "clinician who has examined you and reviewed your medical history.",
            ]),
            ("Prices", [
                "Prices shown are indicative package prices in Istanbul at the time of publication and can "
                "change. The only price that binds anyone is the one written in the individual quote issued "
                "to you after assessment. Where a plan has to change during treatment, any change in price "
                "is agreed with you before the additional work is carried out.",
            ]),
            ("Results", [
                "Before-and-after photographs published on this site are of VeaHealth patients, used with "
                "their permission. They show what was achieved for those individuals. Outcomes depend on "
                "bone quality, gum and scalp health, healing response, medical history and aftercare, and "
                "no outcome is guaranteed.",
            ]),
            ("Warranty", [
                "Warranty terms differ by treatment and by clinic and are set out in the written treatment "
                "plan issued to you. Read what is covered and what is excluded before you accept a plan.",
            ]),
            ("Links", [
                "This site links to third-party services such as WhatsApp and social platforms. We are not "
                "responsible for their content or their handling of your data.",
            ]),
            ("Governing law", [
                "These terms are governed by the laws of the Republic of Türkiye. Nothing here limits any "
                "consumer rights you hold under the law of your own country of residence.",
            ]),
        ],
        "Terms",
    )


def not_found():
    return """
<section class="page-hero">
  <div class="shell">
    <p class="eyebrow">Error 404</p>
    <h1>That page is not here.</h1>
    <p class="lede">It may have moved when the site was rebuilt. The treatment guides, patient results and
    contact form are all one click away.</p>
    <div class="hero-actions">
      <a class="btn btn--primary" href="/">Back to the homepage %s</a>
      <a class="btn btn--ghost" href="/services/">All treatments</a>
      <a class="btn btn--ghost" href="/contact/">Contact</a>
    </div>
  </div>
</section>
<section class="section">
  <div class="shell">
    <h2 class="mt-24">Popular treatments</h2>
    <div class="grid g-3 mt-32">%s</div>
  </div>
</section>
""" % (icon("arrow"), service_cards(limit=3))
