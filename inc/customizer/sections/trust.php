<?php
/**
 * Homepage > Why Trust iFly Nepal section.
 *
 * One section holds the whole thing: the heading, the four bullets, the promo
 * card and both logo bands. The Customizer has no nested panels and no native
 * way to group controls, so the four groups are separated by
 * IFly_Nepal_Customize_Heading_Control rather than being split into sections of
 * their own.
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
	'iflynepal_trust',
	array(
		'title'       => __( 'Why Trust iFly Nepal', 'iflynepal' ),
		'description' => __( 'The heading, the four proof points, the planning card beside them, and the two logo bands beneath.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 30,
	)
);

/* ------------------------------------------------------------------ intro */

$wp_customize->add_setting(
	'iflynepal_trust_kicker',
	array(
		'default'           => IFLYNEPAL_TRUST_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_trust',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_title',
	array(
		'default'           => IFLYNEPAL_TRUST_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_trust',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

/* --------------------------------------------------------------- features */

$iflynepal_icon_choices = array();

foreach ( iflynepal_trust_icons() as $iflynepal_slug => $iflynepal_icon ) {
	$iflynepal_icon_choices[ $iflynepal_slug ] = $iflynepal_icon['label'];
}

for ( $iflynepal_feature = 1; $iflynepal_feature <= IFLYNEPAL_TRUST_FEATURES; $iflynepal_feature++ ) {
	$iflynepal_prefix  = 'iflynepal_trust_feature_' . $iflynepal_feature . '_';
	$iflynepal_default = iflynepal_trust_feature_default( $iflynepal_feature );

	// Each bullet gets a 10-wide band, leaving room for its three fields.
	$iflynepal_priority = 30 + ( ( $iflynepal_feature - 1 ) * 10 );

	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			$iflynepal_prefix . 'heading',
			array(
				'label'    => sprintf(
					/* translators: %d: proof point number. */
					__( 'Proof point %d', 'iflynepal' ),
					$iflynepal_feature
				),
				'section'  => 'iflynepal_trust',
				'priority' => $iflynepal_priority,
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'icon',
		array(
			'default'           => $iflynepal_default['icon'],
			'sanitize_callback' => 'iflynepal_sanitize_trust_icon',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'icon',
		array(
			'label'       => __( 'Icon', 'iflynepal' ),
			'description' => __( 'Drawn in the theme, so it takes the section\'s colours and stays sharp at any size.', 'iflynepal' ),
			'section'     => 'iflynepal_trust',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'select',
			'choices'     => $iflynepal_icon_choices,
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'title',
		array(
			'default'           => $iflynepal_default['title'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'title',
		array(
			'label'    => __( 'Title', 'iflynepal' ),
			'section'  => 'iflynepal_trust',
			'priority' => $iflynepal_priority + 2,
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'description',
		array(
			'default'           => $iflynepal_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_trust',
			'priority' => $iflynepal_priority + 3,
			'type'     => 'textarea',
		)
	);
}

/* ------------------------------------------------------------- promo card */

$iflynepal_promo_defaults = iflynepal_trust_promo_defaults();

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_trust_promo_heading',
		array(
			'label'    => __( 'Planning card', 'iflynepal' ),
			'section'  => 'iflynepal_trust',
			'priority' => 80,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_kicker',
	array(
		'default'           => $iflynepal_promo_defaults['kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_promo_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_trust',
		'priority' => 81,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_title',
	array(
		'default'           => $iflynepal_promo_defaults['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_promo_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_trust',
		'priority'    => 82,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_description',
	array(
		'default'           => $iflynepal_promo_defaults['description'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_promo_description',
	array(
		'label'    => __( 'Description', 'iflynepal' ),
		'section'  => 'iflynepal_trust',
		'priority' => 83,
		'type'     => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_button_label',
	array(
		'default'           => $iflynepal_promo_defaults['button_label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_promo_button_label',
	array(
		'label'       => __( 'Button label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_trust',
		'priority'    => 84,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_button_url',
	array(
		'default'           => $iflynepal_promo_defaults['button_url'],
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_trust_promo_button_url',
	array(
		'label'       => __( 'Button link', 'iflynepal' ),
		'description' => __( 'A full URL, or an on-page anchor such as #explore.', 'iflynepal' ),
		'section'     => 'iflynepal_trust',
		'priority'    => 85,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_trust_promo_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_trust_promo_image',
		array(
			'label'       => __( 'Card background image', 'iflynepal' ),
			'description' => __( 'Sits behind the card under a dark gradient, so a photograph with room at the bottom works best. Landscape, at least 1200px wide.', 'iflynepal' ),
			'section'     => 'iflynepal_trust',
			'priority'    => 86,
			'mime_type'   => 'image',
		)
	)
);

/* ------------------------------------------------------------ logo bands */

/*
 * Both bands are the same control twice over, so they are registered from one
 * table. All ten slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add logo" button.
 */
$iflynepal_logo_bands = array(
	'partner'     => array(
		'heading'  => __( 'Partners', 'iflynepal' ),
		/* translators: %d: logo number. */
		'label'    => __( 'Partner logo %d', 'iflynepal' ),
		'priority' => 90,
	),
	'association' => array(
		'heading'  => __( 'Association', 'iflynepal' ),
		/* translators: %d: logo number. */
		'label'    => __( 'Association logo %d', 'iflynepal' ),
		'priority' => 120,
	),
);

foreach ( $iflynepal_logo_bands as $iflynepal_group => $iflynepal_band ) {
	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			'iflynepal_trust_' . $iflynepal_group . '_heading',
			array(
				'label'       => $iflynepal_band['heading'],
				'description' => __( 'Logos scroll past in a loop. A transparent PNG or a flat logo on white reads best — every logo is shown in grey until it is hovered.', 'iflynepal' ),
				'section'     => 'iflynepal_trust',
				'priority'    => $iflynepal_band['priority'],
				'settings'    => array(),
			)
		)
	);

	for ( $iflynepal_logo = 1; $iflynepal_logo <= IFLYNEPAL_TRUST_LOGO_MAX; $iflynepal_logo++ ) {
		$wp_customize->add_setting(
			'iflynepal_trust_' . $iflynepal_group . '_' . $iflynepal_logo,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'iflynepal_trust_' . $iflynepal_group . '_' . $iflynepal_logo,
				array(
					'label'     => sprintf( $iflynepal_band['label'], $iflynepal_logo ),
					'section'   => 'iflynepal_trust',
					'priority'  => $iflynepal_band['priority'] + $iflynepal_logo,
					'mime_type' => 'image',
				)
			)
		);
	}
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_trust_kicker',
		array(
			'selector'        => '#iflynepal-trust-kicker',
			'settings'        => array( 'iflynepal_trust_kicker' ),
			'render_callback' => 'iflynepal_render_trust_kicker',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_trust_title',
		array(
			'selector'        => '#iflynepal-trust-title',
			'settings'        => array( 'iflynepal_trust_title' ),
			'render_callback' => 'iflynepal_render_trust_title',
		)
	);

	for ( $iflynepal_feature = 1; $iflynepal_feature <= IFLYNEPAL_TRUST_FEATURES; $iflynepal_feature++ ) {
		$iflynepal_prefix = 'iflynepal_trust_feature_' . $iflynepal_feature . '_';

		foreach ( array( 'icon', 'title', 'description' ) as $iflynepal_field ) {
			$wp_customize->selective_refresh->add_partial(
				$iflynepal_prefix . $iflynepal_field,
				array(
					'selector'        => '#iflynepal-trust-feature-' . $iflynepal_feature . '-' . $iflynepal_field,
					'settings'        => array( $iflynepal_prefix . $iflynepal_field ),
					'render_callback' => function () use ( $iflynepal_feature, $iflynepal_field ) {
						$callback = 'iflynepal_render_trust_feature_' . $iflynepal_field;

						return $callback( $iflynepal_feature );
					},
				)
			);
		}
	}

	foreach ( array( 'kicker', 'title', 'description' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_trust_promo_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-trust-promo-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_trust_promo_' . $iflynepal_field ),
				'render_callback' => function () use ( $iflynepal_field ) {
					$callback = 'iflynepal_render_trust_promo_' . $iflynepal_field;

					return $callback();
				},
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_trust_promo_button',
		array(
			'selector'        => '#iflynepal-trust-promo-button',
			'settings'        => array(
				'iflynepal_trust_promo_button_label',
				'iflynepal_trust_promo_button_url',
			),
			'render_callback' => 'iflynepal_render_trust_promo_button',
		)
	);
}
