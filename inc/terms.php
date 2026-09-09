<?php
/**
 * Terms & Conditions page: the clause register and its head renderer.
 *
 * The clauses are not editable in the Customizer. The page is a legal document
 * — it is republished when the wording is agreed, not tuned section by section
 * — so the copy lives in the template part beside the markup it belongs to,
 * and only the *register* of clauses lives here. The two pieces around the
 * document that are marketing rather than legal, the hero photograph and the
 * closing card, do have controls; those live in
 * inc/customizer/callbacks/terms.php.
 *
 * The register exists because two things have to agree: the "On this page"
 * index and the heading of each clause, including its number. Written twice
 * they drift the moment a clause is inserted; written once here, the index is
 * generated and the numbers are positions in this array.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every clause on the page, in the order it is read.
 *
 * The key is the anchor — descriptive rather than `clause-7`, so a link to one
 * from an email or the footer still says what it points at. Adding a clause
 * here adds its index entry and renumbers everything after it; the body itself
 * is written in template-parts/terms/clauses-section.php under the same key.
 *
 * @since 1.0.0
 *
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_terms_clauses() {
	return array(
		'booking-payment'      => array(
			'title' => __( 'Booking & Payment', 'iflynepal' ),
			'note'  => __( 'Deposits, balances and confirmation', 'iflynepal' ),
		),
		'cancellation-refunds' => array(
			'title' => __( 'Cancellation & Refund Policy', 'iflynepal' ),
			'note'  => __( 'By the client and by iFly Nepal', 'iflynepal' ),
		),
		'travel-insurance'     => array(
			'title' => __( 'Travel Insurance', 'iflynepal' ),
			'note'  => __( 'Mandatory cover', 'iflynepal' ),
		),
		'health-fitness'       => array(
			'title' => __( 'Health & Fitness', 'iflynepal' ),
			'note'  => __( 'Your responsibility before you travel', 'iflynepal' ),
		),
		'visa-entry'           => array(
			'title' => __( 'Visa & Entry Requirements', 'iflynepal' ),
			'note'  => __( 'Arriving in Nepal', 'iflynepal' ),
		),
		'flight-delays'        => array(
			'title' => __( 'Flight Delays & Cancellations', 'iflynepal' ),
			'note'  => __( 'Mountain flights and weather', 'iflynepal' ),
		),
		'risk-liability'       => array(
			'title' => __( 'Risk Acknowledgment & Liability', 'iflynepal' ),
			'note'  => __( 'Participation at your own risk', 'iflynepal' ),
		),
		'safety-emergency'     => array(
			'title' => __( 'Safety & Emergency Procedures', 'iflynepal' ),
			'note'  => __( 'On the ground with our guides', 'iflynepal' ),
		),
		'sustainable-travel'   => array(
			'title' => __( 'Sustainable & Ethical Travel', 'iflynepal' ),
			'note'  => __( 'What we ask of every traveller', 'iflynepal' ),
		),
		'volunteering'         => array(
			'title' => __( 'Volunteering & Community Programs', 'iflynepal' ),
			'note'  => __( 'Placements with local partners', 'iflynepal' ),
		),
		'itinerary-changes'    => array(
			'title' => __( 'Accommodation & Itinerary Changes', 'iflynepal' ),
			'note'  => __( 'When plans must change', 'iflynepal' ),
		),
		'complaints-disputes'  => array(
			'title' => __( 'Complaints & Disputes', 'iflynepal' ),
			'note'  => __( 'How issues are resolved', 'iflynepal' ),
		),
		'privacy-data'         => array(
			'title' => __( 'Privacy & Data Protection', 'iflynepal' ),
			'note'  => __( 'What we collect and why', 'iflynepal' ),
		),
		'final-acceptance'     => array(
			'title' => __( 'Final Acceptance', 'iflynepal' ),
			'note'  => __( 'Confirming your booking', 'iflynepal' ),
		),
	);
}

/**
 * One clause's position in the register, counting from one.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return int Its number, or 0 when the anchor is not registered.
 */
function iflynepal_terms_clause_number( $anchor ) {
	$position = array_search( $anchor, array_keys( iflynepal_terms_clauses() ), true );

	return false === $position ? 0 : (int) $position + 1;
}

/**
 * Renders the "On this page" index.
 *
 * Ordinary fragment links, so they work with JavaScript off; the active mark
 * is added by assets/js/terms/index.js.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_terms_index() {
	$markup = '';

	foreach ( iflynepal_terms_clauses() as $anchor => $clause ) {
		$markup .= sprintf(
			'<a class="iflynepal-legal-index__link" href="#%1$s">%2$s</a>',
			esc_attr( $anchor ),
			esc_html( $clause['title'] )
		);
	}

	return $markup;
}

/**
 * Renders one clause's heading: its number, its title and the line under it.
 *
 * The number is drawn zero-padded to two digits, as the design has it, and is
 * hidden from assistive technology — it is a visual index mark, and a screen
 * reader announcing "zero seven" before the heading adds nothing.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return string Markup, or an empty string for an unregistered anchor.
 */
function iflynepal_render_terms_clause_head( $anchor ) {
	$clauses = iflynepal_terms_clauses();

	if ( ! isset( $clauses[ $anchor ] ) ) {
		return '';
	}

	return sprintf(
		'<div class="iflynepal-legal-clause__head">
			<span class="iflynepal-legal-clause__num" aria-hidden="true">%1$s</span>
			<div>
				<h3 class="wp-block-heading iflynepal-legal-clause__title" id="%2$s-title">%3$s</h3>
				<small class="iflynepal-legal-clause__note">%4$s</small>
			</div>
		</div>',
		esc_html( str_pad( (string) iflynepal_terms_clause_number( $anchor ), 2, '0', STR_PAD_LEFT ) ),
		esc_attr( $anchor ),
		esc_html( $clauses[ $anchor ]['title'] ),
		esc_html( $clauses[ $anchor ]['note'] )
	);
}

/**
 * Renders the sentence that points at one of the sibling policy pages.
 *
 * Two clauses defer to another document — Sustainability and Privacy — and both
 * sentences are the same shape, so they are built here rather than assembled at
 * the call site where the link markup would have to be escaped inline.
 *
 * The URL is home_url() rather than a stored setting: these are fixed pages of
 * this site, and the sentence around the link is part of the clause, which is
 * not editable either.
 *
 * @since 1.0.0
 *
 * @param string $policy Either 'sustainable-policy' or 'privacy-policy'.
 * @return string Markup, or an empty string for an unknown policy.
 */
function iflynepal_render_terms_policy_link( $policy ) {
	$policies = array(
		'sustainable-policy' => array(
			'label' => __( 'Sustainability Policy', 'iflynepal' ),
			/* translators: %s: link to the Sustainability Policy page. */
			'text'  => __( 'By travelling with us, you agree to uphold our %s and contribute to responsible tourism in Nepal.', 'iflynepal' ),
		),
		'privacy-policy'     => array(
			'label' => __( 'Privacy Policy', 'iflynepal' ),
			/* translators: %s: link to the Privacy Policy page. */
			'text'  => __( 'See our full %s for details.', 'iflynepal' ),
		),
	);

	if ( ! isset( $policies[ $policy ] ) ) {
		return '';
	}

	return sprintf(
		wp_kses_post( $policies[ $policy ]['text'] ),
		sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( home_url( '/' . $policy ) ),
			esc_html( $policies[ $policy ]['label'] )
		)
	);
}
