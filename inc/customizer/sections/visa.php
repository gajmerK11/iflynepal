<?php
/**
 * Visa Services section.
 *
 * The whole Visa Services page template in one section, in page order: the
 * hero, the three things the office handles, the visa categories, the
 * destinations grid, the step-by-step process, the packages, the fee notice and
 * the closing invitation.
 *
 * Separated by IFly_Nepal_Customize_Heading_Control rather than split into
 * sections of their own, the same arrangement CSR, About > Company and About >
 * Nepal use — the Customizer has no nested panels, and this is one page.
 *
 * Emptying a section's heading hides that section. Five of the blocks are
 * add/remove lists driven by assets/js/visa/repeaters.js.
 *
 * The closing band prints the office's phone number, email and address, and
 * none of the three is a setting here: they are read from Contact Us, which is
 * where they are typed. See iflynepal_visa_contact_lines().
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
	'iflynepal_visa',
	array(
		'title'       => __( 'Visa Services', 'iflynepal' ),
		'description' => __( 'Everything on the Visa Services page template, in the order it appears. Assign the template to a page under Page Attributes &gt; Template. Emptying a section\'s heading hides that section; emptying an item\'s title removes it from its list. The phone number, email and address in the closing band come from Contact Us.', 'iflynepal' ),
		'priority'    => 35,
	)
);

/* ------------------------------------------------------------------- hero */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_hero_heading',
		array(
			'label'    => __( 'Hero', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 10,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_hero_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_HERO_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_hero_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 11,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_hero_title',
	array(
		'default'           => IFLYNEPAL_VISA_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold serif accent.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_hero_lead',
	array(
		'default'           => IFLYNEPAL_VISA_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_hero_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The paragraph under the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 13,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_visa_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 14,
			'mime_type'   => 'image',
		)
	)
);

for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_VISA_HERO_BUTTONS; $iflynepal_button++ ) {
	$iflynepal_button_default = iflynepal_visa_hero_button_default( $iflynepal_button );

	$wp_customize->add_setting(
		'iflynepal_visa_hero_button_' . $iflynepal_button . '_label',
		array(
			'default'           => $iflynepal_button_default['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_hero_button_' . $iflynepal_button . '_label',
		array(
			/* translators: %d: button number. */
			'label'       => sprintf( __( 'Button %d label', 'iflynepal' ), $iflynepal_button ),
			'description' => 1 === $iflynepal_button
				? __( 'The filled button. Leave empty to hide it.', 'iflynepal' )
				: __( 'The outlined button. Leave empty to hide it.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 14 + ( $iflynepal_button * 2 ),
			'type'        => 'text',
		)
	);

	iflynepal_customizer_add_link_field(
		$wp_customize,
		'iflynepal_visa_hero_button_' . $iflynepal_button . '_url',
		array(
			'default'           => $iflynepal_button_default['url'],
			'sanitize_callback' => 'iflynepal_sanitize_link',
		),
		array(
			/* translators: %d: button number. */
			'label'       => sprintf( __( 'Button %d link', 'iflynepal' ), $iflynepal_button ),
			'description' => __( 'A full address, a path like /contact-us/, or an anchor on this page such as #visa-packages.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 15 + ( $iflynepal_button * 2 ),
			'type'        => 'text',
		)
	);
}

/* --------------------------------------------------------------- services */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_services_heading',
		array(
			'label'    => __( 'What we handle for you', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 100,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_services_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_SERVICES_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_services_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 101,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_services_title',
	array(
		'default'           => IFLYNEPAL_VISA_SERVICES_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_services_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides this whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 102,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_service = 1; $iflynepal_service <= IFLYNEPAL_VISA_SERVICE_MAX; $iflynepal_service++ ) {
	$iflynepal_service_default = iflynepal_visa_service_default( $iflynepal_service );

	$wp_customize->add_setting(
		'iflynepal_visa_service_' . $iflynepal_service . '_title',
		array(
			'default'           => $iflynepal_service_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_service_' . $iflynepal_service . '_title',
		array(
			/* translators: %d: item number. */
			'label'       => sprintf( __( 'Item %d title', 'iflynepal' ), $iflynepal_service ),
			'description' => __( 'Empty removes this item. The numerals are counted from what is left.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 102 + ( $iflynepal_service * 2 ),
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_service_' . $iflynepal_service . '_description',
		array(
			'default'           => $iflynepal_service_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_service_' . $iflynepal_service . '_description',
		array(
			/* translators: %d: item number. */
			'label'    => sprintf( __( 'Item %d text', 'iflynepal' ), $iflynepal_service ),
			'section'  => 'iflynepal_visa',
			'priority' => 103 + ( $iflynepal_service * 2 ),
			'type'     => 'textarea',
		)
	);
}

/* ------------------------------------------------------------- categories */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_types_heading',
		array(
			'label'    => __( 'Visa categories', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 200,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_types_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_TYPES_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_types_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 201,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_types_title',
	array(
		'default'           => IFLYNEPAL_VISA_TYPES_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_types_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides this whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 202,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_type = 1; $iflynepal_type <= IFLYNEPAL_VISA_TYPE_MAX; $iflynepal_type++ ) {
	$iflynepal_type_default = iflynepal_visa_type_default( $iflynepal_type );

	$wp_customize->add_setting(
		'iflynepal_visa_type_' . $iflynepal_type . '_title',
		array(
			'default'           => $iflynepal_type_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_type_' . $iflynepal_type . '_title',
		array(
			/* translators: %d: category number. */
			'label'       => sprintf( __( 'Category %d name', 'iflynepal' ), $iflynepal_type ),
			'description' => __( 'Empty removes this category.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 202 + ( $iflynepal_type * 2 ),
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_type_' . $iflynepal_type . '_description',
		array(
			'default'           => $iflynepal_type_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_type_' . $iflynepal_type . '_description',
		array(
			/* translators: %d: category number. */
			'label'    => sprintf( __( 'Category %d text', 'iflynepal' ), $iflynepal_type ),
			'section'  => 'iflynepal_visa',
			'priority' => 203 + ( $iflynepal_type * 2 ),
			'type'     => 'textarea',
		)
	);
}

/* ----------------------------------------------------------- destinations */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_destinations_heading',
		array(
			'label'    => __( 'Destinations', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 300,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_destinations_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_DESTINATIONS_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_destinations_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 301,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_destinations_title',
	array(
		'default'           => IFLYNEPAL_VISA_DESTINATIONS_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_destinations_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides this whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 302,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_destinations_note',
	array(
		'default'           => IFLYNEPAL_VISA_DESTINATIONS_NOTE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_rich',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_destinations_note',
	array(
		'label'       => __( 'Note under the grid', 'iflynepal' ),
		'description' => __( 'May carry a link. Empty prints no note.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 303,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_dest = 1; $iflynepal_dest <= IFLYNEPAL_VISA_DESTINATION_MAX; $iflynepal_dest++ ) {
	$iflynepal_dest_default = iflynepal_visa_destination_default( $iflynepal_dest );

	$wp_customize->add_setting(
		'iflynepal_visa_destination_' . $iflynepal_dest . '_name',
		array(
			'default'           => $iflynepal_dest_default['name'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_destination_' . $iflynepal_dest . '_name',
		array(
			/* translators: %d: destination number. */
			'label'       => sprintf( __( 'Destination %d', 'iflynepal' ), $iflynepal_dest ),
			'description' => __( 'The country name. Empty removes this cell.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 303 + ( $iflynepal_dest * 2 ),
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_destination_' . $iflynepal_dest . '_code',
		array(
			'default'           => $iflynepal_dest_default['code'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_destination_' . $iflynepal_dest . '_code',
		array(
			/* translators: %d: destination number. */
			'label'       => sprintf( __( 'Destination %d short code', 'iflynepal' ), $iflynepal_dest ),
			'description' => __( 'Two or three letters printed above the name, such as AU or EU. Optional.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 304 + ( $iflynepal_dest * 2 ),
			'type'        => 'text',
		)
	);
}

/* ----------------------------------------------------------------- process */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_process_heading',
		array(
			'label'    => __( 'How it works', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 400,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_process_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_PROCESS_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_process_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 401,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_process_title',
	array(
		'default'           => IFLYNEPAL_VISA_PROCESS_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_process_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides this whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 402,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_step = 1; $iflynepal_step <= IFLYNEPAL_VISA_STEP_MAX; $iflynepal_step++ ) {
	$iflynepal_step_default = iflynepal_visa_step_default( $iflynepal_step );

	$wp_customize->add_setting(
		'iflynepal_visa_step_' . $iflynepal_step . '_title',
		array(
			'default'           => $iflynepal_step_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_step_' . $iflynepal_step . '_title',
		array(
			/* translators: %d: step number. */
			'label'       => sprintf( __( 'Step %d title', 'iflynepal' ), $iflynepal_step ),
			'description' => __( 'Empty removes this step. The rest renumber themselves.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => 402 + ( $iflynepal_step * 2 ),
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_step_' . $iflynepal_step . '_description',
		array(
			'default'           => $iflynepal_step_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_step_' . $iflynepal_step . '_description',
		array(
			/* translators: %d: step number. */
			'label'    => sprintf( __( 'Step %d text', 'iflynepal' ), $iflynepal_step ),
			'section'  => 'iflynepal_visa',
			'priority' => 403 + ( $iflynepal_step * 2 ),
			'type'     => 'textarea',
		)
	);
}

/* ---------------------------------------------------------------- packages */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_packages_heading',
		array(
			'label'    => __( 'Packages', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 500,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_packages_kicker',
	array(
		'default'           => IFLYNEPAL_VISA_PACKAGES_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_packages_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 501,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_packages_title',
	array(
		'default'           => IFLYNEPAL_VISA_PACKAGES_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_packages_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides this whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 502,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_package = 1; $iflynepal_package <= IFLYNEPAL_VISA_PACKAGE_MAX; $iflynepal_package++ ) {
	$iflynepal_package_default = iflynepal_visa_package_default( $iflynepal_package );
	$iflynepal_package_base    = 502 + ( $iflynepal_package * 10 );

	$wp_customize->add_setting(
		'iflynepal_visa_package_' . $iflynepal_package . '_name',
		array(
			'default'           => $iflynepal_package_default['name'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_package_' . $iflynepal_package . '_name',
		array(
			/* translators: %d: package number. */
			'label'       => sprintf( __( 'Package %d name', 'iflynepal' ), $iflynepal_package ),
			'description' => __( 'Empty removes this package.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => $iflynepal_package_base + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_package_' . $iflynepal_package . '_tagline',
		array(
			'default'           => $iflynepal_package_default['tagline'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_package_' . $iflynepal_package . '_tagline',
		array(
			/* translators: %d: package number. */
			'label'       => sprintf( __( 'Package %d one-liner', 'iflynepal' ), $iflynepal_package ),
			'description' => __( 'Who this package is for, in one sentence.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => $iflynepal_package_base + 2,
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_package_' . $iflynepal_package . '_badge',
		array(
			'default'           => $iflynepal_package_default['badge'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_package_' . $iflynepal_package . '_badge',
		array(
			/* translators: %d: package number. */
			'label'       => sprintf( __( 'Package %d badge', 'iflynepal' ), $iflynepal_package ),
			'description' => __( 'A short label such as "Most chosen". A package with a badge is the one the row lifts and outlines. Leave empty for no badge.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => $iflynepal_package_base + 3,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_package_' . $iflynepal_package . '_carries',
		array(
			'default'           => $iflynepal_package_default['carries'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_package_' . $iflynepal_package . '_carries',
		array(
			/* translators: %d: package number. */
			'label'       => sprintf( __( 'Package %d carry-over line', 'iflynepal' ), $iflynepal_package ),
			'description' => __( 'Printed at the top of the list with a + rather than a tick, for lines like "Everything in Basic". Optional.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => $iflynepal_package_base + 4,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_visa_package_' . $iflynepal_package . '_features',
		array(
			'default'           => $iflynepal_package_default['features'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_visa_package_' . $iflynepal_package . '_features',
		array(
			/* translators: %d: package number. */
			'label'       => sprintf( __( 'Package %d, what is included', 'iflynepal' ), $iflynepal_package ),
			'description' => __( 'One line per item. Blank lines are ignored, so the list can be spaced out while it is being written.', 'iflynepal' ),
			'section'     => 'iflynepal_visa',
			'priority'    => $iflynepal_package_base + 5,
			'type'        => 'textarea',
			'input_attrs' => array( 'rows' => 8 ),
		)
	);
}

/* ------------------------------------------------------------------ notice */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_notice_heading',
		array(
			'label'    => __( 'Fee notice', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 600,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_notice_title',
	array(
		'default'           => IFLYNEPAL_VISA_NOTICE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_notice_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Empty hides the whole notice band.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 601,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_notice_body',
	array(
		'default'           => IFLYNEPAL_VISA_NOTICE_BODY_DEFAULT,
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_notice_body',
	array(
		'label'       => __( 'Notice text', 'iflynepal' ),
		'description' => __( 'One paragraph per line. This is where the third-party fees and the no-guarantee wording live.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 602,
		'type'        => 'textarea',
		'input_attrs' => array( 'rows' => 6 ),
	)
);

/* --------------------------------------------------------------------- cta */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_visa_cta_heading',
		array(
			'label'    => __( 'Closing invitation', 'iflynepal' ),
			'section'  => 'iflynepal_visa',
			'priority' => 700,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_cta_title',
	array(
		'default'           => IFLYNEPAL_VISA_CTA_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_cta_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; for the gold serif accent. Empty hides the whole band.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 701,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_cta_lead',
	array(
		'default'           => IFLYNEPAL_VISA_CTA_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_cta_lead',
	array(
		'label'    => __( 'Copy', 'iflynepal' ),
		'section'  => 'iflynepal_visa',
		'priority' => 702,
		'type'     => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_visa_cta_button_label',
	array(
		'default'           => IFLYNEPAL_VISA_CTA_BUTTON_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_visa_cta_button_label',
	array(
		'label'       => __( 'Button label', 'iflynepal' ),
		'description' => __( 'Empty hides the button but keeps the band.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 703,
		'type'        => 'text',
	)
);

iflynepal_customizer_add_link_field(
	$wp_customize,
	'iflynepal_visa_cta_button_url',
	array(
		'default'           => IFLYNEPAL_VISA_CTA_BUTTON_URL_DEFAULT,
		'sanitize_callback' => 'iflynepal_sanitize_link',
	),
	array(
		'label'       => __( 'Button link', 'iflynepal' ),
		'description' => __( 'The phone number, email and address printed under this button are the Contact Us ones — edit them in Customize &gt; Contact Us.', 'iflynepal' ),
		'section'     => 'iflynepal_visa',
		'priority'    => 704,
		'type'        => 'text',
	)
);

/* ---------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	/*
	 * The fields whose setting ID, element ID and render callback all follow the
	 * same three names. Everything that does not — the lists, the hero buttons,
	 * the notice body — is registered by hand below.
	 */
	$iflynepal_visa_partials = array(
		'hero_kicker'         => 'iflynepal-visa-hero-kicker',
		'hero_title'          => 'iflynepal-visa-hero-title',
		'hero_lead'           => 'iflynepal-visa-hero-lead',
		'services_kicker'     => 'iflynepal-visa-services-kicker',
		'services_title'      => 'iflynepal-visa-services-title',
		'types_kicker'        => 'iflynepal-visa-types-kicker',
		'types_title'         => 'iflynepal-visa-types-title',
		'destinations_kicker' => 'iflynepal-visa-destinations-kicker',
		'destinations_title'  => 'iflynepal-visa-destinations-title',
		'destinations_note'   => 'iflynepal-visa-destinations-note',
		'process_kicker'      => 'iflynepal-visa-process-kicker',
		'process_title'       => 'iflynepal-visa-process-title',
		'packages_kicker'     => 'iflynepal-visa-packages-kicker',
		'packages_title'      => 'iflynepal-visa-packages-title',
		'notice_title'        => 'iflynepal-visa-notice-title',
		'cta_title'           => 'iflynepal-visa-cta-title',
		'cta_lead'            => 'iflynepal-visa-cta-lead',
	);

	foreach ( $iflynepal_visa_partials as $iflynepal_field => $iflynepal_selector ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_visa_' . $iflynepal_field,
			array(
				'selector'        => '#' . $iflynepal_selector,
				'settings'        => array( 'iflynepal_visa_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_visa_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_visa_button_settings = array();

	for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_VISA_HERO_BUTTONS; $iflynepal_button++ ) {
		$iflynepal_visa_button_settings[] = 'iflynepal_visa_hero_button_' . $iflynepal_button . '_label';
		$iflynepal_visa_button_settings[] = 'iflynepal_visa_hero_button_' . $iflynepal_button . '_url';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_visa_hero_actions',
		array(
			'selector'        => '#iflynepal-visa-hero-actions',
			'settings'        => $iflynepal_visa_button_settings,
			'render_callback' => 'iflynepal_render_visa_hero_actions',
		)
	);

	/*
	 * The five lists. Each partial covers every slot's settings, because adding
	 * or clearing any one of them changes what the whole list prints — the
	 * numerals are counted from position, so a change to item two also moves
	 * item three.
	 */
	$iflynepal_visa_lists = array(
		'services'     => array(
			'selector' => '#iflynepal-visa-services',
			'max'      => IFLYNEPAL_VISA_SERVICE_MAX,
			'patterns' => array( 'iflynepal_visa_service_%d_title', 'iflynepal_visa_service_%d_description' ),
			'render'   => 'iflynepal_render_visa_services',
		),
		'types'        => array(
			'selector' => '#iflynepal-visa-types',
			'max'      => IFLYNEPAL_VISA_TYPE_MAX,
			'patterns' => array( 'iflynepal_visa_type_%d_title', 'iflynepal_visa_type_%d_description' ),
			'render'   => 'iflynepal_render_visa_types',
		),
		'destinations' => array(
			'selector' => '#iflynepal-visa-destinations',
			'max'      => IFLYNEPAL_VISA_DESTINATION_MAX,
			'patterns' => array( 'iflynepal_visa_destination_%d_name', 'iflynepal_visa_destination_%d_code' ),
			'render'   => 'iflynepal_render_visa_destinations',
		),
		'steps'        => array(
			'selector' => '#iflynepal-visa-steps',
			'max'      => IFLYNEPAL_VISA_STEP_MAX,
			'patterns' => array( 'iflynepal_visa_step_%d_title', 'iflynepal_visa_step_%d_description' ),
			'render'   => 'iflynepal_render_visa_steps',
		),
		'packages'     => array(
			'selector' => '#iflynepal-visa-packages-list',
			'max'      => IFLYNEPAL_VISA_PACKAGE_MAX,
			'patterns' => array(
				'iflynepal_visa_package_%d_name',
				'iflynepal_visa_package_%d_tagline',
				'iflynepal_visa_package_%d_badge',
				'iflynepal_visa_package_%d_carries',
				'iflynepal_visa_package_%d_features',
			),
			'render'   => 'iflynepal_render_visa_packages',
		),
	);

	foreach ( $iflynepal_visa_lists as $iflynepal_list_key => $iflynepal_list ) {
		$iflynepal_list_settings = array();

		for ( $iflynepal_slot = 1; $iflynepal_slot <= $iflynepal_list['max']; $iflynepal_slot++ ) {
			foreach ( $iflynepal_list['patterns'] as $iflynepal_pattern ) {
				$iflynepal_list_settings[] = str_replace( '%d', (string) $iflynepal_slot, $iflynepal_pattern );
			}
		}

		$wp_customize->selective_refresh->add_partial(
			'iflynepal_visa_' . $iflynepal_list_key,
			array(
				'selector'        => $iflynepal_list['selector'],
				'settings'        => $iflynepal_list_settings,
				'render_callback' => $iflynepal_list['render'],
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_visa_notice_body',
		array(
			'selector'        => '#iflynepal-visa-notice-body',
			'settings'        => array( 'iflynepal_visa_notice_body' ),
			'render_callback' => 'iflynepal_render_visa_notice_body',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_visa_cta_button',
		array(
			'selector'        => '#iflynepal-visa-cta-button',
			'settings'        => array( 'iflynepal_visa_cta_button_label', 'iflynepal_visa_cta_button_url' ),
			'render_callback' => 'iflynepal_render_visa_cta_button',
		)
	);
}
