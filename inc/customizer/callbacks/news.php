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
 * The standfirst under the headline, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT', 'New departures, festival dates and trip news, straight from our team in Kathmandu.' );

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
 * The standfirst under the headline.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_news_hero_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_news_hero_lead', IFLYNEPAL_NEWS_HERO_LEAD_DEFAULT ) );
}

/**
 * The placeholder inside the search field.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_news_search_placeholder() {
	return trim( (string) get_theme_mod( 'iflynepal_news_search_placeholder', __( 'Search news…', 'iflynepal' ) ) );
}

/**
 * The line beside the "Top news" heading.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_news_top_note() {
	return trim(
		(string) get_theme_mod(
			'iflynepal_news_top_note',
			__( 'The stories our trip planners are fielding the most questions about right now.', 'iflynepal' )
		)
	);
}
