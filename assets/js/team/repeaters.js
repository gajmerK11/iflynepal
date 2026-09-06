/**
 * Team: the Customizer's two add/remove lists.
 *
 * The rosters — global representatives and the executive team — differ only in
 * which settings they cover and what the buttons say, so they are described in
 * PHP and walked here rather than getting a file each. Same arrangement as the
 * About Nepal page's eleven lists.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/team.php); this only decides how many of them the
 * panel shows. The counts are passed in rather than hard-coded, so they stay in
 * step with the IFLYNEPAL_TEAM_* constants.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalTeamLists;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		/**
		 * Builds one roster's slots from its setting-ID patterns.
		 *
		 * A card groups several settings — a name, a role or country, and a
		 * photograph — so every slot is an array of IDs.
		 *
		 * @param {Array}  patterns Setting ID patterns, each containing "%d".
		 * @param {number} max      How many slots to build.
		 * @return {Array} Slots, in display order.
		 */
		function slotsFrom( patterns, max ) {
			var slots = [];

			for ( var i = 1; i <= max; i++ ) {
				slots.push(
					patterns.map( function ( one ) {
						return one.replace( '%d', i );
					} )
				);
			}

			return slots;
		}

		/**
		 * What an unused field holds.
		 *
		 * The repeater reads any field that is not its empty value as "this
		 * slot is in use", and a media control stores an attachment ID, which
		 * is 0 rather than "" when empty — so all twelve slots would open as
		 * filled without this.
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
				removeLabel: list.removeLabel
			} );
		} );
	} );
}( wp.customize ) );
