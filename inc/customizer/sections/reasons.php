<?php
/**
 * Homepage > A Few Good Reasons section.
 *
 * Four fields, all copy: the heading, the description, and the handwritten
 * annotation's fixed opening text plus the words it cycles through after. The
 * card grid and its filter buttons are not edited here at all — they are
 * built from whichever packages the ifn-booking plugin's package editor has
 * ticked "Show in 'A few good reasons'" on, one filter button per package
 * type among them. See inc/customizer/callbacks/reasons.php.
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
	'iflynepal_reasons',
	array(
		'title'       => __( 'A Few Good Reasons', 'iflynepal' ),
		'description' => __( 'The heading, description and handwritten note above the curated card grid. The cards themselves, and the package-type buttons above them, are not edited here — they follow directly from which packages are ticked "Show in \'A few good reasons\'" in the package editor.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 27,
	)
);

$wp_customize->add_setting(
	'iflynepal_reasons_heading',
	array(
		'default'           => IFLYNEPAL_REASONS_HEADING_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_reasons_heading',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a phrase in &lt;span class="underline"&gt;…&lt;/span&gt; to draw the hand-inked underline under it. The mark strokes itself in as the heading is scrolled to.', 'iflynepal' ),
		'section'     => 'iflynepal_reasons',
		'priority'    => 10,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_reasons_description',
	array(
		'default'           => IFLYNEPAL_REASONS_DESCRIPTION_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_reasons_description',
	array(
		'label'    => __( 'Description', 'iflynepal' ),
		'section'  => 'iflynepal_reasons',
		'priority' => 20,
		'type'     => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_reasons_annotation_static',
	array(
		'default'           => IFLYNEPAL_REASONS_ANNOTATION_STATIC_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_reasons_annotation_static',
	array(
		'label'       => __( 'Handwritten note — fixed part', 'iflynepal' ),
		'description' => __( 'Typed once and left in place, e.g. "Featured ".', 'iflynepal' ),
		'section'     => 'iflynepal_reasons',
		'priority'    => 30,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_reasons_annotation_words',
	array(
		'default'           => IFLYNEPAL_REASONS_ANNOTATION_WORDS_DEFAULT,
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_reasons_annotation_words',
	array(
		'label'       => __( 'Handwritten note — cycling words', 'iflynepal' ),
		'description' => __( 'One word or phrase per line. Typed in after the fixed part, held, deleted, then the next line — forever.', 'iflynepal' ),
		'section'     => 'iflynepal_reasons',
		'priority'    => 40,
		'type'        => 'textarea',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_reasons_heading',
		array(
			'selector'        => '#iflynepal-reasons-heading',
			'settings'        => array( 'iflynepal_reasons_heading' ),
			'render_callback' => 'iflynepal_render_reasons_heading',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_reasons_description',
		array(
			'selector'        => '#iflynepal-reasons-description',
			'settings'        => array( 'iflynepal_reasons_description' ),
			'render_callback' => 'iflynepal_render_reasons_description',
		)
	);

	/*
	 * The annotation's two settings have no partials: the script that types
	 * them reads its data attributes once on load, so a selective-refresh
	 * swap would need the script re-run to take effect either way. A full
	 * refresh is what shows the change in the preview.
	 */
}
