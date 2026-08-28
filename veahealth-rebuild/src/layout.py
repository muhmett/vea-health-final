# -*- coding: utf-8 -*-
"""Shared chrome: <head>, header, footer, and the structured-data graph."""

import json
import html as _html
from site_data import SITE, SERVICES, GROUP_ORDER

D = SITE["domain"]


def esc(s):
    return _html.escape(s or "", quote=True)


def url(path):
    """Absolute canonical URL for a site path."""
    if not path.startswith("/"):
        path = "/" + path
    return D + path


ICON = {
    "pin": '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>',
    "mail": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>',
    "phone": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.51 1.2l-2.26 1.13a11 11 0 0 0 5.52 5.52l1.13-2.26a1 1 0 0 1 1.2-.5l4.5 1.49a1 1 0 0 1 .69.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg>',
    "wa": '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.65.08-.3-.15-1.26-.47-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.01-1.04 2.480 1.51 2.53 1.72 2.7 3.38 5.17 5.4 3.43 7.5 2.15 8.85 2.01 1.35-.14 2.55-1.09 2.9-2.14.35-1.05.35-1.94.25-2.13-.1-.19-.27-.3-.57-.44zM12.05 21.5h-.02a9.4 9.4 0 0 1-4.79-1.31l-.34-.2-3.56.93.95-3.47-.22-.36a9.38 9.38 0 0 1-1.44-5.01c0-5.19 4.23-9.41 9.43-9.41 2.52 0 4.88.98 6.66 2.76a9.35 9.35 0 0 1 2.76 6.66c0 5.19-4.23 9.41-9.43 9.41zM20.5 3.49A11.32 11.32 0 0 0 12.05 0C5.8 0 .72 5.08.72 11.32c0 2 .52 3.94 1.51 5.66L.63 24l7.18-1.88a11.3 11.3 0 0 0 4.24.83h.01c6.24 0 11.32-5.08 11.32-11.32 0-3.03-1.18-5.87-3.32-8.01z"/></svg>',
    "arrow": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>',
    "check": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>',
    "compare": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 6L4 12l5 6M15 6l5 6-5 6"/></svg>',
    "fb": '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4v-2c0-.55.45-1 1-1z"/></svg>',
    "ig": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="3.6"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/></svg>',
    "yt": '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2s-.2-1.4-.8-2c-.75-.8-1.6-.8-2-.85C16 4.1 12 4.1 12 4.1h-.01s-4 0-6.8.25c-.4.05-1.25.05-2 .85-.6.6-.8 2-.8 2S2.2 8.8 2.2 10.5v1.6c0 1.65.2 3.3.2 3.3s.2 1.4.8 2c.75.8 1.75.75 2.2.85 1.6.15 6.8.2 6.8.2s4 0 6.8-.25c.4-.05 1.25-.05 2-.85.6-.6.8-2 .8-2s.2-1.65.2-3.3v-1.6c0-1.65-.2-3.3-.2-3.3zM10 14.6V9.1l5.2 2.75L10 14.6z"/></svg>',
}


def icon(name, cls=""):
    svg = ICON[name]
    if cls:
        svg = svg.replace("<svg ", '<svg class="%s" ' % cls, 1)
    return svg


# --------------------------------------------------------------------------
# navigation
# --------------------------------------------------------------------------
def services_by_group():
    out = []
    for g in GROUP_ORDER:
        out.append((g, [s for s in SERVICES if s["group"] == g]))
    return out


def svc_title(s):
    return s.get("nav_title") or s["slug"].replace("-", " ").title()


def nav_html(current):
    def a(href, label, extra=""):
        cur = ' aria-current="page"' if href == current else ""
        return '<a href="%s"%s%s>%s</a>' % (href, cur, extra, label)

    groups = ""
    for g, items in services_by_group():
        groups += '<p class="group-label">%s</p>' % esc(g)
        for s in items:
            groups += a("/services/%s/" % s["slug"], esc(svc_title(s)))

    return """
<ul class="nav">
  <li>%s</li>
  <li class="has-sub">
    <a href="/services/">Treatments</a>
    <div class="subnav subnav--wide">%s</div>
  </li>
  <li>%s</li>
  <li>%s</li>
  <li>%s</li>
  <li>%s</li>
  <li>%s</li>
</ul>
<a class="btn btn--primary nav-cta magnet" href="/contact/">Free assessment</a>
""" % (
        a("/", "Home"),
        groups,
        a("/journey/", "The journey"),
        a("/before-after/", "Results"),
        a("/gallery/", "Clinic"),
        a("/about/", "About"),
        a("/blog/", "Journal"),
    )


