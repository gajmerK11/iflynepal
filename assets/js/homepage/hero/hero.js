/**
 * Hero motion and background video control.
 *
 * Mirrors the approved mockup: the headline reveals word by word, the
 * sub-title, actions and trust bullets follow, the still drifts, the media
 * parallaxes on scroll, and the header swaps from transparent to the solid
 * bar once the hero is left behind.
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

	/* --------------------------------------------------------- scroll pill */

	/*
	 * The pill at the foot of a hero that scrolls to the first section: Team's
	 * "Meet everyone", Contact's, and the legal pages' "Read the terms" /
	 * "Types of cookies". Each page names its own — the pills are styled
	 * differently — so all three are listed rather than given a shared class,
	 * which would mean restyling three components to fix a scroll.
	 *
	 * A plain fragment link to begin with, so it still navigates with
	 * JavaScript off; all this adds is the glide. Without it the browser jumps
	 * the page in one frame, which is what made the legal pills feel abrupt.
	 * It sits above the GSAP guard below because it is not motion — the pill
	 * has to work whether or not anything animates.
	 *
	 * scrollIntoView honours the target's own scroll-margin-top, so the
	 * section clears the fixed header without any offset arithmetic here.
	 */
	var scrollPill = hero.querySelector(
		'.iflynepal-team-hero__scroll, .iflynepal-contact-hero__scroll, .iflynepal-legal-hero__scroll'
	);

	if ( scrollPill ) {
		var pillTarget = document.querySelector( scrollPill.getAttribute( 'href' ) );

		if ( pillTarget ) {
			scrollPill.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				pillTarget.scrollIntoView( {
					behavior: reduced ? 'auto' : 'smooth',
					block: 'start'
				} );
			} );
		}
	}

	/* ------------------------------------------------------- background video */

	/**
	 * Whether this visit should pay for the background clip at all.
	 *
	 * template-parts/home/hero-section.php ships the video with preload="none"
	 * and no autoplay, so nothing is downloaded until this says so. The clip
	 * plays on every screen size, phones included. Two visitors still opt out:
	 * reduced motion is a stated preference against exactly this kind of
	 * looping decoration, and Data Saver is a stated preference against paying
	 * for it. Both fall back to the background image.
	 *
	 * @return {boolean} Whether to load the clip.
	 */
	function shouldLoadVideo() {
		if ( reduced ) {
			return false;
		}

		var connection = navigator.connection;

		return ! ( connection && connection.saveData );
	}

	/*
	 * The background image underneath is what visitors see first and is the LCP
	 * element. The video only fades over it once it is genuinely playable, so a
	 * missing or slow file never leaves a blank hero.
	 */
	if ( video && shouldLoadVideo() ) {
		// Whether the hero is on screen. The clip only runs while it is.
		var heroInView = true;

		// Set once the file has been asked for, so it is fetched a single time.
		var requested = false;

		/**
		 * Starts playback, ignoring the rejection a browser returns when it
		 * declines to autoplay.
		 *
		 * @return {void}
		 */
		function playVideo() {
			video.play().catch( function () {} );
		}

		video.addEventListener(
			'canplay',
			function () {
				video.classList.add( 'is-live' );

				// Could have scrolled past while the file was downloading.
				if ( heroInView ) {
					playVideo();
				}
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
			playVideo();
		} );

		/**
		 * Fetches the clip, once. Nothing is downloaded before this runs.
		 *
		 * @return {void}
		 */
		function requestVideo() {
			if ( requested ) {
				return;
			}

			requested = true;
			video.load();
		}

		/*
		 * Decoding a looping clip costs battery and CPU for as long as it runs,
		 * and none of it is worth paying once the hero has been scrolled past.
		 * The observer both defers the download until the hero is actually in
		 * view and stops playback whenever it leaves.
		 */
		if ( 'IntersectionObserver' in window ) {
			new window.IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						heroInView = entry.isIntersecting;

						if ( ! heroInView ) {
							if ( ! video.paused ) {
								video.pause();
							}

							return;
						}

						requestVideo();

						if ( video.paused ) {
							playVideo();
						}
					} );
				},
				{ threshold: 0 }
			).observe( hero );
		} else {
			requestVideo();
		}

		/*
		 * A background tab keeps a playing video decoding in some browsers, so
		 * hand the frames back when the page is not being looked at.
		 */
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				if ( ! video.paused ) {
					video.pause();
				}

				return;
			}

			if ( heroInView && requested ) {
				playVideo();
			}
		} );
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
	var kicker = hero.querySelector( '.iflynepal-hero__kicker' );
	var actions = hero.querySelector( '.iflynepal-hero__actions' );
	var lead = hero.querySelector( '.iflynepal-hero__lead' );
	var proof = hero.querySelectorAll( '.iflynepal-hero__proof p' );
	var portraits = hero.querySelectorAll( '.iflynepal-team-portrait' );

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

	/*
	 * The pieces around the headline, which differ per template: the homepage
	 * has actions and trust bullets, About has a sub-title and actions, About
	 * Nepal a sub-title alone, Team a kicker, a sub-title and the portraits.
	 * Each is looked for and skipped when absent, so one file drives them all.
	 */
	var staged = [ kicker, actions, lead ].filter( Boolean );

	/*
	 * The legal heroes carry a headline and nothing else — no kicker above it,
	 * no sub-title, no buttons — so the cascade that gives the other heroes
	 * their entrance has only two pieces to work with ("Cookie" and the accent
	 * "Policy"). At the shared 42px rise and a 55ms stagger the two land almost
	 * together and the title reads as though it simply appeared. Given further
	 * to travel and a stagger you can actually see, the same tween becomes an
	 * entrance.
	 */
	var isLegal = hero.classList.contains( 'iflynepal-hero--legal' );

	gsap.set( words, { opacity: 0, y: isLegal ? 64 : 42 } );
	gsap.set( staged, { opacity: 0, y: 22 } );
	gsap.set( proof, { opacity: 0, y: 10 } );
	/*
	 * Opacity only, deliberately. Two of the three frames are rotated a couple
	 * of degrees in the stylesheet, and animating y here would have GSAP write
	 * its own transform over that and stand them straight.
	 */
	gsap.set( portraits, { opacity: 0 } );

	// The gate can come off now that GSAP owns these elements' opacity.
	root.classList.remove( 'iflynepal-anim' );

	var timeline = gsap.timeline( { delay: 0.15 } );

	if ( kicker ) {
		timeline.to( kicker, { opacity: 1, y: 0, duration: 0.6 } );
	}

	timeline.to(
		words,
		{
			opacity: 1,
			y: 0,
			duration: isLegal ? 1.15 : 0.95,
			ease: 'expo.out',
			stagger: isLegal ? 0.14 : 0.055,
		},
		kicker ? '-=0.35' : 0
	);

	/*
	 * The portraits come in with the headline rather than after it: they are
	 * the other half of the same view, and waiting for the words to finish
	 * left the right-hand column visibly empty on a wide screen.
	 */
	if ( portraits.length ) {
		timeline.to(
			portraits,
			{ opacity: 1, duration: 0.8, stagger: 0.12 },
			'-=0.75'
		);
	}

	if ( lead ) {
		timeline.to( lead, { opacity: 1, y: 0, duration: 0.7 }, '-=0.5' );
	}

	if ( actions ) {
		timeline.to( actions, { opacity: 1, y: 0, duration: 0.7 }, '-=0.5' );
	}

	if ( proof.length ) {
		timeline.to( proof, { opacity: 1, y: 0, duration: 0.5, stagger: 0.07 }, '-=0.35' );
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
