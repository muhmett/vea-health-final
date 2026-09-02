# -*- coding: utf-8 -*-
"""Compile inc/articles-i18n/{fr,ar,es}.php from <slug>.py in this directory.

Each source file holds META (title, slug, excerpt, dek, keys) and BODY (the
translated HTML) per language. Links to treatment pages inside the body are
rewritten to that language's treatment slug here, so no translator has to keep
84 slugs in their head.
"""
import os, re, glob, importlib.util, sys, subprocess, json

SRC = os.path.dirname(os.path.abspath(__file__))
# Default relative to this file, not to wherever it was invoked from.
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(SRC, os.pardir)
LANGS = ['fr', 'ar', 'es']

CATS = {
 'Costs and money': (
   ('Coûts et argent', "Ce qu’un traitement à l’étranger coûte réellement, poste par poste, et d’où vient l’économie."),
   ('التكاليف والمال', 'ما يكلّفه العلاج في الخارج فعلاً، بنداً بنداً، ومن أين يأتي التوفير.'),
   ('Costes y dinero', 'Lo que cuesta realmente un tratamiento en el extranjero, partida por partida, y de dónde sale el ahorro.')),
 'Safety and choosing a clinic': (
   ('Sécurité et choix de la clinique', "Comment vérifier une clinique avant d’envoyer un acompte, et que faire si quelque chose tourne mal."),
   ('السلامة واختيار العيادة', 'كيف تتحقّق من عيادة قبل أن ترسل عربوناً، وماذا تفعل إن ساءت الأمور.'),
   ('Seguridad y elección de clínica', 'Cómo comprobar una clínica antes de enviar una señal y qué hacer si algo sale mal.')),
 'Choosing a treatment': (
   ('Choisir son traitement', "Les comparaisons que les gens font avant de décider, répondues sans argumentaire de vente."),
   ('اختيار العلاج', 'المقارنات التي يعقدها الناس قبل أن يقرّروا، مجابة دون خطاب بيع.'),
   ('Elegir tratamiento', 'Las comparaciones que la gente hace antes de decidir, respondidas sin discurso de venta.')),
 'Planning your trip': (
   ('Préparer le voyage', "Dates, vols, bagages et Istanbul elle-même, du point de vue d’un patient."),
   ('التخطيط لرحلتك', 'المواعيد والرحلات والأمتعة وإسطنبول نفسها، من وجهة نظر مريض.'),
   ('Planificar el viaje', 'Fechas, vuelos, equipaje y la propia Estambul, desde el punto de vista de un paciente.')),
 'Recovery and aftercare': (
   ('Récupération et suivi', "À quoi ressemblent vraiment les semaines et les mois qui suivent le traitement."),
   ('التعافي والمتابعة', 'كيف تبدو فعلاً الأسابيع والأشهر التي تلي العلاج.'),
   ('Recuperación y seguimiento', 'Cómo son realmente las semanas y los meses posteriores al tratamiento.')),
}

def service_slugs():
    """English treatment slug -> {lang: translated slug}, read from the built PHP."""
    out = {}
    for i, lang in enumerate(LANGS):
        path = os.path.join(OUT, '..', 'services-i18n', lang + '.php')
        # The generated files guard on ABSPATH and exit silently without it.
        php = ('define("ABSPATH",1); $d = include %r; '
               'foreach ($d["meta"] as $k => $v) echo $k, "\\t", $v["slug"], "\\n";'
               % os.path.abspath(path))
        res = subprocess.run(['php', '-r', php], capture_output=True, text=True)
        for line in res.stdout.strip().split('\n'):
            if not line.strip():
                continue
            en, tr = line.split('\t')
            out.setdefault(en, {})[lang] = tr
    return out

SVC = service_slugs()

def relink(html, lang):
    """Point treatment cross-links at that language's slug."""
    def sub(m):
        en = m.group(1)
        tr = SVC.get(en, {}).get(lang)
        return '%%VH_HOME%%/services/%s/' % (tr or en)
    return re.sub(r'%VH_HOME%/services/([a-z0-9-]+)/', sub, html)

def load(path):
    name = os.path.basename(path)[:-3]
    spec = importlib.util.spec_from_file_location('art_' + name.replace('-', '_'), path)
    m = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(m)
    return name, m

mods = [load(p) for p in sorted(glob.glob(os.path.join(SRC, '*.py')))
        if os.path.basename(p) != os.path.basename(__file__)]

def php(s):
    return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"

for i, lang in enumerate(LANGS):
    lines = ["<?php", "/**", " * Journal translations: %s." % lang, " *",
             " * Generated. See inc/articles-i18n.php for how they are used, and",
             " * inc/articles-i18n/src/ for what they are generated from.", " *",
             " * @package VeaHealth", " */", "",
             "if ( ! defined( 'ABSPATH' ) ) {", "\texit;", "}", "", "return array(", "",
             "\t'cats' => array("]
    for en, forms in CATS.items():
        name, desc = forms[i]
        lines.append("\t\t%s => array( 'name' => %s, 'description' => %s )," % (php(en), php(name), php(desc)))
    lines += ["\t),", "", "\t'posts' => array("]

    n = 0
    for slug, m in mods:
        if lang not in m.META:
            continue
        meta = m.META[lang]
        body = relink(m.BODY[lang].strip(), lang)
        assert '$' not in body, slug
        lines.append("\t\t%s => array(" % php(slug))
        for k in ('title', 'slug', 'excerpt', 'dek'):
            if meta.get(k):
                lines.append("\t\t\t%-11s => %s," % ("'" + k + "'", php(meta[k])))
        if meta.get('keys'):
            lines.append("\t\t\t'keys'      => array(")
            for k in meta['keys']:
                lines.append("\t\t\t\t%s," % php(k))
            lines.append("\t\t\t),")
        tag = 'VH_ART_%d' % n; n += 1
        lines.append("\t\t\t'content'   => <<<'%s'\n%s\n%s," % (tag, body, tag))
        lines.append("\t\t),")
    lines += ["\t),", ");"]

    path = os.path.join(OUT, lang + '.php')
    open(path, 'w', encoding='utf-8').write("\n".join(lines) + "\n")
    print('%s  %d articles  %d KB' % (lang, n, os.path.getsize(path) // 1024))
