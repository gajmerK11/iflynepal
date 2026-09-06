<?php
/**
 * CSR page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The page is eight sections down one column: a hero, the commitment, a pledge
 * band, two pillars, three community projects, two ways tourism empowers, the
 * accountability statement, and the closing invitation. Three of those are
 * add/remove lists and the rest are fixed copy.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Paragraphs the Commitment column can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/csr/repeaters.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_PARAGRAPH_MAX = 6;

/**
 * Rows the Sustainable Tourism pillars can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_PILLAR_MAX = 6;

/**
 * Cards the Community Engagement grid can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_PROJECT_MAX = 9;

/**
 * Panels the Empowering Through Tourism grid can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_TOURISM_MAX = 6;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero kicker.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_HERO_KICKER_DEFAULT = 'Corporate Social Responsibility (CSR)';

/**
 * Default hero headline.
 *
 * `em` marks the word that takes the gold accent, the same as every other hero
 * on the site. The full stop sits outside the accent, as the design has it.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_HERO_TITLE_DEFAULT = 'Travel with <em>purpose</em>.';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_HERO_LEAD_DEFAULT = 'We believe that with great travel comes great responsibility';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_CSR_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/csr/hero-travel-with-purpose.jpg' );

/**
 * Hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_hero_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_hero_kicker', IFLYNEPAL_CSR_HERO_KICKER_DEFAULT ) );
}

/**
 * Hero headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_csr_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_hero_title', IFLYNEPAL_CSR_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_csr_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_hero_lead', IFLYNEPAL_CSR_HERO_LEAD_DEFAULT ) );
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the design's stand-in.
 */
function iflynepal_csr_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_CSR_HERO_IMAGE_DEFAULT;
}

/* ------------------------------------------------------------ commitment */

/**
 * Default kicker above the Commitment heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_COMMITMENT_KICKER_DEFAULT = 'Corporate Social Responsibility (CSR)';

/**
 * Default Commitment heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_COMMITMENT_TITLE_DEFAULT = 'Our Commitment to Responsible Travel';

/**
 * Stand-in photograph beside the Commitment copy.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_CSR_COMMITMENT_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/csr/commitment-responsible-travel.jpg' );

/**
 * Default Commitment paragraphs, as the design has them.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_csr_commitment_defaults() {
	return array(
		1 => __( 'At iFly Nepal Team, we believe in the transformative power of travel. We understand that our journey is intertwined with the communities and environments we explore. As a responsible travel agency based in Nepal, we are committed to making a positive impact on the world around us.', 'iflynepal' ),
	);
}

/**
 * One Commitment paragraph's default.
 *
 * @since 1.0.0
 *
 * @param int $index Paragraph number.
 * @return string Default text.
 */
function iflynepal_csr_commitment_default( $index ) {
	$defaults = iflynepal_csr_commitment_defaults();

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : '';
}

/**
 * Kicker above the Commitment heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_commitment_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_commitment_kicker', IFLYNEPAL_CSR_COMMITMENT_KICKER_DEFAULT ) );
}

/**
 * Commitment heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_csr_commitment_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_commitment_title', IFLYNEPAL_CSR_COMMITMENT_TITLE_DEFAULT ) );
}

/**
 * Whether the Commitment section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_commitment() {
	return '' !== trim( wp_strip_all_tags( iflynepal_csr_commitment_title() ) );
}

/**
 * The Commitment paragraphs that have text, in order.
 *
 * @since 1.0.0
 *
 * @return string[] Paragraph HTML.
 */
function iflynepal_csr_commitment_paragraphs() {
	$paragraphs = array();

	for ( $i = 1; $i <= IFLYNEPAL_CSR_PARAGRAPH_MAX; $i++ ) {
		$value = trim( (string) get_theme_mod( 'iflynepal_csr_commitment_paragraph_' . $i, iflynepal_csr_commitment_default( $i ) ) );

		if ( '' === $value ) {
			continue;
		}

		$paragraphs[] = $value;
	}

	return $paragraphs;
}

/**
 * Commitment photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, or an empty string when the frame is unused.
 */
function iflynepal_csr_commitment_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_commitment_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_CSR_COMMITMENT_IMAGE_DEFAULT;
}

/**
 * Commitment photograph alt text.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_csr_commitment_image_alt() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_commitment_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	return __( 'People sharing time together in a local community', 'iflynepal' );
}

/* ----------------------------------------------------------- pledge band */

