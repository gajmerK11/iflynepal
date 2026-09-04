<?php
/**
 * The Testimonials meta box.
 *
 * Holds the review's fields, the reviewer's photograph and the page the review
 * is shown on. Same shape as the meta boxes in the reference theme: one class,
 * hooked in its own constructor, instantiated at the foot of the file.
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
			'_iflynepal_reviewer_photo'   => array(
				'label'       => __( 'Reviewer Photo', 'iflynepal' ),
				'description' => __( 'Square works best; the card crops it to a circle at 40px. Leave it empty and the card draws a neutral avatar instead.', 'iflynepal' ),
				'type'        => 'media',
			),
			'_iflynepal_display_page'     => array(
				'label'       => __( 'Display On Page', 'iflynepal' ),
				'description' => __( 'The one page this review appears on. A review belongs to a single page, so choosing another page here moves it rather than copying it. Left unassigned, it appears nowhere.', 'iflynepal' ),
				'type'        => 'page',
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
			$value    = get_post_meta( $post->ID, $key, true );
			$field_id = str_replace( '_iflynepal_', 'iflynepal-', $key );
			?>
			<p class="iflynepal-meta-field">
				<label class="iflynepal-meta-label" for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $field['label'] ); ?>
				</label>

				<?php
				switch ( $field['type'] ) {
					case 'textarea':
						?>
						<textarea
							class="widefat"
							id="<?php echo esc_attr( $field_id ); ?>"
							name="<?php echo esc_attr( $key ); ?>"
							rows="5"><?php echo esc_textarea( (string) $value ); ?></textarea>
						<?php
						break;

					case 'media':
						$this->render_media_field( $field_id, $key, (int) $value );
						break;

					case 'page':
						$this->render_page_field( $field_id, $key, (int) $value );
						break;

					default:
						?>
						<input
							class="widefat"
							type="text"
							id="<?php echo esc_attr( $field_id ); ?>"
							name="<?php echo esc_attr( $key ); ?>"
							value="<?php echo esc_attr( (string) $value ); ?>">
						<?php
						break;
				}
				?>

				<?php if ( '' !== $field['description'] ) : ?>
					<span class="description"><?php echo esc_html( $field['description'] ); ?></span>
				<?php endif; ?>
			</p>
			<?php
		}

		$this->render_styles();
	}

	/**
	 * Draws the photograph chooser.
	 *
	 * The stored value is an attachment ID in a hidden input; the buttons beside
	 * it drive the media library through assets/js/admin/testimonial-photo.js.
	 * Without JavaScript the field is inert rather than broken — the hidden
	 * input still posts whatever was already chosen.
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_id      Input's DOM id.
	 * @param string $key           Meta key, used as the input name.
	 * @param int    $attachment_id Currently chosen attachment.
	 * @return void
	 */
	private function render_media_field( $field_id, $key, $attachment_id ) {
		$image = $attachment_id ? wp_get_attachment_image( $attachment_id, 'thumbnail' ) : '';
		?>
		<span class="iflynepal-meta-media" data-iflynepal-media>
			<span class="iflynepal-meta-media__preview" data-iflynepal-media-preview>
				<?php
				// Built by wp_get_attachment_image(), which escapes its own output.
				echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</span>
			<input
				type="hidden"
				id="<?php echo esc_attr( $field_id ); ?>"
				name="<?php echo esc_attr( $key ); ?>"
				value="<?php echo esc_attr( (string) $attachment_id ); ?>"
				data-iflynepal-media-value>
			<button type="button" class="button" data-iflynepal-media-select>
				<?php esc_html_e( 'Choose photo', 'iflynepal' ); ?>
			</button>
			<button type="button" class="button-link" data-iflynepal-media-remove<?php echo $attachment_id ? '' : ' hidden'; ?>>
				<?php esc_html_e( 'Remove', 'iflynepal' ); ?>
			</button>
		</span>
		<?php
	}

	/**
	 * Draws the page chooser.
	 *
	 * One page, not several: a review belongs to a single page, so this is a
	 * select rather than a list of checkboxes. Choosing another page moves the
	 * review rather than copying it.
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_id Select's DOM id.
	 * @param string $key      Meta key, used as the select name.
	 * @param int    $page_id  Currently chosen page.
	 * @return void
	 */
	private function render_page_field( $field_id, $key, $page_id ) {
		/*
		 * Captured rather than echoed so the escaping sniff can see that what
		 * reaches the page is core's own markup, not the arguments handed in.
		 */
		echo wp_dropdown_pages(
			array(
				'id'                => $field_id,
				'name'              => $key,
				'selected'          => $page_id,
				'show_option_none'  => __( '— Not shown on any page —', 'iflynepal' ),
				'option_none_value' => 0,
				'class'             => 'widefat',
				'post_status'       => 'publish',
				'echo'              => 0,
			)
		);
	}

	/**
	 * The handful of rules the box needs.
	 *
	 * Printed inline rather than shipped as a stylesheet: it is a few
	 * declarations that only ever apply on this one editor screen.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function render_styles() {
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

			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-media {
				display: flex;
				align-items: center;
				gap: 12px;
			}

			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-media__preview img {
				display: block;
				width: 64px;
				height: 64px;
				border-radius: 50%;
				object-fit: cover;
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

			$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized on the next lines, by type.

			switch ( $field['type'] ) {
				case 'media':
				case 'page':
					// Both hold an ID and nothing else.
					$value = absint( $raw );
					break;

				case 'textarea':
					/*
					 * A quote is stored as plain text rather than filtered HTML:
					 * it is reproduced verbatim from a review platform, so there
					 * is nothing in it an editor should be marking up.
					 */
					$value = sanitize_textarea_field( $raw );
					break;

				default:
					$value = sanitize_text_field( $raw );
					break;
			}

			update_post_meta( $post_id, $key, $value );
		}

		$this->rename( $post_id );
	}

	/**
	 * Names the review after the page it was just assigned to.
	 *
	 * Runs after the fields are stored, because the title is derived from one
	 * of them. The post type has no title field, so this is the only thing
	 * that ever sets it.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post being saved.
	 * @return void
	 */
	private function rename( $post_id ) {
		$title = iflynepal_testimonial_generated_title( $post_id );

		if ( (string) get_post_field( 'post_title', $post_id ) === $title ) {
			return;
		}

		/*
		 * wp_update_post() fires save_post again, which would land straight
		 * back here. Unhooked for the write and hooked back after.
		 */
		remove_action( 'save_post', array( $this, 'save' ) );

		wp_update_post(
			array(
				'ID'         => $post_id,
				'post_title' => $title,
				'post_name'  => sanitize_title( $title ),
			)
		);

		add_action( 'save_post', array( $this, 'save' ) );
	}
}

new IFly_Nepal_Testimonial_Meta_Box();
