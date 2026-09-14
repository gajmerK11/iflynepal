<?php
/**
 * "Upcoming journeys": copy and month-filter controls on the left, a
 * photographic rail of packages on the right.
 *
 * The copy is edited at Appearance > Customize > Homepage > Upcoming
 * Journeys. The cards are not — they are every package the ifn-booking
 * plugin's package editor has ticked "Display on homepage" on, one month chip
 * per distinct "When available?" value among them. See
 * inc/customizer/callbacks/upcoming-journeys.php.
 *
 * Query-driven, so it is opt-in on its own results: no package is marked yet,
 * no plugin is active — nothing renders, the same rule the plugin's own
 * query-driven archive sections follow.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_departures = iflynepal_upcoming_departures();

if ( ! $iflynepal_departures ) {
	return;
}

$iflynepal_months = iflynepal_upcoming_departure_months();
?>
<section class="wp-block-group iflynepal-departures iflynepal-section--mist" id="departures">
	<div class="iflynepal-departures__inner">
		<div class="iflynepal-departures__split">

			<div class="iflynepal-departures__copy">
				<div class="iflynepal-departures__head" data-iflynepal-reveal>
					<p class="iflynepal-departures__eyebrow" id="iflynepal-upcoming-eyebrow">
						<?php
						// Escaped inside the render callback.
						echo iflynepal_render_upcoming_eyebrow();
						?>
					</p>
					<h2 class="wp-block-heading iflynepal-departures__title" id="iflynepal-upcoming-heading">
						<?php
						// Sanitized by iflynepal_kses_text() on save and again on read.
						echo iflynepal_render_upcoming_heading();
						?>
					</h2>
					<p class="iflynepal-departures__lead" id="iflynepal-upcoming-description">
						<?php
						// Sanitized by iflynepal_kses_text() on save and again on read.
						echo iflynepal_render_upcoming_description();
						?>
					</p>
				</div>

				<?php
				/*
				 * Rendered whenever there is at least one month, even a single
				 * one: a lone chip still tells a visitor what they are looking
				 * at, and it is what lets assets/js/homepage/departures/rail.js
				 * always have a chip to compute the status line from — the
				 * same "one is enough" call the catalogue's own category
				 * filter makes (see the plugin's iflynepal_archive_filter_terms()).
				 */
				?>
				<div class="iflynepal-departures__months" role="group" aria-label="<?php esc_attr_e( 'Filter departures by month', 'iflynepal' ); ?>" data-iflynepal-reveal>
					<?php foreach ( $iflynepal_months as $iflynepal_index => $iflynepal_month ) : ?>
						<button
							type="button"
							class="iflynepal-departures__chip<?php echo 0 === $iflynepal_index ? ' is-active' : ''; ?>"
							data-month="<?php echo esc_attr( $iflynepal_month['value'] ); ?>"
							aria-pressed="<?php echo 0 === $iflynepal_index ? 'true' : 'false'; ?>"
						><?php echo esc_html( $iflynepal_month['label'] ); ?></button>
					<?php endforeach; ?>
				</div>

				<p class="iflynepal-departures__status" id="iflynepal-upcoming-status" role="status">
					<?php echo esc_html( iflynepal_upcoming_status_text() ); ?>
				</p>

				<div class="iflynepal-departures__nav" data-iflynepal-reveal>
					<button type="button" class="iflynepal-departures__prev" aria-label="<?php esc_attr_e( 'Previous departures', 'iflynepal' ); ?>">
						<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15 5l-7 7 7 7"/></svg>
					</button>
					<button type="button" class="iflynepal-departures__next" aria-label="<?php esc_attr_e( 'Next departures', 'iflynepal' ); ?>">
						<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M9 5l7 7-7 7"/></svg>
					</button>
				</div>
			</div>

			<div class="iflynepal-departures__rail" id="iflynepal-departures-rail">
				<?php foreach ( $iflynepal_departures as $iflynepal_card ) : ?>
					<?php
					$iflynepal_fact = trim(
						implode(
							' · ',
							array_filter(
								array( $iflynepal_card['duration'], $iflynepal_card['price'] ),
								'strlen'
							)
						)
					);
					?>
					<a
						class="iflynepal-departures__card"
						href="<?php echo esc_url( $iflynepal_card['permalink'] ); ?>"
						data-iflynepal-reveal
						data-month="<?php echo esc_attr( $iflynepal_card['month'] ); ?>"
					>
						<?php if ( '' !== $iflynepal_card['image'] ) : ?>
							<img loading="lazy" src="<?php echo esc_url( $iflynepal_card['image'] ); ?>" alt="<?php echo esc_attr( $iflynepal_card['image_alt'] ); ?>" />
						<?php endif; ?>
						<span class="iflynepal-departures__scrim"></span>

						<div class="iflynepal-departures__top">
							<?php if ( '' !== $iflynepal_card['pill'] ) : ?>
								<span class="iflynepal-departures__pill"><?php echo esc_html( $iflynepal_card['pill'] ); ?></span>
							<?php endif; ?>
							<?php if ( '' !== $iflynepal_card['month_label'] ) : ?>
								<span class="iflynepal-departures__badge"><?php echo esc_html( $iflynepal_card['month_label'] ); ?></span>
							<?php endif; ?>
						</div>

						<div class="iflynepal-departures__body">
							<h3 class="iflynepal-departures__card-title"><?php echo esc_html( $iflynepal_card['title'] ); ?></h3>
							<?php if ( '' !== $iflynepal_fact ) : ?>
								<span class="iflynepal-departures__price"><?php echo esc_html( $iflynepal_fact ); ?></span>
							<?php endif; ?>
							<div class="iflynepal-departures__reveal"><div>
								<?php if ( '' !== $iflynepal_card['excerpt'] ) : ?>
									<p class="iflynepal-departures__excerpt"><?php echo esc_html( $iflynepal_card['excerpt'] ); ?></p>
								<?php endif; ?>
								<span class="iflynepal-departures__view"><?php esc_html_e( 'View', 'iflynepal' ); ?></span>
							</div></div>
						</div>
					</a>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>
