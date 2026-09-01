<?php
/**
 * Filters that reshape core output.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Styles primary-menu links and hides the call-to-action item from the list.
 *
 * The call to action is rendered separately by the header so it survives the
 * mobile collapse (see template-parts/header/site-navigation.php); leaving it
 * in the list as well would render it twice.
 *
 * @since 1.0.0
 *
 * @param array    $classes Menu item CSS classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    wp_nav_menu arguments.
 * @return array Filtered classes.
 */
function iflynepal_nav_menu_css_class( $classes, $item, $args ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $classes;
	}

	if ( in_array( IFLYNEPAL_NAV_CTA_CLASS, (array) $item->classes, true ) ) {
		$classes[] = 'iflynepal-menu-item--hidden';
	}

	$classes[] = 'iflynepal-menu-item';

	return $classes;
}
add_filter( 'nav_menu_css_class', 'iflynepal_nav_menu_css_class', 10, 3 );

/**
 * Right-sizes the custom logo request.
 *
 * Core requests the logo at full size. The design renders it 68px tall — 88px
 * wide — so without a sizes hint the browser downloads the original for a slot
 * a fraction of its width, in the header, above the fold.
 *
 * @since 1.0.0
 *
 * @param array $attr Image attributes.
 * @return array Filtered attributes.
 */
function iflynepal_custom_logo_attributes( $attr ) {
	$attr['sizes'] = '(max-width: 520px) 62px, 88px';

	return $attr;
}
add_filter( 'get_custom_logo_image_attributes', 'iflynepal_custom_logo_attributes' );

/**
 * Adds a body class while the front page is displayed.
 *
 * The header sits over the hero rather than above it, which only applies on
 * templates that render one.
 *
 * @since 1.0.0
 *
 * @param string[] $classes Body classes.
 * @return string[] Filtered classes.
 */
function iflynepal_body_class( $classes ) {
	if ( iflynepal_has_hero() ) {
		$classes[] = 'has-iflynepal-hero';
	}

	return $classes;
}
add_filter( 'body_class', 'iflynepal_body_class' );
