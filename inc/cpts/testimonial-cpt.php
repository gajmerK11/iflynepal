<?php
/**
 * Testimonials post type.
 *
 * One traveller review per post. The four fields an editor fills in live in a
 * meta box (inc/meta-boxes/class-ifly-nepal-testimonial-meta-box.php); the post
 * title is only an internal label, so a review can be found in the admin list
 * without reading its whole quote.
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
			 * The editor is not supported: the review body is a meta field, so a
			 * second free-form content area would only be somewhere for copy to
			 * get lost. Page attributes carry menu_order, which is how the
			 * running order of the cards is set.
			 */
			'supports'            => array( 'title', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'iflynepal_register_testimonial_cpt' );

/**
 * Renames the title field, which holds an internal label rather than a heading.
 *
 * Nothing on the front end prints the post title, so without this an editor has
 * no way of knowing what belongs in it.
 *
 * @since 1.0.0
 *
 * @param string  $text Placeholder text.
 * @param WP_Post $post Post being edited.
 * @return string Filtered placeholder.
 */
function iflynepal_testimonial_title_placeholder( $text, $post ) {
	if ( IFLYNEPAL_TESTIMONIAL_POST_TYPE === $post->post_type ) {
		return __( 'Internal label, e.g. Marcus — Everest Base Camp', 'iflynepal' );
	}

	return $text;
}
add_filter( 'enter_title_here', 'iflynepal_testimonial_title_placeholder', 10, 2 );

/* --------------------------------------------------------------- admin list */

/**
 * Puts the review's own fields in the Testimonials list table.
 *
 * The post title is an internal label, so a list of titles alone would not show
 * an editor which review is which.
 *
 * @since 1.0.0
 *
 * @param string[] $columns Column headings keyed by slug.
 * @return string[] Filtered columns.
 */
function iflynepal_testimonial_columns( $columns ) {
	return array(
		'cb'               => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'            => __( 'Label', 'iflynepal' ),
		'review_headline'  => __( 'Headline', 'iflynepal' ),
		'reviewer_name'    => __( 'Reviewer', 'iflynepal' ),
		'reviewer_country' => __( 'Country', 'iflynepal' ),
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

	if ( ! isset( $keys[ $column ] ) ) {
		return;
	}

	$value = (string) get_post_meta( $post_id, $keys[ $column ], true );

	echo '' === $value ? '—' : esc_html( $value );
}
add_action( 'manage_' . IFLYNEPAL_TESTIMONIAL_POST_TYPE . '_posts_custom_column', 'iflynepal_testimonial_column_content', 10, 2 );

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
 *     @type int   $limit   Maximum to return. -1 for all. Default -1.
 *     @type int[] $include Specific post IDs, in the order given. Default empty.
 * }
 * @return array[] Testimonials, each with 'id', 'headline', 'body', 'name' and 'country'.
 */
function iflynepal_get_testimonials( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
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
