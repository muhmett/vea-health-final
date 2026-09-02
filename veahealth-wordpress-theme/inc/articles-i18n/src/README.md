# Journal translation sources

`inc/articles-i18n/{fr,ar,es}.php` are generated. These are what they are
generated from: one Python file per article holding `META` (title, slug,
excerpt, dek and the key takeaways) and `BODY` (the whole translated article,
as HTML) for each of the three languages.

Rebuild with:

    python3 artbuild.py

from this directory. It writes the three PHP files one level up.

`php artdump.php <slug>` prints the English article as plain text, which is
what to translate from — the rendered page adds chrome that does not belong in
the stored body.

## Why the body is stored whole, and the treatments are not

`inc/services-i18n/` keys its translations by the English string, because the
same sentence appears on a dozen treatment pages and a change should reach all
of them. An article's prose appears once. Keying it would buy nothing and
would break a paragraph into fragments a translator cannot see the shape of,
so the body is stored as one piece of HTML.

## Two things the builder does for you

Treatment cross-links are rewritten at build time: a body may link to
`%VH_HOME%/services/single-dental-implants/` in any language and the builder
substitutes that language's treatment slug, read from
`inc/services-i18n/<lang>.php`. Nobody has to keep eighty-four slugs in their
head, and a renamed treatment slug propagates on the next rebuild.

`%VH_HOME%` itself is replaced with the site's home URL at render time, so the
stored HTML carries no domain.

## Rules the translations follow

The HTML structure must match the English body exactly — the same tags in the
same order, and the same heading `id` attributes. The ids are the anchor
targets the table of contents links to, so they stay in English; only the
heading text is translated. `php check.php` verifies that, plus that every
article is present with every field filled, that no two articles in a language
share a slug, and that every treatment cross-link resolves. Run it after every
rebuild.

Brand names, protocol names and acronyms stay as they are: Straumann, e.max,
DHI, CBCT, JCI, USHAŞ, All-on-4. Translating them would make a patient unable
to match what he reads here against what a clinic writes in its quote.

Nothing is added that is not in the English. Where the English declines to
give a figure, so does the translation.

The Arabic uses the vocabulary fixed in `inc/glossary.php` — the same
graft/follicle distinction the treatment pages hold to.
