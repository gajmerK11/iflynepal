<?php
/**
 * News archive: the editable parts of its hero, and their defaults.
 *
 * The hero is the only thing on the archive an editor sets here: the Top News
 * row and the run of stories under it are the stories themselves, and which
 * three lead is a toggle on each story rather than a field on the page.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * Copper prayer wheels under prayer flags — the frame the approved design
 * uses.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_NEWS_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/news/hero-news-prayer-wheels.jpg' );

/**
 * The headline, until one is written.
 *
 * `<em>` marks the word that carries the gold accent, the same convention
 * every other editable headline in the site uses.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_NEWS_HERO_TITLE_DEFAULT', 'Stay updated with <em>iFly Nepal</em>' );

/**
 * The standfirst under the headline, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT', 'New departures, festival dates and trip news, straight from our team in Kathmandu.' );

/**
 * The Top News heading, until one is written.
 *
 * `<em>` again marks the accent word — see iflynepal_news_top_heading_html(),
 * which is what turns it into this heading's own hand-inked underline rather
 * than the usual gold colour.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_NEWS_TOP_HEADING_DEFAULT', 'What’s <em>new</em> this season.' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_news_archive_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_news_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_NEWS_HERO_IMAGE_DEFAULT;
}

/**
 * The headline, as the editor typed it.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_news_hero_title() {
	$title = trim( (string) get_theme_mod( 'iflynepal_news_hero_title', IFLYNEPAL_NEWS_HERO_TITLE_DEFAULT ) );

	if ( '' === $title ) {
		$title = IFLYNEPAL_NEWS_HERO_TITLE_DEFAULT;
	}

	if ( function_exists( 'pll__' ) ) {
		$title = pll__( $title );
	}

	return iflynepal_kses_text( $title );
}

/**
 * The headline with each plain word wrapped for the entrance.
 *
 * @since 1.0.0
 *
 * @return string Ready-to-print HTML.
 */
function iflynepal_news_hero_title_html() {
	return iflynepal_hero_title_words( iflynepal_news_hero_title() );
}

/**
 * The standfirst under the headline.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_news_hero_lead() {
	$lead = (string) get_theme_mod( 'iflynepal_news_hero_lead', IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$lead = pll__( $lead );
	}

	return trim( $lead );
}

/**
 * The placeholder inside the search field.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_news_search_placeholder() {
	$placeholder = (string) get_theme_mod( 'iflynepal_news_search_placeholder', __( 'Search news…', 'iflynepal' ) );

	if ( function_exists( 'pll__' ) ) {
		$placeholder = pll__( $placeholder );
	}

	return trim( $placeholder );
}

/**
 * The eyebrow above the Top News heading.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_news_top_eyebrow() {
	$eyebrow = trim( (string) get_theme_mod( 'iflynepal_news_top_eyebrow', __( 'Top news', 'iflynepal' ) ) );

	return '' === $eyebrow ? __( 'Top news', 'iflynepal' ) : $eyebrow;
}

/**
 * The Top News heading, as the editor typed it.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_news_top_heading() {
	$heading = trim( (string) get_theme_mod( 'iflynepal_news_top_heading', IFLYNEPAL_NEWS_TOP_HEADING_DEFAULT ) );

	if ( '' === $heading ) {
		$heading = IFLYNEPAL_NEWS_TOP_HEADING_DEFAULT;
	}

	if ( function_exists( 'pll__' ) ) {
		$heading = pll__( $heading );
	}

	return iflynepal_kses_text( $heading );
}

/**
 * The Top News heading, ready to print.
 *
 * The design draws its accent word with a hand-inked underline (`.ink-mark`
 * plus the `.ink-line` stroke inside it) rather than the gold `<em>` every
 * other headline uses, so an editor still marks it the familiar way — wrap
 * it in `<em>` — and this is what turns that into the structural markup the
 * underline needs. Generated rather than authored because wp_kses() (inside
 * iflynepal_kses_text()) does not allow an `<i>` tag through at all, so a
 * `<span class="ink-mark"><i class="ink-line">` typed directly into the
 * Customizer would lose its stroke on save.
 *
 * @since 1.0.0
 *
 * @return string Ready-to-print HTML.
 */
function iflynepal_news_top_heading_html() {
	return preg_replace(
		'#<em\b[^>]*>(.*?)</em>#is',
		'<span class="ink-mark">$1<i class="ink-line"></i></span>',
		iflynepal_news_top_heading()
	);
}

/**
 * The line beside the "Top news" heading.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_news_top_note() {
	$note = (string) get_theme_mod(
		'iflynepal_news_top_note',
		__( 'The stories our trip planners are fielding the most questions about right now.', 'iflynepal' )
	);

	if ( function_exists( 'pll__' ) ) {
		$note = pll__( $note );
	}

	return trim( $note );
}

/**
 * The eyebrow above the recent-news heading.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_news_recent_eyebrow() {
	$eyebrow = trim( (string) get_theme_mod( 'iflynepal_news_recent_eyebrow', __( 'Recent news', 'iflynepal' ) ) );

	return '' === $eyebrow ? __( 'Recent news', 'iflynepal' ) : $eyebrow;
}

/**
 * The recent-news heading, ready to print.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_news_recent_heading_html() {
	$heading = trim( (string) get_theme_mod( 'iflynepal_news_recent_heading', __( 'Latest from Kathmandu', 'iflynepal' ) ) );

	if ( '' === $heading ) {
		$heading = __( 'Latest from Kathmandu', 'iflynepal' );
	}

	return iflynepal_kses_text( $heading );
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the News archive hero's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical note
 * on iflynepal_register_authors_pll_strings() in
 * inc/customizer/callbacks/authors.php), so registration can't live inside
 * the getters above — those run on the front end.
 *
 * The Top News eyebrow and the Recent News eyebrow/heading are left out:
 * their defaults are already wrapped in __() and translated through the
 * theme's .po file, not through Polylang Strings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_news_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$group = 'iFlyNepal — News';

	pll_register_string( 'News hero title', get_theme_mod( 'iflynepal_news_hero_title', IFLYNEPAL_NEWS_HERO_TITLE_DEFAULT ), $group );
	pll_register_string( 'News hero lead', get_theme_mod( 'iflynepal_news_hero_lead', IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT ), $group );
	pll_register_string( 'News top heading', get_theme_mod( 'iflynepal_news_top_heading', IFLYNEPAL_NEWS_TOP_HEADING_DEFAULT ), $group );
	pll_register_string( 'News search placeholder', get_theme_mod( 'iflynepal_news_search_placeholder', __( 'Search news…', 'iflynepal' ) ), $group );
	pll_register_string(
		'News top note',
		get_theme_mod(
			'iflynepal_news_top_note',
			__( 'The stories our trip planners are fielding the most questions about right now.', 'iflynepal' )
		),
		$group
	);
}
add_action( 'admin_init', 'iflynepal_register_news_pll_strings', 26 );
