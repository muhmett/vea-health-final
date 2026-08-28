# -*- coding: utf-8 -*-
"""
Pull the long-form treatment content out of the old WordPress pages.

On the old site each treatment page was a complete standalone HTML document
pasted into a WordPress "Custom HTML" block. That is why the live pages carried
a second <title>, a second set of Open Graph tags and — most damagingly — a
second <link rel="canonical">, several of which pointed at a different domain.

This module takes that pasted document apart: the editorial content is kept
verbatim, everything that belonged to the stray <head> is dropped, and the
page's own CSS is lifted into a cacheable stylesheet.
"""

import re
import html as _html
import json


def _unescape(s):
    return _html.unescape(re.sub(r"<[^>]+>", "", s or "")).strip()


def load(path):
    """Return the pasted standalone document from a saved live page."""
    raw = open(path, encoding="utf-8").read()
    head_end = raw.lower().find("</head>")
    after = raw[head_end:] if head_end > 0 else raw
    m = re.search(r"<!DOCTYPE html>", after, re.I)
    if not m:
        return None
    tail = after[m.start():]
    end = tail.find("</html>")
    return tail[: end + 7] if end > 0 else tail


def meta(doc):
    """Metadata the author wrote but that never reached the real <head>."""
    def g(pat):
        mm = re.search(pat, doc, re.I | re.S)
        return _html.unescape(mm.group(1)).strip() if mm else ""

    faqs = []
    for q, a in re.findall(
        r'<div class="faq-q"><span>(.*?)</span>.*?<div class="faq-a">(.*?)</div>', doc, re.S
    ):
        faqs.append((_unescape(q), _unescape(a)))

    proc = None
    for block in re.findall(r'<script type="application/ld\+json">(.*?)</script>', doc, re.S):
        try:
            data = json.loads(block)
        except Exception:
            continue
        if isinstance(data, dict) and "MedicalProcedure" in str(data.get("@type", "")):
            proc = data

    return {
        "title": g(r"<title>(.*?)</title>"),
        "description": g(r'<meta name="description" content="(.*?)"'),
        "keywords": g(r'<meta name="keywords" content="(.*?)"'),
        "og_title": g(r'<meta property="og:title" content="(.*?)"'),
        "og_description": g(r'<meta property="og:description" content="(.*?)"'),
        "h1": _unescape(g(r"<h1[^>]*>(.*?)</h1>")),
        "h1_html": g(r"<h1[^>]*>(.*?)</h1>"),
        "lead": _unescape(g(r'<p class="hero-lead">(.*?)</p>')),
        "price": _unescape(g(r'<div class="hero-card-value">(.*?)</div>')),
        "price_label": _unescape(g(r'<span class="hero-card-label">(.*?)</span>')),
        "faqs": faqs,
        "procedure": proc,
    }


def css(doc, scope=None):
    """The page's own stylesheet, ready to be written to its own file."""
    sheets = re.findall(r"<style[^>]*>(.*?)</style>", doc, re.S)
    out = "\n".join(sheets)
    # These pages set global styles on html/body/*, which would fight the
    # shared site stylesheet. Neutralise the resets and re-scope the rest.
    out = re.sub(r"(^|\})\s*\*\s*,\s*\*::before\s*,\s*\*::after\s*\{[^}]*\}", r"\1", out)
    out = re.sub(r"(^|\})\s*html\s*\{[^}]*\}", r"\1", out)
    out = re.sub(r"(^|\})\s*body\s*\{([^}]*)\}", r"\1", out)
    out = re.sub(r"(^|\})\s*::selection\s*\{[^}]*\}", r"\1", out)
    # ':root' custom properties are harmless and needed — keep them, but move
    # them onto the page scope so they cannot leak into shared components.
    if scope:
        out = out.replace(":root{", "%s{" % scope).replace(":root {", "%s {" % scope)

    # The original pages set body copy in --muted (#5a8e98), which is only
    # 3.65:1 on white and fails WCAG 1.4.3. Raise it — and the two tints built
    # from it — to the nearest value that clears 4.5:1 without changing the hue.
    out = out.replace("--muted:      #5a8e98;", "--muted:      #49737B;")
    out = out.replace("--muted:     #5a8e98;", "--muted:     #49737B;")
    out = re.sub(r"(--muted:\s*)#5a8e98", r"\g<1>#49737B", out)
    return out.strip()


