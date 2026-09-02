# -*- coding: utf-8 -*-
"""Compile languages/{fr_FR,ar,es_ES}.mo from the four translation sources."""
import sys, os
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from mo import write_mo, header
import ui1, ui2, ui3, plurals

try:
    import ui4
    EXTRA = ui4.T
except ImportError:
    EXTRA = {}

LOCALES = ['fr_FR', 'ar', 'es_ES']
COL = {'fr_FR': 0, 'ar': 1, 'es_ES': 2}
# Default relative to this file, not to wherever it was invoked from.
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(os.path.dirname(os.path.abspath(__file__)), os.pardir)

singles = {}
for src in (ui1.T, ui2.T, ui3.T, EXTRA):
    for k, v in src.items():
        singles[k] = v

for loc in LOCALES:
    i = COL[loc]
    entries = []
    skip = set(one for one, many in plurals.P)
    for msgid, forms in singles.items():
        if msgid in skip:
            continue                      # carried by the plural entry instead
        s = forms[i]
        if s:
            entries.append((msgid, s))
    for (one, many), by in plurals.P.items():
        entries.append((one + '\x00' + many, '\x00'.join(by[loc])))
    n = write_mo(os.path.join(OUT, loc + '.mo'), entries, header(loc))
    print(loc, n, 'entries')
