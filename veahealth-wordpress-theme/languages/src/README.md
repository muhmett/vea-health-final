# Interface translation sources

`languages/{fr_FR,ar,es_ES}.mo` are compiled binaries. These are what they are
compiled from — without them the catalogue is not maintainable, because a `.mo`
is not a file anybody can correct by hand.

Rebuild with:

    python3 build.py

from this directory. It writes the three `.mo` files one level up and prints
the entry count for each, which should be the same for all three.

## What is in which file

`ui1.py`, `ui2.py`, `ui3.py` and `ui4.py` each hold a plain dictionary keyed by
the English string, with a three-tuple of translations in the order French,
Arabic, Spanish. The split between them is only how the work was done in
batches; the builder merges them and a later file wins on a repeated key.

`plurals.py` holds the entries that need plural forms, as `(singular, plural)`
keys. Arabic has six plural forms and the builder writes all six, so an Arabic
entry gives six strings where French and Spanish give two.

`mo.py` writes the binary. It is the GNU `.mo` format, hand-rolled so the build
needs nothing installed beyond Python.

## What does not belong here

Page titles, treatment names and article prose. Those are content, not
interface, and they live in `inc/pages-i18n.php`, `inc/services-i18n/` and
`inc/articles-i18n/` where a translator can see them in context. A string
belongs here when it is chrome the templates print — a button, a label, a
heading that is the same on every page.

One consequence worth knowing: "Journal" is here, because it is the eyebrow
printed above the journal index and its category archives. It is also the title
of the journal page in `inc/pages-i18n.php`. If you change one, change the
other, or the navigation label and the page heading will disagree.
