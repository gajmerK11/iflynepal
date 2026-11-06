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

