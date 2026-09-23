<?php
/**
 * Authors panel: the archive's hero, and the banner on every single author page.
 *
 * The archive hero is one photograph plus a headline and a standfirst, the
 * same shape as the Articles archive's; see inc/customizer/callbacks/articles.php,
 * which this mirrors field for field.
 *
 * The single-author banner is CloudColleague's "Author Profile" section
 * (inc/customizer/sections/author.php in that theme): one image, with a solid
 * colour fallback when no image is set, shared by every author's page rather
 * than set per person. An individual photo per author is what the Profile
 * Photo field on their own user profile is for.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The Authors archive hero's default photograph.
 *
 * Reuses the Articles archive's own default image rather than shipping a
 * second one: both heroes are the same design and, until the client supplies
 * their own photographs, the same placeholder serves either.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHORS_HERO_IMAGE_DEFAULT', IFLYNEPAL_ARTICLES_HERO_IMAGE_DEFAULT );

/**
 * The Authors archive hero's headline, until one is written.
 *
 * The approved design's own words.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHORS_HERO_TITLE_DEFAULT', '<span class="w">Meet</span> <span class="w">our</span> <em>authors</em>' );

/**
 * The Authors archive hero's standfirst, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHORS_HERO_LEAD_DEFAULT', 'The trip planners and guides whose trips, and trails, the articles come from.' );

/**
 * The single author banner's default photograph.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHOR_BANNER_IMAGE_DEFAULT', IFLYNEPAL_ARTICLES_HERO_IMAGE_DEFAULT );

/**
 * The authors grid's heading, until one is written.
 *
 * The approved design's own words, the accent on the last word.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHORS_LIST_HEADING_DEFAULT', 'Written in <span class="ink-mark">Kathmandu<i class="ink-line"></i></span>' );

/**
 * The authors grid's standfirst, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHORS_LIST_LEAD_DEFAULT', 'Every article carries the byline of the desk it came from. Follow one to read everything they have published.' );

/**
 * The Authors archive hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the shipped default.
 */
function iflynepal_authors_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_authors_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_AUTHORS_HERO_IMAGE_DEFAULT;
}

/**
 * The Authors archive hero's standfirst.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_authors_hero_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_authors_hero_lead', IFLYNEPAL_AUTHORS_HERO_LEAD_DEFAULT ) );
}

/**
 * The Authors archive hero's headline, as the editor typed it.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_authors_hero_title() {
	$title = trim( (string) get_theme_mod( 'iflynepal_authors_hero_title', IFLYNEPAL_AUTHORS_HERO_TITLE_DEFAULT ) );

	if ( '' === $title ) {
		$title = IFLYNEPAL_AUTHORS_HERO_TITLE_DEFAULT;
	}

	return iflynepal_kses_text( $title );
}

/**
 * The Authors archive hero's headline, wrapped for the entrance.
 *
 * Shares iflynepal_hero_title_words() with the Articles and Blogs heroes
 * (inc/customizer/callbacks/articles.php): the same stagger, the same script.
 *
 * @since 1.0.0
 *
 * @return string Ready-to-print HTML.
 */
function iflynepal_authors_hero_title_html() {
	return iflynepal_hero_title_words( iflynepal_authors_hero_title() );
}

/**
 * The single author banner's photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the shipped default.
 */
function iflynepal_author_banner_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_author_banner_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_AUTHOR_BANNER_IMAGE_DEFAULT;
}

/**
 * The authors grid's heading, ready to print.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_authors_list_heading() {
	$heading = trim( (string) get_theme_mod( 'iflynepal_authors_list_heading', IFLYNEPAL_AUTHORS_LIST_HEADING_DEFAULT ) );

	if ( '' === $heading ) {
		$heading = IFLYNEPAL_AUTHORS_LIST_HEADING_DEFAULT;
	}

	return iflynepal_kses_ink_heading( $heading );
}

/**
 * The authors grid's standfirst.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_authors_list_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_authors_list_lead', IFLYNEPAL_AUTHORS_LIST_LEAD_DEFAULT ) );
}

/**
 * The single author page's posts section eyebrow, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHOR_POSTS_EYEBROW_DEFAULT', 'From this author' );

/**
 * The single author page's posts section standfirst, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_AUTHOR_POSTS_LEAD_DEFAULT', 'Trek guides, retreat stories and trip news, written by the people who plan the journeys.' );

/**
 * The eyebrow over "Read my …" on a single author page.
 *
 * @since 1.0.0
 *
 * @return string Sanitized text, falling back to the design's own words.
 */
function iflynepal_author_posts_eyebrow() {
	$eyebrow = trim( (string) get_theme_mod( 'iflynepal_author_posts_eyebrow', IFLYNEPAL_AUTHOR_POSTS_EYEBROW_DEFAULT ) );

	if ( '' === $eyebrow ) {
		$eyebrow = IFLYNEPAL_AUTHOR_POSTS_EYEBROW_DEFAULT;
	}

	return iflynepal_kses_text( $eyebrow );
}

/**
 * The standfirst under "Read my …" on a single author page.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_author_posts_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_author_posts_lead', IFLYNEPAL_AUTHOR_POSTS_LEAD_DEFAULT ) );
}
