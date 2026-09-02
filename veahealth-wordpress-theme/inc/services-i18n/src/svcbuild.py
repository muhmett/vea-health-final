# -*- coding: utf-8 -*-
"""Compile inc/services-i18n/{fr,ar,es}.php from /tmp/tr/svc/<slug>.py.

One file per language rather than per treatment: the sync loads a language
once and looks every string up in it, and a phrase shared by eleven treatments
is stored once.
"""
import os, glob, importlib.util, json, sys

SRC = '/tmp/tr/svc'
OUT = sys.argv[1] if len(sys.argv) > 1 else '.'
LANGS = ['fr', 'ar', 'es']
COL = {'fr': 0, 'ar': 1, 'es': 2}

GROUPS = {
 'Oral surgery & implants': ('Chirurgie orale et implants', 'جراحة الفم والزراعة', 'Cirugía oral e implantes'),
 'Crowns & veneers':        ('Couronnes et facettes',       'التلبيسات والفينير',  'Coronas y carillas'),
 'Hair restoration':        ('Restauration capillaire',     'زراعة الشعر',          'Restauración capilar'),
}

def load(path):
    name = os.path.basename(path)[:-3]
    spec = importlib.util.spec_from_file_location('svc_' + name.replace('-', '_'), path)
    m = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(m)
    return name, m

mods = [load(p) for p in sorted(glob.glob(os.path.join(SRC, '*.py')))]

def php(s):
    return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"

for lang in LANGS:
    i = COL[lang]
    strings, meta, clash = {}, {}, []
    for slug, m in mods:
        for en, forms in m.T.items():
            tr = forms[i]
            if not tr:
                continue
            if en in strings and strings[en] != tr:
                clash.append((slug, en, strings[en], tr))
            strings[en] = tr
        if hasattr(m, 'META') and lang in m.META:
            meta[slug] = m.META[lang]
    if clash:
        print('  !! %s: %d strings translated two different ways' % (lang, len(clash)))
        for c in clash[:5]:
            print('     %s: %r\n       A %r\n       B %r' % (c[0], c[1][:60], c[2][:60], c[3][:60]))

    lines = ["<?php", "/**", " * Treatment translations: %s." % lang, " *", 
             " * Generated. Keyed by the English string each one replaces; see", 
             " * inc/services-i18n.php for how they are used.", " *",
             " * @package VeaHealth", " */", "",
             "if ( ! defined( 'ABSPATH' ) ) {", "\texit;", "}", "", "return array(", "",
             "\t'groups' => array("]
    for en, forms in GROUPS.items():
        lines.append("\t\t%s => %s," % (php(en), php(forms[i])))
    lines += ["\t),", "", "\t'meta' => array("]
    for slug in sorted(meta):
        lines.append("\t\t%s => array(" % php(slug))
        for k in ('title', 'slug', 'seo_title', 'excerpt', 'alt', 'procedure_type',
                  'body_location', 'how_performed', 'preparation', 'followup'):
            if meta[slug].get(k):
                lines.append("\t\t\t%-18s => %s," % ("'" + k + "'", php(meta[slug][k])))
        lines.append("\t\t),")
    lines += ["\t),", "", "\t'strings' => array("]
    for en in sorted(strings, key=lambda x: (len(x), x)):
        lines.append("\t\t%s => %s," % (php(en), php(strings[en])))
    lines += ["\t),", ");"]

    path = os.path.join(OUT, lang + '.php')
    open(path, 'w', encoding='utf-8').write("\n".join(lines) + "\n")
    print('%s  %d strings  %d treatments  %d KB' % (lang, len(strings), len(meta), os.path.getsize(path) // 1024))
