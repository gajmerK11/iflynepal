/**
 * Hero background slideshow: cross-fade with a slow drift.
 *
 * One image is on screen at a time. Each fades up over the one before it while
 * both drift inward, so the change reads as the picture breathing rather than
 * as a cut — the effect the client's reference site uses.
 *
 * The first slide is the LCP element and is printed with its `src` by
 * template-parts/home/hero-section.php. Every other slide is printed with a
 * `data-src` and nothing else, so a visitor who never gets the slideshow — no
 * JavaScript, reduced motion, Data Saver — never downloads them either. This
 * file is what promotes them, and only once it has decided to run.
 *
 * Everything here is enhancement: with it absent the first slide is the hero
 * background and the section is complete.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var media = document.querySelector( '.iflynepal-hero__media' );

	if ( ! media ) {
		return;
	}

	var slides = Array.prototype.slice.call(
		media.querySelectorAll( '.iflynepal-hero__slide' )
	);

	// One picture is a background, not a slideshow.
	if ( slides.length < 2 ) {
		return;
	}

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/**
	 * Whether this visit should pay for the images the first frame does not need.
	 *
	 * The same two opt-outs the background video honours: reduced motion is a
	 * stated preference against exactly this kind of looping decoration, and
	 * Data Saver is a stated preference against paying for it. Both keep the
	 * opening frame, which is already on the page.
	 *
	 * @return {boolean} Whether to run.
	 */
	function shouldRun() {
		if ( reduced || typeof window.gsap === 'undefined' ) {
			return false;
		}

		var connection = navigator.connection || navigator.webkitConnection;

		return ! ( connection && connection.saveData );
	}

	if ( ! shouldRun() ) {
		return;
	}

	var gsap = window.gsap;

	/*
	 * How long each picture holds, and how long the two overlap. The fade is
	 * deliberately a fair share of the hold: a quick cross-fade reads as a cut,
	 * which is the thing this is here to avoid.
	 */
	var HOLD = 5.4;
	var FADE = 1.8;
	var ZOOM = 1.07;

	/**
	 * Gives a slide its file. Returns a promise so the first change can wait
	 * for the picture rather than fading up to an empty frame.
	 *
	 * @param {HTMLImageElement} slide The slide to load.
	 * @return {Promise} Settles when the image is usable, or immediately if it fails.
	 */
	function load( slide ) {
		var src = slide.getAttribute( 'data-src' );

		if ( ! src ) {
			return Promise.resolve();
		}

		slide.removeAttribute( 'data-src' );

		return new Promise( function ( resolve ) {
			slide.addEventListener( 'load', resolve, { once: true } );
			slide.addEventListener( 'error', resolve, { once: true } );
			slide.src = src;
		} );
	}

	/*
	 * The opening frame is already painted, so the rest are fetched now — in
	 * order, one at a time, so they queue behind anything the page still needs
	 * rather than competing with it.
	 */
	var ready = slides.slice( 1 ).reduce( function ( chain, slide ) {
		return chain.then( function () {
			return load( slide );
		} );
	}, Promise.resolve() );

	gsap.set( slides, { opacity: 0, scale: 1 } );
	gsap.set( slides[ 0 ], { opacity: 1 } );

	var index = 0;
	var timer = null;
	var running = false;

	/**
	 * Cross-fades to the next picture.
	 *
	 * @return {void}
	 */
	function advance() {
		var current = slides[ index ];
		var nextIndex = ( index + 1 ) % slides.length;
		var next = slides[ nextIndex ];

		// Wound back to its start so a picture drifts the same way every pass.
		gsap.set( next, { scale: 1 } );

		gsap.to( next, { opacity: 1, duration: FADE, ease: 'power1.inOut' } );
		gsap.to( current, {
			opacity: 0,
			duration: FADE,
			ease: 'power1.inOut',
			onComplete: function () {
				gsap.set( current, { scale: 1 } );
			}
		} );

		/*
		 * The drift runs for the whole time the picture is up, fade included,
		 * so it never appears to stop and restart mid-shot.
		 */
		gsap.to( next, { scale: ZOOM, duration: HOLD + FADE * 2, ease: 'none' } );

		index = nextIndex;
	}

	/**
	 * Starts, or restarts, the cycle.
	 *
	 * @return {void}
	 */
	function play() {
		if ( running ) {
			return;
		}

		running = true;
		timer = window.setInterval( advance, ( HOLD + FADE ) * 1000 );
	}

	/**
	 * Stops the cycle where it is. In-flight fades are left to finish, so
	 * nothing snaps.
	 *
	 * @return {void}
	 */
	function pause() {
		running = false;
		window.clearInterval( timer );
		timer = null;
	}

	ready.then( function () {
		play();
	} );

	// Nothing cycles behind a hidden tab, or once the hero is scrolled past.
	document.addEventListener( 'visibilitychange', function () {
		if ( document.hidden ) {
			pause();
			return;
		}

		play();
	} );

	if ( 'IntersectionObserver' in window ) {
		new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting && ! document.hidden ) {
						play();
						return;
					}

					if ( ! entry.isIntersecting ) {
						pause();
					}
				} );
			},
			{ threshold: 0 }
		).observe( media );
	}
}() );
