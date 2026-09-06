<?php
/**
 * CSR: the transparency and accountability statement.
 *
 * A wide photograph beside the copy — the mirror of the commitment section
 * that opened the page, with the picture on the other side.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_accountability() ) {
	return;
}

$iflynepal_csr_accountability_image = iflynepal_csr_accountability_image_url();
?>
<section
	class="wp-block-group iflynepal-csr-section"
	id="accountability"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-section__inner iflynepal-csr-accountability">

		<?php if ( $iflynepal_csr_accountability_image ) : ?>
			<figure class="iflynepal-csr-accountability__photo" data-iflynepal-reveal>
				<img
					loading="lazy"
					src="<?php echo esc_url( $iflynepal_csr_accountability_image ); ?>"
					alt="<?php echo esc_attr( iflynepal_csr_accountability_image_alt() ); ?>"
				>
			</figure>
		<?php endif; ?>

		<div class="iflynepal-csr-accountability__copy" data-iflynepal-reveal>
			<p class="iflynepal-csr-head__kicker" id="iflynepal-csr-accountability-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_accountability_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-csr-head__title" id="iflynepal-csr-accountability-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_accountability_title();
				?>
			</h2>
			<p class="iflynepal-csr-accountability__text" id="iflynepal-csr-accountability-text">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_accountability_text();
				?>
			</p>
		</div>

	</div>
</section>
