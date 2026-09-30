<?php
/**
 * About page closing card: a full-bleed photograph, darkened, with the heading,
 * paragraph and an optional button centred on it.
 *
 * The homepage CTA's component (template-parts/home/cta-section.php) carrying
 * the About page's own copy, so it reuses the `iflynepal-cta` classes rather
 * than growing a second stylesheet for the same card. It has no kicker: the
 * heading is the statement.
 *
 * Everything editable here lives in Appearance > Customize > About > Company.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_about_has_cta() ) {
	return;
}

$iflynepal_about_cta_image = iflynepal_about_cta_image_url();
?>
<section class="wp-block-group iflynepal-cta" id="about-cta" data-iflynepal-motion>

	<div class="wp-block-cover iflynepal-cta__card" data-iflynepal-reveal>

		<?php if ( $iflynepal_about_cta_image ) : ?>
			<img class="wp-block-cover__image-background" loading="lazy" src="<?php echo esc_url( $iflynepal_about_cta_image ); ?>" alt="<?php echo esc_attr( iflynepal_cta_image_alt() ); ?>" data-object-fit="cover">
		<?php endif; ?>

		<span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>

		<div class="wp-block-cover__inner-container iflynepal-cta__content">

			<h2 class="wp-block-heading iflynepal-cta__title iflynepal-cta__title--wide" id="iflynepal-about-cta-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_about_cta_title();
				?>
			</h2>

			<p class="iflynepal-cta__description" id="iflynepal-about-cta-description">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_about_cta_description();
				?>
			</p>

			<div class="wp-block-buttons iflynepal-cta__actions" id="iflynepal-about-cta-actions">
				<?php
				// Label and URL are escaped inside the render callback.
				echo iflynepal_render_about_cta_actions();
				?>
			</div>

		</div>

	</div>

</section>
