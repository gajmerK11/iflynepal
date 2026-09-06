/**
 * About Nepal: every add/remove list in the Customizer, in one file.
 *
 * The page has eleven of them — a prose block for each of seven chapters, the
 * packing intro, the People cards, the Flora regions, the Economy sectors and
 * the Safety points — and they differ only in which settings they cover and
 * what they are called. Rather than eleven near-identical files calling the
 * same helper, the differences are a list and this walks it.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/about-country.php); this only decides how many of
 * them the panel shows. Keep the counts in step with the IFLYNEPAL_COUNTRY_*
 * constants — they are passed in rather than hard-coded here.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalCountryLists;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		/**
		 * Builds one list's slots from a setting-ID pattern.
		 *
		 * A pattern is a string containing "%d", or an array of them when a
		 * slot groups several settings — a card's title beside its image.
		 *
		 * @param {string|Array} pattern Setting ID pattern, or patterns.
		 * @param {number}       max     How many slots to build.
		 * @return {Array} Slots, in display order.
		 */
		function slotsFrom( pattern, max ) {
			var patterns = Array.isArray( pattern ) ? pattern : [ pattern ];
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
		 * What an unused slot holds, field by field.
		 *
		 * Most fields are blank, but three kinds are not, and the repeater
		 * reads any field that is not its empty value as "this slot is in
		 * use" — so getting these wrong leaves every slot on screen:
		 *
		 * - a media control stores an attachment ID and holds 0;
		 * - a region's numeral defaults to its own position ("05"), because a
		 *   region added later should arrive numbered rather than blank;
		 * - a sector's icon defaults to a real glyph, since there is no
		 *   "no icon" to fall back to.
		 *
		 * @param {string} id Setting ID.
		 * @return {*} The empty value for that setting.
		 */
		function emptyValueFor( id ) {
			if ( /_image$/.test( id ) ) {
				return 0;
			}

			var region = id.match( /_region_(\d+)_number$/ );

			if ( region ) {
				return ( '0' + region[ 1 ] ).slice( -2 );
			}

			var sector = id.match( /_sector_(\d+)_icon$/ );

			if ( sector && config.sectorIcons ) {
				return config.sectorIcons[ sector[ 1 ] ] || '';
			}

			return '';
		}

		config.lists.forEach( function ( list ) {
			window.iflynepalCustomizer.repeater( {
				slots: slotsFrom( list.pattern, list.max ),
				anchor: list.anchor,
				emptyValue: emptyValueFor,
				addLabel: list.addLabel,
				maxMessage: list.maxMessage,
				removeLabel: list.removeLabel
			} );
		} );
	} );
}( wp.customize ) );
