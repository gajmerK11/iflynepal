<?php
/**
 * The "External Testimonial Links" screen.
 *
 * A submenu under Testimonials, beside Add New. One URL field per review
 * platform; whichever are filled in become the buttons under the carousel.
 *
 * Same shape as the theme's meta box: one class, hooked in its own
 * constructor, instantiated at the foot of the file.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Collects the links to the platforms the reviews can be checked on.
 *
 * @since 1.0.0
 */
class IFly_Nepal_Testimonial_Links_Settings {

	/**
	 * The screen's slug.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const PAGE = 'iflynepal-testimonial-links';

	/**
	 * Hooks the screen in.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_init', array( $this, 'register_setting' ) );
		add_action( 'wp_ajax_iflynepal_translate_note', array( $this, 'ajax_translate_note' ) );
	}

	/**
	 * The capability the screen is gated on.
	 *
	 * Matched to the post type rather than hard-coded, so it follows the same
	 * reasoning — and the same repair — as the menu the screen sits under.
	 * See the note in inc/cpts/testimonial-cpt.php.
	 *
	 * @since 1.0.0
	 *
	 * @return string Capability name.
	 */
	private function capability() {
		$post_type = get_post_type_object( IFLYNEPAL_TESTIMONIAL_POST_TYPE );

		return $post_type ? $post_type->cap->edit_posts : 'edit_pages';
	}

	/**
	 * Adds the screen under the Testimonials menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_page() {
		add_submenu_page(
			'edit.php?post_type=' . IFLYNEPAL_TESTIMONIAL_POST_TYPE,
			__( 'Add External Testimonial Links', 'iflynepal' ),
			__( 'Add External Testimonial Links', 'iflynepal' ),
			$this->capability(),
			self::PAGE,
			array( $this, 'render' )
		);
	}

	/**
	 * Registers the option and its sanitizer.
	 *
	 * One option holding every field, rather than one option per platform: it
	 * is a single form saved in one go, and a single row is one autoloaded
	 * lookup on the front end instead of six.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_setting() {
		register_setting(
			self::PAGE,
			IFLYNEPAL_TESTIMONIAL_LINKS_OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Cleans the submitted form.
	 *
	 * Anything not a registered platform is dropped rather than stored, so the
	 * option can never hold a key the front end does not know how to draw.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Raw submitted value.
	 * @return array Sanitized option.
	 */
	public function sanitize( $value ) {
		$clean = array();

		if ( ! is_array( $value ) ) {
			return $clean;
		}

		foreach ( iflynepal_testimonial_platforms() as $slug => $platform ) {
			if ( empty( $value[ $slug ] ) ) {
				continue;
			}

			$url = esc_url_raw( trim( (string) $value[ $slug ] ) );

			if ( '' !== $url ) {
				$clean[ $slug ] = $url;
			}
		}

		if ( isset( $value['note'] ) ) {
			/*
			 * A multilingual site submits one field per language — the note
			 * arrives as an array, keyed by whatever language slugs the form
			 * rendered. A single-language site still submits one plain field.
			 * Either shape is trusted only as far as being a string; an
			 * unrecognised language key is dropped instead of stored, the same
			 * rule the platform links above already follow.
			 */
			if ( is_array( $value['note'] ) ) {
				$langs = iflynepal_customizer_is_multilingual() ? wp_list_pluck( PLL()->model->get_languages_list(), 'slug' ) : array();
				$notes = array();

				foreach ( $value['note'] as $lang => $text ) {
					if ( ! in_array( $lang, $langs, true ) ) {
						continue;
					}

					$text = sanitize_text_field( (string) $text );

					if ( '' !== $text ) {
						$notes[ $lang ] = $text;
					}
				}

				if ( ! empty( $notes ) ) {
					$clean['note'] = $notes;
				}
			} else {
				$note = sanitize_text_field( (string) $value['note'] );

				if ( '' !== $note ) {
					$clean['note'] = $note;
				}
			}
		}

		return $clean;
	}

