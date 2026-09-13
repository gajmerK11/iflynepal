<?php
/**
 * Articles post type, its two taxonomies and the URLs they produce.
 *
 * The arrangement is the one used by the cloudcolleague theme's Articles type,
 * carried over unchanged in shape:
 *
 *   /articles/                        the archive
 *   /articles/{category}/             a category
 *   /articles/{category}/page/2/      a category, paged
 *   /articles/{category}/{slug}/      an article
 *   /article-tag/{slug}/              a tag
 *
 * The category sits inside the article's own permalink, which is what the
 * `%article_category%` placeholder in the rewrite slug is for — WordPress does
 * not resolve it on its own, so iflynepal_article_permalink() below swaps in
 * the term. The category archive URLs collide with that pattern and have to be
 * registered by hand; those rules live in inc/setup.php beside the rest of the
 * theme's query work.
 *
 * Registering a public post type in a theme has a consequence worth knowing,
 * the same one recorded on the Testimonials type: switch the theme away and
 * the posts stay in the database but stop being registered, so every URL above
 * begins to 404. The type belongs in a plugin the day the client wants it to
 * outlive the theme.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The post type's key.
 *
 * Plural, and unprefixed, because it is in every article URL: `articles` reads
 * as a section of the site in a way `iflynepal_article` does not. The trade is
 * the usual one for an unprefixed key — a plugin registering the same key wins
 * or loses by load order — and it is accepted here because the design, the
 * body classes and the archive path all say "articles".
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLE_POST_TYPE = 'articles';

/**
 * The category taxonomy's key.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLE_CATEGORY = 'article_category';

/**
 * The tag taxonomy's key.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLE_TAG = 'article_tag';

/**
 * The capabilities the Articles screens are gated on.
 *
 * Page capabilities rather than post ones, for the reason recorded on the
 * Testimonials type: every `*_posts` capability has been removed from the
 * administrator role on this install, so a type or taxonomy left on the
 * defaults registers fine and is then pruned out of the admin menu — or, for a
 * taxonomy, leaves the category box unusable, since `assign_terms` defaults to
 * `edit_posts`. "Can edit Pages" is the right bar for editorial content here.
 *
 * @since 1.0.0
 *
 * @return array<string,string> Taxonomy capability map.
 */
function iflynepal_article_term_caps() {
	return array(
		'manage_terms' => 'edit_pages',
		'edit_terms'   => 'edit_pages',
		'delete_terms' => 'edit_pages',
		'assign_terms' => 'edit_pages',
	);
}

