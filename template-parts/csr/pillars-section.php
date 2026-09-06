<?php
/**
 * CSR: the sustainability pillars.
 *
 * Wide rows on the tinted band, each a photograph beside its copy, alternating
 * sides down the page. The numerals are counted at render time from each row's
 * position rather than stored, so removing one renumbers the rest.
 *
 * The list is rendered even when empty, so the fragment the Customizer
 * replaces stays on the page.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-csr-section iflynepal-section--mist"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-section__inner">
		<div class="iflynepal-csr-pillars" id="iflynepal-csr-pillars">
			<?php
			// Titles are kses-filtered and images escaped inside the render callback.
			echo iflynepal_render_csr_pillars();
			?>
		</div>
	</div>
</section>
