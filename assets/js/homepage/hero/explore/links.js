/**
 * Explore card links: add and remove label/URL pairs in the Customizer.
 *
 * Each slot is a group of two settings, so adding a link shows both its label
 * and its URL field, and removing clears both. The slots themselves are
 * registered in PHP (inc/customizer/sections/explore.php); this only decides
 * how many of them the panel shows.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalExploreLinks;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		config.cards.forEach( function ( card ) {
			var prefix = 'iflynepal_explore_card_' + card + '_';
			var slots = [];

			for ( var i = 1; i <= config.max; i++ ) {
				slots.push( [ prefix + 'link_' + i + '_label', prefix + 'link_' + i + '_url' ] );
			}

			window.iflynepalCustomizer.repeater( {
				slots: slots,
				// The links sit under the card's description in the panel.
				anchor: prefix + 'description',
				addLabel: config.addLabel,
				maxMessage: config.maxMessage,
				removeLabel: config.removeLabel,
				// A gateway card with no way into its section is a dead end.
				minVisible: 1
			} );
		} );
	} );
}( wp.customize ) );
