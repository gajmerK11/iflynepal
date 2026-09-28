<?php
/**
 * Forces the French site on a visitor arriving from France.
 *
 * The client's own requirement: a visitor from France must land on the
 * French version of the site, automatically, with no banner or prompt.
 * Polylang has no geolocation of its own — it only ever detects a language
 * from the browser's Accept-Language header, a cookie from a prior visit, or
 * the URL prefix — so this reads the country Cloudflare has already resolved
 * for the request (the CF-IPCountry header, present on every request once a
 * domain is proxied through it) and, the first time it sees a French
 * visitor on a non-French page, redirects them there outright.
 *
 * The one way out is the site's own language switcher: the moment that
 * visitor picks a different language from it, a cookie remembers the choice
 * and this stops forcing them back to French, on this browser, from then on.
 * Landing on an English link some other way (a shared URL, a bookmark) does
 * not set that cookie — only the switcher does — so it stays true to "shown
 * forcefully until they explicitly opt out via the switcher."
 *
 * This runs on template_redirect, ahead of any output, rather than in the
 * page itself: production runs a full-page cache (LiteSpeed) that would
 * otherwise bake one visitor's redirect into the cached response for every
 * later visitor of that URL. A redirect response is not something page
 * caches normally store, but iflynepal_geo_force_redirect() tells LiteSpeed
 * not to cache this particular response regardless, as insurance.
 *
 * Nothing here runs at all when Polylang is inactive, when the site has only
 * one language, or off a request Cloudflare never touched (local development,
 * for one) — see iflynepal_geo_detected_country() for the one deliberate
 * escape hatch around that last case.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The cookie that remembers a visitor chose a language via the switcher.
 *
 * Set from the browser, the moment the switcher itself is clicked to a
 * non-French language (see assets/js/global/geo-lang-optout.js) — never set
 * just because a request happened to land on a non-French URL some other
 * way, which would defeat the "forceful by default" requirement on the very
 * first visit.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_GEO_OPT_OUT_COOKIE = 'iflynepal_geo_opt_out';

/**
 * Country codes mapped to the Polylang language they should be forced to.
 *
 * France only, per the client's one concrete requirement so far. Filtered so
 * a later "and similar for other countries" is a line added to this array —
 * Belgium and Switzerland's French-speaking regions, say — rather than a
 * second copy of the logic below it.
 *
 * @since 1.0.0
 *
 * @return array<string,string> Two-letter country code => Polylang language slug.
 */
function iflynepal_geo_language_map() {
	return (array) apply_filters(
		'iflynepal_geo_language_map',
		array(
			'FR' => 'fr',
		)
	);
}

/**
 * The country Cloudflare resolved for this request.
 *
 * Cloudflare adds this header at the edge, on every request, the moment a
 * domain is proxied through it (confirmed on both this project's live and
 * staging hosts) — free, no API call, no added latency. 'XX' is Cloudflare's
 * own placeholder for a request it could not place (a Tor exit node, mostly)
 * and is treated the same as no header at all.
 *
 * A logged-in administrator can override it with ?iflynepal_geo_debug=FR to
 * preview the redirect without a VPN — on local development, which sits
 * behind no Cloudflare at all, this is the only way to see it short of
 * faking the header at the web server. Never trusted for anyone else: the
 * real header always wins for a visitor who cannot manage the site.
 *
 * @since 1.0.0
 *
 * @return string Two-letter country code, or an empty string when unresolved.
 */
