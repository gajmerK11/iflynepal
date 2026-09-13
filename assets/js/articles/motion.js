/**
 * Motion for the Articles pages, ported from the approved designs' own script.
 *
 * The headline arrives a word at a time, the standfirst and the search capsule
 * follow it in, the still drifts and parallaxes, the header swaps from
 * transparent to the solid bar once the hero is left behind, everything below
 * the fold settles in as it is scrolled to, and the hand-drawn underline draws
 * itself across the word it marks.
 *
 * These pages use this rather than the theme's hero.js and sections/motion.js
 * because they carry the design's own markup and class names — `.hero h1 .w`
 * and `[data-anim]` rather than `.iflynepal-hero__title` and
 * `[data-iflynepal-reveal]`. The behaviour is the same in both; this is the
 * copy written against the design's classes.
 *
 * Every entrance state lives behind `.gsap-ready`, added here and removed again
 * if anything throws, so a visitor whose GSAP never loads gets the page in
 * plain CSS, fully legible, rather than blank.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	if ( typeof window.gsap === 'undefined' || ! window.ScrollTrigger ) {
		return;
	}

	var gsap = window.gsap;
	var ScrollTrigger = window.ScrollTrigger;
	var root = document.documentElement;

	window.addEventListener( 'error', function () {
		root.classList.remove( 'gsap-ready' );
	} );

	root.classList.add( 'gsap-ready' );
	gsap.registerPlugin( ScrollTrigger );
	gsap.defaults( { duration: 0.8, ease: 'power2.out' } );

	gsap.matchMedia().add(
		{
			motion: '(prefers-reduced-motion: no-preference)',
			still: '(prefers-reduced-motion: reduce)'
		},
		function ( context ) {
			if ( context.conditions.still ) {
				gsap.set( '[data-anim], .hero h1 .w, .hero h1 em', { opacity: 1, y: 0, clearProps: 'transform' } );
				gsap.set( '.ink-line', { scaleX: 1 } );

				return;
			}

			/* ------------------------------------------------------------ hero */

			gsap.set( '[data-anim="hero"]', { y: 22 } );
			gsap.set( '.hero h1 .w, .hero h1 em', { y: 42 } );
			gsap.set( '.hero-copy > .lead', { opacity: 0, y: 16 } );

			gsap.timeline( { delay: 0.15 } )
				.to( '.hero h1 .w, .hero h1 em', {
					opacity: 1,
					y: 0,
					duration: 0.95,
					ease: 'expo.out',
					stagger: 0.055
				} )
				.to( '.hero-copy > .lead', { opacity: 1, y: 0, duration: 0.7 }, '-=0.5' )
				.to( '[data-anim="hero"][data-hero-step="2"]', { opacity: 1, y: 0, duration: 0.7 }, '-=0.35' );

			// Slow drift on the still, so the hero breathes.
			gsap.to( '.hero-media img', { scale: 1.12, duration: 22, ease: 'none', repeat: -1, yoyo: true } );

			gsap.to( '.hero-media', {
				yPercent: 12,
				ease: 'none',
				scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true }
			} );

			/* ---------------------------------------------------------- header */

			var header = document.querySelector( '.site-header' );

			if ( header ) {
				ScrollTrigger.create( {
					trigger: '.hero',
					start: 'top top-=40',
					onEnter: function () {
						header.classList.add( 'is-docked' );
					},
					onLeaveBack: function () {
						header.classList.remove( 'is-docked' );
					}
				} );
			}

			/* --------------------------------------------------------- reveals */

			var reveals = gsap.utils.toArray( '[data-anim]' ).filter( function ( el ) {
				return el.getAttribute( 'data-anim' ) !== 'hero';
			} );

			gsap.set( reveals, { y: 26 } );

			ScrollTrigger.batch( reveals, {
				start: 'top 88%',
				once: true,
				interval: 0.12,
				batchMax: 6,
				onEnter: function ( batch ) {
					/*
					 * clearProps on the transform is the point: the tween
					 * finishes by writing an inline transform, and that
					 * outranks the :hover rules the cards rely on. Opacity has
					 * to stay inline, because `.gsap-ready [data-anim]` sets
					 * it to 0.
					 */
					gsap.to( batch, {
						opacity: 1,
						y: 0,
						duration: 0.85,
						stagger: 0.08,
						overwrite: true,
						clearProps: 'transform'
					} );
				}
			} );

			/* ------------------------------------------------------- underlines */

			gsap.utils.toArray( '.ink-line' ).forEach( function ( line ) {
				gsap.to( line, {
					scaleX: 1,
					duration: 0.75,
					ease: 'power2.inOut',
					scrollTrigger: { trigger: line, start: 'top 86%', once: true }
				} );
			} );
		}
	);

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );

	/*
	 * In the Customizer, a headline edited in the panel is re-rendered into the
	 * preview on its own — long after the entrance timeline above has run. The
	 * words it brings are held at zero opacity by `.gsap-ready .hero h1 .w`,
	 * which nothing is left to tween, so they are simply shown.
	 */
	if ( window.wp && window.wp.customize && window.wp.customize.selectiveRefresh ) {
		window.wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function ( placement ) {
			var container = placement.container && placement.container[ 0 ] ? placement.container[ 0 ] : placement.container;

			if ( ! container || ! container.querySelectorAll ) {
				return;
			}

			gsap.set( container.querySelectorAll( '.w, em, [data-anim]' ), { opacity: 1, y: 0, clearProps: 'transform' } );
		} );
	}
}() );
