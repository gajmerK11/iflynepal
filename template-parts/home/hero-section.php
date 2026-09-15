<?php
/**
 * Front page hero: a background, the headline, two calls to action and the
 * trust bullets.
 *
 * The background is one of three things, in order of precedence: the slideshow
 * (two or more images cross-fading, or one held still), the single background
 * image with the video over it, or the section's own dark ground. Putting any
 * image in the slideshow control takes the other two off the page entirely, so
 * the video is never requested.
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

$iflynepal_slides     = iflynepal_hero_slides();
$iflynepal_image      = $iflynepal_slides ? '' : iflynepal_hero_background_image_url();
$iflynepal_image_size = iflynepal_hero_background_image_size();
$iflynepal_video      = $iflynepal_slides ? '' : iflynepal_hero_background_video_url();
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

	<?php if ( $iflynepal_slides ) : ?>
		<?php
		/*
		 * The slideshow. Only the first slide carries a src: it is the LCP
		 * element and paints immediately, while the rest wait behind a
		 * data-src that assets/js/homepage/hero/slides.js promotes once it has
		 * decided to run. A visitor on reduced motion or Data Saver — or with
		 * no JavaScript — keeps the first picture and downloads nothing else.
		 */
		?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<?php foreach ( $iflynepal_slides as $iflynepal_index => $iflynepal_slide ) : ?>
				<img
					class="iflynepal-hero__slide"
					<?php if ( 0 === $iflynepal_index ) : ?>
						src="<?php echo esc_url( $iflynepal_slide['url'] ); ?>"
						fetchpriority="high"
						loading="eager"
						decoding="sync"
					<?php else : ?>
						data-src="<?php echo esc_url( $iflynepal_slide['url'] ); ?>"
						loading="lazy"
						decoding="async"
					<?php endif; ?>
					<?php if ( $iflynepal_slide['width'] && $iflynepal_slide['height'] ) : ?>
						width="<?php echo esc_attr( $iflynepal_slide['width'] ); ?>"
						height="<?php echo esc_attr( $iflynepal_slide['height'] ); ?>"
					<?php endif; ?>
					alt=""
				>
			<?php endforeach; ?>
		</div>
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

			<?php if ( iflynepal_has_hero_finder() ) : ?>
				<?php
				/*
				 * The trip types and the results URL both come from the
				 * ifn-booking plugin (iflynepal_homepage_trip_finder filter) —
				 * this template only knows it got a list of {slug,label} pairs
				 * and a URL to send them to.
				 *
				 * A plain <form method="get"> does the whole job on its own:
				 * the browser assembles ?types[]=a&types[]=b from whichever
				 * boxes are checked, with or without JavaScript.
				 * assets/js/homepage/hero/trip-finder.js only keeps the
				 * summary's label in step with the selection — it is not
				 * needed for the redirect to work.
				 */
				?>
				<form class="iflynepal-hero__finder" method="get" action="<?php echo esc_url( iflynepal_hero_finder_url() ); ?>" id="iflynepal-hero-finder">
					<?php
					/*
					 * Both fields share name="iflynepal-hero-finder-picker" (the HTML
					 * <details> exclusive-group attribute, not a form field name — it
					 * never reaches the querystring): opening one closes the other
					 * natively, no JS required, the same way only one native <select>
					 * popup can ever be open at a time.
					 */
					?>
					<details class="iflynepal-hero__finder-field" id="iflynepal-hero-finder-types" name="iflynepal-hero-finder-picker">
						<summary class="iflynepal-hero__finder-trigger">
							<span class="iflynepal-hero__finder-row">
								<span>
									<span class="iflynepal-hero__finder-label"><?php esc_html_e( 'I want to', 'iflynepal' ); ?></span>
									<span class="iflynepal-hero__finder-value" data-placeholder="<?php esc_attr_e( 'Explore Nepal', 'iflynepal' ); ?>"><?php esc_html_e( 'Explore Nepal', 'iflynepal' ); ?></span>
								</span>
								<svg class="iflynepal-hero__finder-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</span>
						</summary>

						<div class="iflynepal-hero__finder-list">
							<?php foreach ( iflynepal_hero_finder_types() as $iflynepal_finder_type ) : ?>
								<label class="iflynepal-hero__finder-option">
									<input type="checkbox" name="types[]" value="<?php echo esc_attr( $iflynepal_finder_type['slug'] ); ?>">
									<?php echo esc_html( $iflynepal_finder_type['label'] ); ?>
								</label>
							<?php endforeach; ?>
						</div>
					</details>

					<?php $iflynepal_finder_durations = iflynepal_hero_finder_durations(); ?>
					<?php if ( $iflynepal_finder_durations ) : ?>
						<?php
						/*
						 * A single choice, so radio inputs rather than "I want to"'s
						 * checkboxes — one <details>/<summary>/list, same as that field,
						 * is what gives it the identical rounded panel, border and shadow
						 * a native <select>'s own popup can never be styled to match (the
						 * OS draws that one, not the page). name="days" on each radio
						 * still submits exactly one ?days=… value, same as the <select>
						 * this replaced.
						 */
						?>
						<details class="iflynepal-hero__finder-field iflynepal-hero__finder-field--select" id="iflynepal-hero-finder-days" name="iflynepal-hero-finder-picker">
							<summary class="iflynepal-hero__finder-trigger">
								<span class="iflynepal-hero__finder-row">
									<span>
										<span class="iflynepal-hero__finder-label"><?php esc_html_e( 'I have', 'iflynepal' ); ?></span>
										<span class="iflynepal-hero__finder-value" data-placeholder="<?php esc_attr_e( 'Not sure yet', 'iflynepal' ); ?>"><?php esc_html_e( 'Not sure yet', 'iflynepal' ); ?></span>
									</span>
									<svg class="iflynepal-hero__finder-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
								</span>
							</summary>

							<?php
							/*
							 * "Not sure yet" is the placeholder, matching "I want to"'s
							 * "Explore Nepal" — what the summary shows before a choice is
							 * made, not a choice of its own. No radio is checked by default,
							 * so with nothing picked the group submits no days= at all,
							 * same as the empty option on the <select> this replaced.
							 */
							?>
							<div class="iflynepal-hero__finder-list">
								<?php foreach ( $iflynepal_finder_durations as $iflynepal_finder_duration ) : ?>
									<label class="iflynepal-hero__finder-option">
										<input type="radio" name="days" value="<?php echo esc_attr( $iflynepal_finder_duration['key'] ); ?>">
										<?php echo esc_html( $iflynepal_finder_duration['label'] ); ?>
									</label>
								<?php endforeach; ?>
							</div>
						</details>
					<?php endif; ?>

					<button type="submit" class="iflynepal-button iflynepal-button--dark iflynepal-hero__finder-submit">
						<?php esc_html_e( 'Find My Trip', 'iflynepal' ); ?>
						<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
					</button>
				</form>
			<?php endif; ?>

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
