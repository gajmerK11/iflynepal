/**
 * Section reveals for the FAQ / Travel Guide section.
 *
 * The two columns rise into place as they are scrolled to, on the same
 * parameters as every other reveal on the page.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-guides' );

	if ( ! section ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	if ( reduced || typeof window.gsap === 'undefined' || ! window.ScrollTrigger ) {
		return;
	}

	var gsap = window.gsap;
	var ScrollTrigger = window.ScrollTrigger;

	gsap.registerPlugin( ScrollTrigger );

	var reveals = Array.prototype.slice.call(
		section.querySelectorAll( '[data-iflynepal-reveal]' )
	);

	if ( ! reveals.length ) {
		return;
	}

	gsap.set( reveals, { opacity: 0, y: 26 } );

	ScrollTrigger.batch( reveals, {
		start: 'top 88%',
		once: true,
		interval: 0.12,
		batchMax: 6,
		onEnter: function ( batch ) {
			gsap.to( batch, {
				opacity: 1,
				y: 0,
				duration: 0.85,
				stagger: 0.08,
				overwrite: true
			} );
		}
	} );

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
