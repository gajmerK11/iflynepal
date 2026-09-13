<?php
/**
 * News post type, the meta an editor sets on a story, and the Top News limit.
 *
 * The arrangement is the one used by the cloudcolleague theme's News type,
 * carried over unchanged in shape:
 *
 *   /news/             the archive
 *   /news/page/2/      the archive, paged
 *   /news/{slug}/      a story
 *
 * No taxonomy, unlike Articles: a news story is filed under "News" and nothing
 * else, which is why the card labels and the breadcrumb print that word rather
 * than a term. The archive's shape comes from the meta below instead — three
 * stories are flagged for the Top News row at the head of the page, and the
 * cloudcolleague theme enforces that three by asking the server how many are
 * already flagged before it lets the toggle be turned on. That check is the
 * REST route and the editor panel at the foot of this file.
 *
 * Registering a public post type in a theme has the consequence recorded on
 * the Articles and Testimonials types: switch the theme away and the posts
 * stay in the database but stop being registered, so every URL above begins to
 * 404. The type belongs in a plugin the day the client wants it to outlive the
 * theme.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The post type's key.
 *
 * Plural in the URL but singular as a word — `news` is both — and unprefixed,
 * for the reason recorded on Articles: it is in every story's URL, and
 * `/news/` is how the section reads. The trade is the usual one for an
 * unprefixed key, and it is accepted here because the design, the body classes
 * and the archive path all say "news".
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_POST_TYPE = 'news';

/**
 * The meta key that flags a story for the Top News row.
 *
 * Underscored, so it stays out of the custom fields box: the toggle in the
 * editor sidebar is the way it is set.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_TOP_META = '_iflynepal_news_top';

/**
 * The meta key holding the story's topic line.
 *
 * The small capitals beside the News flag in the hero — "Festivals & travel"
 * in the approved design. Free text rather than a taxonomy: it labels the one
 * story it is on and nothing links to it, so a term would only be a term
 * archive nobody visits.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_TOPIC_META = '_iflynepal_news_topic';

/**
 * The meta key holding the story's dateline.
 *
 * Where the story is filed from — "Kathmandu". It prints twice: beside the pin
 * in the details row, and in small capitals at the head of the standfirst, the
 * way a newspaper opens a report.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_PLACE_META = '_iflynepal_news_place';

/**
 * How many stories the Top News row holds.
 *
 * Three, as the design draws it, and the number the editor's toggle is capped
 * at.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_TOP_LIMIT = 3;

/**
 * Registers the News post type and the meta a story carries.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_news_cpt() {
	register_post_type(
		IFLYNEPAL_NEWS_POST_TYPE,
		array(
			'labels'          => array(
				'name'               => __( 'News', 'iflynepal' ),
				'singular_name'      => __( 'News', 'iflynepal' ),
				'add_new'            => __( 'Add New', 'iflynepal' ),
				'add_new_item'       => __( 'Add New News', 'iflynepal' ),
				'edit_item'          => __( 'Edit News', 'iflynepal' ),
				'new_item'           => __( 'New News', 'iflynepal' ),
				'view_item'          => __( 'View News', 'iflynepal' ),
				'view_items'         => __( 'View News', 'iflynepal' ),
				'search_items'       => __( 'Search News', 'iflynepal' ),
				'not_found'          => __( 'No news found', 'iflynepal' ),
				'not_found_in_trash' => __( 'No news found in trash', 'iflynepal' ),
				'all_items'          => __( 'All News', 'iflynepal' ),
				'menu_name'          => __( 'News', 'iflynepal' ),
			),
			'public'          => true,
			'has_archive'     => 'news',
			'show_in_rest'    => true,
			'menu_position'   => 22,
			'menu_icon'       => 'dashicons-megaphone',

			/*
			 * Page capabilities rather than post ones, for the reason recorded
			 * on the Articles and Testimonials types: every `*_posts`
			 * capability has been removed from the administrator role on this
			 * install, so a type left on the defaults registers fine and is
			 * then pruned out of the admin menu.
			 */
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields' ),
			'rewrite'         => array(
				'slug'       => 'news',
				'with_front' => false,
			),
		)
	);

	register_post_meta(
		IFLYNEPAL_NEWS_POST_TYPE,
		IFLYNEPAL_NEWS_TOP_META,
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'default'       => false,
			'auth_callback' => 'iflynepal_news_can_edit',
		)
	);

	foreach ( array( IFLYNEPAL_NEWS_TOPIC_META, IFLYNEPAL_NEWS_PLACE_META ) as $key ) {
		register_post_meta(
			IFLYNEPAL_NEWS_POST_TYPE,
			$key,
			array(
				'show_in_rest'      => true,
				'single'            => true,
				'type'              => 'string',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => 'iflynepal_news_can_edit',
			)
		);
	}
}
add_action( 'init', 'iflynepal_register_news_cpt' );

