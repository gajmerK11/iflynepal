<?php
/**
 * Not Found section.
 *
 * The page a visitor lands on when nothing matched. A single section rather
 * than a panel: there is one block of copy on it, and a panel holding one
 * section is a click between an editor and the only thing they came for.
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
	'iflynepal_404',
	array(
		'title'       => __( 'Not Found (404)', 'iflynepal' ),
		'description' => __( 'What a visitor sees when the address they followed does not exist. Preview it by adding any nonsense to the end of the site address.', 'iflynepal' ),
		'priority'    => 43,
	)
);

/* ------------------------------------------------------------------- copy */

$wp_customize->add_setting(
	'iflynepal_404_kicker',
	array(
		'default'           => IFLYNEPAL_404_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_404_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_404',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_404_title',
	array(
		'default'           => IFLYNEPAL_404_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_404_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;span class="underline"&gt;word&lt;/span&gt; to draw the hand-inked underline under a word.', 'iflynepal' ),
		'section'     => 'iflynepal_404',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_404_lead',
	array(
		'default'           => IFLYNEPAL_404_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_404_lead',
	array(
		'label'       => __( 'Paragraph', 'iflynepal' ),
		'description' => __( 'The line under the heading. Accepts &lt;br&gt;, &lt;em&gt; and &lt;strong&gt;.', 'iflynepal' ),
		'section'     => 'iflynepal_404',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

/* ---------------------------------------------------------------- actions */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_404_actions_heading',
		array(
			'label'    => __( 'Buttons', 'iflynepal' ),
			'section'  => 'iflynepal_404',
			'priority' => 40,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_404_home_label',
	array(
		'default'           => IFLYNEPAL_404_HOME_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_404_home_label',
	array(
		'label'       => __( 'The gold action', 'iflynepal' ),
		'description' => __( 'Always points at the home page, so it has no link field. Emptying this removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_404',
		'priority'    => 41,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_404_back_label',
	array(
		'default'           => IFLYNEPAL_404_BACK_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_404_back_label',
	array(
		'label'       => __( 'The outlined action', 'iflynepal' ),
		'description' => __( 'Steps the browser back to the previous page, so it has no link field and is hidden when scripting is off. Emptying this removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_404',
		'priority'    => 42,
		'type'        => 'text',
	)
);

/* -------------------------------------------------------------- signposts */

for ( $iflynepal_link = 1; $iflynepal_link <= IFLYNEPAL_404_LINKS; $iflynepal_link++ ) {
	$iflynepal_default = iflynepal_404_link_default( $iflynepal_link );

	// A 10-wide band apiece, leaving room for the three fields between.
	$iflynepal_priority = 50 + ( ( $iflynepal_link - 1 ) * 10 );

	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			'iflynepal_404_link_' . $iflynepal_link . '_heading',
			array(
				'label'    => sprintf(
					/* translators: %d: signpost number. */
					__( 'Signpost %d', 'iflynepal' ),
					$iflynepal_link
				),
				'section'  => 'iflynepal_404',
				'priority' => $iflynepal_priority,
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'iflynepal_404_link_' . $iflynepal_link . '_label',
		array(
			'default'           => $iflynepal_default['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_404_link_' . $iflynepal_link . '_label',
		array(
			'label'       => __( 'Label', 'iflynepal' ),
			'description' => __( 'Emptying this removes the signpost.', 'iflynepal' ),
			'section'     => 'iflynepal_404',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_404_link_' . $iflynepal_link . '_url',
		array(
			'default'           => $iflynepal_default['url'],
			'sanitize_callback' => 'iflynepal_sanitize_link',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_404_link_' . $iflynepal_link . '_url',
		array(
			'label'       => __( 'Link', 'iflynepal' ),
			'description' => __( 'A full URL, or a path such as /packages/.', 'iflynepal' ),
			'section'     => 'iflynepal_404',
			'priority'    => $iflynepal_priority + 2,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_404_link_' . $iflynepal_link . '_description',
		array(
			'default'           => $iflynepal_default['description'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_404_link_' . $iflynepal_link . '_description',
		array(
			'label'       => __( 'Sub-line', 'iflynepal' ),
			'description' => __( 'The grey line under the label. Leave empty for a bare link.', 'iflynepal' ),
			'section'     => 'iflynepal_404',
			'priority'    => $iflynepal_priority + 3,
			'type'        => 'text',
		)
	);
}

/*
 * No image control. The right-hand column is the drawn numeral and nothing
 * else: it is decoration, it never goes stale, and it cannot be replaced with
 * a photograph that fights the heading beside it.
 */

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title', 'lead' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_404_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-404-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_404_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_404_' . $iflynepal_field,
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_404_actions',
		array(
			'selector'        => '#iflynepal-404-actions',
			'settings'        => array( 'iflynepal_404_home_label', 'iflynepal_404_back_label' ),
			'render_callback' => 'iflynepal_render_404_actions',
		)
	);

	$iflynepal_link_settings = array();

	for ( $iflynepal_link = 1; $iflynepal_link <= IFLYNEPAL_404_LINKS; $iflynepal_link++ ) {
		$iflynepal_link_settings[] = 'iflynepal_404_link_' . $iflynepal_link . '_label';
		$iflynepal_link_settings[] = 'iflynepal_404_link_' . $iflynepal_link . '_url';
		$iflynepal_link_settings[] = 'iflynepal_404_link_' . $iflynepal_link . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_404_links',
		array(
			'selector'        => '#iflynepal-404-links',
			'settings'        => $iflynepal_link_settings,
			'render_callback' => 'iflynepal_render_404_links',
		)
	);
}
