/**
 * The Upcoming Journeys rail: month chips filter it, two buttons step it.
 *
 * Unlike the People rail (assets/js/homepage/people/rail.js) this rail does
 * not loop — its length changes every time a chip is pressed, so a fixed
 * "one run" period to loop against would have to be recalculated on every
 * filter anyway. Stepping through to whichever end the current month's cards
 * happen to reach, and greying out the button that has nothing left that way,
 * is the same behaviour the design itself specifies.
 *
 * The switch between months has no motion at all: a card is shown or hidden
 * with the `is-hidden` class the moment a chip is pressed, and the rail is put
 * back to its start in the same frame, so nothing is seen sliding out from
 * under another month's cards.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function () {
	'use strict';

	var section = document.querySelector( '.iflynepal-departures' );

	if ( ! section ) {
		return;
	}

	var rail   = section.querySelector( '.iflynepal-departures__rail' );
	var months = section.querySelector( '.iflynepal-departures__months' );
	var status = section.querySelector( '.iflynepal-departures__status' );
	var prev   = section.querySelector( '.iflynepal-departures__prev' );
	var next   = section.querySelector( '.iflynepal-departures__next' );

	if ( ! rail ) {
		return;
	}

	var cards = Array.prototype.slice.call( rail.querySelectorAll( '.iflynepal-departures__card' ) );

	if ( ! cards.length ) {
		return;
	}

	// The gap between cards, which a step has to clear along with the card.
	var GAP = 24;

	/**
	 * How far one press of a button moves the rail.
	 *
	 * Measured from a visible card rather than assumed, so the step is right
	 * at every breakpoint and after every filter.
	 *
	 * @return {number} Distance in pixels.
	 */
	function step() {
		var card = rail.querySelector( '.iflynepal-departures__card:not(.is-hidden)' );

		return card ? card.getBoundingClientRect().width + GAP : 373 + GAP;
	}

	/**
	 * Disables whichever button has nothing left to reach.
	 *
	 * @return {void}
	 */
	function sync() {
		if ( ! prev || ! next ) {
			return;
		}

		var max = rail.scrollWidth - rail.clientWidth - 2;

		prev.disabled = rail.scrollLeft <= 2;
		next.disabled = rail.scrollLeft >= max;
	}

	if ( prev && next ) {
		prev.addEventListener( 'click', function () {
			rail.scrollBy( { left: -step(), behavior: 'smooth' } );
		} );
		next.addEventListener( 'click', function () {
			rail.scrollBy( { left: step(), behavior: 'smooth' } );
		} );
		rail.addEventListener( 'scroll', sync, { passive: true } );
		window.addEventListener( 'resize', sync );
		window.addEventListener( 'load', sync );
	}

	if ( ! months || ! status ) {
		sync();

		return;
	}

	var chips = Array.prototype.slice.call( months.querySelectorAll( '.iflynepal-departures__chip' ) );

	if ( ! chips.length ) {
		sync();

		return;
	}

	/**
	 * Shows the cards for one month and hides the rest.
	 *
	 * The set swaps with no motion: a Flip-style reflow would read as the
	 * cards sliding around rather than the month simply changing.
	 *
	 * @param {string} month The chip's data-month value.
	 * @return {void}
	 */
	function applyMonth( month ) {
		var shown = 0;

		cards.forEach( function ( card ) {
			var hidden = card.getAttribute( 'data-month' ) !== month;

			card.classList.toggle( 'is-hidden', hidden );

			if ( ! hidden ) {
				shown++;
			}
		} );

		var chip  = chips.filter( function ( c ) { return c.getAttribute( 'data-month' ) === month; } )[ 0 ];
		var label = chip ? chip.textContent : month;
		var i18n  = window.iflynepalUpcomingDeparturesI18n || {};

		if ( 0 === shown ) {
			status.textContent = ( i18n.none || 'No departures listed for %s' ).replace( '%s', label );
		} else {
			var template = 1 === shown
				? ( i18n.singular || '%1$d departure in %2$s' )
				: ( i18n.plural || '%1$d departures in %2$s' );

			status.textContent = template.replace( '%1$d', shown ).replace( '%2$s', label );
		}

		// The rail just changed length, so jump it back and re-check the arrows.
		rail.scrollLeft = 0;
		sync();
	}

	months.addEventListener( 'click', function ( event ) {
		var chip = event.target.closest ? event.target.closest( '.iflynepal-departures__chip' ) : null;

		if ( ! chip ) {
			return;
		}

		chips.forEach( function ( c ) {
			var on = c === chip;

			c.classList.toggle( 'is-active', on );
			c.setAttribute( 'aria-pressed', String( on ) );
		} );

		applyMonth( chip.getAttribute( 'data-month' ) );
	} );

	var startChip = months.querySelector( '.iflynepal-departures__chip.is-active' ) || chips[ 0 ];

	if ( startChip ) {
		applyMonth( startChip.getAttribute( 'data-month' ) );
	}
}() );
