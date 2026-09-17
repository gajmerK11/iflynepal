<?php
/**
 * Visa Services: the destinations grid.
 *
 * A tiled grid of countries on the page's own white, each cell a short code
 * above the country name, with an optional note under it for the destinations
 * that are handled on request.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_destinations() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-section" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">

		<div class="iflynepal-visa-head">
			<p class="iflynepal-visa-head__kicker" id="iflynepal-visa-destinations-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_destinations_kicker();
				?>
			</p>
			<h2 class="iflynepal-visa-head__title" id="iflynepal-visa-destinations-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_destinations_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-visa-dests" id="iflynepal-visa-destinations">
			<?php
			// Names and codes are escaped inside the render callback.
			echo iflynepal_render_visa_destinations();
			?>
		</div>

		<p class="iflynepal-visa-dests__note" id="iflynepal-visa-destinations-note">
			<?php
			// Sanitized by iflynepal_kses_rich() on save and again on read.
			echo iflynepal_render_visa_destinations_note();
			?>
		</p>

	</div>
</section>
