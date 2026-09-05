<?php
/**
 * External review platforms shown under the testimonial carousel.
 *
 * The registry of platforms lives here rather than in the template, because
 * three things need it: the settings screen that collects the links, the
 * template that draws the buttons, and the icon markup itself.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option holding the saved links, keyed by platform slug.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TESTIMONIAL_LINKS_OPTION = 'iflynepal_testimonial_links';

/**
 * The platforms a link can be given for.
 *
 * Adding one is a single entry here: the settings screen grows a field and the
 * section grows a button, with nothing else to change. Slugs are stored, so
 * reordering this list is safe and renaming a slug is not.
 *
 * The marks for Google and Tripadvisor are the platforms' own. The rest are
 * deliberately simplified single-colour glyphs — close enough to be recognised
 * beside a label, without shipping a half-remembered trademark.
 *
 * @since 1.0.0
 *
 * @return array[] Platforms keyed by slug, each with 'label' and 'placeholder'.
 */
function iflynepal_testimonial_platforms() {
	return array(
		'google'      => array(
			'label'       => __( 'Google Reviews', 'iflynepal' ),
			'placeholder' => 'https://www.google.com/search?q=iFly+Nepal+reviews',
		),
		'tripadvisor' => array(
			'label'       => __( 'Tripadvisor', 'iflynepal' ),
			'placeholder' => 'https://www.tripadvisor.com/Search?q=iFly%20Nepal',
		),
		'trustpilot'  => array(
			'label'       => __( 'Trustpilot', 'iflynepal' ),
			'placeholder' => 'https://www.trustpilot.com/review/iflynepal.com',
		),
		'facebook'    => array(
			'label'       => __( 'Facebook', 'iflynepal' ),
			'placeholder' => 'https://www.facebook.com/iflynepal/reviews',
		),
		'booking'     => array(
			'label'       => __( 'Booking.com', 'iflynepal' ),
			'placeholder' => 'https://www.booking.com/',
		),
		'yelp'        => array(
			'label'       => __( 'Yelp', 'iflynepal' ),
			'placeholder' => 'https://www.yelp.com/biz/ifly-nepal',
		),
	);
}

/**
 * The links that stand in before the screen has ever been saved.
 *
 * The two platforms the approved design shipped with, so the strip does not
 * vanish from a page that was already showing it. Saving with every field
 * empty is how it is deliberately turned off.
 *
 * Its own function because the Customizer's Footer panel edits the same
 * option and has to offer these as its control defaults, or a link the front
 * end is rendering would show as an empty box.
 *
 * @since 1.0.0
 *
 * @return string[] URLs keyed by platform slug.
 */
function iflynepal_testimonial_link_defaults() {
	$platforms = iflynepal_testimonial_platforms();

	return array(
		'google'      => $platforms['google']['placeholder'],
		'tripadvisor' => $platforms['tripadvisor']['placeholder'],
	);
}

/**
 * Every saved link, with the empty ones dropped.
 *
 * Order follows the registry, not the order they were filled in, so the row
 * does not rearrange itself when an editor adds a platform.
 *
 * @since 1.0.0
 *
 * @return array[] Links, each with 'slug', 'label' and 'url'.
 */
function iflynepal_testimonial_links() {
	/*
	 * Until the screen has been saved once, the two platforms the approved
	 * design shipped with stand in, so the strip does not vanish from a page
	 * that was already showing it. Saving the form with every field empty is
	 * how the strip is deliberately turned off.
	 */
	$saved = get_option( IFLYNEPAL_TESTIMONIAL_LINKS_OPTION, null );

	if ( null === $saved ) {
		$saved = iflynepal_testimonial_link_defaults();
	}

	if ( ! is_array( $saved ) ) {
		return array();
	}

	$links = array();

	foreach ( iflynepal_testimonial_platforms() as $slug => $platform ) {
		$url = isset( $saved[ $slug ] ) ? trim( (string) $saved[ $slug ] ) : '';

		if ( '' === $url ) {
			continue;
		}

		$links[] = array(
			'slug'  => $slug,
			'label' => $platform['label'],
			'url'   => $url,
		);
	}

	return $links;
}

/**
 * The handwritten note beside the buttons.
 *
 * @since 1.0.0
 *
 * @return string Note text.
 */
function iflynepal_testimonial_links_note() {
	$saved = get_option( IFLYNEPAL_TESTIMONIAL_LINKS_OPTION, array() );
	$note  = isset( $saved['note'] ) ? (string) $saved['note'] : '';

	return '' !== trim( $note ) ? $note : __( 'Others have shared theirs too, right here', 'iflynepal' );
}

/**
 * One platform's brand mark.
 *
 * Printed literally rather than built from data: these are multi-coloured
 * logos, so they cannot take their colour from the button around them, and a
 * trademark is not something an editor should be able to edit.
 *
 * @since 1.0.0
 *
 * @param string $slug      Platform slug.
 * @param string $css_class Optional. Class for the SVG, so the same mark can be
 *                          sized by the testimonial strip and by the footer chips.
 *                          Default 'iflynepal-testimonials__brand'.
 * @return string SVG markup, or an empty string for an unknown slug.
 */
