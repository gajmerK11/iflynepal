<?php
/**
 * FAQ / Travel Guide > Travel Guide section.
 *
 * The right column of the guides section: kicker, heading, the chosen posts,
 * and the link beneath them.
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
	'iflynepal_travel_guide',
	array(
		'title'       => __( 'Travel Guide', 'iflynepal' ),
		'description' => __( 'The guides column, on the right of the section.', 'iflynepal' ),
		'panel'       => 'iflynepal_guides',
		'priority'    => 20,
	)
);

/* ------------------------------------------------------------------ intro */

$wp_customize->add_setting(
	'iflynepal_guide_kicker',
	array(
		'default'           => IFLYNEPAL_GUIDE_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_guide_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_travel_guide',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_guide_title',
	array(
		'default'           => IFLYNEPAL_GUIDE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_guide_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_travel_guide',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

/* ----------------------------------------------------------------- guides */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_guide_posts_heading',
		array(
			'label'       => __( 'Guides', 'iflynepal' ),
			'description' => __( 'Up to five published posts, shown in the order they are set here. A slot left on “Select a guide”, or pointing at a post that has since been unpublished, is skipped.', 'iflynepal' ),
			'section'     => 'iflynepal_travel_guide',
			'priority'    => 30,
			'settings'    => array(),
		)
	)
);

// Queried once and shared by all five dropdowns.
$iflynepal_guide_choices = iflynepal_guide_post_choices();

for ( $iflynepal_guide = 1; $iflynepal_guide <= IFLYNEPAL_GUIDE_MAX; $iflynepal_guide++ ) {
	$wp_customize->add_setting(
		'iflynepal_guide_post_' . $iflynepal_guide,
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_guide_post_' . $iflynepal_guide,
		array(
			/* translators: %d: guide number. */
			'label'    => sprintf( __( 'Guide %d', 'iflynepal' ), $iflynepal_guide ),
			'section'  => 'iflynepal_travel_guide',
			'priority' => 30 + $iflynepal_guide,
			'type'     => 'select',
			'choices'  => $iflynepal_guide_choices,
		)
	);
}

/* ------------------------------------------------------------------- link */

$iflynepal_guide_cta = iflynepal_guide_cta_defaults();

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_guide_cta_heading',
		array(
			'label'    => __( 'Link under the guides', 'iflynepal' ),
			'section'  => 'iflynepal_travel_guide',
			'priority' => 100,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_guide_cta_label',
	array(
		'default'           => $iflynepal_guide_cta['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_guide_cta_label',
	array(
		'label'       => __( 'Label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the link.', 'iflynepal' ),
		'section'     => 'iflynepal_travel_guide',
		'priority'    => 101,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_guide_cta_url',
	array(
		'default'           => $iflynepal_guide_cta['url'],
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_guide_cta_url',
	array(
		'label'       => __( 'Link', 'iflynepal' ),
		'description' => __( 'A full URL, or an on-page anchor. Left empty, the link points at the blog page set under Settings > Reading; with no blog page set, it is not shown.', 'iflynepal' ),
		'section'     => 'iflynepal_travel_guide',
		'priority'    => 102,
		'type'        => 'text',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_guide_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-guide-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_guide_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_guide_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_post_settings = array();

	for ( $iflynepal_guide = 1; $iflynepal_guide <= IFLYNEPAL_GUIDE_MAX; $iflynepal_guide++ ) {
		$iflynepal_post_settings[] = 'iflynepal_guide_post_' . $iflynepal_guide;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_guide_posts',
		array(
			'selector'        => '#iflynepal-guide-posts',
			'settings'        => $iflynepal_post_settings,
			'render_callback' => 'iflynepal_render_guide_posts',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_guide_cta',
		array(
			'selector'        => '#iflynepal-guide-cta',
			'settings'        => array( 'iflynepal_guide_cta_label', 'iflynepal_guide_cta_url' ),
			'render_callback' => 'iflynepal_render_guide_cta',
		)
	);
}
