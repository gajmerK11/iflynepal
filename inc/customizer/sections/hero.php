<?php
/**
 * Homepage > Hero section.
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
	'iflynepal_hero',
	array(
		'title'    => __( 'Hero', 'iflynepal' ),
		'panel'    => 'iflynepal_homepage',
		'priority' => 10,
	)
);

/* ------------------------------------------------------------------ title */

$wp_customize->add_setting(
	'iflynepal_hero_title',
	array(
		'default'           => IFLYNEPAL_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;span class="hero-text-style"&gt;word&lt;/span&gt; to give a word the gold accent treatment.', 'iflynepal' ),
		'section'     => 'iflynepal_hero',
		'type'        => 'textarea',
	)
);

/* ---------------------------------------------------------------- buttons */

foreach ( iflynepal_hero_button_defaults() as $iflynepal_index => $iflynepal_button ) {
	$wp_customize->add_setting(
		'iflynepal_hero_button_' . $iflynepal_index . '_label',
		array(
			'default'           => $iflynepal_button['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_hero_button_' . $iflynepal_index . '_label',
		array(
			/* translators: %d: button number. */
			'label'       => sprintf( __( 'Button %d label', 'iflynepal' ), $iflynepal_index ),
			'description' => __( 'Leave empty to hide this button.', 'iflynepal' ),
			'section'     => 'iflynepal_hero',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_hero_button_' . $iflynepal_index . '_url',
		array(
			'default'           => $iflynepal_button['url'],
			'sanitize_callback' => 'iflynepal_sanitize_link',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_hero_button_' . $iflynepal_index . '_url',
		array(
			/* translators: %d: button number. */
			'label'       => sprintf( __( 'Button %d link', 'iflynepal' ), $iflynepal_index ),
			'description' => __( 'A full URL, or an on-page anchor such as #explore.', 'iflynepal' ),
			'section'     => 'iflynepal_hero',
			'type'        => 'text',
		)
	);
}

/* ---------------------------------------------------------- trust points */

/*
 * All four slots are registered here and the Customizer's control script hides
 * the empty ones behind an "Add trust point" button, so the panel shows only as
 * many fields as there are bullets.
 */
$iflynepal_trust_defaults = iflynepal_hero_trust_defaults();

for ( $iflynepal_i = 1; $iflynepal_i <= IFLYNEPAL_HERO_TRUST_MAX; $iflynepal_i++ ) {
	$wp_customize->add_setting(
		'iflynepal_hero_trust_' . $iflynepal_i,
		array(
			'default'           => isset( $iflynepal_trust_defaults[ $iflynepal_i ] ) ? $iflynepal_trust_defaults[ $iflynepal_i ] : '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_hero_trust_' . $iflynepal_i,
		array(
			/* translators: %d: trust point number. */
			'label'   => sprintf( __( 'Trust point %d', 'iflynepal' ), $iflynepal_i ),
			'section' => 'iflynepal_hero',
			'type'    => 'text',
		)
	);
}

/* ------------------------------------------------------------------ media */

$wp_customize->add_setting(
	'iflynepal_hero_background_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'iflynepal_validate_hero_background_image',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_hero_background_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => sprintf(
				/* translators: 1: minimum width in pixels, 2: minimum height in pixels. */
				__( 'Shown immediately, and behind the video. This is the largest element on the page — keep it under 150 KB. Must be landscape and at least %1$d x %2$d pixels.', 'iflynepal' ),
				IFLYNEPAL_HERO_IMAGE_MIN_WIDTH,
				IFLYNEPAL_HERO_IMAGE_MIN_HEIGHT
			),
			'section'     => 'iflynepal_hero',
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_hero_background_video',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_hero_background_video',
		array(
			'label'     => __( 'Background video', 'iflynepal' ),
			'section'   => 'iflynepal_hero',
			'mime_type' => 'video',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_hero_audio',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_hero_audio',
		array(
			'label'       => __( 'Ambient sound', 'iflynepal' ),
			'description' => __( 'Optional. Adds a speaker button to the hero. It never plays on its own — browsers block sound that starts by itself, so the visitor switches it on and the file is only downloaded if they do. Leave empty to hide the button.', 'iflynepal' ),
			'section'     => 'iflynepal_hero',
			'mime_type'   => 'audio',
		)
	)
);

/* --------------------------------------------------------------- partials */

/*
 * Each partial puts a pencil shortcut on its part of the hero in the preview
 * and re-renders just that fragment, rather than reloading the page.
 */
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_hero_title',
		array(
			'selector'        => '#iflynepal-hero-title',
			'settings'        => array( 'iflynepal_hero_title' ),
			'render_callback' => 'iflynepal_render_hero_title',
		)
	);

	$iflynepal_button_settings = array();

	foreach ( array_keys( iflynepal_hero_button_defaults() ) as $iflynepal_index ) {
		$iflynepal_button_settings[] = 'iflynepal_hero_button_' . $iflynepal_index . '_label';
		$iflynepal_button_settings[] = 'iflynepal_hero_button_' . $iflynepal_index . '_url';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_hero_actions',
		array(
			'selector'        => '#iflynepal-hero-actions',
			'settings'        => $iflynepal_button_settings,
			'render_callback' => 'iflynepal_render_hero_actions',
		)
	);

	$iflynepal_trust_settings = array();

	for ( $iflynepal_i = 1; $iflynepal_i <= IFLYNEPAL_HERO_TRUST_MAX; $iflynepal_i++ ) {
		$iflynepal_trust_settings[] = 'iflynepal_hero_trust_' . $iflynepal_i;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_hero_trust_points',
		array(
			'selector'        => '#iflynepal-hero-proof',
			'settings'        => $iflynepal_trust_settings,
			'render_callback' => 'iflynepal_render_hero_trust_points',
		)
	);
}
