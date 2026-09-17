<?php
/**
 * Visa Services: the three things the office handles.
 *
 * A numbered row on the page's own white, the first thing under the hero. The
 * numerals are counted at render time from each item's position rather than
 * stored, so removing one renumbers the rest.
 *
 * The list is rendered even when empty, so the fragment the Customizer replaces
 * stays on the page.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_services() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-section" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">

		<div class="iflynepal-visa-head">
			<p class="iflynepal-visa-head__kicker" id="iflynepal-visa-services-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_services_kicker();
				?>
			</p>
			<h2 class="iflynepal-visa-head__title" id="iflynepal-visa-services-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_services_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-visa-services" id="iflynepal-visa-services">
			<?php
			// Titles and text are kses-filtered inside the render callback.
			echo iflynepal_render_visa_services();
			?>
		</div>

	</div>
</section>
