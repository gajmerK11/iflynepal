<?php
/**
 * The WhatsApp action in the header bar.
 *
 * Client-directed, at the right-hand end of the bar. It renders nothing at all
 * when no number is configured or the switch is off — see
 * inc/customizer/callbacks/whatsapp.php.
 *
 * The mark is an inlined single-colour glyph rather than an image or an icon
 * font, the same call the footer's social row makes: recognisable at 20px,
 * no extra request, and no third-party origin involved in drawing the header.
 *
 * `rel="noopener noreferrer"` because it opens in a new tab: without it the
 * page WhatsApp opens can reach back through window.opener.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_whatsapp = iflynepal_header_whatsapp_url();

if ( '' === $iflynepal_whatsapp ) {
	return;
}

$iflynepal_wa_label = iflynepal_header_whatsapp_label();
?>
<a
	class="iflynepal-nav-wa"
	href="<?php echo esc_url( $iflynepal_whatsapp ); ?>"
	target="_blank"
	rel="noopener noreferrer"
	title="<?php echo esc_attr( $iflynepal_wa_label ); ?>"
	aria-label="<?php echo esc_attr( $iflynepal_wa_label ); ?>"
>
	<span class="iflynepal-nav-wa__pulse" aria-hidden="true"></span>
	<svg class="iflynepal-nav-wa__ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
		<path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.87 9.87 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.11.82.83-3.04-.2-.31a8.18 8.18 0 0 1-1.26-4.38c0-4.54 3.7-8.23 8.24-8.23 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.82c0 4.54-3.69 8.23-8.24 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.97-.15.16-.29.18-.53.06-.25-.13-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.09-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.65.31-.23.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.65 4.2 3.71.59.25 1.04.4 1.4.52.59.19 1.12.16 1.55.1.47-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.06-.11-.22-.17-.47-.29z"/>
	</svg>
</a>
