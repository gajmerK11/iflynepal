<?php
/**
 * About > Company section: the Executive Team roster.
 *
 * The roster closes the About page template, so its controls sit at the foot of
 * the Company section, after What We Offer. They were the Team page's own
 * section until that template was removed; the setting IDs keep their
 * `iflynepal_team_*` names so content saved under them carries over untouched.
 *
 * The roster is an add/remove list: every slot is registered here and
 * assets/js/team/repeaters.js hides the unused ones behind an "Add" button.
 *
 * Required inside customize_register after about-company.php, so
 * $wp_customize is already in scope and the section exists.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @var WP_Customize_Manager $wp_customize Customizer manager.
 */

defined( 'ABSPATH' ) || exit;

/* ------------------------------------------------------- executive team */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_team_executive_heading',
		array(
			'label'    => __( 'Executive Team', 'iflynepal' ),
			'section'  => 'iflynepal_about_company',
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
		'section'     => 'iflynepal_about_company',
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
		'section'     => 'iflynepal_about_company',
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
			'section'     => 'iflynepal_about_company',
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
			'section'     => 'iflynepal_about_company',
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
				'section'     => 'iflynepal_about_company',
				'priority'    => $iflynepal_member_priority + 2,
				'mime_type'   => 'image',
			)
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
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
