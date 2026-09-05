<?php
/**
 * Footer navigation walker.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a footer menu as a flat run of anchors.
 *
 * The design's footer columns are anchors laid out directly by the column —
 * `.iflynepal-footer__col a` is a direct child selector's worth of markup, with
 * no list around it and no list markers to undo. Core's walker would wrap every
 * item in `<li>` inside a `<ul>`, so this replaces it rather than styling that
 * structure back down to nothing.
 *
 * Sub-menus are deliberately dropped: a footer column is a flat list of
 * destinations, and a client who nests an item under another should still get a
 * legible column rather than a silent indent.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Footer_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Opens a sub-menu level.
	 *
	 * Emits nothing: nested items are flattened into the column.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output Accumulated markup, passed by reference.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '';
	}

	/**
	 * Closes a sub-menu level.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output Accumulated markup, passed by reference.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu arguments.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '';
	}

	/**
	 * Writes one menu item as an anchor.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output            Accumulated markup, passed by reference.
	 * @param WP_Post  $data_object       The menu item.
	 * @param int      $depth             Current depth.
	 * @param stdClass $args              Menu arguments.
	 * @param int      $current_object_id Current item ID.
	 * @return void
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$title = trim( $data_object->title );

		if ( '' === $title ) {
			return;
		}

		$attributes = '';

		if ( ! empty( $data_object->target ) ) {
			$attributes .= ' target="' . esc_attr( $data_object->target ) . '"';

			// A link opening a new tab gets the opener protection core would add.
			if ( '_blank' === $data_object->target ) {
				$attributes .= ' rel="noopener"';
			}
		}

		$output .= sprintf(
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $data_object->url ),
			$attributes,
			esc_html( $title )
		);
	}

	/**
	 * Closes one menu item.
	 *
	 * Emits nothing: the anchor written above is already closed.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output      Accumulated markup, passed by reference.
	 * @param WP_Post  $data_object The menu item.
	 * @param int      $depth       Current depth.
	 * @param stdClass $args        Menu arguments.
	 * @return void
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '';
	}
}
