<?php
/**
 * Reusable output and lookup helpers used by templates.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * CSS class that marks a primary-menu item as the pill call to action.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NAV_CTA_CLASS = 'nav-cta';

/**
 * Returns the primary menu item flagged as the call to action.
 *
 * The client sets this by adding the "nav-cta" CSS class to a menu item under
 * Appearance > Menus, so the button's label and destination stay editable
 * without touching a template.
 *
 * @since 1.0.0
 *
 * @return array{title:string,url:string}|null The item, or null when none is flagged.
 */
function iflynepal_get_nav_cta_item() {
	static $cached = false;

	if ( false !== $cached ) {
		return $cached;
	}

	$cached    = null;
	$locations = get_nav_menu_locations();

	if ( empty( $locations['primary'] ) ) {
		return $cached;
	}

	$items = wp_get_nav_menu_items( $locations['primary'] );

	if ( ! $items ) {
		return $cached;
	}

	foreach ( $items as $item ) {
		if ( in_array( IFLYNEPAL_NAV_CTA_CLASS, (array) $item->classes, true ) ) {
			$cached = array(
				'title' => $item->title,
				'url'   => $item->url,
			);
			break;
		}
	}

	return $cached;
}

/**
 * Whether the current request renders a hero.
 *
 * Two templates carry one: the front page and the About page. Both use the
 * same component and the same script, so both answer yes here — that script
 * is also what swaps the header from transparent to solid on scroll, and
 * without it a hero template keeps white nav links over white content.
 *
 * Heroes are fixed sections of their templates, not editor content, so this
 * is a template question rather than a post-content one. Kept as its own
 * function because inc/enqueue.php and inc/template-functions.php both
 * condition on it.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_hero() {
	return is_front_page() || iflynepal_has_about();
}

/**
 * Whether the current request renders the Explore Cards section.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_explore() {
	return is_front_page();
}

/**
 * Whether the current request renders the Why-trust section.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_trust() {
	return is_front_page();
}

/**
 * Whether the current request renders the People section.
 *
 * Unlike the sections above it, this one can legitimately be absent: the rail
 * is the section, and an editor who removes every person removes it. The
 * template returns early in that case, so the check has to look at the content
 * as well as the template.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_people() {
	return is_front_page() && iflynepal_people_has_cards();
}

/**
 * Whether the current request renders a testimonial section.
 *
 * The section is reusable and can appear on any template, so this asks whether
 * there is anything to show rather than which page is being viewed. Anything
 * that renders it needs the carousel script.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_testimonials() {
	return (bool) iflynepal_get_testimonials( array( 'limit' => 1 ) );
}

/**
 * Whether the current request renders the FAQ / Travel Guide section.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_guides() {
	return is_front_page();
}

/**
 * Whether the current request renders the closing call to action.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_cta() {
	return is_front_page();
}

/**
 * Whether the current request renders the About page template.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_about() {
	return is_page_template( 'page-about.php' );
}

/**
 * The background image of whichever hero this request renders.
 *
 * The front page and the About page each have their own, and both are the
 * LCP element of their template — so the preconnect and the preload in
 * inc/enqueue.php have to resolve the one actually on the page rather than
 * always reaching for the front page's.
 *
 * @since 1.0.0
 *
 * @return string Image URL, or an empty string when this template has no hero.
 */
function iflynepal_current_hero_image_url() {
	if ( iflynepal_has_about() ) {
		return iflynepal_about_hero_image_url();
	}

	if ( is_front_page() ) {
		return iflynepal_hero_background_image_url();
	}

	return '';
}

/**
 * The origin serving that image, when it is served from another one.
 *
 * @since 1.0.0
 *
 * @return string Scheme and host, or an empty string when same-origin or unset.
 */
function iflynepal_current_hero_image_origin() {
	$url = iflynepal_current_hero_image_url();

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
