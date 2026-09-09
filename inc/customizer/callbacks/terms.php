<?php
/**
 * Terms & Conditions page: the editable parts and their defaults.
 *
 * The clauses themselves are not here and are not editable — a legal document
 * is republished when its wording is agreed, not tuned control by control, so
 * it lives in template-parts/terms/clauses-section.php beside its markup. What
 * *is* here is everything around the document: the hero photograph and the
 * closing "questions before you book" card, both of which are marketing copy
 * that changes without the terms changing.
 *
 * The three contact fields default to empty and fall back to the footer's own
 * office settings at render time. The phone number therefore still lives in
 * one place for a site that has only ever filled the footer in, while a page
 * that wants a different contact — a legal address rather than the sales line
 * — can say so without changing the footer.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The hero photograph shipped with the theme, used until one is uploaded.
 *
 * @since 1.0.0
 * @var string
 */
define( 'IFLYNEPAL_TERMS_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/terms/hero-terms-and-conditions.jpg' );

const IFLYNEPAL_TERMS_CTA_KICKER_DEFAULT = 'Questions before you book';

const IFLYNEPAL_TERMS_CTA_TITLE_DEFAULT = 'Anything here you would like us to <em>explain</em>?';

const IFLYNEPAL_TERMS_CTA_TEXT_DEFAULT = 'Write to the Kathmandu head office and we will walk you through the clause that matters to your trip — insurance, refunds, or safety on the trail.';

const IFLYNEPAL_TERMS_CTA_SCRIPT_DEFAULT = 'we reply personally';

const IFLYNEPAL_TERMS_CTA_CONTACT_LABEL_DEFAULT = 'Contact us';

const IFLYNEPAL_TERMS_CTA_CONTACT_URL_DEFAULT = '/contact-us';

const IFLYNEPAL_TERMS_CTA_WHATSAPP_LABEL_DEFAULT = 'WhatsApp us';

const IFLYNEPAL_TERMS_CTA_PHONE_NOTE_DEFAULT = 'WhatsApp / emergency';

const IFLYNEPAL_TERMS_CTA_HOURS_NOTE_DEFAULT = 'Nepal time';

const IFLYNEPAL_TERMS_CTA_HOURS_DAYS_DEFAULT = 'Monday to Friday';

/* --------------------------------------------------------------------- hero */

/**
 * The hero photograph's URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the file shipped with the theme.
 */
function iflynepal_terms_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_terms_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_TERMS_HERO_IMAGE_DEFAULT;
}

/* --------------------------------------------------------- the closing card */

/**
 * The small capitalised line above the closing headline.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_render_terms_cta_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_terms_cta_kicker', IFLYNEPAL_TERMS_CTA_KICKER_DEFAULT ) );
}

/**
 * The closing headline. Accepts <em> for the gold serif accent.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_render_terms_cta_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_terms_cta_title', IFLYNEPAL_TERMS_CTA_TITLE_DEFAULT ) );
}

/**
 * The paragraph under the closing headline.
 *
 * @since 1.0.0
 *
 * @return string Paragraph HTML.
 */
function iflynepal_render_terms_cta_text() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_terms_cta_text', IFLYNEPAL_TERMS_CTA_TEXT_DEFAULT ) );
}

/**
 * The handwritten line above the buttons.
 *
 * @since 1.0.0
 *
 * @return string Script line HTML.
 */
function iflynepal_render_terms_cta_script() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_terms_cta_script', IFLYNEPAL_TERMS_CTA_SCRIPT_DEFAULT ) );
}

/**
 * One of the closing card's contact fields, falling back to the footer's.
 *
 * An empty setting is not an empty line: it means "whatever the footer says".
 *
 * @since 1.0.0
 *
 * @param string $field One of 'phone', 'email', 'hours'.
 * @return string The value, trimmed.
 */
function iflynepal_terms_cta_contact_field( $field ) {
	$value = trim( (string) get_theme_mod( 'iflynepal_terms_cta_' . $field, '' ) );

	if ( '' !== $value ) {
		return $value;
	}

	return trim( iflynepal_footer_office_field( $field ) );
}

/**
 * Resolves a button's stored link.
 *
 * A path is stored rather than a whole address, so the link survives the site
 * moving domain; anything already absolute is left alone.
 *
 * @since 1.0.0
 *
 * @param string $url Stored value.
 * @return string A URL.
 */
