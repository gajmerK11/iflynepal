<?php
/**
 * Cookie Policy page: the one editable part and its default.
 *
 * Only the hero photograph. The policy itself is not editable — see
 * inc/cookie.php — and this page has no closing card, so there is nothing else
 * on it that is marketing rather than legal.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * ⚠️ The file lives under assets/images/policy/ and its name says nothing about
 * cookies, deliberately. Content blockers run network rules against the request
 * URL, and the cookie-notice filter lists in uBlock Origin and AdGuard match
 * "cookie" in a path — which silently blocked this page's hero and its browser
 * logos while the files sat under assets/images/cookie/. The page still has to
 * be named cookie-policy; its assets do not.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_COOKIE_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/policy/hero-policy-himalaya.jpg' );

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_cookie_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_cookie_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_COOKIE_HERO_IMAGE_DEFAULT;
}
