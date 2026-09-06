<?php
/**
 * CSR: the community engagement projects.
 *
 * A centred head over a three-up grid of cards, each a band of photograph over
 * a numeral, a title and a paragraph. Numerals are counted at render time.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_community() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-csr-section"
	id="community"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-section__inner">

		<div class="iflynepal-csr-head" data-iflynepal-reveal>
			<p class="iflynepal-csr-head__kicker" id="iflynepal-csr-community-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_community_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-csr-head__title" id="iflynepal-csr-community-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_community_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-csr-projects" id="iflynepal-csr-projects">
			<?php
			// Titles are kses-filtered and images escaped inside the render callback.
			echo iflynepal_render_csr_projects();
			?>
		</div>

	</div>
</section>
