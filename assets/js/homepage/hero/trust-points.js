/**
 * Hero trust points: add and remove bullets in the Customizer.
 *
 * The slots themselves are registered in PHP (inc/customizer/sections/hero.php);
 * this only decides how many of them the panel shows. Keep the count in step
 * with IFLYNEPAL_HERO_TRUST_MAX — it is passed in rather than hard-coded here.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalHeroTrust;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var settings = [];

		for ( var i = 1; i <= config.max; i++ ) {
			settings.push( 'iflynepal_hero_trust_' + i );
		}

		window.iflynepalCustomizer.repeater( {
			settings: settings,
			// The bullets sit under the second button's link in the panel.
			anchor: 'iflynepal_hero_button_2_url',
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel,
			// The design never shows a hero with no proof line at all.
			minVisible: 1
		} );
	} );
}( wp.customize ) );
