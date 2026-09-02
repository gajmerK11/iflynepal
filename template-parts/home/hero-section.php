<?php
/**
 * Front page hero: background video over an image, headline, two calls to
 * action and the trust bullets.
 *
 * Everything editable here lives in Appearance > Customize > Homepage > Hero.
 * The background image is the LCP element, so it renders eager and at high
 * priority while the video loads behind it (assets/js/homepage/hero/hero.js gates the actual
 * download, and doubles the image as the video's poster frame).
 *
 * Markup uses the `wp-block-cover`-family classes so main.css and
 * assets/js/homepage/hero/hero.js can target them directly — plain CSS/JS hooks.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_image      = iflynepal_hero_background_image_url();
$iflynepal_image_size = iflynepal_hero_background_image_size();
$iflynepal_video      = iflynepal_hero_background_video_url();
$iflynepal_video_mime = iflynepal_hero_background_video_mime();
$iflynepal_audio      = iflynepal_hero_audio_url();
$iflynepal_audio_mime = iflynepal_hero_audio_mime();
?>
<section class="wp-block-cover iflynepal-hero">

	<?php if ( $iflynepal_video ) : ?>
		<video
			class="wp-block-cover__video-background intrinsic-ignore"
			id="iflynepal-hero-video"
			muted
			loop
			playsinline
			preload="none"
			aria-hidden="true"
			data-object-fit="cover"
			<?php echo $iflynepal_image ? 'poster="' . esc_url( $iflynepal_image ) . '"' : ''; ?>
		>
			<source src="<?php echo esc_url( $iflynepal_video ); ?>" type="<?php echo esc_attr( $iflynepal_video_mime ); ?>">
		</video>
	<?php endif; ?>

	<?php if ( $iflynepal_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_image ); ?>"
				alt=""
				<?php if ( $iflynepal_image_size['width'] && $iflynepal_image_size['height'] ) : ?>
					width="<?php echo esc_attr( $iflynepal_image_size['width'] ); ?>"
					height="<?php echo esc_attr( $iflynepal_image_size['height'] ); ?>"
				<?php endif; ?>
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-hero-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_hero_title();
				?>
			</h1>

			<div class="wp-block-buttons iflynepal-hero__actions" id="iflynepal-hero-actions">
				<?php
				// Labels and URLs are escaped inside the render callback.
				echo iflynepal_render_hero_actions();
				?>
			</div>

			<div class="wp-block-group iflynepal-hero__proof" id="iflynepal-hero-proof">
				<?php
				// Bullet text is escaped inside the render callback.
				echo iflynepal_render_hero_trust_points();
				?>
			</div>

		</div>
	</div>

	<?php if ( $iflynepal_audio ) : ?>
		<?php
		/*
		 * preload="none" and no autoplay: nothing is fetched until the visitor
		 * asks for sound. assets/js/homepage/hero/audio.js owns playback.
		 */
		?>
		<audio id="iflynepal-hero-audio" loop preload="none">
			<source src="<?php echo esc_url( $iflynepal_audio ); ?>" type="<?php echo esc_attr( $iflynepal_audio_mime ); ?>">
		</audio>

		<button
			id="iflynepal-hero-audio-toggle"
			class="iflynepal-hero__audio"
			type="button"
			hidden
			aria-pressed="false"
			aria-label="<?php esc_attr_e( 'Turn on ambient sound', 'iflynepal' ); ?>"
			data-label-on="<?php esc_attr_e( 'Turn off ambient sound', 'iflynepal' ); ?>"
			data-label-off="<?php esc_attr_e( 'Turn on ambient sound', 'iflynepal' ); ?>"
		>
			<svg class="iflynepal-ico iflynepal-ico-sound-off" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M11 5 6 9H3v6h3l5 4V5Z"/><path d="m17 9 4 6M21 9l-4 6"/></svg>
			<svg class="iflynepal-ico iflynepal-ico-sound-on" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M11 5 6 9H3v6h3l5 4V5Z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M18.5 5.5a9 9 0 0 1 0 13"/></svg>
		</button>
	<?php endif; ?>

</section>
