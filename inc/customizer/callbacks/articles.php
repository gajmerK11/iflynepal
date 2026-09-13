<?php
/**
 * Articles archive: the editable parts of its hero, and their defaults.
 *
 * The hero is the only thing on the archive an editor sets: everything below
 * it — the tabs, the cards, the pager — is drawn from the articles themselves
 * and from the category list, so there is nothing there to type.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * Prayer flags on a ridge under Machhapuchhre — the frame the approved design
 * uses.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_ARTICLES_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/articles/hero-articles-machhapuchhre.jpg' );

/**
 * The standfirst under the headline, until one is written.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_ARTICLES_HERO_LEAD_DEFAULT', 'Trek guides, retreat stories and local know-how, written by the people who plan the trips.' );

/**
 * The headline, until one is written.
 *
 * The approved design's own words. `<em>` marks the word that carries the gold
 * accent, which is the same convention the single article's headline uses.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_ARTICLES_HERO_TITLE_DEFAULT', 'Nepal Travel <em>Articles</em>' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_articles_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_articles_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_ARTICLES_HERO_IMAGE_DEFAULT;
}

/**
 * The standfirst under the headline.
 *
 * @since 1.0.0
 *
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_articles_hero_lead() {
	return trim( (string) get_theme_mod( 'iflynepal_articles_hero_lead', IFLYNEPAL_ARTICLES_HERO_LEAD_DEFAULT ) );
}

/**
 * The headline, as the editor typed it.
 *
 * @since 1.0.0
 *
 * @return string Sanitized HTML, falling back to the design's own words.
 */
function iflynepal_articles_hero_title() {
	$title = trim( (string) get_theme_mod( 'iflynepal_articles_hero_title', IFLYNEPAL_ARTICLES_HERO_TITLE_DEFAULT ) );

	if ( '' === $title ) {
		$title = IFLYNEPAL_ARTICLES_HERO_TITLE_DEFAULT;
	}

	return iflynepal_kses_text( $title );
}

/**
 * The headline with each plain word wrapped for the entrance.
 *
 * The design staggers the headline a word at a time, and assets/js/articles/
 * motion.js tweens `.hero h1 .w` and `.hero h1 em` to do it — so the words have
 * to arrive already wrapped rather than being split by script after the fact.
 * Doing it here rather than in the template keeps the Customizer's partial and
 * the first paint building the same markup from the same string.
 *
 * The value has been through iflynepal_kses_text() already, so the only tags
 * that can be in it are `<span>`, `<br>`, `<em>` and `<strong>`. Any run that
 * carries a tag is passed through untouched — an editor who writes their own
 * markup gets exactly what they wrote — and only bare words are wrapped.
 *
 * @since 1.0.0
 *
 * @return string Ready-to-print HTML.
 */
function iflynepal_articles_hero_title_html() {
	$title = iflynepal_articles_hero_title();

	// Split the accent runs out whole; everything between them is plain words.
	$parts = preg_split( '#(<em\b[^>]*>.*?</em>)#is', $title, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

	if ( ! $parts ) {
		return $title;
	}

	$html = '';

	foreach ( $parts as $part ) {
		if ( 0 === stripos( $part, '<em' ) ) {
			// The trailing space is the word gap: the spans are inline-block.
			$html .= $part . ' ';

			continue;
		}

		foreach ( preg_split( '/\s+/', trim( $part ), -1, PREG_SPLIT_NO_EMPTY ) as $word ) {
			$html .= false === strpos( $word, '<' )
				? '<span class="w">' . $word . '</span> '
				: $word . ' ';
		}
	}

	return trim( $html );
}

/**
 * The placeholder inside the search field.
 *
 * @since 1.0.0
 *
 * @return string
 */
function iflynepal_articles_search_placeholder() {
	return trim( (string) get_theme_mod( 'iflynepal_articles_search_placeholder', __( 'Search treks, retreats…', 'iflynepal' ) ) );
}
