#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Generate inc/content.php for the WordPress theme.

The treatment content is the same salvaged HTML the static build uses, with two
differences: the site chrome (breadcrumb, closing call-to-action) is left out
because the template renders it, and asset and home URLs become the tokens
%VH_ASSETS% and %VH_HOME% so the content survives a domain change or a move
into a subdirectory.
"""

import os
import re
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, HERE)

import extract                                    # noqa: E402
import pages as P                                 # noqa: E402
from layout import esc, icon                      # noqa: E402
from site_data import SERVICES, POSTS, GROUP_ORDER  # noqa: E402
from new_services import NEW_PAGES                # noqa: E402
from build import post_body                       # noqa: E402

ROOT = os.path.dirname(HERE)
SRC_PAGES = os.path.join(ROOT, "source-pages")


def tokenise(html):
    """Swap absolute site paths for tokens the theme expands at render time."""
    html = html.replace('"/assets/', '"%VH_ASSETS%/')
    html = html.replace("'/assets/", "'%VH_ASSETS%/")
    html = re.sub(r'href="/(?!/)', 'href="%VH_HOME%/', html)
    return html


def php_string(s):
    """A single-quoted PHP literal."""
    return "'" + s.replace("\\", "\\\\").replace("'", "\\'") + "'"


def php_heredoc(s, tag):
    """Nowdoc: no interpolation, no escaping needed for the HTML payload."""
    return "<<<'%s'\n%s\n%s" % (tag, s, tag)


def salvaged_service(s):
    doc = extract.load(os.path.join(SRC_PAGES, s["src"] + ".html"))
    if doc is None:
        return None
    meta = extract.meta(doc)
    css = extract.css(doc, scope=".svc-page")

    body = extract.body(doc)
    body = extract.modernise(body)
    body = extract.normalise_headings(body)
    body = extract.focusable_scroll_regions(body)
    body = extract.mark_surfaces(body, extract.dark_sections(css))
    body = extract.inject_hero_media(body, s["art"], s["alt"])
    body = '<div class="svc-page">%s</div>' % body

    proc = meta["procedure"] or {}
    return {
        "slug": s["slug"],
        "title": s.get("nav_title") or s["slug"],
        "seo_title": meta["title"],
        "excerpt": meta["description"] or s["blurb"],
        "group": s["group"],
        "art": s["art"],
        "alt": s["alt"],
        "content": tokenise(body),
        "procedure_type": proc.get("procedureType", "Dental Restoration"),
        "body_location": proc.get("bodyLocation", ""),
        "how_performed": proc.get("howPerformed", ""),
        "preparation": proc.get("preparation", ""),
        "followup": proc.get("followup", ""),
    }


def new_service(s):
    d = NEW_PAGES[s["slug"]]

    why = "".join(
        '\n<div class="card" data-anim="up"><h3>%s</h3><p>%s</p></div>' % (esc(t), esc(b))
        for t, b in d["why"]
    )
    steps = "".join("""
<article class="step" data-anim="up">
  <div class="step-n"></div>
  <div>
    <p class="step-meta">%s</p>
    <h3>%s</h3>
    <p>%s</p>
    <ul class="checklist mt-24">%s</ul>
  </div>
</article>""" % (esc(when), esc(t), esc(desc),
                 "".join("<li>%s %s</li>" % (icon("check"), esc(x)) for x in bullets))
        for t, when, desc, bullets in d["procedure"])
    timeline = "".join("\n<tr><td>%s</td><td>%s</td></tr>" % (esc(a), esc(b))
                       for a, b in d["timeline"])
    faqs = "".join(
        '\n<details class="faq-item"><summary>%s</summary>'
        '<div class="faq-body"><p>%s</p></div></details>' % (esc(q), esc(a))
        for q, a in d["faqs"])
    trust = "".join('<li>%s %s</li>' % (icon("check"), esc(t)) for t in d["trust"])

    body = """<div class="svc-page">
