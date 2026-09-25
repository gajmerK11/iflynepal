/**
 * Generic section motion, driven entirely by markup.
 *
 * A section opts in by carrying `data-iflynepal-motion`. Inside it, anything
 * marked `data-iflynepal-reveal` rises into place as it is scrolled to, and any
 * `.underline` strokes itself across the word it marks. Parameters are the ones
 * every section on this site already uses, so nothing has to be passed in.
 *
 * This exists to stop the per-section reveal scripts multiplying. The six that
 * came before it — explore, trust, people, guides, cta and sections — are the
 * same file six times over; they should be retired onto this one, a section at
 * a time, by adding the attribute and dropping the enqueue. Until then, do not
 * mark a section that already has its own script, or its elements are set to
 * hidden twice and batched twice.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet, and this
 * file only winds elements back once it is certain it can play them forward
 * again.
 *
 * It also carries one unrelated, opt-out-free guard: any
 * `.iflynepal-csr-head__title` inside an opted-in section gets its font-size
 * shrunk at runtime if it still overflows after the stylesheet's own wrapping
 * rules, so a CSR page head can never force a horizontal scrollbar. See
 * shrinkCsrHeadTitleToFit() below.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var roots = document.querySelectorAll( '[data-iflynepal-motion]' );

	if ( ! roots.length ) {
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

	/**
	 * Collects one selector's matches across every opted-in section.
	 *
	 * @param {string} selector CSS selector to look for inside each root.
	 * @return {Array} The matched elements, in document order.
	 */
	function collect( selector ) {
		var found = [];

		Array.prototype.forEach.call( roots, function ( root ) {
			found = found.concat(
				Array.prototype.slice.call( root.querySelectorAll( selector ) )
			);
		} );

		return found;
	}

	/* --------------------------------------------------------------- rise in */

	var reveals = collect( '[data-iflynepal-reveal]' );

	if ( reveals.length ) {
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
	}

	/* ------------------------------------------------------------- underline */

	/*
	 * The mark is a pseudo-element, which GSAP cannot tween directly, so the
	 * stylesheet reads its scale from a custom property and the property is
	 * what gets animated. Winding back happens here rather than in the
	 * stylesheet, so the mark is never missing when this file is not running.
	 */
	collect( '.underline' ).forEach( function ( mark ) {
		gsap.set( mark, { '--iflynepal-underline-scale': 0 } );

		gsap.to( mark, {
			'--iflynepal-underline-scale': 1,
			duration: mark.closest( '.iflynepal-contact-head' ) ? 0.6 : 0.9,
			ease: 'power1.inOut',
			scrollTrigger: {
				trigger: mark,
				start: 'top 80%',
				once: true
			}
		} );
	} );

	/* ------------------------------------------------------ shrink to fit */

	/*
	 * Last-resort guard for the CSR section heads. CSS already wraps and
	 * breaks these titles at any width, in any language — this only
	 * engages if one still overflows its own box regardless (an extra-long
	 * editor-entered phrase, a language whose words run longer than the
	 * clamp() ceiling was sized for). It steps the font-size down in 1px
	 * increments, from whatever the stylesheet set, until the title fits.
	 *
	 * @param {Element} el The heading to check.
	 * @return {void}
	 */
	function shrinkCsrHeadTitleToFit( el ) {
		el.style.fontSize = '';

		var floor = 22;
		var tries = 0;

		while ( el.scrollWidth > el.clientWidth + 1 && tries < 40 ) {
			var size = parseFloat( getComputedStyle( el ).fontSize );

			if ( ! size || size <= floor ) {
				break;
			}

			el.style.fontSize = ( size - 1 ) + 'px';
			tries++;
		}
	}

	var csrTitles = collect( '.iflynepal-csr-head__title' );

	if ( csrTitles.length ) {
		var resizeTimer;

		var recheckCsrTitles = function () {
			csrTitles.forEach( shrinkCsrHeadTitleToFit );
		};

		recheckCsrTitles();

		window.addEventListener( 'load', recheckCsrTitles );

		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( recheckCsrTitles, 150 );
		} );
	}

	window.addEventListener( 'load', function () {
		ScrollTrigger.refresh();
	} );
}() );
