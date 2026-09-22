<?php
/**
 * Authors panel.
 *
 * Two sections: the Authors archive's hero, and the banner photograph shared
 * by every single author's page. Everything else on either page is drawn
 * from the authors themselves: their profile fields (inc/user-profile.php)
 * and their published posts, so there is nothing else here to set.
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
	'iflynepal_authors_hero',
	array(
		'title'       => __( 'Archive hero', 'iflynepal' ),
		'description' => __( 'The band at the top of the Authors directory: its headline, the line under it, and the photograph behind them.', 'iflynepal' ),
		'panel'       => 'iflynepal_authors',
		'priority'    => 10,
	)
);

$wp_customize->add_setting(
	'iflynepal_authors_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_authors_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1700px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_authors_hero',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_authors_hero_title',
	array(
		'default'           => IFLYNEPAL_AUTHORS_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_authors_hero_title',
	array(
		'label'       => __( 'Headline', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt;word&lt;/em&gt; to give it the gold accent.', 'iflynepal' ),
		'section'     => 'iflynepal_authors_hero',
		'priority'    => 15,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_authors_hero_lead',
	array(
		'default'           => IFLYNEPAL_AUTHORS_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_authors_hero_lead',
	array(
		'label'       => __( 'Line under the headline', 'iflynepal' ),
		'description' => __( 'One sentence saying what the directory is. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_authors_hero',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_authors_hero_title',
	array(
		'selector'            => '#hero-title-authors',
		'settings'            => array( 'iflynepal_authors_hero_title' ),
		'render_callback'     => 'iflynepal_authors_hero_title_html',
		'container_inclusive' => false,
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_authors_hero_lead',
	array(
		'selector'            => '#hero-lead-authors',
		'settings'            => array( 'iflynepal_authors_hero_lead' ),
		'render_callback'     => 'iflynepal_authors_hero_lead',
		'container_inclusive' => false,
	)
);

/*
 * The single-author banner. One photograph for every author's page, the way
 * CloudColleague's "Author Profile" section works. An individual's own
 * photo is the Profile Photo field on their user profile, which sits over
 * this banner rather than replacing it.
 */
$wp_customize->add_section(
	'iflynepal_author_banner',
	array(
		'title'       => __( 'Author page banner', 'iflynepal' ),
		'description' => __( 'The photograph behind the avatar on every single author page.', 'iflynepal' ),
		'panel'       => 'iflynepal_authors',
		'priority'    => 20,
	)
);

$wp_customize->add_setting(
	'iflynepal_author_banner_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_author_banner_image',
		array(
			'label'       => __( 'Banner image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 2200px. This one crops much tighter than the archive hero above.', 'iflynepal' ),
			'section'     => 'iflynepal_author_banner',
			'priority'    => 10,
			'mime_type'   => 'image',
		)
	)
);
