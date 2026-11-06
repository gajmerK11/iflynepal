<?php
/**
 * Sustainability Policy page: the clause register, its renderers, and the
 * data behind the pledge cards and the frameworks list.
 *
 * The same arrangement as inc/terms.php, inc/cookie.php and inc/privacy.php,
 * for the same reason. The clauses are not editable in the Customizer — a
 * policy is agreed and republished as a whole, not tuned clause by clause — so
 * the copy lives in the template parts beside its markup, and only the
 * *register* lives here.
 *
 * The register exists because two things have to agree: the "On this page"
 * index and the heading of each clause, including its number. Written twice
 * they drift the moment a clause is inserted; written once here, the index is
 * generated and the numbers are positions in this array.
 *
 * The one part of the page that is not the document — who the Sustainability
 * Coordinator is and how to reach them — is in the Customizer; see
 * inc/customizer/callbacks/sustainability.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every clause on the page, in the order it is read.
 *
 * The key is the anchor — descriptive rather than the design's `clause-3`, so a
 * link to one from a supplier brief or a trip dossier still says what it
 * points at.
 *
 * @since 1.0.0
 *
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_sustainability_clauses() {
	return array(
		'introduction'         => array(
			'title' => __( 'Introduction', 'iflynepal' ),
			'note'  => __( 'Why this policy exists', 'iflynepal' ),
		),
		'environment'          => array(
			'title' => __( 'Environmental Responsibility', 'iflynepal' ),
			'note'  => __( 'Core value 1', 'iflynepal' ),
		),
		'community'            => array(
			'title' => __( 'Community Empowerment', 'iflynepal' ),
			'note'  => __( 'Core value 2', 'iflynepal' ),
		),
		'fair-employment'      => array(
			'title' => __( 'Fair Employment & Human Rights', 'iflynepal' ),
			'note'  => __( 'Core value 3', 'iflynepal' ),
		),
		'ethical-conduct'      => array(
			'title' => __( 'Ethical Business Conduct', 'iflynepal' ),
			'note'  => __( 'Core value 4', 'iflynepal' ),
		),
		'governance'           => array(
			'title' => __( 'Governance & Management', 'iflynepal' ),
			'note'  => __( 'Who owns this policy', 'iflynepal' ),
		),
		'in-the-field'         => array(
			'title' => __( 'In the Field', 'iflynepal' ),
			'note'  => __( 'Operations on the trail', 'iflynepal' ),
		),
		'in-the-office'        => array(
			'title' => __( 'In the Office', 'iflynepal' ),
			'note'  => __( 'Operations in Kathmandu', 'iflynepal' ),
		),
		'transportation'       => array(
			'title' => __( 'Transportation', 'iflynepal' ),
			'note'  => __( 'Vehicles, flights and offsets', 'iflynepal' ),
		),
		'food-beverage'        => array(
			'title' => __( 'Food & Beverage', 'iflynepal' ),
			'note'  => __( 'What we serve on trips', 'iflynepal' ),
		),
		'cultural-heritage'    => array(
			'title' => __( 'Cultural & Heritage Sensitivity', 'iflynepal' ),
			'note'  => __( 'Respect on the ground', 'iflynepal' ),
		),
		'monitoring'           => array(
			'title' => __( 'Monitoring, Feedback & Continuous Improvement', 'iflynepal' ),
			'note'  => __( 'How we keep it honest', 'iflynepal' ),
		),
		'public-communication' => array(
			'title' => __( 'Public Communication & Awareness', 'iflynepal' ),
			'note'  => __( 'Sharing what we learn', 'iflynepal' ),
		),
		'policies-in-practice' => array(
			'title' => __( 'Policies in Practice', 'iflynepal' ),
			'note'  => __( 'Our guiding frameworks', 'iflynepal' ),
		),
	);
}

