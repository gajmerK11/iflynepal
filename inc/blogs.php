<?php
/**
 * The Blogs section: WordPress's own posts, wearing the Articles design.
 *
 * The client keeps two editorial runs. Articles are a post type of the theme's
 * own; blogs are the install's ordinary posts, under the ordinary category and
 * tag taxonomies, so anything a plugin or an import writes as a post lands here
 * without translation. What this file does is give that run the same shape the
 * Articles section has:
 *
 *   /blogs/                          the archive (the page set as Posts page)
 *   /blogs/{category}/               a category
 *   /blogs/{category}/page/2/        a category, paged
 *   /blogs/{category}/{slug}/        a post
 *   /blog-tag/{slug}/                a tag
 *
 * Two halves. The category and tag bases are moved by filtering the arguments
 * core registers those taxonomies with, which is enough for their archives —
 * core writes the rules from the base it is given. The post's own permalink is
 * not: the site's permalink structure is `/%postname%/` and changing it is a
 * site setting rather than a theme's business, so the two-segment URL is built
 * by iflynepal_blog_permalink() and matched by the rules below.
 *
 * The pages themselves are template-parts/articles/* — the same files the
 * Articles section draws, asked by inc/sections.php which section they are
 * drawing. That is deliberate: the two designs are the same design, and one set
 * of templates is the only way they stay that way.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The path every blog URL sits under.
 *
 * It matches the slug of the page set as Settings > Reading > Posts page, which
 * is what puts the archive itself at /blogs/. Renaming that page moves the
 * archive and leaves the categories and posts here, so the two are kept in step
 * by hand rather than by reading the page: a rewrite base has to be a constant
 * string at `init`, before any query has run.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_BLOGS_BASE = 'blogs';

/**
 * The base a blog tag's archive sits under.
 *
 * Off a path of its own, as an article tag is: a tag is not a section of the
 * magazine, so it does not live inside one.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_BLOGS_TAG_BASE = 'blog-tag';

/**
 * Blogs per page, on the archive and on every category.
 *
 * Twelve, as the Articles archive has it — four full rows of the three-column
 * grid, so the last row is never left with a gap at the widest breakpoint.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_BLOGS_PER_PAGE = 12;

/* ------------------------------------------------------------------- URLs */

/**
 * The path a given language's blog URLs sit under.
 *
 * Taken from the slug of that language's own Posts page — Polylang translates
 * `page_for_posts` per language, so French's page (however it is named) gives
 * back its own base rather than the English constant. Falls back to
 * IFLYNEPAL_BLOGS_BASE when Polylang is inactive, the language is unknown, or
 * that language has no Posts page of its own, which keeps a single-language
 * install on the plain constant.
 *
 * @since 1.0.0
 *
 * @param string $lang Optional. A Polylang language slug. Defaults to the
 *                      current language.
 * @return string The base segment, without slashes.
 */
function iflynepal_blogs_base( $lang = '' ) {
	$page_id = (int) get_option( 'page_for_posts' );

	if ( ! $page_id ) {
		return IFLYNEPAL_BLOGS_BASE;
	}

	if ( function_exists( 'pll_get_post' ) ) {
		if ( '' === $lang && function_exists( 'pll_current_language' ) ) {
			$lang = pll_current_language();
		}

		if ( $lang ) {
			$translated_id = pll_get_post( $page_id, $lang );

			if ( $translated_id ) {
				$page_id = $translated_id;
			}
		}
	}

	$permalink = get_permalink( $page_id );

	if ( ! $permalink ) {
		return IFLYNEPAL_BLOGS_BASE;
	}

	$path = trim( (string) wp_parse_url( $permalink, PHP_URL_PATH ), '/' );

	if ( '' === $path ) {
		return IFLYNEPAL_BLOGS_BASE;
	}

	$segments = explode( '/', $path );
	$base     = end( $segments );

	return '' !== $base ? $base : IFLYNEPAL_BLOGS_BASE;
}

