<?php
/**
 * Testimonials post type.
 *
 * One traveller review per post. Everything an editor fills in lives in a meta
 * box (inc/meta-boxes/class-ifly-nepal-testimonial-meta-box.php). There is no
 * title field: the title is generated from the page the review is assigned to,
 * as "Home Testimonial 1", so the admin list reads as an ordered set per page
 * without anyone having to name anything.
 *
 * The type is registered by the theme at the developer's instruction. The
 * consequence is worth knowing: theme_mods and post types registered in a theme
 * both stop working when the theme is switched — the posts stay in the database
 * but become invisible, because nothing is registering the type any more.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The post type's key.
 *
 * Prefixed rather than a bare `testimonial`, which is a common enough slug for
 * a plugin to claim it. WordPress caps a post type key at 20 characters, which
 * `iflynepal_testimonial` overruns by one, so the short form of the prefix is
 * used here.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TESTIMONIAL_POST_TYPE = 'ifly_testimonial';

/**
 * Registers the Testimonials post type.
 *
 * Not public: a testimonial is a fragment shown inside a section, never a page
 * of its own. Giving it a URL would put a thin, near-empty page in the index
 * for every review, and leave that page to 404 the day the type stops being
 * registered. `show_ui` still gives it a full admin screen.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_testimonial_cpt() {
	register_post_type(
		IFLYNEPAL_TESTIMONIAL_POST_TYPE,
		array(
			'labels'              => array(
				'name'               => __( 'Testimonials', 'iflynepal' ),
				'singular_name'      => __( 'Testimonial', 'iflynepal' ),
				'add_new'            => __( 'Add New', 'iflynepal' ),
				'add_new_item'       => __( 'Add New Testimonial', 'iflynepal' ),
				'edit_item'          => __( 'Edit Testimonial', 'iflynepal' ),
				'new_item'           => __( 'New Testimonial', 'iflynepal' ),
				'view_item'          => __( 'View Testimonial', 'iflynepal' ),
				'search_items'       => __( 'Search Testimonials', 'iflynepal' ),
				'not_found'          => __( 'No testimonials found', 'iflynepal' ),
				'not_found_in_trash' => __( 'No testimonials found in trash', 'iflynepal' ),
				'all_items'          => __( 'All Testimonials', 'iflynepal' ),
				'menu_name'          => __( 'Testimonials', 'iflynepal' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-format-quote',

			/*
			 * Managed by whoever manages Pages, rather than by whoever manages
			 * Posts. This is not decoration: every `*_posts` capability has been
			 * removed from the administrator role on this install, so a post
			 * type left on the default `post` capability type registers fine and
			 * is then pruned out of the admin menu for having a capability
			 * nobody holds. Page capabilities are intact for both administrator
			 * and editor, and "can edit Pages" is the right bar for a marketing
			 * fragment anyway.
			 */
			'capability_type'     => 'page',
			'map_meta_cap'        => true,

			/*
			 * Neither the editor nor the title is supported. The review body is a
			 * meta field, so a second free-form content area would only be
			 * somewhere for copy to get lost; the title is generated on save from
			 * the assigned page, so a box for it would only invite a value that
			 * gets overwritten. Page attributes carry menu_order, which is how the
			 * running order of the cards is set.
			 */
			'supports'            => array( 'page-attributes' ),
		)
	);
}
add_action( 'init', 'iflynepal_register_testimonial_cpt' );

/* --------------------------------------------------------------- admin list */

/**
 * Puts the review's own fields in the Testimonials list table.
 *
 * The generated title says which page a review belongs to and its place in that
 * page's set, but not what it says, so the review's own fields are shown beside
 * it.
 *
 * @since 1.0.0
 *
 * @param string[] $columns Column headings keyed by slug.
 * @return string[] Filtered columns.
 */
