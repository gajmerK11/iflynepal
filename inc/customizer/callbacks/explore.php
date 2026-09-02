<?php
/**
 * Explore section getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * Same shape as the hero (inc/customizer/callbacks/hero.php): each render
 * callback is also what the template calls, so the pencil-shortcut preview and
 * the shipped page come from the same code.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Number of gateway cards. The design is a two-column pair.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_EXPLORE_CARDS = 2;

/**
 * Links each card can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/homepage/hero/explore/links.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_EXPLORE_LINK_MAX = 3;

/**
 * Default heading, with the inked underline on one word.
 *
 * `underline` is the class an editor puts on a span to mark a word. See the
 * note in assets/css/input.css — inside the heading it also cancels Tailwind's
 * own `.underline` utility, which would otherwise draw a second, plain rule.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_EXPLORE_TITLE_DEFAULT = 'Adventure outward. Journey <span class="underline">inward</span>.';

/**
 * Default handwritten kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_EXPLORE_KICKER_DEFAULT = 'Explore Nepal your way';

/**
 * Stand-in card photography, used until the client's own images are uploaded.
 *
 * Unlike the hero — which deliberately has no fallback, because a stock photo
 * behind the client's own video reads as a glitch — the cards need an image to
 * hold their shape at all, and these are the two the approved mockup ships.
 *
 * @since 1.0.0
 *
 * @return string[] Placeholder URLs, indexed from 1.
 */
function iflynepal_explore_card_image_defaults() {
	return array(
		1 => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1400',
		2 => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=1400',
	);
}

/**
 * Default copy for both cards, as the approved mockup has it.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_explore_card_defaults() {
	return array(
		1 => array(
			'eyebrow'     => __( 'Travel & adventure', 'iflynepal' ),
			'title'       => __( 'Explore Nepal', 'iflynepal' ),
			'description' => __( "Trek the Himalayas, discover heritage cities, meet local communities and explore Nepal's wildlife, landscapes and culture.", 'iflynepal' ),
			'links'       => array(
				1 => array(
					'label' => __( 'Nepal Tours', 'iflynepal' ),
					'url'   => 'https://iflynepal.com/trip_category/tour-and-sightseeing-in-nepal',
				),
				2 => array(
					'label' => __( 'Trekking in Nepal', 'iflynepal' ),
					'url'   => 'https://iflynepal.com/trip_category/top-treks-in-nepal',
				),
				3 => array(
					'label' => __( 'Safari Tours', 'iflynepal' ),
					'url'   => 'https://iflynepal.com/trip_category/best-safari-tours-nepal',
				),
			),
		),
		2 => array(
			'eyebrow'     => __( 'Wellness & stillness', 'iflynepal' ),
			'title'       => __( '<em>Retreats</em> in Nepal', 'iflynepal' ),
			'description' => __( "Make space for meditation, yoga, Ayurveda, monastery life and restorative experiences shaped by Nepal's spiritual traditions and natural landscapes.", 'iflynepal' ),
			'links'       => array(
				1 => array(
					'label' => __( 'Retreats in Nepal', 'iflynepal' ),
					'url'   => 'https://iflynepal.com/trip_category/retreats-in-nepal',
				),
				2 => array(
					'label' => __( 'Meditation & Wellness', 'iflynepal' ),
					'url'   => '#featured',
				),
				3 => array(
					'label' => '',
					'url'   => '',
				),
			),
		),
	);
}

/**
 * One card's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_explore_card_default( $index ) {
	$defaults = iflynepal_explore_card_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'eyebrow'     => '',
		'title'       => '',
		'description' => '',
		'links'       => array(),
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * Handwritten kicker above the heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_explore_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_explore_kicker', IFLYNEPAL_EXPLORE_KICKER_DEFAULT ) );
}

/**
 * Section heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_explore_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_explore_title', IFLYNEPAL_EXPLORE_TITLE_DEFAULT ) );
}

/**
 * One card's eyebrow.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Eyebrow text.
 */
function iflynepal_explore_card_eyebrow( $index ) {
	$default = iflynepal_explore_card_default( $index );

	return (string) get_theme_mod( 'iflynepal_explore_card_' . $index . '_eyebrow', $default['eyebrow'] );
}

/**
 * One card's title.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Title HTML.
 */
function iflynepal_explore_card_title( $index ) {
	$default = iflynepal_explore_card_default( $index );

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_explore_card_' . $index . '_title', $default['title'] ) );
}

/**
 * One card's description.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Description HTML.
 */
function iflynepal_explore_card_description( $index ) {
	$default = iflynepal_explore_card_default( $index );

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_explore_card_' . $index . '_description', $default['description'] ) );
}

/**
 * One card's links, skipping any slot with no label.
 *
 * Emptying a label is how the Customizer's Remove button deletes a link, so an
 * empty slot is dropped rather than rendered as a bare arrow.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array[] Links, each with 'label' and 'url'.
 */
function iflynepal_explore_card_links( $index ) {
	$default = iflynepal_explore_card_default( $index );
	$links   = array();

	for ( $i = 1; $i <= IFLYNEPAL_EXPLORE_LINK_MAX; $i++ ) {
		$link_default = isset( $default['links'][ $i ] ) ? $default['links'][ $i ] : array(
			'label' => '',
			'url'   => '',
		);

		$label = trim( (string) get_theme_mod( 'iflynepal_explore_card_' . $index . '_link_' . $i . '_label', $link_default['label'] ) );

		if ( '' === $label ) {
			continue;
		}

		$links[] = array(
			'label' => $label,
			'url'   => (string) get_theme_mod( 'iflynepal_explore_card_' . $index . '_link_' . $i . '_url', $link_default['url'] ),
		);
	}

	return $links;
}

/* ------------------------------------------------------------------- media */

/**
 * One card's background image URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_explore_card_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_explore_card_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	$defaults = iflynepal_explore_card_image_defaults();

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : '';
}

/* ------------------------------------------------------ render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_explore_kicker() {
	return iflynepal_explore_kicker();
}

/**
 * Renders the section heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_explore_title() {
	return iflynepal_explore_title();
}

/**
 * Renders one card's eyebrow.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_explore_card_eyebrow( $index ) {
	return esc_html( iflynepal_explore_card_eyebrow( $index ) );
}

/**
 * Renders one card's title.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_explore_card_title( $index ) {
	return iflynepal_explore_card_title( $index );
}

/**
 * Renders one card's description.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_explore_card_description( $index ) {
	return iflynepal_explore_card_description( $index );
}

/**
 * Renders one card's link list.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_explore_card_links( $index ) {
	$markup = '';

	foreach ( iflynepal_explore_card_links( $index ) as $link ) {
		$markup .= sprintf(
			'<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="%1$s">%2$s</a></div>',
			esc_url( $link['url'] ),
			esc_html( $link['label'] )
		);
	}

	return $markup;
}
