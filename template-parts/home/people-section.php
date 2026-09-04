<?php
/**
 * "People behind the journey": the heading and contact pill, then a horizontal
 * rail of the people who answer for a traveller's trip, stepped through by the
 * two buttons beside the heading.
 *
 * Everything editable here lives in Appearance > Customize > Homepage > People
 * Behind the Journey.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_people = iflynepal_people_cards();

if ( ! $iflynepal_people ) {
	return;
}
?>
<section class="wp-block-group iflynepal-people iflynepal-section--mist" id="people">
	<div class="iflynepal-people__inner">

		<div class="iflynepal-people__head">

			<div class="iflynepal-people__copy" data-iflynepal-reveal>
				<p class="iflynepal-people__kicker" id="iflynepal-people-kicker">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_people_kicker();
					?>
				</p>
				<h2 class="wp-block-heading iflynepal-people__title" id="iflynepal-people-title">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_people_title();
					?>
				</h2>
				<p class="iflynepal-people__lead" id="iflynepal-people-lead">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_people_lead();
					?>
				</p>
				<div class="iflynepal-people__cta-wrap" id="iflynepal-people-cta" data-iflynepal-reveal>
					<?php
					// Label, note and URL are escaped inside the render callback.
					echo iflynepal_render_people_cta();
					?>
				</div>
			</div>

			<div class="iflynepal-people__nav" data-iflynepal-reveal>
				<button type="button" class="iflynepal-people__prev" aria-label="<?php esc_attr_e( 'Previous people', 'iflynepal' ); ?>">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15 5l-7 7 7 7"/></svg>
				</button>
				<button type="button" class="iflynepal-people__next" aria-label="<?php esc_attr_e( 'Next people', 'iflynepal' ); ?>">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M9 5l7 7-7 7"/></svg>
				</button>
			</div>

		</div>

		<div class="iflynepal-people__rail">
			<?php foreach ( $iflynepal_people as $iflynepal_card ) : ?>
				<article class="iflynepal-people__card" data-iflynepal-reveal>
					<div class="iflynepal-people__photo">
						<?php
						// The image URL and its alt text are escaped inside the render callback.
						echo iflynepal_render_people_card_photo( $iflynepal_card );
						?>
						<span class="iflynepal-people__role" id="iflynepal-people-card-<?php echo esc_attr( $iflynepal_card ); ?>-title">
							<?php
							// Escaped inside the render callback.
							echo iflynepal_render_people_card_title( $iflynepal_card );
							?>
						</span>
					</div>
					<div class="iflynepal-people__body">
						<h3 class="wp-block-heading iflynepal-people__name">
							<?php
							// Escaped inside the render callback.
							echo iflynepal_render_people_card_name( $iflynepal_card );
							?>
						</h3>
						<p class="iflynepal-people__country" id="iflynepal-people-card-<?php echo esc_attr( $iflynepal_card ); ?>-country">
							<?php
							// Escaped inside the render callback.
							echo iflynepal_render_people_card_country( $iflynepal_card );
							?>
						</p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
