/**
 * Section reveal for the Trusted Partner card.
 *
 * Same treatment as the Why-trust section (assets/js/homepage/trust/reveal.js):
 * the heading and the card rise into place as they are scrolled to, in a
 * batch so both arrive together rather than one after the other.
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

	var section = document.querySelector( '.iflynepal-partner' );

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

	gsap.set( reveals, { opacity: 0, y: 34 } );

	// Batched so the heading and the card animate together, slow and eased
	// rather than snapping in.
	ScrollTrigger.batch( reveals, {
		start: 'top 88%',
		once: true,
		interval: 0.12,
		batchMax: 6,
		onEnter: function ( batch ) {
			gsap.to( batch, {
				opacity: 1,
				y: 0,
				duration: 1.4,
				ease: 'power2.out',
				stagger: 0.18,
				overwrite: true
			} );
		}
	} );

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