_DROP_SECTIONS = ("topbar",)


def body(doc):
    """The editorial content only: no stray head, no plugin scripts, no topbar."""
    m = re.search(r"<body[^>]*>(.*)", doc, re.S)
    inner = m.group(1) if m else doc

    # everything after the last content section is WordPress / LiteSpeed noise
    last = inner.rfind("</section>")
    if last > 0:
        inner = inner[: last + len("</section>")]

    # The pasted document repeated the contact bar and the brand lockup; the
    # site header owns both now. The bar has nested <div>s, so cut from its
    # opening tag to the first real content section rather than to a </div>.
    inner = re.sub(r'<div class="topbar"[^>]*>.*?(?=<section)', "", inner, count=1, flags=re.S)
    if '<div class="topbar"' in inner:                       # no <section> followed it
        inner = re.sub(r'<div class="topbar"[^>]*>.*', "", inner, count=1, flags=re.S)
    # anything before the first section is chrome from the old page
    first = inner.find("<section")
    if first > 0:
        inner = inner[first:]

    # drop every script: their behaviour is reimplemented in site.js
    inner = re.sub(r"<script\b.*?</script>", "", inner, flags=re.S | re.I)
    inner = re.sub(r"<style\b.*?</style>", "", inner, flags=re.S | re.I)
    inner = re.sub(r"<noscript\b.*?</noscript>", "", inner, flags=re.S | re.I)

    return inner.strip()


def modernise(inner, contact_url="/contact/"):
    """
    Upgrade the salvaged markup in place:
      * accordions become real <details>/<summary> — keyboard and AT operable
      * .reveal hooks move onto the shared scroll-reveal system
      * counters move onto the shared count-up
      * dead '#' calls-to-action get a real destination
      * every image gets lazy loading and async decoding
    """
    # --- FAQ: <div class="faq-item" onclick> → <details> ---------------------
    def faq_sub(m):
        q, a = m.group(1), m.group(2)
        return ('<details class="faq-item"><summary>%s</summary>'
                '<div class="faq-body"><p>%s</p></div></details>') % (q.strip(), a.strip())

    inner = re.sub(
        r'<div class="faq-item"[^>]*>\s*<div class="faq-q"><span>(.*?)</span>\s*'
        r'<div class="faq-arrow">[^<]*</div>\s*</div>\s*<div class="faq-a">(.*?)</div>\s*</div>',
        faq_sub, inner, flags=re.S,
    )

    # --- scroll reveal -------------------------------------------------------
    inner = re.sub(r'class="([^"]*)\breveal\b([^"]*)"', r'class="\1\2" data-anim="up"', inner)

    # --- counters ------------------------------------------------------------
    inner = re.sub(r'data-target="([0-9.]+)"', r'data-count="\1" data-suffix="%"', inner)

    # --- dead CTAs -----------------------------------------------------------
    inner = re.sub(r'<a([^>]*?)href="#"', r'<a\1href="%s"' % contact_url, inner)

    # --- stale absolute links left in the pasted markup ----------------------
    # These pointed at old WordPress URLs (and in one case at www., which now
    # redirects). Rewrite them to the live paths rather than relying on 301s,
    # and drop target="_blank" on internal links.
    inner = re.sub(
        r'href="https?://(?:www\.)?veahealthturkey\.com/(?:contact-us|contact)/?"',
        'href="%s"' % contact_url, inner)
    inner = re.sub(
        r'href="https?://(?:www\.)?veahealthturkey\.com/(?:service|services)/?"',
        'href="/services/"', inner)
    inner = re.sub(
        r'href="https?://(?:www\.)?veahealthturkey\.com/([^"]*)"',
        r'href="/\1"', inner)
    inner = re.sub(r'(<a[^>]*href="/[^"]*"[^>]*?)\s+target="_blank"', r"\1", inner)

    # --- low-contrast inline colours ----------------------------------------
    # Section labels were written inline as a translucent teal (about 2.8:1 on
    # the page ground) and a translucent white on light panels. Both fail WCAG
    # 1.4.3, and being inline they cannot be fixed from the stylesheet — so
    # rewrite them to the page's own accessible tokens.
    # Drop the declaration entirely rather than substituting a value: an inline
    # style would outrank svc-contrast.css and pin one colour on both surfaces.
    inner = re.sub(r"color:\s*rgba\(91,\s*200,\s*194,\s*0?\.\d+\)\s*;?", "", inner)
    inner = re.sub(r'\s*style="\s*"', "", inner)
    inner = re.sub(r"color:\s*rgba\(255,\s*255,\s*255,\s*0?\.[0-6]\d*\)",
                   "color:rgba(255,255,255,.82)", inner)

    # --- images --------------------------------------------------------------
    def img_sub(m):
        tag = m.group(0)
        if "loading=" not in tag:
            tag = tag.replace("<img", '<img loading="lazy" decoding="async"', 1)
        return tag
    inner = re.sub(r"<img\b[^>]*>", img_sub, inner)

    return inner


