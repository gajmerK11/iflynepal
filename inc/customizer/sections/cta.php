<?php
/**
 * Homepage > CTA section.
 *
 * The card that closes the front page: kicker, heading, paragraph, two
 * buttons, and the photograph behind them.
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
	'iflynepal_cta',
	array(
		'title'       => __( 'CTA', 'iflynepal' ),
		'description' => __( 'The closing card at the foot of the front page.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 50,
	)
);

/* ------------------------------------------------------------------- copy */

$wp_customize->add_setting(
	'iflynepal_cta_kicker',
	array(
		'default'           => IFLYNEPAL_CTA_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_cta_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_cta',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_cta_title',
	array(
		'default'           => IFLYNEPAL_CTA_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_cta_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;span class="underline"&gt;word&lt;/span&gt; to draw the hand-inked underline under a word. The mark strokes itself in as the card is scrolled to.', 'iflynepal' ),
		'section'     => 'iflynepal_cta',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_cta_description',
	array(
		'default'           => IFLYNEPAL_CTA_DESCRIPTION_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_cta_description',
	array(
		'label'       => __( 'Paragraph', 'iflynepal' ),
		'description' => __( 'The lines under the heading. Accepts &lt;br&gt;, &lt;em&gt; and &lt;strong&gt;.', 'iflynepal' ),
		'section'     => 'iflynepal_cta',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

/* ---------------------------------------------------------------- buttons */

$iflynepal_cta_button_labels = array(
	1 => __( 'Button 1 — the gold action', 'iflynepal' ),
	2 => __( 'Button 2 — the outlined action', 'iflynepal' ),
);

for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_CTA_BUTTONS; $iflynepal_button++ ) {
	$iflynepal_defaults = iflynepal_cta_button_defaults();
	$iflynepal_default  = isset( $iflynepal_defaults[ $iflynepal_button ] )
		? $iflynepal_defaults[ $iflynepal_button ]
		: array(
			'label' => '',
			'url'   => '',
		);

	// A 10-wide band apiece, leaving room for the label and link between.
	$iflynepal_priority = 40 + ( ( $iflynepal_button - 1 ) * 10 );

	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			'iflynepal_cta_button_' . $iflynepal_button . '_heading',
			array(
				'label'    => isset( $iflynepal_cta_button_labels[ $iflynepal_button ] ) ? $iflynepal_cta_button_labels[ $iflynepal_button ] : sprintf(
					/* translators: %d: button number. */
					__( 'Button %d', 'iflynepal' ),
					$iflynepal_button
				),
				'section'  => 'iflynepal_cta',
				'priority' => $iflynepal_priority,
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'iflynepal_cta_button_' . $iflynepal_button . '_label',
		array(
			'default'           => $iflynepal_default['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_cta_button_' . $iflynepal_button . '_label',
		array(
			'label'       => __( 'Label', 'iflynepal' ),
			'description' => __( 'Emptying this removes the button.', 'iflynepal' ),
			'section'     => 'iflynepal_cta',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_cta_button_' . $iflynepal_button . '_url',
		array(
			'default'           => $iflynepal_default['url'],
			'sanitize_callback' => 'iflynepal_sanitize_link',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_cta_button_' . $iflynepal_button . '_url',
		array(
			'label'       => __( 'Link', 'iflynepal' ),
			'description' => __( 'A full URL, or an on-page anchor such as #explore.', 'iflynepal' ),
			'section'     => 'iflynepal_cta',
			'priority'    => $iflynepal_priority + 2,
			'type'        => 'text',
		)
	);
}

/* ------------------------------------------------------------------ image */

$wp_customize->add_setting(
	'iflynepal_cta_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_cta_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'Fills the card behind a dark scrim, so a wide landscape works best. At least 2000px wide.', 'iflynepal' ),
			'section'     => 'iflynepal_cta',
			'priority'    => 70,
			'mime_type'   => 'image',
		)
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title', 'description' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_cta_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-cta-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_cta_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_cta_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_button_settings = array();

	for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_CTA_BUTTONS; $iflynepal_button++ ) {
		$iflynepal_button_settings[] = 'iflynepal_cta_button_' . $iflynepal_button . '_label';
		$iflynepal_button_settings[] = 'iflynepal_cta_button_' . $iflynepal_button . '_url';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_cta_actions',
		array(
			'selector'        => '#iflynepal-cta-actions',
			'settings'        => $iflynepal_button_settings,
			'render_callback' => 'iflynepal_render_cta_actions',
		)
	);
}
