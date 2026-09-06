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
