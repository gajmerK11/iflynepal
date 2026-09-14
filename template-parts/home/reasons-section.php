<?php
/**
 * "A few good reasons": the heading and a handwritten annotation on the
 * right, a package-type filter row, and a curated card grid.
 *
 * The copy is edited at Appearance > Customize > Homepage > A Few Good
 * Reasons. The cards and the filter buttons are not — they are every package
 * the ifn-booking plugin's package editor has ticked "Show in 'A few good
 * reasons'" on, one filter button per top-level package type among them. See
 * inc/customizer/callbacks/reasons.php.
 *
 * Query-driven, so it is opt-in on its own results: no package ticked, no
 * plugin active — nothing renders, the same rule the plugin's own
 * query-driven archive sections follow.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_reasons_cards = iflynepal_reasons_cards();

if ( ! $iflynepal_reasons_cards ) {
	return;
}

$iflynepal_reasons_filters = iflynepal_reasons_filters();
?>
<section class="wp-block-group iflynepal-reasons" id="reasons">
	<div class="iflynepal-reasons__inner">

		<div class="iflynepal-reasons__head">
			<div class="iflynepal-reasons__copy" data-iflynepal-reveal>
				<h2 class="wp-block-heading iflynepal-reasons__title" id="iflynepal-reasons-heading">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_reasons_heading();
					?>
				</h2>
				<p class="iflynepal-reasons__lead" id="iflynepal-reasons-description">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_reasons_description();
					?>
				</p>
			</div>

			<span
				class="iflynepal-reasons__annot"
				id="iflynepal-reasons-annot"
				data-iflynepal-reveal
				data-static="<?php echo esc_attr( iflynepal_reasons_annotation_static() ); ?>"
				data-words="<?php echo esc_attr( wp_json_encode( iflynepal_reasons_annotation_words() ) ); ?>"
			>
				<svg viewBox="0 0 46 126" fill="none" aria-hidden="true">
					<g transform="translate(46 0) rotate(90)">
						<path class="iflynepal-reasons__a-dash" d="M2 34c14 6 29 9 45 8 20-1 38-8 58-19" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 7" stroke-linecap="round"/>
						<path class="iflynepal-reasons__a-head" d="M91 15.5 107.5 22.5 99.5 37" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
				</svg>
				<b><span class="iflynepal-reasons__annot-static"></span><span class="iflynepal-reasons__annot-word"></span></b>
			</span>
		</div>

		<?php if ( count( $iflynepal_reasons_filters ) > 1 ) : ?>
			<div class="iflynepal-reasons__filters" role="group" aria-label="<?php esc_attr_e( 'Filter featured experiences', 'iflynepal' ); ?>" data-iflynepal-reveal>
				<?php foreach ( $iflynepal_reasons_filters as $iflynepal_index => $iflynepal_filter ) : ?>
					<button
						type="button"
						class="iflynepal-reasons__filter-btn<?php echo 0 === $iflynepal_index ? ' is-active' : ''; ?>"
						data-filter="<?php echo esc_attr( $iflynepal_filter['slug'] ); ?>"
						aria-pressed="<?php echo 0 === $iflynepal_index ? 'true' : 'false'; ?>"
					><?php echo esc_html( $iflynepal_filter['label'] ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="iflynepal-reasons__grid">
			<?php foreach ( $iflynepal_reasons_cards as $iflynepal_card ) : ?>
				<?php
				$iflynepal_facts = array_filter(
					array( $iflynepal_card['duration'], $iflynepal_card['suitability'] ),
					'strlen'
				);
				?>
				<article class="iflynepal-reasons__card" data-categories="<?php echo esc_attr( implode( ' ', $iflynepal_card['categories'] ) ); ?>" data-iflynepal-reveal>
					<div class="iflynepal-reasons__media">
						<?php if ( '' !== $iflynepal_card['image'] ) : ?>
							<img loading="lazy" src="<?php echo esc_url( $iflynepal_card['image'] ); ?>" alt="<?php echo esc_attr( $iflynepal_card['image_alt'] ); ?>" />
						<?php endif; ?>

						<?php if ( '' !== $iflynepal_card['pill'] ) : ?>
							<span class="iflynepal-reasons__pill"><?php echo esc_html( $iflynepal_card['pill'] ); ?></span>
						<?php endif; ?>

						<?php if ( '' !== $iflynepal_card['excerpt'] ) : ?>
							<div class="iflynepal-reasons__peek"><p><?php echo esc_html( $iflynepal_card['excerpt'] ); ?></p></div>
						<?php endif; ?>
					</div>

					<div class="iflynepal-reasons__body">
						<?php if ( ! empty( $iflynepal_facts ) ) : ?>
							<div class="iflynepal-reasons__meta">
								<?php foreach ( $iflynepal_facts as $iflynepal_fact ) : ?>
									<span><?php echo esc_html( $iflynepal_fact ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<h3 class="iflynepal-reasons__card-title"><?php echo esc_html( $iflynepal_card['title'] ); ?></h3>

						<div class="iflynepal-reasons__foot">
							<?php if ( '' !== $iflynepal_card['price'] ) : ?>
								<span class="iflynepal-reasons__price"><?php echo esc_html( $iflynepal_card['price'] ); ?></span>
							<?php endif; ?>

							<?php
							$iflynepal_link_label = sprintf(
								/* translators: %s: package title. */
								__( 'Explore %s', 'iflynepal' ),
								$iflynepal_card['title']
							);
							?>
							<a class="iflynepal-reasons__link" href="<?php echo esc_url( $iflynepal_card['permalink'] ); ?>" aria-label="<?php echo esc_attr( $iflynepal_link_label ); ?>">
								<?php esc_html_e( 'Explore', 'iflynepal' ); ?>
								<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
							</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
