<?php
/**
 * The author profile fields, on the user's own edit screen.
 *
 * Same shape as CloudColleague's inc/user-profile.php: a WordPress user is the
 * author, not a custom post type, so its extra fields live on the ordinary
 * profile.php / user-edit.php screen rather than in a meta box. One divergence
 * from that reference, kept deliberately: the profile photo is stored as an
 * attachment ID rather than a raw URL, matching every other image field this
 * project stores. A URL breaks the day the site changes domain, an
 * attachment ID does not.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders the "iFly Nepal Author Profile" section on a user's edit screen.
 *
 * @since 1.0.0
 *
 * @param WP_User $user User being edited.
 * @return void
 */
function iflynepal_render_author_profile_fields( $user ) {
	$user_id = $user->ID;
	$photo   = (int) get_user_meta( $user_id, 'iflynepal_author_photo', true );
	?>
	<h3><?php esc_html_e( 'iFly Nepal Author Profile', 'iflynepal' ); ?></h3>
	<p><?php esc_html_e( 'Shown on this person\'s author page and on the Authors directory, when they have a published article or news story.', 'iflynepal' ); ?></p>
	<table class="form-table" role="presentation">

		<tr>
			<th><label for="iflynepal_author_role"><?php esc_html_e( 'Role', 'iflynepal' ); ?></label></th>
			<td>
				<input type="text"
					id="iflynepal_author_role"
					name="iflynepal_author_role"
					value="<?php echo esc_attr( get_user_meta( $user_id, 'iflynepal_author_role', true ) ); ?>"
					class="regular-text">
				<p class="description"><?php esc_html_e( 'Short line under the name, e.g. "Trip planning team, Kathmandu" or "Guide". Falls back to the Biographical Info field above, then to a house line, when left blank.', 'iflynepal' ); ?></p>
			</td>
		</tr>

		<tr>
			<th><label for="iflynepal_author_hand"><?php esc_html_e( 'Handwritten note', 'iflynepal' ); ?></label></th>
			<td>
				<input type="text"
					id="iflynepal_author_hand"
					name="iflynepal_author_hand"
					value="<?php echo esc_attr( get_user_meta( $user_id, 'iflynepal_author_hand', true ) ); ?>"
					class="regular-text">
				<p class="description"><?php esc_html_e( 'Optional, short. Sits in the handwritten script beside the role, e.g. "the people who answer your messages". Leave blank for none.', 'iflynepal' ); ?></p>
			</td>
		</tr>

		<tr>
			<th><label for="iflynepal_author_bio"><?php esc_html_e( 'Long biography', 'iflynepal' ); ?></label></th>
			<td>
				<textarea id="iflynepal_author_bio"
					name="iflynepal_author_bio"
					rows="5"
					class="large-text"><?php echo esc_textarea( get_user_meta( $user_id, 'iflynepal_author_bio', true ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'The opening paragraphs on the full author page. A blank line starts a new paragraph. This is separate from the short Biographical Info field above, which is used in card bylines elsewhere on the site.', 'iflynepal' ); ?></p>
			</td>
		</tr>

		<tr>
			<th><label for="iflynepal_author_expertise"><?php esc_html_e( 'Expertise', 'iflynepal' ); ?></label></th>
			<td>
				<input type="text"
					id="iflynepal_author_expertise"
					name="iflynepal_author_expertise"
					value="<?php echo esc_attr( get_user_meta( $user_id, 'iflynepal_author_expertise', true ) ); ?>"
					class="regular-text">
				<p class="description"><?php esc_html_e( 'Comma-separated Article Category slugs, e.g. "trekking, peak-climbing, wellness-retreats". Shown as pills linking to each category. A slug that does not match a real category is skipped.', 'iflynepal' ); ?></p>
			</td>
		</tr>

		<tr>
			<th><label for="iflynepal_author_experience"><?php esc_html_e( 'Experience', 'iflynepal' ); ?></label></th>
			<td>
				<textarea id="iflynepal_author_experience"
					name="iflynepal_author_experience"
					rows="4"
					class="large-text"><?php echo esc_textarea( get_user_meta( $user_id, 'iflynepal_author_experience', true ) ); ?></textarea>
			</td>
		</tr>

		<tr>
			<th><label for="iflynepal_author_contribution"><?php esc_html_e( 'Contribution at iFly Nepal', 'iflynepal' ); ?></label></th>
			<td>
				<textarea id="iflynepal_author_contribution"
					name="iflynepal_author_contribution"
					rows="4"
					class="large-text"><?php echo esc_textarea( get_user_meta( $user_id, 'iflynepal_author_contribution', true ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Experience and Contribution may both include a link, written as ordinary text, e.g. https://wa.me/9779800000000. It is turned into a clickable link automatically.', 'iflynepal' ); ?></p>
			</td>
		</tr>

		<?php
		$iflynepal_social_fields = iflynepal_author_social_field_defs();

		foreach ( $iflynepal_social_fields as $iflynepal_field => $iflynepal_label ) :
			?>
			<tr>
				<th><label for="<?php echo esc_attr( $iflynepal_field ); ?>"><?php echo esc_html( $iflynepal_label ); ?></label></th>
				<td>
					<input type="url"
						id="<?php echo esc_attr( $iflynepal_field ); ?>"
						name="<?php echo esc_attr( $iflynepal_field ); ?>"
						value="<?php echo esc_attr( get_user_meta( $user_id, $iflynepal_field, true ) ); ?>"
						class="regular-text">
				</td>
			</tr>
		<?php endforeach; ?>

		<tr>
			<th><label><?php esc_html_e( 'Profile Photo', 'iflynepal' ); ?></label></th>
			<td>
				<img id="iflynepal-author-photo-preview"
					src="<?php echo $photo ? esc_url( wp_get_attachment_image_url( $photo, 'thumbnail' ) ) : ''; ?>"
					style="width:96px;height:96px;object-fit:cover;border-radius:50%;display:<?php echo $photo ? 'block' : 'none'; ?>;margin-bottom:8px;">
				<input type="hidden" name="iflynepal_author_photo" id="iflynepal_author_photo"
					value="<?php echo esc_attr( $photo ); ?>">
				<button type="button" id="iflynepal-author-photo-upload" class="button">
					<?php echo $photo ? esc_html__( 'Change Photo', 'iflynepal' ) : esc_html__( 'Upload Photo', 'iflynepal' ); ?>
				</button>
				<button type="button" id="iflynepal-author-photo-remove" class="button"
					style="margin-left:4px;<?php echo $photo ? '' : 'display:none;'; ?>">
					<?php esc_html_e( 'Remove Photo', 'iflynepal' ); ?>
				</button>
				<p class="description"><?php esc_html_e( 'Overrides the Gravatar everywhere this person is credited. The Authors directory card omits the photo slot entirely when this is empty, rather than showing a placeholder.', 'iflynepal' ); ?></p>
				<script>
				( function ( $ ) {
					var frame;

					$( '#iflynepal-author-photo-upload' ).on( 'click', function ( e ) {
						e.preventDefault();
						if ( frame ) { frame.open(); return; }
						frame = wp.media( {
							title:    <?php echo wp_json_encode( __( 'Select Profile Photo', 'iflynepal' ) ); ?>,
							button:   { text: <?php echo wp_json_encode( __( 'Use this photo', 'iflynepal' ) ); ?> },
							multiple: false,
							library:  { type: 'image' }
						} );
						frame.on( 'select', function () {
							var attachment = frame.state().get( 'selection' ).first().toJSON();
							var preview    = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

							$( '#iflynepal_author_photo' ).val( attachment.id );
							$( '#iflynepal-author-photo-preview' ).attr( 'src', preview ).css( 'display', 'block' );
							$( '#iflynepal-author-photo-upload' ).text( <?php echo wp_json_encode( __( 'Change Photo', 'iflynepal' ) ); ?> );
							$( '#iflynepal-author-photo-remove' ).show();
						} );
						frame.open();
					} );

					$( '#iflynepal-author-photo-remove' ).on( 'click', function ( e ) {
						e.preventDefault();
						$( '#iflynepal_author_photo' ).val( '' );
						$( '#iflynepal-author-photo-preview' ).attr( 'src', '' ).hide();
						$( '#iflynepal-author-photo-upload' ).text( <?php echo wp_json_encode( __( 'Upload Photo', 'iflynepal' ) ); ?> );
						$( this ).hide();
					} );
				}( jQuery ) );
				</script>
			</td>
		</tr>

	</table>
	<?php
}
add_action( 'show_user_profile', 'iflynepal_render_author_profile_fields' );
add_action( 'edit_user_profile', 'iflynepal_render_author_profile_fields' );

/**
 * Renders the same fields on the Add New User screen.
 *
 * CloudColleague never hooks `user_new_form`, so this is a deliberate
 * addition rather than something copied from it: a new author's role and
 * socials can be typed once, at creation, instead of needing a second trip
 * to their profile right after. The fields themselves are exactly
 * iflynepal_render_author_profile_fields()'s. There being no user yet to
 * read meta from is why a blank WP_User stands in for one; every field on it
 * reads as empty, which is what an Add New User screen should show.
 *
 * `user_new_form` also fires on Multisite's "Add Existing User" screen, with
 * $context 'add-existing-user'. That user already has these fields on their
 * own profile, so this only draws on an actual new account.
 *
 * @since 1.0.0
 *
 * @param string $context Which Add User screen is rendering.
 * @return void
 */
function iflynepal_render_author_profile_fields_on_create( $context ) {
	if ( 'add-new-user' !== $context ) {
		return;
	}

	iflynepal_render_author_profile_fields( new WP_User() );
}
add_action( 'user_new_form', 'iflynepal_render_author_profile_fields_on_create' );

/**
 * The social fields, name to label, in the order every social row on this
 * site's author pages draws them.
 *
 * @since 1.0.0
 *
 * @return array<string,string> Field name => admin label.
 */
function iflynepal_author_social_field_defs() {
	return array(
		'iflynepal_author_social_facebook'  => __( 'Facebook URL', 'iflynepal' ),
		'iflynepal_author_social_instagram' => __( 'Instagram URL', 'iflynepal' ),
		'iflynepal_author_social_youtube'   => __( 'YouTube URL', 'iflynepal' ),
		'iflynepal_author_social_x'         => __( 'X (Twitter) URL', 'iflynepal' ),
		'iflynepal_author_social_whatsapp'  => __( 'WhatsApp URL', 'iflynepal' ),
		'iflynepal_author_social_website'   => __( 'Website URL', 'iflynepal' ),
	);
}

/**
 * Saves the author profile fields.
 *
 * @since 1.0.0
 *
 * @param int $user_id User being saved.
 * @return void
 */
function iflynepal_save_author_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}

	$text_fields     = array( 'iflynepal_author_role', 'iflynepal_author_hand', 'iflynepal_author_expertise' );
	$textarea_fields = array( 'iflynepal_author_bio', 'iflynepal_author_experience', 'iflynepal_author_contribution' );
	$url_fields      = array_keys( iflynepal_author_social_field_defs() );

	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Core's own user-edit.php screen supplies the nonce this hook fires behind.
			update_user_meta( $user_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}
	}

	foreach ( $textarea_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			update_user_meta( $user_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}
	}

	foreach ( $url_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			update_user_meta( $user_id, $field, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}
	}

	if ( isset( $_POST['iflynepal_author_photo'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		update_user_meta( $user_id, 'iflynepal_author_photo', absint( wp_unslash( $_POST['iflynepal_author_photo'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
	}
}
add_action( 'personal_options_update', 'iflynepal_save_author_profile_fields' );
add_action( 'edit_user_profile_update', 'iflynepal_save_author_profile_fields' );

/*
 * The Add New User screen saves through a different action entirely: core
 * creates the account first and only then fires `user_register`, rather than
 * posting to an `edit_user_profile_update`-style hook on an existing one.
 * Same save function either way: it only ever reads $_POST and writes user
 * meta, neither of which cares which screen sent them.
 */
add_action( 'user_register', 'iflynepal_save_author_profile_fields' );

/**
 * Enqueues the media uploader on the user profile screens.
 *
 * @since 1.0.0
 *
 * @param string $hook Current admin page.
 * @return void
 */
function iflynepal_enqueue_author_profile_media( $hook ) {
	if ( ! in_array( $hook, array( 'profile.php', 'user-edit.php', 'user-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'iflynepal_enqueue_author_profile_media' );

/**
 * Replaces the Gravatar with the uploaded profile photo, wherever one is set.
 *
 * The same filter CloudColleague uses. Falling through to `$args` when there
 * is no custom photo is what leaves an author with none of these still
 * showing their Gravatar in the byline avatar initials fall back to instead
 * (see iflynepal_article_initials()). This filter only ever adds a picture,
 * never removes the plain-letter fallback those already have.
 *
 * @since 1.0.0
 *
 * @param array             $args        Avatar arguments.
 * @param int|string|object $id_or_email User identifier.
 * @return array Filtered arguments.
 */
function iflynepal_author_custom_avatar_data( $args, $id_or_email ) {
	$user_id = null;

	if ( is_numeric( $id_or_email ) ) {
		$user_id = (int) $id_or_email;
	} elseif ( $id_or_email instanceof WP_User ) {
		$user_id = $id_or_email->ID;
	} elseif ( $id_or_email instanceof WP_Post ) {
		$user_id = (int) $id_or_email->post_author;
	} elseif ( $id_or_email instanceof WP_Comment && ! empty( $id_or_email->user_id ) ) {
		$user_id = (int) $id_or_email->user_id;
	} elseif ( is_string( $id_or_email ) ) {
		$user = get_user_by( 'email', $id_or_email );

		if ( $user ) {
			$user_id = $user->ID;
		}
	}

	if ( ! $user_id ) {
		return $args;
	}

	$photo_id = (int) get_user_meta( $user_id, 'iflynepal_author_photo', true );

	if ( ! $photo_id ) {
		return $args;
	}

	$size = isset( $args['size'] ) ? (int) $args['size'] : 96;
	$url  = wp_get_attachment_image_url( $photo_id, array( $size, $size ) );

	if ( ! $url ) {
		return $args;
	}

	$args['url']          = $url;
	$args['found_avatar'] = true;

	return $args;
}
add_filter( 'pre_get_avatar_data', 'iflynepal_author_custom_avatar_data', 10, 2 );

/**
 * Adds an Articles column to the admin Users list table.
 *
 * @since 1.0.0
 *
 * @param string[] $columns Existing columns.
 * @return string[] Filtered columns.
 */
function iflynepal_users_table_articles_column( $columns ) {
	$columns['iflynepal_articles'] = __( 'Articles', 'iflynepal' );

	return $columns;
}
add_filter( 'manage_users_columns', 'iflynepal_users_table_articles_column' );

/**
 * Fills the Articles column on the admin Users list table.
 *
 * @since 1.0.0
 *
 * @param string $value       Existing cell value.
 * @param string $column_name Column being rendered.
 * @param int    $user_id     Row's user.
 * @return string Filtered value.
 */
function iflynepal_users_table_articles_column_data( $value, $column_name, $user_id ) {
	if ( 'iflynepal_articles' !== $column_name ) {
		return $value;
	}

	return (string) count_user_posts( $user_id, IFLYNEPAL_ARTICLE_POST_TYPE, true );
}
add_filter( 'manage_users_custom_column', 'iflynepal_users_table_articles_column_data', 10, 3 );

/**
 * Narrows the Articles column on the admin Users list table.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_users_table_column_styles() {
	$screen = get_current_screen();

	if ( ! $screen || 'users' !== $screen->id ) {
		return;
	}

	echo '<style>.column-iflynepal_articles{width:80px}</style>';
}
add_action( 'admin_head', 'iflynepal_users_table_column_styles' );
