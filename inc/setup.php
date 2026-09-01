<?php
/**
 * Theme setup: supports, menus, image sizes, text domain.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers theme supports and navigation menus.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_setup() {
	load_theme_textdomain( 'iflynepal', IFLYNEPAL_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// The design's brand lockup is 207x160 at source; flex sizing lets the client
	// upload their own without the theme cropping it.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 207,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'iflynepal' ),
		)
	);
}
add_action( 'after_setup_theme', 'iflynepal_setup' );