<section class="page-hero">
  <div class="shell">
    <div class="grid g-2" style="gap:clamp(28px,5vw,60px);align-items:center">
      <div>
        <p class="eyebrow" data-anim="fade">%s</p>
        <h1 data-anim="up">%s</h1>
        <p class="lede mt-24" data-anim="up">%s</p>
        <ul class="checklist mt-24" data-anim="up">%s</ul>
        <div class="hero-actions" data-anim="up">
          <a class="btn btn--primary btn--lg magnet" href="/contact/">Free assessment %s</a>
          <a class="btn btn--ghost btn--lg" href="#procedure">How it works</a>
        </div>
      </div>
      <div class="media-frame ratio-3-2" data-anim="scale">
        <img src="/assets/img/art/%s-800.webp" alt="%s" width="800" height="533" loading="lazy" decoding="async">
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">The technique</p>
      <h2 data-anim="up">%s</h2>
    </div>
    <div class="grid g-2" data-stagger="80">%s</div>
  </div>
</section>

<section class="section section--tint" id="procedure">
  <div class="shell">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">Step by step</p>
      <h2 data-anim="up">Your procedure, in order.</h2>
    </div>
    <div class="steps">%s</div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="grid g-2" style="gap:clamp(30px,5vw,60px);align-items:start">
      <div>
        <p class="eyebrow" data-anim="fade">Recovery</p>
        <h2 data-anim="up">What happens, and when.</h2>
        <p class="lede mt-24" data-anim="up">Shedding of transplanted hair between weeks two and eight is
        expected in every graft procedure. It is not a failure and it is not a sign that something has
        gone wrong.</p>
      </div>
      <div class="table-wrap" data-anim="up" tabindex="0" role="region" aria-label="Recovery timeline">
        <table>
          <thead><tr><th scope="col">Stage</th><th scope="col">What to expect</th></tr></thead>
          <tbody>%s</tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<section class="section section--tint">
  <div class="shell shell-narrow">
    <div class="sec-head">
      <p class="eyebrow" data-anim="fade">Questions</p>
      <h2 data-anim="up">Frequently asked questions</h2>
    </div>
    %s
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="card" data-anim="up" style="border-left:3px solid var(--teal)">
      <h3>Pricing for this treatment</h3>
      <p>This treatment is quoted individually — the graft count, the technique and the number of
      sessions all change the figure, and a price published without seeing your case would be
      meaningless. Send photographs and you will receive an itemised, fixed quote in writing before
      you travel.</p>
      <p class="mt-24"><a class="btn btn--primary" href="/contact/">Request a quote %s</a></p>
    </div>
  </div>
