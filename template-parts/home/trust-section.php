<?php
/**
 * "Why trust iFly Nepal": a centred heading, four proof points in a two-by-two
 * grid, a photographic planning card beside them, and two bands of partner and
 * association logos scrolling past beneath.
 *
 * Everything editable here lives in Appearance > Customize > Homepage > Why
 * Trust iFly Nepal.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_promo_image = iflynepal_trust_promo_image_url();
?>
<section class="wp-block-group iflynepal-trust" id="trust">

	<div class="iflynepal-trust__head" data-iflynepal-reveal>
		<p class="iflynepal-trust__kicker" id="iflynepal-trust-kicker">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_trust_kicker();
			?>
		</p>
		<h2 class="wp-block-heading iflynepal-trust__title" id="iflynepal-trust-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_trust_title();
			?>
		</h2>
	</div>

	<div class="iflynepal-trust__grid" data-iflynepal-reveal>

		<div class="iflynepal-trust__features">
			<?php for ( $iflynepal_feature = 1; $iflynepal_feature <= IFLYNEPAL_TRUST_FEATURES; $iflynepal_feature++ ) : ?>
				<div class="iflynepal-trust__feature">
					<span class="iflynepal-trust__icon" id="iflynepal-trust-feature-<?php echo esc_attr( $iflynepal_feature ); ?>-icon">
						<?php
						// The path data comes from the theme's own icon registry.
						echo iflynepal_render_trust_feature_icon( $iflynepal_feature );
						?>
					</span>
					<div class="iflynepal-trust__feature-copy">
						<strong class="iflynepal-trust__feature-title" id="iflynepal-trust-feature-<?php echo esc_attr( $iflynepal_feature ); ?>-title">
							<?php
							// Escaped inside the render callback.
							echo iflynepal_render_trust_feature_title( $iflynepal_feature );
							?>
						</strong>
						<span class="iflynepal-trust__feature-desc" id="iflynepal-trust-feature-<?php echo esc_attr( $iflynepal_feature ); ?>-description">
							<?php
							// Sanitized by iflynepal_kses_text() on save and again on read.
							echo iflynepal_render_trust_feature_description( $iflynepal_feature );
							?>
						</span>
					</div>
				</div>
			<?php endfor; ?>
		</div>

		<aside class="iflynepal-trust__promo">
			<?php if ( $iflynepal_promo_image ) : ?>
				<img class="iflynepal-trust__promo-image" src="<?php echo esc_url( $iflynepal_promo_image ); ?>" alt="" loading="lazy" decoding="async">
			<?php endif; ?>
			<div class="iflynepal-trust__promo-copy">
				<p class="iflynepal-trust__promo-kicker" id="iflynepal-trust-promo-kicker">
					<?php
					// Escaped inside the render callback.
					echo iflynepal_render_trust_promo_kicker();
					?>
				</p>
				<h3 class="wp-block-heading iflynepal-trust__promo-title" id="iflynepal-trust-promo-title">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_trust_promo_title();
					?>
				</h3>
				<p class="iflynepal-trust__promo-desc" id="iflynepal-trust-promo-description">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_trust_promo_description();
					?>
				</p>
				<div class="iflynepal-trust__promo-action" id="iflynepal-trust-promo-button">
					<?php
					// Label and URL are escaped inside the render callback.
					echo iflynepal_render_trust_promo_button();
					?>
				</div>
			</div>
		</aside>

	</div>

	<?php if ( iflynepal_trust_has_logos() ) : ?>
		<div class="iflynepal-trust__logos" data-iflynepal-reveal>
			<?php
			$iflynepal_bands = array(
				'partner'     => __( 'Partners', 'iflynepal' ),
				'association' => __( 'Association', 'iflynepal' ),
			);

			foreach ( $iflynepal_bands as $iflynepal_group => $iflynepal_band_label ) :
				// A band with no logos uploaded is left out rather than drawn empty.
				if ( ! iflynepal_trust_logos( $iflynepal_group ) ) {
					continue;
				}
				?>
				<div class="iflynepal-trust__band">
					<span class="iflynepal-trust__band-label"><?php echo esc_html( $iflynepal_band_label ); ?></span>
					<div class="iflynepal-trust__marquee">
						<div class="iflynepal-trust__track" aria-label="<?php echo esc_attr( $iflynepal_band_label ); ?>">
							<?php
							// Images are built by wp_get_attachment_image() inside the render callback.
							echo iflynepal_render_trust_logos( $iflynepal_group );
							?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</section>
