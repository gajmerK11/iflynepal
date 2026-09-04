/**
 * The People rail: previous/next buttons, and the loop that has no end.
 *
 * The rail is a horizontally scrolling row with its scrollbar hidden, so the
 * two buttons are how it is stepped through with a mouse. Touch and trackpad
 * scroll it directly.
 *
 * Scrolling past the last person comes back round to the first. That is done
 * the way the logo marquee does it: the run of cards is repeated, and once the
 * rail has travelled one whole run it is moved back by exactly that distance.
 * The card under the cursor at that moment is identical to the one it is
 * swapped for, so the jump cannot be seen.
 *
 * The copies are made here rather than printed by PHP for two reasons: without
 * JavaScript there are no buttons and no loop, so a second copy of every
 * colleague would just be a page listing each of them twice; and how many
 * copies are needed depends on the viewport, which only the browser knows.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-people' );

	if ( ! section ) {
		return;
	}

	var rail = section.querySelector( '.iflynepal-people__rail' );
	var prev = section.querySelector( '.iflynepal-people__prev' );
	var next = section.querySelector( '.iflynepal-people__next' );

	if ( ! rail || ! prev || ! next ) {
		return;
	}

	// The gap between cards, which a step has to clear along with the card.
	var GAP = 22;

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );
	var originals = Array.prototype.slice.call(
		rail.querySelectorAll( '.iflynepal-people__card' )
	);

	if ( ! originals.length ) {
		return;
	}

	var clones = [];
	var looping = false;
	var period = 0;
	var settle = null;
	var resizing = null;

	/**
	 * How the buttons move the rail.
	 *
	 * Passed on every call rather than left to the stylesheet, because the
	 * repositioning the loop does has to be instant whatever the buttons do.
	 *
	 * @return {string} A scroll behaviour.
	 */
	function behavior() {
		return reduced.matches ? 'auto' : 'smooth';
	}

	/**
	 * How far one press of a button moves the rail.
	 *
	 * Measured from the rendered card rather than assumed, so the rail still
	 * steps correctly at the narrower breakpoints.
	 *
	 * @return {number} Distance in pixels.
	 */
	function step() {
		return originals[ 0 ].getBoundingClientRect().width + GAP;
	}

	/**
	 * Discards every copy, leaving the real cards behind.
	 *
	 * @return {void}
	 */
	function clearClones() {
		clones.forEach( function ( clone ) {
			rail.removeChild( clone );
		} );

		clones = [];
	}

	/**
	 * Repeats the run of cards until the rail cannot run out of them.
	 *
	 * A copy carries no ID and no reveal hook — those belong to the real card
	 * it was taken from — and is hidden from assistive technology, which would
	 * otherwise read the whole team out twice.
	 *
	 * @param {number} copies Total runs wanted, the real one included.
	 * @return {void}
	 */
	function buildClones( copies ) {
		for ( var copy = 1; copy < copies; copy++ ) {
			originals.forEach( function ( card ) {
				var clone = card.cloneNode( true );

				clone.setAttribute( 'aria-hidden', 'true' );
				clone.removeAttribute( 'data-iflynepal-reveal' );

				// The reveal leaves its wound-back opacity on the card it is
				// about to play; a copy is never played, so it starts finished.
				clone.removeAttribute( 'style' );

				Array.prototype.forEach.call(
					clone.querySelectorAll( '[id]' ),
					function ( node ) {
						node.removeAttribute( 'id' );
					}
				);

				rail.appendChild( clone );
				clones.push( clone );
			} );
		}
	}

	/**
	 * Brings the rail back inside the first run.
	 *
	 * Only ever called while the rail is standing still: doing it mid-glide
	 * would cut the glide short, which is exactly the jump this hides.
	 *
	 * @return {void}
	 */
	function normalize() {
		if ( ! looping || ! period ) {
			return;
		}

		if ( rail.scrollLeft >= period ) {
			rail.scrollLeft -= period;
		}
	}

	/**
	 * Disables whichever button has nothing left to reach.
	 *
	 * Only meaningful when the rail is not looping — a loop always has more of
	 * itself in both directions.
	 *
	 * The two-pixel slack absorbs the fractional scroll positions a zoomed or
	 * high-density display produces, which would otherwise leave a button
	 * enabled at a rail that cannot move any further.
	 *
	 * @return {void}
	 */
	function sync() {
		if ( looping ) {
			return;
		}

		var max = rail.scrollWidth - rail.clientWidth - 2;

		prev.disabled = rail.scrollLeft <= 2;
		next.disabled = rail.scrollLeft >= max;
	}

	/**
	 * Decides whether the rail loops, and lays it out to suit.
	 *
	 * The decision is made with the copies gone, because it is the real run
	 * that has to overrun the rail before looping it means anything: a team
	 * small enough to fit on screen is a row, not a carousel, and repeating it
	 * would put the same face on screen twice.
	 *
	 * @return {void}
	 */
	function refresh() {
		clearClones();

		looping = rail.scrollWidth > rail.clientWidth + 1;

		if ( ! looping ) {
			period = 0;
			sync();
			return;
		}

		// One run of cards, the gap that follows it included, so subtracting it
		// lands a copy exactly where the card it copies started.
		period = rail.scrollWidth + GAP;

		/*
		 * The rail can be a whole run plus one step along before it is brought
		 * back, and everything from there to the right-hand edge has to be a
		 * card. One more run than that arithmetic needs covers the rounding.
		 */
		buildClones( 1 + Math.ceil( ( step() + rail.clientWidth ) / period ) );

		// Now that a copy exists, the real distance between the two runs is
		// readable rather than derived.
		if ( clones.length ) {
			period = clones[ 0 ].offsetLeft - originals[ 0 ].offsetLeft;
		}

		prev.disabled = false;
		next.disabled = false;

		normalize();
	}

	prev.addEventListener( 'click', function () {
		if ( looping && rail.scrollLeft < step() ) {
			/*
			 * Standing at the start there is nothing to the left, so the rail
			 * is moved forward a whole run first. It lands on the same cards,
			 * one loop along, and the step back then has somewhere to go.
			 */
			rail.scrollLeft += period;
		}

		rail.scrollBy( { left: -step(), behavior: behavior() } );
	} );

	next.addEventListener( 'click', function () {
		// Wrap before moving, never during.
		normalize();

		rail.scrollBy( { left: step(), behavior: behavior() } );
	} );

	rail.addEventListener(
		'scroll',
		function () {
			if ( ! looping ) {
				sync();
				return;
			}

			/*
			 * Wait for the rail to stop. A glide fires scroll events all the
			 * way along, so this timer only runs out once one has finished —
			 * which is the one moment the rail can be moved unnoticed.
			 */
			window.clearTimeout( settle );
			settle = window.setTimeout( normalize, 120 );
		},
		{ passive: true }
	);

	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizing );
		resizing = window.setTimeout( refresh, 200 );
	} );

	window.addEventListener( 'load', refresh );

	refresh();
}() );
