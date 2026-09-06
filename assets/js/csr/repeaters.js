/**
 * CSR: the Customizer's four add/remove lists.
 *
 * The commitment paragraphs, the sustainability pillars, the community
 * projects and the tourism panels differ only in which settings they cover and
 * what the buttons say, so they are described in PHP and walked here — the same
 * arrangement the About Nepal and Team pages use.
 *
 * The slots themselves are registered in PHP (inc/customizer/sections/csr.php);
 * this only decides how many of them the panel shows.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalCsrLists;

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
		 * Only the media controls differ: they store an attachment ID, which is
		 * 0 rather than "" when empty. Nothing on this page defaults a numeral
		 * or an icon to a non-blank value — the numerals are counted at render
		 * time from each item's position — so there is no third case here, and
		 * no way for a slot to open as "in use" when it is not.
		 *
		 * @param {string} id Setting ID.
		 * @return {*} The empty value for that setting.
		 */
		function emptyValueFor( id ) {
			return /_image$/.test( id ) ? 0 : '';
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
