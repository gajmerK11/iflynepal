<?php
/**
 * The News archive: its query, and the pieces its templates draw.
 *
 * The post type itself is registered in inc/cpts/news-cpt.php. What lives here
 * is everything that turns that type into the archive the design shows — the
 * six-per-page query, the search, the Top News row and the small render
 * helpers the template parts call.
 *
 * There are no hand-written rewrite rules here, unlike Articles: News has no
 * taxonomy sitting inside its permalink, so `/news/` and `/news/{slug}/` are
 * exactly what WordPress generates from the type's own rewrite base.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Stories per page on the archive.
 *
 * Six, which is three full rows of the design's two-column grid of horizontal
 * cards — the last row is never left with a gap in it at the widest
 * breakpoint, and the approved design's own pager is drawn over six.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_PER_PAGE = 6;

/**
 * The query variable the archive's search field uses.
 *
 * The same name the Articles archive uses, and for the same reason: not `s`,
 * because WordPress's own search variable turns any URL carrying it into a
 * search results page, which would take the request off the archive template
 * and lose the post type with it. The two archives never share a request, so
 * one name serves both and a visitor moving between them sees the field they
 * expect.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_SEARCH_VAR = 'ifn_search';

/**
 * How many headlines the ticker and the sidebar's rail carry.
 *
 * Five along the foot of the story's picture, of which the sidebar's rail
 * shows the first four — the design's numbers.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_LATEST = 5;

/* ------------------------------------------------------------------ query */

/**
 * Shapes the main query on the News archive.
 *
 * Two things: the page size, and the search. The search is handed to the query
 * as `s` together with the post type, because a search would otherwise widen
 * to every post type on the site.
 *
 * The Top News row above the list is a query of its own, so nothing is
 * excluded here — a flagged story is both the lead of the page and part of the
 * run of stories under it, which is how the design has it.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The query being prepared.
 * @return void
 */
function iflynepal_news_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( IFLYNEPAL_NEWS_POST_TYPE ) ) {
		return;
	}

	$query->set( 'posts_per_page', IFLYNEPAL_NEWS_PER_PAGE );

	$search = iflynepal_news_search_term();

	if ( '' !== $search ) {
		$query->set( 's', $search );
		$query->set( 'post_type', IFLYNEPAL_NEWS_POST_TYPE );
	}
}
add_action( 'pre_get_posts', 'iflynepal_news_pre_get_posts' );

/**
 * Whether the current request renders the News archive.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_news() {
	return is_post_type_archive( IFLYNEPAL_NEWS_POST_TYPE );
}

/**
 * Whether the current request renders a single news story.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_news_story() {
	return is_singular( IFLYNEPAL_NEWS_POST_TYPE );
}

/**
 * What the visitor typed into the archive's search field.
 *
 * @since 1.0.0
 *
 * @return string The query, trimmed; empty when nothing was searched for.
 */
function iflynepal_news_search_term() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- A public, idempotent search field; there is nothing to forge.
	if ( ! isset( $_GET[ IFLYNEPAL_NEWS_SEARCH_VAR ] ) ) {
		return '';
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- As above.
	return trim( sanitize_text_field( wp_unslash( $_GET[ IFLYNEPAL_NEWS_SEARCH_VAR ] ) ) );
}

/**
 * The News archive's own URL.
 *
 * @since 1.0.0
 *
 * @return string Archive URL, empty when the post type has no archive.
 */
function iflynepal_news_archive_url() {
	$url = get_post_type_archive_link( IFLYNEPAL_NEWS_POST_TYPE );

	return $url ? $url : '';
}

/* ------------------------------------------------------------- the stories */

/**
 * The newest stories, for the ticker, the sidebar's rail and the related row.
 *
 * @since 1.0.0
 *
 * @param int $count   How many to return.
 * @param int $exclude A story to leave out — the one being read.
 * @return WP_Post[] Stories, newest first.
 */
function iflynepal_news_latest( $count, $exclude = 0 ) {
	$args = array(
		'post_type'              => IFLYNEPAL_NEWS_POST_TYPE,
		'post_status'            => 'publish',
		'posts_per_page'         => max( 1, (int) $count ),
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
	);

	if ( $exclude ) {
		$args['post__not_in'] = array( (int) $exclude );
	}

	return get_posts( $args );
}

/**
 * The story's topic line, as the hero prints it beside the News flag.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Story. Defaults to the one in the loop.
 * @return string The line, empty when the editor has not set one.
 */
function iflynepal_news_topic( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	return trim( (string) get_post_meta( $post_id, IFLYNEPAL_NEWS_TOPIC_META, true ) );
}

/**
 * Where the story is filed from.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Story. Defaults to the one in the loop.
 * @return string The place, empty when the editor has not set one.
 */
function iflynepal_news_place( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	return trim( (string) get_post_meta( $post_id, IFLYNEPAL_NEWS_PLACE_META, true ) );
}

/**
 * The picture behind a single story's hero.
 *
 * The story's own featured image, falling back to the archive's hero so a
 * story published without one still opens on a photograph rather than on a
 * flat scrim.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_news_hero_image_url() {
	$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	return $url ? $url : iflynepal_news_archive_hero_image_url();
}