/**
 * Moves the category and tag archives under the Blogs section.
 *
 * Core registers both taxonomies itself, early and without a way to pass
 * arguments in, so they are adjusted on the way past. `hierarchical` is turned
 * off in the rewrite — not in the taxonomy, which stays a tree in the editor —
 * so the rule core writes matches one path segment rather than a nested path:
 * /blogs/trekking/ is a category and /blogs/trekking/a-post/ is a post, and the
 * two would otherwise be the same pattern.
 *
 * @since 1.0.0
 *
 * @param array  $args     Arguments the taxonomy is being registered with.
 * @param string $taxonomy Taxonomy key.
 * @return array Filtered arguments.
 */
function iflynepal_blog_taxonomy_args( $args, $taxonomy ) {
	if ( 'category' === $taxonomy ) {
		$args['rewrite'] = array(
			'slug'         => IFLYNEPAL_BLOGS_BASE,
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_CATEGORIES,
		);
	}

	if ( 'post_tag' === $taxonomy ) {
		$args['rewrite'] = array(
			'slug'       => IFLYNEPAL_BLOGS_TAG_BASE,
			'with_front' => false,
			'ep_mask'    => EP_TAGS,
		);
	}

	return $args;
}
add_filter( 'register_taxonomy_args', 'iflynepal_blog_taxonomy_args', 10, 2 );

/**
 * Registers the rules that resolve /blogs/{category}/{slug}/.
 *
 * The category segment is matched and thrown away: a post's name is unique on
 * its own, and not checking the segment against the term list is what lets a
 * post that has been re-filed still answer on its old URL rather than 404 while
 * a visitor's bookmark catches up. It is the same trade the Articles type makes
 * with its `%article_category%` placeholder.
 *
 * Registered at the top of the list, longest first, because the rules are
 * evaluated in order and a shorter pattern would swallow the paths the longer
 * ones are for.
 *
 * Core's own taxonomy registration (iflynepal_blog_taxonomy_args() above) only
 * ever writes a category rule for IFLYNEPAL_BLOGS_BASE with no language prefix
 * — Polylang prefixes that one for every other language itself, because it is
 * a rule core generated through the taxonomy machinery Polylang watches. These
 * rules are not: add_rewrite_rule() has no such hook, so both the language
 * prefix (Polylang's "/fr/") and the localized base ("blogues") have to be
 * written into the pattern here by hand, one set per language.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_blog_rewrites() {
	$languages = function_exists( 'pll_languages_list' ) ? pll_languages_list() : array( '' );

	foreach ( $languages as $lang ) {
		$lang_prefix = '';

		if ( $lang && function_exists( 'pll_home_url' ) ) {
			$lang_prefix = trim( (string) wp_parse_url( pll_home_url( $lang ), PHP_URL_PATH ), '/' );
		}

		$blogs_base = iflynepal_blogs_base( $lang );
		$base       = ( '' !== $lang_prefix ? $lang_prefix . '/' : '' ) . $blogs_base;

		$post_base = '^' . $base . '/[^/]+/([^/]+)';

		// A post split across pages with <!--nextpage-->, and its comment pages.
		add_rewrite_rule( $post_base . '/page/?([0-9]{1,})/?$', 'index.php?name=$matches[1]&page=$matches[2]', 'top' );
		add_rewrite_rule( $post_base . '/comment-page-([0-9]{1,})/?$', 'index.php?name=$matches[1]&cpage=$matches[2]', 'top' );
		add_rewrite_rule( $post_base . '/embed/?$', 'index.php?name=$matches[1]&embed=true', 'top' );
		add_rewrite_rule( $post_base . '/?$', 'index.php?name=$matches[1]', 'top' );

		// Core already writes this one for the default language's own base,
		// unprefixed, and Polylang prefixes it for every other language.
		if ( '' === $lang_prefix && IFLYNEPAL_BLOGS_BASE === $blogs_base ) {
			continue;
		}

		$cat_base = '^' . $base . '/([^/]+)';

		add_rewrite_rule( $cat_base . '/page/?([0-9]{1,})/?$', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( $cat_base . '/embed/?$', 'index.php?category_name=$matches[1]&embed=true', 'top' );
		add_rewrite_rule( $cat_base . '/?$', 'index.php?category_name=$matches[1]', 'top' );
	}
}
add_action( 'init', 'iflynepal_blog_rewrites' );

/**
 * Localizes a category archive's URL to the current language's blogs base.
 *
 * Get_term_link() builds every category URL from the one slug core's taxonomy
 * registration was given — IFLYNEPAL_BLOGS_BASE — because that registration
 * cannot itself vary per request. This swaps that leading segment for the
 * current language's own base after the fact, which is what the extra rules
 * iflynepal_blog_rewrites() adds are there to answer.
 *
 * @since 1.0.0
 *
 * @param string  $url      The category's URL.
 * @param WP_Term $term     The category.
 * @param string  $taxonomy The term's taxonomy.
 * @return string Filtered URL.
 */
