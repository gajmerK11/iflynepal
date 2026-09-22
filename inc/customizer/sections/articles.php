<?php
/**
 * Articles panel.
 *
 * One section, the hero. The archive under it is generated — the tabs come
 * from the category list, the cards from the articles — so there is nothing
 * else on the page for an editor to set.
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
	'iflynepal_articles_hero',
	array(
		'title'       => __( 'Hero', 'iflynepal' ),
		'description' => __( 'The band at the top of the Articles archive: its headline, the line under it, and the search field.', 'iflynepal' ),
		'panel'       => 'iflynepal_articles',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_articles_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_articles_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_articles_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_articles_hero_title',
	array(
		'default'           => IFLYNEPAL_ARTICLES_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_articles_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold accent. Each of the other words arrives on its own as the page opens. Kept short: on a wide screen the headline is held to one line.', 'iflynepal' ),
		'section'     => 'iflynepal_articles_hero',
		'priority'    => 15,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_articles_hero_lead',
	array(
		'default'           => IFLYNEPAL_ARTICLES_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_articles_hero_lead',
	array(
		'label'       => __( 'Line under the headline', 'iflynepal' ),
		'description' => __( 'One sentence saying what the section is. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_articles_hero',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_articles_search_placeholder',
	array(
		'default'           => __( 'Search treks, retreats…', 'iflynepal' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_articles_search_placeholder',
	array(
		'label'       => __( 'Search field placeholder', 'iflynepal' ),
		'description' => __( 'The grey hint inside the field before anything is typed.', 'iflynepal' ),
		'section'     => 'iflynepal_articles_hero',
		'priority'    => 30,
		'type'        => 'text',
	)
);

/*
 * The headline and the standfirst refresh in place rather than reloading the
 * preview. The hero's picture and the search placeholder are left on a full
 * refresh: one is a background, the other an attribute, and neither is worth a
 * partial.
 *
 * A search rewrites the headline into "You searched for: …", which is not this
 * setting — the partial simply never matches on that view, because the element
 * it is keyed to is the same one either way and the preview is not a search.
 */
$wp_customize->selective_refresh->add_partial(
	'iflynepal_articles_hero_title',
	array(
		'selector'            => '#hero-title-articles',
		'settings'            => array( 'iflynepal_articles_hero_title' ),
		'render_callback'     => 'iflynepal_articles_hero_title_html',
		'container_inclusive' => false,
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_articles_hero_lead',
	array(
		'selector'            => '#hero-lead-articles',
		'settings'            => array( 'iflynepal_articles_hero_lead' ),
		'render_callback'     => 'iflynepal_articles_hero_lead',
		'container_inclusive' => false,
	)
);
