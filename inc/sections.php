<?php
/**
 * The editorial sections — Articles and Blogs — and what tells them apart.
 *
 * Both are the same design: the same hero, the same category tabs, the same
 * card grid, the same pager, the same single. They differ in four things and
 * only four — which post type the loop holds, which taxonomy the tabs are built
 * from, which theme mods the hero reads, and what the copy calls a piece.
 *
 * So the templates are not copied. template-parts/articles/* renders both, and
 * asks this file which section it is drawing; whatever a template needs that is
 * not identical between the two comes from here. That is what keeps the Blogs
 * pages pixel-identical to the Articles ones: they are the same files.
 *
 * Articles are a post type of the theme's own (inc/cpts/article-cpt.php); blogs
 * are WordPress's `post` under its own categories and tags (inc/blogs.php).
 * News is deliberately not one of these — it shares the stylesheet but draws a
 * different page, with a ticker, a Top News band and no tab row.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The two sections, keyed by the name used everywhere else in the theme.
 *
 * @since 1.0.0
 *
 * @return array<string,array<string,string>> Section definitions.
 */
function iflynepal_sections() {
	return array(
		'articles' => array(
			'key'       => 'articles',
			'post_type' => IFLYNEPAL_ARTICLE_POST_TYPE,
			'category'  => IFLYNEPAL_ARTICLE_CATEGORY,
			'tag'       => IFLYNEPAL_ARTICLE_TAG,
		),
		'blogs'    => array(
			'key'       => 'blogs',
			'post_type' => 'post',
			'category'  => 'category',
			'tag'       => 'post_tag',
		),
	);
}

/**
 * The section a request belongs to.
 *
 * Answers for both halves of a section: the archive, a category, a tag, and a
 * single piece all report the same key, because all of them are drawn by the
 * same template parts.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Ask for a named section instead of the current one.
 * @return array<string,string>|null The definition, or null off both sections.
 */
function iflynepal_section( $key = '' ) {
	$sections = iflynepal_sections();

	if ( '' !== $key ) {
		return isset( $sections[ $key ] ) ? $sections[ $key ] : null;
	}

	if ( iflynepal_has_blogs() || iflynepal_has_blog() ) {
		return $sections['blogs'];
	}

	if ( iflynepal_has_articles() || iflynepal_has_article() ) {
		return $sections['articles'];
	}

	return null;
}

/**
 * The section key for a post, whichever section it belongs to.
 *
 * Read from the post rather than from the request, because a card in the
 * related row is drawn while the loop is on a post of that section and a
 * template part has no other way to know which taxonomy to label it with.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post|null $post Optional. Post. Defaults to the one in the loop.
 * @return array<string,string>|null The definition, or null for anything else.
 */
function iflynepal_section_for_post( $post = null ) {
	$type = get_post_type( $post );

	foreach ( iflynepal_sections() as $section ) {
		if ( $section['post_type'] === $type ) {
			return $section;
		}
	}

	return null;
}

/**
 * The current section's key, for the few places that need the name itself.
 *
 * @since 1.0.0
 *
 * @return string 'articles', 'blogs', or '' off both.
 */
function iflynepal_section_key() {
	$section = iflynepal_section();

	return $section ? $section['key'] : '';
}

/* ------------------------------------------------------------------- URLs */

/**
 * The section's archive URL: /articles/ or /blogs/.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return string Archive URL, empty when neither section is in play.
 */
function iflynepal_section_archive_url( $key = '' ) {
	$section = iflynepal_section( $key );

	if ( ! $section ) {
		return '';
	}

	return 'blogs' === $section['key']
		? iflynepal_blogs_archive_url()
		: iflynepal_articles_archive_url();
}

/**
 * The term being viewed, when one is.
 *
 * @since 1.0.0
 *
 * @return WP_Term|null The queried term, or null on the plain archive.
 */
function iflynepal_section_current_term() {
	if ( ! is_category() && ! is_tag() && ! is_tax() ) {
		return null;
	}

	$term = get_queried_object();

	return $term instanceof WP_Term ? $term : null;
}

/**
 * The categories the tab row is built from.
 *
 * Empty categories are left out: a tab that leads to "nothing found" is only a
 * dead end, and the client adds categories before they have anything filed
 * under them.
 *
 * Ordered by term id — creation order, which is the order the approved design's
 * tab row has them and the only sequence the client actually controls, a
 * hierarchical taxonomy having no drag order of its own.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return WP_Term[] Categories, in the order they were created.
 */
