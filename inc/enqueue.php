<?php
/**
 * Front-end and editor asset registration.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version for a theme-owned asset: its file modification time.
 *
 * A hand-written version string can go stale while the file it labels changes,
 * which leaves browsers running a cached copy after a deploy. filemtime cannot
 * drift from the file.
 *
 * @since 1.0.0
 *
 * @param string $relative_path Path under the theme root, e.g. 'assets/js/hero.js'.
 * @return string File mtime, or the theme version when the file is missing.
 */
function iflynepal_asset_version( $relative_path ) {
	$path = IFLYNEPAL_DIR . '/' . ltrim( $relative_path, '/' );

	if ( file_exists( $path ) ) {
		return (string) filemtime( $path );
	}

	return IFLYNEPAL_VERSION;
}

/**
 * Enqueues front-end styles and scripts.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_enqueue_assets() {
	wp_enqueue_style(
		'iflynepal-main',
		IFLYNEPAL_URI . '/assets/css/main.css',
		array(),
		iflynepal_asset_version( 'assets/css/main.css' )
	);

	/*
	 * GSAP is the theme's one heavy dependency, so it is loaded only on pages
	 * that actually animate — currently the hero and the Explore Cards section.
	 * A template with neither pays nothing.
	 */
	$has_hero    = iflynepal_has_hero();
	$has_explore = iflynepal_has_explore();

	if ( ! $has_hero && ! $has_explore ) {
		return;
	}

	if ( $has_hero ) {
		/*
		 * Reveal gate, printed in the head so the class lands before the hero
		 * paints. Every hiding rule in the stylesheet is scoped under it, so a
		 * visitor without JavaScript never gets hidden copy — the class is
		 * simply never added. hero.js removes it once GSAP owns those elements.
		 *
		 * Only the hero needs this. It is above the fold, so it cannot afford
		 * to paint once and then be wound back; the sections further down are
		 * hidden by their own script well before they are scrolled to.
		 */
		wp_register_script( 'iflynepal-anim-gate', '', array(), IFLYNEPAL_VERSION, false );
		wp_enqueue_script( 'iflynepal-anim-gate' );
		wp_add_inline_script(
			'iflynepal-anim-gate',
			'document.documentElement.classList.add("iflynepal-anim");'
		);
	}

	wp_enqueue_script(
		'iflynepal-gsap',
		IFLYNEPAL_URI . '/assets/js/vendor/gsap.min.js',
		array(),
		'3.15.0',
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	wp_enqueue_script(
		'iflynepal-gsap-scrolltrigger',
		IFLYNEPAL_URI . '/assets/js/vendor/ScrollTrigger.min.js',
		array( 'iflynepal-gsap' ),
		'3.15.0',
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	if ( $has_hero ) {
		wp_enqueue_script(
			'iflynepal-hero',
			IFLYNEPAL_URI . '/assets/js/hero.js',
			array( 'iflynepal-gsap', 'iflynepal-gsap-scrolltrigger' ),
			iflynepal_asset_version( 'assets/js/hero.js' ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}

	if ( $has_explore ) {
		wp_enqueue_script(
			'iflynepal-reveal',
			IFLYNEPAL_URI . '/assets/js/reveal.js',
			array( 'iflynepal-gsap', 'iflynepal-gsap-scrolltrigger' ),
			iflynepal_asset_version( 'assets/js/reveal.js' ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'iflynepal_enqueue_assets' );

/**
 * Enqueues the navigation toggle on every template that renders a menu.
 *
 * Kept separate from the hero bundle so pages without a hero still get a
 * working mobile menu, at a cost of well under a kilobyte.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_enqueue_navigation() {
	if ( ! has_nav_menu( 'primary' ) ) {
		return;
	}

	wp_enqueue_script(
		'iflynepal-navigation',
		IFLYNEPAL_URI . '/assets/js/navigation.js',
		array(),
		iflynepal_asset_version( 'assets/js/navigation.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'iflynepal_enqueue_navigation' );

/**
 * Preloads the faces that paint the headline.
 *
 * Poppins 500 sets the headline itself and Cormorant Garamond its accent word;
 * both are inside the largest text block on the page, so discovering them only
 * once the stylesheet has parsed costs a visible reflow. The remaining weights
 * are left to font-display: swap.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_preload_fonts() {
	$fonts = array(
		'assets/fonts/poppins-500.woff2',
		'assets/fonts/cormorant-garamond-italic-600.woff2',
	);

	foreach ( $fonts as $font ) {
		if ( ! file_exists( IFLYNEPAL_DIR . '/' . $font ) ) {
			continue;
		}

		printf(
			'<link rel="preload" as="font" type="font/woff2" href="%s" crossorigin>' . "
",
			esc_url( IFLYNEPAL_URI . '/' . $font )
		);
	}
}
add_action( 'wp_head', 'iflynepal_preload_fonts', 2 );

/**
 * Warms the connection to the image host used by the hero background.
 *
 * The hero still is the LCP element and is the only asset served from that
 * origin, so it otherwise pays a full cold DNS + TLS handshake before the
 * largest paint can happen.
 *
 * @since 1.0.0
 *
 * @param array  $hints         Resource hint URLs.
 * @param string $relation_type Hint relation type.
 * @return array Filtered hints.
 */
function iflynepal_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' !== $relation_type || ! iflynepal_has_hero() ) {
		return $hints;
	}

	$origin = iflynepal_hero_still_origin();

	if ( '' !== $origin ) {
		$hints[] = array(
			'href'        => $origin,
			'crossorigin' => 'anonymous',
		);
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'iflynepal_resource_hints', 10, 2 );

/**
 * Preloads the hero still so the LCP element starts downloading immediately.
 *
 * The still sits well down the document inside the hero template part, which
 * puts it too far down for the preload scanner to find it early on its own.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_preload_hero_still() {
	if ( ! iflynepal_has_hero() ) {
		return;
	}

	$url = iflynepal_hero_still_url();

	if ( '' === $url ) {
		return;
	}

	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'iflynepal_preload_hero_still', 2 );
