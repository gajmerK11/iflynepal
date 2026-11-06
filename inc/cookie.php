<?php
/**
 * Cookie Policy page: the clause register and its head renderer.
 *
 * The same arrangement as inc/terms.php, for the same reason. The clauses are
 * not editable in the Customizer — a policy is agreed and republished as a
 * whole, not tuned clause by clause — so the copy lives in the template part
 * beside its markup, and only the *register* lives here.
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
 * The key is the anchor — descriptive rather than `clause-3`, as the design
 * has it, so a link to one from an email or a cookie banner still says what it
 * points at.
 *
 * @since 1.0.0
 *
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_cookie_clauses() {
	return array(
		'what-are-cookies'    => array(
			'title' => __( 'What Are Cookies?', 'iflynepal' ),
			'note'  => __( 'The basics', 'iflynepal' ),
		),
		'cookie-types'        => array(
			'title' => __( 'Types of Cookies We Use', 'iflynepal' ),
			'note'  => __( 'Four categories', 'iflynepal' ),
		),
		'third-party-cookies' => array(
			'title' => __( 'Third-Party Cookies', 'iflynepal' ),
			'note'  => __( 'Embedded content', 'iflynepal' ),
		),
		'cookie-management'   => array(
			'title' => __( 'Cookie Management', 'iflynepal' ),
			'note'  => __( 'Turning cookies off', 'iflynepal' ),
		),
		'policy-updates'      => array(
			'title' => __( 'Updates to this Policy', 'iflynepal' ),
			'note'  => __( 'Law and technology change', 'iflynepal' ),
		),
	);
}

