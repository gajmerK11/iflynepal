<?php
/**
 * Secure, WP-native Contact page submission handler.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return to the Contact page with a form status.
 *
 * @param string $status Result key.
 * @return void
 */
function iflynepal_contact_form_redirect( $status ) {
	$fallback = home_url( '/contact-us/' );
	$referer  = wp_get_referer();
	$url      = $referer ? wp_validate_redirect( $referer, $fallback ) : $fallback;
	$url      = remove_query_arg( 'contact_status', $url );

	wp_safe_redirect( add_query_arg( 'contact_status', sanitize_key( $status ), $url ) . '#enquiry' );
	exit;
}

/**
 * Validates, sends and reports one public enquiry, without redirecting.
 *
 * Shared by the no-JS submission (which redirects with the result) and the
 * AJAX one (which reports it straight back to the same page) so the two paths
 * can never validate or notify differently.
 *
 * @since 1.0.0
 *
 * @return string One of 'invalid', 'invalid_phone', 'error' or 'success'.
 */
function iflynepal_process_contact_submission() {
	$nonce = isset( $_POST['iflynepal_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iflynepal_contact_nonce'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, 'iflynepal_contact_submit' ) ) {
		return 'invalid';
	}

	// Quietly accept automated submissions that fill the hidden website field.
	if ( ! empty( $_POST['website'] ) ) {
		return 'success';
	}

	$name    = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$country = isset( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $country || '' === $message ) {
		return 'invalid';
	}

	// Reported apart from the rest so the visitor is told which field to fix.
	if ( ! preg_match( '/^\+?[0-9\s()\-]{7,20}$/', $phone ) ) {
		return 'invalid_phone';
	}

	/*
	 * The booking plugin owns the "send form submissions to" setting, and this
	 * page's messages belong in the same inbox as the enquiries and the Connect
	 * With Us requests. The theme still stands on its own without the plugin:
	 * the address published on the Contact page, then the administrator.
	 */
	if ( function_exists( 'iflynepal_notification_recipient' ) ) {
		$recipient = iflynepal_notification_recipient();
	} else {
		$recipient = sanitize_email( iflynepal_contact_plain( 'office_email' ) );

		if ( ! is_email( $recipient ) ) {
			$recipient = sanitize_email( get_option( 'admin_email' ) );
		}
	}

	if ( ! is_email( $recipient ) ) {
		return 'error';
	}

	$phone_digits = function_exists( 'iflynepal_booking_sanitize_setting' )
		? iflynepal_booking_sanitize_setting( $phone, 'digits' )
		: (string) preg_replace( '/[^0-9]/', '', $phone );
	$chat_url     = '' === $phone_digits ? '' : 'https://wa.me/' . $phone_digits;

	$subject = sprintf( __( 'Website enquiry from %s', 'iflynepal' ), $name );
	$body    = implode(
		"\n",
		array(
			sprintf( __( 'Name: %s', 'iflynepal' ), $name ),
			sprintf( __( 'Email: %s', 'iflynepal' ), $email ),
			sprintf( __( 'Country: %s', 'iflynepal' ), $country ),
			sprintf( __( 'Phone: %s', 'iflynepal' ), $phone ),
			'',
			__( 'Message:', 'iflynepal' ),
			$message,
			'',
			/* translators: %s: a WhatsApp click-to-chat link for the sender. */
			sprintf( __( 'Reply on WhatsApp: %s', 'iflynepal' ), $chat_url ),
		)
	);
	$headers = array( sprintf( 'Reply-To: %1$s <%2$s>', $name, $email ) );

	return wp_mail( $recipient, $subject, $body, $headers ) ? 'success' : 'error';
}

/**
 * The no-JS path: process the submission and redirect with the result.
 *
 * @return void
 */
function iflynepal_handle_contact_form() {
	if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		iflynepal_contact_form_redirect( 'invalid' );
	}

	iflynepal_contact_form_redirect( iflynepal_process_contact_submission() );
}
add_action( 'admin_post_iflynepal_contact_submit', 'iflynepal_handle_contact_form' );
add_action( 'admin_post_nopriv_iflynepal_contact_submit', 'iflynepal_handle_contact_form' );

/**
 * The AJAX path: process the submission and report the result as JSON.
 *
 * Posts to the same body a real submit sends admin-post.php — the action
 * field, the nonce, every form field — so contact.js can send the form
 * exactly as the browser would have, just to a different endpoint, and the
 * validation above never has to know which one asked.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_handle_contact_form_ajax() {
	$status = iflynepal_process_contact_submission();
	$notice = iflynepal_contact_notice_for_status( $status );

	if ( 'error' === $notice['type'] ) {
		wp_send_json_error( $notice );
	}

	wp_send_json_success( $notice );
}
add_action( 'wp_ajax_iflynepal_contact_submit', 'iflynepal_handle_contact_form_ajax' );
add_action( 'wp_ajax_nopriv_iflynepal_contact_submit', 'iflynepal_handle_contact_form_ajax' );

/**
 * The notice text and type for one result status.
 *
 * @since 1.0.0
 *
 * @param string $status 'success', 'invalid', 'invalid_phone' or 'error'.
 * @return array{type:string,message:string}
 */
function iflynepal_contact_notice_for_status( $status ) {
	if ( 'success' === $status ) {
		return array( 'type' => 'success', 'message' => __( 'Thank you. Your message has been sent.', 'iflynepal' ) );
	}

	if ( 'invalid' === $status ) {
		return array( 'type' => 'error', 'message' => __( 'Please check the required fields and try again.', 'iflynepal' ) );
	}

	if ( 'invalid_phone' === $status ) {
		return array(
			'type'    => 'error',
			'message' => __( 'Please enter a proper mobile number. Only numbers are allowed.', 'iflynepal' ),
		);
	}

	return array( 'type' => 'error', 'message' => __( 'Your message could not be sent. Please email or call us instead.', 'iflynepal' ) );
}

/**
 * Current form notice, when redirected back from a submission.
 *
 * @return array{type:string,message:string}|null
 */
function iflynepal_contact_form_notice() {
	$status = isset( $_GET['contact_status'] ) ? sanitize_key( wp_unslash( $_GET['contact_status'] ) ) : '';

	if ( '' === $status ) {
		return null;
	}

	return iflynepal_contact_notice_for_status( $status );
}