function iflynepal_testimonial_columns( $columns ) {
	return array(
		'cb'               => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'            => __( 'Testimonial', 'iflynepal' ),
		'review_headline'  => __( 'Headline', 'iflynepal' ),
		'reviewer_name'    => __( 'Reviewer', 'iflynepal' ),
		'reviewer_country' => __( 'Country', 'iflynepal' ),
		'display_page'     => __( 'Shown on', 'iflynepal' ),
		'date'             => isset( $columns['date'] ) ? $columns['date'] : __( 'Date', 'iflynepal' ),
	);
}
add_filter( 'manage_' . IFLYNEPAL_TESTIMONIAL_POST_TYPE . '_posts_columns', 'iflynepal_testimonial_columns' );

/**
 * Fills the custom columns.
 *
 * @since 1.0.0
 *
 * @param string $column  Column slug.
 * @param int    $post_id Post ID.
 * @return void
 */
function iflynepal_testimonial_column_content( $column, $post_id ) {
	$keys = array(
		'review_headline'  => '_iflynepal_review_headline',
		'reviewer_name'    => '_iflynepal_reviewer_name',
		'reviewer_country' => '_iflynepal_reviewer_country',
	);

	if ( 'display_page' === $column ) {
		$page_id = (int) get_post_meta( $post_id, '_iflynepal_display_page', true );
		$title   = $page_id ? get_the_title( $page_id ) : '';

		echo '' === $title ? '—' : esc_html( $title );

		return;
	}

	if ( ! isset( $keys[ $column ] ) ) {
		return;
	}

	$value = (string) get_post_meta( $post_id, $keys[ $column ], true );

	echo '' === $value ? '—' : esc_html( $value );
}
add_action( 'manage_' . IFLYNEPAL_TESTIMONIAL_POST_TYPE . '_posts_custom_column', 'iflynepal_testimonial_column_content', 10, 2 );

/* ------------------------------------------------------------------- title */

/**
 * The naming stem for reviews assigned to a page.
 *
 * @since 1.0.0
 *
 * @param int $page_id Assigned page, 0 when there is none.
 * @return string Stem, without a number.
 */
function iflynepal_testimonial_title_stem( $page_id ) {
	$page_title = $page_id ? trim( (string) get_the_title( $page_id ) ) : '';

	if ( '' === $page_title ) {
		return __( 'Unassigned Testimonial', 'iflynepal' );
	}

	return sprintf(
		/* translators: %s: the page the review is shown on. */
		__( '%s Testimonial', 'iflynepal' ),
		$page_title
	);
}

/**
 * The title a review should carry, given the page it is assigned to.
 *
 * Numbered per page — "Home Testimonial 1", "Home Testimonial 2" — so the admin
 * list reads as an ordered set for each page it serves.
 *
 * A review already numbered under its current page keeps the number it has, so
 * re-saving does not renumber it. Moving one to another page renames it into
 * that page's sequence instead. The next number is one past the **highest** in
 * use rather than one past the count, so deleting a review from the middle of a
 * page's set cannot make the next one collide with a title already taken.
 *
 * @since 1.0.0
 *
 * @param int $post_id Review being saved.
 * @return string Title.
 */
function iflynepal_testimonial_generated_title( $post_id ) {
	$page_id = (int) get_post_meta( $post_id, '_iflynepal_display_page', true );
	$stem    = iflynepal_testimonial_title_stem( $page_id );
	$pattern = '/^' . preg_quote( $stem, '/' ) . ' (\d+)$/';
	$current = (string) get_post_field( 'post_title', $post_id );

	// Already numbered under this page: leave the number alone.
	if ( preg_match( $pattern, $current ) ) {
		return $current;
	}

	/*
	 * Every other review is read rather than queried by meta: the set is a
	 * handful of posts, and an unassigned review has no meta row to match on,
	 * which a meta query would have to special-case.
	 */
	$siblings = get_posts(
		array(
			'post_type'              => IFLYNEPAL_TESTIMONIAL_POST_TYPE,
			'post_status'            => 'any',
			'numberposts'            => -1,
			'post__not_in'           => array( $post_id ),
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
		)
	);

	$highest = 0;

	foreach ( $siblings as $sibling_id ) {
		if ( (int) get_post_meta( $sibling_id, '_iflynepal_display_page', true ) !== $page_id ) {
			continue;
		}

		if ( preg_match( $pattern, (string) get_post_field( 'post_title', $sibling_id ), $matches ) ) {
			$highest = max( $highest, (int) $matches[1] );
		}
	}

	return $stem . ' ' . ( $highest + 1 );
}

