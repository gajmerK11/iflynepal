<?php
/**
 * Terms & Conditions panel.
 *
 * Two sections rather than one with heading separators, which is what the
 * other page templates use: the hero and the closing card are the only two
 * editable pieces of this page and they are edited at different times, so they
 * are worth opening separately. Everything between them — the fourteen clauses
 * — is deliberately not here; see inc/customizer/callbacks/terms.php.
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
	'iflynepal_terms_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The photograph at the top of the Terms & Conditions page. The headline itself is part of the document and is not editable here.', 'iflynepal' ),
		'panel'       => 'iflynepal_terms',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_terms_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_terms_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

/* ------------------------------------------------------- the closing card */

$wp_customize->add_section(
	'iflynepal_terms_cta',
	array(
		'title'       => __( 'Questions before you book', 'iflynepal' ),
		'description' => __( 'The navy card at the foot of the page. The three contact fields are blank by default and follow the footer\'s office details; fill one in only to say something different here.', 'iflynepal' ),
		'panel'       => 'iflynepal_terms',
		'priority'    => 20,
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_kicker',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_title',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold serif accent.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 11,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_text',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_TEXT_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_text',
	array(
		'label'       => __( 'Paragraph', 'iflynepal' ),
		'description' => __( 'The lines under the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_script',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_SCRIPT_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_script',
	array(
		'label'       => __( 'Handwritten line', 'iflynepal' ),
		'description' => __( 'The gold script line above the buttons. Decorative — screen readers skip it.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 13,
		'type'        => 'text',
	)
);

/* ------------------------------------------------------------------ buttons */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_terms_cta_buttons_heading',
		array(
			'label'    => __( 'Buttons', 'iflynepal' ),
			'section'  => 'iflynepal_terms_cta',
			'priority' => 20,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_contact_label',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_CONTACT_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_contact_label',
	array(
		'label'       => __( 'First button label', 'iflynepal' ),
		'description' => __( 'Leave empty to hide the button.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 21,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_contact_url',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_CONTACT_URL_DEFAULT,
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_contact_url',
	array(
		'label'       => __( 'First button link', 'iflynepal' ),
		'description' => __( 'A path on this site, such as /contact-us, or a full address.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 22,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_whatsapp_label',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_WHATSAPP_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_whatsapp_label',
	array(
		'label'       => __( 'WhatsApp button label', 'iflynepal' ),
		'description' => __( 'Leave empty to hide the button.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 23,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_whatsapp_number',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_whatsapp_number',
	array(
		'label'       => __( 'WhatsApp number', 'iflynepal' ),
		'description' => __( 'Leave empty to use the phone number below. Everything but the digits is stripped out.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 24,
		'type'        => 'text',
	)
);

/* ------------------------------------------------------------ contact lines */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_terms_cta_contact_heading',
		array(
			'label'    => __( 'Contact lines', 'iflynepal' ),
			'section'  => 'iflynepal_terms_cta',
			'priority' => 30,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_phone',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_phone',
	array(
		'label'       => __( 'Phone', 'iflynepal' ),
		'description' => __( 'Empty follows the footer\'s office phone. The line is hidden when both are empty.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 31,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_phone_note',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_PHONE_NOTE_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_phone_note',
	array(
		'label'       => __( 'Phone note', 'iflynepal' ),
		'description' => __( 'Shown in brackets after the number. Leave empty for the number alone.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 32,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_email',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_email',
	array(
		'label'       => __( 'Email', 'iflynepal' ),
		'description' => __( 'Empty follows the footer\'s office email.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 33,
		'type'        => 'email',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_hours',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_hours',
	array(
		'label'       => __( 'Opening hours', 'iflynepal' ),
		'description' => __( 'Empty follows the footer\'s office hours, for example 9:00 AM to 5:00 PM.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 34,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_hours_note',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_HOURS_NOTE_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_hours_note',
	array(
		'label'       => __( 'Time zone note', 'iflynepal' ),
		'description' => __( 'Shown in brackets after the hours.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 35,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_terms_cta_hours_days',
	array(
		'default'           => IFLYNEPAL_TERMS_CTA_HOURS_DAYS_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_terms_cta_hours_days',
	array(
		'label'       => __( 'Days', 'iflynepal' ),
		'description' => __( 'Shown after the hours, for example Monday to Friday.', 'iflynepal' ),
		'section'     => 'iflynepal_terms_cta',
		'priority'    => 36,
		'type'        => 'text',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$iflynepal_terms_fields = array(
		'cta_kicker' => '#iflynepal-terms-cta-kicker',
		'cta_title'  => '#iflynepal-terms-cta-title',
		'cta_text'   => '#iflynepal-terms-cta-text',
		'cta_script' => '#iflynepal-terms-cta-script',
	);

	foreach ( $iflynepal_terms_fields as $iflynepal_field => $iflynepal_selector ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_terms_' . $iflynepal_field,
			array(
				'selector'        => $iflynepal_selector,
				'settings'        => array( 'iflynepal_terms_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_terms_' . $iflynepal_field,
			)
		);
	}

	/*
	 * Both buttons are one partial: hiding one by emptying its label changes
	 * what is left in the row, not just that button's own markup.
	 */
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_terms_cta_actions',
		array(
			'selector'        => '#iflynepal-terms-cta-actions',
			'settings'        => array(
				'iflynepal_terms_cta_contact_label',
				'iflynepal_terms_cta_contact_url',
				'iflynepal_terms_cta_whatsapp_label',
				'iflynepal_terms_cta_whatsapp_number',
				'iflynepal_terms_cta_phone',
			),
			'render_callback' => 'iflynepal_render_terms_cta_actions',
		)
	);

	// One partial for all three lines, for the same reason.
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_terms_cta_lines',
		array(
			'selector'        => '#iflynepal-terms-cta-lines',
			'settings'        => array(
				'iflynepal_terms_cta_phone',
				'iflynepal_terms_cta_phone_note',
				'iflynepal_terms_cta_email',
				'iflynepal_terms_cta_hours',
				'iflynepal_terms_cta_hours_note',
				'iflynepal_terms_cta_hours_days',
			),
			'render_callback' => 'iflynepal_render_terms_cta_lines',
		)
	);
}
