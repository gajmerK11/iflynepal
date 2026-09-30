<?php
/**
 * Contact page content getters.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'IFLYNEPAL_CONTACT_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/contact/hero-contact-office-v2.jpg' );

/**
 * Default page copy and links.
 *
 * @return string[]
 */
function iflynepal_contact_defaults() {
	return array(
		'hero_kicker'          => __( 'Get in touch', 'iflynepal' ),
		'hero_title'           => __( 'Contact <em>Us</em>', 'iflynepal' ),
		'hero_lead'            => __( 'Write to our Kathmandu head office.', 'iflynepal' ),
		'hero_primary_label'   => __( 'Send a message', 'iflynepal' ),
		'hero_primary_url'     => '#enquiry',
		'hero_secondary_label' => '',
		'hero_secondary_url'   => '',
		'hero_script'          => __( 'we reply personally', 'iflynepal' ),
		'hero_scroll_label'    => __( 'Write to us', 'iflynepal' ),
		'office_label'         => __( 'Head Office', 'iflynepal' ),
		'office_address'       => __( 'Tarkeshwor-2,<br>KATHMANDU, NEPAL', 'iflynepal' ),
		'office_phone'         => '+977 9841771010',
		'office_hours'         => __( 'Time: 9:00 AM to 5:00 PM', 'iflynepal' ),
		'office_email'         => 'contact@iflynepal.com',
		'enquiry_kicker'       => __( 'Send us a message', 'iflynepal' ),
		'enquiry_title'        => __( 'Contact <span class="underline">Us</span>', 'iflynepal' ),
		'enquiry_lead'         => __( 'Tell us where you are, how to reach you, and what you would like to know.', 'iflynepal' ),
		'form_title'           => __( 'Contact Us', 'iflynepal' ),
		'form_note'            => __( 'Fields marked * are required.', 'iflynepal' ),
		'form_hint'            => __( 'Office hours 9:00 AM to 5:00 PM, Nepal time.', 'iflynepal' ),
		'map_embed_url'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3530.5621603573004!2d85.30368071113126!3d27.76164767605205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb193ec9371e29%3A0xb6e7ad8a1258aa55!2siFly%20Nepal!5e0!3m2!1sen!2snp!4v1752737443819!5m2!1sen!2snp',
		'map_label'            => __( 'Head Office', 'iflynepal' ),
		'map_title'            => __( 'Tarkeshwor-2, Kathmandu', 'iflynepal' ),
		'map_hours'            => __( 'Time: 9:00 AM to 5:00 PM', 'iflynepal' ),
		'map_button_label'     => __( 'Get directions', 'iflynepal' ),
		'map_button_url'       => 'https://maps.google.com/?q=iFly+Nepal+Kathmandu',
	);
}

/**
 * One content value that permits the theme's documented inline formatting.
 *
 * @param string $key Setting suffix.
 * @return string
 */
function iflynepal_contact_text( $key ) {
	$defaults = iflynepal_contact_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_contact_' . $key, $default ) );
}

/**
 * One plain content value.
 *
 * @param string $key Setting suffix.
 * @return string
 */
function iflynepal_contact_plain( $key ) {
	$defaults = iflynepal_contact_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	return trim( (string) get_theme_mod( 'iflynepal_contact_' . $key, $default ) );
}

/**
 * One link value.
 *
 * @param string $key Setting suffix.
 * @return string
 */
function iflynepal_contact_link( $key ) {
	if ( in_array( $key, array( 'hero_primary_url', 'hero_secondary_url' ), true ) ) {
		$defaults = iflynepal_contact_defaults();
		$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

		return iflynepal_sanitize_link( iflynepal_customizer_get_link( 'iflynepal_contact_' . $key, $default ) );
	}

	return iflynepal_sanitize_link( iflynepal_contact_plain( $key ) );
}

/**
 * Hero photograph URL.
 *
 * @return string
 */
function iflynepal_contact_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_contact_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_CONTACT_HERO_IMAGE_DEFAULT;
}

/* ------------------------------------------------------ render callbacks */

/**
 * Renders one simple Contact setting for selective refresh.
 *
 * @param WP_Customize_Partial $partial Partial being rendered.
 * @return string Markup or escaped text.
 */
