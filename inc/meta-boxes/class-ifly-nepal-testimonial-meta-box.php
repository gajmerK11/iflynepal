<?php
/**
 * The Testimonials meta box.
 *
 * Holds the review's fields, the reviewer's photograph and the places the
 * review is shown on. Same shape as the meta boxes in the reference theme: one class,
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
			'_iflynepal_review_headline'     => array(
				'label'       => __( 'Review Headline', 'iflynepal' ),
				'description' => __( 'The line set in italics at the top of the card. A short phrase lifted from the review reads better than a summary written for it.', 'iflynepal' ),
				'type'        => 'text',
			),
			'_iflynepal_review_body'         => array(
				'label'       => __( 'Review Body', 'iflynepal' ),
				'description' => __( "The traveller's own words, quoted verbatim from the platform the review came from. Two to four sentences. A testimonial with an empty body is not shown.", 'iflynepal' ),
				'type'        => 'textarea',
			),
			'_iflynepal_reviewer_name'       => array(
				'label'       => __( 'Reviewer Name', 'iflynepal' ),
				'description' => '',
				'type'        => 'text',
			),
			'_iflynepal_reviewer_country'    => array(
				'label'       => __( 'Reviewer Country', 'iflynepal' ),
				'description' => __( 'Printed after the name, as "Marcus, Germany".', 'iflynepal' ),
				'type'        => 'text',
			),
			'_iflynepal_reviewer_photo'      => array(
				'label'       => __( 'Reviewer Photo', 'iflynepal' ),
				'description' => __( 'Square works best; the card crops it to a circle at 40px. Leave it empty and the card draws a neutral avatar instead.', 'iflynepal' ),
				'type'        => 'media',
			),
			IFLYNEPAL_TESTIMONIAL_TARGET_KEY => array(
				'label'       => __( 'Display On Pages', 'iflynepal' ),
				'description' => __( 'Every place this review appears — pages, and package type archives when the booking plugin is active. Tick as many as it belongs on; the review is shown in full on each of them. Left untouched, it appears nowhere. The review is named after the first place ticked.', 'iflynepal' ),
				'type'        => 'target',
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
			/*
			 * The target field is the one that holds a row per value rather than
			 * a single value, so it is read as a list and every other field is
			 * read as the scalar it is.
			 */
			$value    = 'target' === $field['type']
				? iflynepal_testimonial_targets( $post->ID )
				: get_post_meta( $post->ID, $key, true );
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

					case 'target':
						$this->render_target_field( $field_id, $key, (array) $value );
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
	 * Draws the chooser for the places a review is shown.
	 *
	 * Several, not one. A review used to belong to a single page and this was a
	 * select; the same quote is worth showing on the homepage and on the retreat
	 * archive, so it is a list of checkboxes and choosing another place adds to
	 * the set rather than moving the review out of the one it was in.
	 *
	 * Hand-built rather than wp_dropdown_pages(), which can only ever list pages
	 * and only ever picks one. The options come from
	 * iflynepal_testimonial_display_targets(), so a plugin's own templates — the
	 * package type archives — appear here in their own group without the theme
	 * naming any of them.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $field_id Fieldset's DOM id.
	 * @param string   $key      Meta key, used as the base of the input name.
	 * @param string[] $stored   Targets currently chosen.
	 * @return void
	 */
	private function render_target_field( $field_id, $key, $stored ) {
		$groups  = iflynepal_testimonial_display_targets();
		$choices = iflynepal_testimonial_display_target_choices();
		$name    = $key . '[]';
		$number  = 0;
		?>
		<span class="iflynepal-meta-targets" id="<?php echo esc_attr( $field_id ); ?>">
			<?php
			/*
			 * A marker, so that clearing every box means "shown nowhere" rather
			 * than "not submitted". An unchecked checkbox posts nothing at all, so
			 * without this the save routine cannot tell a review the editor has
			 * just taken off every page from one whose field was never on screen —
			 * and would leave the old assignments in place for both.
			 */
			?>
			<input type="hidden" name="<?php echo esc_attr( $key ); ?>_submitted" value="1">

			<?php
			/*
			 * A target that is no longer on offer is still drawn, and still ticked.
			 * A plugin switched off takes its own targets out of the list with it,
			 * and without this the review would show as shown nowhere — so opening
			 * it and pressing Update, changing nothing, would unassign it.
			 */
			foreach ( $stored as $orphan_target ) :
				if ( isset( $choices[ $orphan_target ] ) ) :
					continue;
				endif;

				$orphan_label = iflynepal_testimonial_target_label( $orphan_target );
				++$number;
				?>
				<label class="iflynepal-meta-targets__item" for="<?php echo esc_attr( $field_id . '-' . $number ); ?>">
					<input
						type="checkbox"
						id="<?php echo esc_attr( $field_id . '-' . $number ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $orphan_target ); ?>"
						checked>
					<?php
					printf(
						/* translators: %s: the name of the page or archive the review is shown on. */
						esc_html__( '%s (currently unavailable)', 'iflynepal' ),
						'' === $orphan_label ? esc_html( $orphan_target ) : esc_html( $orphan_label )
					);
					?>
				</label>
				<?php
			endforeach;
			?>

			<?php foreach ( $groups as $group ) : ?>
				<?php if ( empty( $group['options'] ) || ! is_array( $group['options'] ) ) : ?>
					<?php continue; ?>
				<?php endif; ?>

				<span class="iflynepal-meta-targets__group">
					<span class="iflynepal-meta-targets__group-label">
						<?php echo esc_html( isset( $group['label'] ) ? $group['label'] : '' ); ?>
					</span>

					<?php foreach ( $group['options'] as $target => $label ) : ?>
						<?php $target = iflynepal_testimonial_normalize_target( $target ); ?>
						<?php if ( '' === $target ) : ?>
							<?php continue; ?>
						<?php endif; ?>
						<?php ++$number; ?>
						<label class="iflynepal-meta-targets__item" for="<?php echo esc_attr( $field_id . '-' . $number ); ?>">
							<input
								type="checkbox"
								id="<?php echo esc_attr( $field_id . '-' . $number ); ?>"
								name="<?php echo esc_attr( $name ); ?>"
								value="<?php echo esc_attr( $target ); ?>"
								<?php checked( in_array( $target, $stored, true ) ); ?>>
							<?php echo esc_html( $label ); ?>
						</label>
					<?php endforeach; ?>
				</span>
			<?php endforeach; ?>
		</span>
		<?php
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

			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-targets {
				display: block;
				max-height: 260px;
				padding: 8px 12px;
				overflow-y: auto;
				border: 1px solid #dcdcde;
				border-radius: 4px;
				background: #fff;
			}

			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-targets__group-label {
				display: block;
				margin: 10px 0 4px;
				color: #646970;
				font-size: 11px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: .04em;
			}

			#<?php echo esc_html( self::ID ); ?> .iflynepal-meta-targets__item {
				display: block;
				padding: 2px 0;
				font-weight: 400;
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
			/*
			 * The targets are handled before the "was it submitted" test, and
			 * have to be: an unticked checkbox posts nothing, so a review taken
			 * off every page submits no value at all under this key. Its own
			 * marker says the field was on screen, and the absent list then
			 * means an empty one rather than "leave what is stored alone".
			 */
			if ( 'target' === $field['type'] ) {
				if ( isset( $_POST[ $key . '_submitted' ] ) ) {
					$this->save_targets( $post_id, isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : array() ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized per value in save_targets().
				}

				continue;
			}

			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}

			$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized on the next lines, by type.

			switch ( $field['type'] ) {
				case 'media':
					// An attachment ID and nothing else.
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
	 * Stores the places a review is shown.
	 *
	 * One meta row per target, under the one key, because that is what the query
	 * selecting a request's reviews matches — see iflynepal_testimonial_targets().
	 * The rows are deleted and rewritten rather than reconciled: the set is at
	 * most a handful of values, and a reconciliation is two loops that have to
	 * agree with each other.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $post_id Review being saved.
	 * @param mixed $raw     Submitted list, unslashed.
	 * @return void
	 */
	private function save_targets( $post_id, $raw ) {
		$stored  = iflynepal_testimonial_targets( $post_id );
		$choices = iflynepal_testimonial_display_target_choices();
		$keep    = array();

		foreach ( (array) $raw as $value ) {
			$target = iflynepal_testimonial_normalize_target( sanitize_text_field( is_scalar( $value ) ? (string) $value : '' ) );

			if ( '' === $target || in_array( $target, $keep, true ) ) {
				continue;
			}

			/*
			 * A checkbox is markup, and markup is a suggestion — anything at all
			 * can be posted to this screen, so a target has to be one the site
			 * actually offers rather than merely one that is shaped right.
			 *
			 * The exception is a target already stored. One whose plugin is
			 * switched off is not on offer and is still the editor's own choice;
			 * re-saving the review for an unrelated reason must not throw it away.
			 */
			if ( ! isset( $choices[ $target ] ) && ! in_array( $target, $stored, true ) ) {
				continue;
			}

			$keep[] = $target;
		}

		if ( $keep === $stored ) {
			return;
		}

		delete_post_meta( $post_id, IFLYNEPAL_TESTIMONIAL_TARGET_KEY );

		foreach ( $keep as $target ) {
			add_post_meta( $post_id, IFLYNEPAL_TESTIMONIAL_TARGET_KEY, $target );
		}
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
