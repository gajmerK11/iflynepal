<?php
/**
 * Final call-to-action getters and selective-refresh render callbacks.
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
 * Buttons the card carries. The design is a gold action beside a ghost one.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CTA_BUTTONS = 2;

/**
 * Default kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CTA_KICKER_DEFAULT = 'Your Nepal, your pace';

/**
 * Default heading, with the inked underline on one phrase.
 *
 * `underline` is the class an editor puts on a span to mark a word, the same
 * one the Explore heading uses. See the note in assets/css/input.css — inside a
 * heading it also cancels Tailwind's own `.underline` utility, which would
 * otherwise draw a plain rule under the word on top of the inked mark.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CTA_TITLE_DEFAULT = 'One country. More than <span class="underline">one way</span> to experience it.';

/**
 * Default paragraph under the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CTA_DESCRIPTION_DEFAULT = 'Come for the mountains, culture or wildlife. Stay longer for stillness, reflection and the parts of Nepal that reveal themselves when you stop rushing.';

/**
 * Stand-in photograph, used until the client's own image is uploaded.
 *
 * The card is a photograph with a scrim over it, so it needs an image to be
 * the thing the design describes at all. This is the frame the approved mockup
 * ships.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CTA_IMAGE_DEFAULT = 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2000&q=88';

/**
 * Alt text for the stand-in photograph, as the approved mockup has it.
 *
 * The card's own copy does not say what the picture shows, so the image is not
 * decorative and needs a description of its own.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_cta_image_alt() {
	return __( 'Dramatic Himalayan mountains at the end of a Nepal journey', 'iflynepal' );
}

/**
 * Default label and destination for each button.
 *
 * The mockup points these at its planner and featured sections, neither of
 * which has a counterpart in the theme yet, so they land on the sections that
 * hold the nearest live equivalents — the same substitution the FAQ link makes.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1, each with 'label' and 'url'.
 */
function iflynepal_cta_button_defaults() {
	return array(
		1 => array(
			'label' => __( 'Plan My Nepal Trip', 'iflynepal' ),
			'url'   => '#people',
		),
		2 => array(
			'label' => __( 'Explore Experiences', 'iflynepal' ),
			'url'   => '#explore',
		),
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * Kicker above the heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_cta_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_cta_kicker', IFLYNEPAL_CTA_KICKER_DEFAULT ) );
}

/**
 * Card heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_cta_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_cta_title', IFLYNEPAL_CTA_TITLE_DEFAULT ) );
}

/**
 * Paragraph under the heading.
 *
 * @since 1.0.0
 *
 * @return string Paragraph HTML.
 */
function iflynepal_cta_description() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_cta_description', IFLYNEPAL_CTA_DESCRIPTION_DEFAULT ) );
}

/**
 * One button's label and link.
 *
 * @since 1.0.0
 *
 * @param int $index Button number, 1 or 2.
 * @return array{label: string, url: string} Label and link. Label is empty when the button is off.
 */
function iflynepal_cta_button( $index ) {
	$defaults = iflynepal_cta_button_defaults();
	$default  = isset( $defaults[ $index ] ) ? $defaults[ $index ] : array(
		'label' => '',
		'url'   => '',
	);

	return array(
		'label' => (string) get_theme_mod( 'iflynepal_cta_button_' . $index . '_label', $default['label'] ),
		'url'   => (string) get_theme_mod( 'iflynepal_cta_button_' . $index . '_url', $default['url'] ),
	);
}

/* ------------------------------------------------------------------- media */

/**
 * Background photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the mockup's stand-in.
 */
function iflynepal_cta_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_cta_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_CTA_IMAGE_DEFAULT;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cta_kicker() {
	return iflynepal_cta_kicker();
}

/**
 * Renders the card heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cta_title() {
	return iflynepal_cta_title();
}

/**
 * Renders the paragraph.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cta_description() {
	return iflynepal_cta_description();
}

/**
 * Renders both buttons, skipping either one whose label has been emptied.
 *
 * The gold treatment sits on the first button here, unlike the hero: this is
 * the last thing on the page and "plan my trip" is the action it is asking
 * for, so it leads rather than follows.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_cta_actions() {
	$modifiers = array(
		1 => 'iflynepal-btn--primary',
		2 => 'iflynepal-btn--ghost',
	);

	$markup = '';

	foreach ( $modifiers as $index => $modifier ) {
		$button = iflynepal_cta_button( $index );

		if ( '' === trim( $button['label'] ) ) {
			continue;
		}

		$markup .= sprintf(
			'<div class="wp-block-button %1$s"><a class="wp-block-button__link wp-element-button" href="%2$s">%3$s</a></div>',
			esc_attr( $modifier ),
			esc_url( $button['url'] ),
			esc_html( $button['label'] )
		);
	}

	return $markup;
}
