/**
 * Keeps the Team page's section leads ("Global Representatives" and
 * "Executive Team") on one line at wide viewports without ever overflowing
 * their head.
 *
 * The CSS forces `white-space: nowrap` on `.iflynepal-team-section__lead`
 * from 900px up, sized against the English copy. A translation can run
 * longer than the English original and overflow the 860px head it sits in —
 * the paragraph still centers on its own box, but that box is now wider than
 * its container, which reads as off-centre on the page. Same technique as
 * the booking plugin's mapTitleFit()/fitFacetsTitle(): shrink the font until
 * it fits on one line, and fall back to an ordinary wrap if it still does not
 * fit at the floor size.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */
( function () {
	'use strict';

	var MIN_FONT_SIZE = 14;

	function fit( lead ) {
		lead.style.removeProperty( 'font-size' );
		lead.style.removeProperty( 'white-space' );

		if ( ! window.matchMedia( '(min-width: 900px)' ).matches ) {
			return;
		}

		lead.style.whiteSpace = 'nowrap';

		var fontSize = parseFloat( getComputedStyle( lead ).fontSize );

		while ( lead.scrollWidth > lead.clientWidth && fontSize > MIN_FONT_SIZE ) {
			fontSize -= 1;
			lead.style.setProperty( 'font-size', fontSize + 'px' );
		}

		// Still too long at the floor size: an ordinary wrap reads better
		// than a font shrunk unreadably small or text bleeding past its head.
		// Wrapping removes the overflow on its own, so the shrink is undone
		// too — otherwise a wrapped line would be stuck at the floor size for
		// no reason.
		if ( lead.scrollWidth > lead.clientWidth ) {
			lead.style.whiteSpace = 'normal';
			lead.style.removeProperty( 'font-size' );
		}
	}

	function fitAll() {
		document.querySelectorAll( '.iflynepal-team-section__lead' ).forEach( fit );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', fitAll );
	} else {
		fitAll();
	}

	var resizeTimer;

	window.addEventListener( 'resize', function () {
		clearTimeout( resizeTimer );
		resizeTimer = setTimeout( fitAll, 150 );
	} );
} )();
