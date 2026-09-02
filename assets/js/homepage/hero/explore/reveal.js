/**
 * Section reveals for the Explore Cards pattern.
 *
 * Mirrors the approved mockup: the intro block and the two cards rise into
 * place as they are scrolled to, in batches so a row arrives together rather
 * than one card at a time, and the inked underline strokes itself across the
 * word it marks.
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

	var section = document.querySelector( '.iflynepal-explore' );

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

	/* --------------------------------------------------------------- rise in */

	var reveals = Array.prototype.slice.call(
		document.querySelectorAll( '.iflynepal-explore__intro, .iflynepal-explore__card' )
	);

	if ( reveals.length ) {
		gsap.set( reveals, { opacity: 0, y: 26 } );

		// Batched so cards that come into view together animate together.
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
					overwrite: true,
				} );
			},
		} );
	}

	/* ------------------------------------------------------------- underline */

	/*
	 * The mark is a pseudo-element, which GSAP cannot tween directly, so the
	 * stroke is a CSS transition the class toggle drives. .is-armed winds it
	 * back to nothing; .is-drawn plays it across. Arming happens here rather
	 * than in the stylesheet so the mark is never missing when this file is not
	 * running.
	 */
	Array.prototype.slice
		.call( document.querySelectorAll( '.iflynepal-explore__underline' ) )
		.forEach( function ( mark ) {
			mark.classList.add( 'is-armed' );

			ScrollTrigger.create( {
				trigger: mark,
				start: 'top 86%',
				once: true,
				onEnter: function () {
					mark.classList.add( 'is-drawn' );
				},
			} );
		} );

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
