/**
 * "What we offer" rows: add and remove offerings in the Customizer.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/about-company.php); this only decides how many of
 * them the panel shows. Keep the count in step with IFLYNEPAL_ABOUT_OFFER_MAX —
 * it is passed in rather than hard-coded here.
 *
 * A row mixes three text fields with a media control, and the two disagree
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
		var config = window.iflynepalAboutOffers;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var slots = [];

		for ( var i = 1; i <= config.max; i++ ) {
			slots.push( [
				'iflynepal_about_offer_' + i + '_number',
				'iflynepal_about_offer_' + i + '_title',
				'iflynepal_about_offer_' + i + '_description',
				'iflynepal_about_offer_' + i + '_image'
			] );
		}

		window.iflynepalCustomizer.repeater( {
			slots: slots,
			// The group's own heading is what the first offering sits under.
			anchor: 'iflynepal_about_offer_lead',
			emptyValue: function ( id ) {
				return /_image$/.test( id ) ? 0 : '';
			},
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel
		} );
	} );
}( wp.customize ) );
