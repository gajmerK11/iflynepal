<?php
/**
 * About > CSR section.
 *
 * The whole CSR page template in one section, in page order: the hero, the
 * commitment, the pledge band, the sustainability pillars, the community
 * projects, the ways tourism empowers, the accountability statement and the
 * closing invitation.
 *
 * Separated by IFly_Nepal_Customize_Heading_Control rather than split into
 * sections of their own, the same arrangement About > Company, About > Nepal
 * and About > Team use — the Customizer has no nested panels.
 *
 * Emptying a section's heading hides that section. Three of the blocks are
 * add/remove lists driven by assets/js/csr/repeaters.js.
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
	'iflynepal_csr',
	array(
		'title'       => __( 'CSR', 'iflynepal' ),
		'description' => __( 'Everything on the CSR page template, in the order it appears. Emptying a section\'s heading hides that section; emptying an item\'s title removes it from its list.', 'iflynepal' ),
		'panel'       => 'iflynepal_about',
		'priority'    => 40,
	)
);

/* ------------------------------------------------------------------- hero */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_hero_heading',
		array(
			'label'    => __( 'Hero', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 10,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_hero_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_HERO_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_hero_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 11,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_hero_title',
	array(
		'default'           => IFLYNEPAL_CSR_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold serif accent.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_hero_lead',
	array(
		'default'           => IFLYNEPAL_CSR_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_hero_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The line under the headline.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 13,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_csr_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => 14,
			'mime_type'   => 'image',
		)
	)
);

/* ------------------------------------------------------------ commitment */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_commitment_heading',
		array(
			'label'    => __( 'Our Commitment', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 100,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_commitment_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_COMMITMENT_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_commitment_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 101,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_commitment_title',
	array(
		'default'           => IFLYNEPAL_CSR_COMMITMENT_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_commitment_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 102,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_commitment_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_csr_commitment_image',
		array(
			'label'       => __( 'Photograph', 'iflynepal' ),
			'description' => __( 'The tall frame beside the copy. Landscape or portrait, at least 1200px.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => 103,
			'mime_type'   => 'image',
		)
	)
);

for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_CSR_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_csr_commitment_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => iflynepal_csr_commitment_default( $iflynepal_paragraph ),
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_commitment_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => 110 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

/* ----------------------------------------------------------- pledge band */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_pledge_heading',
		array(
			'label'    => __( 'Pledge band', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 200,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_pledge_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_PLEDGE_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_pledge_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 201,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_pledge',
	array(
		'default'           => IFLYNEPAL_CSR_PLEDGE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_pledge',
	array(
		'label'       => __( 'Pledge', 'iflynepal' ),
		'description' => __( 'Set large and on one line, so keep it short. Wrap a word in &lt;em&gt;word&lt;/em&gt; for the gold serif accent. Emptying it hides the band.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 202,
		'type'        => 'textarea',
	)
);

/* --------------------------------------------------------------- pillars */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_pillars_heading',
		array(
			'label'       => __( 'Sustainability pillars', 'iflynepal' ),
			'description' => __( 'The wide rows under the pledge. They alternate sides down the page and are numbered in order automatically.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => 300,
			'settings'    => array(),
		)
	)
);

for ( $iflynepal_pillar = 1; $iflynepal_pillar <= IFLYNEPAL_CSR_PILLAR_MAX; $iflynepal_pillar++ ) {
	$iflynepal_pillar_default  = iflynepal_csr_pillar_default( $iflynepal_pillar );
	$iflynepal_pillar_priority = 310 + ( ( $iflynepal_pillar - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_csr_pillar_' . $iflynepal_pillar . '_title',
		array(
			'default'           => $iflynepal_pillar_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_pillar_' . $iflynepal_pillar . '_title',
		array(
			/* translators: %d: pillar number. */
			'label'       => sprintf( __( 'Pillar %d title', 'iflynepal' ), $iflynepal_pillar ),
			'description' => __( 'Emptying this removes the row.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => $iflynepal_pillar_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_csr_pillar_' . $iflynepal_pillar . '_description',
		array(
			'default'           => $iflynepal_pillar_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_pillar_' . $iflynepal_pillar . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => $iflynepal_pillar_priority + 1,
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_csr_pillar_' . $iflynepal_pillar . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_csr_pillar_' . $iflynepal_pillar . '_image',
			array(
				'label'       => __( 'Image', 'iflynepal' ),
				'description' => __( 'Fills half the row. Landscape, at least 1200px.', 'iflynepal' ),
				'section'     => 'iflynepal_csr',
				'priority'    => $iflynepal_pillar_priority + 2,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ---------------------------------------------------- community projects */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_community_heading',
		array(
			'label'    => __( 'Community Engagement', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 400,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_community_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_COMMUNITY_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_community_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 401,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_community_title',
	array(
		'default'           => IFLYNEPAL_CSR_COMMUNITY_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_community_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 402,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_project = 1; $iflynepal_project <= IFLYNEPAL_CSR_PROJECT_MAX; $iflynepal_project++ ) {
	$iflynepal_project_default  = iflynepal_csr_project_default( $iflynepal_project );
	$iflynepal_project_priority = 410 + ( ( $iflynepal_project - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_csr_project_' . $iflynepal_project . '_title',
		array(
			'default'           => $iflynepal_project_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_project_' . $iflynepal_project . '_title',
		array(
			/* translators: %d: project number. */
			'label'       => sprintf( __( 'Project %d title', 'iflynepal' ), $iflynepal_project ),
			'description' => __( 'Emptying this removes the card.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => $iflynepal_project_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_csr_project_' . $iflynepal_project . '_description',
		array(
			'default'           => $iflynepal_project_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_project_' . $iflynepal_project . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => $iflynepal_project_priority + 1,
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_csr_project_' . $iflynepal_project . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_csr_project_' . $iflynepal_project . '_image',
			array(
				'label'       => __( 'Image', 'iflynepal' ),
				'description' => __( 'The band across the top of the card. Landscape, at least 800px.', 'iflynepal' ),
				'section'     => 'iflynepal_csr',
				'priority'    => $iflynepal_project_priority + 2,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ------------------------------------------------ empowering through tourism */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_tourism_heading',
		array(
			'label'    => __( 'Empowering Through Tourism', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 500,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_tourism_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_TOURISM_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_tourism_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 501,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_tourism_title',
	array(
		'default'           => IFLYNEPAL_CSR_TOURISM_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_tourism_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 502,
		'type'        => 'textarea',
	)
);

for ( $iflynepal_tourism = 1; $iflynepal_tourism <= IFLYNEPAL_CSR_TOURISM_MAX; $iflynepal_tourism++ ) {
	$iflynepal_tourism_default  = iflynepal_csr_tourism_default( $iflynepal_tourism );
	$iflynepal_tourism_priority = 510 + ( ( $iflynepal_tourism - 1 ) * 2 );

	$wp_customize->add_setting(
		'iflynepal_csr_tourism_' . $iflynepal_tourism . '_title',
		array(
			'default'           => $iflynepal_tourism_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_tourism_' . $iflynepal_tourism . '_title',
		array(
			/* translators: %d: panel number. */
			'label'       => sprintf( __( 'Panel %d title', 'iflynepal' ), $iflynepal_tourism ),
			'description' => __( 'Emptying this removes the panel.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => $iflynepal_tourism_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_csr_tourism_' . $iflynepal_tourism . '_description',
		array(
			'default'           => $iflynepal_tourism_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_csr_tourism_' . $iflynepal_tourism . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => $iflynepal_tourism_priority + 1,
			'type'     => 'textarea',
		)
	);
}

/* -------------------------------------------------------- accountability */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_accountability_heading',
		array(
			'label'    => __( 'Transparency and Accountability', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 600,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_accountability_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_ACCOUNTABILITY_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_accountability_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 601,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_accountability_title',
	array(
		'default'           => IFLYNEPAL_CSR_ACCOUNTABILITY_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_accountability_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole section.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 602,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_accountability_text',
	array(
		'default'           => IFLYNEPAL_CSR_ACCOUNTABILITY_TEXT_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_accountability_text',
	array(
		'label'    => __( 'Paragraph', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 603,
		'type'     => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_accountability_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_csr_accountability_image',
		array(
			'label'       => __( 'Photograph', 'iflynepal' ),
			'description' => __( 'The wide frame beside the copy. Landscape, at least 1400px.', 'iflynepal' ),
			'section'     => 'iflynepal_csr',
			'priority'    => 604,
			'mime_type'   => 'image',
		)
	)
);

/* --------------------------------------------------------------- closing */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_csr_close_heading',
		array(
			'label'    => __( 'Closing invitation', 'iflynepal' ),
			'section'  => 'iflynepal_csr',
			'priority' => 700,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_close_kicker',
	array(
		'default'           => IFLYNEPAL_CSR_CLOSE_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_close_kicker',
	array(
		'label'    => __( 'Kicker', 'iflynepal' ),
		'section'  => 'iflynepal_csr',
		'priority' => 701,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_close_title',
	array(
		'default'           => IFLYNEPAL_CSR_CLOSE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_close_title',
	array(
		'label'       => __( 'Headline, first line', 'iflynepal' ),
		'description' => __( 'Each line is held to one row on a wide screen, so keep them short.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 702,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_close_title_two',
	array(
		'default'           => IFLYNEPAL_CSR_CLOSE_TITLE_TWO_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_close_title_two',
	array(
		'label'       => __( 'Headline, second line', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; for the serif accent. Emptying both lines hides the block.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 703,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_csr_close_text',
	array(
		'default'           => IFLYNEPAL_CSR_CLOSE_TEXT_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_rich',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_csr_close_text',
	array(
		'label'       => __( 'Paragraph', 'iflynepal' ),
		'description' => __( 'The only field on this page that accepts a link: write it as &lt;a href="mailto:you@example.com"&gt;you@example.com&lt;/a&gt;.', 'iflynepal' ),
		'section'     => 'iflynepal_csr',
		'priority'    => 704,
		'type'        => 'textarea',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	/*
	 * The copy fields are one partial apiece; the three lists are one partial
	 * for the whole list, because removing an item changes how many there are
	 * and — for the pillars, projects and panels — renumbers everything after
	 * it.
	 */
	$iflynepal_csr_fields = array(
		'hero_kicker'           => '#iflynepal-csr-hero-kicker',
		'hero_title'            => '#iflynepal-csr-hero-title',
		'hero_lead'             => '#iflynepal-csr-hero-lead',
		'commitment_kicker'     => '#iflynepal-csr-commitment-kicker',
		'commitment_title'      => '#iflynepal-csr-commitment-title',
		'pledge_kicker'         => '#iflynepal-csr-pledge-kicker',
		'pledge'                => '#iflynepal-csr-pledge',
		'community_kicker'      => '#iflynepal-csr-community-kicker',
		'community_title'       => '#iflynepal-csr-community-title',
		'tourism_kicker'        => '#iflynepal-csr-tourism-kicker',
		'tourism_title'         => '#iflynepal-csr-tourism-title',
		'accountability_kicker' => '#iflynepal-csr-accountability-kicker',
		'accountability_title'  => '#iflynepal-csr-accountability-title',
		'accountability_text'   => '#iflynepal-csr-accountability-text',
		'close_kicker'          => '#iflynepal-csr-close-kicker',
		'close_text'            => '#iflynepal-csr-close-text',
	);

	foreach ( $iflynepal_csr_fields as $iflynepal_field => $iflynepal_selector ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_csr_' . $iflynepal_field,
			array(
				'selector'        => $iflynepal_selector,
				'settings'        => array( 'iflynepal_csr_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_csr_' . $iflynepal_field,
			)
		);
	}

	// Both headline lines feed one fragment — see the render callback.
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_csr_close_title',
		array(
			'selector'        => '#iflynepal-csr-close-title',
			'settings'        => array( 'iflynepal_csr_close_title', 'iflynepal_csr_close_title_two' ),
			'render_callback' => 'iflynepal_render_csr_close_title',
		)
	);

	$iflynepal_commitment_settings = array();

	for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_CSR_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
		$iflynepal_commitment_settings[] = 'iflynepal_csr_commitment_paragraph_' . $iflynepal_paragraph;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_csr_commitment_paragraphs',
		array(
			'selector'        => '#iflynepal-csr-commitment-copy',
			'settings'        => $iflynepal_commitment_settings,
			'render_callback' => 'iflynepal_render_csr_commitment_paragraphs',
		)
	);

	$iflynepal_pillar_settings = array();

	for ( $iflynepal_pillar = 1; $iflynepal_pillar <= IFLYNEPAL_CSR_PILLAR_MAX; $iflynepal_pillar++ ) {
		$iflynepal_pillar_settings[] = 'iflynepal_csr_pillar_' . $iflynepal_pillar . '_title';
		$iflynepal_pillar_settings[] = 'iflynepal_csr_pillar_' . $iflynepal_pillar . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_csr_pillars',
		array(
			'selector'        => '#iflynepal-csr-pillars',
			'settings'        => $iflynepal_pillar_settings,
			'render_callback' => 'iflynepal_render_csr_pillars',
		)
	);

	$iflynepal_project_settings = array();

	for ( $iflynepal_project = 1; $iflynepal_project <= IFLYNEPAL_CSR_PROJECT_MAX; $iflynepal_project++ ) {
		$iflynepal_project_settings[] = 'iflynepal_csr_project_' . $iflynepal_project . '_title';
		$iflynepal_project_settings[] = 'iflynepal_csr_project_' . $iflynepal_project . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_csr_projects',
		array(
			'selector'        => '#iflynepal-csr-projects',
			'settings'        => $iflynepal_project_settings,
			'render_callback' => 'iflynepal_render_csr_projects',
		)
	);

	$iflynepal_tourism_settings = array();

	for ( $iflynepal_tourism = 1; $iflynepal_tourism <= IFLYNEPAL_CSR_TOURISM_MAX; $iflynepal_tourism++ ) {
		$iflynepal_tourism_settings[] = 'iflynepal_csr_tourism_' . $iflynepal_tourism . '_title';
		$iflynepal_tourism_settings[] = 'iflynepal_csr_tourism_' . $iflynepal_tourism . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_csr_tourism_items',
		array(
			'selector'        => '#iflynepal-csr-tourism-items',
			'settings'        => $iflynepal_tourism_settings,
			'render_callback' => 'iflynepal_render_csr_tourism_items',
		)
	);
}
