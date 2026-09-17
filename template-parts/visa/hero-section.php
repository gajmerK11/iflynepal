<?php
/**
 * Visa Services hero: a photograph under a scrim, the kicker, the headline,
 * the sub-title and two calls to action.
 *
 * The same component as every other page hero on the site, so it carries the
 * same `iflynepal-hero` classes and is driven by the same
 * assets/js/homepage/hero/hero.js — which also swaps the header from
 * transparent to solid on scroll. Without that this page would keep white nav
 * links over white content once the hero was scrolled past.
 *
 * Everything editable here lives in Appearance > Customize > Visa Services.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_visa_hero_image = iflynepal_visa_hero_image_url();
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page iflynepal-hero--visa">

	<?php if ( $iflynepal_visa_hero_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_visa_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<p class="iflynepal-hero__kicker" id="iflynepal-visa-hero-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_hero_kicker();
				?>
			</p>

			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-visa-hero-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_hero_title();
				?>
			</h1>

			<p class="iflynepal-hero__lead" id="iflynepal-visa-hero-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_visa_hero_lead();
				?>
			</p>

			<div class="wp-block-buttons iflynepal-hero__actions" id="iflynepal-visa-hero-actions">
				<?php
				// Labels and URLs are escaped inside the render callback.
				echo iflynepal_render_visa_hero_actions();
				?>
			</div>

		</div>
	</div>

</section>
