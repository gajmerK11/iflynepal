<?php
/**
 * A Customizer textarea with a formatting toolbar.
 *
 * The Customizer has no rich-text control, and a full TinyMCE inside a list of
 * twenty collapsed slots is slow and fragile, so this is a textarea with a row
 * of buttons that wrap the selection in the matching tag: bold, italic,
 * underline, link, bulleted and numbered lists, and clear formatting. The
 * buttons are wired by assets/js/legal/customizer.js.
 *
 * The saved value is HTML, so it passes through wp_kses_post() on the way in
 * and again on the way out; see iflynepal_legal_sanitize_body().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a toolbar above a textarea.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Customize_Rich_Text_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'iflynepal-rich-text';

	/**
	 * Rows the textarea opens with.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	public $rows = 8;

	/**
	 * Whether the list buttons are offered. Off for short fields such as a card's text.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $lists = true;

	/**
	 * Prints the label, the toolbar and the textarea.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function render_content() {
		$buttons = array(
			array( 'bold', '<b>B</b>', __( 'Bold', 'iflynepal' ) ),
			array( 'italic', '<i>I</i>', __( 'Italic', 'iflynepal' ) ),
			array( 'underline', '<u>U</u>', __( 'Underline', 'iflynepal' ) ),
			array( 'link', '&#128279;', __( 'Link', 'iflynepal' ) ),
		);

		if ( $this->lists ) {
			$buttons[] = array( 'ul', '&bull; List', __( 'Bulleted list', 'iflynepal' ) );
			$buttons[] = array( 'ol', '1. List', __( 'Numbered list', 'iflynepal' ) );
		}

		$buttons[] = array( 'clear', '&times; Clear', __( 'Remove formatting from the selection', 'iflynepal' ) );
		?>
		<label>
			<?php if ( $this->label ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
		</label>
		<div class="iflynepal-rich">
			<div class="iflynepal-rich__bar" role="toolbar" aria-label="<?php esc_attr_e( 'Formatting', 'iflynepal' ); ?>">
				<?php foreach ( $buttons as $button ) : ?>
					<button type="button" class="button iflynepal-rich__btn" data-cmd="<?php echo esc_attr( $button[0] ); ?>" title="<?php echo esc_attr( $button[2] ); ?>" aria-label="<?php echo esc_attr( $button[2] ); ?>"><?php echo wp_kses( $button[1], array( 'b' => array(), 'i' => array(), 'u' => array() ) ); ?></button>
				<?php endforeach; ?>
			</div>
			<textarea rows="<?php echo (int) $this->rows; ?>" style="width:100%" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</div>
		<?php if ( $this->description ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<?php
	}
}
