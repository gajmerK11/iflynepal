<?php
/**
 * About page Overview: a centred head, the company's story on the left and a
 * photographic planning card on the right.
 *
 * The grid, the head and the card are the Why-trust section's own components
 * (§8b-3) carrying different copy, so they keep the `iflynepal-trust__*`
 * classes rather than growing a second set of identical rules.
 *
 * Everything editable here lives in Appearance > Customize > About > Company.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_about_promo_image = iflynepal_about_promo_image_url();
?>
<section class="wp-block-group iflynepal-trust iflynepal-about-overview" id="overview" data-iflynepal-motion>

	<div class="iflynepal-trust__head" data-iflynepal-reveal>
		<p class="iflynepal-trust__kicker" id="iflynepal-about-overview-kicker">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_about_overview_kicker();
			?>
		</p>
		<h2 class="wp-block-heading iflynepal-trust__title" id="iflynepal-about-overview-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_about_overview_title();
			?>
		</h2>
	</div>

	<div class="iflynepal-trust__grid">

		<div class="iflynepal-about-overview__story" id="iflynepal-about-story" data-iflynepal-reveal>
			<?php
			// Each paragraph is kses-filtered inside the render callback.
			echo iflynepal_render_about_story();
			?>
		</div>

		<aside class="iflynepal-trust__promo" data-iflynepal-reveal>
			<?php if ( $iflynepal_about_promo_image ) : ?>
				<img
					class="iflynepal-trust__promo-image"
					loading="lazy"
					src="<?php echo esc_url( $iflynepal_about_promo_image ); ?>"
					alt="<?php echo esc_attr( iflynepal_about_promo_image_alt() ); ?>"
				>
			<?php endif; ?>

			<div>
				<p class="iflynepal-trust__promo-kicker" id="iflynepal-about-promo-kicker">
					<?php
					// Escaped inside the render callback.
					echo iflynepal_render_about_promo_kicker();
					?>
				</p>
				<h3 class="wp-block-heading iflynepal-trust__promo-title" id="iflynepal-about-promo-title">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_about_promo_title();
					?>
				</h3>
				<p class="iflynepal-trust__promo-desc" id="iflynepal-about-promo-description">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_about_promo_description();
					?>
				</p>
				<div class="iflynepal-trust__promo-action" id="iflynepal-about-promo-button">
					<?php
					// Label and URL are escaped inside the render callback.
					echo iflynepal_render_about_promo_button();
					?>
				</div>
			</div>
		</aside>

	</div>

</section>
