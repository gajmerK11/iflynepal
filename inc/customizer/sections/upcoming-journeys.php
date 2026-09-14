<?php
/**
 * Homepage > Upcoming Journeys section.
 *
 * Three fields, all copy: the eyebrow, the heading and the description. The
 * status line beneath the chips is not one of them — it is computed from the
 * cards themselves (iflynepal_upcoming_status_text()), the same count the
 * script recalculates on every chip press, so there is nothing here that can
 * fall out of step with what the rail actually shows. The rail of cards is
 * not edited here either — it is built from whichever packages the
 * ifn-booking plugin's package editor has ticked "Display on homepage" on,
 * each carrying its own "When available?" month. See
 * inc/customizer/callbacks/upcoming-journeys.php.
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
	'iflynepal_upcoming_journeys',
	array(
		'title'       => __( 'Upcoming Journeys', 'iflynepal' ),
		'description' => __( 'The copy around the rail of packages marked "Display on homepage" in the package editor. The cards themselves, and the month chips above them, are not edited here — they follow directly from which packages are ticked and what each is marked "When available?".', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 25,
	)
);

$wp_customize->add_setting(
	'iflynepal_upcoming_eyebrow',
	array(
		'default'           => IFLYNEPAL_UPCOMING_EYEBROW_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_upcoming_eyebrow',
	array(
		'label'    => __( 'Eyebrow', 'iflynepal' ),
		'section'  => 'iflynepal_upcoming_journeys',
		'priority' => 10,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_upcoming_heading',
	array(
		'default'           => IFLYNEPAL_UPCOMING_HEADING_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_upcoming_heading',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;em&gt; to give it the gold accent.', 'iflynepal' ),
		'section'     => 'iflynepal_upcoming_journeys',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_upcoming_description',
	array(
		'default'           => IFLYNEPAL_UPCOMING_DESCRIPTION_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_upcoming_description',
	array(
		'label'    => __( 'Description', 'iflynepal' ),
		'section'  => 'iflynepal_upcoming_journeys',
		'priority' => 30,
		'type'     => 'textarea',
	)
);

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_upcoming_eyebrow',
		array(
			'selector'        => '#iflynepal-upcoming-eyebrow',
			'settings'        => array( 'iflynepal_upcoming_eyebrow' ),
			'render_callback' => 'iflynepal_render_upcoming_eyebrow',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_upcoming_heading',
		array(
			'selector'        => '#iflynepal-upcoming-heading',
			'settings'        => array( 'iflynepal_upcoming_heading' ),
			'render_callback' => 'iflynepal_render_upcoming_heading',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_upcoming_description',
		array(
			'selector'        => '#iflynepal-upcoming-description',
			'settings'        => array( 'iflynepal_upcoming_description' ),
			'render_callback' => 'iflynepal_render_upcoming_description',
		)
	);
}
