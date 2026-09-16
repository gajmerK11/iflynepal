<?php
/**
 * Header > WhatsApp button.
 *
 * A section of its own rather than anything under Homepage: the button is on
 * every template, and an editor looking for it is looking at the header, not
 * at the front page.
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
	'iflynepal_whatsapp',
	array(
		'title'       => __( 'WhatsApp Button', 'iflynepal' ),
		'description' => __( 'The floating WhatsApp action at the right-hand end of the header bar. Leave the number empty to use the one at Packages > Settings, if the booking plugin is active.', 'iflynepal' ),
		'priority'    => 29,
	)
);

$wp_customize->add_setting(
	'iflynepal_whatsapp_enabled',
	array(
		'default'           => true,
		'sanitize_callback' => 'iflynepal_sanitize_checkbox',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_whatsapp_enabled',
	array(
		'label'       => __( 'Show the button', 'iflynepal' ),
		'description' => __( 'Takes the button off every page without losing the number below.', 'iflynepal' ),
		'section'     => 'iflynepal_whatsapp',
		'priority'    => 10,
		'type'        => 'checkbox',
	)
);

$wp_customize->add_setting(
	'iflynepal_whatsapp_number',
	array(
		'default'           => '',
		'sanitize_callback' => 'iflynepal_sanitize_phone',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_whatsapp_number',
	array(
		'label'       => __( 'WhatsApp number', 'iflynepal' ),
		'description' => __( 'With the country code and no leading +, e.g. 9779851188551. Spaces, dashes and brackets are fine — they are stripped. Left empty, the booking plugin\'s number is used and, on a package page, the chat opens naming that package.', 'iflynepal' ),
		'section'     => 'iflynepal_whatsapp',
		'priority'    => 20,
		'type'        => 'text',
		'input_attrs' => array(
			'placeholder' => '9779851188551',
		),
	)
);

$wp_customize->add_setting(
	'iflynepal_whatsapp_message',
	array(
		'default'           => IFLYNEPAL_HEADER_WHATSAPP_MESSAGE_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_whatsapp_message',
	array(
		'label'       => __( 'Opening message', 'iflynepal' ),
		'description' => __( 'What the visitor\'s chat is pre-filled with. They can edit it before sending. Used only when a number is set above.', 'iflynepal' ),
		'section'     => 'iflynepal_whatsapp',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_whatsapp_label',
	array(
		'default'           => IFLYNEPAL_HEADER_WHATSAPP_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_whatsapp_label',
	array(
		'label'       => __( 'Button label', 'iflynepal' ),
		'description' => __( 'Shown on hover and read out by screen readers. The button itself is an icon, so this is the only name it has.', 'iflynepal' ),
		'section'     => 'iflynepal_whatsapp',
		'priority'    => 40,
		'type'        => 'text',
	)
);
