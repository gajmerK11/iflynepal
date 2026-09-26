<?php
/**
 * Testimonials post type.
 *
 * One traveller review per post. Everything an editor fills in lives in a meta
 * box (inc/meta-boxes/class-ifly-nepal-testimonial-meta-box.php). There is no
 * title field: the title is generated from the first place the review is shown,
 * as "Home Testimonial 1", so the admin list reads as an ordered set without
 * anyone having to name anything. A review may be shown in several places at
 * once, each one its own meta row — see iflynepal_testimonial_targets().
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
			 * where it is shown, so a box for it would only invite a value that
			 * gets overwritten. Page attributes carry menu_order, which is how the
			 * running order of the cards is set.
			 */
			'supports'            => array( 'page-attributes' ),
		)
	);
}
add_action( 'init', 'iflynepal_register_testimonial_cpt' );

/**
 * Tells Polylang the Testimonials post type is translated.
 *
 * Polylang's settings screen only offers `'public' => true` post types for
 * language management, because that is the list it builds the checkbox
 * options from. Testimonials is deliberately `public => false` — a review has
 * no page of its own — so it would never appear there and would stay
 * language-less forever without this. Adding it through the filter's
 * `$is_settings = false` branch makes it translated unconditionally, the same
 * bypass Polylang's own WPML-config importer uses for non-public types.
 *
 * @since 1.0.0
 *
 * @param string[] $post_types Post type names, as both keys and values.
 * @return string[] Filtered.
 */
function iflynepal_testimonial_pll_translated( $post_types ) {
	$post_types[ IFLYNEPAL_TESTIMONIAL_POST_TYPE ] = IFLYNEPAL_TESTIMONIAL_POST_TYPE;

	return $post_types;
}
add_filter( 'pll_get_post_types', 'iflynepal_testimonial_pll_translated' );

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
		$labels = array();

		foreach ( iflynepal_testimonial_targets( $post_id ) as $target ) {
			$label = iflynepal_testimonial_target_label( $target );

			if ( '' !== $label ) {
				$labels[] = $label;
			}
		}

		// Every place it is shown, not just the one that named it.
		echo empty( $labels ) ? '—' : esc_html( implode( ', ', $labels ) );

		return;
	}

	if ( ! isset( $keys[ $column ] ) ) {
		return;
	}

	$value = (string) get_post_meta( $post_id, $keys[ $column ], true );

	echo '' === $value ? '—' : esc_html( $value );
}
add_action( 'manage_' . IFLYNEPAL_TESTIMONIAL_POST_TYPE . '_posts_custom_column', 'iflynepal_testimonial_column_content', 10, 2 );

/* ----------------------------------------------------------- display target */

/**
 * The meta key holding the place a review is shown.
 *
 * The key still says "page" because that is what it held first and renaming it
 * would need a migration of every stored row for no gain. What it holds now is
 * a display *target* — see iflynepal_testimonial_normalize_target().
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TESTIMONIAL_TARGET_KEY = '_iflynepal_display_page';

/**
 * A stored display target, in the one shape everything else may assume.
 *
 * A review used to be assigned to a page and the value stored was that page's
 * ID. Once it can also be assigned to a term archive, a bare ID is ambiguous:
 * post IDs and term IDs are separate sequences that both start at 1, so page 15
 * and term 15 are the same number and a review assigned to one would surface on
 * the other. The kind therefore travels with the ID — `page:15`, `term:15`.
 *
 * A bare number is read as a page, which is what every row written before this
 * holds. That is deliberate and is the reason there is no migration script: the
 * reader understands both shapes and the writer only ever emits the new one, so
 * a row converts itself the next time its review is saved.
 *
 * @since 1.0.0
 *
 * @param mixed $value Stored or submitted value.
 * @return string Target key, or an empty string when there is no valid target.
 */
function iflynepal_testimonial_normalize_target( $value ) {
	$value = is_scalar( $value ) ? trim( (string) $value ) : '';

	if ( '' === $value ) {
		return '';
	}

	// Legacy: a bare page ID, written before a review could go anywhere else.
	if ( ctype_digit( $value ) ) {
		return (int) $value > 0 ? 'page:' . (int) $value : '';
	}

	return preg_match( '/^(?:page|term):[1-9][0-9]*$/', $value ) ? $value : '';
}

/**
 * Every place one review is shown.
 *
 * A review used to belong to one place and the meta held one value. It can now
 * be shown in several, and each is **its own meta row under the same key**
 * rather than a list packed into one. That is not a style preference: the query
 * that selects the reviews for a request matches a row exactly, and a serialized
 * array cannot be matched exactly — it would have to be searched with a LIKE,
 * which matches `term:3` inside `term:33`.
 *
 * A row written before this still holds a bare page ID and is still one row, so
 * it reads back here as a single-target list with nothing done to it.
 *
 * @since 1.0.0
 *
 * @param int $post_id Review.
 * @return string[] Target keys, in the order they were stored, without repeats.
 */