/**
 * Registers the Articles post type and its taxonomies.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_article_cpt() {
	register_post_type(
		IFLYNEPAL_ARTICLE_POST_TYPE,
		array(
			'labels'          => array(
				'name'               => __( 'Articles', 'iflynepal' ),
				'singular_name'      => __( 'Article', 'iflynepal' ),
				'add_new'            => __( 'Add New', 'iflynepal' ),
				'add_new_item'       => __( 'Add New Article', 'iflynepal' ),
				'edit_item'          => __( 'Edit Article', 'iflynepal' ),
				'new_item'           => __( 'New Article', 'iflynepal' ),
				'view_item'          => __( 'View Article', 'iflynepal' ),
				'view_items'         => __( 'View Articles', 'iflynepal' ),
				'search_items'       => __( 'Search Articles', 'iflynepal' ),
				'not_found'          => __( 'No articles found', 'iflynepal' ),
				'not_found_in_trash' => __( 'No articles found in trash', 'iflynepal' ),
				'all_items'          => __( 'All Articles', 'iflynepal' ),
				'menu_name'          => __( 'Articles', 'iflynepal' ),
			),
			'public'          => true,
			'has_archive'     => 'articles',
			'show_in_rest'    => true,
			'menu_position'   => 21,
			'menu_icon'       => 'dashicons-text-page',
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields' ),
			'taxonomies'      => array( IFLYNEPAL_ARTICLE_CATEGORY, IFLYNEPAL_ARTICLE_TAG ),

			/*
			 * `%article_category%` is not a placeholder WordPress knows. It
			 * survives into the generated permalink and is replaced by
			 * iflynepal_article_permalink() below; the matching rewrite rule
			 * treats that segment as one more path component, which is why an
			 * article resolves whichever category it is filed under.
			 */
			'rewrite'         => array(
				'slug'       => 'articles/%article_category%',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		IFLYNEPAL_ARTICLE_CATEGORY,
		IFLYNEPAL_ARTICLE_POST_TYPE,
		array(
			'labels'            => array(
				'name'          => __( 'Article Categories', 'iflynepal' ),
				'singular_name' => __( 'Article Category', 'iflynepal' ),
				'search_items'  => __( 'Search Categories', 'iflynepal' ),
				'all_items'     => __( 'All Categories', 'iflynepal' ),
				'edit_item'     => __( 'Edit Category', 'iflynepal' ),
				'update_item'   => __( 'Update Category', 'iflynepal' ),
				'add_new_item'  => __( 'Add New Category', 'iflynepal' ),
				'new_item_name' => __( 'New Category Name', 'iflynepal' ),
				'menu_name'     => __( 'Categories', 'iflynepal' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'capabilities'      => iflynepal_article_term_caps(),

			/*
			 * The term archive is /articles/{slug}/, one level under the post
			 * type archive rather than off a taxonomy base of its own — the
			 * category tabs on the archive read as part of that section. The
			 * rules WordPress generates from this are shadowed by the post
			 * type's own; see iflynepal_article_category_rewrites().
			 */
			'rewrite'           => array(
				'slug'         => 'articles',
				'with_front'   => false,
				'hierarchical' => false,
			),
		)
	);

	register_taxonomy(
		IFLYNEPAL_ARTICLE_TAG,
		IFLYNEPAL_ARTICLE_POST_TYPE,
		array(
			'labels'            => array(
				'name'          => __( 'Article Tags', 'iflynepal' ),
				'singular_name' => __( 'Article Tag', 'iflynepal' ),
				'search_items'  => __( 'Search Tags', 'iflynepal' ),
				'all_items'     => __( 'All Tags', 'iflynepal' ),
				'edit_item'     => __( 'Edit Tag', 'iflynepal' ),
				'update_item'   => __( 'Update Tag', 'iflynepal' ),
				'add_new_item'  => __( 'Add New Tag', 'iflynepal' ),
				'new_item_name' => __( 'New Tag Name', 'iflynepal' ),
				'menu_name'     => __( 'Tags', 'iflynepal' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'capabilities'      => iflynepal_article_term_caps(),

			// Off a base of its own: a tag is not a section of the magazine.
			'rewrite'           => array(
				'slug'       => 'article-tag',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'iflynepal_register_article_cpt' );

/**
 * Fills the `%article_category%` segment of an article's permalink.
 *
 * An article with several categories is filed under the first one returned,
 * which is the lowest term ID — stable for a given article, so its URL does not
 * move about on its own. An article with none falls back to `uncategorized`,
 * matching the placeholder cloudcolleague uses; the rewrite rule does not check
 * the segment against the term list, so such a URL still resolves.
 *
 * @since 1.0.0
 *
 * @param string  $post_link The post's permalink.
 * @param WP_Post $post      The post.
 * @return string Filtered permalink.
 */
function iflynepal_article_permalink( $post_link, $post ) {
	if ( IFLYNEPAL_ARTICLE_POST_TYPE !== $post->post_type ) {
		return $post_link;
	}

	if ( false === strpos( $post_link, '%article_category%' ) ) {
		return $post_link;
	}

	$terms = get_the_terms( $post->ID, IFLYNEPAL_ARTICLE_CATEGORY );
	$slug  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'uncategorized';

	return str_replace( '%article_category%', $slug, $post_link );
}
add_filter( 'post_type_link', 'iflynepal_article_permalink', 10, 2 );
