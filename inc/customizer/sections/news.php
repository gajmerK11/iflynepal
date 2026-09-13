<?php
/**
 * News panel.
 *
 * One section, the hero, plus the line that sits beside the Top News heading.
 * Everything else on the archive is generated — the three lead stories come
 * from a toggle on each story, the rest from the run of them.
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
	'iflynepal_news_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The band at the top of the News archive. The headline is fixed; the line under it and the search field are set here.', 'iflynepal' ),
		'panel'       => 'iflynepal_news',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_news_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_news_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_news_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_news_hero_lead',
	array(
		'default'           => IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_news_hero_lead',
	array(
		'label'       => __( 'Line under the headline', 'iflynepal' ),
		'description' => __( 'One sentence saying what the section is. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_news_hero',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_news_search_placeholder',
	array(
		'default'           => __( 'Search news…', 'iflynepal' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_news_search_placeholder',
	array(
		'label'       => __( 'Search field placeholder', 'iflynepal' ),
		'description' => __( 'The grey hint inside the field before anything is typed.', 'iflynepal' ),
		'section'     => 'iflynepal_news_hero',
		'priority'    => 30,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_news_top_note',
	array(
		'default'           => __( 'The stories our trip planners are fielding the most questions about right now.', 'iflynepal' ),
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_news_top_note',
	array(
		'label'       => __( 'Line beside the Top News heading', 'iflynepal' ),
		'description' => __( 'Says why those three lead. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_news_hero',
		'priority'    => 40,
		'type'        => 'textarea',
	)
);