/* -------------------------------------------------------------------- query */

/**
 * The published testimonials, in the order the section should show them.
 *
 * Ordered by menu_order first so the running order is set by dragging the Order
 * field, with the newest review breaking a tie — a review added without an
 * order still lands at the front rather than the back.
 *
 * @since 1.0.0
 *
 * @param array $args {
 *     Optional. Selection arguments.
 *
 *     @type int|string $page    Page the reviews are assigned to. 'current' (the
 *                               default) reads the page being viewed; 0 drops the
 *                               filter and returns every review.
 *     @type int        $limit   Maximum to return. -1 for all. Default -1.
 *     @type int[]      $include Specific post IDs, in the order given. Default empty.
 * }
 * @return array[] Testimonials, each with 'id', 'headline', 'body', 'name', 'country' and 'photo'.
 */
function iflynepal_get_testimonials( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'page'    => 'current',
			'limit'   => -1,
			'include' => array(),
		)
	);

	$query_args = array(
		'post_type'              => IFLYNEPAL_TESTIMONIAL_POST_TYPE,
		'post_status'            => 'publish',
		'posts_per_page'         => (int) $args['limit'],
		'orderby'                => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
	);

	/*
	 * A review belongs to one page, so the section shows the reviews assigned
	 * to the page being viewed and nothing else. An explicit 0 turns that off,
	 * for a caller that wants the whole set.
	 */
	$page = 'current' === $args['page'] ? get_queried_object_id() : (int) $args['page'];

	if ( $page ) {
		$query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- The set is small and the alternative is fetching every review on every page.
			array(
				'key'     => '_iflynepal_display_page',
				'value'   => $page,
				'compare' => '=',
				'type'    => 'NUMERIC',
			),
		);
	}

	if ( $args['include'] ) {
		$query_args['post__in'] = array_map( 'absint', (array) $args['include'] );
		$query_args['orderby']  = 'post__in';
	}

	$query        = new WP_Query( $query_args );
	$testimonials = array();

	foreach ( $query->posts as $post ) {
		$body = (string) get_post_meta( $post->ID, '_iflynepal_review_body', true );

		// A review with nothing quoted in it is a draft in all but status.
		if ( '' === trim( $body ) ) {
			continue;
		}

		$testimonials[] = array(
			'id'       => $post->ID,
			'headline' => (string) get_post_meta( $post->ID, '_iflynepal_review_headline', true ),
			'body'     => $body,
			'name'     => (string) get_post_meta( $post->ID, '_iflynepal_reviewer_name', true ),
			'country'  => (string) get_post_meta( $post->ID, '_iflynepal_reviewer_country', true ),
			'photo'    => (int) get_post_meta( $post->ID, '_iflynepal_reviewer_photo', true ),
		);
	}

	/*
	 * WP_Query overwrites the global $post; anything after this that relies on
	 * it — the_title() and friends — would otherwise be reading the last
	 * testimonial rather than the page being rendered.
	 */
	wp_reset_postdata();

	return $testimonials;
}

/**
 * The reviewer's name and country as one line, as the card prints it.
 *
 * @since 1.0.0
 *
 * @param array $testimonial One entry from iflynepal_get_testimonials().
 * @return string Byline, empty when neither field is filled in.
 */
function iflynepal_testimonial_byline( $testimonial ) {
	$name    = isset( $testimonial['name'] ) ? trim( $testimonial['name'] ) : '';
	$country = isset( $testimonial['country'] ) ? trim( $testimonial['country'] ) : '';

	if ( '' !== $name && '' !== $country ) {
		return sprintf(
			/* translators: 1: reviewer's name, 2: reviewer's country. */
			__( '%1$s, %2$s', 'iflynepal' ),
			$name,
			$country
		);
	}

	return '' !== $name ? $name : $country;
}
