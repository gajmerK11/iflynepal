/**
 * Hero background slideshow: add and remove images in the Customizer.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/hero.php); this only decides how many of them the
 * panel shows. Keep the count in step with IFLYNEPAL_HERO_SLIDE_MAX — it is
 * passed in rather than hard-coded here.
 *
 * A media control stores an attachment ID and holds 0 when it is empty, so the
 * repeater is told what "empty" means for these slots rather than assuming the
 * empty string it uses for text fields.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalHeroSlides;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var slots = [];

		for ( var i = 1; i <= config.max; i++ ) {
			slots.push( 'iflynepal_hero_slide_' + i + '_image' );
		}

		window.iflynepalCustomizer.repeater( {
			slots: slots,
			// The group's own heading is what the first slot sits under.
			anchor: 'iflynepal_hero_slides_heading',
			emptyValue: 0,
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel
		} );
	} );
}( wp.customize ) );