def mobile_nav_html(current):
    out = ['<a href="/">Home</a>', '<a href="/services/">All treatments</a>']
    for g, items in services_by_group():
        out.append('<p class="m-group">%s</p><div class="m-sub">' % esc(g))
        for s in items:
            out.append('<a href="/services/%s/">%s</a>' % (s["slug"], esc(svc_title(s))))
        out.append("</div>")
    out.append('<p class="m-group">Company</p><div class="m-sub">')
    for href, label in [("/journey/", "The journey"), ("/before-after/", "Results"),
                        ("/gallery/", "Clinic"), ("/about/", "About"),
                        ("/blog/", "Journal"), ("/contact/", "Contact")]:
        out.append('<a href="%s">%s</a>' % (href, label))
    out.append("</div>")
    out.append('<a class="btn btn--primary btn--block mt-24" href="/contact/">Free assessment</a>')
    return "".join(out)


BRAND = """
<a class="brand" href="/" aria-label="VeaHealth Turkey — home">
  <svg viewBox="0 0 44 44" aria-hidden="true" focusable="false" style="height:34px;width:34px">
    <defs><linearGradient id="bm" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#7FE3DD"/><stop offset="1" stop-color="#1E7A75"/></linearGradient></defs>
    <path fill="url(#bm)" d="M32.2 6.6c-4.2 0-7.8 2.3-9.8 5.7-2-3.4-5.6-5.7-9.8-5.7C7.9 6.6 4 10.6 4 16.2c0 3.1 1.3 5.8 3.3 8.2 3.9 4.6 9.9 8.9 13.9 13.4a1.6 1.6 0 0 0 2.4 0c4-4.5 10-8.8 13.9-13.4 2-2.4 3.3-5.1 3.3-8.2 0-5.6-3.9-9.6-9-9.6Z"/>
  </svg>
  <span>
    <span class="brand-name">Vea<span>Health</span></span>
    <span class="brand-sub">Istanbul · Turkey</span>
  </span>
</a>
"""


def header_html(current):
    return """
<div class="scroll-progress" aria-hidden="true"></div>
<header class="site-header-group">
<div class="site-topbar">
  <div class="shell">
    <span class="tb-item">%s Istanbul, Türkiye</span>
    <a class="tb-item" href="mailto:%s">%s %s</a>
    <a class="tb-item" href="tel:%s">%s %s</a>
    <a class="tb-item tb-spacer" href="%s" rel="noopener">%s WhatsApp 7/24</a>
  </div>
</div>
<div class="site-header">
  <div class="shell">
    %s
    %s
    <button class="burger" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu"><span></span></button>
  </div>
</div>
</header>
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile">%s</nav>
""" % (
        icon("pin"), esc(SITE["email"]), icon("mail"), esc(SITE["email"]),
        esc(SITE["phone_href"]), icon("phone"), esc(SITE["phone"]),
        SITE["whatsapp"], icon("wa"),
        BRAND, nav_html(current), mobile_nav_html(current),
    )


