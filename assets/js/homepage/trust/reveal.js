/**
 * Section reveals for the Why-trust section.
 *
 * Mirrors the approved mockup: the heading, the proof grid and the logo bands
 * rise into place as they are scrolled to, in batches so a row arrives together
 * rather than one block at a time.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet — the
 * section renders complete and static with JavaScript off, or with reduced
 * motion on, and this file only winds elements back once it is certain it can
 * play them forward again.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-trust' );

	if ( ! section ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// No GSAP, or motion is unwelcome: the section is already in its finished
	// state, so there is nothing to do.
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

	// Batched so blocks that come into view together animate together.
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
