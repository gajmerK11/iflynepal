<?php
/**
 * Packages archive hero: a photograph under a scrim, the kicker, the headline
 * and the sub-title.
 *
 * The same component as every other page hero on the site — same
 * `iflynepal-hero` classes, driven by the same assets/js/homepage/hero/hero.js,
 * which is also what docks the site header from transparent to solid on the
 * first scroll. A hero built with different class names here would leave white
 * nav links over white content once it was scrolled past.
 *
 * No buttons: this page is a list of ways in, and a call to action above a
 * catalogue is a button competing with the thing it sits on top of.
 *
 * Printed by the booking plugin's /packages/ template through
 * iflynepal_the_packages_hero(). Everything editable here lives in
 * Appearance > Customize > Packages Archive.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_packages_hero_image = iflynepal_packages_hero_image_url();
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page iflynepal-hero--packages">

	<?php if ( $iflynepal_packages_hero_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_packages_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<p class="iflynepal-hero__kicker" id="iflynepal-packages-hero-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_packages_hero_kicker();
				?>
			</p>

			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-packages-hero-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_packages_hero_title();
				?>
			</h1>

			<p class="iflynepal-hero__lead" id="iflynepal-packages-hero-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_packages_hero_lead();
				?>
			</p>

		</div>
	</div>

</section>
