<?php
/**
 * Terms & Conditions: the document itself — a sticky index beside the clause cards.
 *
 * Nothing here is written in the template. The heading, the index title, each
 * clause's title, sub-title and body are all editable in the Customizer, so
 * this file is only the frame; the copy and its defaults come from
 * inc/legal-content.php and inc/legal-defaults.php. The index is generated from
 * the same clause register as the headings, so the two cannot drift apart.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_kicker = iflynepal_legal_head( 'terms', 'head_kicker' );
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="terms"
	aria-labelledby="iflynepal-terms-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-terms-title">
				<?php echo iflynepal_legal_head( 'terms', 'head_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_head( 'terms', 'head_lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-terms-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-terms-index-title">
					<?php echo esc_html( wp_strip_all_tags( iflynepal_legal_head( 'terms', 'index_title' ) ) ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-terms-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_legal_index( 'terms' );
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="booking-payment" aria-labelledby="booking-payment-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'booking-payment' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'booking-payment' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cancellation-refunds" aria-labelledby="cancellation-refunds-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'cancellation-refunds' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'cancellation-refunds' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="travel-insurance" aria-labelledby="travel-insurance-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'travel-insurance' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'travel-insurance' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="health-fitness" aria-labelledby="health-fitness-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'health-fitness' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'health-fitness' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="visa-entry" aria-labelledby="visa-entry-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'visa-entry' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'visa-entry' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="flight-delays" aria-labelledby="flight-delays-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'flight-delays' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'flight-delays' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="risk-liability" aria-labelledby="risk-liability-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'risk-liability' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'risk-liability' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="safety-emergency" aria-labelledby="safety-emergency-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'safety-emergency' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'safety-emergency' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="sustainable-travel" aria-labelledby="sustainable-travel-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'sustainable-travel' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'sustainable-travel' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="volunteering" aria-labelledby="volunteering-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'volunteering' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'volunteering' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="itinerary-changes" aria-labelledby="itinerary-changes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'itinerary-changes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'itinerary-changes' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="complaints-disputes" aria-labelledby="complaints-disputes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'complaints-disputes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'complaints-disputes' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="privacy-data" aria-labelledby="privacy-data-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'privacy-data' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'privacy-data' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="final-acceptance" aria-labelledby="final-acceptance-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'terms', 'final-acceptance' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'terms', 'final-acceptance' ); ?>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
