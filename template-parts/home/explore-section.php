<?php
/**
 * "Explore Nepal your way" gateway: a handwritten kicker, a centred heading
 * with an inked underline, and two photographic cards leading into tours and
 * retreats.
 *
 * Markup keeps the `wp-block-cover`/`wp-block-columns`-family classes from the
 * design's original block-based build so main.css and assets/js/reveal.js
 * need no changes — this theme no longer uses the block editor, but the
 * classes are just CSS/JS hooks now, not evidence of one.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Stand-ins until the client's photography lands.
$iflynepal_card_one = 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1400';
$iflynepal_card_two = 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=1400';
?>
<section class="wp-block-group iflynepal-explore" id="explore">

	<div class="iflynepal-explore__intro">

		<div class="iflynepal-explore__kicker">
			<figure class="iflynepal-explore__arrow">
				<img src="<?php echo esc_url( IFLYNEPAL_URI . '/assets/images/explore-arrow.svg' ); ?>" alt="" width="44" height="118">
			</figure>
			<p class="iflynepal-explore__kicker-text"><?php esc_html_e( 'Explore Nepal your way', 'iflynepal' ); ?></p>
		</div>

		<h2 class="wp-block-heading iflynepal-explore__title">
			<?php esc_html_e( 'Adventure outward. Journey', 'iflynepal' ); ?> <span class="iflynepal-explore__underline"><?php esc_html_e( 'inward', 'iflynepal' ); ?></span>.
		</h2>

	</div>

	<div class="wp-block-columns iflynepal-explore__cards">

		<div class="wp-block-column">
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left iflynepal-explore__card">
				<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $iflynepal_card_one ); ?>" data-object-fit="cover">
				<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
				<div class="wp-block-cover__inner-container">
					<div class="wp-block-group iflynepal-explore__card-content">
						<p class="iflynepal-explore__eyebrow"><?php esc_html_e( 'Travel & adventure', 'iflynepal' ); ?></p>
						<h3 class="wp-block-heading iflynepal-explore__card-title"><?php esc_html_e( 'Explore Nepal', 'iflynepal' ); ?></h3>
						<div class="iflynepal-explore__reveal">
							<div class="iflynepal-explore__reveal-inner">
								<p class="iflynepal-explore__card-desc">
									<?php esc_html_e( "Trek the Himalayas, discover heritage cities, meet local communities and explore Nepal's wildlife, landscapes and culture.", 'iflynepal' ); ?>
								</p>
								<div class="wp-block-buttons iflynepal-explore__links">
									<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Nepal Tours', 'iflynepal' ); ?></a></div>
									<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Trekking in Nepal', 'iflynepal' ); ?></a></div>
									<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Safari Tours', 'iflynepal' ); ?></a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="wp-block-column">
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left iflynepal-explore__card">
				<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $iflynepal_card_two ); ?>" data-object-fit="cover">
				<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
				<div class="wp-block-cover__inner-container">
					<div class="wp-block-group iflynepal-explore__card-content">
						<p class="iflynepal-explore__eyebrow"><?php esc_html_e( 'Wellness & stillness', 'iflynepal' ); ?></p>
						<h3 class="wp-block-heading iflynepal-explore__card-title"><em><?php esc_html_e( 'Retreats', 'iflynepal' ); ?></em> <?php esc_html_e( 'in Nepal', 'iflynepal' ); ?></h3>
						<div class="iflynepal-explore__reveal">
							<div class="iflynepal-explore__reveal-inner">
								<p class="iflynepal-explore__card-desc">
									<?php esc_html_e( "Make space for meditation, yoga, Ayurveda, monastery life and restorative experiences shaped by Nepal's spiritual traditions and natural landscapes.", 'iflynepal' ); ?>
								</p>
								<div class="wp-block-buttons iflynepal-explore__links">
									<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Retreats in Nepal', 'iflynepal' ); ?></a></div>
									<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Meditation & Wellness', 'iflynepal' ); ?></a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</section>
