/**
 * Section reveal for the closing call to action.
 *
 * The card rises into place as it is scrolled to, on the same parameters as
 * every other reveal on the page, and the inked underline strokes itself
 * across the word it marks — the same treatment the Explore heading gets.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet — the
 * card renders complete and static with JavaScript off, or with reduced motion
 * on, and this file only winds elements back once it is certain it can play
 * them forward again.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-cta' );

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

	/* --------------------------------------------------------------- rise in */

	var reveals = Array.prototype.slice.call(
		section.querySelectorAll( '[data-iflynepal-reveal]' )
	);

	if ( reveals.length ) {
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
	}

	/* ------------------------------------------------------------- underline */

	/*
	 * The mark is a pseudo-element, which GSAP cannot tween directly, so the
	 * stylesheet reads its scale from a custom property and the property is
	 * what gets animated. Winding back happens here rather than in the
	 * stylesheet, so the mark is never missing when this file is not running.
	 *
	 * Same duration and start as the Explore heading's mark: slower than the
	 * mockup's 0.75s and begun a little later, so the stroke is still playing
	 * once the heading has settled in front of the reader.
	 */
	gsap.utils.toArray( '.iflynepal-cta__title .underline' ).forEach( function ( mark ) {
		gsap.set( mark, { '--iflynepal-underline-scale': 0 } );

		gsap.to( mark, {
			'--iflynepal-underline-scale': 1,
			duration: 0.9,
			ease: 'power1.inOut',
			scrollTrigger: {
				trigger: mark,
				start: 'top 80%',
				once: true
			}
		} );
	} );

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