/**
 * Whether the current user may write the meta above.
 *
 * `edit_pages`, not `edit_posts`, for the same reason the type is registered on
 * page capabilities: `edit_posts` does not exist on this install.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_news_can_edit() {
	return current_user_can( 'edit_pages' );
}

/* --------------------------------------------------------- the three limit */

/**
 * Registers the route the editor panel counts Top News with.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_news_rest_routes() {
	register_rest_route(
		'iflynepal/v1',
		'/top-news',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'iflynepal_news_top_rest',
			'permission_callback' => 'iflynepal_news_can_edit',
		)
	);
}
add_action( 'rest_api_init', 'iflynepal_register_news_rest_routes' );

/**
 * The stories already flagged for Top News, for the editor panel.
 *
 * The panel needs two things: how many there are, so it can grey the toggle
 * out at three, and a way to reach them, so the editor can free a place up
 * without hunting for which three they were.
 *
 * @since 1.0.0
 *
 * @return WP_REST_Response Count and the flagged stories.
 */
function iflynepal_news_top_rest() {
	$posts = iflynepal_news_top_stories();
	$out   = array();

	foreach ( $posts as $post ) {
		$out[] = array(
			'id'        => $post->ID,
			'title'     => get_the_title( $post ),
			'edit_link' => get_edit_post_link( $post->ID, 'raw' ),
		);
	}

	return rest_ensure_response(
		array(
			'count' => count( $out ),
			'posts' => $out,
		)
	);
}

/**
 * The stories flagged for the Top News row, newest first.
 *
 * Capped at three whatever the database says: the toggle is the only way to
 * set the flag and it stops at three, but a story flagged and then re-dated
 * should not be able to push the row to four.
 *
 * @since 1.0.0
 *
 * @return WP_Post[] Stories.
 */
function iflynepal_news_top_stories() {
	return get_posts(
		array(
			'post_type'              => IFLYNEPAL_NEWS_POST_TYPE,
			'post_status'            => 'publish',
			'posts_per_page'         => IFLYNEPAL_NEWS_TOP_LIMIT,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'meta_query'             => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- One key, three rows, once per archive.
				array(
					'key'   => IFLYNEPAL_NEWS_TOP_META,
					'value' => '1',
				),
			),
		)
	);
}

/* ------------------------------------------------------------ the list table */

/**
 * Adds the Top News column to the News list table.
 *
 * Which three are flagged is the one thing about a story that cannot be read
 * off the list without opening it.
 *
 * @since 1.0.0
 *
 * @param array<string,string> $columns Column headings.
 * @return array<string,string> Filtered headings.
 */
function iflynepal_news_columns( $columns ) {
	$columns['iflynepal_news_top'] = __( 'Top News', 'iflynepal' );

	return $columns;
}
add_filter( 'manage_' . IFLYNEPAL_NEWS_POST_TYPE . '_posts_columns', 'iflynepal_news_columns' );

/**
 * Fills the Top News column.
 *
 * @since 1.0.0
 *
 * @param string $column  Column key.
 * @param int    $post_id Story.
 * @return void
 */
function iflynepal_news_column_content( $column, $post_id ) {
	if ( 'iflynepal_news_top' !== $column ) {
		return;
	}

	echo get_post_meta( $post_id, IFLYNEPAL_NEWS_TOP_META, true )
		? esc_html__( 'Yes', 'iflynepal' )
		: esc_html__( 'No', 'iflynepal' );
}
add_action( 'manage_' . IFLYNEPAL_NEWS_POST_TYPE . '_posts_custom_column', 'iflynepal_news_column_content', 10, 2 );

/* -------------------------------------------------------- the editor panel */

/**
 * Loads the News panel into the block editor.
 *
 * On the News editor alone: the panel registers itself the moment it is
 * parsed, so loading it anywhere else would put a News box on every screen.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_enqueue_news_editor_panel() {
	$screen = get_current_screen();

	if ( ! $screen || IFLYNEPAL_NEWS_POST_TYPE !== $screen->post_type ) {
		return;
	}

	wp_enqueue_script(
		'iflynepal-news-panel',
		IFLYNEPAL_URI . '/assets/js/news-panel.js',
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-data', 'wp-components', 'wp-api-fetch', 'wp-i18n' ),
		iflynepal_asset_version( 'assets/js/news-panel.js' ),
		true
	);

	wp_set_script_translations( 'iflynepal-news-panel', 'iflynepal' );

	wp_add_inline_script(
		'iflynepal-news-panel',
		'window.iflynepalNews = ' . wp_json_encode(
			array(
				'topMeta'   => IFLYNEPAL_NEWS_TOP_META,
				'topicMeta' => IFLYNEPAL_NEWS_TOPIC_META,
				'placeMeta' => IFLYNEPAL_NEWS_PLACE_META,
				'limit'     => IFLYNEPAL_NEWS_TOP_LIMIT,
			)
		) . ';',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'iflynepal_enqueue_news_editor_panel' );
