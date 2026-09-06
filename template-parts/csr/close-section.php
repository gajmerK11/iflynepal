<?php
/**
 * CSR: the closing invitation.
 *
 * The last block before the footer: a kicker, a two-line headline and one
 * paragraph carrying the contact address. That paragraph is the only field on
 * the page that accepts a link, so it is sanitized with iflynepal_kses_rich().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_close() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-csr-section iflynepal-csr-close"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-close__inner" data-iflynepal-reveal>

		<p class="iflynepal-csr-close__kicker" id="iflynepal-csr-close-kicker">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_csr_close_kicker();
			?>
		</p>

		<h2 class="wp-block-heading iflynepal-csr-close__title" id="iflynepal-csr-close-title">
			<?php
			// Both lines are kses-filtered inside the render callback.
			echo iflynepal_render_csr_close_title();
			?>
		</h2>

		<p class="iflynepal-csr-close__text" id="iflynepal-csr-close-text">
			<?php
			// Sanitized by iflynepal_kses_rich() on save and again on read.
			echo iflynepal_render_csr_close_text();
			?>
		</p>

	</div>
</section>
