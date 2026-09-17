<?php
/**
 * Visa Services: the closing invitation.
 *
 * The section the hero's second button points at, so it carries the id that
 * anchor uses. The heading, the copy and the button are this page's own; the
 * three contact lines under them are the Contact Us ones, read rather than
 * re-typed — see iflynepal_visa_contact_lines().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_cta() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-cta" id="visa-contact" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">
		<div class="iflynepal-visa-cta__panel">

			<div class="iflynepal-visa-cta__copy">
				<h2 class="iflynepal-visa-cta__title" id="iflynepal-visa-cta-title">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_visa_cta_title();
					?>
				</h2>

				<p class="iflynepal-visa-cta__lead" id="iflynepal-visa-cta-lead">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_visa_cta_lead();
					?>
				</p>

				<div class="wp-block-buttons iflynepal-visa-cta__actions" id="iflynepal-visa-cta-button">
					<?php
					// Label and URL are escaped inside the render callback.
					echo iflynepal_render_visa_cta_button();
					?>
				</div>
			</div>

			<?php
			/*
			 * The rail is dropped rather than printed empty when Contact Us has
			 * no phone number, email or address in it — an empty bordered column
			 * beside the copy reads as something that failed to load.
			 */
			?>
			<?php if ( iflynepal_visa_contact_lines() ) : ?>
				<div class="iflynepal-visa-contact">
					<?php
					// Labels and values are escaped inside the render callback.
					echo iflynepal_render_visa_contact_lines();
					?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