function iflynepal_blog_term_link( $url, $term, $taxonomy ) {
	if ( 'category' !== $taxonomy ) {
		return $url;
	}

	$term_id = is_object( $term ) ? (int) $term->term_id : (int) $term;
	$lang    = function_exists( 'pll_get_term_language' ) ? pll_get_term_language( $term_id ) : '';
	$base    = iflynepal_blogs_base( (string) $lang );

	if ( IFLYNEPAL_BLOGS_BASE === $base ) {
		return $url;
	}

	$path = (string) wp_parse_url( $url, PHP_URL_PATH );

	if ( 0 !== strpos( $path, '/' . IFLYNEPAL_BLOGS_BASE . '/' ) ) {
		return $url;
	}

	$rest = substr( $path, strlen( '/' . IFLYNEPAL_BLOGS_BASE ) );

	return str_replace( $path, '/' . $base . $rest, $url );
}
add_filter( 'term_link', 'iflynepal_blog_term_link', 10, 3 );

/**
 * Builds a post's permalink under its category.
 *
 * A post with several categories is filed under the first one returned, which is
 * the lowest term id — stable for a given post, so its URL does not move about
 * on its own. A post with none falls back to `uncategorized`, which is the term
 * core files it under anyway; the rewrite rule does not check the segment, so
 * such a URL still resolves.
 *
 * Pages, attachments and every other type are left alone: only `post` is a blog.
 *
 * @since 1.0.0
 *
 * @param string  $permalink The post's permalink.
 * @param WP_Post $post      The post.
 * @return string Filtered permalink.
 */
function iflynepal_blog_permalink( $permalink, $post ) {
	if ( ! $post instanceof WP_Post || 'post' !== $post->post_type ) {
		return $permalink;
	}

	// Drafts and pending posts carry a query-string preview URL; leave it be.
	if ( ! in_array( $post->post_status, array( 'publish', 'private', 'future' ), true ) ) {
		return $permalink;
	}

	$terms = get_the_terms( $post->ID, 'category' );
	$slug  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'uncategorized';

	// The post's own language, not whichever language the current request
	// happens to be in — a French post's link stays under the French base
	// even when it is printed on an English page (a "same post in other
	// languages" widget, say).
	$lang = function_exists( 'pll_get_post_language' ) ? pll_get_post_language( $post->ID ) : '';

	return user_trailingslashit(
		home_url( iflynepal_blogs_base( (string) $lang ) . '/' . $slug . '/' . $post->post_name )
	);
}
add_filter( 'post_link', 'iflynepal_blog_permalink', 10, 2 );

