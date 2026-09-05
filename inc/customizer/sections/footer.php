<?php
/**
 * Footer > Brand, Recommended On, Follow Us.
 *
 * Three sections in one panel, matching the three rows of the footer's navy
 * band that carry editable content. The link columns above them are not here
 * on purpose — they are nav menus, edited under Appearance > Menus, with the
 * column heading taken from the assigned menu's own name (inc/setup.php).
 *
 * Required inside customize_register, so $wp_customize is already in scope.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @var WP_Customize_Manager $wp_customize Customizer manager.
 */

defined( 'ABSPATH' ) || exit;

/* ------------------------------------------------------------------ brand */

$wp_customize->add_section(
	'iflynepal_footer_brand',
	array(
		'title'       => __( 'Brand', 'iflynepal' ),
		'description' => __( 'The line beside the logo, the head office details, and the copyright.', 'iflynepal' ),
		'panel'       => 'iflynepal_footer',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_footer_blurb',
	array(
		'default'           => IFLYNEPAL_FOOTER_BLURB_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_footer_blurb',
	array(
		'label'       => __( 'Blurb', 'iflynepal' ),
		'description' => __( 'The sentence beside the logo. The logo itself is set under Site Identity.', 'iflynepal' ),
		'section'     => 'iflynepal_footer_brand',
		'priority'    => 10,
		'type'        => 'textarea',
	)
);

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_footer_office_heading_group',
		array(
			'label'    => __( 'Head office', 'iflynepal' ),
			'section'  => 'iflynepal_footer_brand',
			'priority' => 20,
			'settings' => array(),
		)
	)
);

$iflynepal_footer_office = iflynepal_footer_office_defaults();

