<?php
/**
 * Visa Services: the fee notice.
 *
 * The navy band near the foot of the page, carrying what the service fee does
 * not cover and the statement that no agency can guarantee an embassy's
 * decision. Dark rather than tinted on purpose: it is the one block on the page
 * a visitor should not skim past, and it is also the block a dissatisfied
 * applicant will be pointed back to.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_notice() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-notice" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">
		<div class="iflynepal-visa-notice__panel">

			<h2 class="iflynepal-visa-notice__title" id="iflynepal-visa-notice-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_notice_title();
				?>
			</h2>

			<div class="iflynepal-visa-notice__body" id="iflynepal-visa-notice-body">
				<?php
				// Sanitized by iflynepal_kses_rich() inside the render callback.
				echo iflynepal_render_visa_notice_body();
				?>
			</div>

		</div>
	</div>
</section>
