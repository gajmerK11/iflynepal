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
 * Validate and email one public enquiry.
 *
 * @return void
 */
function iflynepal_handle_contact_form() {
	if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		iflynepal_contact_form_redirect( 'invalid' );
	}

	$nonce = isset( $_POST['iflynepal_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iflynepal_contact_nonce'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, 'iflynepal_contact_submit' ) ) {
		iflynepal_contact_form_redirect( 'invalid' );
	}

	// Quietly discard automated submissions that fill the hidden website field.
	if ( ! empty( $_POST['website'] ) ) {
		iflynepal_contact_form_redirect( 'success' );
	}

	$name    = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$country = isset( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $country || '' === $message || ! preg_match( '/^\+?[0-9\s()\-]{7,20}$/', $phone ) ) {
		iflynepal_contact_form_redirect( 'invalid' );
	}

	$recipient = sanitize_email( iflynepal_contact_plain( 'office_email' ) );

	if ( ! is_email( $recipient ) ) {
		$recipient = sanitize_email( get_option( 'admin_email' ) );
	}

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
		)
	);
	$headers = array( sprintf( 'Reply-To: %1$s <%2$s>', $name, $email ) );
	$status  = wp_mail( $recipient, $subject, $body, $headers ) ? 'success' : 'error';

	iflynepal_contact_form_redirect( $status );
}
add_action( 'admin_post_iflynepal_contact_submit', 'iflynepal_handle_contact_form' );
add_action( 'admin_post_nopriv_iflynepal_contact_submit', 'iflynepal_handle_contact_form' );

/**
 * Current form notice, when redirected back from a submission.
 *
 * @return array{type:string,message:string}|null
 */
function iflynepal_contact_form_notice() {
	$status = isset( $_GET['contact_status'] ) ? sanitize_key( wp_unslash( $_GET['contact_status'] ) ) : '';

	if ( 'success' === $status ) {
		return array( 'type' => 'success', 'message' => __( 'Thank you. Your message has been sent.', 'iflynepal' ) );
	}

	if ( 'invalid' === $status ) {
		return array( 'type' => 'error', 'message' => __( 'Please check the required fields and try again.', 'iflynepal' ) );
	}

	if ( 'error' === $status ) {
		return array( 'type' => 'error', 'message' => __( 'Your message could not be sent. Please email or call us instead.', 'iflynepal' ) );
	}

	return null;
}