</section>
</div>""" % (esc(s["group"]), d["h1"], esc(d["lead"]), trust, icon("arrow"),
             s["art"], esc(s["alt"]),
             esc(d["why_title"]), why, steps, timeline, faqs, icon("arrow"))

    return {
        "slug": s["slug"],
        "title": d["nav_title"],
        "seo_title": d["title"],
        "excerpt": d["description"],
        "group": s["group"],
        "art": s["art"],
        "alt": s["alt"],
        "content": tokenise(body),
        "procedure_type": "Percutaneous",
        "body_location": "Scalp" if ("hair" in s["slug"] or "fue" in s["slug"]) else "Face",
        "how_performed": "",
        "preparation": "",
        "followup": "",
    }


# --------------------------------------------------------------------------
def legal_pages():
    """The legal pages, as editable post content."""
    def strip_chrome(html):
        # Keep only the prose section; the template supplies hero and crumbs.
        m = re.search(r'<section class="section"><div class="shell shell-narrow">(.*?)</div></section>',
                      html, re.S)
        return m.group(1).strip() if m else html

    return [
        dict(slug="privacy-policy", title="Privacy policy",
             excerpt="What we collect when you enquire, why we hold it, how long we keep it and how to get it deleted.",
             content=tokenise(strip_chrome(P.privacy()))),
        dict(slug="cookie-policy", title="Cookie policy",
             excerpt="Which cookies this site sets, which ones wait for your consent, and how to change your mind.",
             content=tokenise(strip_chrome(P.cookies()))),
        dict(slug="terms", title="Terms of use",
             excerpt="What VeaHealth is, what it is not, and the limits of what is published here.",
             content=tokenise(strip_chrome(P.terms()))),
    ]


def blog_posts():
    out = []
    for p in POSTS:
        blocks = post_body(p["src"], p["title"]) or []
        if not blocks:
            blocks = ["<p>%s</p>" % esc(p["desc"])]
        out.append(dict(
            slug=p["slug"], title=p["title"], excerpt=p["desc"],
            date=p["date"], cover=p["cover"], alt=p["alt"],
            content="\n".join(blocks),
        ))
    return out


# --------------------------------------------------------------------------
def main():
    services = []
    for s in SERVICES:
        item = salvaged_service(s) if s.get("src") else new_service(s)
        if item:
            services.append(item)

    php = ["<?php",
           "/**",
           " * Content payload for the one-click installer.",
           " *",
           " * Generated from the treatment pages of the previous site. The long-form",
           " * copy is preserved word for word; only the wrapper changed.",
           " *",
           " * Asset and home URLs are stored as %VH_ASSETS% and %VH_HOME% and expanded",
           " * when the content is rendered, so the site can move domain or live in a",
           " * subdirectory without a search and replace.",
           " *",
           " * @package VeaHealth",
           " */",
           "",
           "if ( ! defined( 'ABSPATH' ) ) {",
           "\texit;",
           "}",
           "",
           "/** Expand the content tokens at render time. */",
           "function veahealth_expand_tokens( $html ) {",
           "\treturn str_replace(",
           "\t\tarray( '%VH_ASSETS%', '%VH_HOME%' ),",
           "\t\tarray( VEAHEALTH_URI . '/assets', untrailingslashit( home_url() ) ),",
           "\t\t$html",
           "\t);",
           "}",
           "add_filter( 'the_content', 'veahealth_expand_tokens', 9 );",
           "add_filter( 'the_excerpt', 'veahealth_expand_tokens', 9 );",
           "",
           "/** Treatment groups, in the order they appear in the navigation. */",
           "function veahealth_content_groups() {",
           "\treturn array("]
    for g in GROUP_ORDER:
        php.append("\t\t%s," % php_string(g))
    php += ["\t);", "}", "",
            "/** The 21 treatments. */",
            "function veahealth_content_services() {",
            "\treturn array("]
    for i, s in enumerate(services):
        php.append("\t\tarray(")
        for key in ("slug", "title", "seo_title", "excerpt", "group", "art", "alt",
                    "procedure_type", "body_location", "how_performed", "preparation", "followup"):
            php.append("\t\t\t'%s' => %s," % (key, php_string(s[key])))
        php.append("\t\t\t'order'   => %d," % ((i + 1) * 10))
        php.append("\t\t\t'content' => %s," % php_heredoc(s["content"], "VH_SVC_%d" % i))
        php.append("\t\t),")
    php += ["\t);", "}", "",
            "/** Legal pages. */",
            "function veahealth_content_legal() {",
            "\treturn array("]
    for i, p in enumerate(legal_pages()):
        php.append("\t\tarray(")
        for key in ("slug", "title", "excerpt"):
            php.append("\t\t\t'%s' => %s," % (key, php_string(p[key])))
        php.append("\t\t\t'content' => %s," % php_heredoc(p["content"], "VH_LEGAL_%d" % i))
        php.append("\t\t),")
    php += ["\t);", "}", "",
            "/** The two articles carried over from the old blog. */",
            "function veahealth_content_posts() {",
            "\treturn array("]
    for i, p in enumerate(blog_posts()):
        php.append("\t\tarray(")
        for key in ("slug", "title", "excerpt", "date", "cover", "alt"):
            php.append("\t\t\t'%s' => %s," % (key, php_string(p[key])))
        php.append("\t\t\t'content' => %s," % php_heredoc(p["content"], "VH_POST_%d" % i))
        php.append("\t\t),")
    php += ["\t);", "}", ""]

    out = os.path.join(ROOT, "theme-content.php")
    if len(sys.argv) > 1:
        out = sys.argv[1]
    with open(out, "w", encoding="utf-8") as fh:
        fh.write("\n".join(php))

    print("services: %d   legal: 3   posts: %d" % (len(services), len(blog_posts())))
    print("written:  %s  (%d KB)" % (out, os.path.getsize(out) // 1024))


if __name__ == "__main__":
    main()