function iflynepal_testimonial_targets( $post_id ) {
	$targets = array();

	foreach ( (array) get_post_meta( $post_id, IFLYNEPAL_TESTIMONIAL_TARGET_KEY, false ) as $value ) {
		$target = iflynepal_testimonial_normalize_target( $value );

		if ( '' === $target || in_array( $target, $targets, true ) ) {
			continue;
		}

		$targets[] = $target;
	}

	return $targets;
}

/**
 * The first place a review is shown, which is what names it.
 *
 * @since 1.0.0
 *
 * @param int $post_id Review.
 * @return string Target key, empty when the review is shown nowhere.
 */
function iflynepal_testimonial_primary_target( $post_id ) {
	$targets = iflynepal_testimonial_targets( $post_id );

	return $targets ? $targets[0] : '';
}

/**
 * The published pages, as target options, in their own hierarchy.
 *
 * Children follow their parent and are indented with non-breaking spaces rather
 * than an HTML entity, because the label is escaped wherever it is printed and
 * an entity would show as its own source.
 *
 * @since 1.0.0
 *
 * @param WP_Post[] $pages  Every page, as one flat list.
 * @param int       $parent_id Parent being drawn under.
 * @param int       $depth  Current depth.
 * @return string[] Labels keyed by target.
 */
function iflynepal_testimonial_page_options( $pages, $parent_id = 0, $depth = 0 ) {
	$options = array();

	foreach ( $pages as $page ) {
		if ( (int) $page->post_parent !== (int) $parent_id ) {
			continue;
		}

		$title = trim( (string) $page->post_title );

		if ( '' === $title ) {
			$title = sprintf(
				/* translators: %d: the page's ID. */
				__( '(no title) #%d', 'iflynepal' ),
				(int) $page->ID
			);
		}

		$options[ 'page:' . (int) $page->ID ] = str_repeat( "\xc2\xa0\xc2\xa0\xc2\xa0", $depth ) . $title;

		/*
		 * Merged rather than appended so a page's children sit directly under
		 * it: at this point $options ends with the parent, and += adds only the
		 * keys it does not already hold, in the order they arrive.
		 */
		$options += iflynepal_testimonial_page_options( $pages, $page->ID, $depth + 1 );
	}

	return $options;
}

/**
 * The places a review can be assigned to, grouped for the chooser.
 *
 * The theme knows about pages and nothing else, which is the whole point of the
 * filter: a plugin that owns templates of its own — package type archives, say
 * — adds its own group, and the theme neither names them nor has to be edited
 * again when another arrives.
 *
 * @since 1.0.0
 *
 * @return array[] Groups keyed by group key, each with 'label' and 'options'.
 */
function iflynepal_testimonial_display_targets() {
	$groups = array(
		'pages' => array(
			'label'   => __( 'Pages', 'iflynepal' ),
			'options' => iflynepal_testimonial_page_options(
				get_pages(
					array(
						'post_status' => 'publish',
						'sort_column' => 'menu_order,post_title',
					)
				)
			),
		),
	);

	/**
	 * Filters the places a testimonial can be assigned to.
	 *
	 * Each group holds a 'label' and an 'options' map of target key to label.
	 * A target key is `page:{post ID}` or `term:{term ID}`; anything else is
	 * dropped, because the same keys have to be readable by the query that
	 * selects the reviews for the request being rendered.
	 *
	 * The one hook rather than one per question: the theme already answers
	 * "which target is this request" generically, from the queried object, so
	 * a plugin only has to say which of its own targets exist.
	 *
	 * @since 1.0.0
	 *
	 * @param array[] $groups Target groups, keyed by group key.
	 */
	return (array) apply_filters( 'iflynepal_testimonial_display_targets', $groups );
}

/**
 * Every target on offer, flattened and validated.
 *
 * @since 1.0.0
 *
 * @return string[] Labels keyed by target key.
 */
function iflynepal_testimonial_display_target_choices() {
	$choices = array();

	foreach ( iflynepal_testimonial_display_targets() as $group ) {
		if ( empty( $group['options'] ) || ! is_array( $group['options'] ) ) {
			continue;
		}

		foreach ( $group['options'] as $target => $label ) {
			$target = iflynepal_testimonial_normalize_target( $target );

			if ( '' === $target ) {
				continue;
			}

			$choices[ $target ] = (string) $label;
		}
	}

	return $choices;
}

/**
 * What to call a target.
 *
 * A target that is no longer on offer — a page moved to draft, or a plugin that
 * registered it switched off — is named from its own source rather than shown as
 * nothing, so an assignment that has stopped working says which one it was.
 *
 * @since 1.0.0
 *
 * @param mixed $target Stored or submitted target.
 * @return string Label, empty when there is no target or nothing to name it by.
 */
