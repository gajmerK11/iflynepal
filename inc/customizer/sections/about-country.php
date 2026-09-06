<?php
/**
 * About > Nepal section.
 *
 * The whole About Nepal page template in one section: the hero, then the nine
 * country chapters in page order, each with its kicker, heading, banner and
 * paragraphs, followed by whichever component that chapter carries.
 *
 * The Customizer has no nested panels and no native way to group controls, so
 * the chapters are separated by IFly_Nepal_Customize_Heading_Control rather
 * than being split into sections of their own — the same arrangement About >
 * Company uses, and the reason this one section is long.
 *
 * Two things on the page are deliberately not editable: the climate comparison
 * table and the visa fee schedule. Both are dense reference data — six
 * readings across three cities, and about fifteen numbered fee clauses — that
 * changes rarely and would be painful to maintain through a Customizer form.
 * They live in their template parts.
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
	'iflynepal_about_country',
	array(
		'title'       => __( 'Nepal', 'iflynepal' ),
		'description' => __( 'Everything on the About Nepal page template, in the order it appears. Emptying a chapter\'s heading hides that chapter and drops it from the index bar.', 'iflynepal' ),
		'panel'       => 'iflynepal_about',
		'priority'    => 20,
	)
);

/* ------------------------------------------------------------------- hero */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_hero_heading',
		array(
			'label'    => __( 'Hero', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 10,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_country_hero_title',
	array(
		'default'           => IFLYNEPAL_COUNTRY_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_hero_title',
	array(
		'label'       => __( 'Hero title', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;em&gt;word&lt;/em&gt; to give a word the gold accent.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 11,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_hero_lead',
	array(
		'default'           => IFLYNEPAL_COUNTRY_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_hero_lead',
	array(
		'label'       => __( 'Hero sub-title', 'iflynepal' ),
		'description' => __( 'The line under the hero title.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 2200px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 13,
			'mime_type'   => 'image',
		)
	)
);

/* --------------------------------------------------------- geography */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_geography_heading',
		array(
			'label'    => __( 'Geography', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 100,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter       = iflynepal_country_chapter( 'geography' );
$iflynepal_note_defaults = iflynepal_country_note_defaults();

$wp_customize->add_setting(
	'iflynepal_country_geography_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_geography_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 101,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_geography_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_geography_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 102,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_geography_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_geography_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 103,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_geography_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_geography_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 104,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_geography_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_geography_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 104 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

$wp_customize->add_setting(
	'iflynepal_country_note_label',
	array(
		'default'           => $iflynepal_note_defaults['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_note_label',
	array(
		'label'       => __( 'Note label', 'iflynepal' ),
		'description' => __( 'The small caps line opening the note under the banner.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 120,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_note_title',
	array(
		'default'           => $iflynepal_note_defaults['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_note_title',
	array(
		'label'       => __( 'Note heading', 'iflynepal' ),
		'description' => __( 'The figure the note is about.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 121,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_note_text',
	array(
		'default'           => $iflynepal_note_defaults['text'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_note_text',
	array(
		'label'       => __( 'Note text', 'iflynepal' ),
		'description' => __( 'The sentence under the note heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 122,
		'type'        => 'textarea',
	)
);

/* ------------------------------------------------------------ people */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_people_heading',
		array(
			'label'    => __( 'People', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 200,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'people' );

$wp_customize->add_setting(
	'iflynepal_country_people_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_people_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 201,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_people_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_people_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 202,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_people_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_people_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 203,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_people_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_people_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 204,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_people_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_people_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 204 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_bands_heading',
		array(
			'label'    => __( 'People — cards', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 220,
			'settings' => array(),
		)
	)
);

/*
 * All card slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add card" button.
 */
for ( $iflynepal_band = 1; $iflynepal_band <= IFLYNEPAL_COUNTRY_BAND_MAX; $iflynepal_band++ ) {
	$iflynepal_band_default  = iflynepal_country_band_default( $iflynepal_band );
	$iflynepal_band_priority = 221 + ( ( $iflynepal_band - 1 ) * 2 );

	$wp_customize->add_setting(
		'iflynepal_country_band_' . $iflynepal_band . '_title',
		array(
			'default'           => $iflynepal_band_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_band_' . $iflynepal_band . '_title',
		array(
			/* translators: %d: card number. */
			'label'       => sprintf( __( 'Card %d title', 'iflynepal' ), $iflynepal_band ),
			'description' => __( 'Emptying this removes the card.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => $iflynepal_band_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_band_' . $iflynepal_band . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_country_band_' . $iflynepal_band . '_image',
			array(
				'label'       => __( 'Image', 'iflynepal' ),
				'description' => __( 'Portrait or square, at least 850px wide. Its alt text is taken from the media library.', 'iflynepal' ),
				'section'     => 'iflynepal_about_country',
				'priority'    => $iflynepal_band_priority + 1,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ----------------------------------------------------------- history */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_history_heading',
		array(
			'label'    => __( 'History', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 300,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'history' );

$wp_customize->add_setting(
	'iflynepal_country_history_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_history_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 301,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_history_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_history_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 302,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_history_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_history_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 303,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_history_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_history_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 304,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_history_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_history_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 304 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

/* ----------------------------------------------------------- climate */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_climate_heading',
		array(
			'label'    => __( 'Climate', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 400,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'climate' );

$wp_customize->add_setting(
	'iflynepal_country_climate_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_climate_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 401,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_climate_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_climate_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 402,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_climate_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_climate_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 403,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_climate_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_climate_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 404,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_climate_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_climate_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 404 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

$wp_customize->add_setting(
	'iflynepal_country_bring_title',
	array(
		'default'           => IFLYNEPAL_COUNTRY_BRING_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_bring_title',
	array(
		'label'       => __( 'Packing heading', 'iflynepal' ),
		'description' => __( 'The centred heading over the two packing lists.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 420,
		'type'        => 'textarea',
	)
);

$iflynepal_bring_defaults = iflynepal_country_bring_defaults();

for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_bring_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_bring_defaults[ $iflynepal_paragraph ] ) ? $iflynepal_bring_defaults[ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_bring_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Packing paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 420 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

/* ---------------------------------------------------------- politics */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_politics_heading',
		array(
			'label'    => __( 'Politics', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 500,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'politics' );

$wp_customize->add_setting(
	'iflynepal_country_politics_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_politics_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 501,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_politics_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_politics_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 502,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_politics_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_politics_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 503,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_politics_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_politics_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 504,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_politics_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_politics_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 504 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

/* --------------------------------------------------- flora and fauna */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_flora_heading',
		array(
			'label'    => __( 'Flora and Fauna', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 600,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'flora' );

$wp_customize->add_setting(
	'iflynepal_country_flora_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_flora_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 601,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_flora_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_flora_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 602,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_flora_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_flora_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 603,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_flora_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_flora_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 604,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_flora_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_flora_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 604 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_regions_heading',
		array(
			'label'    => __( 'Flora and fauna — regions', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 620,
			'settings' => array(),
		)
	)
);

/*
 * All row slots are registered here; the Customizer's control script hides the
 * empty ones behind an "Add region" button.
 */
for ( $iflynepal_region = 1; $iflynepal_region <= IFLYNEPAL_COUNTRY_REGION_MAX; $iflynepal_region++ ) {
	$iflynepal_region_default  = iflynepal_country_region_default( $iflynepal_region );
	$iflynepal_region_priority = 621 + ( ( $iflynepal_region - 1 ) * 4 );

	$wp_customize->add_setting(
		'iflynepal_country_region_' . $iflynepal_region . '_number',
		array(
			'default'           => $iflynepal_region_default['number'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_region_' . $iflynepal_region . '_number',
		array(
			/* translators: %d: row number. */
			'label'       => sprintf( __( 'Region %d number', 'iflynepal' ), $iflynepal_region ),
			'description' => __( 'The large numeral on the card, such as 01.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => $iflynepal_region_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_region_' . $iflynepal_region . '_title',
		array(
			'default'           => $iflynepal_region_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_region_' . $iflynepal_region . '_title',
		array(
			'label'       => __( 'Title', 'iflynepal' ),
			'description' => __( 'Emptying this removes the region.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => $iflynepal_region_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_region_' . $iflynepal_region . '_description',
		array(
			'default'           => $iflynepal_region_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_region_' . $iflynepal_region . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => $iflynepal_region_priority + 2,
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_region_' . $iflynepal_region . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_country_region_' . $iflynepal_region . '_image',
			array(
				'label'       => __( 'Image', 'iflynepal' ),
				'description' => __( 'Landscape, at least 1200px wide. Its alt text is taken from the media library.', 'iflynepal' ),
				'section'     => 'iflynepal_about_country',
				'priority'    => $iflynepal_region_priority + 3,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ----------------------------------------------------------- economy */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_economy_heading',
		array(
			'label'    => __( 'Economy', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 700,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'economy' );

$wp_customize->add_setting(
	'iflynepal_country_economy_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_economy_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 701,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_economy_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_economy_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 702,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_economy_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_economy_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 703,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_economy_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_economy_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 704,
			'mime_type'   => 'image',
		)
	)
);

/*
 * All paragraph slots are registered here; the Customizer's control script
 * hides the empty ones behind an "Add paragraph" button.
 */
for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_economy_paragraph_' . $iflynepal_paragraph,
		array(
			'default'           => isset( $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] ) ? $iflynepal_chapter['paragraphs'][ $iflynepal_paragraph ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_economy_paragraph_' . $iflynepal_paragraph,
		array(
			/* translators: %d: paragraph number. */
			'label'       => sprintf( __( 'Paragraph %d', 'iflynepal' ), $iflynepal_paragraph ),
			'description' => __( 'Emptying this removes the paragraph.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 704 + $iflynepal_paragraph,
			'type'        => 'textarea',
		)
	);
}

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_sectors_heading',
		array(
			'label'    => __( 'Economy — sectors', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 720,
			'settings' => array(),
		)
	)
);

$iflynepal_sector_choices = array();

foreach ( iflynepal_country_sector_icons() as $iflynepal_slug => $iflynepal_icon ) {
	$iflynepal_sector_choices[ $iflynepal_slug ] = $iflynepal_icon['label'];
}

/*
 * All sector slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add sector" button.
 */
for ( $iflynepal_sector = 1; $iflynepal_sector <= IFLYNEPAL_COUNTRY_SECTOR_MAX; $iflynepal_sector++ ) {
	$iflynepal_sector_default  = iflynepal_country_sector_default( $iflynepal_sector );
	$iflynepal_sector_priority = 721 + ( ( $iflynepal_sector - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_country_sector_' . $iflynepal_sector . '_title',
		array(
			'default'           => $iflynepal_sector_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_sector_' . $iflynepal_sector . '_title',
		array(
			/* translators: %d: sector number. */
			'label'       => sprintf( __( 'Sector %d title', 'iflynepal' ), $iflynepal_sector ),
			'description' => __( 'Emptying this removes the sector.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => $iflynepal_sector_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_sector_' . $iflynepal_sector . '_description',
		array(
			'default'           => $iflynepal_sector_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_sector_' . $iflynepal_sector . '_description',
		array(
			'label'    => __( 'Description', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => $iflynepal_sector_priority + 1,
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_country_sector_' . $iflynepal_sector . '_icon',
		array(
			'default'           => $iflynepal_sector_default['icon'],
			'sanitize_callback' => 'iflynepal_sanitize_country_sector_icon',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_sector_' . $iflynepal_sector . '_icon',
		array(
			'label'    => __( 'Icon', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => $iflynepal_sector_priority + 2,
			'type'     => 'select',
			'choices'  => $iflynepal_sector_choices,
		)
	);
}

/* ------------------------------------------------------------ safety */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_safety_heading',
		array(
			'label'    => __( 'Safety', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 800,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter = iflynepal_country_chapter( 'safety' );

$wp_customize->add_setting(
	'iflynepal_country_safety_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_safety_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 801,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_safety_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_safety_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 802,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_safety_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_safety_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 803,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_safety_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_safety_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 804,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_safety_heading',
		array(
			'label'    => __( 'Safety — points', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 820,
			'settings' => array(),
		)
	)
);

$iflynepal_safety_defaults = iflynepal_country_safety_defaults();

/*
 * All point slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add point" button.
 */
for ( $iflynepal_point = 1; $iflynepal_point <= IFLYNEPAL_COUNTRY_SAFETY_MAX; $iflynepal_point++ ) {
	$wp_customize->add_setting(
		'iflynepal_country_safety_' . $iflynepal_point,
		array(
			'default'           => isset( $iflynepal_safety_defaults[ $iflynepal_point ] ) ? $iflynepal_safety_defaults[ $iflynepal_point ] : '',
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_country_safety_' . $iflynepal_point,
		array(
			/* translators: %d: point number. */
			'label'       => sprintf( __( 'Point %d', 'iflynepal' ), $iflynepal_point ),
			'description' => __( 'Emptying this removes the point.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 820 + $iflynepal_point,
			'type'        => 'textarea',
		)
	);
}

/* -------------------------------------------- visa, permits and fees */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_country_visa_heading',
		array(
			'label'    => __( 'Visa, Permits and Fees', 'iflynepal' ),
			'section'  => 'iflynepal_about_country',
			'priority' => 900,
			'settings' => array(),
		)
	)
);

$iflynepal_chapter         = iflynepal_country_chapter( 'visa' );
$iflynepal_permit_defaults = iflynepal_country_permit_defaults();

$wp_customize->add_setting(
	'iflynepal_country_visa_label',
	array(
		'default'           => $iflynepal_chapter['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_visa_label',
	array(
		'label'       => __( 'Index bar label', 'iflynepal' ),
		'description' => __( 'The short name this chapter goes by in the sticky index bar at the top of the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 901,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_visa_eyebrow',
	array(
		'default'           => $iflynepal_chapter['eyebrow'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_visa_eyebrow',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The small line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 902,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_visa_title',
	array(
		'default'           => $iflynepal_chapter['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_visa_title',
	array(
		'label'       => __( 'Title', 'iflynepal' ),
		'description' => __( 'Emptying this hides the whole chapter and drops it from the index bar.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 903,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_visa_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_country_visa_image',
		array(
			'label'       => __( 'Background image', 'iflynepal' ),
			'description' => __( 'The wide banner under the heading. Landscape, at least 1600px. Leaving it unset shows no banner.', 'iflynepal' ),
			'section'     => 'iflynepal_about_country',
			'priority'    => 904,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_country_permit_title',
	array(
		'default'           => $iflynepal_permit_defaults['title'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_permit_title',
	array(
		'label'       => __( 'Permit note heading', 'iflynepal' ),
		'description' => __( 'The bordered note that closes the page.', 'iflynepal' ),
		'section'     => 'iflynepal_about_country',
		'priority'    => 920,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_country_permit_text',
	array(
		'default'           => $iflynepal_permit_defaults['text'],
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_country_permit_text',
	array(
		'label'    => __( 'Permit note text', 'iflynepal' ),
		'section'  => 'iflynepal_about_country',
		'priority' => 921,
		'type'     => 'textarea',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_hero_title',
		array(
			'selector'        => '#iflynepal-country-hero-title',
			'settings'        => array( 'iflynepal_country_hero_title' ),
			'render_callback' => 'iflynepal_render_country_hero_title',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_hero_lead',
		array(
			'selector'        => '#iflynepal-country-hero-lead',
			'settings'        => array( 'iflynepal_country_hero_lead' ),
			'render_callback' => 'iflynepal_render_country_hero_lead',
		)
	);

	/*
	 * The index bar is rebuilt from every chapter's label and heading at once:
	 * a label changes a link's text, and emptying a heading removes the link
	 * altogether, so both feed the same fragment.
	 */
	$iflynepal_index_settings = array();

	foreach ( array_keys( iflynepal_country_chapters() ) as $iflynepal_slug ) {
		$iflynepal_index_settings[] = 'iflynepal_country_' . $iflynepal_slug . '_label';
		$iflynepal_index_settings[] = 'iflynepal_country_' . $iflynepal_slug . '_title';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_index',
		array(
			'selector'        => '#iflynepal-country-index',
			'settings'        => $iflynepal_index_settings,
			'render_callback' => 'iflynepal_render_country_index',
		)
	);

	/*
	 * A chapter's kicker and heading are their own fragments; its paragraphs
	 * are one fragment for the whole block, because removing a paragraph
	 * changes how many there are and a per-paragraph partial would leave an
	 * empty block standing where it had been.
	 *
	 * The callbacks take a slug, which a partial cannot pass, so each is
	 * wrapped in a closure over the chapter it belongs to.
	 */
	foreach ( array_keys( iflynepal_country_chapters() ) as $iflynepal_slug ) {
		foreach ( array( 'eyebrow', 'title' ) as $iflynepal_field ) {
			$wp_customize->selective_refresh->add_partial(
				'iflynepal_country_' . $iflynepal_slug . '_' . $iflynepal_field,
				array(
					'selector'        => '#iflynepal-country-' . $iflynepal_slug . '-' . $iflynepal_field,
					'settings'        => array( 'iflynepal_country_' . $iflynepal_slug . '_' . $iflynepal_field ),
					'render_callback' => function () use ( $iflynepal_slug, $iflynepal_field ) {
						$callback = 'iflynepal_render_country_chapter_' . $iflynepal_field;

						return $callback( $iflynepal_slug );
					},
				)
			);
		}

		if ( ! iflynepal_country_chapter_has_prose( $iflynepal_slug ) ) {
			continue;
		}

		$iflynepal_prose_settings = array();

		for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
			$iflynepal_prose_settings[] = 'iflynepal_country_' . $iflynepal_slug . '_paragraph_' . $iflynepal_paragraph;
		}

		$wp_customize->selective_refresh->add_partial(
			'iflynepal_country_' . $iflynepal_slug . '_prose',
			array(
				'selector'        => '#iflynepal-country-' . $iflynepal_slug . '-prose',
				'settings'        => $iflynepal_prose_settings,
				'render_callback' => function () use ( $iflynepal_slug ) {
					return iflynepal_render_country_chapter_prose( $iflynepal_slug );
				},
			)
		);
	}

	foreach ( array( 'label', 'title', 'text' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_country_note_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-country-note-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_country_note_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_country_note_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_band_settings = array();

	for ( $iflynepal_band = 1; $iflynepal_band <= IFLYNEPAL_COUNTRY_BAND_MAX; $iflynepal_band++ ) {
		$iflynepal_band_settings[] = 'iflynepal_country_band_' . $iflynepal_band . '_title';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_bands',
		array(
			'selector'        => '#iflynepal-country-bands',
			'settings'        => $iflynepal_band_settings,
			'render_callback' => 'iflynepal_render_country_bands',
		)
	);

	$iflynepal_region_settings = array();

	for ( $iflynepal_region = 1; $iflynepal_region <= IFLYNEPAL_COUNTRY_REGION_MAX; $iflynepal_region++ ) {
		$iflynepal_region_settings[] = 'iflynepal_country_region_' . $iflynepal_region . '_number';
		$iflynepal_region_settings[] = 'iflynepal_country_region_' . $iflynepal_region . '_title';
		$iflynepal_region_settings[] = 'iflynepal_country_region_' . $iflynepal_region . '_description';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_regions',
		array(
			'selector'        => '#iflynepal-country-regions',
			'settings'        => $iflynepal_region_settings,
			'render_callback' => 'iflynepal_render_country_regions',
		)
	);

	$iflynepal_sector_settings = array();

	for ( $iflynepal_sector = 1; $iflynepal_sector <= IFLYNEPAL_COUNTRY_SECTOR_MAX; $iflynepal_sector++ ) {
		$iflynepal_sector_settings[] = 'iflynepal_country_sector_' . $iflynepal_sector . '_title';
		$iflynepal_sector_settings[] = 'iflynepal_country_sector_' . $iflynepal_sector . '_description';
		$iflynepal_sector_settings[] = 'iflynepal_country_sector_' . $iflynepal_sector . '_icon';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_sectors',
		array(
			'selector'        => '#iflynepal-country-sectors',
			'settings'        => $iflynepal_sector_settings,
			'render_callback' => 'iflynepal_render_country_sectors',
		)
	);

	$iflynepal_safety_settings = array();

	for ( $iflynepal_point = 1; $iflynepal_point <= IFLYNEPAL_COUNTRY_SAFETY_MAX; $iflynepal_point++ ) {
		$iflynepal_safety_settings[] = 'iflynepal_country_safety_' . $iflynepal_point;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_safety',
		array(
			'selector'        => '#iflynepal-country-safety',
			'settings'        => $iflynepal_safety_settings,
			'render_callback' => 'iflynepal_render_country_safety',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_bring_title',
		array(
			'selector'        => '#iflynepal-country-bring-title',
			'settings'        => array( 'iflynepal_country_bring_title' ),
			'render_callback' => 'iflynepal_render_country_bring_title',
		)
	);

	$iflynepal_bring_settings = array();

	for ( $iflynepal_paragraph = 1; $iflynepal_paragraph <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $iflynepal_paragraph++ ) {
		$iflynepal_bring_settings[] = 'iflynepal_country_bring_paragraph_' . $iflynepal_paragraph;
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_country_bring_prose',
		array(
			'selector'        => '#iflynepal-country-bring-prose',
			'settings'        => $iflynepal_bring_settings,
			'render_callback' => 'iflynepal_render_country_bring_prose',
		)
	);

	foreach ( array( 'title', 'text' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_country_permit_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-country-permit-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_country_permit_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_country_permit_' . $iflynepal_field,
			)
		);
	}
}
