<?php
/**
 * Cookie Policy page: the clause register and its head renderer.
 *
 * The same arrangement as inc/terms.php, for the same reason. The clauses are
 * not editable in the Customizer — a policy is agreed and republished as a
 * whole, not tuned clause by clause — so the copy lives in the template part
 * beside its markup, and only the *register* lives here.
 *
 * The register exists because two things have to agree: the "On this page"
 * index and the heading of each clause, including its number. Written twice
 * they drift the moment a clause is inserted; written once here, the index is
 * generated and the numbers are positions in this array.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every clause on the page, in the order it is read.
 *
 * The key is the anchor — descriptive rather than `clause-3`, as the design
 * has it, so a link to one from an email or a cookie banner still says what it
 * points at.
 *
 * @since 1.0.0
 *
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_cookie_clauses() {
	return array(
		'what-are-cookies'    => array(
			'title' => __( 'What Are Cookies?', 'iflynepal' ),
			'note'  => __( 'The basics', 'iflynepal' ),
		),
		'cookie-types'        => array(
			'title' => __( 'Types of Cookies We Use', 'iflynepal' ),
			'note'  => __( 'Four categories', 'iflynepal' ),
		),
		'third-party-cookies' => array(
			'title' => __( 'Third-Party Cookies', 'iflynepal' ),
			'note'  => __( 'Embedded content', 'iflynepal' ),
		),
		'cookie-management'   => array(
			'title' => __( 'Cookie Management', 'iflynepal' ),
			'note'  => __( 'Turning cookies off', 'iflynepal' ),
		),
		'policy-updates'      => array(
			'title' => __( 'Updates to this Policy', 'iflynepal' ),
			'note'  => __( 'Law and technology change', 'iflynepal' ),
		),
	);
}

/**
 * One clause's position in the register, counting from one.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return int Its number, or 0 when the anchor is not registered.
 */
function iflynepal_cookie_clause_number( $anchor ) {
	$position = array_search( $anchor, array_keys( iflynepal_cookie_clauses() ), true );

	return false === $position ? 0 : (int) $position + 1;
}

/**
 * Renders the "On this page" index.
 *
 * Ordinary fragment links, so they work with JavaScript off; the active mark
 * is added by assets/js/legal/index.js.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cookie_index() {
	$markup = '';

	foreach ( iflynepal_cookie_clauses() as $anchor => $clause ) {
		$markup .= sprintf(
			'<a class="iflynepal-legal-index__link" href="#%1$s">%2$s</a>',
			esc_attr( $anchor ),
			esc_html( $clause['title'] )
		);
	}

	return $markup;
}

/**
 * Renders one clause's heading: its number, its title and the line under it.
 *
 * The number is drawn zero-padded to two digits, as the design has it, and is
 * hidden from assistive technology — it is a visual index mark, and a screen
 * reader announcing "zero three" before the heading adds nothing.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return string Markup, or an empty string for an unregistered anchor.
 */
function iflynepal_render_cookie_clause_head( $anchor ) {
	$clauses = iflynepal_cookie_clauses();

	if ( ! isset( $clauses[ $anchor ] ) ) {
		return '';
	}

	return sprintf(
		'<div class="iflynepal-legal-clause__head">
			<span class="iflynepal-legal-clause__num" aria-hidden="true">%1$s</span>
			<div>
				<h3 class="wp-block-heading iflynepal-legal-clause__title" id="%2$s-title">%3$s</h3>
				<small class="iflynepal-legal-clause__note">%4$s</small>
			</div>
		</div>',
		esc_html( str_pad( (string) iflynepal_cookie_clause_number( $anchor ), 2, '0', STR_PAD_LEFT ) ),
		esc_attr( $anchor ),
		esc_html( $clauses[ $anchor ]['title'] ),
		esc_html( $clauses[ $anchor ]['note'] )
	);
}

/**
 * The browser links in clause 04, each pointing at that browser's own help.
 *
 * Kept as data rather than four near-identical blocks of markup: they differ
 * only in a name, a URL and a logo file. The logos are local copies of the
 * Simple Icons glyphs the design loaded from a CDN — the same artwork, without
 * a third-party request on a page about third-party requests.
 *
 * ⚠️ They live under assets/images/policy/, not assets/images/cookie/ — see the
 * note above IFLYNEPAL_COOKIE_HERO_IMAGE_DEFAULT. A content blocker matching
 * "cookie" in the request path takes these out along with the hero.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'name', 'url' and 'icon' (a file under assets/images/policy/browsers).
 */
function iflynepal_cookie_browsers() {
	return array(
		array(
			'name' => __( 'Google Chrome', 'iflynepal' ),
			'url'  => 'https://support.google.com/chrome/answer/95647',
			'icon' => 'googlechrome.svg',
		),
		array(
			'name' => __( 'Mozilla Firefox', 'iflynepal' ),
			'url'  => 'https://support.mozilla.org/en-US/kb/enhanced-tracking-protection-firefox-desktop',
			'icon' => 'firefoxbrowser.svg',
		),
		array(
			'name' => __( 'Safari', 'iflynepal' ),
			'url'  => 'https://support.apple.com/en-us/105082',
			'icon' => 'safari.svg',
		),
		array(
			'name' => __( 'Microsoft Edge', 'iflynepal' ),
			'url'  => 'https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09',
			'icon' => 'microsoftedge.svg',
		),
	);
}

/**
 * Renders the browser settings links.
 *
 * Each opens in a new tab: the reader is being sent to a help page to change a
 * setting, and losing this page while they do it is the wrong outcome.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cookie_browsers() {
	$markup = '';

	foreach ( iflynepal_cookie_browsers() as $browser ) {
		$markup .= sprintf(
			'<a class="iflynepal-cookie-browser" href="%1$s" target="_blank" rel="noopener">
				<img src="%2$s" alt="" width="22" height="22" loading="lazy" decoding="async">
				<span>%3$s</span>
				<svg class="iflynepal-ico iflynepal-cookie-browser__arrow" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M8 7h9v9"/></svg>
			</a>',
			esc_url( $browser['url'] ),
			esc_url( IFLYNEPAL_URI . '/assets/images/policy/browsers/' . $browser['icon'] ),
			esc_html( $browser['name'] )
		);
	}

	return $markup;
}