def footer_html():
    svc_links = ""
    for g, items in services_by_group():
        svc_links += '<h3>%s</h3><ul>' % esc(g)
        for s in items:
            svc_links += '<li><a href="/services/%s/">%s</a></li>' % (s["slug"], esc(svc_title(s)))
        svc_links += "</ul>"

    return """
<footer class="site-footer">
  <div class="shell">
    <div class="foot-grid">
      <div>
        %s
        <p class="foot-disclaimer">VeaHealth is a medical tourism coordinator based in Istanbul. Treatment is
        carried out by licensed partner clinics and their clinical teams. Information on this site is general
        and is not a substitute for a consultation, diagnosis or treatment plan from a qualified clinician.</p>
        <div class="social">
          <a href="%s" rel="noopener" aria-label="VeaHealth on Facebook">%s</a>
          <a href="%s" rel="noopener" aria-label="VeaHealth on Instagram">%s</a>
          <a href="%s" rel="noopener" aria-label="VeaHealth on YouTube">%s</a>
        </div>
      </div>
      <div class="foot-col">%s</div>
      <div class="foot-col">
        <h3>Company</h3>
        <ul>
          <li><a href="/journey/">The journey</a></li>
          <li><a href="/before-after/">Patient results</a></li>
          <li><a href="/gallery/">Clinic &amp; facilities</a></li>
          <li><a href="/about/">About VeaHealth</a></li>
          <li><a href="/blog/">Journal</a></li>
          <li><a href="/contact/">Contact</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h3>Contact</h3>
        <ul>
          <li><a href="mailto:%s">%s</a></li>
          <li><a href="tel:%s">%s</a></li>
          <li><a href="%s" rel="noopener">WhatsApp</a></li>
          <li><address style="font-style:normal">%s<br>%s %s<br>Istanbul, Türkiye</address></li>
        </ul>
        <h3 style="margin-top:26px">Opening hours</h3>
        <ul>
          <li>Monday – Saturday · 09:00 – 18:00</li>
          <li>Sunday · closed</li>
          <li>WhatsApp answered 7 days</li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© 2026 VeaHealth. All rights reserved.</span>
      <a href="/privacy-policy/">Privacy policy</a>
      <a href="/cookie-policy/">Cookies</a>
      <a href="/terms/">Terms</a>
      <span class="sep"></span>
    </div>
  </div>
</footer>


<aside class="cookie" role="dialog" aria-labelledby="cookie-h" aria-describedby="cookie-p">
  <h3 id="cookie-h">Cookies on this site</h3>
  <p id="cookie-p">We use essential cookies to make the site work. With your consent we also use analytics
  cookies to understand which pages help patients most. No analytics tag loads until you choose.</p>
  <div class="cookie-actions">
    <button class="btn btn--primary" type="button" data-consent="all">Accept analytics</button>
    <button class="btn btn--ghost" type="button" data-consent="necessary">Essential only</button>
    <a class="btn btn--ghost" href="/cookie-policy/">Read policy</a>
  </div>
</aside>

<aside class="wa-float-wrap" aria-label="Quick contact">
  <a class="wa-float" href="%s" rel="noopener" aria-label="Chat with VeaHealth on WhatsApp">
    %s<span>Chat on WhatsApp</span>
  </a>
</aside>
""" % (
        BRAND,
        SITE["social"]["facebook"], icon("fb"),
        SITE["social"]["instagram"], icon("ig"),
        SITE["social"]["youtube"], icon("yt"),
        svc_links,
        esc(SITE["email"]), esc(SITE["email"]),
        esc(SITE["phone_href"]), esc(SITE["phone"]),
        SITE["whatsapp"],
        esc(SITE["street"]), esc(SITE["postcode"]), esc(SITE["district"]),
        SITE["whatsapp"], icon("wa"),
    )


# --------------------------------------------------------------------------
# structured data
# --------------------------------------------------------------------------
def org_node():
    return {
        "@type": ["Organization", "MedicalBusiness"],
        "@id": D + "/#organization",
        "name": "VeaHealth",
        "alternateName": "VeaHealth Turkey",
        "url": D + "/",
        "logo": {"@type": "ImageObject", "@id": D + "/#logo",
                 "url": D + "/assets/img/logo.svg", "contentUrl": D + "/assets/img/logo.svg"},
        "image": D + "/assets/img/clinic/vea-health-clinic-lounge-istanbul.webp",
        "email": SITE["email"],
        "telephone": SITE["phone"],
        "areaServed": ["GB", "IE", "DE", "FR", "NL", "BE", "IT", "ES", "US", "CA", "MA", "DZ", "TN"],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": SITE["street"],
            "addressLocality": SITE["district"],
            "addressRegion": SITE["city"],
            "postalCode": SITE["postcode"],
            "addressCountry": "TR",
        },
        "medicalSpecialty": ["Dentistry", "PlasticSurgery"],
        "sameAs": [SITE["social"]["facebook"], SITE["social"]["instagram"], SITE["social"]["youtube"]],
        "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "opens": "09:00", "closes": "18:00",
        }],
    }


def website_node():
    return {
        "@type": "WebSite",
        "@id": D + "/#website",
        "url": D + "/",
        "name": "VeaHealth Turkey",
        "publisher": {"@id": D + "/#organization"},
        "inLanguage": "en",
    }