def inject_hero_media(inner, art_slug, alt):
    """Give the treatment hero a real photograph behind its existing content."""
    media = (
        '<div class="svc-hero-media" aria-hidden="true">'
        '<img src="/assets/img/art/%s.webp" alt="" width="1400" height="910" '
        'loading="lazy" decoding="async"></div>' % art_slug
    )
    # the hero tag is written as <section class="hero"> on most pages and
    # <section class="hero" id="top"> on two of them
    m = re.search(r'<section\s+class="hero"[^>]*>', inner)
    if not m:
        return inner
    return inner[: m.end()] + media + inner[m.end():]

def normalise_headings(inner, start_level=0):
    """
    Keep heading levels from skipping a step.

    The salvaged pages jump from <h2> straight to <h4> in a few places, which
    fails WCAG 1.3.1 and makes the outline unusable for screen-reader users.
    Rewrite each heading to at most one level below the previous one, keeping
    the visual class names untouched so nothing changes on screen.
    """
    prev = start_level
    seen_h1 = False
    out, pos = [], 0
    for m in re.finditer(r"<(/?)h([1-6])([^>]*)>", inner):
        closing, level, attrs = m.group(1), int(m.group(2)), m.group(3)
        out.append(inner[pos:m.start()])
        pos = m.end()
        if closing:
            out.append("</h%d>" % prev)
            continue
        level = min(level, prev + 1)
        if level == 1 and seen_h1:     # only one <h1> per document
            level = 2
        if level == 1:
            seen_h1 = True
        prev = level
        out.append("<h%d%s>" % (level, attrs))
    out.append(inner[pos:])
    return "".join(out)


def focusable_scroll_regions(inner):
    """A container that scrolls must be reachable from the keyboard."""
    return re.sub(
        r'<div class="((?:[^"]*\s)?table-wrap(?:\s[^"]*)?)"',
        r'<div class="\1" tabindex="0" role="region" aria-label="Scrollable table"',
        inner,
    )

# --------------------------------------------------------------------------
# Contrast repair
#
# The salvaged design uses one bright brand teal (#5BC8C2) for accent text on
# both dark and light section backgrounds. On the light sections that is about
# 1.9:1, well under the 4.5:1 WCAG 1.4.3 asks for. No single teal clears 4.5:1
# against both #0f2428 and #f0fafa, so the fix has to know which kind of
# section each label sits in. We read that from the page's own stylesheet and
# mark the dark sections in the markup, then one shared rule set handles both.
# --------------------------------------------------------------------------
_DARK_BG = re.compile(r"var\(--ink|#0f2428|#1a3840|#162b2e|#192d31", re.I)


def dark_sections(css_text):
    """Class names of sections the page paints with a dark background."""
    text = re.sub(r"/\*.*?\*/", " ", css_text, flags=re.S)
    dark = set()
    for m in re.finditer(r"([^{}]+)\{([^}]*)\}", text):
        sel, decl = m.group(1), m.group(2)
        bg = re.search(r"background(?:-color)?\s*:\s*([^;]+)", decl)
        if not bg or not _DARK_BG.search(bg.group(1)):
            continue
        for part in sel.split(","):
            part = part.strip()
            m2 = re.fullmatch(r"\.([a-zA-Z0-9_-]+)", part)
            if m2:
                dark.add(m2.group(1))
    return dark


def mark_surfaces(inner, dark):
    """Tag every dark-backed section so the contrast overrides can find it."""
    def sub(m):
        tag, cls = m.group(0), m.group(1)
        if any(c in dark for c in cls.split()):
            return tag[:-1] + ' data-surface="dark">'
        return tag
    return re.sub(r'<section[^>]*class="([^"]*)"[^>]*>', sub, inner)
