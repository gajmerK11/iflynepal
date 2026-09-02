<?php
/**
 * A settingless Customizer control that draws a group heading.
 *
 * The Customizer has no way to group controls inside a section, and no nested
 * panels, so a section holding several distinct groups reads as one long
 * undifferentiated list. This control is pure UI — it stores nothing — and just
 * marks where one group ends and the next begins.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a heading between groups of controls.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Customize_Heading_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'iflynepal-heading';

	/**
	 * Prints the heading and its optional description.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) {
			printf(
				'<span class="customize-control-title iflynepal-customize-heading">%s</span>',
				esc_html( $this->label )
			);
		}

		if ( ! empty( $this->description ) ) {
			printf(
				'<span class="description customize-control-description">%s</span>',
				esc_html( $this->description )
			);
		}
	}
}
