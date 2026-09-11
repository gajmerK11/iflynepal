<?php
/**
 * Privacy Policy panel.
 *
 * One section, the hero, inside a panel of its own — the arrangement the Terms
 * & Conditions and Cookie Policy pages use, so the legal pages sit side by side
 * in the Customizer list and are found the same way. The policy body is not
 * editable; see inc/privacy.php for why.
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
	'iflynepal_privacy_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The photograph at the top of the Privacy Policy page. The headline is part of the document and is not editable here.', 'iflynepal' ),
		'panel'       => 'iflynepal_privacy',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_privacy_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_privacy_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_privacy_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);
