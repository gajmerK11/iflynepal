/**
 * Section reveals for the reusable testimonial section.
 *
 * Written against every testimonial section on the page rather than one of
 * them, because the template part it belongs to is reusable.
 *
 * Same parameters as the reveals on the hero-side sections — the motion is
 * deliberately identical across the page.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet, and this
 * file only winds elements back once it is certain it can play them forward
 * again.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var sections = document.querySelectorAll( '.iflynepal-testimonials' );

	if ( ! sections.length ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// No GSAP, or motion is unwelcome: the sections are already finished.
	if ( reduced || typeof window.gsap === 'undefined' || ! window.ScrollTrigger ) {
		return;
	}

	var gsap = window.gsap;
	var ScrollTrigger = window.ScrollTrigger;

	gsap.registerPlugin( ScrollTrigger );

	var reveals = [];

	Array.prototype.forEach.call( sections, function ( section ) {
		reveals = reveals.concat(
			Array.prototype.slice.call(
				section.querySelectorAll( '[data-iflynepal-reveal]' )
			)
		);
	} );

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
