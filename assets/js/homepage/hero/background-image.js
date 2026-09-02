/**
 * Hero background image: reject one too small or too tall, as it is picked.
 *
 * The hero is a full-viewport cover, so an undersized image is upscaled and
 * visibly soft, and a portrait one has to be cropped down to a sliver to fill
 * the box. Both are caught here the moment the image is chosen, which saves the
 * client from finding out at Save.
 *
 * This is convenience, not security. The gate that actually holds is the
 * setting's validate_callback in inc/customizer/callbacks/hero.php, which runs
 * on the server and blocks the save.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( api ) {
	'use strict';

	var NOTIFICATION_CODE = 'iflynepal_hero_image_incompatible';

	api.bind( 'ready', function () {
		var config = window.iflynepalHeroImage;
		var setting = api( 'iflynepal_hero_background_image' );
		var control = api.control( 'iflynepal_hero_background_image' );

		if ( ! config || ! setting || ! control || ! window.wp.media ) {
			return;
		}

		// The last value known to pass, so a rejected pick has somewhere to go back to.
		var accepted = setting.get();

		// Set while reverting, so putting the old value back does not re-run the check.
		var reverting = false;

		/**
		 * Shows or clears the rejection message on the control.
		 *
		 * @param {boolean} show Whether the image was rejected.
		 * @return {void}
		 */
		function notify( show ) {
			if ( show ) {
				control.notifications.add(
					new api.Notification( NOTIFICATION_CODE, {
						type: 'error',
						message: config.message
					} )
				);
				return;
			}

			control.notifications.remove( NOTIFICATION_CODE );
		}

		/**
		 * Whether an attachment's dimensions suit a full-viewport hero.
		 *
		 * @param {number} width  Image width in pixels.
		 * @param {number} height Image height in pixels.
		 * @return {boolean} True when the image can be used.
		 */
		function isUsable( width, height ) {
			if ( ! width || ! height ) {
				return false;
			}

			if ( width < config.minWidth || height < config.minHeight ) {
				return false;
			}

			return width / height >= config.minRatio;
		}

		setting.bind( function ( value ) {
			if ( reverting ) {
				return;
			}

			var id = parseInt( value, 10 );

			// Cleared. Nothing to check — the theme falls back to the shipped image.
			if ( ! id ) {
				accepted = value;
				notify( false );
				return;
			}

			var attachment = window.wp.media.attachment( id );

			attachment.fetch().done( function () {
				if ( isUsable( attachment.get( 'width' ), attachment.get( 'height' ) ) ) {
					accepted = value;
					notify( false );
					return;
				}

				notify( true );

				reverting = true;
				setting.set( accepted );
				reverting = false;
			} );
		} );
	} );
}( wp.customize ) );
