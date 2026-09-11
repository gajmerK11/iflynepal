<?php
/**
 * Sustainability Policy page: the editable parts and their defaults.
 *
 * The hero photograph, and the Sustainability Coordinator card in clause 06.
 * The policy itself is not editable — see inc/sustainability.php — but who
 * holds that role, and how to reach them, changes on its own schedule and
 * should not wait for a theme release.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * Under assets/images/policy/ beside the other legal pages' heroes, and named
 * for what it shows rather than for the page — see the note above
 * IFLYNEPAL_COOKIE_HERO_IMAGE_DEFAULT on content blockers matching words in a
 * request path.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_SUSTAINABILITY_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/policy/hero-policy-ama-dablam.jpg' );

/**
 * The coordinator the design names.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_SUSTAINABILITY_COORDINATOR_NAME_DEFAULT', 'Prem' );

/**
 * The coordinator's direct line, as the design has it.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_SUSTAINABILITY_COORDINATOR_PHONE_DEFAULT', '+977 9851075128' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_sustainability_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_sustainability_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_SUSTAINABILITY_HERO_IMAGE_DEFAULT;
}

/**
 * Renders the Sustainability Coordinator card's contents.
 *
 * Text only: the role, the name and the two contact links. The design's
 * initial-letter avatar was taken out at the client's request. The email
 * follows the footer's office address when left empty, since that is the
 * inbox the design sends it to. Either link is dropped when it has nothing to
 * point at, and the card with it when there is no name.
 *
 * Also the selective-refresh render callback, so the card redraws as it is
 * edited.
 *
 * @since 1.0.0
 *
 * @return string Markup, or an empty string when no name is set.
 */
function iflynepal_render_sustainability_coordinator() {
	$name = trim( (string) get_theme_mod( 'iflynepal_sustainability_coordinator_name', IFLYNEPAL_SUSTAINABILITY_COORDINATOR_NAME_DEFAULT ) );

	if ( '' === $name ) {
		return '';
	}

	$email = sanitize_email( (string) get_theme_mod( 'iflynepal_sustainability_coordinator_email', '' ) );

	if ( ! $email ) {
		$email = sanitize_email( iflynepal_footer_office_field( 'email' ) );
	}

	$phone = trim( (string) get_theme_mod( 'iflynepal_sustainability_coordinator_phone', IFLYNEPAL_SUSTAINABILITY_COORDINATOR_PHONE_DEFAULT ) );
	$links = '';

	if ( $email ) {
		$links .= sprintf(
			'<a href="%1$s"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>%2$s</a>',
			esc_url( 'mailto:' . $email ),
			esc_html( $email )
		);
	}

	if ( '' !== $phone ) {
		$links .= sprintf(
			'<a href="%1$s"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92z"/></svg>%2$s</a>',
			esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ),
			esc_html( $phone )
		);
	}

	return sprintf(
		'<div class="iflynepal-sustain-coordinator">
			<small class="iflynepal-sustain-coordinator__role">%1$s</small>
			<h4 class="wp-block-heading iflynepal-sustain-coordinator__name">%2$s</h4>
			%3$s
		</div>',
		esc_html__( 'Sustainability Coordinator', 'iflynepal' ),
		esc_html( $name ),
		'' === $links ? '' : '<div class="iflynepal-sustain-coordinator__links">' . $links . '</div>'
	);
}