/**
 * Default kicker above the pledge.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_PLEDGE_KICKER_DEFAULT = 'Sustainable Tourism Initiatives';

/**
 * Default pledge.
 *
 * The design sets this on one line at any width it fits, so it is written to be
 * short. `em` gives the closing word the serif accent.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_PLEDGE_DEFAULT = '&ldquo;Leave Only Footprints, Take Only <em>Pictures</em>&rdquo;';

/**
 * Kicker above the pledge.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_pledge_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_pledge_kicker', IFLYNEPAL_CSR_PLEDGE_KICKER_DEFAULT ) );
}

/**
 * The pledge itself.
 *
 * @since 1.0.0
 *
 * @return string Pledge HTML. Empty hides the band.
 */
function iflynepal_csr_pledge() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_pledge', IFLYNEPAL_CSR_PLEDGE_DEFAULT ) );
}

/**
 * Whether the pledge band is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_pledge() {
	return '' !== trim( wp_strip_all_tags( iflynepal_csr_pledge() ) );
}

/* --------------------------------------------------------------- pillars */

/**
 * Default pillars, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_csr_pillar_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Preserving Nepal&rsquo;s Natural Beauty:', 'iflynepal' ),
			'description' => __( 'We actively participate in initiatives that aim to preserve the breathtaking landscapes and biodiversity that make Nepal a haven for travelers. From supporting local conservation projects to promoting eco-friendly practices, we strive to minimize our ecological footprint.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/csr/pillar-01-preserving-natural-beauty.jpg',
			'image_alt'   => __( 'Nepal&rsquo;s mountain environment beneath a clear sky', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Empowering Local Communities:', 'iflynepal' ),
			'description' => __( 'Our commitment goes beyond tourism; we are dedicated to empowering local communities. By collaborating with local businesses, supporting artisans, and promoting fair trade practices, we aim to foster sustainable development in the regions we operate.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/csr/pillar-02-empowering-local-communities.jpg',
			'image_alt'   => __( 'People connecting within a local community', 'iflynepal' ),
		),
	);
}

/**
 * One pillar's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Pillar number.
 * @return array Defaults for that pillar.
 */
function iflynepal_csr_pillar_default( $index ) {
	$defaults = iflynepal_csr_pillar_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
		'image'       => '',
		'image_alt'   => '',
	);
}

/**
 * One pillar's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Pillar number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_csr_pillar_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_pillar_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_csr_pillar_default( $index );

	return $default['image'];
}

/**
 * One pillar's photograph alt text.
 *
 * @since 1.0.0
 *
 * @param int $index Pillar number.
 * @return string Alt text.
 */
function iflynepal_csr_pillar_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_pillar_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_csr_pillar_default( $index );

	return $default['image_alt'];
}

/**
 * The pillars that have a title, in order.
 *
 * Emptying a title is how the Customizer's Remove button deletes one.
 *
 * @since 1.0.0
 *
 * @return array[] Pillars, each with 'index', 'title' and 'description'.
 */
function iflynepal_csr_pillars() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_CSR_PILLAR_MAX; $i++ ) {
		$default = iflynepal_csr_pillar_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_csr_pillar_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => trim( (string) get_theme_mod( 'iflynepal_csr_pillar_' . $i . '_description', $default['description'] ) ),
		);
	}

	return $rows;
}

/* ---------------------------------------------------- community projects */

