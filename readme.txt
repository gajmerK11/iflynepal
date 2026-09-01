=== iFly Nepal ===

Contributors: iflynepal
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom theme for iFly Nepal — Nepal tours, treks and retreats.

== Description ==

A classic theme: plain PHP templates and template-parts, no block editor, no
theme.json. Front-page sections (hero, Explore Cards) are fixed markup in
template-parts/home/, editable copy lives in Appearance > Customize, and the
trip planner search bar is its own template-part.

Companion plugin (not built yet): once built, iFly Nepal Trips will register
the trip post type and the three taxonomies the hero's trip planner searches.
The theme displays that content; the plugin will own it, so it survives a
theme switch. Until then, template-parts/home/trip-planner.php renders only
its submit button, since its taxonomies don't exist.

== Setup ==

1. Appearance > Menus — create a menu, assign it to Primary. Add "Plan My Trip"
   as a menu item and give it the CSS class `nav-cta` (Screen Options > CSS
   Classes) to render it as the pill button.
2. Appearance > Customize > Site Identity — upload the logo.
3. Appearance > Customize > Hero Background — set the still image, video URL,
   poster and (optional) fallback video URL.
4. Settings > Reading — set a static front page; front-page.php renders the
   hero and Explore Cards sections automatically, no page content needed.
5. Add a screenshot.png (1200x900) once the hero renders with real footage.

== Front-page sections ==

template-parts/home/hero-section.php and explore-section.php are plain PHP —
editing them updates every page immediately, unlike a block pattern that would
need re-inserting. Markup keeps the `wp-block-cover`/`wp-block-columns`-family
CSS classes from the theme's original block-based build so assets/css/main.css
and assets/js/{hero,reveal}.js needed no changes when the block editor was
removed — those classes are just CSS/JS hooks now, not evidence of one.

Motion: GSAP loads only on pages that animate. inc/enqueue.php checks
ifn_has_hero()/ifn_has_explore() (both true on the front page only) and loads
the library plus assets/js/hero.js and assets/js/reveal.js accordingly. Both
scripts are pure enhancement — nothing is hidden in the stylesheet, so each
section renders finished with JavaScript off or reduced motion on.

== Build ==

    npm install
    npm run build        # Tailwind stylesheet
    npm run watch:css    # Tailwind in watch mode

The compiled asset (assets/css/main.css) is committed, so the theme runs
without a build step on the server.

== Bundled resources ==

GSAP 3.15.0 and the ScrollTrigger plugin — https://gsap.com
  assets/js/vendor/gsap.min.js
  assets/js/vendor/ScrollTrigger.min.js
  Copyright GreenSock. Used under the GreenSock Standard "No Charge" License:
  https://gsap.com/standard-license
  NOTE: this license is not GPL-compatible. It permits use in a site like this
  one at no charge, but it makes the theme ineligible for the WordPress.org
  theme directory as bundled. Remove GSAP before any directory submission.

Poppins, Cormorant Garamond and Caveat — https://fonts.google.com
  assets/fonts/*.woff2
  Copyright the Indian Type Foundry, Catharsis Fonts and Impallari Type
  respectively. Licensed under the SIL Open Font License 1.1:
  https://scripts.sil.org/OFL
  Latin subsets only, self-hosted. No font CDN is contacted.

No other third-party code, images or services are bundled. The theme itself
makes no external request; the hero still image ships pointing at an Unsplash
URL as a placeholder, and is replaced under Appearance > Customize > Hero
Background with a media-library image once the client's photograph is in.

== Changelog ==

= 1.0.0 =
* Initial build: site header, hero section, trip planner search bar.
