#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Build the static veahealthturkey.com site.

    python3 src/build.py            # writes ./dist

Inputs:
    src/               templates, data and page bodies (this directory)
    ../pages/          the saved live pages the long-form content comes from
    dist/assets/       CSS, JS, images and video (kept in place between builds)
"""

import os
import re
import shutil
import sys
import html as _html

HERE = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, HERE)

import extract                                   # noqa: E402
import pages as P                                # noqa: E402
from layout import (document, schema_graph, faq_node, esc, url, icon,  # noqa: E402
                    SITE, D)
from site_data import SERVICES, RESULTS, POSTS   # noqa: E402
from new_services import NEW_PAGES               # noqa: E402

ROOT = os.path.dirname(HERE)
# Archived copies of the old live pages. The long-form treatment content is
# salvaged from these at build time, so the bundle rebuilds on its own without
# needing the original site to still be up.
SRC_PAGES = os.path.join(ROOT, "source-pages")
OUT = os.path.join(ROOT, "dist")

WRITTEN = []          # (path, changefreq, priority) for the sitemap


def write(path, content, sitemap=True, priority="0.7"):
    full = os.path.join(OUT, path.lstrip("/"))
    os.makedirs(os.path.dirname(full), exist_ok=True)
    with open(full, "w", encoding="utf-8") as fh:
        fh.write(content)
    if sitemap:
        page = "/" + os.path.dirname(path.lstrip("/")) + "/"
        page = page.replace("//", "/")
        if path.strip("/") == "index.html":
            page = "/"
        WRITTEN.append((page, priority))
    return full


def svc_title(s):
    return s.get("nav_title") or s["slug"].replace("-", " ").title()


# ===========================================================================
# treatment pages salvaged from the old site
# ===========================================================================
def build_salvaged_service(s):
    src = os.path.join(SRC_PAGES, s["src"] + ".html")
    doc = extract.load(src)
    if doc is None:
        print("  !! no embedded document in", s["src"])
        return False

    meta = extract.meta(doc)
    scope = ".svc-page"

    # per-page stylesheet, scoped so it cannot leak into the shared chrome
    css = extract.css(doc, scope=scope)
    write("assets/css/pages/%s.css" % s["slug"], css, sitemap=False)

    body = extract.body(doc)
    body = extract.modernise(body)
    body = extract.normalise_headings(body)
    body = extract.focusable_scroll_regions(body)
    body = extract.mark_surfaces(body, extract.dark_sections(css))
    body = extract.inject_hero_media(body, s["art"], s["alt"])

    title = meta["title"] or "%s in Istanbul, Turkey – VeaHealth" % svc_title(s)
    desc = meta["description"] or s["blurb"]
    path = "/services/%s/" % s["slug"]
    page_url = url(path)

    crumbs = [("Home", "/"), ("Treatments", "/services/"), (svc_title(s), None)]
    extra = []
    if meta["faqs"]:
        extra.append(faq_node(meta["faqs"], page_url))
    proc = meta["procedure"] or {}
    node = {
        "@type": "MedicalProcedure",
        "@id": page_url + "#procedure",
        "name": proc.get("name") or svc_title(s),
        "description": proc.get("description") or desc,
        "procedureType": proc.get("procedureType", "Dental Restoration"),
        "howPerformed": proc.get("howPerformed", ""),
        "preparation": proc.get("preparation", ""),
        "followup": proc.get("followup", ""),
        "bodyLocation": proc.get("bodyLocation", ""),
        "provider": {"@id": D + "/#organization"},
        "url": page_url,
    }
    extra.append({k: v for k, v in node.items() if v != ""})

    schema = schema_graph(page_url, "MedicalWebPage", title, desc, crumbs, extra)

    nav = P.crumbs_html(crumbs)
    body = ('<div class="svc-page">%s<div class="shell" style="padding-top:14px">%s</div>%s</div>'
            % ("", nav, body))
    body += P.cta_band(
        "Ready to see what this would cost in your case?",
        "Send photographs and any recent X-rays. A partner dentist reviews them and returns an "
        "itemised plan with a fixed price — no charge, no obligation.")

    html = document(
        path, title, desc, body, schema=schema,
        extra_css="/assets/css/pages/%s.css" % s["slug"],
        og_image="/assets/img/art/%s.webp" % s["art"],
        current="/services/",
    )
    write(path + "index.html", html, priority="0.9")
    return True


# ===========================================================================
# treatment pages written from scratch (menu items that had no page)
# ===========================================================================
def build_new_service(s):
    d = NEW_PAGES[s["slug"]]
    path = "/services/%s/" % s["slug"]
    page_url = url(path)

    why = "".join("""
