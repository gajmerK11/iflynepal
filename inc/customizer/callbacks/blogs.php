<?php
/**
 * Blogs archive: the editable parts of its hero, and their defaults.
 *
 * The same four fields the Articles archive has, on settings of their own — the
 * two sections share a design, not a headline. Everything below the hero is
 * drawn from the posts and from the category list, so there is nothing else
 * there to type.
 *
 * The shaping of the headline is not repeated here: the wrapping of each word
 * for the entrance is iflynepal_articles_hero_title_html()'s work, done once in
 * inc/customizer/callbacks/articles.php and called with this section's string.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * The Articles archive's frame, since the two are the same band and the client
 * has one photograph for it until they choose otherwise.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_BLOGS_HERO_IMAGE_DEFAULT', IFLYNEPAL_ARTICLES_HERO_IMAGE_DEFAULT );

/**
 * The standfirst under the headline, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_BLOGS_HERO_LEAD_DEFAULT', 'Field notes, planning advice and stories from the road, written by the people who plan the trips.' );

/**
 * The headline, until one is written.
 *
 * `<em>` marks the word that carries the gold accent, which is the same
 * convention the Articles headline uses.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_BLOGS_HERO_TITLE_DEFAULT', 'Nepal Travel <em>Blogs</em>' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_blogs_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_blogs_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_BLOGS_HERO_IMAGE_DEFAULT;
}

/**
 * The standfirst under the headline.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_blogs_hero_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_blogs_hero_lead', IFLYNEPAL_BLOGS_HERO_LEAD_DEFAULT ) );
}

/**
 * The headline, as the editor typed it.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the theme's own words.
 */
function iflynepal_blogs_hero_title() {
	$title = trim( (string) get_theme_mod( 'iflynepal_blogs_hero_title', IFLYNEPAL_BLOGS_HERO_TITLE_DEFAULT ) );

	if ( '' === $title ) {
		$title = IFLYNEPAL_BLOGS_HERO_TITLE_DEFAULT;
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
function iflynepal_blogs_hero_title_html() {
	return iflynepal_hero_title_words( iflynepal_blogs_hero_title() );
}

/**
 * The placeholder inside the search field.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_blogs_search_placeholder() {
	return trim( (string) get_theme_mod( 'iflynepal_blogs_search_placeholder', __( 'Search treks, retreats…', 'iflynepal' ) ) );
}
