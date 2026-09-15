/**
 * Smooth in-page anchor scrolling, site-wide.
 *
 * Every fragment link on the site — the hero's "Explore Nepal" button, the
 * closing CTA, the trust-band promo, the hero/team/contact/legal scroll
 * pills, any future one — starts as a plain `<a href="#id">`, so the page
 * still navigates correctly with JavaScript off. This is the one enhancement
 * that adds the glide: without it the browser jumps the page in a single
 * frame, which is the "sudden snap" a fragment link otherwise always does.
 *
 * Delegated on `document` rather than bound per element, so a section built
 * later (a new CTA, a new archive band) gets the same glide for free with no
 * enqueue change and no class to remember to add. Only true in-page anchors
 * are touched: a bare `href="#"` (menus/accordions that use it as a no-op)
 * and a hash with no matching element on the page (an off-page link ending
 * in `#pricing` for a page that has no such id) are both left to the browser
 * or to whatever other script owns them.
 *
 * scrollIntoView honours the target's own scroll-margin-top, so the section
 * clears the fixed header without any offset arithmetic here.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	document.addEventListener( 'click', function ( event ) {
		var link = event.target.closest( 'a[href^="#"]' );

		if ( ! link ) {
			return;
		}

		var hash = link.getAttribute( 'href' );

		// A bare "#" is a JS hook (menu toggle, accordion), not a scroll target.
		if ( hash.length < 2 ) {
			return;
		}

		var target;

		try {
			target = document.querySelector( hash );
		} catch ( error ) {
			// An id that isn't valid CSS (rare, but not worth a thrown error).
			return;
		}

		if ( ! target ) {
			return;
		}

		event.preventDefault();
		target.scrollIntoView( {
			behavior: reduced ? 'auto' : 'smooth',
			block: 'start'
		} );
	} );
}() );
