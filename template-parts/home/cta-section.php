<?php
/**
 * The closing call to action: a full-bleed photograph, darkened, with the
 * kicker, heading, paragraph and both buttons centred on it.
 *
 * Everything editable here lives in Appearance > Customize > Homepage > CTA.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_cta_image = iflynepal_cta_image_url();
?>
<section class="wp-block-group iflynepal-cta" id="cta">

	<div class="wp-block-cover iflynepal-cta__card" data-iflynepal-reveal>

		<?php if ( $iflynepal_cta_image ) : ?>
			<img class="wp-block-cover__image-background" loading="lazy" src="<?php echo esc_url( $iflynepal_cta_image ); ?>" alt="<?php echo esc_attr( iflynepal_cta_image_alt() ); ?>" data-object-fit="cover">
		<?php endif; ?>

		<span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>

		<div class="wp-block-cover__inner-container iflynepal-cta__content">

			<p class="iflynepal-cta__kicker" id="iflynepal-cta-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_cta_kicker();
				?>
			</p>

			<h2 class="wp-block-heading iflynepal-cta__title" id="iflynepal-cta-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_cta_title();
				?>
			</h2>

			<p class="iflynepal-cta__description" id="iflynepal-cta-description">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_cta_description();
				?>
			</p>

			<div class="wp-block-buttons iflynepal-cta__actions" id="iflynepal-cta-actions">
				<?php
				// Labels and URLs are escaped inside the render callback.
				echo iflynepal_render_cta_actions();
				?>
			</div>

		</div>

	</div>

</section>
