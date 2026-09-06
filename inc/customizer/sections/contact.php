<?php
/**
 * Contact Us panel sections and controls.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_contact_defaults = iflynepal_contact_defaults();

$wp_customize->add_section(
	'iflynepal_contact_hero',
	array(
		'title'       => __( 'Hero & Head Office', 'iflynepal' ),
		'description' => __( 'The opening message, hero photograph and Kathmandu contact card.', 'iflynepal' ),
		'panel'       => 'iflynepal_contact',
		'priority'    => 10,
	)
);

$wp_customize->add_section(
	'iflynepal_contact_enquiry',
	array(
		'title'       => __( 'Enquiry & Map', 'iflynepal' ),
		'description' => __( 'Copy surrounding the contact form and the office map.', 'iflynepal' ),
		'panel'       => 'iflynepal_contact',
		'priority'    => 20,
	)
);

$wp_customize->add_section(
	'iflynepal_contact_representatives',
	array(
		'title'       => __( 'Worldwide Representatives', 'iflynepal' ),
		'description' => __( 'The regional contacts shown below the enquiry form. Empty a name to hide its card.', 'iflynepal' ),
		'panel'       => 'iflynepal_contact',
		'priority'    => 30,
	)
);

/**
 * Add one ordinary Contact setting and control.
 *
 * This file is required inside iflynepal_customize_register(), so this helper
 * remains local to that registration call.
 */
$iflynepal_contact_add_field = static function ( $id, $label, $section, $priority, $type = 'text', $sanitize = 'sanitize_text_field', $description = '' ) use ( $wp_customize, $iflynepal_contact_defaults ) {
	$default = isset( $iflynepal_contact_defaults[ $id ] ) ? $iflynepal_contact_defaults[ $id ] : '';

	$wp_customize->add_setting(
		'iflynepal_contact_' . $id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'iflynepal_contact_' . $id,
		array(
			'label'       => $label,
			'description' => $description,
			'section'     => $section,
			'priority'    => $priority,
			'type'        => $type,
		)
	);
};

$iflynepal_contact_add_field( 'hero_kicker', __( 'Kicker', 'iflynepal' ), 'iflynepal_contact_hero', 10, 'text', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'hero_title', __( 'Heading', 'iflynepal' ), 'iflynepal_contact_hero', 20, 'textarea', 'iflynepal_kses_text', __( 'Wrap a word in <em>word</em> for the gold serif accent.', 'iflynepal' ) );
$iflynepal_contact_add_field( 'hero_lead', __( 'Introduction', 'iflynepal' ), 'iflynepal_contact_hero', 30, 'textarea', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'hero_primary_label', __( 'Primary button label', 'iflynepal' ), 'iflynepal_contact_hero', 40 );
$iflynepal_contact_add_field( 'hero_primary_url', __( 'Primary button link', 'iflynepal' ), 'iflynepal_contact_hero', 41, 'text', 'iflynepal_sanitize_link' );
$iflynepal_contact_add_field( 'hero_secondary_label', __( 'Secondary button label', 'iflynepal' ), 'iflynepal_contact_hero', 50 );
$iflynepal_contact_add_field( 'hero_secondary_url', __( 'Secondary button link', 'iflynepal' ), 'iflynepal_contact_hero', 51, 'text', 'iflynepal_sanitize_link' );
$iflynepal_contact_add_field( 'hero_script', __( 'Handwritten note', 'iflynepal' ), 'iflynepal_contact_hero', 60 );
$iflynepal_contact_add_field( 'hero_scroll_label', __( 'Scroll button label', 'iflynepal' ), 'iflynepal_contact_hero', 70 );

$wp_customize->add_setting(
	'iflynepal_contact_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_contact_hero_image',
		array(
			'label'       => __( 'Hero photograph', 'iflynepal' ),
			'description' => __( 'Landscape, at least 1400px wide.', 'iflynepal' ),
			'settings'    => 'iflynepal_contact_hero_image',
			'section'     => 'iflynepal_contact_hero',
			'priority'    => 80,
			'mime_type'   => 'image',
		)
	)
);

$iflynepal_contact_add_field( 'office_label', __( 'Office label', 'iflynepal' ), 'iflynepal_contact_hero', 90 );
$iflynepal_contact_add_field( 'office_address', __( 'Office address', 'iflynepal' ), 'iflynepal_contact_hero', 100, 'textarea', 'iflynepal_kses_text', __( 'Use <br> for a deliberate line break.', 'iflynepal' ) );
$iflynepal_contact_add_field( 'office_phone', __( 'Office phone', 'iflynepal' ), 'iflynepal_contact_hero', 110 );
$iflynepal_contact_add_field( 'office_hours', __( 'Office hours', 'iflynepal' ), 'iflynepal_contact_hero', 120 );
$iflynepal_contact_add_field( 'office_email', __( 'Office email', 'iflynepal' ), 'iflynepal_contact_hero', 130, 'email', 'sanitize_email', __( 'Contact-form messages are sent here.', 'iflynepal' ) );

