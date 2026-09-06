<?php
/**
 * CSR: the commitment statement.
 *
 * A centred head, then the copy column beside a tall photograph. The copy is
 * an add/remove list of paragraphs, so the block is rendered even when every
 * one has been emptied — the fragment the Customizer replaces has to stay on
 * the page for adding one back to update in place.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_commitment() ) {
	return;
}

$iflynepal_csr_commitment_image = iflynepal_csr_commitment_image_url();
?>
<section
	class="wp-block-group iflynepal-csr-section"
	id="commitment"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-section__inner">

		<div class="iflynepal-csr-head" data-iflynepal-reveal>
			<p class="iflynepal-csr-head__kicker" id="iflynepal-csr-commitment-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_commitment_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-csr-head__title" id="iflynepal-csr-commitment-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_commitment_title();
				?>
			</h2>
		</div>

		<div class="iflynepal-csr-commitment">

			<div class="iflynepal-csr-commitment__copy" id="iflynepal-csr-commitment-copy" data-iflynepal-reveal>
				<?php
				// Each paragraph is kses-filtered inside the render callback.
				echo iflynepal_render_csr_commitment_paragraphs();
				?>
			</div>

			<?php if ( $iflynepal_csr_commitment_image ) : ?>
				<figure class="iflynepal-csr-commitment__photo" data-iflynepal-reveal>
					<img
						loading="lazy"
						src="<?php echo esc_url( $iflynepal_csr_commitment_image ); ?>"
						alt="<?php echo esc_attr( iflynepal_csr_commitment_image_alt() ); ?>"
					>
				</figure>
			<?php endif; ?>

		</div>

	</div>
</section>
