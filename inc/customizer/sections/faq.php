<?php
/**
 * FAQ / Travel Guide > FAQ section.
 *
 * The left column of the guides section: kicker, heading, the questions, and
 * the link beneath them.
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
	'iflynepal_faq',
	array(
		'title'       => __( 'FAQ', 'iflynepal' ),
		'description' => __( 'The questions column, on the left of the section.', 'iflynepal' ),
		'panel'       => 'iflynepal_guides',
		'priority'    => 10,
	)
);

/* ------------------------------------------------------------------ intro */

$wp_customize->add_setting(
	'iflynepal_faq_kicker',
	array(
		'default'           => IFLYNEPAL_FAQ_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_faq_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_faq',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_faq_title',
	array(
		'default'           => IFLYNEPAL_FAQ_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_faq_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_faq',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

/* -------------------------------------------------------------- questions */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_faq_items_heading',
		array(
			'label'    => __( 'Questions', 'iflynepal' ),
			'section'  => 'iflynepal_faq',
			'priority' => 30,
			'settings' => array(),
		)
	)
);

/*
 * All question slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add question" button.
 */
for ( $iflynepal_faq = 1; $iflynepal_faq <= IFLYNEPAL_FAQ_MAX; $iflynepal_faq++ ) {
	$iflynepal_default  = iflynepal_faq_default( $iflynepal_faq );
	$iflynepal_priority = 30 + ( $iflynepal_faq * 10 );

	$wp_customize->add_setting(
		'iflynepal_faq_' . $iflynepal_faq . '_question',
		array(
			'default'           => $iflynepal_default['question'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_faq_' . $iflynepal_faq . '_question',
		array(
			/* translators: %d: question number. */
			'label'       => sprintf( __( 'Question %d', 'iflynepal' ), $iflynepal_faq ),
			'description' => __( 'Emptying this removes the question.', 'iflynepal' ),
			'section'     => 'iflynepal_faq',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_faq_' . $iflynepal_faq . '_answer',
		array(
			'default'           => $iflynepal_default['answer'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_faq_' . $iflynepal_faq . '_answer',
		array(
			/* translators: %d: question number. */
			'label'    => sprintf( __( 'Answer %d', 'iflynepal' ), $iflynepal_faq ),
			'section'  => 'iflynepal_faq',
			'priority' => $iflynepal_priority + 2,
			'type'     => 'textarea',
		)
	);
}

/* ------------------------------------------------------------------- link */

$iflynepal_faq_cta = iflynepal_faq_cta_defaults();

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_faq_cta_heading',
		array(
			'label'    => __( 'Link under the questions', 'iflynepal' ),
			'section'  => 'iflynepal_faq',
			'priority' => 200,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_faq_cta_label',
	array(
		'default'           => $iflynepal_faq_cta['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_faq_cta_label',
	array(
		'label'       => __( 'Label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the link.', 'iflynepal' ),
		'section'     => 'iflynepal_faq',
		'priority'    => 201,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_faq_cta_url',
	array(
		'default'           => $iflynepal_faq_cta['url'],
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_faq_cta_url',
	array(
		'label'       => __( 'Link', 'iflynepal' ),
		'description' => __( 'A full URL, or an on-page anchor such as #people.', 'iflynepal' ),
		'section'     => 'iflynepal_faq',
		'priority'    => 202,
		'type'        => 'text',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_faq_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-faq-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_faq_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_faq_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_item_settings = array();

	for ( $iflynepal_faq = 1; $iflynepal_faq <= IFLYNEPAL_FAQ_MAX; $iflynepal_faq++ ) {
		$iflynepal_item_settings[] = 'iflynepal_faq_' . $iflynepal_faq . '_question';
		$iflynepal_item_settings[] = 'iflynepal_faq_' . $iflynepal_faq . '_answer';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_faq_items',
		array(
			'selector'        => '#iflynepal-faq-items',
			'settings'        => $iflynepal_item_settings,
			'render_callback' => 'iflynepal_render_faq_items',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_faq_cta',
		array(
			'selector'        => '#iflynepal-faq-cta',
			'settings'        => array( 'iflynepal_faq_cta_label', 'iflynepal_faq_cta_url' ),
			'render_callback' => 'iflynepal_render_faq_cta',
		)
	);
}
