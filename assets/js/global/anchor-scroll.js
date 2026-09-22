/**
 * Smooth in-page anchor scrolling, site-wide.
 *
 * Two shapes of fragment link share this one file:
 *
 * - `<a href="#id">` — older markup, or anywhere outside a stored link field,
 *   that still needs to keep working with JavaScript off. The browser's own
 *   jump is a single-frame snap; this adds the glide on top of it.
 * - `<a data-iflynepal-scroll="id" role="button" tabindex="0">` — what
 *   iflynepal_anchor_attr() / iflynepal_booking_anchor_attr() print for any
 *   stored link field that holds a hash instead of a URL. Those carry no
 *   `href` at all, on purpose: a hash `href` always shows the resolved target
 *   in the browser's status bar on hover, which is exactly what a CTA typed
 *   as `#id` in the admin used to reveal before anyone clicked it. Without an
 *   `href` there is nothing to preview and nothing to navigate to, so this
 *   script is the only thing that makes the element do anything — the
 *   trade-off accepted for losing the hover preview.
 *
 * Delegated on `document` rather than bound per element, so a section built
 * later (a new CTA, a new archive band) gets the same behaviour for free with
 * no enqueue change and no class to remember to add. A bare `href="#"`
 * (menus/accordions that use it as a no-op) and a hash with no matching
 * element on the page (an off-page link ending in `#pricing` for a page that
 * has no such id) are both left to the browser or to whatever other script
 * owns them.
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

	function scrollToHash( hash ) {
		if ( ! hash || hash.length < 2 ) {
			return false;
		}

		var target;

		try {
			target = document.querySelector( hash );
		} catch ( error ) {
			// An id that isn't valid CSS (rare, but not worth a thrown error).
			return false;
		}

		if ( ! target ) {
			return false;
		}

		target.scrollIntoView( {
			behavior: reduced ? 'auto' : 'smooth',
			block: 'start'
		} );

		return true;
	}

	document.addEventListener( 'click', function ( event ) {
		var scrollTrigger = event.target.closest( '[data-iflynepal-scroll]' );

		if ( scrollTrigger ) {
			if ( scrollToHash( '#' + scrollTrigger.getAttribute( 'data-iflynepal-scroll' ) ) ) {
				event.preventDefault();
			}

			return;
		}

		var link = event.target.closest( 'a[href^="#"]' );

		if ( ! link ) {
			return;
		}

		if ( scrollToHash( link.getAttribute( 'href' ) ) ) {
			event.preventDefault();
		}
	} );

	// data-iflynepal-scroll elements carry no href, so they need Enter/Space
	// handled explicitly — a real <a> gets that from the browser for free.
	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Enter' !== event.key && ' ' !== event.key && 'Spacebar' !== event.key ) {
			return;
		}

		var scrollTrigger = event.target.closest( '[data-iflynepal-scroll]' );

		if ( ! scrollTrigger ) {
			return;
		}

		if ( scrollToHash( '#' + scrollTrigger.getAttribute( 'data-iflynepal-scroll' ) ) ) {
			event.preventDefault();
		}
	} );
}() );
