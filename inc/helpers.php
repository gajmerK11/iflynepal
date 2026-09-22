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
 * Sanitizes copy that is allowed to carry a link.
 *
 * The text filter above deliberately does not allow `<a>`: nearly every field
 * in this theme is a headline or a line of copy whose link, if it has one, is
 * its own setting with its own URL sanitizer. A running paragraph that names an
 * address mid-sentence is the exception — splitting it into text, link and more
 * text would take one sentence and make it three fields.
 *
 * `href` is left to wp_kses's own protocol filtering, which allows mailto and
 * tel alongside http(s) and rejects javascript:.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized HTML.
 */
function iflynepal_kses_rich( $value ) {
	return wp_kses(
		(string) $value,
		array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
				'rel'    => array(),
			),
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
 * Sanitizes a Customizer checkbox.
 *
 * An unchecked box posts nothing at all, so the value arrives as null rather
 * than as false — hence a cast rather than a comparison.
 *
 * @since 1.0.0
 *
 * @param mixed $value Raw value.
 * @return bool Whether the box is ticked.
 */
function iflynepal_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitizes a telephone number typed the way people write them.
 *
 * The stored value keeps whatever the editor typed minus anything that is not
 * a digit, a plus, a space, a dash or a bracket; the readers that need a dialable
 * string reduce it to digits themselves. Keeping the shape means the field still
 * reads as the number the editor recognises when they come back to it.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized number.
 */
function iflynepal_sanitize_phone( $value ) {
	return trim( preg_replace( '/[^0-9+()\-\s]/', '', (string) $value ) );
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

/**
 * Builds the attributes an `<a>` needs for a stored link field.
 *
 * A real URL prints as an ordinary `href`. An in-page anchor (`#id`) does not:
 * a hash `href` always shows the resolved target in the status bar on hover,
 * and every anchor on the site used to reveal exactly that — hovering "Explore
 * Retreats" showed `.../retreat-nepal/#iflynepal-packages` in the chrome
 * before a visitor ever clicked. There is no CSS or HTML way to keep an `href`
 * and lose that preview, so an anchor gets no `href` at all: instead
 * `data-iflynepal-scroll` carries the target id and
 * assets/js/global/anchor-scroll.js does the scrolling on click (and on
 * Enter/Space, since `role="button" tabindex="0"` is what makes the element
 * focusable without one). The trade-off, accepted deliberately, is that these
 * links need JavaScript — a bare `#` (a JS hook with no scroll target, same as
 * a menu toggle) prints nothing at all rather than a dead attribute.
 *
 * @since 1.0.0
 *
 * @param string $url Stored link value, already run through iflynepal_sanitize_link().
 * @return string Attribute markup, ready to print inside an `<a ...>` tag.
 */
function iflynepal_anchor_attr( $url ) {
	$url = trim( (string) $url );

	if ( '' === $url ) {
		return '';
	}

	if ( '#' === $url[0] ) {
		$target = ltrim( $url, '#' );

		if ( '' === $target ) {
			return '';
		}

		return sprintf( 'data-iflynepal-scroll="%s" role="button" tabindex="0"', esc_attr( $target ) );
	}

	return sprintf( 'href="%s"', esc_url( $url ) );
}
