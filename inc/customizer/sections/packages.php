<?php
/**
 * Packages archive section.
 *
 * The hero on /packages/, and nothing else. The bands under it are one per
 * package type, drawn from each type's own archive content model under
 * Packages > Package Types — putting them here as well would be two screens
 * that disagree.
 *
 * Required inside customize_register, so $wp_customize is already in scope.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @var WP_Customize_Manager $wp_customize Customizer manager.
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_section(
	'iflynepal_packages',
	array(
		'title'       => __( 'Packages Archive', 'iflynepal' ),
		'description' => __( 'The hero at the top of /packages/, the page listing every kind of trip. The bands under it come from each package type, under Packages &gt; Package Types.', 'iflynepal' ),
		'priority'    => 34,
	)
);

$wp_customize->add_setting(
	'iflynepal_packages_hero_kicker',
	array(
		'default'           => IFLYNEPAL_PACKAGES_HERO_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_packages_hero_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_packages',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_packages_hero_title',
	array(
		'default'           => IFLYNEPAL_PACKAGES_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_packages_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold serif accent.', 'iflynepal' ),
		'section'     => 'iflynepal_packages',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_packages_hero_lead',
	array(
		'default'           => IFLYNEPAL_PACKAGES_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_packages_hero_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The paragraph under the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_packages',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_packages_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_packages_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_packages',
			'priority'    => 40,
			'mime_type'   => 'image',
		)
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title', 'lead' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_packages_hero_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-packages-hero-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_packages_hero_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_packages_hero_' . $iflynepal_field,
			)
		);
	}
}
