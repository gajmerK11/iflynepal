<?php
/**
 * About > Team section.
 *
 * The whole Team page template in one section, in page order: the hero and its
 * portrait cluster, the Global Representatives roster, then the Executive Team
 * roster.
 *
 * The Customizer has no nested panels and no native way to group controls, so
 * the three parts are separated by IFly_Nepal_Customize_Heading_Control rather
 * than being split into sections of their own — the same arrangement About >
 * Company and About > Nepal use.
 *
 * Both rosters are add/remove lists: every slot is registered here and
 * assets/js/team/repeaters.js hides the unused ones behind an "Add" button.
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
	'iflynepal_team',
	array(
		'title'       => __( 'Team', 'iflynepal' ),
		'description' => __( 'Everything on the Team page template, in the order it appears. Emptying a roster\'s heading hides that whole roster; emptying a person\'s name removes their card.', 'iflynepal' ),
		'panel'       => 'iflynepal_about',
		'priority'    => 30,
	)
);

/* ------------------------------------------------------------------- hero */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_team_hero_heading',
		array(
			'label'    => __( 'Hero', 'iflynepal' ),
			'section'  => 'iflynepal_team',
			'priority' => 10,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_kicker',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the headline ("Our team").', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 11,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_title',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_title',
	array(
		'label'       => __( 'Headline, first line', 'iflynepal' ),
		'description' => __( 'The plain line of the headline ("The people behind").', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 12,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_brand',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_BRAND_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_brand',
	array(
		'label'       => __( 'Headline, company line', 'iflynepal' ),
		'description' => __( 'The second line, set in the gold serif beside the logo mark ("iFly Nepal"). The mark is the logo from Site Identity. Emptying this removes the line and the mark.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 13,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_lead',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The paragraph under the headline. Accepts &lt;br&gt; to control where it wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 14,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_image',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'iflynepal_team_hero_image',
		array(
			'label'       => __( 'Hero background image', 'iflynepal' ),
			'description' => __( 'Wide landscape, at least 1900px. Sits under a dark scrim, so a busy frame still reads.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => 15,
			'mime_type'   => 'image',
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_script',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_SCRIPT_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_script',
	array(
		'label'       => __( 'Handwritten note', 'iflynepal' ),
		'description' => __( 'The line in the handwritten face under the portraits ("rooted in Nepal"). Emptying it removes the note.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 16,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_hero_scroll_label',
	array(
		'default'           => IFLYNEPAL_TEAM_HERO_SCROLL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	'iflynepal_team_hero_scroll_label',
	array(
		'label'       => __( 'Scroll button label', 'iflynepal' ),
		'description' => __( 'The pill at the foot of the hero, which drops to the first roster ("Meet everyone"). Emptying it removes the button.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 17,
		'type'        => 'text',
	)
);

/* -------------------------------------------------------- hero portraits */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_team_portraits_heading',
		array(
			'label'       => __( 'Hero — portraits', 'iflynepal' ),
			'description' => __( 'The three frames beside the headline. Not a list: each has its own shape and place in the arrangement, so there is no fourth. Leaving one unset drops that frame.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => 20,
			'settings'    => array(),
		)
	)
);

for ( $iflynepal_portrait = 1; $iflynepal_portrait <= IFLYNEPAL_TEAM_PORTRAIT_MAX; $iflynepal_portrait++ ) {
	$wp_customize->add_setting(
		'iflynepal_team_portrait_' . $iflynepal_portrait . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_team_portrait_' . $iflynepal_portrait . '_image',
			array(
				/* translators: %d: portrait number. */
				'label'       => sprintf( __( 'Portrait %d', 'iflynepal' ), $iflynepal_portrait ),
				'description' => __( 'Portrait crop, at least 600px wide. Its alt text is taken from the media library, so give it one there.', 'iflynepal' ),
				'section'     => 'iflynepal_team',
				'priority'    => 20 + $iflynepal_portrait,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ------------------------------------------------- global representatives */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_team_reps_heading',
		array(
			'label'    => __( 'Global Representatives', 'iflynepal' ),
			'section'  => 'iflynepal_team',
			'priority' => 100,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_team_reps_kicker',
	array(
		'default'           => IFLYNEPAL_TEAM_REPS_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_reps_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading ("Across the world").', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 101,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_reps_title',
	array(
		'default'           => IFLYNEPAL_TEAM_REPS_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_reps_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;span class="underline"&gt;word&lt;/span&gt; to draw the inked mark under it. Emptying this hides the whole roster.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 102,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_reps_lead',
	array(
		'default'           => IFLYNEPAL_TEAM_REPS_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_reps_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The paragraph under the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 103,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_reps_label',
	array(
		'default'           => IFLYNEPAL_TEAM_REPS_LABEL_DEFAULT,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_reps_label',
	array(
		'label'       => __( 'Card label', 'iflynepal' ),
		'description' => __( 'The line above every name in this roster ("Global representative"). One setting for all of them, since the design gives them the same line. Emptying it leaves the line off every card.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 104,
		'type'        => 'text',
	)
);

/*
 * All card slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add representative" button.
 */
for ( $iflynepal_rep = 1; $iflynepal_rep <= IFLYNEPAL_TEAM_REPRESENTATIVE_MAX; $iflynepal_rep++ ) {
	$iflynepal_rep_default  = iflynepal_team_representative_default( $iflynepal_rep );
	$iflynepal_rep_priority = 110 + ( ( $iflynepal_rep - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_team_representative_' . $iflynepal_rep . '_name',
		array(
			'default'           => $iflynepal_rep_default['name'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_team_representative_' . $iflynepal_rep . '_name',
		array(
			/* translators: %d: representative number. */
			'label'       => sprintf( __( 'Representative %d name', 'iflynepal' ), $iflynepal_rep ),
			'description' => __( 'Emptying this removes the card.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => $iflynepal_rep_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_team_representative_' . $iflynepal_rep . '_country',
		array(
			'default'           => $iflynepal_rep_default['country'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_team_representative_' . $iflynepal_rep . '_country',
		array(
			'label'       => __( 'Country', 'iflynepal' ),
			'description' => __( 'The line under the name.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => $iflynepal_rep_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_team_representative_' . $iflynepal_rep . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_team_representative_' . $iflynepal_rep . '_image',
			array(
				'label'       => __( 'Photograph', 'iflynepal' ),
				'description' => __( 'Portrait crop, at least 600px wide. Without one the card shows its name over an empty frame.', 'iflynepal' ),
				'section'     => 'iflynepal_team',
				'priority'    => $iflynepal_rep_priority + 2,
				'mime_type'   => 'image',
			)
		)
	);
}

/* ------------------------------------------------------- executive team */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_team_executive_heading',
		array(
			'label'    => __( 'Executive Team', 'iflynepal' ),
			'section'  => 'iflynepal_team',
			'priority' => 500,
			'settings' => array(),
		)
	)
);

$wp_customize->add_setting(
	'iflynepal_team_executive_title',
	array(
		'default'           => IFLYNEPAL_TEAM_EXECUTIVE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_executive_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Wrap a word in &lt;span class="accent"&gt;word&lt;/span&gt; to set it in the serif italic. Emptying this hides the whole roster.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 501,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_team_executive_lead',
	array(
		'default'           => IFLYNEPAL_TEAM_EXECUTIVE_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_team_executive_lead',
	array(
		'label'       => __( 'Sub-title', 'iflynepal' ),
		'description' => __( 'The paragraph beside the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_team',
		'priority'    => 502,
		'type'        => 'textarea',
	)
);

/*
 * All card slots are registered here; the Customizer's control script hides
 * the empty ones behind an "Add person" button.
 */
for ( $iflynepal_member = 1; $iflynepal_member <= IFLYNEPAL_TEAM_MEMBER_MAX; $iflynepal_member++ ) {
	$iflynepal_member_default  = iflynepal_team_member_default( $iflynepal_member );
	$iflynepal_member_priority = 510 + ( ( $iflynepal_member - 1 ) * 3 );

	$wp_customize->add_setting(
		'iflynepal_team_member_' . $iflynepal_member . '_name',
		array(
			'default'           => $iflynepal_member_default['name'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_team_member_' . $iflynepal_member . '_name',
		array(
			/* translators: %d: team member number. */
			'label'       => sprintf( __( 'Person %d name', 'iflynepal' ), $iflynepal_member ),
			'description' => __( 'Emptying this removes the card.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => $iflynepal_member_priority,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_team_member_' . $iflynepal_member . '_role',
		array(
			'default'           => $iflynepal_member_default['role'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'iflynepal_team_member_' . $iflynepal_member . '_role',
		array(
			'label'       => __( 'Role', 'iflynepal' ),
			'description' => __( 'Shown on the pill over the photograph and again under the name.', 'iflynepal' ),
			'section'     => 'iflynepal_team',
			'priority'    => $iflynepal_member_priority + 1,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'iflynepal_team_member_' . $iflynepal_member . '_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'iflynepal_team_member_' . $iflynepal_member . '_image',
			array(
				'label'       => __( 'Photograph', 'iflynepal' ),
				'description' => __( 'Portrait crop, at least 600px wide. Without one the card shows its name over an empty frame.', 'iflynepal' ),
				'section'     => 'iflynepal_team',
				'priority'    => $iflynepal_member_priority + 2,
				'mime_type'   => 'image',
			)
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_hero_kicker',
		array(
			'selector'        => '#iflynepal-team-hero-kicker',
			'settings'        => array( 'iflynepal_team_hero_kicker' ),
			'render_callback' => 'iflynepal_render_team_hero_kicker',
		)
	);

	/*
	 * The headline's two lines are one fragment: the logo mark belongs to the
	 * second, so a partial on that line alone would leave the mark standing
	 * where the line had been.
	 */
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_hero_title',
		array(
			'selector'        => '#iflynepal-team-hero-title',
			'settings'        => array( 'iflynepal_team_hero_title', 'iflynepal_team_hero_brand' ),
			'render_callback' => 'iflynepal_render_team_hero_title',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_hero_lead',
		array(
			'selector'        => '#iflynepal-team-hero-lead',
			'settings'        => array( 'iflynepal_team_hero_lead' ),
			'render_callback' => 'iflynepal_render_team_hero_lead',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_hero_script',
		array(
			'selector'        => '#iflynepal-team-portraits',
			'settings'        => array( 'iflynepal_team_hero_script' ),
			'render_callback' => 'iflynepal_render_team_portraits',
		)
	);

	foreach ( array( 'kicker', 'title', 'lead' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_team_reps_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-team-reps-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_team_reps_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_team_reps_' . $iflynepal_field,
			)
		);
	}

	/*
	 * A roster is one fragment rather than one per card: removing a card
	 * changes how many are left, and the grid is laid out off that count. The
	 * shared card label feeds the same fragment, since it prints on every card.
	 */
	$iflynepal_rep_settings = array( 'iflynepal_team_reps_label' );

	for ( $iflynepal_rep = 1; $iflynepal_rep <= IFLYNEPAL_TEAM_REPRESENTATIVE_MAX; $iflynepal_rep++ ) {
		$iflynepal_rep_settings[] = 'iflynepal_team_representative_' . $iflynepal_rep . '_name';
		$iflynepal_rep_settings[] = 'iflynepal_team_representative_' . $iflynepal_rep . '_country';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_representatives',
		array(
			'selector'        => '#iflynepal-team-representatives',
			'settings'        => $iflynepal_rep_settings,
			'render_callback' => 'iflynepal_render_team_representatives',
		)
	);

	foreach ( array( 'title', 'lead' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_team_executive_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-team-executive-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_team_executive_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_team_executive_' . $iflynepal_field,
			)
		);
	}

	$iflynepal_member_settings = array();

	for ( $iflynepal_member = 1; $iflynepal_member <= IFLYNEPAL_TEAM_MEMBER_MAX; $iflynepal_member++ ) {
		$iflynepal_member_settings[] = 'iflynepal_team_member_' . $iflynepal_member . '_name';
		$iflynepal_member_settings[] = 'iflynepal_team_member_' . $iflynepal_member . '_role';
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_team_members',
		array(
			'selector'        => '#iflynepal-team-members',
			'settings'        => $iflynepal_member_settings,
			'render_callback' => 'iflynepal_render_team_members',
		)
	);
}