function iflynepal_terms_cta_url( $url ) {
	if ( '' === $url ) {
		return '';
	}

	if ( preg_match( '#^(https?:)?//#', $url ) || 0 === strpos( $url, 'mailto:' ) || 0 === strpos( $url, 'tel:' ) ) {
		return $url;
	}

	return home_url( '/' === $url[0] ? $url : '/' . $url );
}

/**
 * Renders the closing card's two buttons.
 *
 * The WhatsApp button is dropped when there is no number to send anyone to —
 * neither its own setting nor a phone number to strip down to digits.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_terms_cta_actions() {
	$markup = '';

	$contact_label = trim( (string) get_theme_mod( 'iflynepal_terms_cta_contact_label', IFLYNEPAL_TERMS_CTA_CONTACT_LABEL_DEFAULT ) );
	$contact_url   = trim( (string) get_theme_mod( 'iflynepal_terms_cta_contact_url', IFLYNEPAL_TERMS_CTA_CONTACT_URL_DEFAULT ) );

	if ( '' !== $contact_label ) {
		$markup .= sprintf(
			'<a class="iflynepal-button iflynepal-button--light" href="%1$s">%2$s<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>',
			esc_url( iflynepal_terms_cta_url( $contact_url ) ),
			esc_html( $contact_label )
		);
	}

	$whatsapp_label  = trim( (string) get_theme_mod( 'iflynepal_terms_cta_whatsapp_label', IFLYNEPAL_TERMS_CTA_WHATSAPP_LABEL_DEFAULT ) );
	$whatsapp_number = trim( (string) get_theme_mod( 'iflynepal_terms_cta_whatsapp_number', '' ) );

	if ( '' === $whatsapp_number ) {
		$whatsapp_number = iflynepal_terms_cta_contact_field( 'phone' );
	}

	$whatsapp_digits = preg_replace( '/\D/', '', $whatsapp_number );

	if ( '' !== $whatsapp_label && '' !== $whatsapp_digits ) {
		$markup .= sprintf(
			'<a class="iflynepal-button iflynepal-button--outline" href="%1$s" target="_blank" rel="noopener">%2$s</a>',
			esc_url( 'https://wa.me/' . $whatsapp_digits ),
			esc_html( $whatsapp_label )
		);
	}

	return $markup;
}

/**
 * Renders the contact lines beside the closing copy.
 *
 * Each line is dropped when its field is empty, so a site that publishes no
 * phone number gets a shorter card rather than a stray icon.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_terms_cta_lines() {
	$markup = '';

	$phone      = iflynepal_terms_cta_contact_field( 'phone' );
	$phone_note = trim( (string) get_theme_mod( 'iflynepal_terms_cta_phone_note', IFLYNEPAL_TERMS_CTA_PHONE_NOTE_DEFAULT ) );

	if ( '' !== $phone ) {
		$markup .= sprintf(
			'<p class="iflynepal-legal-accept__line"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8 3H5a2 2 0 0 0-2 2c0 8.84 7.16 16 16 16a2 2 0 0 0 2-2v-3l-5-1-1.5 2.5a13 13 0 0 1-8-8L9 8z"/></svg><a href="%1$s">%2$s</a></p>',
			esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ),
			esc_html( '' === $phone_note ? $phone : $phone . ' (' . $phone_note . ')' )
		);
	}

	$email = iflynepal_terms_cta_contact_field( 'email' );

	if ( is_email( $email ) ) {
		$markup .= sprintf(
			'<p class="iflynepal-legal-accept__line"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 5h18v14H3z"/><path d="m3 7 9 6 9-6"/></svg><a href="%1$s">%2$s</a></p>',
			esc_url( 'mailto:' . $email ),
			esc_html( $email )
		);
	}

	$hours      = iflynepal_terms_cta_contact_field( 'hours' );
	$hours_note = trim( (string) get_theme_mod( 'iflynepal_terms_cta_hours_note', IFLYNEPAL_TERMS_CTA_HOURS_NOTE_DEFAULT ) );
	$hours_days = trim( (string) get_theme_mod( 'iflynepal_terms_cta_hours_days', IFLYNEPAL_TERMS_CTA_HOURS_DAYS_DEFAULT ) );

	if ( '' !== $hours ) {
		$line = $hours;

		if ( '' !== $hours_note ) {
			$line .= ' (' . $hours_note . ')';
		}

		if ( '' !== $hours_days ) {
			$line .= ', ' . $hours_days;
		}

		$markup .= sprintf(
			'<p class="iflynepal-legal-accept__line"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span>%1$s</span></p>',
			esc_html( $line )
		);
	}

	return $markup;
}
