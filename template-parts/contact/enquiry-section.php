<?php
/**
 * Contact form and map.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_notice = iflynepal_contact_form_notice();
$iflynepal_countries = array( 'Australia', 'France', 'Italy', 'Japan', 'Nepal', 'United Kingdom', 'United States' );
?>
<section class="wp-block-group iflynepal-contact-section iflynepal-section--mist" id="enquiry" data-iflynepal-motion aria-labelledby="iflynepal-contact-enquiry-title">
	<div class="iflynepal-contact-container">
		<header class="iflynepal-contact-head" data-iflynepal-reveal>
			<p class="iflynepal-contact-eyebrow"><?php echo iflynepal_contact_text( 'enquiry_kicker' ); ?></p>
			<h2 id="iflynepal-contact-enquiry-title"><?php echo iflynepal_contact_text( 'enquiry_title' ); ?></h2>
			<p><?php echo iflynepal_contact_text( 'enquiry_lead' ); ?></p>
		</header>

		<div class="iflynepal-contact-enquiry">
			<div class="iflynepal-contact-form-card" data-iflynepal-reveal>
				<h2><?php echo esc_html( iflynepal_contact_plain( 'form_title' ) ); ?></h2>
				<p class="iflynepal-contact-form-card__note"><?php echo esc_html( iflynepal_contact_plain( 'form_note' ) ); ?></p>
				<?php if ( $iflynepal_notice ) : ?>
					<div class="iflynepal-contact-notice iflynepal-contact-notice--<?php echo esc_attr( $iflynepal_notice['type'] ); ?>" role="status"><?php echo esc_html( $iflynepal_notice['message'] ); ?></div>
				<?php endif; ?>

				<form class="iflynepal-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
					<input type="hidden" name="action" value="iflynepal_contact_submit">
					<?php wp_nonce_field( 'iflynepal_contact_submit', 'iflynepal_contact_nonce' ); ?>
					<label class="iflynepal-contact-honeypot" aria-hidden="true">Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Full Name', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="text" name="full_name" placeholder="<?php esc_attr_e( 'Your full name', 'iflynepal' ); ?>" autocomplete="name" required><small><?php esc_html_e( 'Please enter your full name.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Email Address', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="email" name="email" placeholder="you@example.com" autocomplete="email" required><small><?php esc_html_e( 'Please enter a valid email address.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Country', 'iflynepal' ); ?> <b>*</b></span><select class="iflynepal-contact-control" name="country" required><option value="" selected disabled><?php esc_html_e( 'Select your country', 'iflynepal' ); ?></option><?php foreach ( $iflynepal_countries as $iflynepal_country ) : ?><option value="<?php echo esc_attr( $iflynepal_country ); ?>"><?php echo esc_html( $iflynepal_country ); ?></option><?php endforeach; ?></select><small><?php esc_html_e( 'Please select your country.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Mobile Number', 'iflynepal' ); ?> <b>*</b></span><input class="iflynepal-contact-control" type="tel" name="phone" placeholder="+977 9800000000" autocomplete="tel" pattern="^\+?[0-9\s()\-]{7,20}$" required><small><?php esc_html_e( 'Please enter a valid mobile number.', 'iflynepal' ); ?></small></label>
					<label class="iflynepal-contact-field"><span><?php esc_html_e( 'Your Question / Message', 'iflynepal' ); ?> <b>*</b></span><textarea class="iflynepal-contact-control" name="message" rows="5" placeholder="<?php esc_attr_e( 'Write your message here...', 'iflynepal' ); ?>" required></textarea><small><?php esc_html_e( 'Please enter your question or message.', 'iflynepal' ); ?></small></label>
					<div class="iflynepal-contact-form__actions"><button class="iflynepal-button iflynepal-contact-submit" type="submit"><?php esc_html_e( 'Submit', 'iflynepal' ); ?> <?php echo iflynepal_contact_icon( 'arrow-right' ); ?></button><span><?php echo esc_html( iflynepal_contact_plain( 'form_hint' ) ); ?></span></div>
				</form>
			</div>

			<div class="iflynepal-contact-map" data-iflynepal-reveal>
				<div class="iflynepal-contact-map__frame"><iframe title="<?php esc_attr_e( 'iFly Nepal on Google Maps', 'iflynepal' ); ?>" src="<?php echo esc_url( iflynepal_contact_plain( 'map_embed_url' ) ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
				<div class="iflynepal-contact-map__foot"><div><small><?php echo esc_html( iflynepal_contact_plain( 'map_label' ) ); ?></small><h3><?php echo esc_html( iflynepal_contact_plain( 'map_title' ) ); ?></h3><p><?php echo esc_html( iflynepal_contact_plain( 'map_hours' ) ); ?></p></div><a class="iflynepal-button iflynepal-contact-submit" href="<?php echo esc_url( iflynepal_contact_link( 'map_button_url' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( iflynepal_contact_plain( 'map_button_label' ) ); ?> <?php echo iflynepal_contact_icon( 'arrow-right' ); ?></a></div>
			</div>
		</div>
	</div>
</section>