$iflynepal_contact_add_field( 'enquiry_kicker', __( 'Kicker', 'iflynepal' ), 'iflynepal_contact_enquiry', 10, 'text', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'enquiry_title', __( 'Heading', 'iflynepal' ), 'iflynepal_contact_enquiry', 20, 'textarea', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'enquiry_lead', __( 'Introduction', 'iflynepal' ), 'iflynepal_contact_enquiry', 30, 'textarea', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'form_title', __( 'Form heading', 'iflynepal' ), 'iflynepal_contact_enquiry', 40 );
$iflynepal_contact_add_field( 'form_note', __( 'Required-fields note', 'iflynepal' ), 'iflynepal_contact_enquiry', 50 );
$iflynepal_contact_add_field( 'form_hint', __( 'Form footer note', 'iflynepal' ), 'iflynepal_contact_enquiry', 60 );
$iflynepal_contact_add_field( 'map_embed_url', __( 'Google Maps embed URL', 'iflynepal' ), 'iflynepal_contact_enquiry', 70, 'url', 'esc_url_raw' );
$iflynepal_contact_add_field( 'map_label', __( 'Map label', 'iflynepal' ), 'iflynepal_contact_enquiry', 80 );
$iflynepal_contact_add_field( 'map_title', __( 'Map address', 'iflynepal' ), 'iflynepal_contact_enquiry', 90 );
$iflynepal_contact_add_field( 'map_hours', __( 'Map office hours', 'iflynepal' ), 'iflynepal_contact_enquiry', 100 );
$iflynepal_contact_add_field( 'map_button_label', __( 'Directions button label', 'iflynepal' ), 'iflynepal_contact_enquiry', 110 );
$iflynepal_contact_add_field( 'map_button_url', __( 'Directions button link', 'iflynepal' ), 'iflynepal_contact_enquiry', 120, 'url', 'esc_url_raw' );

$iflynepal_contact_add_field( 'reps_kicker', __( 'Kicker', 'iflynepal' ), 'iflynepal_contact_representatives', 10, 'text', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'reps_title', __( 'Heading', 'iflynepal' ), 'iflynepal_contact_representatives', 20, 'textarea', 'iflynepal_kses_text' );
$iflynepal_contact_add_field( 'reps_lead', __( 'Introduction', 'iflynepal' ), 'iflynepal_contact_representatives', 30, 'textarea', 'iflynepal_kses_text' );

