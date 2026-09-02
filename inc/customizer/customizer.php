<?php
/**
 * Customizer bootstrap.
 *
 * Callbacks are required on every request because selective refresh calls them
 * from the front end; sections are required only while the Customizer is being
 * registered, since nothing else needs them.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/hero.php';

/**
 * Registers the theme's panels and sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function iflynepal_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_panel(
		'iflynepal_homepage',
		array(
			'title'       => __( 'Homepage', 'iflynepal' ),
			'description' => __( 'Content for each section of the front page, in the order it appears.', 'iflynepal' ),
			'priority'    => 30,
		)
	);

	require IFLYNEPAL_DIR . '/inc/customizer/sections/hero.php';
}
add_action( 'customize_register', 'iflynepal_customize_register' );

/**
 * Enqueues the scripts that drive the Customizer's own controls.
 *
 * These run in the Customizer panel, not on the front end, so they never reach
 * a visitor. One file per behaviour, grouped by the section it belongs to.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_customizer_controls_assets() {
	wp_enqueue_script(
		'iflynepal-customizer-repeater',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/repeater.js',
		array( 'jquery', 'customize-controls' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/repeater.js' ),
		true
	);

	wp_enqueue_script(
		'iflynepal-customizer-hero-trust-points',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/trust-points.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/trust-points.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-hero-trust-points',
		'iflynepalHeroTrust',
		array(
			'max'         => IFLYNEPAL_HERO_TRUST_MAX,
			'addLabel'    => __( 'Add trust point', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of trust points. */
				__( 'Maximum %d trust points allowed.', 'iflynepal' ),
				IFLYNEPAL_HERO_TRUST_MAX
			),
			/* translators: %d: trust point number. */
			'removeLabel' => __( 'Remove trust point %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-hero-background-image',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/background-image.js',
		array( 'jquery', 'customize-controls', 'media-views' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/background-image.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-hero-background-image',
		'iflynepalHeroImage',
		array(
			'minWidth'  => IFLYNEPAL_HERO_IMAGE_MIN_WIDTH,
			'minHeight' => IFLYNEPAL_HERO_IMAGE_MIN_HEIGHT,
			'minRatio'  => IFLYNEPAL_HERO_IMAGE_MIN_RATIO,
			'message'   => __( "The image's quality and size is not compatible", 'iflynepal' ),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'iflynepal_customizer_controls_assets' );
