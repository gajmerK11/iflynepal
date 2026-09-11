<?php
/**
 * Sustainability Policy panel.
 *
 * Two sections: the hero, as on the other legal pages, and the Sustainability
 * Coordinator card in clause 06. The policy body is not editable; see
 * inc/sustainability.php for why.
 *
 * Required inside customize_register, so $wp_customize is already in scope.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @var WP_Customize_Manager $wp_customize Customizer manager.
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------- hero */

$wp_customize->add_section(
	'iflynepal_sustainability_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The photograph at the top of the Sustainability Policy page. The headline is part of the document and is not editable here.', 'iflynepal' ),
		'panel'       => 'iflynepal_sustainability',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_sustainability_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_sustainability_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_sustainability_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

/* ------------------------------------------------------------- coordinator */

$wp_customize->add_section(
	'iflynepal_sustainability_coordinator',
	array(
		'title'       => __( 'Sustainability Coordinator', 'iflynepal' ),
		'description' => __( 'The contact card under "Governance & Management" (clause 06).', 'iflynepal' ),
		'panel'       => 'iflynepal_sustainability',
		'priority'    => 20,
	)
);

$wp_customize->add_setting(
	'iflynepal_sustainability_coordinator_name',
	array(
		'default'           => IFLYNEPAL_SUSTAINABILITY_COORDINATOR_NAME_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_sustainability_coordinator_name',
	array(
		'label'       => __( 'Name', 'iflynepal' ),
		'description' => __( 'Empty hides the card.', 'iflynepal' ),
		'section'     => 'iflynepal_sustainability_coordinator',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_sustainability_coordinator_email',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_sustainability_coordinator_email',
	array(
		'label'       => __( 'Email', 'iflynepal' ),
		'description' => __( 'Empty follows the footer\'s office email.', 'iflynepal' ),
		'section'     => 'iflynepal_sustainability_coordinator',
		'priority'    => 20,
		'type'        => 'email',
	)
);

$wp_customize->add_setting(
	'iflynepal_sustainability_coordinator_phone',
	array(
		'default'           => IFLYNEPAL_SUSTAINABILITY_COORDINATOR_PHONE_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_sustainability_coordinator_phone',
	array(
		'label'       => __( 'Phone', 'iflynepal' ),
		'description' => __( 'Shown as written; the link dials the digits. Empty hides it.', 'iflynepal' ),
		'section'     => 'iflynepal_sustainability_coordinator',
		'priority'    => 30,
		'type'        => 'text',
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_sustainability_coordinator',
	array(
		'selector'            => '#iflynepal-sustain-coordinator',
		'settings'            => array(
			'iflynepal_sustainability_coordinator_name',
			'iflynepal_sustainability_coordinator_email',
			'iflynepal_sustainability_coordinator_phone',
		),
		'render_callback'     => 'iflynepal_render_sustainability_coordinator',
		'container_inclusive' => false,
	)
);