	/**
	 * Draws the screen.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		if ( ! current_user_can( $this->capability() ) ) {
			return;
		}

		$saved = get_option( IFLYNEPAL_TESTIMONIAL_LINKS_OPTION, array() );
		$saved = is_array( $saved ) ? $saved : array();
		$name  = IFLYNEPAL_TESTIMONIAL_LINKS_OPTION;
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Add External Testimonial Links', 'iflynepal' ); ?></h1>

			<p class="description">
				<?php esc_html_e( 'The platforms travellers can check the reviews on. A platform with a link becomes a button under the testimonial carousel; one left empty is not shown. Two buttons sit side by side, and a third starts a second row.', 'iflynepal' ); ?>
			</p>

			<form action="options.php" method="post">
				<?php settings_fields( self::PAGE ); ?>

				<table class="form-table" role="presentation">
					<tbody>
						<?php foreach ( iflynepal_testimonial_platforms() as $iflynepal_slug => $iflynepal_platform ) : ?>
							<?php $iflynepal_field_id = 'iflynepal-link-' . $iflynepal_slug; ?>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr( $iflynepal_field_id ); ?>">
										<?php echo esc_html( $iflynepal_platform['label'] ); ?>
									</label>
								</th>
								<td>
									<input
										type="url"
										class="regular-text code"
										id="<?php echo esc_attr( $iflynepal_field_id ); ?>"
										name="<?php echo esc_attr( $name . '[' . $iflynepal_slug . ']' ); ?>"
										value="<?php echo esc_attr( isset( $saved[ $iflynepal_slug ] ) ? $saved[ $iflynepal_slug ] : '' ); ?>"
										placeholder="<?php echo esc_attr( $iflynepal_platform['placeholder'] ); ?>">
								</td>
							</tr>
						<?php endforeach; ?>

						<?php if ( iflynepal_customizer_is_multilingual() ) : ?>
							<?php
							$iflynepal_note_saved  = isset( $saved['note'] ) ? $saved['note'] : '';
							$iflynepal_note_legacy = is_string( $iflynepal_note_saved ) ? $iflynepal_note_saved : '';
							$iflynepal_note_values = is_array( $iflynepal_note_saved ) ? $iflynepal_note_saved : array();
							$iflynepal_default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';
							?>
							<?php foreach ( PLL()->model->get_languages_list() as $iflynepal_lang ) : ?>
								<?php
								$iflynepal_note_field_id = 'iflynepal-link-note-' . $iflynepal_lang->slug;
								$iflynepal_note_value    = isset( $iflynepal_note_values[ $iflynepal_lang->slug ] )
									? $iflynepal_note_values[ $iflynepal_lang->slug ]
									: $iflynepal_note_legacy;
								$iflynepal_is_default    = ( $iflynepal_lang->slug === $iflynepal_default_lang );
								?>
								<tr>
									<th scope="row">
										<label for="<?php echo esc_attr( $iflynepal_note_field_id ); ?>">
											<?php
											printf(
												/* translators: %s: language name, e.g. "French". */
												esc_html__( 'Handwritten note (%s)', 'iflynepal' ),
												esc_html( $iflynepal_lang->name )
											);
											?>
										</label>
									</th>
									<td>
										<span class="iflynepal-note-field">
											<input
												type="text"
												class="regular-text"
												id="<?php echo esc_attr( $iflynepal_note_field_id ); ?>"
												name="<?php echo esc_attr( $name . '[note][' . $iflynepal_lang->slug . ']' ); ?>"
												value="<?php echo esc_attr( $iflynepal_note_value ); ?>"
												placeholder="<?php esc_attr_e( 'Others have shared theirs too, right here', 'iflynepal' ); ?>"
												<?php echo $iflynepal_is_default ? 'data-iflynepal-note-source' : ''; ?>>
											<?php if ( ! $iflynepal_is_default && function_exists( 'iflynepal_deepl_api_key' ) && '' !== iflynepal_deepl_api_key() ) : ?>
												<button
													type="button"
													class="button iflynepal-note-translate"
													data-source="iflynepal-link-note-<?php echo esc_attr( $iflynepal_default_lang ); ?>"
													data-dest="<?php echo esc_attr( $iflynepal_note_field_id ); ?>"
													data-lang="<?php echo esc_attr( $iflynepal_lang->slug ); ?>">
													<?php esc_html_e( 'Translate', 'iflynepal' ); ?>
												</button>
											<?php endif; ?>
										</span>
										<?php if ( $iflynepal_is_default ) : ?>
											<p class="description">
												<?php esc_html_e( 'The line in the handwritten face, with the arrow pointing at the buttons. Left empty, the default above is used.', 'iflynepal' ); ?>
											</p>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<th scope="row">
									<label for="iflynepal-link-note"><?php esc_html_e( 'Handwritten note', 'iflynepal' ); ?></label>
								</th>
								<td>
									<input
										type="text"
										class="regular-text"
										id="iflynepal-link-note"
										name="<?php echo esc_attr( $name . '[note]' ); ?>"
										value="<?php echo esc_attr( isset( $saved['note'] ) && is_string( $saved['note'] ) ? $saved['note'] : '' ); ?>"
										placeholder="<?php esc_attr_e( 'Others have shared theirs too, right here', 'iflynepal' ); ?>">
									<p class="description">
										<?php esc_html_e( 'The line in the handwritten face, with the arrow pointing at the buttons. Left empty, the default above is used.', 'iflynepal' ); ?>
									</p>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
		$this->render_translate_script();
	}

	/**
	 * The script behind each language's "Translate" button.
	 *
	 * One request per click, straight to admin-ajax.php: the note is a single
	 * short line, so there is no batching to be done and nothing gained by a
	 * separate JS file for a script this small and this tied to this one
	 * screen. Only printed when the multilingual fields above were drawn —
	 * a single-language site has no button for it to bind to.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function render_translate_script() {
		if ( ! iflynepal_customizer_is_multilingual() || ! function_exists( 'iflynepal_deepl_api_key' ) || '' === iflynepal_deepl_api_key() ) {
			return;
		}
		?>
		<script>
		( function() {
			document.querySelectorAll( '.iflynepal-note-translate' ).forEach( function( button ) {
				button.addEventListener( 'click', function() {
					var source = document.getElementById( button.dataset.source );
					var dest   = document.getElementById( button.dataset.dest );

					if ( ! source || ! dest || '' === source.value.trim() ) {
						return;
					}

					var original = button.textContent;
					button.disabled    = true;
					button.textContent = '<?php echo esc_js( __( 'Translating…', 'iflynepal' ) ); ?>';

					var body = new URLSearchParams( {
						action: 'iflynepal_translate_note',
						nonce: '<?php echo esc_js( wp_create_nonce( 'iflynepal_translate_note' ) ); ?>',
						text: source.value,
						lang: button.dataset.lang
					} );

					fetch( ajaxurl, { method: 'POST', credentials: 'same-origin', body: body } )
						.then( function( response ) { return response.json(); } )
						.then( function( result ) {
							if ( result && result.success && result.data && result.data.text ) {
								dest.value = result.data.text;
							}
						} )
						.finally( function() {
							button.disabled    = false;
							button.textContent = original;
						} );
				} );
			} );
		} )();
		</script>
		<?php
	}

	/**
	 * Translates one language's note on demand, via DeepL.
	 *
	 * The client sends the default language's current, possibly-unsaved field
	 * value — not the saved option — so a note edited a moment ago translates
	 * from what is actually on screen rather than from what Save Changes last
	 * wrote.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function ajax_translate_note() {
		check_ajax_referer( 'iflynepal_translate_note', 'nonce' );

		if ( ! current_user_can( $this->capability() ) ) {
			wp_send_json_error( array( 'message' => 'forbidden' ), 403 );
		}

		if ( ! function_exists( 'iflynepal_deepl_translate_batch' ) || ! function_exists( 'iflynepal_deepl_lang_code' ) || '' === iflynepal_deepl_api_key() ) {
			wp_send_json_error( array( 'message' => 'deepl unavailable' ), 400 );
		}

		$text = isset( $_POST['text'] ) ? sanitize_text_field( wp_unslash( $_POST['text'] ) ) : '';
		$lang = isset( $_POST['lang'] ) ? sanitize_key( wp_unslash( $_POST['lang'] ) ) : '';

		if ( '' === $text || '' === $lang || ! function_exists( 'PLL' ) || ! PLL()->model->get_language( $lang ) ) {
			wp_send_json_error( array( 'message' => 'bad request' ), 400 );
		}

		$default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';
		$target_code  = iflynepal_deepl_lang_code( $lang, true );
		$source_code  = $default_lang ? iflynepal_deepl_lang_code( $default_lang, false ) : '';

		$translated = iflynepal_deepl_translate_batch( array( $text ), $target_code, $source_code );

		if ( empty( $translated[0] ) ) {
			wp_send_json_error( array( 'message' => 'translation failed' ), 502 );
		}

		wp_send_json_success( array( 'text' => $translated[0] ) );
	}
}

new IFly_Nepal_Testimonial_Links_Settings();