<div class="card" data-anim="up"><h3>%s</h3><p>%s</p></div>""" % (esc(t), esc(b))
                  for t, b in d["why"])

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

    timeline = "".join("""
<tr><td>%s</td><td>%s</td></tr>""" % (esc(a), esc(b)) for a, b in d["timeline"])

    faqs = "".join("""
<details class="faq-item"><summary>%s</summary><div class="faq-body"><p>%s</p></div></details>"""
                   % (esc(q), esc(a)) for q, a in d["faqs"])

    trust = "".join('<li>%s %s</li>' % (icon("check"), esc(t)) for t in d["trust"])

    body = """
<section class="page-hero">
  <div class="shell">
    %s
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
          <caption class="visually-hidden">Recovery timeline</caption>
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
""" % (P.crumbs_html([("Home", "/"), ("Treatments", "/services/"), (d["nav_title"], None)]),
       esc(s["group"]), d["h1"], esc(d["lead"]), trust, icon("arrow"),
       s["art"], esc(s["alt"]),
       esc(d["why_title"]), why, steps, timeline, faqs, icon("arrow"))

    body += P.cta_band(
        "Send your photographs and get a written plan.",
        "A partner surgeon reviews what you send and tells you what is realistic in your case, "
        "including when the honest answer is that surgery is not the right route.")

    crumbs = [("Home", "/"), ("Treatments", "/services/"), (d["nav_title"], None)]
    extra = [faq_node(d["faqs"], page_url), {
        "@type": "MedicalProcedure",
        "@id": page_url + "#procedure",
        "name": d["nav_title"],
        "description": d["description"],
        "procedureType": "Percutaneous",
        "bodyLocation": "Scalp" if "hair" in s["slug"] or "fue" in s["slug"] else "Face",
        "provider": {"@id": D + "/#organization"},
        "url": page_url,
    }]
    schema = schema_graph(page_url, "MedicalWebPage", d["title"], d["description"], crumbs, extra)

    html = document(path, d["title"], d["description"], body, schema=schema,
                    og_image="/assets/img/art/%s.webp" % s["art"], current="/services/")
    write(path + "index.html", html, priority="0.8")


# ===========================================================================
# blog posts salvaged from the old site
# ===========================================================================
def post_body(src_name, title=""):
    """Pull the article text out of a saved WordPress post.

    The old theme printed the headline three times and stamped the author name
    and date into the flow; none of that belongs in the article body now that
    the page template carries them.
    """
    path = os.path.join(SRC_PAGES, src_name + ".html")
    if not os.path.exists(path):
        return None
    raw = open(path, encoding="utf-8").read()
    # the article itself lives in the theme's .entry-content wrapper; matching
    # on <main> pulled in the whole navigation and footer instead
    m = re.search(r'<div[^>]*class="[^"]*entry-content[^"]*"[^>]*>(.*?)(?=<footer|</main|<div[^>]*class="[^"]*wp-block-post-comments)',
                  raw, re.S | re.I)
    if not m:
        m = re.search(r'<main[^>]*>(.*?)</main>', raw, re.S | re.I)
    seg = m.group(1) if m else raw
    seg = re.sub(r"<(script|style|noscript|svg|nav|form)\b.*?</\1>", " ", seg, flags=re.S | re.I)

    out = []
    for tag, inner in re.findall(r"<(h2|h3|p|li)[^>]*>(.*?)</\1>", seg, re.S | re.I):
        text = _html.unescape(re.sub(r"<[^>]+>", "", inner)).strip()
        text = re.sub(r"\s+", " ", text)
        if len(text) < 45:
            continue
        low = text.lower()
        if any(k in low for k in
               ("cookie", "wp-", "skip to content", "copyright", "all rights reserved")):
            continue
        if title and low.startswith(title.lower()[:28]):
            continue                                   # repeated headline
        if re.match(r"^veahealth\.tr", low) or re.match(r"^[a-z]+ \d{1,2}, \d{4}$", low):
            continue                                   # byline / date stamp
        if tag.lower() in ("h2", "h3"):
            out.append("<h2>%s</h2>" % esc(text))
        else:
            out.append("<p>%s</p>" % esc(text))
    # de-duplicate consecutive repeats (the old theme printed the excerpt twice)
    dedup, seen = [], set()
    for block in out:
        if block in seen:
            continue
        seen.add(block)
        dedup.append(block)
    return dedup


def build_post(p):
    blocks = post_body(p["src"], p["title"]) or []
    if not blocks:
        blocks = ["<p>%s</p>" % esc(p["desc"])]
    article = "".join(
        b.replace("<h2>", '<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px)">')
         .replace("<p>", '<p class="mt-24" data-anim="up">')
        for b in blocks)

    path = "/blog/%s/" % p["slug"]
    page_url = url(path)
    crumbs = [("Home", "/"), ("Journal", "/blog/"), (p["title"], None)]
    schema = schema_graph(page_url, "Article", p["title"], p["desc"], crumbs, [{
        "@type": "Article",
        "@id": page_url + "#article",
        "headline": p["title"],
        "description": p["desc"],
        "datePublished": p["date"],
        "dateModified": p["date"],
        "author": {"@id": D + "/#organization"},
        "publisher": {"@id": D + "/#organization"},
        "image": url("/assets/img/art/%s.webp" % p["cover"]),
        "mainEntityOfPage": page_url,
    }])

    body = """
