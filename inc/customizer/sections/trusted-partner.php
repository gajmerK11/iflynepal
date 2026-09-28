<?php
/**
 * Homepage > Trusted Partner section.
 *
 * The card between the hero and Explore Nepal: a photograph or video on one
 * side, a heading, a portion of the company's story and a button to the
 * About page on the other.
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
	'iflynepal_trusted_partner',
	array(
		'title'       => __( 'Trusted Partner', 'iflynepal' ),
		'description' => __( 'The card between the hero and Explore Nepal.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 15,
	)
);

/* ------------------------------------------------------------------- copy */

$wp_customize->add_setting(
	'iflynepal_partner_title',
	array(
		'default'           => IFLYNEPAL_PARTNER_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_partner_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt;, &lt;em&gt; and &lt;strong&gt;.', 'iflynepal' ),
		'section'     => 'iflynepal_trusted_partner',
		'priority'    => 10,
		'type'        => 'textarea',
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_PARTNER_DESCRIPTION_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_partner_description_' . $iflynepal_paragraph,
		array(
			'default'           => iflynepal_partner_description_default( $iflynepal_paragraph ),
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_partner_description_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => 1 === $iflynepal_paragraph
				? __( 'A portion of the company&#8217;s story, not the whole thing — this card should read as an invitation to the About page, not a second copy of it. Emptying this removes the paragraph.', 'iflynepal' )
				: __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_trusted_partner',
			'priority'    => 19 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

/* ---------------------------------------------------------------- button */

$wp_customize->add_setting(
	'iflynepal_partner_button_label',
	array(
		'default'           => IFLYNEPAL_PARTNER_BUTTON_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_partner_button_label',
	array(
		'label'       => __( 'Button label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_trusted_partner',
		'priority'    => 30,
		'type'        => 'text',
	)
);

iflynepal_customizer_add_link_field(
	$wp_customize,
	'iflynepal_partner_button_url',
	array(
		'default'           => iflynepal_partner_about_page_url(),
		'sanitize_callback' => 'iflynepal_sanitize_link',
	),
	array(
		'label'       => __( 'Button link', 'iflynepal' ),
		'description' => __( 'Defaults to the About page. A full URL, or an on-page anchor such as #explore.', 'iflynepal' ),
		'section'     => 'iflynepal_trusted_partner',
		'priority'    => 40,
		'type'        => 'text',
	)
);

/* ------------------------------------------------------------------ media */

$wp_customize->add_setting(
	'iflynepal_partner_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_partner_image',
		array(
			'label'       => __( 'Image', 'iflynepal' ),
			'description' => __( 'Shown on its own, or as the video\'s poster frame while it loads.', 'iflynepal' ),
			'section'     => 'iflynepal_trusted_partner',
			'priority'    => 50,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_partner_video',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_partner_video',
		array(
			'label'       => __( 'Video', 'iflynepal' ),
			'description' => __( 'Optional. Replaces the image above with a playable video, using the image as its poster frame.', 'iflynepal' ),
			'section'     => 'iflynepal_trusted_partner',
			'priority'    => 60,
			'mime_type'   => 'video',
		)
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_partner_title',
		array(
			'selector'        => '#iflynepal-partner-title',
			'settings'        => array( 'iflynepal_partner_title' ),
			'render_callback' => 'iflynepal_render_partner_title',
		)
	);

	$iflynepal_description_settings = array();

	for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_PARTNER_DESCRIPTION_MAX; $iflynepal_paragraph++ ) {
		$iflynepal_description_settings[] = 'iflynepal_partner_description_' . $iflynepal_paragraph;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_partner_description',
		array(
			'selector'        => '#iflynepal-partner-description',
			'settings'        => $iflynepal_description_settings,
			'render_callback' => 'iflynepal_render_partner_description',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_partner_button',
		array(
			'selector'        => '#iflynepal-partner-button',
			'settings'        => array( 'iflynepal_partner_button_label', 'iflynepal_partner_button_url' ),
			'render_callback' => 'iflynepal_render_partner_button',
		)
	);
}
