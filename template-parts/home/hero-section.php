<?php
/**
 * Front page hero: background video over a still, headline, two calls to
 * action, four trust bullets and the trip planner search bar.
 *
 * Video, still, poster and fallback source are all Customizer settings
 * (inc/customizer.php) — Appearance > Customize > Hero Background. The still
 * is the LCP element, so it renders eager and high priority while the video
 * loads behind it (assets/js/hero.js gates the actual download).
 *
 * Markup uses the `wp-block-cover`-family classes so main.css and
 * assets/js/hero.js can target them directly — plain CSS/JS hooks.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_video    = iflynepal_hero_video_url();
$iflynepal_fallback = iflynepal_hero_video_fallback_url();
$iflynepal_poster   = iflynepal_hero_poster_url();
$iflynepal_still    = iflynepal_hero_still_url();
?>
<section class="wp-block-cover iflynepal-hero">

	<video
		class="wp-block-cover__video-background intrinsic-ignore"
		id="iflynepal-hero-video"
		muted
		loop
		playsinline
		preload="none"
		aria-hidden="true"
		data-object-fit="cover"
		<?php echo $iflynepal_poster ? 'poster="' . esc_url( $iflynepal_poster ) . '"' : ''; ?>
	>
		<?php if ( $iflynepal_video ) : ?>
			<source src="<?php echo esc_url( $iflynepal_video ); ?>" type="video/mp4">
		<?php endif; ?>
		<?php if ( $iflynepal_fallback ) : ?>
			<source src="<?php echo esc_url( $iflynepal_fallback ); ?>" type="video/mp4">
		<?php endif; ?>
	</video>

	<?php if ( $iflynepal_still ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_still ); ?>"
				alt=""
				width="2200"
				height="1467"
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<h1 class="wp-block-heading iflynepal-hero__title">
				<?php esc_html_e( 'Nepal Tours, Treks &', 'iflynepal' ); ?> <em><?php esc_html_e( 'Retreats', 'iflynepal' ); ?></em><br>
				<?php esc_html_e( 'With Local Experts', 'iflynepal' ); ?>
			</h1>

			<div class="wp-block-buttons iflynepal-hero__actions">
				<div class="wp-block-button iflynepal-btn--primary">
					<a class="wp-block-button__link wp-element-button" href="#explore"><?php esc_html_e( 'Explore Nepal', 'iflynepal' ); ?></a>
				</div>
				<div class="wp-block-button iflynepal-btn--ghost">
					<a class="wp-block-button__link wp-element-button" href="https://iflynepal.com/trip_category/retreats-in-nepal"><?php esc_html_e( 'Find a Retreat', 'iflynepal' ); ?></a>
				</div>
			</div>

			<div class="wp-block-group iflynepal-hero__proof">
				<p><?php esc_html_e( 'Local Nepal team', 'iflynepal' ); ?></p>
				<p><?php esc_html_e( 'Experienced guides', 'iflynepal' ); ?></p>
				<p><?php esc_html_e( 'Private & small-group options', 'iflynepal' ); ?></p>
				<p><?php esc_html_e( 'Support from arrival to departure', 'iflynepal' ); ?></p>
			</div>

			<?php get_template_part( 'template-parts/home/trip-planner' ); ?>

		</div>
	</div>

</section>
