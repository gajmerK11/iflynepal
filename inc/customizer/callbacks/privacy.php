<?php
/**
 * Privacy Policy page: the one editable part and its default.
 *
 * Only the hero photograph. The policy itself is not editable — see
 * inc/privacy.php — and this page has no closing card, so there is nothing else
 * on it that is marketing rather than legal.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * Under assets/images/policy/ beside the Cookie Policy's, and named for what it
 * shows rather than for the page — see the note above
 * IFLYNEPAL_COOKIE_HERO_IMAGE_DEFAULT on content blockers matching words in a
 * request path.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_PRIVACY_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/policy/hero-policy-everest.jpg' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_privacy_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_privacy_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_PRIVACY_HERO_IMAGE_DEFAULT;
}
