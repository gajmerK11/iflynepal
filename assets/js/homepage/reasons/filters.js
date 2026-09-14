/**
 * The "A few good reasons" filter row: one button per package type, "All"
 * first.
 *
 * Client-side over an already-rendered grid, so the section is complete and
 * correct with JavaScript off — every card simply shows. A card is hidden
 * with the `is-hidden` class rather than a style, so it leaves the
 * accessibility tree as well as the layout, the same rule the catalogue's own
 * category filter follows (ifn-booking's assets/js/archive/filters.js).
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

	var filters = section.querySelector( '.iflynepal-reasons__filters' );
	var cards   = Array.prototype.slice.call( section.querySelectorAll( '.iflynepal-reasons__card' ) );

	if ( ! filters || ! cards.length ) {
		return;
	}

	var buttons = Array.prototype.slice.call( filters.querySelectorAll( '.iflynepal-reasons__filter-btn' ) );

	filters.addEventListener( 'click', function ( event ) {
		var button = event.target.closest ? event.target.closest( '.iflynepal-reasons__filter-btn' ) : null;

		if ( ! button ) {
			return;
		}

		buttons.forEach( function ( b ) {
			var on = b === button;

			b.classList.toggle( 'is-active', on );
			b.setAttribute( 'aria-pressed', String( on ) );
		} );

		var filter = button.getAttribute( 'data-filter' ) || '';

		cards.forEach( function ( card ) {
			// A package's data-categories carries every ancestor term's slug
			// (see ifn-booking's iflynepal_package_filter_slugs()), so a card
			// filed under a child category still answers to its top-level
			// type's button.
			var categories = ( card.getAttribute( 'data-categories' ) || '' ).split( ' ' );
			var hidden     = '' !== filter && categories.indexOf( filter ) === -1;

			card.classList.toggle( 'is-hidden', hidden );
		} );
	} );
}() );
