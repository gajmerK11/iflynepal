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

	/*
	 * The footer's three link columns take their heading from the name of the
	 * menu assigned to them, so the client controls both the heading and the
	 * links from Appearance > Menus alone. The slot label reflects that back:
	 * once a menu is assigned, the location reads "Footer-1: Main activities"
	 * rather than a bare number, which is otherwise impossible to tell apart in
	 * the Menu location list. Mirrors CloudColleague's footer slots.
	 *
	 * The legal row is its own slot because it renders differently: no heading,
	 * laid out across the bottom bar rather than as a column.
	 */
	$iflynepal_assigned = get_nav_menu_locations();
	$iflynepal_menus    = array( 'primary' => esc_html__( 'Primary Menu', 'iflynepal' ) );

	foreach ( iflynepal_footer_menu_slots() as $iflynepal_location => $iflynepal_label ) {
		$iflynepal_menu = isset( $iflynepal_assigned[ $iflynepal_location ] )
			? wp_get_nav_menu_object( $iflynepal_assigned[ $iflynepal_location ] )
			: null;

		$iflynepal_menus[ $iflynepal_location ] = $iflynepal_menu
			? $iflynepal_label . ': ' . $iflynepal_menu->name
			: $iflynepal_label;
	}

	$iflynepal_menus[ IFLYNEPAL_FOOTER_LEGAL_LOCATION ] = esc_html__( 'Footer: Legal links', 'iflynepal' );

	register_nav_menus( $iflynepal_menus );
}
add_action( 'after_setup_theme', 'iflynepal_setup' );

/**
 * The footer's menu locations, in the order they are rendered.
 *
 * Kept as its own function because three things need the list: the
 * registration above, the footer template that walks the columns, and the
 * label each slot falls back to before a menu is assigned.
 *
 * @since 1.0.0
 *
 * @return string[] Slot labels keyed by theme location.
 */
function iflynepal_footer_menu_slots() {
	return array(
		'footer-1' => esc_html__( 'Footer-1', 'iflynepal' ),
		'footer-2' => esc_html__( 'Footer-2', 'iflynepal' ),
		'footer-3' => esc_html__( 'Footer-3', 'iflynepal' ),
	);
}

/**
 * The location of the legal row along the bottom of the footer.
 *
 * Separate from the columns above because it carries no heading and is laid
 * out in a row, so the footer template treats it differently.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_FOOTER_LEGAL_LOCATION = 'footer-legal';