/**
 * Default kicker above the Community heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_COMMUNITY_KICKER_DEFAULT = 'Community Engagement Projects';

/**
 * Default Community heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_COMMUNITY_TITLE_DEFAULT = 'Empowering Lives, Transforming Communities';

/**
 * Kicker above the Community heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_community_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_community_kicker', IFLYNEPAL_CSR_COMMUNITY_KICKER_DEFAULT ) );
}

/**
 * Community heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_csr_community_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_community_title', IFLYNEPAL_CSR_COMMUNITY_TITLE_DEFAULT ) );
}

/**
 * Whether the Community section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_community() {
	return '' !== trim( wp_strip_all_tags( iflynepal_csr_community_title() ) );
}

/**
 * Default community projects, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_csr_project_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Education for All:', 'iflynepal' ),
			'description' => __( 'We believe in the power of education to create lasting change. Through our projects, we contribute to educational initiatives that ensure children in remote areas have access to quality education, paving the way for a brighter future.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/csr/community-01-education-for-all.jpg',
			'image_alt'   => __( 'Students learning together in a classroom', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Health and Well-being:', 'iflynepal' ),
			'description' => __( 'We are dedicated to improving the health and well-being of communities in need. From organizing health camps to supporting healthcare infrastructure, we actively engage in projects that address the unique healthcare challenges faced by different communities.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/csr/community-02-health-and-well-being.jpg',
			'image_alt'   => __( 'Healthcare professionals supporting community wellbeing', 'iflynepal' ),
		),
		3 => array(
			'title'       => __( 'Disaster Relief and Resilience:', 'iflynepal' ),
			'description' => __( 'We are dedicated to disaster relief, swiftly responding to crises with essential supplies, medical aid, and long-term reconstruction efforts. Our focus on community resilience includes training, healthcare, and infrastructure development.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/csr/community-03-disaster-relief.jpg',
			'image_alt'   => __( 'Volunteers working together to support a community', 'iflynepal' ),
		),
	);
}

/**
 * One project's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_csr_project_default( $index ) {
	$defaults = iflynepal_csr_project_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
		'image'       => '',
		'image_alt'   => '',
	);
}

/**
 * One project's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_csr_project_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_project_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'medium_large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_csr_project_default( $index );

	return $default['image'];
}

/**
 * One project's photograph alt text.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Alt text.
 */
function iflynepal_csr_project_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_project_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_csr_project_default( $index );

	return $default['image_alt'];
}

/**
 * The community projects that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Projects, each with 'index', 'title' and 'description'.
 */
function iflynepal_csr_projects() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_CSR_PROJECT_MAX; $i++ ) {
		$default = iflynepal_csr_project_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_csr_project_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$cards[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => trim( (string) get_theme_mod( 'iflynepal_csr_project_' . $i . '_description', $default['description'] ) ),
		);
	}

	return $cards;
}

/* -------------------------------------------------- empowering through tourism */

/**
 * Default kicker above the Empowerment heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_TOURISM_KICKER_DEFAULT = 'Empowering Through Tourism';

/**
 * Default Empowerment heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_TOURISM_TITLE_DEFAULT = 'Building Futures, Enriching Communities';

/**
 * Kicker above the Empowerment heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_tourism_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_tourism_kicker', IFLYNEPAL_CSR_TOURISM_KICKER_DEFAULT ) );
}

/**
 * Empowerment heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_csr_tourism_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_tourism_title', IFLYNEPAL_CSR_TOURISM_TITLE_DEFAULT ) );
}

/**
 * Whether the Empowerment section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_tourism() {
	return '' !== trim( wp_strip_all_tags( iflynepal_csr_tourism_title() ) );
}

/**
 * Default tourism panels, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_csr_tourism_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Local Employment Opportunities:', 'iflynepal' ),
			'description' => __( 'Tourism is a powerful tool for creating employment opportunities. We prioritize working with local guides, accommodation providers, and businesses, contributing to the economic growth of the areas we serve.', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Preserving Cultural Heritage:', 'iflynepal' ),
			'description' => __( 'Nepal&rsquo;s rich cultural heritage is a treasure to be preserved. We actively promote responsible tourism practices that respect and celebrate local customs and traditions, ensuring that cultural heritage remains vibrant for generations to come.', 'iflynepal' ),
		),
	);
}

/**
 * One tourism panel's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Panel number.
 * @return array Defaults for that panel.
 */
function iflynepal_csr_tourism_default( $index ) {
	$defaults = iflynepal_csr_tourism_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
	);
}

/**
 * The tourism panels that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Panels, each with 'index', 'title' and 'description'.
 */
function iflynepal_csr_tourism_items() {
	$items = array();

	for ( $i = 1; $i <= IFLYNEPAL_CSR_TOURISM_MAX; $i++ ) {
		$default = iflynepal_csr_tourism_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_csr_tourism_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$items[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => trim( (string) get_theme_mod( 'iflynepal_csr_tourism_' . $i . '_description', $default['description'] ) ),
		);
	}

	return $items;
}

/* -------------------------------------------------------- accountability */

