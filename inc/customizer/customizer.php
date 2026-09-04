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
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/explore.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/trust.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/people.php';

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

	/*
	 * Control classes extend WP_Customize_Control, which only exists once the
	 * Customizer is being registered — so they load here rather than at the top
	 * of the file.
	 */
	require_once IFLYNEPAL_DIR . '/inc/customizer/controls/class-ifly-nepal-customize-heading-control.php';

	require IFLYNEPAL_DIR . '/inc/customizer/sections/hero.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/explore.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/trust.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/people.php';
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
		'iflynepal-customizer-explore-links',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/explore/links.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/explore/links.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-explore-links',
		'iflynepalExploreLinks',
		array(
			'cards'       => range( 1, IFLYNEPAL_EXPLORE_CARDS ),
			'max'         => IFLYNEPAL_EXPLORE_LINK_MAX,
			'addLabel'    => __( 'Add link', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of links per card. */
				__( 'Maximum %d links allowed.', 'iflynepal' ),
				IFLYNEPAL_EXPLORE_LINK_MAX
			),
			/* translators: %d: link number. */
			'removeLabel' => __( 'Remove link %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-trust-logos',
		IFLYNEPAL_URI . '/assets/js/homepage/trust/logos.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/trust/logos.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-trust-logos',
		'iflynepalTrustLogos',
		array(
			'groups'      => array( 'partner', 'association' ),
			'max'         => IFLYNEPAL_TRUST_LOGO_MAX,
			'addLabel'    => __( 'Add logo', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of logos per band. */
				__( 'Maximum %d logos allowed.', 'iflynepal' ),
				IFLYNEPAL_TRUST_LOGO_MAX
			),
			/* translators: %d: logo number. */
			'removeLabel' => __( 'Remove logo %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-people-cards',
		IFLYNEPAL_URI . '/assets/js/homepage/people/cards.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/people/cards.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-people-cards',
		'iflynepalPeopleCards',
		array(
			'max'         => IFLYNEPAL_PEOPLE_CARD_MAX,
			'addLabel'    => __( 'Add person', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of people in the rail. */
				__( 'Maximum %d people allowed.', 'iflynepal' ),
				IFLYNEPAL_PEOPLE_CARD_MAX
			),
			/* translators: %d: person number. */
			'removeLabel' => __( 'Remove person %d', 'iflynepal' ),
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

/**
 * Styles the group headings inside a section.
 *
 * A rule apiece, printed inline rather than shipped as a stylesheet: it is a
 * handful of declarations that only ever apply inside the Customizer panel, and
 * a separate file would be another request for them.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_customizer_controls_styles() {
	?>
	<style id="iflynepal-customizer-controls">
		.customize-control-iflynepal-heading {
			margin-bottom: 4px;
			padding-top: 16px;
			border-top: 1px solid #dcdcde;
		}

		.customize-control-iflynepal-heading .iflynepal-customize-heading {
			margin-bottom: 0;
			color: #1d2327;
			font-size: 14px;
			font-weight: 600;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'iflynepal_customizer_controls_styles' );
