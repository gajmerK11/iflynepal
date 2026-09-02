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

A classic theme: plain PHP templates and template-parts. Front-page sections
(hero, Explore Cards) are fixed markup in template-parts/home/, and editable
copy lives in Appearance > Customize.

The hero's trip planner search bar is not built. Its design was removed while
how to implement it is decided; the previous markup is in git history at
template-parts/home/trip-planner.php.

Companion plugin (not built yet): once built, iFly Nepal Trips will register
the trip post type and the taxonomies the planner will search. The theme
displays that content; the plugin will own it, so it survives a theme switch.

== Setup ==

1. Appearance > Menus — create a menu, assign it to Primary. Add "Plan My Trip"
   as a menu item and give it the CSS class `nav-cta` (Screen Options > CSS
   Classes) to render it as the pill button.
2. Appearance > Customize > Site Identity — upload the logo.
3. Appearance > Customize > Homepage > Hero — set the headline, the two button
   labels and links, the trust points, and upload the background image and
   (optional) background video. The background image must be landscape and at
   least 1920x1080; anything smaller is refused. With no image uploaded the
   hero falls back to its own dark ground.
4. Nothing to set in Settings > Reading — front-page.php always renders the
   homepage (hero and Explore Cards sections) regardless of that setting, no
   page content needed.
5. Add a screenshot.png (1200x900) once the hero renders with real footage.

== Front-page sections ==

template-parts/home/hero-section.php and explore-section.php are plain PHP —
editing them updates every page immediately. Markup uses the
`wp-block-cover`/`wp-block-columns`-family CSS classes as plain CSS/JS hooks
for assets/css/main.css and the section's script under assets/js/homepage/.

Scripts are filed by the design section they belong to, front-end and
Customizer alike:

    assets/js/homepage/hero/          hero.js          front-end motion
                                      repeater.js      Customizer control
                                      trust-points.js  Customizer control
                                      background-image.js  Customizer control
    assets/js/homepage/hero/explore/  reveal.js        front-end motion
    assets/js/header/                 navigation.js
    assets/js/vendor/                 GSAP and ScrollTrigger

Note that Explore is its own top-level <section>, a sibling of the hero rather
than a child of it; its script is nested under hero/ by project convention, not
because the markup nests.

Motion: GSAP loads only on pages that animate. inc/enqueue.php checks
iflynepal_has_hero()/iflynepal_has_explore() (both true on the front page only)
and loads the library plus the two section scripts accordingly. Both are pure
enhancement — nothing is hidden in the stylesheet, so each section renders
finished with JavaScript off or reduced motion on.

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

No other third-party code or services are bundled. The hero ships with no
background image at all — it is uploaded under Appearance > Customize >
Homepage > Hero. The Explore cards still point at two Unsplash URLs as
stand-ins until the client's photography lands; replace them in
template-parts/home/explore-section.php.

== Changelog ==

= 1.0.0 =
* Initial build: site header, hero section.