function iflynepal_section_categories( $key = '' ) {
	$section = iflynepal_section( $key );

	if ( ! $section ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => $section['category'],
			'hide_empty' => true,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * The first category a piece is filed under, as the card labels it.
 *
 * The same term the permalink uses, so the label above a card and the URL under
 * it agree.
 *
 * @since 1.0.0
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null The term, or null when the piece has no category.
 */
function iflynepal_section_primary_category( $post_id ) {
	$section = iflynepal_section_for_post( $post_id );

	if ( ! $section ) {
		return null;
	}

	$terms = get_the_terms( $post_id, $section['category'] );

	if ( is_wp_error( $terms ) || ! $terms ) {
		return null;
	}

	return $terms[0];
}

/* ------------------------------------------------------------------- hero */

/**
 * The photograph behind the section's archive hero.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return string Image URL.
 */
function iflynepal_section_hero_image_url( $key = '' ) {
	$section = iflynepal_section( $key );

	return ( $section && 'blogs' === $section['key'] )
		? iflynepal_blogs_hero_image_url()
		: iflynepal_articles_hero_image_url();
}

/**
 * The headline over the archive, with each plain word wrapped for the entrance.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return string Ready-to-print HTML.
 */
function iflynepal_section_hero_title_html( $key = '' ) {
	$section = iflynepal_section( $key );

	return ( $section && 'blogs' === $section['key'] )
		? iflynepal_blogs_hero_title_html()
		: iflynepal_articles_hero_title_html();
}

/**
 * The standfirst under the archive's headline.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return string The line, empty when the editor has cleared it.
 */
function iflynepal_section_hero_lead( $key = '' ) {
	$section = iflynepal_section( $key );

	return ( $section && 'blogs' === $section['key'] )
		? iflynepal_blogs_hero_lead()
		: iflynepal_articles_hero_lead();
}

/**
 * The grey hint inside the archive's search field.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return string
 */
function iflynepal_section_search_placeholder( $key = '' ) {
	$section = iflynepal_section( $key );

	return ( $section && 'blogs' === $section['key'] )
		? iflynepal_blogs_search_placeholder()
		: iflynepal_articles_search_placeholder();
}

/**
 * The photograph behind a single piece's hero.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_section_single_hero_image_url() {
	return iflynepal_has_blog()
		? iflynepal_blog_hero_image_url()
		: iflynepal_article_hero_image_url();
}

/**
 * The pieces the closing row offers next, from whichever section is being read.
 *
 * @since 1.0.0
 *
 * @return WP_Post[] Posts, at most IFLYNEPAL_ARTICLE_RELATED of them.
 */
function iflynepal_section_related_posts() {
	return iflynepal_has_blog()
		? iflynepal_blog_related()
		: iflynepal_article_related();
}

/* ----------------------------------------------------------------- labels */

/**
 * What the section's copy calls a piece, everywhere a template says so.
 *
 * Written out per section rather than built from a noun: a translator needs
 * whole sentences, and "No %s found." assembled at runtime cannot be translated
 * into a language that declines the noun.
 *
 * @since 1.0.0
 *
 * @param string $key Optional. Section key. Defaults to the current section.
 * @return array<string,string> Copy for that section, keyed by where it is used.
 */
function iflynepal_section_labels( $key = '' ) {
	$section = iflynepal_section( $key );

	if ( $section && 'blogs' === $section['key'] ) {
		return array(
			'archive'         => __( 'Blogs', 'iflynepal' ),
			'single'          => __( 'Blog', 'iflynepal' ),
			'categories_nav'  => __( 'Blog categories', 'iflynepal' ),
			'pages_nav'       => __( 'Blog pages', 'iflynepal' ),
			'search_label'    => __( 'Search blogs', 'iflynepal' ),
			'empty'           => __( 'No blogs found.', 'iflynepal' ),
			'browse_all'      => __( 'Browse every blog', 'iflynepal' ),
			'view_all'        => __( 'View all blogs', 'iflynepal' ),
			'aside_about'     => __( 'About this blog', 'iflynepal' ),
			'related_eyebrow' => __( 'From the blog', 'iflynepal' ),
			'related_lead'    => __( 'More travel tips for planning your Nepal trip, from the same shelf.', 'iflynepal' ),
		);
	}

	return array(
		'archive'         => __( 'Articles', 'iflynepal' ),
		'single'          => __( 'Article', 'iflynepal' ),
		'categories_nav'  => __( 'Article categories', 'iflynepal' ),
		'pages_nav'       => __( 'Article pages', 'iflynepal' ),
		'search_label'    => __( 'Search articles', 'iflynepal' ),
		'empty'           => __( 'No articles found.', 'iflynepal' ),
		'browse_all'      => __( 'Browse every article', 'iflynepal' ),
		'view_all'        => __( 'View all articles', 'iflynepal' ),
		'aside_about'     => __( 'About this article', 'iflynepal' ),
		'related_eyebrow' => __( 'From the articles', 'iflynepal' ),
		'related_lead'    => __( 'More travel tips for planning your Nepal trip, from the same shelf.', 'iflynepal' ),
	);
}

/**
 * "N articles match." — the line under a search headline.
 *
 * A sentence of its own per section for the reason the labels above are: the
 * plural is the translator's to decide, and it cannot be if the noun arrives as
 * a variable.
 *
 * @since 1.0.0
 *
 * @param int    $found How many pieces matched.
 * @param string $key   Optional. Section key. Defaults to the current section.
 * @return string
 */
function iflynepal_section_match_count( $found, $key = '' ) {
	$section = iflynepal_section( $key );
	$found   = (int) $found;

	if ( $section && 'blogs' === $section['key'] ) {
		return sprintf(
			/* translators: %s: number of matching blogs. */
			esc_html( _n( '%s blog matches.', '%s blogs match.', $found, 'iflynepal' ) ),
			esc_html( number_format_i18n( $found ) )
		);
	}

	return sprintf(
		/* translators: %s: number of matching articles. */
		esc_html( _n( '%s article matches.', '%s articles match.', $found, 'iflynepal' ) ),
		esc_html( number_format_i18n( $found ) )
	);
}
