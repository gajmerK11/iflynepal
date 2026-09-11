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

/**
 * One clause's position in the register, counting from one.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return int Its number, or 0 when the anchor is not registered.
 */
function iflynepal_privacy_clause_number( $anchor ) {
	$position = array_search( $anchor, array_keys( iflynepal_privacy_clauses() ), true );

	return false === $position ? 0 : (int) $position + 1;
}

/**
 * Renders the "On this page" index.
 *
 * Ordinary fragment links, so they work with JavaScript off; the active mark
 * and the glide are added by assets/js/legal/index.js.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_privacy_index() {
	$markup = '';

	foreach ( iflynepal_privacy_clauses() as $anchor => $clause ) {
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
 * reader announcing "zero three" before the heading adds nothing.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return string Markup, or an empty string for an unregistered anchor.
 */
function iflynepal_render_privacy_clause_head( $anchor ) {
	$clauses = iflynepal_privacy_clauses();

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
		esc_html( str_pad( (string) iflynepal_privacy_clause_number( $anchor ), 2, '0', STR_PAD_LEFT ) ),
		esc_attr( $anchor ),
		esc_html( $clauses[ $anchor ]['title'] ),
		esc_html( $clauses[ $anchor ]['note'] )
	);
}

/**
 * The note under clause 04, pointing at the Cookie Policy.
 *
 * One translatable sentence with the link dropped in, so a translator can put
 * the policy's name where their language wants it. The link is built from the
 * site's own address, so it follows the site to its live domain.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_privacy_cookie_note() {
	return sprintf(
		/* translators: %s: link to the Cookie Policy page. */
		esc_html__( 'You can manage cookie settings through your browser or opt out of certain tracking. See our %s for the full detail.', 'iflynepal' ),
		sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( home_url( '/cookie-policy/' ) ),
			esc_html__( 'Cookie Policy', 'iflynepal' )
		)
	);
}

/**
 * The note under clause 11, naming the address data requests go to.
 *
 * The address is the office email from Customizer > Footer rather than a copy
 * typed into the policy, so the two cannot disagree when the inbox changes.
 * The design's address stands in only while that field is empty.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_privacy_contact_note() {
	$email = sanitize_email( iflynepal_footer_office_field( 'email' ) );

	if ( ! $email ) {
		$email = 'contact@iflynepal.com';
	}

	return sprintf(
		/* translators: %s: the office email address, as a link. */
		esc_html__( 'Please contact us at %s for any data access or removal request.', 'iflynepal' ),
		sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( 'mailto:' . $email ),
			esc_html( $email )
		)
	);
}

/**
 * The three rights in clause 11, as cards.
 *
 * Data rather than three blocks of markup: they differ only in an icon, a
 * title and a sentence.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'icon' (SVG inner markup), 'title' and 'text'.
 */
function iflynepal_privacy_rights() {
	return array(
		array(
			'icon'  => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/>',
			'title' => __( 'A copy of your data', 'iflynepal' ),
			'text'  => __( 'Request a copy of the personal data we hold about you.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
			'title' => __( 'Corrections or updates', 'iflynepal' ),
			'text'  => __( 'Ask us to correct or update any information that is wrong or out of date.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>',
			'title' => __( 'Deletion of your data', 'iflynepal' ),
			'text'  => __( 'Request deletion, except data we must retain for legal reasons.', 'iflynepal' ),
		),
	);
}

/**
 * Renders the rights cards.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_privacy_rights() {
	$svg = array(
		'path' => array( 'd' => true ),
	);

	$markup = '';

	foreach ( iflynepal_privacy_rights() as $right ) {
		$markup .= sprintf(
			'<div class="iflynepal-privacy-right">
				<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%1$s</svg>
				<h4 class="wp-block-heading iflynepal-privacy-right__title">%2$s</h4>
				<p class="iflynepal-privacy-right__text">%3$s</p>
			</div>',
			wp_kses( $right['icon'], $svg ),
			esc_html( $right['title'] ),
			esc_html( $right['text'] )
		);
	}

	return $markup;
}
