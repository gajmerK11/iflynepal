<?php
/**
 * Homepage "Trusted Partner" getters and selective-refresh render callbacks.
 *
 * The card between the hero and Explore Nepal: a photograph or a short video
 * on one side, a portion of the company's own story and a link to the full
 * About page on the other.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default heading, as the client asked for it by name.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PARTNER_TITLE_DEFAULT = 'Your Trusted Partner for<br>Himalayan Trek, Tours &amp; Retreats';

/**
 * Paragraphs the card's copy column can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/homepage/partner/description.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PARTNER_DESCRIPTION_MAX = 4;

/**
 * Default paragraphs: the opening lines of the About page's own story
 * (Appearance &gt; Customize &gt; About &gt; Overview), not the whole thing —
 * this card is an invitation to read the rest there, not a second copy of it.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_partner_description_defaults() {
	return array(
		1 => __( 'Founded in 2021 in the vibrant city of Kathmandu, iFly Nepal is more than just a travel company&mdash;we are a collective of explorers, storytellers, and community advocates dedicated to creating travel experiences that leave lasting impressions.', 'iflynepal' ),
		2 => __( 'Locally owned and deeply rooted in Nepali culture, our team understands the soul of this land&mdash;and we want you to feel it too.', 'iflynepal' ),
		3 => __( 'We serve a wide spectrum of travelers&mdash;adventure seekers, wellness enthusiasts, volunteers, cultural explorers, and first-time visitors&mdash;offering both set itineraries and fully customized journeys across Nepal and beyond.', 'iflynepal' ),
	);
}

/**
 * One paragraph's default, with an empty fallback for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Paragraph number.
 * @return string Default text.
 */
function iflynepal_partner_description_default( $index ) {
	$defaults = iflynepal_partner_description_defaults();

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : '';
}

/**
 * Default button label.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PARTNER_BUTTON_LABEL_DEFAULT = 'Read More About Us';

/**
 * Fallback alt text for an uploaded image that carries none of its own.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_partner_image_default_alt() {
	return __( 'Guides and travellers with iFly Nepal in the Himalaya', 'iflynepal' );
}

/**
 * The About page's ID, whichever page has that template assigned.
 *
 * Cached for the request: called once while the Customizer registers and
 * once while the card itself renders, and it is never going to change
 * between the two.
 *
 * @since 1.0.0
 *
 * @return int Post ID, or 0 if no page carries the About template.
 */
function iflynepal_partner_about_page_id() {
	static $about_id = null;

	if ( null !== $about_id ) {
		return $about_id;
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-about.php',
		)
	);

	$about_id = $pages ? (int) $pages[0] : 0;

	return $about_id;
}

/**
 * The About page's URL in the current language.
 *
 * Falls back to the page's own (default-language) permalink when Polylang
 * has no translation for it yet, and to an empty string when no page carries
 * the About template at all — the button is then simply left off, the same
 * rule every other optional button in the theme follows.
 *
 * @since 1.0.0
 *
 * @return string URL, or an empty string.
 */
function iflynepal_partner_about_page_url() {
	$about_id = iflynepal_partner_about_page_id();

	if ( ! $about_id ) {
		return '';
	}

	if ( function_exists( 'pll_current_language' ) && function_exists( 'pll_get_post' ) ) {
		$lang = pll_current_language();

		if ( $lang ) {
			$translated = pll_get_post( $about_id, $lang );

			if ( $translated ) {
				$about_id = $translated;
			}
		}
	}

	$url = get_permalink( $about_id );

	return $url ? (string) $url : '';
}

/* -------------------------------------------------------------------- copy */

/**
 * Card heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_partner_title() {
	$title = get_theme_mod( 'iflynepal_partner_title', IFLYNEPAL_PARTNER_TITLE_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$title = pll__( $title );
	}

	return iflynepal_kses_text( $title );
}

/**
 * The card's paragraphs that have text, in order.
 *
 * Emptying a paragraph is how the Customizer's Remove button deletes it, so
 * an empty slot is skipped rather than rendered as a blank line.
 *
 * @since 1.0.0
 *
 * @return string[] Paragraph HTML.
 */
