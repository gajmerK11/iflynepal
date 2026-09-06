<?php
/**
 * CSR: empowering through tourism.
 *
 * A centred head over panels that carry no photograph — a rule along the top,
 * a numeral, a title and a paragraph. Numerals are counted at render time.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_tourism() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-csr-section iflynepal-section--mist"
	id="empowerment"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-section__inner">

		<div class="iflynepal-csr-head" data-iflynepal-reveal>
			<p class="iflynepal-csr-head__kicker" id="iflynepal-csr-tourism-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_tourism_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-csr-head__title" id="iflynepal-csr-tourism-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_tourism_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-csr-tourism-grid" id="iflynepal-csr-tourism-items">
			<?php
			// Titles are kses-filtered inside the render callback.
			echo iflynepal_render_csr_tourism_items();
			?>
		</div>

	</div>
</section>
