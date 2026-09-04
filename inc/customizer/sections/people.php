<?php
/**
 * Homepage > People section.
 *
 * One section holds the whole thing: the heading, the contact pill beside it,
 * then the rail of people. The Customizer has no nested panels and no native
 * way to group controls, so the groups are separated by
 * IFly_Nepal_Customize_Heading_Control rather than by being split into sections
 * of their own.
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
	'iflynepal_people',
	array(
		'title'       => __( 'People Behind the Journey', 'iflynepal' ),
		'description' => __( 'The heading, the contact pill beside it, and the people in the rail below.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 40,
	)
);

/* ------------------------------------------------------------------ intro */

$wp_customize->add_setting(
	'iflynepal_people_kicker',
	array(
		'default'           => IFLYNEPAL_PEOPLE_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The small capitalised line above the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 10,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_people_title',
	array(
		'default'           => IFLYNEPAL_PEOPLE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_people_lead',
	array(
		'default'           => IFLYNEPAL_PEOPLE_LEAD_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_lead',
	array(
		'label'       => __( 'Standfirst', 'iflynepal' ),
		'description' => __( 'The sentence under the heading.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 30,
		'type'        => 'textarea',
	)
);

/* ----------------------------------------------------------- contact pill */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_people_cta_heading',
		array(
			'label'    => __( 'Contact pill', 'iflynepal' ),
			'section'  => 'iflynepal_people',
			'priority' => 40,
			'settings' => array(),
		)
	)
);

$iflynepal_cta_defaults = iflynepal_people_cta_defaults();

$wp_customize->add_setting(
	'iflynepal_people_cta_label',
	array(
		'default'           => $iflynepal_cta_defaults['label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_cta_label',
	array(
		'label'       => __( 'Label', 'iflynepal' ),
		'description' => __( 'Emptying this removes the pill.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 41,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_people_cta_note',
	array(
		'default'           => $iflynepal_cta_defaults['note'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_cta_note',
	array(
		'label'       => __( 'Note', 'iflynepal' ),
		'description' => __( 'The smaller grey line under the label — the office, and how quickly it answers.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 42,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'iflynepal_people_cta_url',
	array(
		'default'           => $iflynepal_cta_defaults['url'],
		'sanitize_callback' => 'iflynepal_sanitize_link',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_people_cta_url',
	array(
		'label'       => __( 'Link', 'iflynepal' ),
		'description' => __( 'A full URL, or an on-page anchor such as #trust.', 'iflynepal' ),
		'section'     => 'iflynepal_people',
		'priority'    => 43,
		'type'        => 'text',
	)
);

/* ------------------------------------------------------------------ cards */

$wp_customize->add_control(
	new IFly_Nepal_Customize_Heading_Control(
		$wp_customize,
		'iflynepal_people_cards_heading',
		array(
			'label'    => __( 'People', 'iflynepal' ),
			'section'  => 'iflynepal_people',
			'priority' => 50,
			'settings' => array(),
		)
	)
);

/*
 * All card slots are registered here; the Customizer's control script hides the
 * empty ones behind an "Add person" button.
 */
for ( $iflynepal_card = 1; $iflynepal_card <= IFLYNEPAL_PEOPLE_CARD_MAX; $iflynepal_card++ ) {
	$iflynepal_prefix  = 'iflynepal_people_card_' . $iflynepal_card . '_';
	$iflynepal_default = iflynepal_people_card_default( $iflynepal_card );

	// Four fields apiece, so each card gets a 10-wide band of its own.
	$iflynepal_priority = 50 + ( $iflynepal_card * 10 );

	$wp_customize->add_setting(
		$iflynepal_prefix . 'title',
		array(
			'default'           => $iflynepal_default['title'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'title',
		array(
			/* translators: %d: card number. */
			'label'       => sprintf( __( 'Person %d — title', 'iflynepal' ), $iflynepal_card ),
			'description' => __( 'The role shown on the pill over the photograph.', 'iflynepal' ),
			'section'     => 'iflynepal_people',
			'priority'    => $iflynepal_priority + 1,
			'type'        => 'text',
		)
	);

	/*
	 * The name decides whether the card exists at all, so it refreshes the
	 * preview rather than swapping one element: a partial would leave an empty
	 * card standing where the person had been removed.
	 */
	$wp_customize->add_setting(
		$iflynepal_prefix . 'name',
		array(
			'default'           => $iflynepal_default['name'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'name',
		array(
			/* translators: %d: card number. */
			'label'       => sprintf( __( 'Person %d — name', 'iflynepal' ), $iflynepal_card ),
			'description' => __( 'Emptying this removes the card.', 'iflynepal' ),
			'section'     => 'iflynepal_people',
			'priority'    => $iflynepal_priority + 2,
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'country',
		array(
			'default'           => $iflynepal_default['country'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'country',
		array(
			/* translators: %d: card number. */
			'label'    => sprintf( __( 'Person %d — country', 'iflynepal' ), $iflynepal_card ),
			'section'  => 'iflynepal_people',
			'priority' => $iflynepal_priority + 3,
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			$iflynepal_prefix . 'image',
			array(
				/* translators: %d: card number. */
				'label'       => sprintf( __( 'Person %d — card background image', 'iflynepal' ), $iflynepal_card ),
				'description' => __( 'A portrait photograph, at least 640px wide. The card crops it to a tall frame, so leave room around the face. Until one is uploaded the card shows a neutral avatar.', 'iflynepal' ),
				'section'     => 'iflynepal_people',
				'priority'    => $iflynepal_priority + 4,
				'mime_type'   => 'image',
			)
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	foreach ( array( 'kicker', 'title', 'lead' ) as $iflynepal_field ) {
		$wp_customize->selective_refresh->add_partial(
			'iflynepal_people_' . $iflynepal_field,
			array(
				'selector'        => '#iflynepal-people-' . $iflynepal_field,
				'settings'        => array( 'iflynepal_people_' . $iflynepal_field ),
				'render_callback' => 'iflynepal_render_people_' . $iflynepal_field,
			)
		);
	}

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_people_cta',
		array(
			'selector'        => '#iflynepal-people-cta',
			'settings'        => array(
				'iflynepal_people_cta_label',
				'iflynepal_people_cta_note',
				'iflynepal_people_cta_url',
			),
			'render_callback' => 'iflynepal_render_people_cta',
		)
	);

	for ( $iflynepal_card = 1; $iflynepal_card <= IFLYNEPAL_PEOPLE_CARD_MAX; $iflynepal_card++ ) {
		foreach ( array( 'title', 'country' ) as $iflynepal_field ) {
			$wp_customize->selective_refresh->add_partial(
				'iflynepal_people_card_' . $iflynepal_card . '_' . $iflynepal_field,
				array(
					'selector'        => '#iflynepal-people-card-' . $iflynepal_card . '-' . $iflynepal_field,
					'settings'        => array( 'iflynepal_people_card_' . $iflynepal_card . '_' . $iflynepal_field ),
					'render_callback' => function () use ( $iflynepal_card, $iflynepal_field ) {
						$callback = 'iflynepal_render_people_card_' . $iflynepal_field;

						return $callback( $iflynepal_card );
					},
				)
			);
		}
	}
}
