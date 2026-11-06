<?php
/**
 * Privacy Policy page: the clause register, its renderers, and the two notes
 * that link out of the document.
 *
 * The same arrangement as inc/terms.php and inc/cookie.php, for the same
 * reason. The clauses are not editable in the Customizer — a policy is agreed
 * and republished as a whole, not tuned clause by clause — so the copy lives in
 * the template part beside its markup, and only the *register* lives here.
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
 * The key is the anchor — descriptive rather than the design's `clause-3`, so a
 * link to one from an email or a data request still says what it points at.
 *
 * @since 1.0.0
 *
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_privacy_clauses() {
	return array(
		'who-we-are'             => array(
			'title' => __( 'Who We Are', 'iflynepal' ),
			'note'  => __( 'The company behind this website', 'iflynepal' ),
		),
		'information-we-collect' => array(
			'title' => __( 'Information We Collect', 'iflynepal' ),
			'note'  => __( 'Personal and payment information', 'iflynepal' ),
		),
		'automatic-information'  => array(
			'title' => __( 'Automatically Collected Information', 'iflynepal' ),
			'note'  => __( 'Collected when you visit our site', 'iflynepal' ),
		),
		'tracking-technologies'  => array(
			'title' => __( 'Cookies & Tracking Technologies', 'iflynepal' ),
			'note'  => __( 'Improving your browsing experience', 'iflynepal' ),
		),
		'media-uploads'          => array(
			'title' => __( 'Media Uploads', 'iflynepal' ),
			'note'  => __( 'Images you share with us', 'iflynepal' ),
		),
		'comments'               => array(
			'title' => __( 'Comments', 'iflynepal' ),
			'note'  => __( 'When you leave a comment on our site', 'iflynepal' ),
		),
		'embedded-content'       => array(
			'title' => __( 'Embedded Content from Other Websites', 'iflynepal' ),
			'note'  => __( 'Videos, maps and articles', 'iflynepal' ),
		),
		'how-we-use-data'        => array(
			'title' => __( 'How We Use Your Information', 'iflynepal' ),
			'note'  => __( 'Purposes for processing', 'iflynepal' ),
		),
		'data-sharing'           => array(
			'title' => __( 'Who We Share Your Data With', 'iflynepal' ),
			'note'  => __( 'We do not sell your data', 'iflynepal' ),
		),
		'data-retention'         => array(
			'title' => __( 'How Long We Retain Your Data', 'iflynepal' ),
			'note'  => __( 'Retention periods', 'iflynepal' ),
		),
		'your-rights'            => array(
			'title' => __( 'Your Rights', 'iflynepal' ),
			'note'  => __( 'What you can request', 'iflynepal' ),
		),
		'data-security'          => array(
			'title' => __( 'Data Security', 'iflynepal' ),
			'note'  => __( 'How we safeguard your data', 'iflynepal' ),
		),
		'data-transfers'         => array(
			'title' => __( 'Where Your Data Is Sent', 'iflynepal' ),
			'note'  => __( 'Spam checks and trip operations', 'iflynepal' ),
		),
		'third-party-links'      => array(
			'title' => __( 'Third-Party Links', 'iflynepal' ),
			'note'  => __( 'Sites we link out to', 'iflynepal' ),
		),
		'policy-changes'         => array(
			'title' => __( 'Changes to This Policy', 'iflynepal' ),
			'note'  => __( 'Keeping you informed', 'iflynepal' ),
		),
	);
}

