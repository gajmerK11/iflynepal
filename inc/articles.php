<?php
/**
 * The Articles archive: its URLs, its query, and the pieces its templates draw.
 *
 * The post type itself is registered in inc/cpts/article-cpt.php. What lives
 * here is everything that turns that type into the archive the design shows —
 * the hand-written category rewrite rules, the twelve-per-page query, the
 * search, and the small render helpers the template parts call.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Articles per page, on the archive and on every category.
 *
 * Twelve is four full rows of the three-column grid, so the last row is never
 * left with a gap in it at the widest breakpoint.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLES_PER_PAGE = 12;

/**
 * The query variable the archive's search field uses.
 *
 * Not `s`. WordPress's own search variable turns any URL carrying it into a
 * search results page, which would take the request off the archive template
 * and lose the post type with it. A variable of the theme's own leaves the
 * archive in charge and is handed to the query as `s` in
 * iflynepal_articles_pre_get_posts().
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLES_SEARCH_VAR = 'ifn_search';

/* ------------------------------------------------------------------- URLs */

/**
 * Registers the rewrite rules for the category archives.
 *
 * These have to be written by hand, one pair per term. The post type's own
 * rewrite base is `articles/%article_category%`, which generates a rule
 * matching two path segments — so `/articles/trekking/` would otherwise be read
 * as the article `trekking` filed under the category `articles`, and never
 * reach the taxonomy at all.
 *
 * Both rules are added at the top of the list, and the paged one first: the
 * rules are evaluated in the order they are registered, and the un-paged rule
 * would otherwise swallow `/articles/trekking/page/2/` before the paged rule
 * was reached.
 *
 * Runs at priority 20, after the taxonomy exists at the default priority — the
 * term list cannot be read before it is registered.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_article_category_rewrites() {
	$terms = get_terms(
		array(
			'taxonomy'   => IFLYNEPAL_ARTICLE_CATEGORY,
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) || ! $terms ) {
		return;
	}

	foreach ( $terms as $term ) {
		add_rewrite_rule(
			'^articles/' . preg_quote( $term->slug, '/' ) . '/page/?([0-9]{1,})/?$',
			'index.php?' . IFLYNEPAL_ARTICLE_CATEGORY . '=' . $term->slug . '&paged=$matches[1]',
			'top'
		);

		add_rewrite_rule(
			'^articles/' . preg_quote( $term->slug, '/' ) . '/?$',
			'index.php?' . IFLYNEPAL_ARTICLE_CATEGORY . '=' . $term->slug,
			'top'
		);
	}
}
add_action( 'init', 'iflynepal_article_category_rewrites', 20 );

/**
 * Rewrites the rules whenever the category list changes.
 *
 * The rules above are generated from the terms, so a new, renamed or deleted
 * category leaves the stored set describing a list that no longer exists.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_flush_article_rewrites() {
	flush_rewrite_rules();
}
add_action( 'created_' . IFLYNEPAL_ARTICLE_CATEGORY, 'iflynepal_flush_article_rewrites' );
add_action( 'edited_' . IFLYNEPAL_ARTICLE_CATEGORY, 'iflynepal_flush_article_rewrites' );
add_action( 'delete_' . IFLYNEPAL_ARTICLE_CATEGORY, 'iflynepal_flush_article_rewrites' );

/*
 * And once when the theme is activated, since none of the rules above exist
 * until something registers the post type — which is this theme.
 */
add_action( 'after_switch_theme', 'iflynepal_flush_article_rewrites' );

/* ------------------------------------------------------------------ query */

/**
 * Shapes the main query on the Articles archive and its term archives.
 *
 * Two things: the page size, and the search. The search is handed to the query
 * as `s` together with the post type, because a term archive that is also a
 * search would otherwise widen to every post type on the site.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The query being prepared.
 * @return void
 */
function iflynepal_articles_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( IFLYNEPAL_ARTICLE_POST_TYPE )
		&& ! $query->is_tax( IFLYNEPAL_ARTICLE_CATEGORY )
		&& ! $query->is_tax( IFLYNEPAL_ARTICLE_TAG ) ) {
		return;
	}

	$query->set( 'posts_per_page', IFLYNEPAL_ARTICLES_PER_PAGE );

	$search = iflynepal_articles_search_term();

	if ( '' !== $search ) {
		$query->set( 's', $search );
		$query->set( 'post_type', IFLYNEPAL_ARTICLE_POST_TYPE );
	}
}
add_action( 'pre_get_posts', 'iflynepal_articles_pre_get_posts' );

/**
 * Whether the current request renders the Articles archive.
 *
 * The post type archive, a category and a tag all use the same template, so
 * all three answer yes — inc/enqueue.php and the hero both condition on this.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_articles() {
	return is_post_type_archive( IFLYNEPAL_ARTICLE_POST_TYPE )
		|| is_tax( IFLYNEPAL_ARTICLE_CATEGORY )
		|| is_tax( IFLYNEPAL_ARTICLE_TAG );
}

/**
 * What the visitor typed into the archive's search field.
 *
 * @since 1.0.0
 *
 * @return string The query, trimmed; empty when nothing was searched for.
 */