/**
 * Default kicker above the Accountability heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_ACCOUNTABILITY_KICKER_DEFAULT = 'Transparency and Accountability';

/**
 * Default Accountability heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_ACCOUNTABILITY_TITLE_DEFAULT = 'Transparency and Accountability';

/**
 * Default Accountability paragraph.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_ACCOUNTABILITY_TEXT_DEFAULT = 'We are committed to transparency and accountability in all our CSR initiatives. Regular updates and reports on the impact of our projects will be shared on this page, reflecting our dedication to making a positive difference in the places we operate.';

/**
 * Stand-in photograph beside the Accountability copy.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_CSR_ACCOUNTABILITY_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/csr/accountability-transparency.jpg' );

/**
 * One of the Accountability copy fields.
 *
 * @since 1.0.0
 *
 * @param string $field One of 'kicker', 'title' or 'text'.
 * @return string Field HTML.
 */
function iflynepal_csr_accountability_field( $field ) {
	$defaults = array(
		'kicker' => IFLYNEPAL_CSR_ACCOUNTABILITY_KICKER_DEFAULT,
		'title'  => IFLYNEPAL_CSR_ACCOUNTABILITY_TITLE_DEFAULT,
		'text'   => IFLYNEPAL_CSR_ACCOUNTABILITY_TEXT_DEFAULT,
	);

	$default = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_accountability_' . $field, $default ) );
}

/**
 * Whether the Accountability section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_accountability() {
	return '' !== trim( wp_strip_all_tags( iflynepal_csr_accountability_field( 'title' ) ) );
}

/**
 * Accountability photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, or an empty string when the frame is unused.
 */
function iflynepal_csr_accountability_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_accountability_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_CSR_ACCOUNTABILITY_IMAGE_DEFAULT;
}

/**
 * Accountability photograph alt text.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_csr_accountability_image_alt() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_csr_accountability_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	return __( 'Historic architecture and living cultural heritage in Kathmandu', 'iflynepal' );
}

/* --------------------------------------------------------------- closing */

/**
 * Default kicker on the closing block.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_CLOSE_KICKER_DEFAULT = 'Join our journey';

/**
 * Default closing headline, first line.
 *
 * The design sets the two lines as separate blocks, each held to one line, so
 * they are two settings rather than one — the same arrangement the Team hero's
 * headline uses (§8b-12).
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_CLOSE_TITLE_DEFAULT = 'iFly Nepal Team: Travel with Purpose';

/**
 * Default closing headline, second line.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_CLOSE_TITLE_TWO_DEFAULT = 'Explore with <em>Heart.</em>';

/**
 * Default closing paragraph.
 *
 * Carries the contact address inline, which is why it is sanitized with
 * iflynepal_kses_rich() rather than the usual text filter.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_CSR_CLOSE_TEXT_DEFAULT = 'Join us on our journey towards responsible and sustainable travel. Together, let&rsquo;s explore the world while leaving a positive footprint behind. Contact us at <a href="mailto:contact@iflynepal.com">contact@iflynepal.com</a> to learn and contribute to the CSR-related initiatives.';

/**
 * Kicker on the closing block.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_csr_close_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_close_kicker', IFLYNEPAL_CSR_CLOSE_KICKER_DEFAULT ) );
}

/**
 * Closing headline, first line.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_csr_close_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_close_title', IFLYNEPAL_CSR_CLOSE_TITLE_DEFAULT ) );
}

/**
 * Closing headline, second line.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_csr_close_title_two() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_csr_close_title_two', IFLYNEPAL_CSR_CLOSE_TITLE_TWO_DEFAULT ) );
}

/**
 * Closing paragraph.
 *
 * @since 1.0.0
 *
 * @return string Paragraph HTML, links included.
 */
function iflynepal_csr_close_text() {
	return iflynepal_kses_rich( get_theme_mod( 'iflynepal_csr_close_text', IFLYNEPAL_CSR_CLOSE_TEXT_DEFAULT ) );
}

