<?php
/**
 * Upcoming Journeys section getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The cards themselves are not edited here at all — they come from the
 * ifn-booking plugin, one per package an editor has ticked "Display on
 * homepage" on, over the `iflynepal_upcoming_departures` filter (the same
 * shape as `iflynepal_testimonial_display_targets`: the theme owns the
 * section's copy and never learns what a package is). This file holds the
 * three pieces of copy around that rail — the eyebrow, the heading and the
 * description — plus the status line, which is not copy at all: it is
 * counted from the cards themselves, never typed in, so it cannot say
 * something the rail does not actually show.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default eyebrow above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_UPCOMING_EYEBROW_DEFAULT = 'Upcoming journeys';

/**
 * Default heading. The accent word carries the gold treatment — see
 * .iflynepal-departures__title em in assets/css/input.css.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_UPCOMING_HEADING_DEFAULT = 'See what you can join <em>Next</em>';

/**
 * Default description under the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_UPCOMING_DESCRIPTION_DEFAULT = 'Real dates you can join, travel and retreat alike. No email needed to see what is next.';

/* -------------------------------------------------------------------- copy */

/**
 * The eyebrow above the heading.
 *
 * @since 1.0.0
 *
 * @return string Eyebrow text.
 */
function iflynepal_upcoming_eyebrow() {
	$eyebrow = (string) get_theme_mod( 'iflynepal_upcoming_eyebrow', IFLYNEPAL_UPCOMING_EYEBROW_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$eyebrow = pll__( $eyebrow );
	}

	return $eyebrow;
}

/**
 * The section heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_upcoming_heading() {
	$heading = get_theme_mod( 'iflynepal_upcoming_heading', IFLYNEPAL_UPCOMING_HEADING_DEFAULT );

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
function iflynepal_upcoming_description() {
	$description = get_theme_mod( 'iflynepal_upcoming_description', IFLYNEPAL_UPCOMING_DESCRIPTION_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$description = pll__( $description );
	}

	return iflynepal_kses_text( $description );
}

/* ---------------------------------------------------------------- packages */

/**
 * The packages the plugin has marked for this rail, cached for one request.
 *
 * A plain `apply_filters()` call would be harmless to repeat, but the
 * template, the enqueue guard and any future render callback all ask this
 * question, and a static cache is what keeps three call sites from running
 * the same query three times on one request.
 *
 * @since 1.0.0
 *
 * @return array[] Cards, each as iflynepal_upcoming_departure_card() shapes
 *                 them in the plugin — empty when the plugin is inactive or
 *                 no package qualifies.
 */
function iflynepal_upcoming_departures() {
	static $cards = null;

	if ( null === $cards ) {
		/**
		 * Filters the packages shown on the homepage's Upcoming Journeys rail.
		 *
		 * The theme fires this and renders whatever comes back; it carries no
		 * opinion of its own about what a package is. See
		 * ifn-booking/includes/frontend/homepage-departures.php.
		 *
		 * @since 1.0.0
		 *
		 * @param array[] $cards Cards to show, in the order they should appear.
		 */
		$cards = (array) apply_filters( 'iflynepal_upcoming_departures', array() );
	}

	return $cards;
}

/**
 * Whether the Upcoming Journeys section has anything to show.
 *
 * A query-driven section is opt-in on its own results, the same rule the
 * plugin's archive testimonials band and departures rail follow: a section
 * with nothing behind it is left off the page rather than rendered empty.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_upcoming_departures() {
	return (bool) iflynepal_upcoming_departures();
}

/**
 * The distinct months the current set of cards runs in, in date order.
 *
 * Built from the cards themselves rather than queried separately, so the chip
 * row can never list a month with nothing behind it — the same "answered from
 * what is already on the page" rule the catalogue's category filter uses.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'value' (YYYY-MM) and 'label' (e.g. 'Sep 2026').
 */
function iflynepal_upcoming_departure_months() {
	$months = array();

	foreach ( iflynepal_upcoming_departures() as $card ) {
		$value = isset( $card['month'] ) ? $card['month'] : '';

		if ( '' === $value || isset( $months[ $value ] ) ) {
			continue;
		}

		$months[ $value ] = isset( $card['month_label'] ) ? $card['month_label'] : $value;
	}

	// YYYY-MM sorts correctly as a plain string; no date parsing is needed.
	ksort( $months );

	$list = array();

	foreach ( $months as $value => $label ) {
		$list[] = array(
			'value' => $value,
			'label' => $label,
		);
	}

	return $list;
}

/**
 * The status line under the month chips, for whichever month starts active.
 *
 * Not a copy field — it is counted from the cards themselves, the same way
 * assets/js/homepage/departures/rail.js recounts it on every chip press, so
 * server-rendered markup and the script's own count can never disagree. The
 * first month in date order is the one the template marks active, so that is
 * the one counted here.
 *
 * @since 1.0.0
 *
 * @return string e.g. '4 departures in Sep 2026', or '' when there is
 *                nothing to count.
 */
function iflynepal_upcoming_status_text() {
	$months = iflynepal_upcoming_departure_months();

	if ( ! $months ) {
		return '';
	}

	$month = $months[0];
	$count = 0;

	foreach ( iflynepal_upcoming_departures() as $card ) {
		if ( isset( $card['month'] ) && $card['month'] === $month['value'] ) {
			++$count;
		}
	}

	return sprintf(
		/* translators: 1: number of departures, 2: month label, e.g. "Sep 2026". */
		_n( '%1$d departure in %2$s', '%1$d departures in %2$s', $count, 'iflynepal' ),
		$count,
		$month['label']
	);
}

/* ------------------------------------------------------ render callbacks */

/**
 * Renders the eyebrow.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_upcoming_eyebrow() {
	return esc_html( iflynepal_upcoming_eyebrow() );
}

/**
 * Renders the heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_upcoming_heading() {
	return iflynepal_upcoming_heading();
}

/**
 * Renders the description.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_upcoming_description() {
	return iflynepal_upcoming_description();
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the Upcoming Journeys section's Customizer text with Polylang.
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
function iflynepal_register_upcoming_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	pll_register_string( 'Upcoming journeys eyebrow', get_theme_mod( 'iflynepal_upcoming_eyebrow', IFLYNEPAL_UPCOMING_EYEBROW_DEFAULT ), 'iFlyNepal — Homepage / Upcoming Journeys' );
	pll_register_string( 'Upcoming journeys heading', get_theme_mod( 'iflynepal_upcoming_heading', IFLYNEPAL_UPCOMING_HEADING_DEFAULT ), 'iFlyNepal — Homepage / Upcoming Journeys', true );
	pll_register_string( 'Upcoming journeys description', get_theme_mod( 'iflynepal_upcoming_description', IFLYNEPAL_UPCOMING_DESCRIPTION_DEFAULT ), 'iFlyNepal — Homepage / Upcoming Journeys' );
}
add_action( 'admin_init', 'iflynepal_register_upcoming_pll_strings', 12 );
