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
 * Set the moment the banner is decided on, not on a dismiss click — so it
 * shows exactly once ever for a given browser, whether that visit ends in a
 * dismiss, a click through to French, or the tab simply being closed. This is
 * also what "first visit only" means in practice: nothing here tracks visits,
 * only whether this one browser has been offered the choice before.
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
 * Decides whether to show the banner on this request, once, and remembers it.
 *
 * Cached in a static so the decision is made exactly once per request and the
 * two hooks below — one early enough to still set a cookie, one late enough
 * to have something to print — always agree with each other. The cookie is
 * written here, on 'template_redirect', which runs well before any output;
 * writing it from 'wp_footer' instead would be past the point headers can
 * still be sent and would silently fail.
 *
 * @since 1.0.0
 *
 * @return array{show: bool, lang: string, url: string} Decision and, when showing, the target language and URL.
 */
function iflynepal_geo_banner_decision() {
	static $decision = null;

	if ( null !== $decision ) {
		return $decision;
	}

	$decision = array(
		'show' => false,
		'lang' => '',
		'url'  => '',
	);

	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_current_language' ) ) {
		return $decision;
	}

	if ( count( pll_languages_list() ) < 2 ) {
		return $decision;
	}

	if ( ! empty( $_COOKIE[ IFLYNEPAL_GEO_BANNER_COOKIE ] ) ) {
		return $decision;
	}

	if ( iflynepal_geo_is_bot() ) {
		return $decision;
	}

	$country = iflynepal_geo_detected_country();

	if ( '' === $country ) {
		return $decision;
	}

	$map  = iflynepal_geo_language_map();
	$lang = isset( $map[ $country ] ) ? $map[ $country ] : '';

	if ( '' === $lang || ! in_array( $lang, pll_languages_list(), true ) ) {
		return $decision;
	}

	if ( pll_current_language() === $lang ) {
		return $decision;
	}

	/*
	 * The French translation of the exact page being read when there is one,
	 * so a visitor already partway through a package or an article is offered
	 * that same page in French rather than being funneled back to the
	 * homepage. Falls back to the French homepage everywhere else, including
	 * every archive and any singular page with no translation yet.
	 */
	$url = '';

	if ( is_singular() && function_exists( 'pll_get_post' ) ) {
		$translated_id = pll_get_post( get_queried_object_id(), $lang );

		if ( $translated_id ) {
			$url = (string) get_permalink( $translated_id );
		}
	}

	if ( '' === $url && function_exists( 'pll_home_url' ) ) {
		$url = (string) pll_home_url( $lang );
	}

	if ( '' === $url ) {
		return $decision;
	}

	$decision['show'] = true;
	$decision['lang'] = $lang;
	$decision['url']  = $url;

	if ( ! headers_sent() ) {
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

	return $decision;
}
add_action( 'template_redirect', 'iflynepal_geo_banner_decision' );

/**
 * Prints the banner, if the decision above called for one.
 *
 * Printed in the footer rather than gated behind any script: the decision is
 * already made server-side, so there is nothing for JavaScript to decide —
 * only the dismiss button's own hide behaviour needs it, and that degrades to
 * "the banner stays up until the next page load" with JavaScript off, not to
 * "the banner never goes away".
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_render_geo_language_banner() {
	$decision = iflynepal_geo_banner_decision();

	if ( ! $decision['show'] ) {
		return;
	}

	$language = function_exists( 'PLL' ) && PLL() ? PLL()->model->get_language( $decision['lang'] ) : null;
	$language_name = $language ? $language->name : __( 'French', 'iflynepal' );
	?>
	<div class="iflynepal-geo-banner" id="iflynepal-geo-banner" role="region" aria-label="<?php esc_attr_e( 'Language suggestion', 'iflynepal' ); ?>">
		<p class="iflynepal-geo-banner__text">
			<?php
			printf(
				/* translators: %s: the suggested language's own name, e.g. "Français". */
				esc_html__( 'Vous semblez naviguer depuis la France. Voir le site en %s ?', 'iflynepal' ),
				esc_html( $language_name )
			);
			?>
		</p>
		<div class="iflynepal-geo-banner__actions">
			<a class="iflynepal-geo-banner__switch" href="<?php echo esc_url( $decision['url'] ); ?>">
				<?php esc_html_e( 'Voir en français', 'iflynepal' ); ?>
			</a>
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
	<script>
		( function () {
			var banner = document.getElementById( 'iflynepal-geo-banner' );

			if ( ! banner ) {
				return;
			}

			var dismiss = banner.querySelector( '[data-iflynepal-geo-dismiss]' );

			if ( dismiss ) {
				dismiss.addEventListener( 'click', function () {
					banner.remove();
				} );
			}
		} )();
	</script>
	<?php
}
add_action( 'wp_footer', 'iflynepal_render_geo_language_banner' );