/**
 * Whether the closing block is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_csr_has_close() {
	$lines = trim( wp_strip_all_tags( iflynepal_csr_close_title() . iflynepal_csr_close_title_two() ) );

	return '' !== $lines;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_hero_kicker() {
	return iflynepal_csr_hero_kicker();
}

/**
 * Renders the hero headline.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_hero_title() {
	return iflynepal_csr_hero_title();
}

/**
 * Renders the hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_hero_lead() {
	return iflynepal_csr_hero_lead();
}

/**
 * Renders the Commitment kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_commitment_kicker() {
	return iflynepal_csr_commitment_kicker();
}

/**
 * Renders the Commitment heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_commitment_title() {
	return iflynepal_csr_commitment_title();
}

/**
 * Renders the Commitment paragraphs.
 *
 * One fragment for the block rather than one per paragraph: removing a
 * paragraph changes how many there are, and a per-paragraph partial would
 * leave an empty one standing where it had been.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_commitment_paragraphs() {
	$markup = '';

	foreach ( iflynepal_csr_commitment_paragraphs() as $paragraph ) {
		$markup .= '<p>' . iflynepal_kses_text( $paragraph ) . '</p>';
	}

	return $markup;
}

/**
 * Renders the pledge kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_pledge_kicker() {
	return iflynepal_csr_pledge_kicker();
}

/**
 * Renders the pledge.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_pledge() {
	return iflynepal_csr_pledge();
}

/**
 * Renders the pillars.
 *
 * The numeral is derived from the row's position rather than stored: the
 * design numbers them in order, so a stored number is a second thing to keep
 * in step with the list — and the repeater then has to be told that "01" is
 * what an unused slot holds, which is the trap §8b-11 records. Counting here
 * means removing a row renumbers the rest, which is what is wanted anyway.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_pillars() {
	$markup = '';

	foreach ( iflynepal_csr_pillars() as $row ) {
		$image = iflynepal_csr_pillar_image_url( $row['index'] );
		$photo = '';

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-csr-pillar__media"><img loading="lazy" src="%1$s" alt="%2$s"></div>',
				esc_url( $image ),
				esc_attr( iflynepal_csr_pillar_image_alt( $row['index'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-csr-pillar" data-iflynepal-reveal>%1$s<div class="iflynepal-csr-pillar__copy"><h3 class="iflynepal-csr-pillar__title">%2$s</h3><p class="iflynepal-csr-pillar__desc">%3$s</p></div></article>',
			$photo,
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the Community kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_community_kicker() {
	return iflynepal_csr_community_kicker();
}

/**
 * Renders the Community heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_community_title() {
	return iflynepal_csr_community_title();
}

/**
 * Renders the community project cards.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_projects() {
	$markup = '';

	foreach ( iflynepal_csr_projects() as $card ) {
		$image = iflynepal_csr_project_image_url( $card['index'] );
		$photo = '';

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-csr-project__media"><img loading="lazy" src="%1$s" alt="%2$s"></div>',
				esc_url( $image ),
				esc_attr( iflynepal_csr_project_image_alt( $card['index'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-csr-project" data-iflynepal-reveal>%1$s<div class="iflynepal-csr-project__copy"><h3 class="iflynepal-csr-project__title">%2$s</h3><p class="iflynepal-csr-project__desc">%3$s</p></div></article>',
			$photo,
			iflynepal_kses_text( $card['title'] ),
			iflynepal_kses_text( $card['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the Empowerment kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_tourism_kicker() {
	return iflynepal_csr_tourism_kicker();
}

/**
 * Renders the Empowerment heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_tourism_title() {
	return iflynepal_csr_tourism_title();
}

/**
 * Renders the tourism panels.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_tourism_items() {
	$markup = '';

	foreach ( iflynepal_csr_tourism_items() as $item ) {
		$markup .= sprintf(
			'<article class="iflynepal-csr-tourism" data-iflynepal-reveal><h3 class="iflynepal-csr-tourism__title">%1$s</h3><p class="iflynepal-csr-tourism__desc">%2$s</p></article>',
			iflynepal_kses_text( $item['title'] ),
			iflynepal_kses_text( $item['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the Accountability kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_accountability_kicker() {
	return iflynepal_csr_accountability_field( 'kicker' );
}

/**
 * Renders the Accountability heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_accountability_title() {
	return iflynepal_csr_accountability_field( 'title' );
}

/**
 * Renders the Accountability paragraph.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_accountability_text() {
	return iflynepal_csr_accountability_field( 'text' );
}

/**
 * Renders the closing kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_close_kicker() {
	return iflynepal_csr_close_kicker();
}

/**
 * Renders the closing headline.
 *
 * Both lines are one fragment: each is its own block and emptying one should
 * close the gap it left rather than leave a blank line standing.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_close_title() {
	$markup = '';

	foreach ( array( iflynepal_csr_close_title(), iflynepal_csr_close_title_two() ) as $line ) {
		if ( '' === trim( wp_strip_all_tags( $line ) ) ) {
			continue;
		}

		$markup .= '<span>' . $line . '</span>';
	}

	return $markup;
}

/**
 * Renders the closing paragraph.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_csr_close_text() {
	return iflynepal_csr_close_text();
}
