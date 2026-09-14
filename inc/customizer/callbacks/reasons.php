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
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_reasons_heading', IFLYNEPAL_REASONS_HEADING_DEFAULT ) );
}

/**
 * The description under the heading.
 *
 * @since 1.0.0
 *
 * @return string Description HTML.
 */
function iflynepal_reasons_description() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_reasons_description', IFLYNEPAL_REASONS_DESCRIPTION_DEFAULT ) );
}

/**
 * The annotation's fixed opening text.
 *
 * @since 1.0.0
 *
 * @return string Plain text.
 */
function iflynepal_reasons_annotation_static() {
	return (string) get_theme_mod( 'iflynepal_reasons_annotation_static', IFLYNEPAL_REASONS_ANNOTATION_STATIC_DEFAULT );
}

/**
 * The words the annotation cycles through, one per line in the Customizer.
 *
 * @since 1.0.0
 *
 * @return string[] Non-empty words, in order.
 */
function iflynepal_reasons_annotation_words() {
	$raw   = get_theme_mod( 'iflynepal_reasons_annotation_words', IFLYNEPAL_REASONS_ANNOTATION_WORDS_DEFAULT );
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
 * The filter buttons above the grid, "All" included.
 *
 * "All" carries no slug of its own — it is the unfiltered view, so there is
 * nothing for a card to match against, the same rule the catalogue's own
 * "All" button follows (it is deliberately not "All retreats" either: see
 * ifn-booking's iflynepal_archive_filter_terms()).
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'slug' (empty for "All") and 'label'.
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