<section class="page-hero">
  <div class="shell">
    %s
    <p class="eyebrow" data-anim="fade"><time datetime="%s">%s</time></p>
    <h1 data-anim="up">%s</h1>
    <p class="lede mt-24" data-anim="up">%s</p>
  </div>
</section>
<section class="section">
  <div class="shell shell-narrow">
    <div class="media-frame ratio-16-9" data-anim="scale">
      <img src="/assets/img/art/%s-900.webp" alt="%s" width="900" height="506" loading="lazy" decoding="async">
    </div>
    <article>%s</article>
    <p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">This article is general information and
    is not a diagnosis or a treatment plan. Whether a treatment suits you can only be determined by a
    clinician who has examined you.</p>
  </div>
</section>
""" % (P.crumbs_html(crumbs), p["date"], p["date"], esc(p["title"]), esc(p["desc"]),
       p["cover"], esc(p["alt"]), article)

    body += P.cta_band("Have a question about your own case?",
                       "Send photographs and a partner dentist will tell you what is indicated.")

    write(path + "index.html",
          document(path, p["title"] + " – VeaHealth Turkey", p["desc"], body, schema=schema,
                   og_image="/assets/img/art/%s.webp" % p["cover"], current="/blog/"),
          priority="0.6")


# ===========================================================================
# supporting files
# ===========================================================================
def build_sitemap():
    seen, rows = set(), []
    order = {"/": "1.0"}
    for page, pri in WRITTEN:
        if page in seen:
            continue
        seen.add(page)
        rows.append('  <url><loc>%s</loc><changefreq>monthly</changefreq>'
                    '<priority>%s</priority></url>' % (url(page), order.get(page, pri)))
    xml = ('<?xml version="1.0" encoding="UTF-8"?>\n'
           '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
           + "\n".join(sorted(rows)) + "\n</urlset>\n")
    write("sitemap.xml", xml, sitemap=False)


def build_robots():
    write("robots.txt",
          "User-agent: *\n"
          "Allow: /\n"
          "Disallow: /send.php\n\n"
          "Sitemap: %s/sitemap.xml\n" % D, sitemap=False)


HTACCESS = """# ============================================================
# VeaHealth Turkey — Apache configuration
# Works as-is on Hostinger (LiteSpeed reads .htaccess).
# ============================================================

