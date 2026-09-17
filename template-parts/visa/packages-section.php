<?php
/**
 * Visa Services: the packages.
 *
 * The section the hero's first button points at, so it carries the id the
 * anchor uses. Two cards side by side on the page's own white; the one the
 * Customizer gives a badge takes the raised, outlined treatment.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_visa_has_packages() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-visa-section iflynepal-visa-section--packages" id="visa-packages" data-iflynepal-motion>
	<div class="iflynepal-visa-section__inner">

		<div class="iflynepal-visa-head">
			<p class="iflynepal-visa-head__kicker" id="iflynepal-visa-packages-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_packages_kicker();
				?>
			</p>
			<h2 class="iflynepal-visa-head__title" id="iflynepal-visa-packages-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_packages_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-visa-packages" id="iflynepal-visa-packages-list">
			<?php
			// Names, taglines and features are escaped inside the render callback.
			echo iflynepal_render_visa_packages();
			?>
		</div>

	</div>
</section>
