<?php
/**
 * CSR hero: a photograph under a scrim, the kicker, the headline and the
 * sub-title.
 *
 * The plainest hero on the site — no video, no ambient sound, no trust
 * bullets, no buttons, no second column. It carries the same `iflynepal-hero`
 * classes and is driven by the same assets/js/homepage/hero/hero.js, which
 * guards every one of those absent pieces and is also what docks the header.
 *
 * Everything editable here lives in Appearance > Customize > About > CSR.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_csr_hero_image = iflynepal_csr_hero_image_url();
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page iflynepal-hero--csr">

	<?php if ( $iflynepal_csr_hero_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_csr_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<p class="iflynepal-hero__kicker" id="iflynepal-csr-hero-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_hero_kicker();
				?>
			</p>

			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-csr-hero-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_hero_title();
				?>
			</h1>

			<p class="iflynepal-hero__lead" id="iflynepal-csr-hero-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_csr_hero_lead();
				?>
			</p>

		</div>
	</div>

</section>