for ( $iflynepal_rep = 1; $iflynepal_rep <= IFLYNEPAL_CONTACT_REPRESENTATIVE_MAX; $iflynepal_rep++ ) {
	$iflynepal_default  = iflynepal_contact_representative_default( $iflynepal_rep );
	$iflynepal_priority = 100 + ( ( $iflynepal_rep - 1 ) * 10 );
	$iflynepal_labels   = array(
		'name'        => __( 'Name', 'iflynepal' ),
		'country'     => __( 'Country', 'iflynepal' ),
		'phone'       => __( 'Telephone link', 'iflynepal' ),
		'phone_label' => __( 'Displayed phone', 'iflynepal' ),
		'channel'     => __( 'Contact note', 'iflynepal' ),
	);

	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			'iflynepal_contact_rep_' . $iflynepal_rep . '_heading',
			array(
				'label'    => sprintf( __( 'Representative %d', 'iflynepal' ), $iflynepal_rep ),
				'section'  => 'iflynepal_contact_representatives',
				'priority' => $iflynepal_priority,
				'settings' => array(),
			)
		)
	);

	foreach ( array( 'name', 'country', 'phone', 'phone_label', 'channel' ) as $iflynepal_field ) {
		$iflynepal_id = 'iflynepal_contact_rep_' . $iflynepal_rep . '_' . $iflynepal_field;
		$wp_customize->add_setting( $iflynepal_id, array( 'default' => $iflynepal_default[ $iflynepal_field ], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
		$wp_customize->add_control( $iflynepal_id, array( 'label' => $iflynepal_labels[ $iflynepal_field ], 'section' => 'iflynepal_contact_representatives', 'priority' => ++$iflynepal_priority, 'type' => 'text' ) );
	}

	$wp_customize->add_setting( 'iflynepal_contact_rep_' . $iflynepal_rep . '_image', array( 'default' => 0, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_contact_rep_' . $iflynepal_rep . '_image',
			array( 'label' => __( 'Photograph', 'iflynepal' ), 'section' => 'iflynepal_contact_representatives', 'priority' => ++$iflynepal_priority, 'mime_type' => 'image' )
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	/* Every one-value fragment receives its own preview shortcut. */
	$iflynepal_contact_fields = array(
		'hero_kicker'    => '#iflynepal-contact-hero-kicker',
		'hero_title'     => '#iflynepal-contact-hero-title',
		'hero_lead'      => '#iflynepal-contact-hero-lead',
		'hero_script'    => '#iflynepal-contact-hero-script',
		'office_label'   => '#iflynepal-contact-office-title',
		'office_address' => '#iflynepal-contact-office-address',
		'office_hours'   => '#iflynepal-contact-office-hours',
		'enquiry_kicker' => '#iflynepal-contact-enquiry-kicker',
		'enquiry_title'  => '#iflynepal-contact-enquiry-title',
		'enquiry_lead'   => '#iflynepal-contact-enquiry-lead',
		'form_title'     => '#iflynepal-contact-form-title',
		'form_note'      => '#iflynepal-contact-form-note',
		'form_hint'      => '#iflynepal-contact-form-hint',
		'map_label'      => '#iflynepal-contact-map-label',
		'map_title'      => '#iflynepal-contact-map-title',
		'map_hours'      => '#iflynepal-contact-map-hours',
		'reps_kicker'    => '#iflynepal-contact-reps-kicker',
		'reps_title'     => '#iflynepal-contact-representatives-title',
		'reps_lead'      => '#iflynepal-contact-reps-lead',
	);

	foreach ( $iflynepal_contact_fields as $iflynepal_field => $iflynepal_selector ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_contact_' . $iflynepal_field,
			array(
				'selector'        => $iflynepal_selector,
				'settings'        => array( 'iflynepal_contact_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_contact_field',
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_contact_hero_image',
		array(
			'selector'            => '.iflynepal-contact-hero',
			'settings'            => array( 'iflynepal_contact_hero_image' ),
			'render_callback'     => 'iflynepal_render_contact_hero_section',
			'container_inclusive' => true,
		)
	);

	foreach ( array( 'primary', 'secondary' ) as $iflynepal_type ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_contact_hero_' . $iflynepal_type . '_button',
			array(
				'selector'            => '#iflynepal-contact-hero-' . $iflynepal_type,
				'settings'            => array(
					'iflynepal_contact_hero_' . $iflynepal_type . '_label',
					'iflynepal_contact_hero_' . $iflynepal_type . '_url',
				),
				'render_callback'     => 'iflynepal_render_contact_hero_' . $iflynepal_type . '_button',
				'container_inclusive' => true,
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_contact_hero_scroll_label',
		array(
			'selector'        => '#iflynepal-contact-hero-scroll',
			'settings'        => array( 'iflynepal_contact_hero_scroll_label' ),
			'render_callback' => 'iflynepal_render_contact_hero_scroll_label',
		)
	);

	foreach ( array( 'phone', 'email' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_contact_office_' . $iflynepal_field,
			array(
				'selector'            => '#iflynepal-contact-office-' . $iflynepal_field,
				'settings'            => array( 'iflynepal_contact_office_' . $iflynepal_field ),
				'render_callback'     => 'iflynepal_render_contact_office_' . $iflynepal_field,
				'container_inclusive' => true,
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_contact_map_embed_url',
		array(
			'selector'        => '.iflynepal-contact-map__frame',
			'settings'        => array( 'iflynepal_contact_map_embed_url' ),
			'render_callback' => 'iflynepal_render_contact_map_embed',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_contact_map_button',
		array(
			'selector'            => '#iflynepal-contact-map-button',
			'settings'            => array( 'iflynepal_contact_map_button_label', 'iflynepal_contact_map_button_url' ),
			'render_callback'     => 'iflynepal_render_contact_map_button',
			'container_inclusive' => true,
		)
	);

	for ( $iflynepal_rep = 1; $iflynepal_rep <= IFLYNEPAL_CONTACT_REPRESENTATIVE_MAX; $iflynepal_rep++ ) {
		$iflynepal_rep_settings = array();

		foreach ( array( 'name', 'country', 'phone', 'phone_label', 'channel', 'image' ) as $iflynepal_field ) {
			$iflynepal_rep_settings[] = 'iflynepal_contact_rep_' . $iflynepal_rep . '_' . $iflynepal_field;
		}

		$wp_customize->selective_refresh->add_partial(
			'iflynepal_contact_representative_' . $iflynepal_rep,
			array(
				'selector'            => '#iflynepal-contact-rep-' . $iflynepal_rep,
				'settings'            => $iflynepal_rep_settings,
				'render_callback'     => 'iflynepal_render_contact_representative',
				'container_inclusive' => true,
			)
		);
	}
}
