<?php
/**
 * Keeps the admin toolbar in English, regardless of which language the
 * front-end page underneath it is showing.
 *
 * Polylang switches the whole request's locale to match whichever language a
 * front-end page is viewed in, so that page's own content translates
 * correctly — but that locale switch is global for the request, and the
 * admin toolbar's default items ("Edit Page", "Customize", "New", …) are
 * built by core with plain `__()` calls that get swept up in it too. An
 * editor viewing the French homepage ends up with a French toolbar, even
 * though nothing about the toolbar itself is content a visitor ever sees.
 *
 * `switch_to_locale()`/`restore_current_locale()` — the pairing WordPress
 * documents for exactly this ("show this one part of the page in a different
 * language") — turned out not to fit here: switching *to* English has
 * nothing to load, since English is the untranslated source language with no
 * .mo file of its own, so the already-loaded French strings from the page's
 * own locale switch were left in place instead of being cleared. Filtering
 * `gettext` (and its plural/context siblings) to hand back the original,
 * untranslated string for the one window the toolbar is being built in sidesteps
 * that entirely — it does not depend on any locale or file being loaded at all.
 *
 * wp-admin itself is unaffected by this file and needs no fix — the
 * dashboard already always uses the user's own profile language
 * (`get_user_locale()`), never the front-end page's language, regardless of
 * Polylang.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hands back the original (English) string instead of its translation.
 *
 * @since 1.0.0
 *
 * @param string $translation Translated text.
 * @param string $text        Original, untranslated text.
 * @return string
 */
function iflynepal_admin_bar_untranslate( $translation, $text ) {
	return $text;
}

/**
 * Same as iflynepal_admin_bar_untranslate(), for a translation looked up with
 * a disambiguating context (`_x()`/`_ex()`).
 *
 * @since 1.0.0
 *
 * @param string $translation Translated text.
 * @param string $text        Original, untranslated text.
 * @return string
 */
function iflynepal_admin_bar_untranslate_with_context( $translation, $text ) {
	return $text;
}

/**
 * Same as iflynepal_admin_bar_untranslate(), for a singular/plural pair.
 *
 * @since 1.0.0
 *
 * @param string $translation Translated text.
 * @param string $single      Singular form, untranslated.
 * @param string $plural      Plural form, untranslated.
 * @param int    $number      The number deciding which form applies.
 * @return string
 */
function iflynepal_admin_bar_untranslate_plural( $translation, $single, $plural, $number ) {
	return 1 === (int) $number ? $single : $plural;
}

/**
 * Starts overriding translations, just before core and every plugin add
 * their nodes to the toolbar.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_admin_bar_use_english() {
	if ( is_admin() ) {
		return; // wp-admin already renders in the user's own language.
	}

	add_filter( 'gettext', 'iflynepal_admin_bar_untranslate', 999, 2 );
	add_filter( 'gettext_with_context', 'iflynepal_admin_bar_untranslate_with_context', 999, 2 );
	add_filter( 'ngettext', 'iflynepal_admin_bar_untranslate_plural', 999, 4 );
	add_filter( 'ngettext_with_context', 'iflynepal_admin_bar_untranslate_plural', 999, 4 );
}
add_action( 'admin_bar_menu', 'iflynepal_admin_bar_use_english', -999 );

/**
 * Stops overriding translations once the toolbar is fully built, so the page
 * content rendered around it keeps translating normally.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_admin_bar_restore_translation() {
	if ( is_admin() ) {
		return;
	}

	remove_filter( 'gettext', 'iflynepal_admin_bar_untranslate', 999 );
	remove_filter( 'gettext_with_context', 'iflynepal_admin_bar_untranslate_with_context', 999 );
	remove_filter( 'ngettext', 'iflynepal_admin_bar_untranslate_plural', 999 );
	remove_filter( 'ngettext_with_context', 'iflynepal_admin_bar_untranslate_plural', 999 );
}
add_action( 'wp_before_admin_bar_render', 'iflynepal_admin_bar_restore_translation', 999 );
