<?php
/**
 * Visa Services: the visa categories.
 *
 * A grid of small panels on the tinted band, the first of the page's two mist
 * sections. Each panel is one kind of visa the office files.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_types() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-section iflynepal-section--mist" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">

		<div class="iflynepal-visa-head">
			<p class="iflynepal-visa-head__kicker" id="iflynepal-visa-types-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_types_kicker();
				?>
			</p>
			<h2 class="iflynepal-visa-head__title" id="iflynepal-visa-types-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_types_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-visa-types" id="iflynepal-visa-types">
			<?php
			// Titles and text are kses-filtered inside the render callback.
			echo iflynepal_render_visa_types();
			?>
		</div>

	</div>
</section>
