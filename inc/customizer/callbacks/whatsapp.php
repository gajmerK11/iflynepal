<?php
/**
 * The header's WhatsApp button: its settings, and the link it builds.
 *
 * Client-directed: a WhatsApp action in the header bar, at the right-hand end
 * beside the call to action and the menu toggle.
 *
 * Loaded on every request rather than only inside customize_register, because
 * the header reads these on the front end.
 *
 * Every name here carries a `header_` infix on purpose. The booking plugin owns
 * iflynepal_whatsapp_number() and iflynepal_whatsapp_url() already — a package's
 * own chat link, with the package named in the message — and a theme function
 * of the same name would be a fatal redeclaration the moment both are active.
 * The two are not duplicates: this one is the site's header, that one is a
 * package's aside, and the fallback below is what keeps a single number behind
 * both.
 *
 * The number is the single source of truth. With none available there is no
 * button at all — an empty number cannot be dialled, and a WhatsApp icon that
 * opens a broken chat is worse than no icon. The on/off switch is there to take
 * the button down without losing the number, which is what an editor actually
 * wants when a chat line is paused.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The message a chat opens with when no other is set.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HEADER_WHATSAPP_MESSAGE_DEFAULT = 'Hello iFly Nepal, I would like to know more about your trips.';

/**
 * The label read out to assistive technology and shown on hover.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HEADER_WHATSAPP_LABEL_DEFAULT = 'Chat with us on WhatsApp';

/**
 * Whether the header button is switched on.
 *
 * @since 1.0.0
 *
 * @return bool True when the editor has it enabled.
 */
function iflynepal_header_whatsapp_enabled() {
	return (bool) get_theme_mod( 'iflynepal_whatsapp_enabled', true );
}

/**
 * The number typed into the Customizer, reduced to the digits WhatsApp accepts.
 *
 * Editors type numbers the way they write them — "+977 985-118 8551" — and
 * wa.me takes none of that. Stripping happens on read as well as on save, so a
 * number stored before this rule existed still works.
 *
 * @since 1.0.0
 *
 * @return string Digits only, empty when nothing is set.
 */
function iflynepal_header_whatsapp_number() {
	return preg_replace( '/[^0-9]/', '', (string) get_theme_mod( 'iflynepal_whatsapp_number', '' ) );
}

/**
 * The message the chat window opens pre-filled with.
 *
 * @since 1.0.0
 *
 * @return string Message, possibly empty.
 */
function iflynepal_header_whatsapp_message() {
	return trim( (string) get_theme_mod( 'iflynepal_whatsapp_message', IFLYNEPAL_HEADER_WHATSAPP_MESSAGE_DEFAULT ) );
}

/**
 * The button's accessible name.
 *
 * @since 1.0.0
 *
 * @return string Label, never empty.
 */
function iflynepal_header_whatsapp_label() {
	$label = trim( (string) get_theme_mod( 'iflynepal_whatsapp_label', IFLYNEPAL_HEADER_WHATSAPP_LABEL_DEFAULT ) );

	return '' !== $label ? $label : IFLYNEPAL_HEADER_WHATSAPP_LABEL_DEFAULT;
}

/**
 * The click-to-chat address the header button points at.
 *
 * WhatsApp's own redirector, wa.me, opens the desktop app, the phone app
 * or web.whatsapp.com depending on where the visitor is, which is why the link
 * is built against it rather than against any one of those directly.
 *
 * With the Customizer field left empty and the booking plugin active, the
 * plugin's number stands in and the plugin builds the link — which means the
 * header chat on a package page opens already naming that package, and a site
 * that has typed its number once at Packages > Settings does not have to type
 * it again here. Filling the field in overrides that for the whole header.
 *
 * @since 1.0.0
 *
 * @return string URL, or an empty string when the button should not render.
 */
function iflynepal_header_whatsapp_url() {
	if ( ! iflynepal_header_whatsapp_enabled() ) {
		return '';
	}

	$number = iflynepal_header_whatsapp_number();

	if ( '' === $number ) {
		if ( function_exists( 'iflynepal_whatsapp_url' ) ) {
			$package = ( function_exists( 'iflynepal_package_field' ) && is_singular( 'iflynepal_package' ) ) ? get_queried_object_id() : 0;

			return (string) iflynepal_whatsapp_url( $package );
		}

		return '';
	}

	$url     = 'https://wa.me/' . $number;
	$message = iflynepal_header_whatsapp_message();

	if ( '' !== $message ) {
		$url .= '?text=' . rawurlencode( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );
	}

	return $url;
}