$iflynepal_office_fields = array(
	'heading' => array(
		'label'       => __( 'Column heading', 'iflynepal' ),
		'description' => __( 'The uppercase label over the address.', 'iflynepal' ),
		'type'        => 'text',
		'sanitize'    => 'sanitize_text_field',
	),
	'address' => array(
		'label'       => __( 'Address', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'type'        => 'textarea',
		'sanitize'    => 'iflynepal_kses_text',
	),
	'phone'   => array(
		'label'       => __( 'Phone', 'iflynepal' ),
		'description' => __( 'Shown as typed; the dial link strips everything but the digits.', 'iflynepal' ),
		'type'        => 'text',
		'sanitize'    => 'sanitize_text_field',
	),
	'hours'   => array(
		'label'       => __( 'Opening hours', 'iflynepal' ),
		'description' => '',
		'type'        => 'text',
		'sanitize'    => 'sanitize_text_field',
	),
	'email'   => array(
		'label'       => __( 'Email', 'iflynepal' ),
		'description' => '',
		'type'        => 'text',
		'sanitize'    => 'sanitize_email',
	),
);

$iflynepal_office_priority = 21;

foreach ( $iflynepal_office_fields as $iflynepal_field => $iflynepal_config ) {
	$wp_customize->add_setting(
		'iflynepal_footer_office_' . $iflynepal_field,
		array(
			'default'           => isset( $iflynepal_footer_office[ $iflynepal_field ] ) ? $iflynepal_footer_office[ $iflynepal_field ] : '',
			'sanitize_callback' => $iflynepal_config['sanitize'],
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_footer_office_' . $iflynepal_field,
		array(
			'label'       => $iflynepal_config['label'],
			'description' => $iflynepal_config['description'],
			'section'     => 'iflynepal_footer_brand',
			'priority'    => $iflynepal_office_priority,
			'type'        => $iflynepal_config['type'],
		)
	);

	++$iflynepal_office_priority;
}

$wp_customize->add_setting(
	'iflynepal_footer_copyright',
	array(
		'default'           => __( 'All rights reserved.', 'iflynepal' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_footer_copyright',
	array(
		'label'       => __( 'Copyright line', 'iflynepal' ),
		'description' => __( 'Follows the year and the site name, both of which are filled in automatically.', 'iflynepal' ),
		'section'     => 'iflynepal_footer_brand',
		'priority'    => 40,
		'type'        => 'text',
	)
);

/* -------------------------------------------------------- recommended on */

$wp_customize->add_section(
	'iflynepal_footer_reviews',
	array(
		'title'       => __( 'Recommended On', 'iflynepal' ),
		'description' => __( 'The review buttons beside the logo. These are the same links as Testimonials > Add External Testimonial Links — editing either place changes both. A field left empty hides its button.', 'iflynepal' ),
		'panel'       => 'iflynepal_footer',
		'priority'    => 20,
	)
);

/*
 * These write to the option the testimonial links screen owns, not to theme
 * mods. The same three URLs drive the review strip under the testimonials and
 * the chips in the footer, so giving them a second, separate store would mean
 * typing each Google review link twice and watching the two drift apart.
 *
 * The bracketed setting ID is how the Customizer addresses one key of an
 * option array; WP_Customize_Setting resolves it without any help from here.
 */
$iflynepal_platforms     = iflynepal_testimonial_platforms();
$iflynepal_link_defaults = iflynepal_testimonial_link_defaults();

$iflynepal_review_priority = 10;

foreach ( iflynepal_footer_review_slugs() as $iflynepal_slug ) {
	if ( ! isset( $iflynepal_platforms[ $iflynepal_slug ] ) ) {
		continue;
	}

	$wp_customize->add_setting(
		IFLYNEPAL_TESTIMONIAL_LINKS_OPTION . '[' . $iflynepal_slug . ']',
		array(
			'type'              => 'option',
			'default'           => isset( $iflynepal_link_defaults[ $iflynepal_slug ] ) ? $iflynepal_link_defaults[ $iflynepal_slug ] : '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		IFLYNEPAL_TESTIMONIAL_LINKS_OPTION . '[' . $iflynepal_slug . ']',
		array(
			'label'       => $iflynepal_platforms[ $iflynepal_slug ]['label'],
			'description' => sprintf(
				/* translators: %s: an example URL for this platform. */
				__( 'For example: %s', 'iflynepal' ),
				$iflynepal_platforms[ $iflynepal_slug ]['placeholder']
			),
			'section'     => 'iflynepal_footer_reviews',
			'priority'    => $iflynepal_review_priority,
			'type'        => 'url',
		)
	);

	++$iflynepal_review_priority;
}

/* ------------------------------------------------------------- follow us */

$wp_customize->add_section(
	'iflynepal_footer_socials',
	array(
		'title'       => __( 'Follow Us', 'iflynepal' ),
		'description' => __( 'One field per network. A field left empty removes that button from the row.', 'iflynepal' ),
		'panel'       => 'iflynepal_footer',
		'priority'    => 30,
	)
);

$iflynepal_social_priority = 10;

foreach ( iflynepal_footer_social_networks() as $iflynepal_slug => $iflynepal_network ) {
	$wp_customize->add_setting(
		'iflynepal_footer_social_' . $iflynepal_slug,
		array(
			'default'           => $iflynepal_network['placeholder'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_footer_social_' . $iflynepal_slug,
		array(
			'label'       => $iflynepal_network['label'],
			'description' => sprintf(
				/* translators: %s: an example profile URL for this network. */
				__( 'For example: %s', 'iflynepal' ),
				$iflynepal_network['placeholder']
			),
			'section'     => 'iflynepal_footer_socials',
			'priority'    => $iflynepal_social_priority,
			'type'        => 'url',
		)
	);

	++$iflynepal_social_priority;
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_blurb',
		array(
			'selector'        => '#iflynepal-footer-blurb',
			'settings'        => array( 'iflynepal_footer_blurb' ),
			'render_callback' => 'iflynepal_render_footer_blurb',
		)
	);

	$iflynepal_office_settings = array();

	foreach ( array_keys( $iflynepal_office_fields ) as $iflynepal_field ) {
		if ( 'heading' === $iflynepal_field ) {
			continue;
		}

		$iflynepal_office_settings[] = 'iflynepal_footer_office_' . $iflynepal_field;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_office',
		array(
			'selector'        => '#iflynepal-footer-office',
			'settings'        => $iflynepal_office_settings,
			'render_callback' => 'iflynepal_render_footer_office',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_office_heading',
		array(
			'selector'        => '#iflynepal-footer-office-heading',
			'settings'        => array( 'iflynepal_footer_office_heading' ),
			'render_callback' => 'iflynepal_render_footer_office_heading',
		)
	);

	$iflynepal_review_settings = array();

	foreach ( iflynepal_footer_review_slugs() as $iflynepal_slug ) {
		$iflynepal_review_settings[] = IFLYNEPAL_TESTIMONIAL_LINKS_OPTION . '[' . $iflynepal_slug . ']';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_reviews',
		array(
			'selector'        => '#iflynepal-footer-reviews',
			'settings'        => $iflynepal_review_settings,
			'render_callback' => 'iflynepal_render_footer_reviews',
		)
	);

	$iflynepal_social_settings = array();

	foreach ( array_keys( iflynepal_footer_social_networks() ) as $iflynepal_slug ) {
		$iflynepal_social_settings[] = 'iflynepal_footer_social_' . $iflynepal_slug;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_socials',
		array(
			'selector'        => '#iflynepal-footer-socials',
			'settings'        => $iflynepal_social_settings,
			'render_callback' => 'iflynepal_render_footer_socials',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_footer_copyright',
		array(
			'selector'        => '#iflynepal-footer-copyright',
			'settings'        => array( 'iflynepal_footer_copyright' ),
			'render_callback' => 'iflynepal_render_footer_copyright',
		)
	);
}