function iflynepal_partner_description_paragraphs() {
	$paragraphs = array();

	for ( $i = 1; $i <= IFLYNEPAL_PARTNER_DESCRIPTION_MAX; $i++ ) {
		$value = trim( (string) get_theme_mod( 'iflynepal_partner_description_' . $i, iflynepal_partner_description_default( $i ) ) );

		if ( '' === $value ) {
			continue;
		}

		if ( function_exists( 'pll__' ) ) {
			$value = pll__( $value );
		}

		$paragraphs[] = $value;
	}

	return $paragraphs;
}

/**
 * The button's label and link.
 *
 * @since 1.0.0
 *
 * @return array{label: string, url: string} Label and link. Label is empty when the button is off.
 */
function iflynepal_partner_button() {
	$label = (string) get_theme_mod( 'iflynepal_partner_button_label', IFLYNEPAL_PARTNER_BUTTON_LABEL_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$label = pll__( $label );
	}

	return array(
		'label' => $label,
		'url'   => iflynepal_customizer_get_link( 'iflynepal_partner_button_url', iflynepal_partner_about_page_url() ),
	);
}

/* ------------------------------------------------------------------- media */

/**
 * Photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the stand-in.
 */
function iflynepal_partner_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_partner_image', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $attachment_id, 'large' );

	return $url ? $url : '';
}

/**
 * Photograph alt text.
 *
 * An uploaded image brings its own description from the media library; the
 * stand-in falls back to the one this file ships.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_partner_image_alt() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_partner_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$alt = iflynepal_partner_image_default_alt();

	if ( function_exists( 'pll__' ) ) {
		$alt = pll__( $alt );
	}

	return $alt;
}

/**
 * Video URL.
 *
 * Takes over from the photograph the moment one is uploaded; see the
 * template, which renders the image only when this is empty.
 *
 * @since 1.0.0
 *
 * @return string Video URL, or an empty string when none is set.
 */
function iflynepal_partner_video_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_partner_video', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) wp_get_attachment_url( $attachment_id );
}

/**
 * MIME type of the video, for the source element's type attribute.
 *
 * @since 1.0.0
 *
 * @return string MIME type, or an empty string when no video is set.
 */
function iflynepal_partner_video_mime() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_partner_video', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	return (string) get_post_mime_type( $attachment_id );
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the card heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_partner_title() {
	return iflynepal_partner_title();
}

/**
 * Renders the whole copy column's paragraphs.
 *
 * One partial for the column rather than one per paragraph: emptying a
 * paragraph removes it, which changes how many there are, and a per-paragraph
 * partial would leave an empty block standing where it had been.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_partner_description() {
	$markup = '';

	foreach ( iflynepal_partner_description_paragraphs() as $paragraph ) {
		$markup .= '<p>' . iflynepal_kses_text( $paragraph ) . '</p>';
	}

	return $markup;
}

/**
 * Renders the button, or nothing when its label has been emptied.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_partner_button() {
	$button = iflynepal_partner_button();

	if ( '' === trim( $button['label'] ) ) {
		return '';
	}

	return sprintf(
		'<div class="wp-block-button iflynepal-btn--primary"><a class="wp-block-button__link wp-element-button" %1$s>%2$s</a></div>',
		iflynepal_anchor_attr( $button['url'] ),
		esc_html( $button['label'] )
	);
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the Trusted Partner card's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical
 * note on iflynepal_register_cta_pll_strings() in
 * inc/customizer/callbacks/cta.php), so registration can't live inside the
 * getters above — those run on the front end.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_partner_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$group = 'iFlyNepal — Homepage / Trusted Partner';

	pll_register_string( 'Trusted Partner title', get_theme_mod( 'iflynepal_partner_title', IFLYNEPAL_PARTNER_TITLE_DEFAULT ), $group, true );

	for ( $i = 1; $i <= IFLYNEPAL_PARTNER_DESCRIPTION_MAX; $i++ ) {
		$value = trim( (string) get_theme_mod( 'iflynepal_partner_description_' . $i, iflynepal_partner_description_default( $i ) ) );

		if ( '' === $value ) {
			continue;
		}

		pll_register_string( "Trusted Partner paragraph $i", $value, $group, true );
	}

	pll_register_string( 'Trusted Partner button label', get_theme_mod( 'iflynepal_partner_button_label', IFLYNEPAL_PARTNER_BUTTON_LABEL_DEFAULT ), $group );
	pll_register_string( 'Trusted Partner image alt text', iflynepal_partner_image_default_alt(), $group );
}
add_action( 'admin_init', 'iflynepal_register_partner_pll_strings', 19 );
