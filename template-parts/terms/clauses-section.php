<?php
/**
 * Terms & Conditions: the document itself — a sticky index beside fourteen
 * clause cards.
 *
 * The copy is written here rather than pulled from the Customizer. This is a
 * legal document: it is agreed and republished as a whole, not tuned clause by
 * clause by whoever is logged in, and a half-edited liability clause is worse
 * than none. Changing the wording is a code change, reviewed like one.
 *
 * The clause register — anchors, titles, sub-titles and therefore the numbering
 * and the index — lives in inc/terms.php, so the index and the headings cannot
 * drift apart. Only the bodies are written below, each under the anchor its
 * register entry declares.
 *
 * Each sentence is one translatable string with its own `<strong>` inline,
 * rather than a printf with the emphasised phrase passed in. A translator needs
 * the whole sentence to move the emphasis to where their language puts it, and
 * it keeps the markup readable beside the copy it marks up.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="terms"
	aria-labelledby="iflynepal-terms-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-terms-title">
				<?php echo wp_kses_post( __( 'Terms &amp; <span class="underline">Conditions</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'Please read these before confirming your booking. They cover payment, cancellation, insurance, safety and how we resolve any issue.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-terms-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-terms-index-title">
					<?php esc_html_e( 'On this page', 'iflynepal' ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-terms-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_terms_index();
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="booking-payment" aria-labelledby="booking-payment-title" data-iflynepal-reveal>
					<?php
					// Number, title and sub-title come from the register; all escaped there.
					echo iflynepal_render_terms_clause_head( 'booking-payment' );
					?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'A <strong>deposit (typically 20&ndash;30%)</strong> is required to confirm your booking. The remaining balance is payable prior to the start of your trip or on arrival, depending on the itinerary.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Payment methods include bank transfer, major credit cards, or online gateways. Any associated <strong>transaction charges are borne by the client</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'A booking is only confirmed once we issue a <strong>confirmation email</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cancellation-refunds" aria-labelledby="cancellation-refunds-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'cancellation-refunds' ); ?>
					<div class="iflynepal-legal-clause__body">

						<span class="iflynepal-legal-sublabel"><?php esc_html_e( 'By the client', 'iflynepal' ); ?></span>

						<div class="iflynepal-legal-refunds">
							<div class="iflynepal-legal-refunds__row">
								<span><?php esc_html_e( '30+ days prior to departure', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( 'Full refund minus transaction &amp; admin fees', 'iflynepal' ); ?></b>
							</div>
							<div class="iflynepal-legal-refunds__row">
								<span><?php echo esc_html__( '15&ndash;29 days prior to departure', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( '50% refund', 'iflynepal' ); ?></b>
							</div>
							<div class="iflynepal-legal-refunds__row iflynepal-legal-refunds__row--warn">
								<span><?php esc_html_e( 'Less than 15 days prior', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( 'No refund', 'iflynepal' ); ?></b>
							</div>
						</div>

						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( 'Within 15 days, a booking <strong>may be transferred</strong> to a future date or another person, subject to availability.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'No refund will be made for <strong>unused services</strong> once the trip has commenced.', 'iflynepal' ) ); ?></li>
						</ul>

						<span class="iflynepal-legal-sublabel"><?php esc_html_e( 'By iFly Nepal', 'iflynepal' ); ?></span>

						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'If we cancel due to unforeseen events (e.g. natural disasters, political unrest), a <strong>full refund or credit</strong> will be offered.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'If cancellation is due to <strong>force majeure</strong>, we are not liable for compensation beyond the refund of received payments.', 'iflynepal' ) ); ?></li>
						</ul>

					</div>
				</article>

				<article class="iflynepal-legal-clause" id="travel-insurance" aria-labelledby="travel-insurance-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'travel-insurance' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Travel insurance is <strong>mandatory</strong> for all trekking, adventure and high-altitude trips.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Your policy must include <strong>emergency evacuation, medical coverage, and trip cancellation / interruption</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'iFly Nepal is not responsible for expenses resulting from your failure to secure proper insurance.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="health-fitness" aria-labelledby="health-fitness-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'health-fitness' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Certain trips (e.g. trekking, volunteering, wellness retreats) require a <strong>minimum level of physical fitness</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'It is your responsibility to consult with a physician and ensure you are in good health before participating.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'You must inform us of any <strong>medical conditions, allergies, or dietary restrictions</strong> in advance.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="visa-entry" aria-labelledby="visa-entry-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'visa-entry' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Most travellers can obtain a Nepal visa on arrival at Tribhuvan International Airport or land borders. Ensure your passport is <strong>valid for at least 6 months</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'iFly Nepal is not responsible for visa denials, immigration issues, or delays caused by border regulations.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="flight-delays" aria-labelledby="flight-delays-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'flight-delays' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( '<strong>Lukla, Jomsom, Pokhara</strong> and other mountain flights are prone to weather-related delays or cancellations.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'We recommend scheduling <strong>buffer days</strong> and securing travel insurance that covers such disruptions.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Alternative arrangements (helicopter charter, rescheduling, overland options) may be offered <strong>at additional cost</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="risk-liability" aria-labelledby="risk-liability-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'risk-liability' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Many activities (e.g. trekking, rafting, safaris) involve inherent risks such as <strong>altitude sickness, accidents, or unforeseen events</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'By booking, you agree to participate at your own risk and release iFly Nepal and its representatives from any liability related to injury, loss, or damage.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Our liability is <strong>limited to the cost of the tour purchased</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="safety-emergency" aria-labelledby="safety-emergency-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'safety-emergency' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'iFly Nepal&#8217;s guides are trained in <strong>first aid and altitude safety</strong> and carry basic medical kits and emergency protocols.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'In serious situations, we may organise <strong>helicopter evacuation at the traveller&#8217;s expense</strong> unless covered by insurance.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Travellers must follow guide instructions and safety guidelines during the trip.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="sustainable-travel" aria-labelledby="sustainable-travel-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'sustainable-travel' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php esc_html_e( 'We encourage all clients to:', 'iflynepal' ); ?></p>
						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( 'Respect <strong>local cultures, customs and religious sites</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Minimise plastic and environmental impact by using reusable gear.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Support <strong>local businesses and artisans</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Avoid activities or purchases that exploit wildlife or people.', 'iflynepal' ); ?></li>
						</ul>
						<p class="iflynepal-legal-note">
							<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 21c-4.5-2.5-7-6-7-10a7 7 0 0 1 14 0c0 4-2.5 7.5-7 10z"/><path d="M9 13l3-2 3 2"/></svg>
							<span>
								<?php
								// The link is built and escaped inside the render callback.
								echo iflynepal_render_terms_policy_link( 'sustainable-policy' );
								?>
							</span>
						</p>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="volunteering" aria-labelledby="volunteering-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'volunteering' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Volunteering placements are run in collaboration with <strong>vetted local organisations</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Travellers are expected to behave ethically, respectfully, and within the bounds of their assigned role.', 'iflynepal' ); ?></li>
							<li><?php esc_html_e( 'iFly Nepal is not liable for personal disputes, loss, or misunderstandings during placements.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="itinerary-changes" aria-labelledby="itinerary-changes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'itinerary-changes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php esc_html_e( 'We reserve the right to make necessary changes to the itinerary, accommodation, or services due to unforeseen circumstances (weather, strikes, availability).', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Every effort will be made to provide <strong>comparable alternatives</strong> with minimal disruption.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="complaints-disputes" aria-labelledby="complaints-disputes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'complaints-disputes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'If you encounter any issues during your trip, notify your guide or contact us <strong>immediately</strong> so we can resolve it.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Formal complaints must be submitted <strong>in writing within 14 days</strong> of the trip&#8217;s conclusion.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Any disputes shall be governed by the <strong>laws of Nepal</strong>, and legal proceedings will take place in <strong>Kathmandu District Court</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="privacy-data" aria-labelledby="privacy-data-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'privacy-data' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'We collect only <strong>essential personal information</strong> to process bookings and deliver services.', 'iflynepal' ) ); ?></li>
							<li>
								<?php
								echo wp_kses_post( __( 'Your data is <strong>never sold or misused</strong>.', 'iflynepal' ) ) . ' ';
								// The link is built and escaped inside the render callback.
								echo iflynepal_render_terms_policy_link( 'privacy-policy' );
								?>
							</li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="final-acceptance" aria-labelledby="final-acceptance-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_terms_clause_head( 'final-acceptance' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php echo wp_kses_post( __( 'By confirming your booking with iFly Nepal, you acknowledge that you have <strong>read, understood, and agreed</strong> to these Terms &amp; Conditions.', 'iflynepal' ) ); ?></p>
					</div>
				</article>

			</div>
		</div>

	</div>
</section>