Options -Indexes
ServerSignature Off

# ---- canonical host: force https and strip www --------------
<IfModule mod_rewrite.c>
  RewriteEngine On

  RewriteCond %{HTTPS} !=on
  RewriteRule ^(.*)$ https://veahealthturkey.com/$1 [R=301,L]

  RewriteCond %{HTTP_HOST} ^www\\.(.+)$ [NC]
  RewriteRule ^(.*)$ https://%1/$1 [R=301,L]

  # pretty URLs -> the index.html inside each folder
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*)$ /$1/ [R=301,L]
</IfModule>

ErrorDocument 404 /404.html

# ---- redirects from the old WordPress URLs ------------------
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^service/?$                        /services/ [R=301,L]
  RewriteRule ^about-us/?$                       /about/ [R=301,L]
  RewriteRule ^contact-us/?$                     /contact/ [R=301,L]
  RewriteRule ^the-journey/?$                    /journey/ [R=301,L]
  RewriteRule ^portail/?$                        /services/ [R=301,L]
  RewriteRule ^home/?$                           / [R=301,L]
  RewriteRule ^category/dental/?$                /blog/ [R=301,L]
  RewriteRule ^author/.*$                        / [R=301,L]
  RewriteRule ^services_category/.*$             /services/ [R=301,L]
  RewriteRule ^services/immediate_dental_implants/?$ /services/immediate-dental-implants/ [R=301,L]
  RewriteRule ^services/Hybrid-Prosthesis-Porcelain/?$ /services/hybrid-prosthesis-porcelain/ [R=301,L]
  RewriteRule ^are-cosmetic-dentistry-operations-age-restricted/?$ /blog/are-cosmetic-dentistry-operations-age-restricted/ [R=301,L]
  RewriteRule ^smile-makeover-transforming-confidence-through-dentistry/?$ /blog/smile-makeover-transforming-confidence-through-dentistry/ [R=301,L]

  # the old WordPress surface no longer exists here
  RewriteRule ^(wp-admin|wp-login\\.php|wp-json|xmlrpc\\.php|readme\\.html|wp-content|wp-includes) - [R=410,L]
</IfModule>

# ---- security headers ---------------------------------------
<IfModule mod_headers.c>
  Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
  Header always set X-Content-Type-Options "nosniff"
  Header always set X-Frame-Options "SAMEORIGIN"
  Header always set Referrer-Policy "strict-origin-when-cross-origin"
  Header always set Permissions-Policy "geolocation=(), microphone=(), camera=(), interest-cohort=()"
  Header always set Cross-Origin-Opener-Policy "same-origin"
  Header always set Content-Security-Policy "default-src 'self'; script-src 'self' https://www.googletagmanager.com; style-src 'self' 'unsafe-inline'; font-src 'self'; img-src 'self' data:; media-src 'self'; connect-src 'self' https://www.google-analytics.com; frame-ancestors 'self'; form-action 'self'; base-uri 'self'; upgrade-insecure-requests"
  Header unset X-Powered-By
</IfModule>

# ---- compression --------------------------------------------
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css text/javascript application/javascript application/json image/svg+xml text/xml application/xml
</IfModule>

# ---- caching ------------------------------------------------
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType text/html                "access plus 1 hour"
  ExpiresByType text/css                 "access plus 1 year"
  ExpiresByType application/javascript   "access plus 1 year"
  ExpiresByType image/webp               "access plus 1 year"
  ExpiresByType image/svg+xml            "access plus 1 year"
  ExpiresByType video/mp4                "access plus 1 year"
  ExpiresByType font/woff2               "access plus 1 year"
</IfModule>

<IfModule mod_headers.c>
  <FilesMatch "\\.(css|js|webp|svg|mp4|woff2)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>