function iflynepal_testimonial_target_label( $target ) {
	$target = iflynepal_testimonial_normalize_target( $target );

	if ( '' === $target ) {
		return '';
	}

	$choices = iflynepal_testimonial_display_target_choices();

	if ( isset( $choices[ $target ] ) ) {
		return trim( str_replace( "\xc2\xa0", ' ', $choices[ $target ] ) );
	}

	list( $kind, $id ) = explode( ':', $target );

	if ( 'page' === $kind ) {
		return trim( (string) get_the_title( (int) $id ) );
	}

	$term = get_term( (int) $id );

	return $term instanceof WP_Term ? $term->name : '';
}

/**
 * The target the request being rendered stands for.
 *
 * Derived from the queried object rather than from a list of templates, which is
 * what keeps this generic: a page, a package, a term archive and anything else
 * a plugin queries all resolve here without the theme knowing what they are.
 *
 * @since 1.0.0
 *
 * @return string Target key, empty on a request that is neither.
 */
function iflynepal_testimonial_current_target() {
	$object = get_queried_object();

	if ( $object instanceof WP_Term ) {
		return 'term:' . (int) $object->term_id;
	}

	if ( $object instanceof WP_Post ) {
		return 'page:' . (int) $object->ID;
	}

	return '';
}

/* ------------------------------------------------------------------- title */

/**
 * The naming stem every review is numbered under.
 *
 * One stem for the whole post type, rather than one per place a review is shown.
 * It used to name the page — "Home Testimonial 1" — which worked while a review
 * belonged to exactly one page and stopped being true the moment it could belong
 * to several: the title named the first of them and said nothing about the rest,
 * and it was rewritten whenever that first one changed. The title is now only an
 * identifier; where a review appears is the list table's "Shown on" column, which
 * is the one place that can say all of it.
 *
 * @since 1.0.0
 *
 * @return string Stem, without a number.
 */
function iflynepal_testimonial_title_stem() {
	return __( 'Testimonial', 'iflynepal' );
}

/**
 * The title a review should carry.
 *
 * "Testimonial 1", "Testimonial 2", in one sequence across the post type.
 *
 * A review already numbered keeps the number it has, so re-saving one — or moving
 * it to another page — does not renumber it and does not renumber anything after
 * it. The next number is one past the **highest** in use rather than one past the
 * count, so deleting a review from the middle of the set cannot make the next one
 * collide with a title already taken.
 *
 * @since 1.0.0
 *
 * @param int $post_id Review being saved.
 * @return string Title.
 */
function iflynepal_testimonial_generated_title( $post_id ) {
	$stem    = iflynepal_testimonial_title_stem();
	$pattern = '/^' . preg_quote( $stem, '/' ) . ' (\d+)$/';
	$current = (string) get_post_field( 'post_title', $post_id );

	// Already numbered: leave the number alone.
	if ( preg_match( $pattern, $current ) ) {
		return $current;
	}

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
 *     @type int|string $target  Target the reviews are assigned to — 'page:12',
 *                               'term:4', or a bare page ID. 'current' (the
 *                               default) reads the request being rendered; 0
 *                               drops the filter and returns every review.
 *     @type int|string $page    Deprecated alias for 'target', kept because the
 *                               reusable section part has always taken it.
 *     @type int        $limit   Maximum to return. -1 for all. Default -1.
 *     @type int[]      $include Specific post IDs, in the order given. Default empty.
 * }
 * @return array[] Testimonials, each with 'id', 'headline', 'body', 'name', 'country' and 'photo'.
 */
function iflynepal_get_testimonials( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'target'  => 'current',
			'page'    => null,
			'limit'   => -1,
			'include' => array(),
		)
	);

	// The older argument name still decides it when it was passed at all.
	if ( null !== $args['page'] ) {
		$args['target'] = $args['page'];
	}

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
	 * A review belongs to one place, so the section shows the reviews assigned
	 * to the request being rendered and nothing else. An explicit 0 turns that
	 * off, for a caller that wants the whole set.
	 */
	$target = 'current' === $args['target']
		? iflynepal_testimonial_current_target()
		: iflynepal_testimonial_normalize_target( $args['target'] );

	if ( '' !== $target ) {
		/*
		 * Two clauses for a page, one for anything else. Rows written before a
		 * review could be assigned to a term hold a bare page ID, and those are
		 * still the assignment they always were — the ones this query would
		 * otherwise stop finding. They are not compared numerically: 'page:12'
		 * casts to 0, which would match every legacy row at once.
		 */
		$clauses = array(
			array(
				'key'     => IFLYNEPAL_TESTIMONIAL_TARGET_KEY,
				'value'   => $target,
				'compare' => '=',
			),
		);

		if ( 0 === strpos( $target, 'page:' ) ) {
			$clauses['relation'] = 'OR';

			$clauses[] = array(
				'key'     => IFLYNEPAL_TESTIMONIAL_TARGET_KEY,
				'value'   => (string) (int) substr( $target, 5 ),
				'compare' => '=',
			);
		}

		$query_args['meta_query'] = $clauses; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- The set is small and the alternative is fetching every review on every page.
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