def breadcrumb_node(crumbs, page_url):
    items = []
    for i, (label, href) in enumerate(crumbs, start=1):
        item = {"@type": "ListItem", "position": i, "name": label}
        if href:
            item["item"] = url(href)
        items.append(item)
    return {"@type": "BreadcrumbList", "@id": page_url + "#breadcrumb", "itemListElement": items}


def faq_node(faqs, page_url):
    return {
        "@type": "FAQPage",
        "@id": page_url + "#faq",
        "mainEntity": [{
            "@type": "Question", "name": q,
            "acceptedAnswer": {"@type": "Answer", "text": a},
        } for q, a in faqs],
    }


def schema_graph(page_url, page_type, name, desc, crumbs=None, extra=None):
    page = {
        "@type": page_type,
        "@id": page_url + "#webpage",
        "url": page_url,
        "name": name,
        "description": desc,
        "isPartOf": {"@id": D + "/#website"},
        "about": {"@id": D + "/#organization"},
        "inLanguage": "en",
    }
    graph = [org_node(), website_node(), page]
    if crumbs:
        graph.append(breadcrumb_node(crumbs, page_url))
        page["breadcrumb"] = {"@id": page_url + "#breadcrumb"}
    if extra:
        graph.extend(extra)
    return json.dumps({"@context": "https://schema.org", "@graph": graph},
                      ensure_ascii=False, separators=(",", ":"))


# --------------------------------------------------------------------------
# document
# --------------------------------------------------------------------------
# Webfonts are served from this domain, not from the Google Fonts CDN: that CDN
# receives every visitor's IP address, which German courts have held to breach
# the GDPR, and it costs an extra DNS lookup and TLS handshake before any text
# can render. See assets/fonts/fonts.css.
FONTS = "/assets/fonts/fonts.css"

# The two faces that carry the first paint are preloaded so text does not swap.
FONT_PRELOAD = (
    "/assets/fonts/outfit-variable-latin.woff2",
    "/assets/fonts/cormorantgaramond-variable-latin.woff2",
)


def document(path, title, description, body, schema="", extra_css=None,
             extra_js=None, og_image=None, preload=None, current=None,
             robots="index, follow, max-image-preview:large"):
    """Assemble one complete HTML document."""
    canonical = url(path)
    og_image = og_image or "/assets/img/clinic/vea-health-clinic-lounge-istanbul.webp"
    css = '<link rel="stylesheet" href="/assets/css/site.css">'
    if extra_css:
        # the page's own salvaged stylesheet, then the contrast repairs that
        # have to win over it
        css += '\n  <link rel="stylesheet" href="%s">' % extra_css
        css += '\n  <link rel="stylesheet" href="/assets/css/svc-contrast.css">'
    pre = ""
    if preload:
        pre = '<link rel="preload" as="image" href="%s" fetchpriority="high">' % preload
    js = '<script src="/assets/js/site.js" defer></script>'
    if extra_js:
        js += '\n<script src="%s" defer></script>' % extra_js

    ga = ' data-ga="%s"' % esc(SITE["ga_id"]) if SITE["ga_id"] else ""

    return """<!DOCTYPE html>
<html lang="en"%s>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>%s</title>
  <meta name="description" content="%s">
  <link rel="canonical" href="%s">
  <meta name="robots" content="%s">

  <meta property="og:type" content="website">
  <meta property="og:site_name" content="VeaHealth Turkey">
  <meta property="og:locale" content="en">
  <meta property="og:title" content="%s">
  <meta property="og:description" content="%s">
  <meta property="og:url" content="%s">
  <meta property="og:image" content="%s">
  <meta name="twitter:card" content="summary_large_image">

  <link rel="icon" href="/assets/img/logo-mark.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/assets/img/logo-mark.svg">
  <meta name="theme-color" content="#0F2428">

  %s
  <link rel="stylesheet" href="%s">
  %s
  %s

  <script type="application/ld+json">%s</script>
</head>
<body>
<a class="skip" href="#main">Skip to content</a>
%s
<main id="main">
%s
</main>
%s
%s
</body>
</html>
""" % (ga, esc(title), esc(description), canonical, robots,
       esc(title), esc(description), canonical, url(og_image),
       "\n  ".join('<link rel="preload" as="font" type="font/woff2" href="%s" crossorigin>' % f
                    for f in FONT_PRELOAD),
       FONTS, pre, css,
       schema or schema_graph(canonical, "WebPage", title, description),
       header_html(current or path), body, footer_html(), js)
