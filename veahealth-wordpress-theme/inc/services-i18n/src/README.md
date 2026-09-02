# Treatment translation sources

`inc/services-i18n/{fr,ar,es}.php` are generated. These are what they are
generated from: one Python file per treatment holding `META` (title, slug,
search description and the schema fields) and `T` (every prose string in that
treatment, keyed by the English it replaces), plus `_shared.py` for phrases
that belong to no single treatment — recovery phase labels, day tags, and the
questions asked on a dozen pages.

Rebuild with:

    python3 svcbuild.py ..

from this directory. The builder merges every file, warns when two treatments
translate the same English string two different ways, and writes the three PHP
files.

Two rules the files follow:

Academic citations stay as they are. "Chen & Buser (2009) · ITI Consensus
Statements" is author names, a year and a journal; translating it would be
inventing a source. Prices, percentages and figures likewise — anything with
no letter in it is dropped before the count is taken.

The Arabic uses the vocabulary fixed in `inc/glossary.php`, which is not a
style preference. A graft is a طُعم and never a بُصيلة: a graft carries one to
four hairs, so calling four thousand grafts four thousand follicles tells a
patient something untrue about what is going into his head.
