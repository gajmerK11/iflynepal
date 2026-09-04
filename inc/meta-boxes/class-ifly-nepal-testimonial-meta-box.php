<?php
/**
 * The Testimonials meta box.
 *
 * Holds the four fields that make up a review. Same shape as the meta boxes in
 * the reference theme: one class, hooked in its own constructor, instantiated
 * at the foot of the file.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Review fields for the Testimonials post type.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Testimonial_Meta_Box {

	/**
	 * Meta box ID, and the base for its nonce.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const ID = 'iflynepal_testimonial_fields';

	/**
	 * Hooks the box into the editor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * The fields, in the order they are drawn.
	 *
	 * The key is the meta key; 'type' decides both the control drawn and the
	 * sanitizer used on save, so the two can never drift apart.
	 *
	 * @since 1.0.0
	 *
	 * @return array[] Field definitions keyed by meta key.
	 */
	private function fields() {
		return array(
			'_iflynepal_review_headline'  => array(
				'label'       => __( 'Review Headline', 'iflynepal' ),
				'description' => __( 'The line set in italics at the top of the card. A short phrase lifted from the review reads better than a summary written for it.', 'iflynepal' ),
				'type'        => 'text',
			),
			'_iflynepal_review_body'      => array(
				'label'       => __( 'Review Body', 'iflynepal' ),
				'description' => __( "The traveller's own words, quoted verbatim from the platform the review came from. Two to four sentences. A testimonial with an empty body is not shown.", 'iflynepal' ),
				'type'        => 'textarea',
			),
			'_iflynepal_reviewer_name'    => array(
				'label'       => __( 'Reviewer Name', 'iflynepal' ),
				'description' => '',
				'type'        => 'text',
			),
			'_iflynepal_reviewer_country' => array(
				'label'       => __( 'Reviewer Country', 'iflynepal' ),
				'description' => __( 'Printed after the name, as "Marcus, Germany".', 'iflynepal' ),
				'type'        => 'text',
			),
		);
	}

	/**
	 * Registers the box on the Testimonials editor screen.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {
		add_meta_box(
			self::ID,
			__( 'Review', 'iflynepal' ),
			array( $this, 'render' ),
			IFLYNEPAL_TESTIMONIAL_POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Draws the fields.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post Post being edited.
	 * @return void
	 */
	public function render( $post ) {
		wp_nonce_field( self::ID . '_save', self::ID . '_nonce' );

		foreach ( $this->fields() as $key => $field ) {
			$value    = (string) get_post_meta( $post->ID, $key, true );
			$field_id = str_replace( '_iflynepal_', 'iflynepal-', $key );
			?>
			<p>
				<label class="iflynepal-meta-label" for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $field['label'] ); ?>
				</label>

				<?php if ( 'textarea' === $field['type'] ) : ?>
					<textarea
						class="widefat"
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $key ); ?>"
						rows="5"><?php echo esc_textarea( $value ); ?></textarea>
				<?php else : ?>
					<input
						class="widefat"
						type="text"
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $key ); ?>"
						value="<?php echo esc_attr( $value ); ?>">
				<?php endif; ?>

				<?php if ( '' !== $field['description'] ) : ?>
					<span class="description"><?php echo esc_html( $field['description'] ); ?></span>
				<?php endif; ?>
			</p>
			<?php
		}
		?>
		<style>
			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-label {
				display: block;
				margin-bottom: 6px;
				font-weight: 600;
			}

			#<?php echo esc_html( self::ID ); ?> .description {
				display: block;
				margin-top: 4px;
			}
		</style>
		<?php
	}

	/**
	 * Stores the fields.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post being saved.
	 * @return void
	 */
	public function save( $post_id ) {
		$nonce_key = self::ID . '_nonce';

		if ( ! isset( $_POST[ $nonce_key ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce_key ] ) ), self::ID . '_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( $this->fields() as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}

			$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized on the next line, by type.

			/*
			 * A quote is stored as plain text rather than filtered HTML: it is
			 * reproduced verbatim from a review platform, so there is nothing
			 * in it an editor should be marking up.
			 */
			$value = 'textarea' === $field['type']
				? sanitize_textarea_field( $raw )
				: sanitize_text_field( $raw );

			update_post_meta( $post_id, $key, $value );
		}
	}
}

new IFly_Nepal_Testimonial_Meta_Box();
