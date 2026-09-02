<?php
/**
 * Hero getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * Each render callback is also what the template calls, so the pencil-shortcut
 * preview and the shipped page are produced by the same code.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default headline. `hero-text-style` is the accent treatment.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HERO_TITLE_DEFAULT = 'Nepal Tours, Treks & <span class="hero-text-style">Retreats</span><br>With Local Experts';

/**
 * Smallest background image the hero accepts.
 *
 * The hero is a full-viewport cover, so anything narrower than a common laptop
 * screen is upscaled and visibly soft. The ratio floor rejects portrait and
 * square images, which cannot fill that box without cropping away most of the
 * picture.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HERO_IMAGE_MIN_WIDTH  = 1920;
const IFLYNEPAL_HERO_IMAGE_MIN_HEIGHT = 1080;
const IFLYNEPAL_HERO_IMAGE_MIN_RATIO  = 1.4;

/**
 * Number of trust bullets the hero can show.
 *
 * Changing this needs a matching change to IFLYNEPAL_HERO_TRUST_MAX in
 * assets/js/homepage/hero/trust-points.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HERO_TRUST_MAX = 4;

/**
 * Default trust bullets, in order.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_hero_trust_defaults() {
	return array(
		1 => __( 'Local Nepal team', 'iflynepal' ),
		2 => __( 'Experienced guides', 'iflynepal' ),
		3 => __( 'Private & small-group options', 'iflynepal' ),
		4 => __( 'Support from arrival to departure', 'iflynepal' ),
	);
}

/**
 * Default label and link for each call to action.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1, each with 'label' and 'url'.
 */
function iflynepal_hero_button_defaults() {
	return array(
		1 => array(
			'label' => __( 'Explore Nepal', 'iflynepal' ),
			'url'   => '#explore',
		),
		2 => array(
			'label' => __( 'Find a Retreat', 'iflynepal' ),
			'url'   => 'https://iflynepal.com/trip_category/retreats-in-nepal',
		),
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * Headline, as sanitized HTML ready to print.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_hero_title', IFLYNEPAL_HERO_TITLE_DEFAULT ) );
}

/**
 * One call to action.
 *
 * @since 1.0.0
 *
 * @param int $index Button number, 1 or 2.
 * @return array{label: string, url: string} Label and link. Label is empty when the button is off.
 */
function iflynepal_hero_button( $index ) {
	$defaults = iflynepal_hero_button_defaults();
	$default  = isset( $defaults[ $index ] ) ? $defaults[ $index ] : array(
		'label' => '',
		'url'   => '',
	);

	return array(
		'label' => (string) get_theme_mod( 'iflynepal_hero_button_' . $index . '_label', $default['label'] ),
		'url'   => (string) get_theme_mod( 'iflynepal_hero_button_' . $index . '_url', $default['url'] ),
	);
}

/**
 * Trust bullets that have text, in order.
 *
 * Emptying a slot is how the Customizer's Remove button deletes a bullet, so an
 * empty slot is skipped rather than rendered blank.
 *
 * @since 1.0.0
 *
 * @return string[] Bullet labels.
 */
function iflynepal_hero_trust_points() {
	$defaults = iflynepal_hero_trust_defaults();
	$points   = array();

	for ( $i = 1; $i <= IFLYNEPAL_HERO_TRUST_MAX; $i++ ) {
		$default = isset( $defaults[ $i ] ) ? $defaults[ $i ] : '';
		$value   = trim( (string) get_theme_mod( 'iflynepal_hero_trust_' . $i, $default ) );

		if ( '' !== $value ) {
			$points[] = $value;
		}
	}

	return $points;
}

/* ------------------------------------------------------------------- media */

/**
 * Background image URL.
 *
 * Only ever an image the client has actually uploaded. There is deliberately no
 * shipped fallback: a stock photograph behind somebody else's video reads as a
 * glitch, because the two are different pictures and the swap is visible.
 *
 * With nothing uploaded the hero falls back to its own dark ground, which is
 * also what a visitor on reduced motion or Data Saver sees, since those two
 * never get the video either.
 *
 * @since 1.0.0
 *
 * @return string Image URL, or an empty string when none is set.
 */
function iflynepal_hero_background_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_background_image', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) wp_get_attachment_image_url( $attachment_id, 'full' );
}

/**
 * Intrinsic size of the background image, for the img width/height attributes.
 *
 * Printing the real size reserves the right box before the file arrives, which
 * is what keeps the hero from shifting layout as it loads.
 *
 * @since 1.0.0
 *
 * @return array{width: int, height: int} Pixel dimensions, zero when unknown.
 */
function iflynepal_hero_background_image_size() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_background_image', 0 );
	$meta          = $attachment_id ? wp_get_attachment_metadata( $attachment_id ) : array();

	return array(
		'width'  => empty( $meta['width'] ) ? 0 : (int) $meta['width'],
		'height' => empty( $meta['height'] ) ? 0 : (int) $meta['height'],
	);
}

