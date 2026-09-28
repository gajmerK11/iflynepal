<?php
/**
 * "Trusted Partner": a photograph or a short video beside a portion of the
 * company's own story and a link through to the full About page.
 *
 * Sits between the hero and Explore Nepal. Everything editable here lives in
 * Appearance > Customize > Homepage > Trusted Partner.
 *
 * The video, where one is set, is a plain native <video controls> rather
 * than a custom play button and player: it works with no JavaScript at all,
 * and the poster attribute already shows the uploaded photograph until a
 * visitor presses play.
 *
 * Neither carries a shipped stand-in: with nothing uploaded, the media side
 * is simply empty until an editor sets one in the Customizer.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_partner_video = iflynepal_partner_video_url();
$iflynepal_partner_image = iflynepal_partner_image_url();
$iflynepal_partner_button = iflynepal_render_partner_button();
?>
<section class="wp-block-group iflynepal-partner" id="partner">

	<div class="iflynepal-partner__head" data-iflynepal-reveal>
		<h2 class="wp-block-heading iflynepal-partner__title" id="iflynepal-partner-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_partner_title();
			?>
		</h2>
	</div>

	<div class="iflynepal-partner-card" data-iflynepal-reveal>

		<div class="iflynepal-partner__media">
			<?php if ( '' !== $iflynepal_partner_video ) : ?>
				<video
					class="iflynepal-partner__video"
					controls
					playsinline
					preload="metadata"
					<?php echo '' !== $iflynepal_partner_image ? 'poster="' . esc_url( $iflynepal_partner_image ) . '"' : ''; ?>
				>
					<source src="<?php echo esc_url( $iflynepal_partner_video ); ?>" type="<?php echo esc_attr( iflynepal_partner_video_mime() ); ?>">
				</video>
			<?php elseif ( '' !== $iflynepal_partner_image ) : ?>
				<img
					class="iflynepal-partner__image"
					loading="lazy"
					src="<?php echo esc_url( $iflynepal_partner_image ); ?>"
					alt="<?php echo esc_attr( iflynepal_partner_image_alt() ); ?>"
				>
			<?php endif; ?>
		</div>

		<div class="iflynepal-partner__copy">
			<div class="iflynepal-partner__desc" id="iflynepal-partner-description">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_partner_description();
				?>
			</div>
			<?php if ( '' !== $iflynepal_partner_button ) : ?>
				<div class="iflynepal-partner__action" id="iflynepal-partner-button">
					<?php
					// Label and URL are escaped inside the render callback.
					echo $iflynepal_partner_button;
					?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>
