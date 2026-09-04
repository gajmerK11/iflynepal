/**
 * People cards: add and remove people in the Customizer.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/people.php); this only decides how many of them the
 * panel shows. Keep the count in step with IFLYNEPAL_PEOPLE_CARD_MAX — it is
 * passed in rather than hard-coded here.
 *
 * A card mixes three text fields with a media control, and the two disagree
 * about what "empty" looks like: text holds the empty string, a media control
 * holds the attachment ID 0. The repeater is therefore given a function rather
 * than one value, so Remove writes the right kind of empty into each field.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalPeopleCards;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var slots = [];

		for ( var i = 1; i <= config.max; i++ ) {
			slots.push( [
				'iflynepal_people_card_' + i + '_title',
				'iflynepal_people_card_' + i + '_name',
				'iflynepal_people_card_' + i + '_country',
				'iflynepal_people_card_' + i + '_image'
			] );
		}

		window.iflynepalCustomizer.repeater( {
			slots: slots,
			// The group's own heading is what the first card sits under.
			anchor: 'iflynepal_people_cards_heading',
			emptyValue: function ( id ) {
				return /_image$/.test( id ) ? 0 : '';
			},
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel
		} );
	} );
}( wp.customize ) );
