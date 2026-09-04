/**
 * FAQ questions: add and remove them in the Customizer.
 *
 * The slots themselves are registered in PHP (inc/customizer/sections/faq.php);
 * this only decides how many of them the panel shows. Keep the count in step
 * with IFLYNEPAL_FAQ_MAX — it is passed in rather than hard-coded here.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalFaqItems;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var slots = [];

		for ( var i = 1; i <= config.max; i++ ) {
			slots.push( [
				'iflynepal_faq_' + i + '_question',
				'iflynepal_faq_' + i + '_answer'
			] );
		}

		window.iflynepalCustomizer.repeater( {
			slots: slots,
			// The group's own heading is what the first question sits under.
			anchor: 'iflynepal_faq_items_heading',
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel
		} );
	} );
}( wp.customize ) );
