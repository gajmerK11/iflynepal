/**
 * Hero motion and background video control.
 *
 * Mirrors the approved mockup: the headline reveals word by word, the actions,
 * trust bullets and planner follow, the still drifts, the media parallaxes on
 * scroll, and the header swaps from transparent to the solid bar once the hero
 * is left behind.
 *
 * Everything here is enhancement. With JavaScript off, the gate class is never
 * added, nothing is hidden, and the hero renders complete and static.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var hero = document.querySelector( '.iflynepal-hero' );

	if ( ! hero ) {
		return;
	}

	var root = document.documentElement;
	var title = hero.querySelector( '.iflynepal-hero__title' );
	var media = hero.querySelector( '.iflynepal-hero__media' );
	var still = hero.querySelector( '.iflynepal-hero__still' );
	var video = document.getElementById( 'iflynepal-hero-video' );
	var header = document.getElementById( 'iflynepal-header' );
	var hasGsap = typeof window.gsap !== 'undefined';
	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ------------------------------------------------------- background video */

	/**
	 * Whether this visit should pay for the background clip at all.
	 *
	 * template-parts/home/hero-section.php ships the video with preload="none"
	 * and no autoplay, so nothing is downloaded until this says so. On a phone the still already
	 * carries the whole design and the clip is a megabyte-plus of cellular
	 * data for a decoration behind a scrim; on Data Saver it is worse. Both get
	 * the still, which is the same picture the poster frame would have shown.
	 *
	 * @return {boolean} Whether to load the clip.
	 */
	function shouldLoadVideo() {
		if ( reduced ) {
			return false;
		}

		if ( window.matchMedia( '(max-width: 760px)' ).matches ) {
			return false;
		}

		var connection = navigator.connection;

		return ! ( connection && connection.saveData );
	}

	/*
	 * The still underneath is what visitors see first and is the LCP element.
	 * The video only fades over it once it is genuinely playable, so a missing
	 * or slow file never leaves a blank hero — it simply stays a still image.
	 */
	if ( video && shouldLoadVideo() ) {
		video.addEventListener(
			'canplay',
			function () {
				video.classList.add( 'is-live' );
				video.play().catch( function () {} );
			},
			{ once: true }
		);

		video.addEventListener( 'error', function () {
			video.classList.remove( 'is-live' );
		} );

		// Belt and braces on the loop attribute: if a decoder ever lets the clip
		// run out, restart rather than freezing on the last frame.
		video.addEventListener( 'ended', function () {
			video.currentTime = 0;
			video.play().catch( function () {} );
		} );

		// Nothing is fetched before this call.
		video.load();
	}

	/* ------------------------------------------------------------- headline */

	/**
	 * Wraps each word of the headline so the words can stagger independently.
	 *
	 * Only text nodes are split — the <em> accent keeps its gradient fill and
	 * animates as one unit, exactly as the design has it. <br> is preserved.
	 *
	 * @return {Array} The elements to stagger, in document order.
	 */
	function splitHeadline() {
		if ( ! title ) {
			return [];
		}

		var pieces = [];

		Array.prototype.slice.call( title.childNodes ).forEach( function ( node ) {
			if ( node.nodeType === Node.ELEMENT_NODE ) {
				if ( node.tagName !== 'BR' ) {
					pieces.push( node );
				}
				return;
			}

			if ( node.nodeType !== Node.TEXT_NODE || ! node.textContent.trim() ) {
				return;
			}

			var fragment = document.createDocumentFragment();

			node.textContent.split( /(\s+)/ ).forEach( function ( chunk ) {
				if ( ! chunk.trim() ) {
					fragment.appendChild( document.createTextNode( chunk ) );
					return;
				}

				var span = document.createElement( 'span' );
				span.className = 'iflynepal-w';
				span.textContent = chunk;
				fragment.appendChild( span );
				pieces.push( span );
			} );

			title.replaceChild( fragment, node );
		} );

		return pieces;
	}

	/* -------------------------------------------------------------- reveals */

	var words = splitHeadline();
	var actions = hero.querySelector( '.iflynepal-hero__actions' );
	var proof = hero.querySelectorAll( '.iflynepal-hero__proof p' );
	var planner = hero.querySelector( '.iflynepal-trip-search' );

	// No GSAP, or motion is unwelcome: show everything and stop.
	if ( ! hasGsap || reduced ) {
		root.classList.remove( 'iflynepal-anim' );
		return;
	}

	var gsap = window.gsap;

	if ( window.ScrollTrigger ) {
		gsap.registerPlugin( window.ScrollTrigger );
	}

	gsap.defaults( { duration: 0.8, ease: 'power2.out' } );

	var staged = [ actions, planner ].filter( Boolean );

	gsap.set( words, { opacity: 0, y: 42 } );
	gsap.set( staged, { opacity: 0, y: 22 } );
	gsap.set( proof, { opacity: 0, y: 10 } );

	// The gate can come off now that GSAP owns these elements' opacity.
	root.classList.remove( 'iflynepal-anim' );

	var timeline = gsap.timeline( { delay: 0.15 } );

	timeline.to( words, {
		opacity: 1,
		y: 0,
		duration: 0.95,
		ease: 'expo.out',
		stagger: 0.055,
	} );

	if ( actions ) {
		timeline.to( actions, { opacity: 1, y: 0, duration: 0.7 }, '-=0.5' );
	}

	if ( proof.length ) {
		timeline.to( proof, { opacity: 1, y: 0, duration: 0.5, stagger: 0.07 }, '-=0.35' );
	}

	if ( planner ) {
		timeline.to( planner, { opacity: 1, y: 0, duration: 0.8 }, '-=0.3' );
	}

	/* --------------------------------------------------------------- drift */

	// Slow scale on the still, so the hero breathes even before a video file
	// is in place. Transform only — no layout, no repaint cost.
	if ( still ) {
		gsap.to( still, {
			scale: 1.12,
			duration: 22,
			ease: 'none',
			repeat: -1,
			yoyo: true,
		} );
	}

	if ( ! window.ScrollTrigger ) {
		return;
	}

	if ( media ) {
		gsap.to( media, {
			yPercent: 12,
			ease: 'none',
			scrollTrigger: {
				trigger: hero,
				start: 'top top',
				end: 'bottom top',
				scrub: true,
			},
		} );
	}

	/* -------------------------------------------------------------- header */

	// Swaps the header from transparent to the solid primary bar once the page
	// has moved off the very top.
	if ( header ) {
		window.ScrollTrigger.create( {
			trigger: hero,
			start: 'top top-=40',
			onEnter: function () {
				header.classList.add( 'is-docked' );
			},
			onLeaveBack: function () {
				header.classList.remove( 'is-docked' );
			},
		} );
	}
}() );
