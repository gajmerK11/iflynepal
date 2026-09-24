<?php
/**
 * "A few good reasons" section getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The cards and the filter buttons are not edited here at all — they come
 * from the ifn-booking plugin, one card per package an editor has ticked
 * "Show in 'A few good reasons'" on, over the `iflynepal_homepage_reasons`
 * filter (the same shape as `iflynepal_upcoming_departures`: the theme owns
 * the section's copy and never learns what a package type is). This file
 * holds the heading, the description and the handwritten annotation beside
 * them — the static word it opens on, and the words it cycles through after.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default heading. `underline` is the same class the Explore heading uses to
 * mark a word for the hand-inked underline — see
 * .iflynepal-reasons__title .underline in assets/css/input.css, which folds
 * this section into that shared rule rather than styling a class of its own.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_REASONS_HEADING_DEFAULT = 'A few <span class="underline">good reasons</span> to come to Nepal.';

/**
 * Default description under the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_REASONS_DESCRIPTION_DEFAULT = 'A curated mix of travel and retreat experiences, not an endless catalogue.';

/**
 * Default fixed text the handwritten annotation opens on and keeps.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_REASONS_ANNOTATION_STATIC_DEFAULT = 'Featured ';

/**
 * Default words the annotation cycles through after the static text, one per
 * line — the same shape the catalogue archive's own listing annotation uses.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_REASONS_ANNOTATION_WORDS_DEFAULT = "Experiences\nTravel\nRetreats";

/* -------------------------------------------------------------------- copy */

/**
 * The section heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_reasons_heading() {
	$heading = get_theme_mod( 'iflynepal_reasons_heading', IFLYNEPAL_REASONS_HEADING_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$heading = pll__( $heading );
	}

	return iflynepal_kses_text( $heading );
}

/**
 * The description under the heading.
 *
 * @since 1.0.0
 *
 * @return string Description HTML.
 */
function iflynepal_reasons_description() {
	$description = get_theme_mod( 'iflynepal_reasons_description', IFLYNEPAL_REASONS_DESCRIPTION_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$description = pll__( $description );
	}

	return iflynepal_kses_text( $description );
}

/**
 * The annotation's fixed opening text.
 *
 * @since 1.0.0
 *
 * @return string Plain text.
 */
function iflynepal_reasons_annotation_static() {
	$static = (string) get_theme_mod( 'iflynepal_reasons_annotation_static', IFLYNEPAL_REASONS_ANNOTATION_STATIC_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$static = pll__( $static );
	}

	/*
	 * assets/js/homepage/reasons/annotation.js types this text and the
	 * cycling word back to back with nothing in between, so the space has to
	 * be part of this string. Re-added here rather than trusted to survive
	 * storage: the Polylang Strings screen's textarea trims trailing
	 * whitespace on save, so a translator's space was silently lost.
	 */
	return '' === trim( $static ) ? $static : rtrim( $static ) . ' ';
}

/**
 * The words the annotation cycles through, one per line in the Customizer.
 *
 * @since 1.0.0
 *
 * @return string[] Non-empty words, in order.
 */
function iflynepal_reasons_annotation_words() {
	$raw = get_theme_mod( 'iflynepal_reasons_annotation_words', IFLYNEPAL_REASONS_ANNOTATION_WORDS_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$raw = pll__( $raw );
	}

	$lines = preg_split( '/\R/', (string) $raw );

	return array_values( array_filter( array_map( 'trim', (array) $lines ), 'strlen' ) );
}

/* ---------------------------------------------------------------- packages */

/**
 * The plugin's answer to "what goes in this grid", cached for one request.
 *
 * @since 1.0.0
 *
 * @return array{cards: array[], filters: array[]} Empty of both when the
 *                plugin is inactive or nothing is ticked.
 */
