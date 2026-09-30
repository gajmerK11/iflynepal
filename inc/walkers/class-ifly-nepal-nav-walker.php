<?php
/**
 * Primary navigation walker: turns a nested menu into the header dropdown.
 *
 * A top-level item with children becomes a trigger and a panel; one without
 * stays an ordinary link. Only one level of nesting is rendered — anything
 * deeper is a menu that wants rethinking rather than a design this header has.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Builds the header's dropdown markup from a nested menu.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Records how many children an item has before rendering it.
	 *
	 * @since 1.0.0
	 *
	 * @param object $element           Menu item.
	 * @param array  $children_elements Children, keyed by parent id.
	 * @param int    $max_depth         Depth limit.
	 * @param int    $depth             Current depth.
	 * @param array  $args              wp_nav_menu arguments.
	 * @param string $output            Markup, by reference.
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( $element && isset( $element->ID ) ) {
			$element->iflynepal_children = isset( $children_elements[ $element->ID ] )
				? count( $children_elements[ $element->ID ] )
				: 0;
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Opens a dropdown panel.
	 *
	 * Always a single column, however many links it holds; the stylesheet
	 * sizes it to its longest label.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Markup, by reference.
	 * @param int    $depth  Current depth.
	 * @param array  $args   wp_nav_menu arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}

		$output .= '<ul class="iflynepal-nav-panel">';
	}

	/**
	 * Closes a dropdown panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Markup, by reference.
	 * @param int    $depth  Current depth.
	 * @param array  $args   wp_nav_menu arguments.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}

		$output .= '</ul>';
	}

	/**
	 * Renders one menu item.
	 *
	 * ⚠️ A top-level item that has children is a `button`, never a link. It is
	 * the control that opens the panel, and the client asked for it not to
	 * navigate — which is also the accessible answer, since a link that does
	 * not go anywhere is a trap for anyone using the keyboard. Whatever URL the
	 * item carries in Appearance > Menus is deliberately ignored.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output      Markup, by reference.
	 * @param object $data_object Menu item.
	 * @param int    $depth       Current depth.
	 * @param array  $args        wp_nav_menu arguments.
	 * @param int    $current_object_id Current object id.
	 * @return void
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item     = $data_object;
		$children = isset( $item->iflynepal_children ) ? (int) $item->iflynepal_children : 0;
		// Already through `the_title` — wp_setup_nav_menu_item() applies it.
		$title   = $item->title;
		$classes = array_filter( (array) $item->classes );

		if ( 0 === $depth && $children ) {
			$classes[] = 'iflynepal-nav-item';
		}

		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';

		if ( 0 === $depth && $children ) {
			$output .= sprintf(
				'<button class="iflynepal-nav-trigger" type="button" aria-expanded="false">%1$s<svg class="iflynepal-nav-chevron" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false"><path d="m4 6 4 4 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
				esc_html( $title )
			);

			return;
		}

		$output .= sprintf(
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $item->url ? $item->url : '#' ),
			$item->target ? ' target="' . esc_attr( $item->target ) . '"' : '',
			esc_html( $title )
		);
	}

	/**
	 * Closes one menu item.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output      Markup, by reference.
	 * @param object $data_object Menu item.
	 * @param int    $depth       Current depth.
	 * @param array  $args        wp_nav_menu arguments.
	 * @return void
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