</IfModule>

AddType image/webp .webp
"""

SEND_PHP = r"""<?php
/**
 * VeaHealth enquiry handler.
 *
 * The form posts JSON here. Every enquiry is (1) appended to a local CSV so a
 * lead is never lost even if mail fails, and (2) emailed to the coordinator.
 *
 * BEFORE GOING LIVE:
 *   - set $TO to the mailbox that should receive enquiries
 *   - set $FROM to an address on this domain (Hostinger requires this)
 *   - move $LOG outside the public folder if your hosting allows it
 */

declare(strict_types=1);

$TO   = 'info@veahealthturkey.com';
$FROM = 'website@veahealthturkey.com';
$LOG  = __DIR__ . '/../enquiries.csv';   // outside public_html where possible

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'bad_request']);
    exit;
}

function field(array $d, string $k, int $max = 400): string {
    $v = isset($d[$k]) ? (is_array($d[$k]) ? implode(', ', $d[$k]) : (string) $d[$k]) : '';
    $v = trim(preg_replace('/[\r\n]+/', ' ', $v));
    return mb_substr($v, 0, $max);
}

$first   = field($data, 'firstName', 80);
$last    = field($data, 'lastName', 80);
$email   = field($data, 'email', 160);
$phone   = field($data, 'phone', 40);
$country = field($data, 'country', 80);
$timing  = field($data, 'timing', 80);
$treat   = field($data, 'treatments', 400);
$message = field($data, 'message', 4000);
$page    = field($data, 'page', 200);

if ($first === '' || $email === '' || $phone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'validation_failed']);
    exit;
}

/* 1. never lose the lead --------------------------------------------------- */
$row = [gmdate('c'), $first, $last, $email, $phone, $country, $treat, $timing, $message, $page,
        $_SERVER['REMOTE_ADDR'] ?? ''];
$fh = @fopen($LOG, 'a');
if ($fh !== false) {
    @flock($fh, LOCK_EX);
    @fputcsv($fh, $row);
    @flock($fh, LOCK_UN);
    @fclose($fh);
}

/* 2. notify the coordinator ------------------------------------------------ */
$subject = sprintf('Website enquiry — %s %s (%s)', $first, $last, $country);
$body = "New enquiry from veahealthturkey.com\n\n"
      . "Name:       $first $last\n"
      . "Email:      $email\n"
      . "Phone:      $phone\n"
      . "Country:    $country\n"
      . "Treatments: $treat\n"
      . "Timing:     $timing\n"
      . "Page:       $page\n\n"
      . "Message:\n$message\n";

$headers  = "From: VeaHealth Website <$FROM>\r\n";
$headers .= "Reply-To: $first $last <$email>\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$sent = @mail($TO, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

