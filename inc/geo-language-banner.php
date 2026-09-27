<?php
/**
 * Suggests the French site to a visitor arriving from France.
 *
 * The client's own requirement: a visitor from France should land on the
 * French version of the site. Polylang has no geolocation of its own — it
 * only ever detects a language from the browser's Accept-Language header, a
 * cookie from a prior visit, or the URL prefix — so this reads the country
 * Cloudflare has already resolved for the request (the CF-IPCountry header,
 * present on every request once a domain is proxied through it) and offers a
 * dismissible banner rather than a silent redirect: a hard redirect would
 * trap a France-based visitor who genuinely wants the English site, and risks
 * a crawler being redirected off the URL it asked for, which reads as
 * cloaking to a search engine.
 *
 * The decision is made over AJAX, not while the page itself renders.
 * Production runs a full-page cache (LiteSpeed) that serves the same cached
 * HTML to every guest visitor for up to a week — a server-rendered decision
 * based on one visitor's request headers would be computed once, cached, and
 * then served to every visitor afterwards regardless of where they are
 * actually browsing from. admin-ajax.php is excluded from every caching
 * plugin's page cache by design (it has to be, or logged-in state, carts and
 * the like would break the same way), so the country lookup and the
 * "shown once" cookie both have to happen there instead. The page itself
 * only ever ships a static, identical-for-everyone, hidden container — safe
 * to cache — that this request fills in.
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
 * The cookie that remembers the banner has already been shown once.
 *
 * Set from the AJAX handler, the moment a "yes, show it" decision is made —
 * not on a dismiss click — so it shows exactly once ever for a given browser,
 * whether that visit ends in a dismiss, a click through to French, or the tab
 * simply being closed.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_GEO_BANNER_COOKIE = 'iflynepal_geo_banner_seen';

/**
 * Country codes mapped to the Polylang language they should be offered.
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
 * preview the banner without a VPN — on local development, which sits behind
 * no Cloudflare at all, this is the only way to see it short of faking the
 * header at the web server. Never trusted for anyone else: the real header
 * always wins for a visitor who cannot manage the site.
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
 * The banner must never be the thing a search engine or a link-preview
 * fetcher sees in place of the page it asked for — offering a language
 * switch is harmless to a person, but a bot acting on it (or simply being
 * counted as having "seen" it) is not something to risk for a feature this
 * small. Filtered in case another crawler needs excluding later.
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
 * Works out whether to offer the banner, and for which language and URL.
 *
 * Pure with respect to its $post_id argument — everything else it reads
 * ($_SERVER, $_COOKIE) is the live request, which is exactly what makes this
 * safe to call from the AJAX handler and unsafe to have called while the page
 * itself renders (see the file docblock).
 *
 * @since 1.0.0
 *
 * @param int $post_id The post the visitor is actually reading, 0 when the
 *                      request is not for a singular page (an archive, the
 *                      blog index, and so on).
 * @return array{show: bool, lang: string, url: string, language_name: string}
 */
function iflynepal_geo_resolve_target( $post_id ) {
	$result = array(
		'show'          => false,
		'lang'          => '',
		'url'           => '',
		'language_name' => '',
	);

	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_current_language' ) ) {
		return $result;
	}

	if ( count( pll_languages_list() ) < 2 ) {
		return $result;
	}

	if ( ! empty( $_COOKIE[ IFLYNEPAL_GEO_BANNER_COOKIE ] ) ) {
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
	 * so a visitor already partway through a package or an article is offered
	 * that same page in French rather than being funneled back to the
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

	$language = function_exists( 'PLL' ) && PLL() ? PLL()->model->get_language( $lang ) : null;

	$result['show']          = true;
	$result['lang']          = $lang;
	$result['url']           = $url;
	$result['language_name'] = $language ? $language->name : __( 'French', 'iflynepal' );

	return $result;
}

