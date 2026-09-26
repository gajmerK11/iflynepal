<?php
/**
 * Sorts every Polylang-translated post type's and taxonomy's admin list
 * table so a translation sits next to the item it translates, instead of
 * wherever its own date/name happens to fall.
 *
 * Polylang links a group of translations by giving them all a row in
 * `wp_term_relationships` against one shared term in an internal taxonomy —
 * `post_translations` for posts, `term_translations` for terms (the object
 * id there is a term id, not a post id; Polylang reuses the relationships
 * table for both). Ordering by that shared term id first, and by the row's
 * own date/name only as the tie-break inside one group, is what clusters a
 * translation pair together without needing to know which two rows belong
 * together ahead of time.
 *
 * Deliberately narrow: only the ordinary "browse the list" request is
 * re-sorted. A search, or any column the admin explicitly clicked to sort
 * by, is left alone — grouping a search result set would bury the very
 * match being searched for next to an unrelated translation.
 *
 * A translation pair can still land on opposite sides of a page break; nothing
 * server-side can prevent that once a list is paginated at all. In exchange for
 * that one edge case, every other pair reads as adjacent instead of scattered
 * across pages sorted purely by date.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the current admin request is a plain "browse the list" load —
 * no search, no explicit column sort — that grouping should apply to.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_translation_grouping_applies() {
	return is_admin()
		&& ! wp_doing_ajax()
		&& empty( $_GET['orderby'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only, decides sort order, not a state change.
		&& empty( $_GET['s'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Same.
}

/* -------------------------------------------------------------- posts */

/**
 * Groups a translated post type's list table by translation group.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The main admin list query.
 * @return void
 */
function iflynepal_group_post_translations( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || ! iflynepal_translation_grouping_applies() ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || 'edit' !== $screen->base ) {
		return;
	}

	if ( ! function_exists( 'PLL' ) || ! PLL() instanceof PLL_Admin_Base ) {
		return;
	}

	if ( ! PLL()->model->is_translated_post_type( (string) $query->get( 'post_type' ) ) ) {
		return;
	}

	add_filter( 'posts_clauses', 'iflynepal_group_post_translations_clauses' );
}
add_action( 'pre_get_posts', 'iflynepal_group_post_translations' );

/**
 * The join and ORDER BY that does the actual grouping.
 *
 * Self-removing: added only for the one query it was hooked for, so it
 * never reaches an unrelated query run later in the same request.
 *
 * @since 1.0.0
 *
 * @param string[] $clauses Query clause pieces, keyed by clause name.
 * @return string[] Filtered clauses.
 */
function iflynepal_group_post_translations_clauses( $clauses ) {
	remove_filter( 'posts_clauses', 'iflynepal_group_post_translations_clauses' );

	global $wpdb;

	/*
	 * A plain two-table join here — term_relationships joined straight to
	 * wp_posts.ID — fans out to one row per taxonomy the post belongs to
	 * (package type, category, language, translation group, all share that
	 * one table), because the taxonomy filter only lives on the *second*
	 * join and a LEFT JOIN keeps the first join's row regardless of whether
	 * the second one matched. Pre-filtering to the one taxonomy that
	 * matters inside a subquery, before it ever meets wp_posts, is what
	 * keeps this to at most one row per post.
	 */
	$clauses['join'] .= " LEFT JOIN ("
		. " SELECT tr.object_id, tt.term_id"
		. " FROM {$wpdb->term_relationships} AS tr"
		. " INNER JOIN {$wpdb->term_taxonomy} AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'post_translations'"
		. " ) AS ifn_ptt ON ifn_ptt.object_id = {$wpdb->posts}.ID";

	$clauses['orderby'] = "ifn_ptt.term_id IS NULL, ifn_ptt.term_id DESC, {$wpdb->posts}.post_date ASC";

	return $clauses;
}

/* -------------------------------------------------------------- terms */

/**
 * Groups a translated taxonomy's term list table the same way.
 *
 * @since 1.0.0
 *
 * @param string[] $clauses    Query clause pieces.
 * @param string[] $taxonomies Taxonomies being queried.
 * @return string[] Filtered clauses.
 */
function iflynepal_group_term_translations_clauses( $clauses, $taxonomies ) {
	if ( ! is_admin() || ! iflynepal_translation_grouping_applies() ) {
		return $clauses;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || 'edit-tags' !== $screen->base ) {
		return $clauses;
	}

	if ( ! function_exists( 'PLL' ) || ! PLL() instanceof PLL_Admin_Base ) {
		return $clauses;
	}

	if ( 1 !== count( $taxonomies ) || ! PLL()->model->is_translated_taxonomy( $taxonomies[0] ) ) {
		return $clauses;
	}

	global $wpdb;

	// Same subquery reasoning as iflynepal_group_post_translations_clauses() above.
	$clauses['join'] .= " LEFT JOIN ("
		. " SELECT tr.object_id, tt.term_id"
		. " FROM {$wpdb->term_relationships} AS tr"
		. " INNER JOIN {$wpdb->term_taxonomy} AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'term_translations'"
		. " ) AS ifn_ttt ON ifn_ttt.object_id = t.term_id";

	/*
	 * Unlike posts_clauses, WP_Term_Query does not prepend 'ORDER BY' to
	 * this string itself (it is already baked into the default clause
	 * before this filter runs), and it appends its own trailing ASC/DESC
	 * after whatever this returns — hence the keyword here and no explicit
	 * direction on the last column, or the query comes out as literal
	 * "ORDER BY … t.name ASC ASC", which is a syntax error.
	 */
	$clauses['orderby'] = 'ORDER BY ifn_ttt.term_id IS NULL, ifn_ttt.term_id DESC, t.name';

	return $clauses;
}
add_filter( 'terms_clauses', 'iflynepal_group_term_translations_clauses', 10, 2 );
