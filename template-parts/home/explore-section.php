<?php
/**
 * "Explore Nepal your way" gateway: a handwritten kicker, a centred heading
 * with an inked underline, and two photographic cards leading into tours and
 * retreats.
 *
 * Everything editable here lives in Appearance > Customize > Homepage — the
 * heading in "Explore", each card in its own "Explore ▸ ..." section.
 *
 * Markup uses the `wp-block-cover`/`wp-block-columns`-family classes so main.css
 * and assets/js/homepage/hero/explore/reveal.js can target them directly — plain
 * CSS/JS hooks.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-group iflynepal-explore" id="explore">

	<div class="iflynepal-explore__intro">

		<div class="iflynepal-explore__kicker">
			<figure class="iflynepal-explore__arrow">
				<img src="<?php echo esc_url( IFLYNEPAL_URI . '/assets/images/explore-arrow.svg' ); ?>" alt="" width="44" height="118">
			</figure>
			<p class="iflynepal-explore__kicker-text" id="iflynepal-explore-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_explore_kicker();
				?>
			</p>
		</div>

		<h2 class="wp-block-heading iflynepal-explore__title" id="iflynepal-explore-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_explore_title();
			?>
		</h2>

	</div>

	<div class="wp-block-columns iflynepal-explore__cards">

		<?php for ( $iflynepal_card = 1; $iflynepal_card <= IFLYNEPAL_EXPLORE_CARDS; $iflynepal_card++ ) : ?>
			<?php $iflynepal_image = iflynepal_explore_card_image_url( $iflynepal_card ); ?>
			<div class="wp-block-column">
				<div class="wp-block-cover has-custom-content-position is-position-bottom-left iflynepal-explore__card">
					<?php if ( $iflynepal_image ) : ?>
						<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $iflynepal_image ); ?>" data-object-fit="cover">
					<?php endif; ?>
					<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
					<div class="wp-block-cover__inner-container">
						<div class="wp-block-group iflynepal-explore__card-content">

							<p class="iflynepal-explore__eyebrow" id="iflynepal-explore-card-<?php echo esc_attr( $iflynepal_card ); ?>-eyebrow">
								<?php
								// Escaped inside the render callback.
								echo iflynepal_render_explore_card_eyebrow( $iflynepal_card );
								?>
							</p>

							<h3 class="wp-block-heading iflynepal-explore__card-title" id="iflynepal-explore-card-<?php echo esc_attr( $iflynepal_card ); ?>-title">
								<?php
								// Sanitized by iflynepal_kses_text() on save and again on read.
								echo iflynepal_render_explore_card_title( $iflynepal_card );
								?>
							</h3>

							<div class="iflynepal-explore__reveal">
								<div class="iflynepal-explore__reveal-inner">
									<p class="iflynepal-explore__card-desc" id="iflynepal-explore-card-<?php echo esc_attr( $iflynepal_card ); ?>-description">
										<?php
										// Sanitized by iflynepal_kses_text() on save and again on read.
										echo iflynepal_render_explore_card_description( $iflynepal_card );
										?>
									</p>
									<div class="wp-block-buttons iflynepal-explore__links" id="iflynepal-explore-card-<?php echo esc_attr( $iflynepal_card ); ?>-links">
										<?php
										// Labels and URLs are escaped inside the render callback.
										echo iflynepal_render_explore_card_links( $iflynepal_card );
										?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		<?php endfor; ?>

	</div>

</section>
