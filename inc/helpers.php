<?php
/**
 * Shared helpers.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes editor-supplied copy that is allowed a little inline formatting.
 *
 * Single source of truth: the same function runs as a Customizer setting's
 * sanitize_callback, inside every selective-refresh render callback, and in the
 * template that prints the value. What saves, what previews and what ships are
 * therefore always the same string.
 *
 * `<span class="hero-text-style">` is the documented way to give a word the
 * accent treatment, so `class` has to survive; `<br>` lets an editor control
 * where a headline wraps.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized HTML.
 */
function iflynepal_kses_text( $value ) {
	return wp_kses(
		(string) $value,
		array(
			'span'   => array(
				'class' => array(),
				'style' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		)
	);
}

/**
 * Sanitizes a link that may be an on-page anchor rather than a full URL.
 *
 * The hero's first button points at `#explore`, which esc_url_raw would strip,
 * so fragments and root-relative paths are passed through untouched and
 * everything else goes through the normal URL sanitizer.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized link.
 */
function iflynepal_sanitize_link( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	if ( '#' === $value[0] || '/' === $value[0] ) {
		return sanitize_text_field( $value );
	}

	return esc_url_raw( $value );
}