/**
 * The AJAX endpoint the banner script calls once the (cached) page has loaded.
 *
 * Registered for both logged-in and logged-out requests — the banner is a
 * guest-facing feature, and admin-ajax.php answers both the same way here.
 * Sets the "seen" cookie itself, the moment it decides to say yes: this is
 * the one point in the whole flow that is guaranteed never to be served from
 * a cache, which a decision made while the page renders is not (see the file
 * docblock).
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_ajax_geo_banner_check() {
	check_ajax_referer( 'iflynepal_geo_banner', 'nonce' );

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	$result  = iflynepal_geo_resolve_target( $post_id );

	if ( $result['show'] && ! headers_sent() ) {
		setcookie(
			IFLYNEPAL_GEO_BANNER_COOKIE,
			'1',
			array(
				'expires'  => time() + YEAR_IN_SECONDS,
				'path'     => COOKIEPATH,
				'domain'   => COOKIE_DOMAIN,
				'secure'   => is_ssl(),
				'httponly' => false,
				'samesite' => 'Lax',
			)
		);
	}

	wp_send_json_success( $result );
}
add_action( 'wp_ajax_iflynepal_geo_banner', 'iflynepal_ajax_geo_banner_check' );
add_action( 'wp_ajax_nopriv_iflynepal_geo_banner', 'iflynepal_ajax_geo_banner_check' );

/**
 * Whether the current request could possibly want the banner script at all.
 *
 * Gates both the enqueue below and the static container: a single-language
 * install, or one with Polylang off, has nothing for the AJAX call to ever
 * say yes to, so neither is worth shipping.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_geo_banner_active() {
	return function_exists( 'pll_languages_list' ) && count( pll_languages_list() ) > 1;
}

/**
 * Enqueues the banner script.
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
		'iflynepal-geo-banner',
		IFLYNEPAL_URI . '/assets/js/global/geo-banner.js',
		array(),
		iflynepal_asset_version( 'assets/js/global/geo-banner.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-geo-banner',
		'iflynepalGeoBanner',
		array(
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( 'iflynepal_geo_banner' ),
			'postId'     => is_singular() ? get_queried_object_id() : 0,
			'cookieName' => IFLYNEPAL_GEO_BANNER_COOKIE,
			'switchLabel' => __( 'Voir en français', 'iflynepal' ),
			/* translators: %s: the suggested language's own name, e.g. "Français". */
			'textTemplate' => __( 'Vous semblez naviguer depuis la France. Voir le site en %s ?', 'iflynepal' ),
			'dismissLabel' => __( 'Dismiss', 'iflynepal' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'iflynepal_enqueue_geo_banner' );

/**
 * Prints the banner's static, hidden container.
 *
 * Identical for every visitor of a given URL — nothing in it depends on who
 * is asking — which is exactly what makes it safe to sit inside a fully
 * cached page. assets/js/global/geo-banner.js is what fills it in and reveals
 * it, only for the one visitor the AJAX call actually says yes to.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_render_geo_banner_container() {
	if ( ! iflynepal_geo_banner_active() ) {
		return;
	}
	?>
	<div class="iflynepal-geo-banner" id="iflynepal-geo-banner" role="region" aria-label="<?php esc_attr_e( 'Language suggestion', 'iflynepal' ); ?>" hidden>
		<p class="iflynepal-geo-banner__text" id="iflynepal-geo-banner-text"></p>
		<div class="iflynepal-geo-banner__actions">
			<a class="iflynepal-geo-banner__switch" id="iflynepal-geo-banner-switch" href="#"></a>
			<button type="button" class="iflynepal-geo-banner__dismiss" data-iflynepal-geo-dismiss aria-label="<?php esc_attr_e( 'Dismiss', 'iflynepal' ); ?>">
				&times;
			</button>
		</div>
	</div>
	<style>
		.iflynepal-geo-banner {
			position: fixed;
			left: 16px;
			right: 16px;
			bottom: 16px;
			z-index: 9999;
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 12px 20px;
			max-width: 640px;
			margin: 0 auto;
			padding: 16px 18px;
			border-radius: 10px;
			background: #0545a7;
			background: var(--iflynepal-navy, #0545a7);
			color: #fff;
			font-family: var(--iflynepal-ui-font, system-ui, sans-serif);
			box-shadow: 0 18px 50px rgba(4, 26, 64, 0.28);
		}

		.iflynepal-geo-banner[hidden] {
			display: none;
		}

		.iflynepal-geo-banner__text {
			flex: 1 1 240px;
			margin: 0;
			font-size: 14px;
			line-height: 1.5;
		}

		.iflynepal-geo-banner__actions {
			display: flex;
			align-items: center;
			gap: 10px;
			flex: 0 0 auto;
		}

		.iflynepal-geo-banner__switch {
			display: inline-block;
			padding: 8px 16px;
			border-radius: 999px;
			background: #e3b463;
			background: var(--iflynepal-gold, #e3b463);
			color: #04347d;
			font-size: 14px;
			font-weight: 600;
			text-decoration: none;
			white-space: nowrap;
		}

		.iflynepal-geo-banner__switch:hover,
		.iflynepal-geo-banner__switch:focus {
			opacity: 0.9;
		}

		.iflynepal-geo-banner__dismiss {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 30px;
			height: 30px;
			border: 0;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.14);
			color: #fff;
			font-size: 18px;
			line-height: 1;
			cursor: pointer;
		}

		.iflynepal-geo-banner__dismiss:hover,
		.iflynepal-geo-banner__dismiss:focus {
			background: rgba(255, 255, 255, 0.24);
		}

		@media (max-width: 480px) {
			.iflynepal-geo-banner {
				flex-direction: column;
				align-items: stretch;
				text-align: center;
			}

			.iflynepal-geo-banner__actions {
				justify-content: center;
			}
		}
	</style>
	<?php
}
add_action( 'wp_footer', 'iflynepal_render_geo_banner_container' );
