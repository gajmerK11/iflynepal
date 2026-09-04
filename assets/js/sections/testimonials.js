/**
 * The testimonial carousel.
 *
 * Written against the section as a class rather than an ID, so a page can carry
 * more than one of them — the template part is reusable, and two testimonial
 * sections on one page must not fight over an element id.
 *
 * The loop is seamless: the slides are cloned into a band either side, so the
 * track never runs out of cards in either direction. Once a move settles, an
 * index that has walked out of the middle band is rewound by exactly one band
 * with the transition switched off — same cards, same pixels, so the rewind
 * cannot be seen.
 *
 * Everything here is enhancement. The dimming of the off-centre cards is
 * applied only under the `is-ready` class this file adds, so with JavaScript
 * off the section is a plain, fully legible row of reviews.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	/**
	 * Wires one carousel.
	 *
	 * @param {HTMLElement} carousel The section's carousel root.
	 * @return {void}
	 */
	function setup( carousel ) {
		var viewport = carousel.querySelector( '.iflynepal-testimonials__viewport' );
		var track = carousel.querySelector( '.iflynepal-testimonials__track' );

		if ( ! viewport || ! track ) {
			return;
		}

		var originals = Array.prototype.slice.call( track.children );
		var count = originals.length;

		// One review is a quote, not a carousel. Left as it is.
		if ( count < 2 ) {
			return;
		}

		var frontBand = document.createDocumentFragment();
		var backBand = document.createDocumentFragment();

		originals.forEach( function ( item ) {
			[ frontBand, backBand ].forEach( function ( band ) {
				var clone = item.cloneNode( true );

				// The real slides are already in the accessibility tree.
				clone.setAttribute( 'aria-hidden', 'true' );
				band.appendChild( clone );
			} );
		} );

		track.insertBefore( frontBand, track.firstChild );
		track.appendChild( backBand );

		var slides = Array.prototype.slice.call( track.children );
		var index = count; // The first real slide.
		var itemW = 0;
		var dragging = false;
		var startX = 0;
		var startShift = 0;
		var moved = 0;
		var settle = null;

		carousel.classList.add( 'is-ready' );

		/**
		 * How many cards are across at this width.
		 *
		 * Kept in step with the breakpoints on the item's width in the
		 * stylesheet — the script sizes nothing itself.
		 *
		 * @return {number} Cards across.
		 */
		function perView() {
			var w = window.innerWidth;

			if ( w < 768 ) {
				return 1;
			}

			return w < 1170 ? 2 : 3;
		}

		/**
		 * Reads the width of one card off the rendered viewport.
		 *
		 * @return {void}
		 */
		function measure() {
			itemW = viewport.clientWidth / perView();
		}

		/**
		 * Where the track sits when a given slide is the middle one.
		 *
		 * @param {number} i Slide index.
		 * @return {number} Offset in pixels.
		 */
		function shiftFor( i ) {
			return ( ( viewport.clientWidth - itemW ) / 2 ) - ( i * itemW );
		}

		/**
		 * Moves the track and marks the centre card.
		 *
		 * @param {boolean} animate Whether the move should be seen.
		 * @return {void}
		 */
		function paint( animate ) {
			if ( ! animate ) {
				track.classList.add( 'is-jumping' );
			}

			track.style.transform = 'translate3d(' + shiftFor( index ) + 'px,0,0)';

			slides.forEach( function ( slide, i ) {
				slide.classList.toggle( 'is-center', i === index );
			} );

			if ( ! animate ) {
				// Flush the jump before the transition is allowed back.
				void track.offsetWidth;
				track.classList.remove( 'is-jumping' );
			}
		}

		/**
		 * Brings an index that has left the middle band back into it.
		 *
		 * @return {void}
		 */
		function rewind() {
			if ( index < count ) {
				index += count;
				paint( false );
			} else if ( index >= count * 2 ) {
				index -= count;
				paint( false );
			}
		}

		/**
		 * Steps the carousel.
		 *
		 * @param {number} delta Cards to move by, negative to go back.
		 * @return {void}
		 */
		function go( delta ) {
			index += delta;
			paint( true );

			window.clearTimeout( settle );
			settle = window.setTimeout( rewind, 470 );
		}

		track.addEventListener( 'pointerdown', function ( event ) {
			if ( 0 !== event.button ) {
				return;
			}

			dragging = true;
			moved = 0;
			startX = event.clientX;
			startShift = shiftFor( index );

			track.classList.add( 'is-dragging' );

			if ( track.setPointerCapture ) {
				track.setPointerCapture( event.pointerId );
			}
		} );

		track.addEventListener( 'pointermove', function ( event ) {
			if ( ! dragging ) {
				return;
			}

			// Stop the drag from turning into a text selection.
			event.preventDefault();

			moved = event.clientX - startX;
			track.style.transform = 'translate3d(' + ( startShift + moved ) + 'px,0,0)';
		} );

		[ 'pointerup', 'pointercancel' ].forEach( function ( type ) {
			track.addEventListener( type, function () {
				if ( ! dragging ) {
					return;
				}

				dragging = false;
				track.classList.remove( 'is-dragging' );

				var steps = Math.round( -moved / itemW );

				// A short flick should still advance a card.
				if ( 0 === steps && Math.abs( moved ) > 40 ) {
					steps = moved < 0 ? 1 : -1;
				}

				go( steps );
			} );
		} );

		carousel.addEventListener( 'keydown', function ( event ) {
			if ( 'ArrowLeft' === event.key ) {
				event.preventDefault();
				go( -1 );
			}

			if ( 'ArrowRight' === event.key ) {
				event.preventDefault();
				go( 1 );
			}
		} );

		/**
		 * Re-reads the card width and puts the track back where it belongs.
		 *
		 * @return {void}
		 */
		function relayout() {
			measure();
			paint( false );
		}

		/*
		 * Watching the viewport rather than the window, because a card's width
		 * is read off the rendered element: a section that starts inside a
		 * hidden container measures zero, and no window resize ever follows to
		 * correct it. The observer fires the moment the box has a width.
		 */
		if ( 'function' === typeof window.ResizeObserver ) {
			new window.ResizeObserver( relayout ).observe( viewport );
		}

		/*
		 * Kept alongside the observer rather than as its fallback. Relaying out
		 * twice costs nothing — it is idempotent — and the window event is the
		 * one that still arrives if the observer's callbacks are being starved.
		 */
		window.addEventListener( 'resize', relayout );
		window.addEventListener( 'load', relayout );

		relayout();
	}

	Array.prototype.forEach.call(
		document.querySelectorAll( '.iflynepal-testimonials__carousel' ),
		setup
	);
}() );
