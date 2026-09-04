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
 * Whether the current request renders the hero section.
 *
 * The hero and Explore Cards are fixed sections of front-page.php, not
 * editor content, so "does this page have one" is just "is this the front
 * page" — no post-content sniffing needed. Kept as its own function because
 * inc/enqueue.php and inc/template-functions.php both condition on it and the
 * two sections could diverge onto different templates later.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_hero() {
	return is_front_page();
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
