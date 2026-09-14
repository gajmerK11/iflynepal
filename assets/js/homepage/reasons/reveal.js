/**
 * Section reveals for "A few good reasons": the heading, filters and cards
 * rise into place as they are scrolled to, the ink-marked phrase in the
 * heading strokes itself in, and the handwritten annotation tilts into
 * position — the same three moves the catalogue archive's own reveal.js
 * plays for its listing heading (ifn-booking's assets/js/archive/reveal.js).
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

	var section = document.querySelector( '.iflynepal-reasons' );

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

	var marks = Array.prototype.slice.call(
		section.querySelectorAll( '.iflynepal-reasons__title .underline' )
	);

	marks.forEach( function ( mark ) {
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

	/* --------------------------------------------------------- the annotation */

	var annot = section.querySelector( '.iflynepal-reasons__annot' );

	if ( annot ) {
		gsap.fromTo(
			annot,
			{ opacity: 0, rotate: -6, y: 10 },
			{
				opacity: 1,
				rotate: 0,
				y: 0,
				duration: 0.8,
				ease: 'back.out(1.5)',
				scrollTrigger: {
					trigger: annot,
					start: 'top 92%',
					once: true
				}
			}
		);
	}

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
