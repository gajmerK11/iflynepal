<?php
/**
 * Homepage > Explore section.
 *
 * One section holds the whole thing: the heading above the gateway, then both
 * cards. The Customizer has no nested panels and no native way to group
 * controls, so the cards are separated by IFly_Nepal_Customize_Heading_Control
 * rather than by being split into sections of their own.
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
	'iflynepal_explore',
	array(
		'title'       => __( 'Explore', 'iflynepal' ),
		'description' => __( 'The heading above the gateway, and the two cards beneath it.', 'iflynepal' ),
		'panel'       => 'iflynepal_homepage',
		'priority'    => 20,
	)
);

/* ------------------------------------------------------------------ intro */

$wp_customize->add_setting(
	'iflynepal_explore_kicker',
	array(
		'default'           => IFLYNEPAL_EXPLORE_KICKER_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_explore_kicker',
	array(
		'label'       => __( 'Kicker', 'iflynepal' ),
		'description' => __( 'The handwritten line beside the arrow. Accepts &lt;br&gt; and &lt;span&gt;.', 'iflynepal' ),
		'section'     => 'iflynepal_explore',
		'priority'    => 10,
		'type'        => 'textarea',
	)
);

$wp_customize->add_setting(
	'iflynepal_explore_title',
	array(
		'default'           => IFLYNEPAL_EXPLORE_TITLE_DEFAULT,
		'sanitize_callback' => 'iflynepal_kses_text',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	'iflynepal_explore_title',
	array(
		'label'       => __( 'Heading', 'iflynepal' ),
		'description' => __( 'Accepts &lt;br&gt; to control where the line wraps, and &lt;span class="underline"&gt;word&lt;/span&gt; to draw the hand-inked underline under a word. The mark strokes itself in as the heading is scrolled to.', 'iflynepal' ),
		'section'     => 'iflynepal_explore',
		'priority'    => 20,
		'type'        => 'textarea',
	)
);

/* ------------------------------------------------------------------ cards */

$iflynepal_card_titles = array(
	1 => __( 'Card 1 — Explore Nepal', 'iflynepal' ),
	2 => __( 'Card 2 — Retreats in Nepal', 'iflynepal' ),
);

for ( $iflynepal_card = 1; $iflynepal_card <= IFLYNEPAL_EXPLORE_CARDS; $iflynepal_card++ ) {
	$iflynepal_prefix  = 'iflynepal_explore_card_' . $iflynepal_card . '_';
	$iflynepal_default = iflynepal_explore_card_default( $iflynepal_card );

	// Each card gets a 40-wide band, leaving room for its links to sit between.
	$iflynepal_priority = 30 + ( ( $iflynepal_card - 1 ) * 40 );

	$wp_customize->add_control(
		new IFly_Nepal_Customize_Heading_Control(
			$wp_customize,
			$iflynepal_prefix . 'heading',
			array(
				'label'    => isset( $iflynepal_card_titles[ $iflynepal_card ] ) ? $iflynepal_card_titles[ $iflynepal_card ] : sprintf(
					/* translators: %d: card number. */
					__( 'Card %d', 'iflynepal' ),
					$iflynepal_card
				),
				'section'  => 'iflynepal_explore',
				'priority' => $iflynepal_priority,
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'eyebrow',
		array(
			'default'           => $iflynepal_default['eyebrow'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'eyebrow',
		array(
			'label'    => __( 'Eyebrow', 'iflynepal' ),
			'section'  => 'iflynepal_explore',
			'priority' => $iflynepal_priority + 1,
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'title',
		array(
			'default'           => $iflynepal_default['title'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'title',
		array(
			'label'       => __( 'Card title', 'iflynepal' ),
			'description' => __( 'Wrap a word in &lt;em&gt; to give it the gold accent.', 'iflynepal' ),
			'section'     => 'iflynepal_explore',
			'priority'    => $iflynepal_priority + 2,
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		$iflynepal_prefix . 'description',
		array(
			'default'           => $iflynepal_default['description'],
			'sanitize_callback' => 'iflynepal_kses_text',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		$iflynepal_prefix . 'description',
		array(
			'label'       => __( 'Description', 'iflynepal' ),
			'description' => __( 'Revealed when the card is hovered or focused.', 'iflynepal' ),
			'section'     => 'iflynepal_explore',
			'priority'    => $iflynepal_priority + 3,
			'type'        => 'textarea',
		)
	);

	/*
	 * All link slots are registered here; the Customizer's control script hides
	 * the empty ones behind an "Add link" button.
	 */
	for ( $iflynepal_link = 1; $iflynepal_link <= IFLYNEPAL_EXPLORE_LINK_MAX; $iflynepal_link++ ) {
		$iflynepal_link_default = isset( $iflynepal_default['links'][ $iflynepal_link ] )
			? $iflynepal_default['links'][ $iflynepal_link ]
			: array(
				'label' => '',
				'url'   => '',
			);

		$wp_customize->add_setting(
			$iflynepal_prefix . 'link_' . $iflynepal_link . '_label',
			array(
				'default'           => $iflynepal_link_default['label'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$iflynepal_prefix . 'link_' . $iflynepal_link . '_label',
			array(
				/* translators: %d: link number. */
				'label'    => sprintf( __( 'Link %d label', 'iflynepal' ), $iflynepal_link ),
				'section'  => 'iflynepal_explore',
				'priority' => $iflynepal_priority + 3 + ( $iflynepal_link * 2 ) - 1,
				'type'     => 'text',
			)
		);

		$wp_customize->add_setting(
			$iflynepal_prefix . 'link_' . $iflynepal_link . '_url',
			array(
				'default'           => $iflynepal_link_default['url'],
				'sanitize_callback' => 'iflynepal_sanitize_link',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$iflynepal_prefix . 'link_' . $iflynepal_link . '_url',
			array(
				/* translators: %d: link number. */
				'label'       => sprintf( __( 'Link %d URL', 'iflynepal' ), $iflynepal_link ),
				'description' => __( 'A full URL, or an on-page anchor such as #featured.', 'iflynepal' ),
				'section'     => 'iflynepal_explore',
				'priority'    => $iflynepal_priority + 3 + ( $iflynepal_link * 2 ),
				'type'        => 'text',
			)
		);
	}

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
				'label'       => __( 'Card background image', 'iflynepal' ),
				'description' => __( 'Sits behind the card under a dark gradient, so a photograph with room at the bottom works best. Landscape, at least 1400px wide.', 'iflynepal' ),
				'section'     => 'iflynepal_explore',
				'priority'    => $iflynepal_priority + 3 + ( IFLYNEPAL_EXPLORE_LINK_MAX * 2 ) + 1,
				'mime_type'   => 'image',
			)
		)
	);
}

/* --------------------------------------------------------------- partials */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'iflynepal_explore_kicker',
		array(
			'selector'        => '#iflynepal-explore-kicker',
			'settings'        => array( 'iflynepal_explore_kicker' ),
			'render_callback' => 'iflynepal_render_explore_kicker',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'iflynepal_explore_title',
		array(
			'selector'        => '#iflynepal-explore-title',
			'settings'        => array( 'iflynepal_explore_title' ),
			'render_callback' => 'iflynepal_render_explore_title',
		)
	);

	for ( $iflynepal_card = 1; $iflynepal_card <= IFLYNEPAL_EXPLORE_CARDS; $iflynepal_card++ ) {
		$iflynepal_prefix = 'iflynepal_explore_card_' . $iflynepal_card . '_';

		foreach ( array( 'eyebrow', 'title', 'description' ) as $iflynepal_field ) {
			$wp_customize->selective_refresh->add_partial(
				$iflynepal_prefix . $iflynepal_field,
				array(
					'selector'        => '#iflynepal-explore-card-' . $iflynepal_card . '-' . $iflynepal_field,
					'settings'        => array( $iflynepal_prefix . $iflynepal_field ),
					'render_callback' => function () use ( $iflynepal_card, $iflynepal_field ) {
						$callback = 'iflynepal_render_explore_card_' . $iflynepal_field;

						return $callback( $iflynepal_card );
					},
				)
			);
		}

		$iflynepal_link_settings = array();

		for ( $iflynepal_link = 1; $iflynepal_link <= IFLYNEPAL_EXPLORE_LINK_MAX; $iflynepal_link++ ) {
			$iflynepal_link_settings[] = $iflynepal_prefix . 'link_' . $iflynepal_link . '_label';
			$iflynepal_link_settings[] = $iflynepal_prefix . 'link_' . $iflynepal_link . '_url';
		}

		$wp_customize->selective_refresh->add_partial(
			$iflynepal_prefix . 'links',
			array(
				'selector'        => '#iflynepal-explore-card-' . $iflynepal_card . '-links',
				'settings'        => $iflynepal_link_settings,
				'render_callback' => function () use ( $iflynepal_card ) {
					return iflynepal_render_explore_card_links( $iflynepal_card );
				},
			)
		);
	}
}