function iflynepal_reasons_payload() {
	static $payload = null;

	if ( null === $payload ) {
		/**
		 * Filters the cards and filter buttons for the "A few good reasons" grid.
		 *
		 * The theme fires this and renders whatever comes back; it carries no
		 * opinion of its own about what a package type is. See
		 * ifn-booking/includes/frontend/homepage-reasons.php.
		 *
		 * @since 1.0.0
		 *
		 * @param array{cards: array[], filters: array[]} $payload Empty by default.
		 */
		$payload = (array) apply_filters(
			'iflynepal_homepage_reasons',
			array(
				'cards'   => array(),
				'filters' => array(),
			)
		);

		$payload += array(
			'cards'   => array(),
			'filters' => array(),
		);
	}

	return $payload;
}

/**
 * The cards for the grid.
 *
 * @since 1.0.0
 *
 * @return array[] Cards, in the order they should appear.
 */
function iflynepal_reasons_cards() {
	return iflynepal_reasons_payload()['cards'];
}

/**
 * The whole catalogue's own archive — /packages/ — for the "All" filter's
 * "view all" link.
 *
 * @since 1.0.0
 *
 * @return string URL, or '' when the booking plugin isn't active to register
 *                 the post type this reads.
 */
function iflynepal_reasons_all_url() {
	if ( ! defined( 'IFLYNEPAL_PACKAGE_POST_TYPE' ) ) {
		return '';
	}

	$url = get_post_type_archive_link( IFLYNEPAL_PACKAGE_POST_TYPE );

	return $url ? $url : '';
}

/**
 * The filter buttons above the grid, "All" included.
 *
 * "All" carries no slug of its own — it is the unfiltered view, so there is
 * nothing for a card to match against, the same rule the catalogue's own
 * "All" button follows (it is deliberately not "All retreats" either: see
 * ifn-booking's iflynepal_archive_filter_terms()). Its "view all" link is the
 * one exception to "a type's own archive": with no single type chosen there
 * is no one archive to send a visitor to, so it points at the whole
 * catalogue instead — see the "view all" link in
 * template-parts/home/reasons-section.php.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'slug' (empty for "All"), 'label' and 'url'.
 */
function iflynepal_reasons_filters() {
	$filters = iflynepal_reasons_payload()['filters'];

	if ( ! $filters ) {
		return array();
	}

	array_unshift(
		$filters,
		array(
			'slug'  => '',
			'label' => __( 'All', 'iflynepal' ),
			'url'   => iflynepal_reasons_all_url(),
		)
	);

	return $filters;
}

/**
 * Whether the "A few good reasons" section has anything to show.
 *
 * Query-driven, so it is opt-in on its own results — the same rule every
 * other query-driven homepage section in this project follows.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_reasons() {
	return (bool) iflynepal_reasons_cards();
}

/* ------------------------------------------------------ render callbacks */

/**
 * Renders the heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_reasons_heading() {
	return iflynepal_reasons_heading();
}

/**
 * Renders the description.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_reasons_description() {
	return iflynepal_reasons_description();
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the "A few good reasons" section's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical note
 * on iflynepal_register_authors_pll_strings() in
 * inc/customizer/callbacks/authors.php), so registration can't live inside
 * the getters above — those run on the front end.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_reasons_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	pll_register_string( 'Reasons heading', get_theme_mod( 'iflynepal_reasons_heading', IFLYNEPAL_REASONS_HEADING_DEFAULT ), 'iFlyNepal — Homepage / Reasons', true );
	pll_register_string( 'Reasons description', get_theme_mod( 'iflynepal_reasons_description', IFLYNEPAL_REASONS_DESCRIPTION_DEFAULT ), 'iFlyNepal — Homepage / Reasons' );
	pll_register_string( 'Reasons annotation static text', get_theme_mod( 'iflynepal_reasons_annotation_static', IFLYNEPAL_REASONS_ANNOTATION_STATIC_DEFAULT ), 'iFlyNepal — Homepage / Reasons' );
	pll_register_string( 'Reasons annotation words', get_theme_mod( 'iflynepal_reasons_annotation_words', IFLYNEPAL_REASONS_ANNOTATION_WORDS_DEFAULT ), 'iFlyNepal — Homepage / Reasons', true );
}
add_action( 'admin_init', 'iflynepal_register_reasons_pll_strings', 13 );
