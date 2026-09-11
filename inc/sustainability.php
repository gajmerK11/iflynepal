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

/**
 * One clause's position in the register, counting from one.
 *
 * @since 1.0.0
 *
 * @param string $anchor Clause anchor.
 * @return int Its number, or 0 when the anchor is not registered.
 */
function iflynepal_sustainability_clause_number( $anchor ) {
	$position = array_search( $anchor, array_keys( iflynepal_sustainability_clauses() ), true );

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
function iflynepal_render_sustainability_index() {
	$markup = '';

	foreach ( iflynepal_sustainability_clauses() as $anchor => $clause ) {
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
function iflynepal_render_sustainability_clause_head( $anchor ) {
	$clauses = iflynepal_sustainability_clauses();

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
		esc_html( str_pad( (string) iflynepal_sustainability_clause_number( $anchor ), 2, '0', STR_PAD_LEFT ) ),
		esc_attr( $anchor ),
		esc_html( $clauses[ $anchor ]['title'] ),
		esc_html( $clauses[ $anchor ]['note'] )
	);
}

/**
 * The six promises in the "Our commitment" section above the policy.
 *
 * Data rather than six blocks of markup: they differ only in an icon, a title
 * and a sentence.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'icon' (SVG inner markup), 'title' and 'text'.
 */
function iflynepal_sustainability_pledges() {
	return array(
		array(
			'icon'  => '<path d="M12 21c-4.5-2.5-7-6-7-10a7 7 0 0 1 14 0c0 4-2.5 7.5-7 10z"/><path d="M12 21v-9M9.5 14 12 12l2.5 2"/>',
			'title' => __( 'Minimise our environmental footprint', 'iflynepal' ),
			'text'  => __( 'Across every part of our operations, from the trail to the office.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
			'title' => __( 'Promote social equity', 'iflynepal' ),
			'text'  => __( 'Empower the local communities who host and guide our travellers.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M3 21h18M6 21V9l6-5 6 5v12"/><path d="M10 21v-6h4v6"/>',
			'title' => __( 'Foster cultural sensitivity', 'iflynepal' ),
			'text'  => __( 'Preserve heritage and respect the customs of every place we visit.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
			'title' => __( 'Uphold fair labour and human rights', 'iflynepal' ),
			'text'  => __( 'Fair wages, safe conditions and insurance for all staff and field crew.', 'iflynepal' ),
		),
		array(
			'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 2"/>',
			'title' => __( 'Operate with transparency', 'iflynepal' ),
			'text'  => __( 'Accountability and integrity in how we run and report on the business.', 'iflynepal' ),
		),
		array(
			'icon'  => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
			'title' => __( 'Engage clients and partners', 'iflynepal' ),
			'text'  => __( 'Bring travellers and suppliers into our sustainability efforts, not around them.', 'iflynepal' ),
		),
	);
}

/**
 * The SVG elements an icon in this file is allowed to contain.
 *
 * @since 1.0.0
 *
 * @return array wp_kses() allow-list.
 */
function iflynepal_sustainability_icon_kses() {
	return array(
		'path'   => array( 'd' => true ),
		'circle' => array(
			'cx' => true,
			'cy' => true,
			'r'  => true,
		),
	);
}

/**
 * Renders the pledge cards.
 *
 * Each card reveals on its own, as the design staggers them.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_sustainability_pledges() {
	$markup = '';

	foreach ( iflynepal_sustainability_pledges() as $pledge ) {
		$markup .= sprintf(
			'<article class="iflynepal-sustain-pledge" data-iflynepal-reveal>
				<div class="iflynepal-sustain-pledge__icon" aria-hidden="true">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false">%1$s</svg>
				</div>
				<h3 class="wp-block-heading iflynepal-sustain-pledge__title">%2$s</h3>
				<p class="iflynepal-sustain-pledge__text">%3$s</p>
			</article>',
			wp_kses( $pledge['icon'], iflynepal_sustainability_icon_kses() ),
			esc_html( $pledge['title'] ),
			esc_html( $pledge['text'] )
		);
	}

	return $markup;
}

/**
 * The guiding frameworks listed in clause 14.
 *
 * @since 1.0.0
 *
 * @return string[] Framework names.
 */
function iflynepal_sustainability_frameworks() {
	return array(
		__( 'Sustainable Excursions & Code of Conduct', 'iflynepal' ),
		__( 'Sustainable Accommodation Standards', 'iflynepal' ),
		__( 'Sustainable Procurement Policy', 'iflynepal' ),
		__( 'Anti-Corruption and Fair Trade Policy', 'iflynepal' ),
		__( 'Transportation & Carbon Offset Plan', 'iflynepal' ),
		__( 'Plastic-Free & Waste Management Guide', 'iflynepal' ),
		__( 'Partner & Supplier Sustainability Criteria', 'iflynepal' ),
		__( 'Forbidden Souvenirs & Wildlife Protection Policy', 'iflynepal' ),
	);
}

/**
 * Renders the frameworks as a list.
 *
 * A real list rather than the design's run of spans, so a screen reader
 * announces how many there are.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_sustainability_frameworks() {
	$markup = '';

	foreach ( iflynepal_sustainability_frameworks() as $framework ) {
		$markup .= sprintf(
			'<li class="iflynepal-sustain-framework">
				<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20 6 9 17l-5-5"/></svg>
				<span>%s</span>
			</li>',
			esc_html( $framework )
		);
	}

	return $markup;
}

/**
 * A link to another of the site's policy pages, dropped into a sentence.
 *
 * One translatable sentence per use with the link passed in, so a translator
 * can put the policy's name where their language wants it. Built from the
 * site's own address, so it follows the site to its live domain.
 *
 * @since 1.0.0
 *
 * @param string $policy 'privacy' (clause 05) or 'terms' (the note in clause 14).
 * @return string Markup, or an empty string for an unknown policy.
 */
function iflynepal_render_sustainability_policy_link( $policy ) {
	$policies = array(
		'privacy' => array(
			/* translators: %s: link to the Privacy Policy page. */
			'text'  => __( 'Respect the privacy and data of all customers and staff — see our %s.', 'iflynepal' ),
			'label' => __( 'Privacy Policy', 'iflynepal' ),
			'path'  => '/privacy-policy/',
		),
		'terms'   => array(
			/* translators: %s: link to the Terms & Conditions page. */
			'text'  => __( 'Travelling with us means agreeing to uphold this policy — see the sustainability clause in our %s.', 'iflynepal' ),
			'label' => __( 'Terms & Conditions', 'iflynepal' ),
			// Straight to the clause that points back here, not the top of the page.
			'path'  => '/terms-and-conditions/#sustainable-travel',
		),
	);

	if ( ! isset( $policies[ $policy ] ) ) {
		return '';
	}

	return sprintf(
		esc_html( $policies[ $policy ]['text'] ),
		sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( home_url( $policies[ $policy ]['path'] ) ),
			esc_html( $policies[ $policy ]['label'] )
		)
	);
}
