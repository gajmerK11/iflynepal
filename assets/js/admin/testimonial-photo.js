/**
 * The reviewer photograph chooser on the Testimonials editor screen.
 *
 * Drives the media library for the hidden attachment-ID input the meta box
 * prints. Written against data attributes rather than IDs so a second media
 * field on the same screen would work without touching this file.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( $ ) {
	'use strict';

	$( function () {
		$( '[data-iflynepal-media]' ).each( function () {
			var $field = $( this );
			var $value = $field.find( '[data-iflynepal-media-value]' );
			var $preview = $field.find( '[data-iflynepal-media-preview]' );
			var $remove = $field.find( '[data-iflynepal-media-remove]' );
			var frame;

			$field.on( 'click', '[data-iflynepal-media-select]', function ( event ) {
				event.preventDefault();

				// The frame is built once and reopened, so it keeps its state.
				if ( ! frame ) {
					frame = wp.media( {
						title: window.iflynepalTestimonialPhoto.title,
						button: { text: window.iflynepalTestimonialPhoto.button },
						library: { type: 'image' },
						multiple: false
					} );

					frame.on( 'select', function () {
						var attachment = frame.state().get( 'selection' ).first().toJSON();
						var size = attachment.sizes && attachment.sizes.thumbnail
							? attachment.sizes.thumbnail
							: attachment;

						$value.val( attachment.id );
						$preview.html( $( '<img>', { src: size.url, alt: '' } ) );
						$remove.prop( 'hidden', false );
					} );
				}

				frame.open();
			} );

			$field.on( 'click', '[data-iflynepal-media-remove]', function ( event ) {
				event.preventDefault();

				$value.val( 0 );
				$preview.empty();
				$remove.prop( 'hidden', true );
			} );
		} );
	} );
}( jQuery ) );
