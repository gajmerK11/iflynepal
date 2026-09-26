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
 * Sanitizes a heading that carries the site's "ink" underline accent.
 *
 * The accent is `<span class="ink-mark">word<i class="ink-line"></i></span>`
 * (template-parts/authors/authors-layout.php and its siblings), one tag wider
 * than iflynepal_kses_text() allows: that filter has no `<i>`, since nowhere
 * else in the theme needs one.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized HTML.
 */
function iflynepal_kses_ink_heading( $value ) {
	return wp_kses(
		(string) $value,
		array(
			'span'   => array(
				'class' => array(),
			),
			'i'      => array(
				'class' => array(),
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
 * Whether the site currently has more than one Polylang language.
 *
 * Gates every per-language Customizer link field below: on a single-language
 * install there is nothing to switch between, so the field stays exactly as
 * it always was — one setting, one control, no migration to worry about.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_customizer_is_multilingual() {
	return function_exists( 'pll_languages_list' ) && count( pll_languages_list() ) > 1;
}

/**
 * Registers a link-type Customizer setting/control, once per language.
 *
 * A Customizer setting is one value; there is no built-in way to hold "one
 * URL per language" behind a single control. So instead this registers one
 * plain-suffixed setting per language (`{$id}_en`, `{$id}_fr`, ...), each
 * with its own control labelled with the language name, and always on
 * 'refresh' transport — splitting the value per language means the existing
 * postMessage preview JS, which listens for the un-suffixed id, can no
 * longer bind to it, so a full preview reload replaces the instant update.
 * On a single-language site this registers the one setting/control exactly
 * as before, untouched.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize  Customizer manager.
 * @param string               $id            Base setting/control id, e.g. 'iflynepal_hero_button_1_url'.
 * @param array                $setting_args  Args for add_setting(), same for every language.
 * @param array                $control_args  Args for add_control(); 'label' gets the language name appended.
 * @return void
 */
function iflynepal_customizer_add_link_field( $wp_customize, $id, $setting_args, $control_args ) {
	$setting_args['transport'] = 'refresh';

	if ( ! iflynepal_customizer_is_multilingual() ) {
		$wp_customize->add_setting( $id, $setting_args );
		$wp_customize->add_control( $id, $control_args );
		return;
	}

	/*
	 * Seeds every language's field with today's already-saved single value
	 * (falling back to the theme's own default only if nothing was ever
	 * saved), rather than the theme default outright — otherwise opening the
	 * Customizer for the first time after this split would show a site that
	 * had been customized as if it had just been reset to defaults.
	 */
	$setting_args['default'] = get_theme_mod( $id, isset( $setting_args['default'] ) ? $setting_args['default'] : '' );

	foreach ( PLL()->model->get_languages_list() as $iflynepal_lang ) {
		$lang_control_args          = $control_args;
		$lang_control_args['label'] = sprintf( '%s (%s)', $control_args['label'], $iflynepal_lang->name );

		$wp_customize->add_setting( $id . '_' . $iflynepal_lang->slug, $setting_args );
		$wp_customize->add_control( $id . '_' . $iflynepal_lang->slug, $lang_control_args );
	}
}

/**
 * Reads a per-language link Customizer setting for the current front-end language.
 *
 * Pairs with iflynepal_customizer_add_link_field(). Falls back to the plain,
 * un-suffixed mod when nothing has been saved yet for the current language —
 * the state every one of these fields is in immediately after this per-language
 * split ships, since the old single value never gets copied automatically.
 *
 * @since 1.0.0
 *
 * @param string $id      Base setting id, e.g. 'iflynepal_hero_button_1_url'.
 * @param string $default Default when nothing is stored at all.
 * @return string
 */
function iflynepal_customizer_get_link( $id, $default = '' ) {
	if ( iflynepal_customizer_is_multilingual() ) {
		$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : '';

		if ( $lang ) {
			$mod = get_theme_mod( $id . '_' . $lang, null );

			if ( null !== $mod && '' !== $mod ) {
				return (string) $mod;
			}
		}
	}

	return (string) get_theme_mod( $id, $default );
}

/**
 * Reads a per-language, non-link Customizer setting for the current front-end language.
 *
 * Same fallback rule as iflynepal_customizer_get_link() — a per-language mod
 * that was never saved falls back to the legacy, un-suffixed one — but for a
 * plain scalar value like a chosen post ID rather than a sanitized link, e.g.
 * a per-language "which post goes in this slot" select field.
 *
 * @since 1.0.0
 *
 * @param string $id      Base setting id.
 * @param mixed  $default Default when nothing is stored at all.
 * @return mixed
 */
function iflynepal_customizer_get_choice( $id, $default = 0 ) {
	if ( iflynepal_customizer_is_multilingual() ) {
		$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : '';

		if ( $lang ) {
			$mod = get_theme_mod( $id . '_' . $lang, null );

			if ( null !== $mod && '' !== $mod ) {
				return $mod;
			}
		}
	}

	return get_theme_mod( $id, $default );
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
