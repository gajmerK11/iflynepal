<?php
/**
 * Visa Services: how an application moves from blank form to submitted file.
 *
 * Ruled rows on the tinted band, one per step. An ordered list, because the
 * order is the content — the numerals are drawn by CSS from the list itself, so
 * removing a step renumbers the rest with nothing to recount.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_process() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-section iflynepal-section--mist" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">

		<div class="iflynepal-visa-head">
			<p class="iflynepal-visa-head__kicker" id="iflynepal-visa-process-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_process_kicker();
				?>
			</p>
			<h2 class="iflynepal-visa-head__title" id="iflynepal-visa-process-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_process_title();
				?>
			</h2>
		</div>

		<ol class="iflynepal-visa-steps" id="iflynepal-visa-steps">
			<?php
			// Titles and text are kses-filtered inside the render callback.
			echo iflynepal_render_visa_steps();
			?>
		</ol>

	</div>
</section>
