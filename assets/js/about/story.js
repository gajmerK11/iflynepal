/**
 * Overview paragraphs: add and remove them in the Customizer.
 *
 * The slots themselves are registered in PHP
 * (inc/customizer/sections/about-company.php); this only decides how many of
 * them the panel shows. Keep the count in step with IFLYNEPAL_ABOUT_STORY_MAX —
 * it is passed in rather than hard-coded here.
 *
 * One field per slot, so Remove clears a single setting and the default empty
 * string is the right kind of empty.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	api.bind( 'ready', function () {
		var config = window.iflynepalAboutStory;

		if ( ! config || ! window.iflynepalCustomizer ) {
			return;
		}

		var slots = [];

		for ( var i = 1; i <= config.max; i++ ) {
			slots.push( [ 'iflynepal_about_story_' + i ] );
		}

		window.iflynepalCustomizer.repeater( {
			slots: slots,
			// The heading the Overview copy sits under.
			anchor: 'iflynepal_about_overview_title',
			// The column is the section; it cannot be emptied to nothing.
			minVisible: 1,
			addLabel: config.addLabel,
			maxMessage: config.maxMessage,
			removeLabel: config.removeLabel
		} );
	} );
}( wp.customize ) );
