<?php
/**
 * Packages archive getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * This is the hero on /packages/ — the whole-catalogue archive the booking
 * plugin renders. Only the hero lives here: the bands under it are drawn per
 * package type from the plugin's own content model, and copying that into the
 * Customizer would be two places to edit one thing.
 *
 * The archive has no term behind it and is not a Page, so it has nowhere of its
 * own to keep copy — which is exactly why the settings are theme mods. A type
 * archive keeps its hero on the term; this one has no term to keep it on.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero kicker.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PACKAGES_HERO_KICKER_DEFAULT = 'Everything we run';

/**
 * Default hero headline.
 *
 * `em` marks the word that takes the gold accent, the same as every other hero
 * on the site.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PACKAGES_HERO_TITLE_DEFAULT = 'Find the trip that is <em>yours</em>.';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PACKAGES_HERO_LEAD_DEFAULT = 'Every kind of trip we run, a few from each. Open any one to see the whole list.';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_PACKAGES_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/homepage/explore-card-explore-nepal.jpg' );

/**
 * Hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_packages_hero_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_packages_hero_kicker', IFLYNEPAL_PACKAGES_HERO_KICKER_DEFAULT ) );
}

/**
 * Hero headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_packages_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_packages_hero_title', IFLYNEPAL_PACKAGES_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_packages_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_packages_hero_lead', IFLYNEPAL_PACKAGES_HERO_LEAD_DEFAULT ) );
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, never empty.
 */
function iflynepal_packages_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_packages_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_PACKAGES_HERO_IMAGE_DEFAULT;
}

/* --------------------------------------------------------------- partials */

/**
 * Renders the hero kicker for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_render_packages_hero_kicker() {
	return iflynepal_packages_hero_kicker();
}

/**
 * Renders the hero headline for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_render_packages_hero_title() {
	return iflynepal_packages_hero_title();
}

/**
 * Renders the hero sub-title for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_render_packages_hero_lead() {
	return iflynepal_packages_hero_lead();
}
