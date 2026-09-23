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
 * The heading and standfirst over the authors grid, under the hero.
 */
$wp_customize->add_section(
	'iflynepal_authors_list',
	array(
		'title'       => __( 'Grid heading', 'iflynepal' ),
		'description' => __( 'The heading and line above the grid of author cards.', 'iflynepal' ),
		'panel'       => 'iflynepal_authors',
		'priority'    => 15,
	)
);

$wp_customize->add_setting(
	'iflynepal_authors_list_heading',
	array(
		'default'           => IFLYNEPAL_AUTHORS_LIST_HEADING_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_ink_heading',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_authors_list_heading',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;span class="ink-mark"&gt;word&lt;i class="ink-line"&gt;&lt;/i&gt;&lt;/span&gt; to give it the underline accent.', 'iflynepal' ),
		'section'     => 'iflynepal_authors_list',
		'priority'    => 10,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_authors_list_lead',
	array(
		'default'           => IFLYNEPAL_AUTHORS_LIST_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_authors_list_lead',
	array(
		'label'       => __( 'Line under the heading', 'iflynepal' ),
		'description' => __( 'One sentence. Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_authors_list',
		'priority'    => 15,
		'type'        => 'textarea',
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_authors_list_heading',
	array(
		'selector'            => '#authors-title',
		'settings'            => array( 'iflynepal_authors_list_heading' ),
		'render_callback'     => 'iflynepal_authors_list_heading',
		'container_inclusive' => false,
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_authors_list_lead',
	array(
		'selector'            => '#authors-list-lead',
		'settings'            => array( 'iflynepal_authors_list_lead' ),
		'render_callback'     => 'iflynepal_authors_list_lead',
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

$wp_customize->add_setting(
	'iflynepal_author_posts_eyebrow',
	array(
		'default'           => IFLYNEPAL_AUTHOR_POSTS_EYEBROW_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_author_posts_eyebrow',
	array(
		'label'       => __( 'Posts section eyebrow', 'iflynepal' ),
		'description' => __( 'Above "Read my …", over the grid of this author\'s own writing.', 'iflynepal' ),
		'section'     => 'iflynepal_author_banner',
		'priority'    => 20,
	)
);

$wp_customize->add_setting(
	'iflynepal_author_posts_lead',
	array(
		'default'           => IFLYNEPAL_AUTHOR_POSTS_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_author_posts_lead',
	array(
		'label'       => __( 'Posts section line', 'iflynepal' ),
		'description' => __( 'One sentence under "Read my …". Empty removes it.', 'iflynepal' ),
		'section'     => 'iflynepal_author_banner',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_author_posts_eyebrow',
	array(
		'selector'            => '#author-posts-eyebrow',
		'settings'            => array( 'iflynepal_author_posts_eyebrow' ),
		'render_callback'     => 'iflynepal_author_posts_eyebrow',
		'container_inclusive' => false,
	)
);

$wp_customize->selective_refresh->add_partial(
	'iflynepal_author_posts_lead',
	array(
		'selector'            => '#author-posts-lead',
		'settings'            => array( 'iflynepal_author_posts_lead' ),
		'render_callback'     => 'iflynepal_author_posts_lead',
		'container_inclusive' => false,
	)
);