function iflynepal_articles_search_term() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- A public, idempotent search field; there is nothing to forge.
	if ( ! isset( $_GET[ IFLYNEPAL_ARTICLES_SEARCH_VAR ] ) ) {
		return '';
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- As above.
	return trim( sanitize_text_field( wp_unslash( $_GET[ IFLYNEPAL_ARTICLES_SEARCH_VAR ] ) ) );
}

/**
 * The Articles archive's own URL.
 *
 * @since 1.0.0
 *
 * @return string Archive URL, empty when the post type has no archive.
 */
function iflynepal_articles_archive_url() {
	$url = get_post_type_archive_link( IFLYNEPAL_ARTICLE_POST_TYPE );

	return $url ? $url : '';
}

/**
 * The term being viewed, when one is.
 *
 * @since 1.0.0
 *
 * @return WP_Term|null The queried term, or null on the full archive.
 */
function iflynepal_articles_current_term() {
	if ( ! is_tax( IFLYNEPAL_ARTICLE_CATEGORY ) && ! is_tax( IFLYNEPAL_ARTICLE_TAG ) ) {
		return null;
	}

	$term = get_queried_object();

	return $term instanceof WP_Term ? $term : null;
}

/**
 * The categories the tab row is built from.
 *
 * Empty categories are left out: a tab that leads to "no articles found" is
 * only a dead end, and the client adds categories before they have anything
 * filed under them.
 *
 * Ordered by term id, which is the order they were created in and the order the
 * approved design's tab row has them — an editorial run from Trekking through
 * to Travel Tips rather than an alphabetical one. A hierarchical taxonomy has
 * no drag order of its own, so creation order is the only sequence the client
 * actually controls.
 *
 * @since 1.0.0
 *
 * @return WP_Term[] Categories, in the order they were created.
 */
function iflynepal_articles_categories() {
	$terms = get_terms(
		array(
			'taxonomy'   => IFLYNEPAL_ARTICLE_CATEGORY,
			'hide_empty' => true,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Whether the current request renders a single article.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_article() {
	return is_singular( IFLYNEPAL_ARTICLE_POST_TYPE );
}

/**
 * The picture behind a single article's hero.
 *
 * The article's own featured image, falling back to the archive's hero so a
 * piece published without one still opens on a photograph rather than on a
 * flat scrim.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_article_hero_image_url() {
	$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	return $url ? $url : iflynepal_articles_hero_image_url();
}

/* --------------------------------------------------------------- the card */

/**
 * The first category an article is filed under, as the card labels it.
 *
 * The same term the permalink uses, so the label above a card and the URL
 * under it agree.
 *
 * @since 1.0.0
 *
 * @param int $post_id Article ID.
 * @return WP_Term|null The term, or null when the article has no category.
 */
function iflynepal_article_primary_category( $post_id ) {
	return iflynepal_section_primary_category( $post_id );
}

/**
 * The author's initials, for the small disc on the card.
 *
 * The design draws a monogram rather than a photograph, so no avatar is
 * requested — and this site's authors are a house byline rather than people
 * with Gravatars.
 *
 * The first two characters of the name, exactly as they are typed. Both the
 * Articles and the News designs draw "iF" for "iFly Nepal", which is the
 * brand's own wordmark rather than a pair of initials — "IN" would be right
 * for a person and wrong for the only byline this site has, and the case is
 * kept for the same reason.
 *
 * @since 1.0.0
 *
 * @param string $name Display name.
 * @return string Up to two characters; empty when the name is.
 */
function iflynepal_article_initials( $name ) {
	$name = trim( wp_strip_all_tags( $name ) );

	if ( '' === $name ) {
		return '';
	}

	return mb_substr( $name, 0, 2 );
}

/* --------------------------------------------------------- the pagination */

/**
 * The page numbers the pager shows, with gaps marked.
 *
 * The shape paginate_links() produces with its defaults — the first and last
 * page always, two either side of the current one, and one ellipsis for each
 * run that is left out. Built here rather than parsing paginate_links()'s HTML
 * back apart, because the design's markup is nothing like what it emits.
 *
 * @since 1.0.0
 *
 * @param int $current Page being viewed.
 * @param int $total   Total pages.
 * @return array<int,int|null> Page numbers in order; null marks an ellipsis.
 */
function iflynepal_articles_pagination_numbers( $current, $total ) {
	$numbers = array();
	$gap     = false;

	for ( $page = 1; $page <= $total; $page++ ) {
		if ( 1 === $page || $page === $total || abs( $page - $current ) <= 2 ) {
			$numbers[] = $page;
			$gap       = false;

			continue;
		}

		if ( ! $gap ) {
			$numbers[] = null;
			$gap       = true;
		}
	}

	return $numbers;
}

/**
 * A pager link, with the search carried across it.
 *
 * Built by get_pagenum_link(), which works from the current URL and so keeps
 * the query string it already has — that is what carries `ifn_search` from one
 * page of results to the next.
 *
 * @since 1.0.0
 *
 * @param int $page Page number.
 * @return string URL.
 */
function iflynepal_articles_page_url( $page ) {
	return get_pagenum_link( max( 1, (int) $page ) );
}
