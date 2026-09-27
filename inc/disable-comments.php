<?php
/**
 * Disables comments site-wide.
 *
 * The theme never renders a comment form anywhere — Articles, News,
 * Testimonials, none of it — so the feature has no legitimate use on this
 * site. That alone does not stop a submission: WordPress core's
 * wp-comments-post.php accepts a POST for any post whose comment status is
 * "open" (the default for a new post) regardless of whether any theme ever
 * draws a form for it, which is how a spam bot posts a comment to a page that
 * has never shown one. Settings > Discussion's own toggle only changes the
 * default for posts published from now on, so it does nothing about a post
 * that already exists — this closes it everywhere, unconditionally, at the
 * one check every submission path (the front end, XML-RPC, the REST API) has
 * to pass regardless of a post's own stored status.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * The one filter that actually matters. wp_new_comment() calls comments_open()
 * before accepting anything, so a submission is refused here before it is
 * ever written to the database — no per-post status to keep in sync, and
 * nothing left over for a plugin or a future post to accidentally reopen.
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Belt and suspenders: nothing already stored ever renders, even if something asks for it directly.
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

/**
 * Drops the Comments screen from the admin menu.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_remove_comments_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'iflynepal_remove_comments_admin_menu' );

/**
 * Drops the Comments bubble from the admin bar.
 *
 * @since 1.0.0
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar being built.
 * @return void
 */
function iflynepal_remove_comments_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'iflynepal_remove_comments_admin_bar', 999 );

/**
 * Drops the Comments meta box from every edit screen it could appear on.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_remove_comments_meta_boxes() {
	foreach ( get_post_types( array( 'public' => true ) ) as $post_type ) {
		remove_meta_box( 'commentsdiv', $post_type, 'normal' );
		remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
	}
}
add_action( 'admin_menu', 'iflynepal_remove_comments_meta_boxes' );

/**
 * Sends a direct request to `/wp-comments-post.php` home rather than letting
 * it process at all.
 *
 * comments_open() being false already makes wp_new_comment() refuse the
 * submission with an error page — this only replaces that error page with a
 * quiet redirect, so a bot's request ends the same way a normal visitor's
 * would if they somehow found the endpoint: nowhere.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_block_comments_post_endpoint() {
	if ( false !== stripos( isset( $_SERVER['SCRIPT_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ) : '', 'wp-comments-post.php' ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
}
add_action( 'init', 'iflynepal_block_comments_post_endpoint' );