/**
 * Sends a post's old one-segment URL on to its place under /blogs/.
 *
 * The site's permalink structure is still `/%postname%/`, so core's own rule
 * goes on answering /a-post/ with the post — two URLs for one piece, which is
 * a duplicate rather than a courtesy. Core's canonical redirect does not close
 * it: as far as it is concerned the request matched the structure it was told
 * about. So the comparison is made here, against the permalink this theme
 * builds, and anything that is not already at it is moved there permanently.
 *
 * Previews, feeds, embeds and the admin are left alone — none of them is a URL
 * a reader arrives at, and a preview has no permalink to be at yet.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_blog_canonical_redirect() {
	if ( is_admin() || ! is_singular( 'post' ) || is_preview() || is_embed() || is_feed() || is_customize_preview() ) {
		return;
	}

	$permalink = get_permalink();

	if ( ! $permalink || ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$requested = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
	$current   = isset( $requested['path'] ) ? untrailingslashit( $requested['path'] ) : '';
	$target    = untrailingslashit( (string) wp_parse_url( $permalink, PHP_URL_PATH ) );

	if ( '' === $current || $current === $target ) {
		return;
	}

	// A post split over pages keeps the page it was asked for.
	$page = (int) get_query_var( 'page' );

	if ( $page > 1 ) {
		$permalink = trailingslashit( $permalink ) . user_trailingslashit( $page, 'single_paged' );
	}

	if ( ! empty( $requested['query'] ) ) {
		$permalink .= '?' . $requested['query'];
	}

	wp_safe_redirect( $permalink, 301 );
	exit;
}
add_action( 'template_redirect', 'iflynepal_blog_canonical_redirect' );

/**
 * Rewrites the rules whenever the theme is switched to.
 *
 * The taxonomy bases above only exist while this theme is active, so the stored
 * rules describe the previous theme's URLs until they are written again.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_flush_blog_rewrites() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'iflynepal_flush_blog_rewrites' );

/* ------------------------------------------------------------------ query */

/**
 * Shapes the main query on the Blogs archive, its categories and its tags.
 *
 * The page size, and the search — the search handed to the query as `s`
 * together with the post type, because a category that is also a search would
 * otherwise widen to every post type on the site.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The query being prepared.
 * @return void
 */
function iflynepal_blogs_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_home() && ! $query->is_category() && ! $query->is_tag() ) {
		return;
	}

	$query->set( 'posts_per_page', IFLYNEPAL_BLOGS_PER_PAGE );

	$search = iflynepal_articles_search_term();

	if ( '' !== $search ) {
		$query->set( 's', $search );
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_get_posts', 'iflynepal_blogs_pre_get_posts' );

/**
 * Whether the current request renders the Blogs archive.
 *
 * The posts page, a category and a tag all use the same template, so all three
 * answer yes — inc/enqueue.php and the hero both condition on this.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_blogs() {
	return is_home() || is_category() || is_tag();
}

/**
 * Whether the current request renders a single blog post.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_blog() {
	return is_singular( 'post' );
}

/**
 * The Blogs archive's own URL.
 *
 * The page assigned as the Posts page, which is what /blogs/ is. Falling back
 * to the base itself when no page is assigned — the archive is then the front
 * page and this is still where its categories point.
 *
 * @since 1.0.0
 *
 * @return string Archive URL.
 */
function iflynepal_blogs_archive_url() {
	$page_id = (int) get_option( 'page_for_posts' );

	if ( $page_id ) {
		$url = get_permalink( $page_id );

		if ( $url ) {
			return $url;
		}
	}

	return home_url( user_trailingslashit( IFLYNEPAL_BLOGS_BASE ) );
}

/**
 * The picture behind a single blog post's hero.
 *
 * The post's own featured image, falling back to the archive's hero so a piece
 * published without one still opens on a photograph rather than on a flat scrim.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_blog_hero_image_url() {
	$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	return $url ? $url : iflynepal_blogs_hero_image_url();
}

/**
 * The posts the closing row offers next.
 *
 * Same category first, newest first, this post excluded. Short of four, the
 * rest of the archive tops the row up rather than leaving a gap in a two-by-two
 * grid — the Articles section's rule, on the Blogs section's taxonomy.
 *
 * @since 1.0.0
 *
 * @return WP_Post[] Posts, at most IFLYNEPAL_ARTICLE_RELATED of them.
 */
function iflynepal_blog_related() {
	return iflynepal_section_related( 'post', 'category' );
}
