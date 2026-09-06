<?php
/**
 * Contact page content getters.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

const IFLYNEPAL_CONTACT_REPRESENTATIVE_MAX = 6;

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
		'hero_lead'            => __( 'Write to our Kathmandu head office, or speak with our worldwide representative closest to you.', 'iflynepal' ),
		'hero_primary_label'   => __( 'Send a message', 'iflynepal' ),
		'hero_primary_url'     => '#enquiry',
		'hero_secondary_label' => __( 'Speak with a representative', 'iflynepal' ),
		'hero_secondary_url'   => '#representatives',
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
		'reps_kicker'          => __( 'Across the world', 'iflynepal' ),
		'reps_title'           => __( 'Speak with our worldwide <span class="accent">representative</span>', 'iflynepal' ),
		'reps_lead'            => __( 'Your local point of contact, connected directly with our Nepal-based team. Every number below reaches us on Mobile and WhatsApp.', 'iflynepal' ),
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

/**
 * Default representative cards.
 *
 * @return array[]
 */
function iflynepal_contact_representative_defaults() {
	return array(
		1 => array( 'name' => 'Prem', 'country' => 'Nepal', 'phone' => '+9779851075128', 'phone_label' => '+977-9851075128', 'channel' => '(Mobile/WhatsApp)', 'image' => IFLYNEPAL_URI . '/assets/images/team/member-01-prem-chief-executive.jpg' ),
		2 => array( 'name' => 'Gyanu', 'country' => 'USA', 'phone' => '+15416784853', 'phone_label' => '+1 (541) 678-4853', 'channel' => '(Mobile/WhatsApp)', 'image' => IFLYNEPAL_URI . '/assets/images/team/member-05-gyanu-business-development-usa.jpg' ),
		3 => array( 'name' => 'Raju', 'country' => 'France', 'phone' => '+33605738953', 'phone_label' => '+33-605738953', 'channel' => '(Mobile/WhatsApp)', 'image' => IFLYNEPAL_URI . '/assets/images/team/representative-03-raju-france.jpg' ),
		4 => array( 'name' => 'Vijay', 'country' => 'Italy', 'phone' => '+393471728275', 'phone_label' => '+39 347 172 8275', 'channel' => '(Mobile/WhatsApp)', 'image' => IFLYNEPAL_URI . '/assets/images/team/representative-04-vijay-italy.jpg' ),
		5 => array( 'name' => 'Suraj', 'country' => 'Australia', 'phone' => '+61449996267', 'phone_label' => '+61 449 996 267', 'channel' => '(Mobile/WhatsApp)', 'image' => IFLYNEPAL_URI . '/assets/images/team/representative-05-suraj-australia.jpg' ),
		6 => array( 'name' => 'Ayush', 'country' => 'Japan', 'phone' => '+9779841771010', 'phone_label' => __( 'Reach via head office', 'iflynepal' ), 'channel' => '+977 9841771010', 'image' => IFLYNEPAL_URI . '/assets/images/team/representative-06-ayush-japan.jpg' ),
	);
}

/**
 * One representative's defaults.
 *
 * @param int $index Card number.
 * @return array
 */
function iflynepal_contact_representative_default( $index ) {
	$defaults = iflynepal_contact_representative_defaults();

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : array( 'name' => '', 'country' => '', 'phone' => '', 'phone_label' => '', 'channel' => '', 'image' => '' );
}

/**
 * Representative cards with a name.
 *
 * @return array[]
 */
function iflynepal_contact_representatives() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_CONTACT_REPRESENTATIVE_MAX; $i++ ) {
		$default = iflynepal_contact_representative_default( $i );
		$name    = trim( (string) get_theme_mod( 'iflynepal_contact_rep_' . $i . '_name', $default['name'] ) );

		if ( '' === $name ) {
			continue;
		}

		$cards[] = array(
			'index'       => $i,
			'name'        => $name,
			'country'     => trim( (string) get_theme_mod( 'iflynepal_contact_rep_' . $i . '_country', $default['country'] ) ),
			'phone'       => preg_replace( '/[^0-9+]/', '', (string) get_theme_mod( 'iflynepal_contact_rep_' . $i . '_phone', $default['phone'] ) ),
			'phone_label' => trim( (string) get_theme_mod( 'iflynepal_contact_rep_' . $i . '_phone_label', $default['phone_label'] ) ),
			'channel'     => trim( (string) get_theme_mod( 'iflynepal_contact_rep_' . $i . '_channel', $default['channel'] ) ),
		);
	}

	return $cards;
}

/**
 * Representative photograph URL.
 *
 * @param int $index Card number.
 * @return string
 */
function iflynepal_contact_representative_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_contact_rep_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_contact_representative_default( $index );

	return $default['image'];
}

/**
 * Representative photograph alt text.
 *
 * @param array $card Representative data.
 * @return string
 */
function iflynepal_contact_representative_image_alt( $card ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_contact_rep_' . $card['index'] . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	return sprintf( __( '%1$s, representative in %2$s', 'iflynepal' ), $card['name'], $card['country'] );
}

/**
 * Whether the representative section has content.
 *
 * @return bool
 */
function iflynepal_contact_has_representatives() {
	return '' !== trim( wp_strip_all_tags( iflynepal_contact_text( 'reps_title' ) ) ) && (bool) iflynepal_contact_representatives();
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