function iflynepal_render_testimonial_platform_icon( $slug, $css_class = 'iflynepal-testimonials__brand' ) {
	$open  = '<svg class="' . esc_attr( $css_class ) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false">';
	$close = '</svg>';

	switch ( $slug ) {
		case 'google':
			return $open .
				'<path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.46a5.52 5.52 0 0 1-2.4 3.62v3h3.88c2.27-2.09 3.58-5.17 3.58-8.81z"/>' .
				'<path fill="#34A853" d="M12 24c3.24 0 5.96-1.08 7.94-2.92l-3.88-3c-1.08.72-2.45 1.15-4.06 1.15-3.13 0-5.78-2.11-6.73-4.96H1.26v3.09A11.99 11.99 0 0 0 12 24z"/>' .
				'<path fill="#FBBC05" d="M5.27 14.27a7.2 7.2 0 0 1 0-4.54V6.64H1.26a12 12 0 0 0 0 10.72l4.01-3.09z"/>' .
				'<path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.44-3.44C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.69 1.26 6.64l4.01 3.09C6.22 6.86 8.87 4.75 12 4.75z"/>' .
				$close;

		case 'tripadvisor':
			return $open .
				'<circle cx="12" cy="12" r="11.5" fill="#34E0A1"/>' .
				'<path fill="#000" d="M12 5.6c2.6 0 5 .63 7 1.72h3.4l-1.9 2.07c.5.83.79 1.8.79 2.85a5.5 5.5 0 0 1-9.29 3.99A5.5 5.5 0 0 1 2.71 12.24c0-1.04.29-2.02.79-2.85L1.6 7.32H5c2-1.09 4.4-1.72 7-1.72z"/>' .
				'<circle cx="7.5" cy="12.3" r="3.1" fill="#fff"/><circle cx="7.5" cy="12.3" r="1.4" fill="#000"/>' .
				'<circle cx="16.5" cy="12.3" r="3.1" fill="#fff"/><circle cx="16.5" cy="12.3" r="1.4" fill="#000"/>' .
				$close;

		case 'trustpilot':
			return $open .
				'<path fill="#00B67A" d="M12 1.5l3.09 6.9 7.41.72-5.58 5.02 1.6 7.36L12 17.7l-6.52 3.8 1.6-7.36L1.5 9.12l7.41-.72z"/>' .
				$close;

		case 'facebook':
			return $open .
				'<circle cx="12" cy="12" r="11.5" fill="#1877F2"/>' .
				'<path fill="#fff" d="M15.1 12.6h-2v6.9h-2.9v-6.9H8.7v-2.5h1.5V8.6c0-2 1.2-3.1 3-3.1.9 0 1.8.07 2 .1v2.4h-1.4c-1 0-1.2.47-1.2 1.16v1h2.4z"/>' .
				$close;

		case 'booking':
			return $open .
				'<rect x="1" y="1" width="22" height="22" rx="4" fill="#003580"/>' .
				'<path fill="#fff" d="M8.4 6.4h4c2.1 0 3.4 1.1 3.4 2.9 0 1.2-.6 2-1.5 2.4 1.2.35 2 1.3 2 2.7 0 2-1.5 3.2-3.8 3.2H8.4zm2.5 4.3h1.3c.9 0 1.4-.4 1.4-1.1s-.5-1.1-1.4-1.1h-1.3zm0 4.8h1.6c1 0 1.6-.45 1.6-1.25 0-.8-.6-1.25-1.6-1.25h-1.6z"/>' .
				$close;

		case 'yelp':
			return $open .
				'<path fill="#D32323" d="M10.6 2.6l.5 8.3c.03.6-.7.9-1.1.44L5.6 6.9a1 1 0 0 1 .2-1.55 12 12 0 0 1 3.5-1.5 1 1 0 0 1 1.3.75zM10.1 13.4c.42.2.46.8.07 1.06l-3.3 2.2a1 1 0 0 1-1.5-.5 11.9 11.9 0 0 1-.6-3 1 1 0 0 1 1.2-1zM13.4 13.9c-.3-.35-.05-.9.4-.93l3.95-.25a1 1 0 0 1 1 1.25 11.9 11.9 0 0 1-1.4 3 1 1 0 0 1-1.6.1zM13.3 11c-.45-.1-.6-.66-.26-.97l2.9-2.7a1 1 0 0 1 1.6.25c.5.9.85 1.9 1 2.9a1 1 0 0 1-1 1.15zM11.9 15.5c.45-.1.85.3.75.75l-.85 3.85a1 1 0 0 1-1.4.7 12 12 0 0 1-2.5-1.7 1 1 0 0 1 .15-1.6z"/>' .
				$close;
	}

	return '';
}
