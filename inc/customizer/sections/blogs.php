<?php
/**
 * Blogs panel.
 *
 * One section, the hero — the Articles panel's four fields on settings of this
 * section's own. The archive under it is generated: the tabs come from the
 * category list, the cards from the posts.
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
	'iflynepal_blogs_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The band at the top of the Blogs archive: its headline, the line under it, and the search field.', 'iflynepal' ),
		'panel'       => 'iflynepal_blogs',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_blogs_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_blogs_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_blogs_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_blogs_hero_title',
	array(
		'default'           => IFLYNEPAL_BLOGS_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_blogs_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold accent. Each of the other words arrives on its own as the page opens. Kept short: on a wide screen the headline is held to one line.', 'iflynepal' ),
		'section'     => 'iflynepal_blogs_hero',
		'priority'    => 15,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_blogs_hero_lead',
	array(
		'default'           => IFLYNEPAL_BLOGS_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_blogs_hero_lead',
	array(
		'label'       => __( 'Line under the headline', 'iflynepal' ),
		'description' => __( 'One sentence saying what the section is. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_blogs_hero',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_blogs_search_placeholder',
	array(
		'default'           => __( 'Search treks, retreats…', 'iflynepal' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_blogs_search_placeholder',
	array(
		'label'       => __( 'Search field placeholder', 'iflynepal' ),
		'description' => __( 'The grey hint inside the field before anything is typed.', 'iflynepal' ),
		'section'     => 'iflynepal_blogs_hero',
		'priority'    => 30,
		'type'        => 'text',
	)
);

/*
 * As on the Articles panel: the headline and the standfirst refresh in place,
 * the picture and the placeholder reload the preview.
 */
$wp_customize->selective_refresh->add_partial(
	'iflynepal_blogs_hero_title',
	array(
		'selector'            => '#hero-title',
		'settings'            => array( 'iflynepal_blogs_hero_title' ),
		'render_callback'     => 'iflynepal_blogs_hero_title_html',
		'container_inclusive' => false,
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_blogs_hero_lead',
	array(
		'selector'            => '#hero-lead',
		'settings'            => array( 'iflynepal_blogs_hero_lead' ),
		'render_callback'     => 'iflynepal_blogs_hero_lead',
		'container_inclusive' => false,
	)
);
