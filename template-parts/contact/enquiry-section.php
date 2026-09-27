<?php
/**
 * Contact form and map.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_notice = iflynepal_contact_form_notice();
?>
<section class="wp-block-group iflynepal-contact-section iflynepal-section--mist" id="enquiry" data-iflynepal-motion aria-labelledby="iflynepal-contact-enquiry-title">
	<div class="iflynepal-contact-container">
		<header class="iflynepal-contact-head" data-iflynepal-reveal>
			<p class="iflynepal-contact-eyebrow" id="iflynepal-contact-enquiry-kicker"><?php echo iflynepal_contact_text( 'enquiry_kicker' ); ?></p>
			<h2 id="iflynepal-contact-enquiry-title"><?php echo iflynepal_contact_text( 'enquiry_title' ); ?></h2>
			<p id="iflynepal-contact-enquiry-lead"><?php echo iflynepal_contact_text( 'enquiry_lead' ); ?></p>
		</header>

		<div class="iflynepal-contact-enquiry">
			<div class="iflynepal-contact-form-card" data-iflynepal-reveal>
				<h2 id="iflynepal-contact-form-title"><?php echo esc_html( iflynepal_contact_plain( 'form_title' ) ); ?></h2>
				<p class="iflynepal-contact-form-card__note" id="iflynepal-contact-form-note"><?php echo esc_html( iflynepal_contact_plain( 'form_note' ) ); ?></p>
				<?php if ( $iflynepal_notice ) : ?>
					<div class="iflynepal-contact-notice iflynepal-contact-notice--<?php echo esc_attr( $iflynepal_notice['type'] ); ?>" id="iflynepal-contact-notice" role="status"><?php echo esc_html( $iflynepal_notice['message'] ); ?></div>
					<?php
					/*
					 * The status lives in the URL itself (see
					 * iflynepal_contact_form_redirect()), so a plain reload — no new
					 * submission, just the visitor pressing F5 — would ask the server
					 * for the same URL and get the same notice back. Clearing the
					 * query arg right away, without a navigation, means the next
					 * reload asks for the page with nothing to report. The hash is
					 * left alone: the browser is still in the middle of scrolling to
					 * it when this runs, and clearing it here beats that scroll to the
					 * punch, landing the visitor back at the top of the page instead
					 * of at the form. The fade-out on top of that is for the visitor
					 * who never reloads at all: the notice answers "did it send?" and
					 * stops being needed once that has had time to sink in.
					 */
					?>
					<script>
					( function () {
						var notice = document.getElementById( 'iflynepal-contact-notice' );

						if ( ! notice ) {
							return;
						}

						if ( window.history && window.history.replaceState ) {
							var url = new URL( window.location.href );
							url.searchParams.delete( 'contact_status' );
							window.history.replaceState( null, '', url.toString() );
						}

						window.setTimeout( function () {
							notice.style.transition = 'opacity .3s ease';
							notice.style.opacity = '0';

							window.setTimeout( function () {
								notice.remove();
							}, 300 );
						}, 6000 );
					} )();
					</script>
				<?php endif; ?>

				<form class="iflynepal-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
					<input type="hidden" name="action" value="iflynepal_contact_submit">
					<?php wp_nonce_field( 'iflynepal_contact_submit', 'iflynepal_contact_nonce' ); ?>
					<label class="iflynepal-contact-honeypot" aria-hidden="true">Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Full Name', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="text" name="full_name" placeholder="<?php esc_attr_e( 'Your full name', 'iflynepal' ); ?>" autocomplete="name" required><small><?php esc_html_e( 'Please enter your full name.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Email Address', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'iflynepal' ); ?>" autocomplete="email" required><small><?php esc_html_e( 'Please enter a valid email address.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Your Country', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="text" name="country" placeholder="<?php esc_attr_e( 'Your Country', 'iflynepal' ); ?>" autocomplete="country-name" required><small><?php esc_html_e( 'Please enter your country.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Mobile Number', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="tel" name="phone" placeholder="<?php esc_attr_e( 'Your WhatsApp number', 'iflynepal' ); ?>" autocomplete="tel" pattern="^\+?[0-9\s()\-]{7,20}$" required><small><?php esc_html_e( 'Please enter a valid mobile number.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Your Question / Message', 'iflynepal' ); ?> <b>*</b></span><textarea class="iflynepal-contact-control" name="message" rows="5" placeholder="<?php esc_attr_e( 'Write your message here...', 'iflynepal' ); ?>" required></textarea><small><?php esc_html_e( 'Please enter your question or message.', 'iflynepal' ); ?></small></label>
					<div class="iflynepal-contact-form__actions"><button class="iflynepal-button iflynepal-contact-submit" type="submit"><?php esc_html_e( 'Submit', 'iflynepal' ); ?> <?php echo iflynepal_contact_icon( 'arrow-right' ); ?></button><span id="iflynepal-contact-form-hint"><?php echo esc_html( iflynepal_contact_plain( 'form_hint' ) ); ?></span></div>
				</form>
			</div>

			<div class="iflynepal-contact-map" data-iflynepal-reveal>
				<div class="iflynepal-contact-map__frame"><?php echo iflynepal_render_contact_map_embed(); ?></div>
				<div class="iflynepal-contact-map__foot"><div><small id="iflynepal-contact-map-label"><?php echo esc_html( iflynepal_contact_plain( 'map_label' ) ); ?></small><h3 id="iflynepal-contact-map-title"><?php echo esc_html( iflynepal_contact_plain( 'map_title' ) ); ?></h3><p id="iflynepal-contact-map-hours"><?php echo esc_html( iflynepal_contact_plain( 'map_hours' ) ); ?></p></div><?php echo iflynepal_render_contact_map_button(); ?></div>
			</div>
		</div>
	</div>
</section>
