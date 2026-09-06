<?php
/**
 * About Nepal hero: a photograph under a scrim, the headline and the
 * sub-title.
 *
 * The same component as the front page's and the About page's heroes, minus
 * the video, the ambient sound, the trust bullets and the buttons — so it
 * carries the same `iflynepal-hero` classes and is driven by the same
 * assets/js/homepage/hero/hero.js, which guards every one of those absent
 * pieces. That script also swaps the header from transparent to solid on
 * scroll; without it this page would keep white nav links over white content
 * once the hero was scrolled past.
 *
 * Everything editable here lives in Appearance > Customize > About > Nepal.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_country_hero_image = iflynepal_country_hero_image_url();
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page">

	<?php if ( $iflynepal_country_hero_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_country_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-country-hero-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_country_hero_title();
				?>
			</h1>

			<p class="iflynepal-hero__lead" id="iflynepal-country-hero-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_country_hero_lead();
				?>
			</p>

		</div>
	</div>

</section>
