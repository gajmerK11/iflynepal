# Fonts

Self-hosted Latin subsets, declared at the top of `assets/css/input.css`. No
font CDN is used, so the theme makes no third-party request to render type.

| File | Used by |
|---|---|
| `poppins-400.woff2` | body copy |
| `poppins-500.woff2` | the hero headline |
| `poppins-700.woff2` | trust bullets, planner dropdowns |
| `poppins-800.woff2` | buttons, planner field labels |
| `cormorant-garamond-italic-600.woff2` | the headline's accent word |
| `caveat-600.woff2` | the Explore section's handwritten kicker |

Poppins 500 and the Cormorant face are preloaded from `inc/enqueue.php` because
both paint the headline, which is the largest text on the page. The rest load
under `font-display: swap`.

The navigation deliberately stays on the system UI stack — that is the design,
not an omission.

Caveat is not preloaded: it carries four words below the fold and its Latin
subset is 51 KB, by far the heaviest face here. Under `font-display: swap` the
kicker renders in the fallback script stack first and reflows once. If that
reflow ever reads badly, subset the file to the exact glyphs in that string
rather than preloading 51 KB.

All three families are licensed under the SIL Open Font License 1.1. To refresh or
add a weight, pull the Latin subset from Google Fonts, drop the `.woff2` here,
add an `@font-face` block to `input.css`, and run `npm run build:css`.
