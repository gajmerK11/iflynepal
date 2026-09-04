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
			$clean['note'] = sanitize_text_field( (string) $value['note'] );
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
									value="<?php echo esc_attr( isset( $saved['note'] ) ? $saved['note'] : '' ); ?>"
									placeholder="<?php esc_attr_e( 'Others have shared theirs too, right here', 'iflynepal' ); ?>">
								<p class="description">
									<?php esc_html_e( 'The line in the handwritten face, with the arrow pointing at the buttons. Left empty, the default above is used.', 'iflynepal' ); ?>
								</p>
							</td>
						</tr>
					</tbody>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

new IFly_Nepal_Testimonial_Links_Settings();
