# -*- coding: utf-8 -*-
"""Write a gettext .mo. msgfmt is not on this box, and the format is small
enough to emit directly — a header, two tables of (length, offset), then the
strings themselves, sorted by msgid because that is what the reader assumes."""
import struct

def write_mo(path, entries, meta):
    """entries: list of (msgid, msgstr) where a plural entry uses \\x00 joins."""
    items = [('', meta)] + sorted(entries, key=lambda e: e[0].encode('utf-8'))
    ids = b''; strs = b''; offs = []
    for mid, mstr in items:
        b_id, b_str = mid.encode('utf-8'), mstr.encode('utf-8')
        offs.append((len(ids), len(b_id), len(strs), len(b_str)))
        ids  += b_id  + b'\x00'
        strs += b_str + b'\x00'

    n = len(items)
    keystart = 7 * 4 + 16 * n
    valstart = keystart + len(ids)
    koffs, voffs = [], []
    for o1, l1, o2, l2 in offs:
        koffs += [l1, o1 + keystart]
        voffs += [l2, o2 + valstart]

    out = struct.pack('Iiiiiii', 0x950412de, 0, n, 7 * 4, 7 * 4 + n * 8, 0, 0)
    out += struct.pack('i' * len(koffs), *koffs)
    out += struct.pack('i' * len(voffs), *voffs)
    out += ids + strs
    open(path, 'wb').write(out)
    return n

PLURAL = {
  'fr_FR': 'nplurals=2; plural=(n > 1);',
  'es_ES': 'nplurals=2; plural=(n != 1);',
  'ar':    'nplurals=6; plural=(n==0 ? 0 : n==1 ? 1 : n==2 ? 2 : '
           'n%100>=3 && n%100<=10 ? 3 : n%100>=11 ? 4 : 5);',
}

def header(locale):
    return ('Project-Id-Version: VeaHealth\n'
            'MIME-Version: 1.0\n'
            'Content-Type: text/plain; charset=UTF-8\n'
            'Content-Transfer-Encoding: 8bit\n'
            'Language: %s\n'
            'Plural-Forms: %s\n' % (locale, PLURAL[locale]))