function iflynepal_render_contact_field( $partial ) {
	$field = str_replace( 'iflynepal_contact_', '', $partial->id );
	$html_fields = array(
		'hero_kicker',
		'hero_title',
		'hero_lead',
		'office_address',
		'enquiry_kicker',
		'enquiry_title',
		'enquiry_lead',
	);

	if ( in_array( $field, $html_fields, true ) ) {
		return iflynepal_contact_text( $field );
	}

	return esc_html( iflynepal_contact_plain( $field ) );
}

/**
 * Hero image markup.
 *
 * @return string Markup.
 */
function iflynepal_render_contact_hero_image() {
	return sprintf(
		'<img class="iflynepal-hero__still" src="%s" alt="" fetchpriority="high" loading="eager" decoding="sync">',
		esc_url( iflynepal_contact_hero_image_url() )
	);
}

/**
 * Renders the full hero when its background changes.
 *
 * The image layer sits behind the overlay, so its edit shortcut is placed on
 * the visible section and the section is refreshed as one inclusive fragment.
 *
 * @return string Markup.
 */
function iflynepal_render_contact_hero_section() {
	ob_start();
	get_template_part( 'template-parts/contact/hero-section' );

	return (string) ob_get_clean();
}

/**
 * One hero action.
 *
 * @param string $type Action type.
 * @return string Markup.
 */
function iflynepal_contact_hero_button_markup( $type ) {
	$primary  = 'primary' === $type;
	$label    = iflynepal_contact_plain( 'hero_' . $type . '_label' );
	$url      = iflynepal_contact_link( 'hero_' . $type . '_url' );
	$modifier = $primary ? 'iflynepal-button--light' : 'iflynepal-button--outline';

	if ( '' === $label || '' === $url ) {
		return '';
	}

	return sprintf(
		'<a id="iflynepal-contact-hero-%1$s" class="iflynepal-button %2$s" %3$s>%4$s</a>',
		esc_attr( $type ),
		esc_attr( $modifier ),
		iflynepal_anchor_attr( $url ),
		esc_html( $label )
	);
}

/** @return string Markup. */
function iflynepal_render_contact_hero_primary_button() {
	return iflynepal_contact_hero_button_markup( 'primary' );
}

/** @return string Markup. */
function iflynepal_render_contact_hero_secondary_button() {
	return iflynepal_contact_hero_button_markup( 'secondary' );
}

/** @return string Markup. */
function iflynepal_render_contact_hero_scroll_label() {
	return esc_html( iflynepal_contact_plain( 'hero_scroll_label' ) ) . ' <span aria-hidden="true">&#8595;</span>';
}

/** @return string Markup. */
function iflynepal_render_contact_office_phone() {
	$phone = iflynepal_contact_plain( 'office_phone' );
	$href  = preg_replace( '/[^0-9+]/', '', $phone );

	return sprintf( '<a id="iflynepal-contact-office-phone" %1$s>%2$s</a>', iflynepal_anchor_attr( 'tel:' . $href ), esc_html( $phone ) );
}

/** @return string Markup. */
function iflynepal_render_contact_office_email() {
	$email = sanitize_email( iflynepal_contact_plain( 'office_email' ) );

	return sprintf( '<a id="iflynepal-contact-office-email" %1$s>%2$s</a>', iflynepal_anchor_attr( 'mailto:' . $email ), esc_html( $email ) );
}

/** @return string Markup. */
function iflynepal_render_contact_map_embed() {
	return sprintf(
		'<iframe id="iflynepal-contact-map-embed" title="%1$s" src="%2$s" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>',
		esc_attr__( 'iFly Nepal on Google Maps', 'iflynepal' ),
		esc_url( iflynepal_contact_plain( 'map_embed_url' ) )
	);
}

/** @return string Markup. */
function iflynepal_render_contact_map_button() {
	return sprintf(
		'<a id="iflynepal-contact-map-button" class="iflynepal-button iflynepal-contact-submit" %1$s target="_blank" rel="noopener noreferrer">%2$s %3$s</a>',
		iflynepal_anchor_attr( iflynepal_contact_link( 'map_button_url' ) ),
		esc_html( iflynepal_contact_plain( 'map_button_label' ) ),
		iflynepal_contact_icon( 'arrow-right' )
	);
}

/**
 * Small inline icon used by the Contact page.
 *
 * @param string $name Icon name.
 * @return string SVG markup, or an empty string.
 */
function iflynepal_contact_icon( $name ) {
	$paths = array(
		'phone'       => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92z"/>',
		'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'mail'        => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return '<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}
