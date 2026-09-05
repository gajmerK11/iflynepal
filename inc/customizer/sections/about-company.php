<?php
/**
 * About > Company section.
 *
 * The whole About page template in one section: hero, Overview and its card,
 * the vision statement, and the What We Offer rows. The Customizer has no
 * nested panels and no native way to group controls, so the four parts are
 * separated by IFly_Nepal_Customize_Heading_Control rather than being split
 * into sections of their own.
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
	'iflynepal_about_company',
	array(
		'title'       => __( 'Company', 'iflynepal' ),
		'description' => __( 'Everything on the About page template, in the order it appears.', 'iflynepal' ),
		'panel'       => 'iflynepal_about',
		'priority'    => 10,
	)
);

/* ------------------------------------------------------------------- hero */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_about_hero_heading',
		array(
			'label'    => __( 'Hero', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => 10,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_about_hero_title',
	array(
		'default'           => IFLYNEPAL_ABOUT_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_hero_title',
	array(
		'label'       => __( 'Hero title', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;em&gt;word&lt;/em&gt; to give a word the gold accent.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 11,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_hero_lead',
	array(
		'default'           => IFLYNEPAL_ABOUT_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_hero_lead',
	array(
		'label'       => __( 'Hero sub-title', 'iflynepal' ),
		'description' => __( 'The lines under the hero title.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$iflynepal_about_hero_button_labels = array(
	1 => __( 'Hero button 1 — the blue action', 'iflynepal' ),
	2 => __( 'Hero button 2 — the outlined action', 'iflynepal' ),
);

for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_ABOUT_HERO_BUTTONS; $iflynepal_button++ ) {
	$iflynepal_defaults = iflynepal_about_hero_button_defaults();
	$iflynepal_default  = isset( $iflynepal_defaults[ $iflynepal_button ] )
		? $iflynepal_defaults[ $iflynepal_button ]
		: array(
			'label' => '',
			'url'   => '',
		);

	$iflynepal_priority = 13 + ( ( $iflynepal_button - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_about_hero_button_' . $iflynepal_button . '_label',
		array(
			'default'           => $iflynepal_default['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_hero_button_' . $iflynepal_button . '_label',
		array(
			'label'       => isset( $iflynepal_about_hero_button_labels[ $iflynepal_button ] ) ? $iflynepal_about_hero_button_labels[ $iflynepal_button ] : sprintf(
				/* translators: %d: button number. */
				__( 'Hero button %d', 'iflynepal' ),
				$iflynepal_button
			),
			'description' => __( 'Emptying this removes the button.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => $iflynepal_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_about_hero_button_' . $iflynepal_button . '_url',
		array(
			'default'           => $iflynepal_default['url'],
			'sanitize_callback' => 'iflynepal_sanitize_link',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_hero_button_' . $iflynepal_button . '_url',
		array(
			'label'       => __( 'Link', 'iflynepal' ),
			'description' => __( 'A full URL, or an on-page anchor such as #offer.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'text',
		)
	);
}

$wp_customize->add_setting(
	'iflynepal_about_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_about_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Fills the hero behind a dark scrim, so a wide landscape works best. At least 2200px wide.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => 20,
			'mime_type'   => 'image',
		)
	)
);

/* --------------------------------------------------------------- overview */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_about_overview_heading',
		array(
			'label'    => __( 'Overview', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => 30,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_about_overview_kicker',
	array(
		'default'           => IFLYNEPAL_ABOUT_OVERVIEW_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_overview_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading ("About iFly Nepal").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 31,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_overview_title',
	array(
		'default'           => IFLYNEPAL_ABOUT_OVERVIEW_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_overview_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'The large heading under the kicker ("Overview").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 32,
		'type'        => 'textarea',
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_story = 1; $iflynepal_story <= IFLYNEPAL_ABOUT_STORY_MAX; $iflynepal_story++ ) {
	$wp_customize->add_setting(
		'iflynepal_about_story_' . $iflynepal_story,
		array(
			'default'           => iflynepal_about_story_default( $iflynepal_story ),
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_story_' . $iflynepal_story,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_story ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => 32 + $iflynepal_story,
			'type'        => 'textarea',
		)
	);
}

/* ------------------------------------------------------------- promo card */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_about_promo_heading',
		array(
			'label'    => __( 'Overview card', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => 50,
			'settings' => array(),
		)
	)
);

$iflynepal_about_promo = iflynepal_about_promo_defaults();

$wp_customize->add_setting(
	'iflynepal_about_promo_kicker',
	array(
		'default'           => $iflynepal_about_promo['kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_promo_kicker',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'The small capitalised line at the top of the card ("Start planning").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 51,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_promo_title',
	array(
		'default'           => $iflynepal_about_promo['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_promo_title',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The large line under it ("Tell us how you want to travel").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 52,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_promo_description',
	array(
		'default'           => $iflynepal_about_promo['description'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_promo_description',
	array(
		'label'    => __( 'Description', 'iflynepal' ),
		'section'  => 'iflynepal_about_company',
		'priority' => 53,
		'type'     => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_promo_button_label',
	array(
		'default'           => $iflynepal_about_promo['button_label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_promo_button_label',
	array(
		'label'       => __( 'Button label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 54,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_promo_button_url',
	array(
		'default'           => $iflynepal_about_promo['button_url'],
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_promo_button_url',
	array(
		'label'       => __( 'Button link', 'iflynepal' ),
		'description' => __( 'A full URL, or an on-page anchor such as #offer.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 55,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_promo_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_about_promo_image',
		array(
			'label'       => __( 'Card background image', 'iflynepal' ),
			'description' => __( 'Sits behind the card under a dark gradient, so a photograph with room at the bottom works best. Portrait or square, at least 1200px wide.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => 56,
			'mime_type'   => 'image',
		)
	)
);

/* ----------------------------------------------------------------- vision */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_about_vision_heading',
		array(
			'label'    => __( 'Our Vision', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => 60,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_about_vision_title',
	array(
		'default'           => IFLYNEPAL_ABOUT_VISION_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_vision_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'The small capitalised line over the statement ("Our Vision").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 61,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_vision_content',
	array(
		'default'           => IFLYNEPAL_ABOUT_VISION_CONTENT_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_vision_content',
	array(
		'label'       => __( 'Content', 'iflynepal' ),
		'description' => __( 'The statement itself. Wrap a phrase in &lt;span class="accent"&gt;&lt;/span&gt; to give it the gold treatment.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 62,
		'type'        => 'textarea',
	)
);

/* ----------------------------------------------------------- what we offer */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_about_offer_heading',
		array(
			'label'    => __( 'What We Offer', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => 70,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_about_offer_kicker',
	array(
		'default'           => IFLYNEPAL_ABOUT_OFFER_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_offer_kicker',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading ("What We Offer").', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 71,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_offer_title',
	array(
		'default'           => IFLYNEPAL_ABOUT_OFFER_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_offer_title',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The large heading under it. Accepts &lt;br&gt;, and &lt;span class="underline"&gt;word&lt;/span&gt; to draw the hand-inked underline under a word.', 'iflynepal' ),
		'section'     => 'iflynepal_about_company',
		'priority'    => 72,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_about_offer_lead',
	array(
		'default'           => IFLYNEPAL_ABOUT_OFFER_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_about_offer_lead',
	array(
		'label'    => __( 'Description', 'iflynepal' ),
		'section'  => 'iflynepal_about_company',
		'priority' => 73,
		'type'     => 'textarea',
	)
);

/*
 * All row slots are registered here; the Customizer's control script hides the
 * empty ones behind an "Add offering" button.
 */
for ( $iflynepal_offer = 1; $iflynepal_offer <= IFLYNEPAL_ABOUT_OFFER_MAX; $iflynepal_offer++ ) {
	$iflynepal_offer_default = iflynepal_about_offer_default( $iflynepal_offer );

	// A 10-wide band per row, leaving room for its four fields between.
	$iflynepal_offer_priority = 80 + ( ( $iflynepal_offer - 1 ) * 10 );

	$wp_customize->add_setting(
		'iflynepal_about_offer_' . $iflynepal_offer . '_number',
		array(
			'default'           => $iflynepal_offer_default['number'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_offer_' . $iflynepal_offer . '_number',
		array(
			/* translators: %d: row number. */
			'label'       => sprintf( __( 'Offering %d number', 'iflynepal' ), $iflynepal_offer ),
			'description' => __( 'The large numeral on the card, such as 01.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => $iflynepal_offer_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_about_offer_' . $iflynepal_offer . '_title',
		array(
			'default'           => $iflynepal_offer_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_offer_' . $iflynepal_offer . '_title',
		array(
			'label'       => __( 'Title', 'iflynepal' ),
			'description' => __( 'Emptying this removes the offering.', 'iflynepal' ),
			'section'     => 'iflynepal_about_company',
			'priority'    => $iflynepal_offer_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_about_offer_' . $iflynepal_offer . '_description',
		array(
			'default'           => $iflynepal_offer_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_about_offer_' . $iflynepal_offer . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
			'priority' => $iflynepal_offer_priority + 2,
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_about_offer_' . $iflynepal_offer . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_about_offer_' . $iflynepal_offer . '_image',
			array(
				'label'       => __( 'Image', 'iflynepal' ),
				'description' => __( 'Landscape, at least 1200px wide. Its alt text is taken from the media library.', 'iflynepal' ),
				'section'     => 'iflynepal_about_company',
				'priority'    => $iflynepal_offer_priority + 3,
				'mime_type'   => 'image',
			)
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$iflynepal_about_partials = array(
		'hero_title'        => 'iflynepal-about-hero-title',
		'hero_lead'         => 'iflynepal-about-hero-lead',
		'overview_kicker'   => 'iflynepal-about-overview-kicker',
		'overview_title'    => 'iflynepal-about-overview-title',
		'promo_kicker'      => 'iflynepal-about-promo-kicker',
		'promo_title'       => 'iflynepal-about-promo-title',
		'promo_description' => 'iflynepal-about-promo-description',
		'vision_title'      => 'iflynepal-about-vision-title',
		'vision_content'    => 'iflynepal-about-vision-content',
		'offer_kicker'      => 'iflynepal-about-offer-kicker',
		'offer_title'       => 'iflynepal-about-offer-title',
		'offer_lead'        => 'iflynepal-about-offer-lead',
	);

	foreach ( $iflynepal_about_partials as $iflynepal_field => $iflynepal_selector ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_about_' . $iflynepal_field,
			array(
				'selector'        => '#' . $iflynepal_selector,
				'settings'        => array( 'iflynepal_about_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_about_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_hero_button_settings = array();

	for ( $iflynepal_button = 1; $iflynepal_button <= IFLYNEPAL_ABOUT_HERO_BUTTONS; $iflynepal_button++ ) {
		$iflynepal_hero_button_settings[] = 'iflynepal_about_hero_button_' . $iflynepal_button . '_label';
		$iflynepal_hero_button_settings[] = 'iflynepal_about_hero_button_' . $iflynepal_button . '_url';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_about_hero_actions',
		array(
			'selector'        => '#iflynepal-about-hero-actions',
			'settings'        => $iflynepal_hero_button_settings,
			'render_callback' => 'iflynepal_render_about_hero_actions',
		)
	);

	$iflynepal_story_settings = array();

	for ( $iflynepal_story = 1; $iflynepal_story <= IFLYNEPAL_ABOUT_STORY_MAX; $iflynepal_story++ ) {
		$iflynepal_story_settings[] = 'iflynepal_about_story_' . $iflynepal_story;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_about_story',
		array(
			'selector'        => '#iflynepal-about-story',
			'settings'        => $iflynepal_story_settings,
			'render_callback' => 'iflynepal_render_about_story',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_about_promo_button',
		array(
			'selector'        => '#iflynepal-about-promo-button',
			'settings'        => array( 'iflynepal_about_promo_button_label', 'iflynepal_about_promo_button_url' ),
			'render_callback' => 'iflynepal_render_about_promo_button',
		)
	);

	$iflynepal_offer_settings = array();

	for ( $iflynepal_offer = 1; $iflynepal_offer <= IFLYNEPAL_ABOUT_OFFER_MAX; $iflynepal_offer++ ) {
		$iflynepal_offer_settings[] = 'iflynepal_about_offer_' . $iflynepal_offer . '_number';
		$iflynepal_offer_settings[] = 'iflynepal_about_offer_' . $iflynepal_offer . '_title';
		$iflynepal_offer_settings[] = 'iflynepal_about_offer_' . $iflynepal_offer . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_about_offers',
		array(
			'selector'        => '#iflynepal-about-offers',
			'settings'        => $iflynepal_offer_settings,
			'render_callback' => 'iflynepal_render_about_offers',
		)
	);
}