echo json_encode(['ok' => true, 'mailed' => (bool) $sent]);
"""


# ===========================================================================
def main():
    if os.path.isdir(OUT):
        for name in os.listdir(OUT):
            if name == "assets":
                continue
            p = os.path.join(OUT, name)
            shutil.rmtree(p) if os.path.isdir(p) else os.remove(p)
    os.makedirs(OUT, exist_ok=True)

    print("building pages …")

    # ---- home -------------------------------------------------------------
    write("index.html", document(
        "/",
        "Dental Implants & Hair Transplant in Istanbul – VeaHealth Turkey",
        "VeaHealth coordinates dental and hair restoration treatment in Istanbul: written treatment "
        "plan and fixed price before you travel, airport transfers and hotel arranged, English-speaking "
        "coordinator, aftercare once you are home.",
        P.home(),
        schema=schema_graph(url("/"), "WebPage",
                            "Dental Implants & Hair Transplant in Istanbul – VeaHealth Turkey",
                            "Medical travel to Istanbul for dental and hair restoration, coordinated end to end.",
                            [("Home", None)]),
        preload="/assets/img/art/hero-istanbul-bosphorus-1600.webp",
        og_image="/assets/img/art/hero-istanbul-bosphorus-1600.webp",
        current="/"), priority="1.0")

    # ---- top-level pages --------------------------------------------------
    simple = [
        ("/services/", "All Treatments – Dental & Hair Restoration in Istanbul | VeaHealth Turkey",
         "Twenty-one dental and hair restoration treatments in Istanbul, each documented with "
         "technique, procedure, recovery timeline, published evidence and price.",
         P.services_hub(), "0.9"),
        ("/before-after/", "Before & After Results – Real VeaHealth Patients in Istanbul",
         "Before and after photographs of VeaHealth patients treated in Istanbul, with a drag-to-compare "
         "slider. Real clinic photography, published with patient permission.",
         P.before_after(), "0.8"),
        ("/gallery/", "Clinic & Facilities in Istanbul – VeaHealth Turkey",
         "Photographs and film from the VeaHealth partner clinic in Istanbul: treatment rooms, "
         "laboratory and patient areas.",
         P.gallery(), "0.7"),
        ("/journey/", "The Patient Journey – Medical Travel to Istanbul | VeaHealth",
         "How treatment in Istanbul actually works: remote assessment, written quote, airport transfer, "
         "hotel, treatment and aftercare once you are home.",
         P.journey(), "0.8"),
        ("/about/", "About VeaHealth – Medical Tourism Coordinator in Istanbul",
         "VeaHealth is a medical tourism coordinator in Istanbul working with licensed partner clinics. "
         "What we do, what we do not do, and the questions worth asking any coordinator.",
         P.about(), "0.7"),
        ("/contact/", "Free Assessment & Quote – Contact VeaHealth Istanbul",
         "Send photographs and any recent X-rays for a free assessment. A partner dentist returns an "
         "itemised treatment plan with a fixed price, in writing.",
         P.contact(), "0.9"),
        ("/blog/", "Journal – Notes on Dental Treatment & Medical Travel | VeaHealth",
         "Articles for patients deciding whether to travel for dental or hair treatment, and what to "
         "ask when they get there.",
         P.blog_index(), "0.6"),
        ("/privacy-policy/", "Privacy Policy – VeaHealth Turkey",
         "What VeaHealth collects when you enquire, why, how long it is kept, and how to have it deleted.",
         P.privacy(), "0.3"),
        ("/cookie-policy/", "Cookie Policy – VeaHealth Turkey",
         "Which cookies this site sets, which wait for your consent, and how to change your choice.",
         P.cookies(), "0.3"),
        ("/terms/", "Terms of Use – VeaHealth Turkey",
         "What VeaHealth is, the limits of the information published here, and how prices and warranties work.",
         P.terms(), "0.3"),
    ]
    for path, title, desc, body, pri in simple:
        write(path + "index.html",
              document(path, title, desc, body, current=path), priority=pri)
        print("  ", path)

    # ---- 404 --------------------------------------------------------------
    write("404.html", document("/404.html", "Page not found – VeaHealth Turkey",
                               "That page is not here. The treatment guides, patient results and contact "
                               "form are one click away.",
                               P.not_found(), robots="noindex, follow"), sitemap=False)

    # ---- treatments -------------------------------------------------------
    ok = new = 0
    for s in SERVICES:
        if s.get("src"):
            if build_salvaged_service(s):
                ok += 1
                print("   /services/%s/  (salvaged)" % s["slug"])
        else:
            build_new_service(s)
            new += 1
            print("   /services/%s/  (new)" % s["slug"])

    # ---- blog -------------------------------------------------------------
    for p in POSTS:
        build_post(p)
        print("   /blog/%s/" % p["slug"])

    # ---- supporting files -------------------------------------------------
    build_sitemap()
    build_robots()
    write(".htaccess", HTACCESS, sitemap=False)
    write("send.php", SEND_PHP, sitemap=False)

    print("\n%d salvaged treatment pages, %d new treatment pages, %d URLs in the sitemap"
          % (ok, new, len(set(p for p, _ in WRITTEN))))
    print("output: %s" % OUT)


if __name__ == "__main__":
    main()