function iflynepal_geo_detected_country() {
	if ( isset( $_GET['iflynepal_geo_debug'] ) && current_user_can( 'manage_options' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- A debug preview, gated on capability; nothing is written from it.
		return strtoupper( sanitize_key( wp_unslash( $_GET['iflynepal_geo_debug'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Same as above.
	}

	$country = isset( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) ) : '';

	return 'XX' === $country ? '' : $country;
}

/**
 * Well-known crawler and preview-bot user agents.
 *
 * A crawler is left on whatever language it actually asked for rather than
 * forced elsewhere — geotargeting a human visitor is legitimate, but a bot
 * being bounced around by IP is the kind of divergent-response pattern
 * that reads as cloaking to a search engine. Filtered in case another
 * crawler needs excluding later.
 *
 * @since 1.0.0
 *
 * @return string[] Case-insensitive substrings matched against the user agent.
 */
function iflynepal_geo_bot_user_agents() {
	return (array) apply_filters(
		'iflynepal_geo_bot_user_agents',
		array(
			'bot',
			'spider',
			'crawl',
			'slurp',
			'facebookexternalhit',
			'whatsapp',
			'telegrambot',
			'preview',
		)
	);
}

/**
 * Whether the current request is a crawler or preview fetcher.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_geo_is_bot() {
	$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) ) : '';

	if ( '' === $user_agent ) {
		// No user agent at all is not how a browser behaves.
		return true;
	}

	foreach ( iflynepal_geo_bot_user_agents() as $needle ) {
		if ( false !== strpos( $user_agent, $needle ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Works out whether to force a redirect, and to what URL.
 *
 * Pure with respect to its $post_id argument — everything else it reads
 * ($_SERVER, $_COOKIE) is the live request, which is exactly what makes this
 * safe to call from template_redirect and unsafe to have cached (see the
 * file docblock).
 *
 * @since 1.0.0
 *
 * @param int $post_id The post the visitor is actually reading, 0 when the
 *                      request is not for a singular page (an archive, the
 *                      blog index, and so on).
 * @return array{show: bool, lang: string, url: string}
 */
function iflynepal_geo_resolve_target( $post_id ) {
	$result = array(
		'show' => false,
		'lang' => '',
		'url'  => '',
	);

	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_current_language' ) ) {
		return $result;
	}

	if ( count( pll_languages_list() ) < 2 ) {
		return $result;
	}

	if ( ! empty( $_COOKIE[ IFLYNEPAL_GEO_OPT_OUT_COOKIE ] ) ) {
		return $result;
	}

	if ( iflynepal_geo_is_bot() ) {
		return $result;
	}

	$country = iflynepal_geo_detected_country();

	if ( '' === $country ) {
		return $result;
	}

	$map  = iflynepal_geo_language_map();
	$lang = isset( $map[ $country ] ) ? $map[ $country ] : '';

	if ( '' === $lang || ! in_array( $lang, pll_languages_list(), true ) ) {
		return $result;
	}

	if ( pll_current_language() === $lang ) {
		return $result;
	}

	/*
	 * The French translation of the exact page being read when there is one,
	 * so a visitor already partway through a package or an article is sent
	 * to that same page in French rather than being funneled back to the
	 * homepage. Falls back to the French homepage everywhere else, including
	 * every archive and any singular page with no translation yet.
	 */
	$url = '';

	if ( $post_id && function_exists( 'pll_get_post' ) ) {
		$translated_id = pll_get_post( $post_id, $lang );

		if ( $translated_id ) {
			$url = (string) get_permalink( $translated_id );
		}
	}

	if ( '' === $url && function_exists( 'pll_home_url' ) ) {
		$url = (string) pll_home_url( $lang );
	}

	if ( '' === $url ) {
		return $result;
	}

	$result['show'] = true;
	$result['lang'] = $lang;
	$result['url']  = $url;

	return $result;
}

/**
 * Forces a French-IP visitor onto the French site.
 *
 * Skips anything that isn't a plain front-end page view — admin, AJAX, cron,
 * REST, feeds, and non-GET requests (a POST mid-submission must never be
 * redirected away from its own handler).
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_geo_force_redirect() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || is_feed() ) {
		return;
	}

	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}

	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'GET' !== $_SERVER['REQUEST_METHOD'] ) {
		return;
	}

	$post_id = is_singular() ? get_queried_object_id() : 0;
	$result  = iflynepal_geo_resolve_target( $post_id );

	if ( ! $result['show'] ) {
		return;
	}

	// Insurance: a full-page cache must never store this visitor's redirect.
	if ( has_action( 'litespeed_control_set_nocache' ) ) {
		do_action( 'litespeed_control_set_nocache', 'iflynepal geo force redirect' );
	}

	wp_safe_redirect( $result['url'], 302 );
	exit;
}
add_action( 'template_redirect', 'iflynepal_geo_force_redirect' );

/**
 * Whether the current request could possibly want the opt-out script at all.
 *
 * A single-language install, or one with Polylang off, has no forced
 * redirect for the switcher to ever need opting out of.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_geo_banner_active() {
	return function_exists( 'pll_languages_list' ) && count( pll_languages_list() ) > 1;
}

/**
 * Enqueues the script that remembers a switcher-driven language choice.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_enqueue_geo_banner() {
	if ( ! iflynepal_geo_banner_active() ) {
		return;
	}

	wp_enqueue_script(
		'iflynepal-geo-lang-optout',
		IFLYNEPAL_URI . '/assets/js/global/geo-lang-optout.js',
		array(),
		iflynepal_asset_version( 'assets/js/global/geo-lang-optout.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-geo-lang-optout',
		'iflynepalGeoBanner',
		array(
			'cookieName' => IFLYNEPAL_GEO_OPT_OUT_COOKIE,
			'forcedLang' => 'fr',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'iflynepal_enqueue_geo_banner' );
