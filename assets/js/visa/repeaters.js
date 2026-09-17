/**
 * Visa Services: the Customizer's five add/remove lists.
 *
 * The services, the visa categories, the destinations, the process steps and
 * the packages differ only in which settings they cover and what the buttons
 * say, so they are described in PHP and walked here — the same arrangement the
 * CSR, About Nepal and Team pages use.
 *
 * The slots themselves are registered in PHP (inc/customizer/sections/visa.php);
 * this only decides how many of them the panel shows.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalVisaLists;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		/**
		 * Builds one list's slots from its setting-ID patterns.
		 *
		 * @param {Array}  patterns Setting ID patterns, each containing "%d".
		 * @param {number} max      How many slots to build.
		 * @return {Array} Slots, in display order.
		 */
		function slotsFrom( patterns, max ) {
			var slots = [];

			for ( var i = 1; i <= max; i++ ) {
				var ids = patterns.map( function ( one ) {
					return one.replace( '%d', i );
				} );

				slots.push( 1 === ids.length ? ids[ 0 ] : ids );
			}

			return slots;
		}

		/**
		 * What an unused field holds.
		 *
		 * Every field on this page is text — there are no media controls in any
		 * of these five lists, and no field defaults to a numeral, because the
		 * service numerals and the step numerals are both worked out at render
		 * time from position. So a cleared slot is the empty string in every
		 * case, and there is no way for one to open as "in use" when it is not.
		 *
		 * @return {string} The empty value.
		 */
		function emptyValueFor() {
			return '';
		}

		config.lists.forEach( function ( list ) {
			window.iflynepalCustomizer.repeater( {
				slots: slotsFrom( list.patterns, list.max ),
				anchor: list.anchor,
				emptyValue: emptyValueFor,
				addLabel: list.addLabel,
				maxMessage: list.maxMessage,
				removeLabel: list.removeLabel,
				minVisible: list.minVisible
			} );
		} );
	} );
}( wp.customize ) );