/**
 * Background video URL.
 *
 * @since 1.0.0
 *
 * @return string Video URL, or an empty string when none is set.
 */
function iflynepal_hero_background_video_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_background_video', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) wp_get_attachment_url( $attachment_id );
}

/**
 * MIME type of the background video, for the source element's type attribute.
 *
 * @since 1.0.0
 *
 * @return string MIME type, or an empty string when no video is set.
 */
function iflynepal_hero_background_video_mime() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_background_video', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) get_post_mime_type( $attachment_id );
}

/**
 * Ambient audio URL.
 *
 * Never plays on its own. Browsers reject unmuted autoplay outright, and WCAG
 * 1.4.2 requires a stop control for anything that would, so the hero renders a
 * toggle and the visitor decides. Nothing is downloaded until they do.
 *
 * @since 1.0.0
 *
 * @return string Audio URL, or an empty string when none is set.
 */
function iflynepal_hero_audio_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_audio', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) wp_get_attachment_url( $attachment_id );
}

/**
 * MIME type of the ambient audio, for the source element's type attribute.
 *
 * @since 1.0.0
 *
 * @return string MIME type, or an empty string when no audio is set.
 */
function iflynepal_hero_audio_mime() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_hero_audio', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) get_post_mime_type( $attachment_id );
}

/**
 * Scheme and host serving the background image, for the preconnect hint.
 *
 * Normally the image is same-origin and no hint is wanted. It matters when the
 * media library is offloaded to a CDN: the image is the LCP element, so without
 * the hint it pays a cold DNS and TLS handshake before the largest paint starts.
 *
 * @since 1.0.0
 *
 * @return string Origin, or an empty string when same-origin or unset.
 */
function iflynepal_hero_background_image_origin() {
	$url = iflynepal_hero_background_image_url();

	if ( '' === $url ) {
		return '';
	}

	$parts = wp_parse_url( $url );

	if ( empty( $parts['scheme'] ) || empty( $parts['host'] ) ) {
		return '';
	}

	if ( wp_parse_url( home_url(), PHP_URL_HOST ) === $parts['host'] ) {
		return '';
	}

	return $parts['scheme'] . '://' . $parts['host'];
}

/* ------------------------------------------------------ render callbacks */

/**
 * Renders the headline.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_hero_title() {
	return iflynepal_hero_title();
}

/**
 * Renders both calls to action.
 *
 * A button with no label is skipped, which is how one of the pair is turned off.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_hero_actions() {
	/*
	 * The gold treatment sits on the second button: retreats are what the site
	 * is being repositioned around, so that is the action worth weighting.
	 */
	$modifiers = array(
		1 => 'iflynepal-btn--ghost',
		2 => 'iflynepal-btn--primary',
	);

	$markup = '';

	foreach ( $modifiers as $index => $modifier ) {
		$button = iflynepal_hero_button( $index );

		if ( '' === trim( $button['label'] ) ) {
			continue;
		}

		$markup .= sprintf(
			'<div class="wp-block-button %1$s"><a class="wp-block-button__link wp-element-button" href="%2$s">%3$s</a></div>',
			esc_attr( $modifier ),
			esc_url( $button['url'] ),
			esc_html( $button['label'] )
		);
	}

	return $markup;
}

/**
 * Renders the trust bullets.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_hero_trust_points() {
	$markup = '';

	foreach ( iflynepal_hero_trust_points() as $point ) {
		$markup .= '<p>' . esc_html( $point ) . '</p>';
	}

	return $markup;
}

/* --------------------------------------------------------------- validation */

/**
 * Rejects a background image too small or too tall for a full-viewport hero.
 *
 * Runs on save and blocks it, so a client cannot end up with a stretched or
 * badly cropped hero. The Customizer control also checks dimensions the moment
 * an image is picked (assets/js/homepage/hero/background-image.js) — that is
 * for immediate feedback only; this is the gate that actually holds.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Current validity.
 * @param mixed    $value    Attachment ID.
 * @return WP_Error Validity, carrying an error when the image is unusable.
 */
function iflynepal_validate_hero_background_image( $validity, $value ) {
	$attachment_id = (int) $value;

	if ( ! $attachment_id ) {
		return $validity;
	}

	$meta = wp_get_attachment_metadata( $attachment_id );

	$width  = empty( $meta['width'] ) ? 0 : (int) $meta['width'];
	$height = empty( $meta['height'] ) ? 0 : (int) $meta['height'];

	$too_small = $width < IFLYNEPAL_HERO_IMAGE_MIN_WIDTH || $height < IFLYNEPAL_HERO_IMAGE_MIN_HEIGHT;
	$too_tall  = ! $height || ( $width / $height ) < IFLYNEPAL_HERO_IMAGE_MIN_RATIO;

	if ( $too_small || $too_tall ) {
		$validity->add(
			'iflynepal_hero_image_incompatible',
			__( "The image's quality and size is not compatible", 'iflynepal' )
		);
	}

	return $validity;
}
