<?php
/**
 * Team page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The page is a hero and two rosters — the global representatives and the
 * executive team — that share one card shape between them, so the two lists
 * are the same code twice over rather than two designs. Everything on the page
 * is editable in Appearance > Customize > About > Team.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Portraits the hero cluster carries.
 *
 * Not a repeater: the three frames have three different shapes, sizes and
 * rotations in the design, so a fourth would have nowhere to sit. Emptying one
 * leaves its frame out.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_PORTRAIT_MAX = 3;

/**
 * Cards the Global Representatives roster can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/team/repeaters.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_REPRESENTATIVE_MAX = 12;

/**
 * Cards the Executive Team roster can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/team/repeaters.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_MEMBER_MAX = 20;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero kicker.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_KICKER_DEFAULT = 'Our team';

/**
 * Default hero headline, first line.
 *
 * The design's headline is two lines: an ordinary one, then the company name
 * in the gold serif beside the logo mark. They are two settings rather than
 * one, because the mark has to sit against the second line and a single
 * textarea gives no way to say where it goes.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_TITLE_DEFAULT = 'The people behind';

/**
 * Default hero headline, the accented company line beside the logo mark.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_BRAND_DEFAULT = 'iFly Nepal';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_LEAD_DEFAULT = 'Local in Nepal, connected around the world.<br>Meet the people who shape every journey from the first conversation to the final trail.';

/**
 * Default handwritten note under the portrait cluster.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_SCRIPT_DEFAULT = 'rooted in Nepal';

/**
 * Default label on the button that drops to the first roster.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_HERO_SCROLL_DEFAULT = 'Meet everyone';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * The hero is a photograph under a scrim, so it needs an image to be the thing
 * the design describes at all. The file lives in assets/images/team, named for
 * this section, so swapping it is a matter of replacing the file at that path.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_TEAM_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/team/hero-the-people-behind-ifly-nepal.jpg' );

/**
 * Hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_team_hero_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_hero_kicker', IFLYNEPAL_TEAM_HERO_KICKER_DEFAULT ) );
}

/**
 * Hero headline, first line.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_team_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_hero_title', IFLYNEPAL_TEAM_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero headline, the accented company line.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML. Empty hides the line and its logo mark.
 */
function iflynepal_team_hero_brand() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_hero_brand', IFLYNEPAL_TEAM_HERO_BRAND_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_team_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_hero_lead', IFLYNEPAL_TEAM_HERO_LEAD_DEFAULT ) );
}

/**
 * Handwritten note under the portrait cluster.
 *
 * @since 1.0.0
 *
 * @return string Note text. Empty hides it.
 */
function iflynepal_team_hero_script() {
	return trim( (string) get_theme_mod( 'iflynepal_team_hero_script', IFLYNEPAL_TEAM_HERO_SCRIPT_DEFAULT ) );
}

/**
 * Label on the button that drops to the first roster.
 *
 * @since 1.0.0
 *
 * @return string Label. Empty removes the button.
 */
function iflynepal_team_hero_scroll_label() {
	return trim( (string) get_theme_mod( 'iflynepal_team_hero_scroll_label', IFLYNEPAL_TEAM_HERO_SCROLL_DEFAULT ) );
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the design's stand-in.
 */
function iflynepal_team_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_TEAM_HERO_IMAGE_DEFAULT;
}

/* ------------------------------------------------------- hero: portraits */

/**
 * Default portraits in the hero cluster, as the design has them.
 *
 * These point at the same three files two of the rosters below default to —
 * the design shows the same colleagues in both places. They are separate
 * settings all the same, so changing a roster photograph does not silently
 * change the hero.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_team_portrait_defaults() {
	return array(
		1 => array(
			'image'     => IFLYNEPAL_URI . '/assets/images/team/member-01-prem-chief-executive.jpg',
			'image_alt' => __( 'Prem, Chief Executive', 'iflynepal' ),
		),
		2 => array(
			'image'     => IFLYNEPAL_URI . '/assets/images/team/member-03-yojana-business-development-lead.jpg',
			'image_alt' => __( 'Yojana, Business Development Lead', 'iflynepal' ),
		),
		3 => array(
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-01-prakash-usa.jpg',
			'image_alt' => __( 'Prakash, global representative in the USA', 'iflynepal' ),
		),
	);
}

/**
 * One portrait's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Portrait number.
 * @return array Defaults for that portrait.
 */
function iflynepal_team_portrait_default( $index ) {
	$defaults = iflynepal_team_portrait_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'image'     => '',
		'image_alt' => '',
	);
}

/**
 * One portrait's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Portrait number.
 * @return string Image URL, or an empty string when the frame is unused.
 */
function iflynepal_team_portrait_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_portrait_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_team_portrait_default( $index );

	return $default['image'];
}

/**
 * One portrait's alt text.
 *
 * Nothing beside the cluster names these people, so each frame carries a
 * description rather than being marked decorative.
 *
 * @since 1.0.0
 *
 * @param int $index Portrait number.
 * @return string Alt text.
 */
function iflynepal_team_portrait_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_portrait_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_team_portrait_default( $index );

	return $default['image_alt'];
}

/**
 * The portraits that have a photograph, in order.
 *
 * @since 1.0.0
 *
 * @return int[] Portrait numbers.
 */
function iflynepal_team_portraits() {
	$portraits = array();

	for ( $i = 1; $i <= IFLYNEPAL_TEAM_PORTRAIT_MAX; $i++ ) {
		if ( '' === iflynepal_team_portrait_image_url( $i ) ) {
			continue;
		}

		$portraits[] = $i;
	}

	return $portraits;
}

/* ----------------------------------------------------- representatives */

/**
 * Default kicker above the Global Representatives heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_REPS_KICKER_DEFAULT = 'Across the world';

/**
 * Default Global Representatives heading.
 *
 * `<span class="underline">` draws the inked mark, the same as the Explore
 * heading on the front page.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_REPS_TITLE_DEFAULT = 'Global <span class="underline">Representatives</span>';

/**
 * Default Global Representatives sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_REPS_LEAD_DEFAULT = 'Your local point of contact, connected directly with our Nepal-based team.';

/**
 * Default label printed above every representative's name.
 *
 * One setting for the whole roster rather than one per card: the design gives
 * all six the same line, and a per-card copy would be six chances for them to
 * drift apart.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_REPS_LABEL_DEFAULT = 'Global representative';

/**
 * Kicker above the Global Representatives heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_team_reps_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_reps_kicker', IFLYNEPAL_TEAM_REPS_KICKER_DEFAULT ) );
}

/**
 * Global Representatives heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the whole section.
 */
function iflynepal_team_reps_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_reps_title', IFLYNEPAL_TEAM_REPS_TITLE_DEFAULT ) );
}

/**
 * Global Representatives sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_team_reps_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_reps_lead', IFLYNEPAL_TEAM_REPS_LEAD_DEFAULT ) );
}

/**
 * Label printed above every representative's name.
 *
 * @since 1.0.0
 *
 * @return string Label. Empty leaves the line off every card.
 */
function iflynepal_team_reps_label() {
	return trim( (string) get_theme_mod( 'iflynepal_team_reps_label', IFLYNEPAL_TEAM_REPS_LABEL_DEFAULT ) );
}

/**
 * Whether the Global Representatives section is shown.
 *
 * Emptying the heading hides it, the same convention the rest of the theme
 * uses one level up.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_team_has_reps() {
	return '' !== trim( wp_strip_all_tags( iflynepal_team_reps_title() ) );
}

/**
 * Default representative cards, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_team_representative_defaults() {
	return array(
		1 => array(
			'name'      => __( 'Prakash', 'iflynepal' ),
			'country'   => __( 'USA', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-01-prakash-usa.jpg',
			'image_alt' => __( 'Prakash, global representative in the USA', 'iflynepal' ),
		),
		2 => array(
			'name'      => __( 'Gus', 'iflynepal' ),
			'country'   => __( 'UK', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-02-gus-uk.jpg',
			'image_alt' => __( 'Gus, global representative in the UK', 'iflynepal' ),
		),
		3 => array(
			'name'      => __( 'Raju', 'iflynepal' ),
			'country'   => __( 'France', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-03-raju-france.jpg',
			'image_alt' => __( 'Raju, global representative in France', 'iflynepal' ),
		),
		4 => array(
			'name'      => __( 'Vijay', 'iflynepal' ),
			'country'   => __( 'Italy', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-04-vijay-italy.jpg',
			'image_alt' => __( 'Vijay, global representative in Italy', 'iflynepal' ),
		),
		5 => array(
			'name'      => __( 'Suraj', 'iflynepal' ),
			'country'   => __( 'Australia', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-05-suraj-australia.jpg',
			'image_alt' => __( 'Suraj, global representative in Australia', 'iflynepal' ),
		),
		6 => array(
			'name'      => __( 'Ayush', 'iflynepal' ),
			'country'   => __( 'Japan', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/team/representative-06-ayush-japan.jpg',
			'image_alt' => __( 'Ayush, global representative in Japan', 'iflynepal' ),
		),
	);
}

/**
 * One representative's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_team_representative_default( $index ) {
	$defaults = iflynepal_team_representative_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'name'      => '',
		'country'   => '',
		'image'     => '',
		'image_alt' => '',
	);
}

/**
 * One representative's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_team_representative_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_representative_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_team_representative_default( $index );

	return $default['image'];
}

/**
 * One representative's photograph alt text.
 *
 * Built from the card's own fields when the media library has none, so a
 * screen reader is told who the photograph is of rather than being handed a
 * filename.
 *
 * @since 1.0.0
 *
 * @param int    $index   Card number.
 * @param string $name    The name on the card.
 * @param string $country The country on the card.
 * @return string Alt text.
 */
function iflynepal_team_representative_image_alt( $index, $name, $country ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_representative_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_team_representative_default( $index );
	$name    = trim( wp_strip_all_tags( $name ) );
	$country = trim( wp_strip_all_tags( $country ) );

	if ( ! $attachment_id && '' !== $default['image_alt'] && $name === $default['name'] ) {
		return $default['image_alt'];
	}

	if ( '' === $name ) {
		return '';
	}

	if ( '' === $country ) {
		return $name;
	}

	/* translators: 1: person's name, 2: the country they represent. */
	return sprintf( __( '%1$s, global representative in %2$s', 'iflynepal' ), $name, $country );
}

/**
 * The representative cards that have a name, in order.
 *
 * Emptying a name is how the Customizer's Remove button deletes a card, so a
 * nameless slot is dropped rather than rendered as a bare photograph.
 *
 * @since 1.0.0
 *
 * @return array[] Cards, each with 'index', 'name' and 'country'.
 */
function iflynepal_team_representatives() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_TEAM_REPRESENTATIVE_MAX; $i++ ) {
		$default = iflynepal_team_representative_default( $i );
		$name    = trim( (string) get_theme_mod( 'iflynepal_team_representative_' . $i . '_name', $default['name'] ) );

		if ( '' === $name ) {
			continue;
		}

		$cards[] = array(
			'index'   => $i,
			'name'    => $name,
			'country' => trim( (string) get_theme_mod( 'iflynepal_team_representative_' . $i . '_country', $default['country'] ) ),
		);
	}

	return $cards;
}

/* ----------------------------------------------------- executive team */

/**
 * Default Executive Team heading.
 *
 * `<span class="accent">` puts a word in the serif italic, the same mark the
 * About page's vision panel uses.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_EXECUTIVE_TITLE_DEFAULT = 'Executive <span class="accent">Team</span>';

/**
 * Default Executive Team sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_EXECUTIVE_LEAD_DEFAULT = 'The people responsible for planning, partnerships, finance, technology and guiding on the ground.';

/**
 * Executive Team heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the whole section.
 */
function iflynepal_team_executive_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_executive_title', IFLYNEPAL_TEAM_EXECUTIVE_TITLE_DEFAULT ) );
}

/**
 * Executive Team sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_team_executive_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_team_executive_lead', IFLYNEPAL_TEAM_EXECUTIVE_LEAD_DEFAULT ) );
}

/**
 * Whether the Executive Team section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_team_has_executive() {
	return '' !== trim( wp_strip_all_tags( iflynepal_team_executive_title() ) );
}

/**
 * Default executive cards, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_team_member_defaults() {
	return array(
		1  => array(
			'name'  => __( 'Prem', 'iflynepal' ),
			'role'  => __( 'Chief Executive', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-01-prem-chief-executive.jpg',
		),
		2  => array(
			'name'  => __( 'CA Dilip', 'iflynepal' ),
			'role'  => __( 'Finance', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-02-dilip-finance.jpg',
		),
		3  => array(
			'name'  => __( 'Yojana', 'iflynepal' ),
			'role'  => __( 'Business Development Lead', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-03-yojana-business-development-lead.jpg',
		),
		4  => array(
			'name'  => __( 'Sandesh', 'iflynepal' ),
			'role'  => __( 'Business Development, France', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-04-sandesh-business-development-france.jpg',
		),
		5  => array(
			'name'  => __( 'Gyanu', 'iflynepal' ),
			'role'  => __( 'Business Development, USA', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-05-gyanu-business-development-usa.jpg',
		),
		6  => array(
			'name'  => __( 'Samir', 'iflynepal' ),
			'role'  => __( 'SEO', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-06-samir-seo.jpg',
		),
		7  => array(
			'name'  => __( 'Anish', 'iflynepal' ),
			'role'  => __( 'IT', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-07-anish-it.jpg',
		),
		8  => array(
			'name'  => __( 'Agrata', 'iflynepal' ),
			'role'  => __( 'BD', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-08-agrata-bd.jpg',
		),
		9  => array(
			'name'  => __( 'Raj', 'iflynepal' ),
			'role'  => __( 'Guide', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-09-raj-guide.jpg',
		),
		10 => array(
			'name'  => __( 'Bhuwan', 'iflynepal' ),
			'role'  => __( 'Guide', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-10-bhuwan-guide.jpg',
		),
		11 => array(
			'name'  => __( 'Manik', 'iflynepal' ),
			'role'  => __( 'Guide', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-11-manik-guide.jpg',
		),
		12 => array(
			'name'  => __( 'Laxmi', 'iflynepal' ),
			'role'  => __( 'Guide', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-12-laxmi-guide.jpg',
		),
		13 => array(
			'name'  => __( 'Manoj', 'iflynepal' ),
			'role'  => __( 'Guide', 'iflynepal' ),
			'image' => IFLYNEPAL_URI . '/assets/images/team/member-13-manoj-guide.png',
		),
	);
}

/**
 * One executive's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_team_member_default( $index ) {
	$defaults = iflynepal_team_member_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'name'  => '',
		'role'  => '',
		'image' => '',
	);
}

/**
 * One executive's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_team_member_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_member_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_team_member_default( $index );

	return $default['image'];
}

/**
 * One executive's photograph alt text.
 *
 * Built from the card's own fields when the media library has none: "Prem,
 * Chief Executive" rather than a bare name, which leaves a screen reader with
 * no idea why the photograph is on the page.
 *
 * @since 1.0.0
 *
 * @param int    $index Card number.
 * @param string $name  The name on the card.
 * @param string $role  The role on the card.
 * @return string Alt text.
 */
function iflynepal_team_member_image_alt( $index, $name, $role ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_team_member_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$name = trim( wp_strip_all_tags( $name ) );
	$role = trim( wp_strip_all_tags( $role ) );

	if ( '' === $name ) {
		return '';
	}

	if ( '' === $role ) {
		return $name;
	}

	/* translators: 1: person's name, 2: their role. */
	return sprintf( __( '%1$s, %2$s', 'iflynepal' ), $name, $role );
}

/**
 * The executive cards that have a name, in order.
 *
 * Emptying a name is how the Customizer's Remove button deletes a card.
 *
 * @since 1.0.0
 *
 * @return array[] Cards, each with 'index', 'name' and 'role'.
 */
function iflynepal_team_members() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_TEAM_MEMBER_MAX; $i++ ) {
		$default = iflynepal_team_member_default( $i );
		$name    = trim( (string) get_theme_mod( 'iflynepal_team_member_' . $i . '_name', $default['name'] ) );

		if ( '' === $name ) {
			continue;
		}

		$cards[] = array(
			'index' => $i,
			'name'  => $name,
			'role'  => trim( (string) get_theme_mod( 'iflynepal_team_member_' . $i . '_role', $default['role'] ) ),
		);
	}

	return $cards;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_hero_kicker() {
	return iflynepal_team_hero_kicker();
}

/**
 * The logo mark beside the headline's company line.
 *
 * The site's own logo when one is set under Customize > Site Identity, so the
 * mark here cannot drift from the one in the header; the bundled file is the
 * fallback for an install that has not set one.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_team_hero_mark_url() {
	$attachment_id = (int) get_theme_mod( 'custom_logo', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'medium' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_URI . '/assets/images/ifly-logo.png';
}

/**
 * Renders the hero headline.
 *
 * The logo mark travels with the accented company line, so both are one
 * fragment: a partial on the line alone would leave the mark stranded when the
 * line is emptied.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_hero_title() {
	$title  = iflynepal_team_hero_title();
	$brand  = iflynepal_team_hero_brand();
	$markup = '';

	if ( '' !== trim( wp_strip_all_tags( $title ) ) ) {
		$markup .= '<span class="iflynepal-team-hero__line">' . $title . '</span>';
	}

	if ( '' !== trim( wp_strip_all_tags( $brand ) ) ) {
		$markup .= sprintf(
			'<span class="iflynepal-team-hero__brand"><img class="iflynepal-team-hero__mark" src="%1$s" alt="" aria-hidden="true"><em>%2$s</em></span>',
			esc_url( iflynepal_team_hero_mark_url() ),
			$brand
		);
	}

	return $markup;
}

/**
 * Renders the hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_hero_lead() {
	return iflynepal_team_hero_lead();
}

/**
 * Renders the hero's portrait cluster.
 *
 * One fragment for the whole cluster rather than one per frame: each frame has
 * its own shape and position in the arrangement, so removing one changes what
 * the others sit against.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_portraits() {
	$markup = '';

	/*
	 * Whole class names, not a modifier stitched on at runtime. Tailwind builds
	 * the stylesheet by scanning these files for literal class names, so
	 * "iflynepal-team-portrait--" . $shape would leave every one of these rules
	 * out of the compiled CSS and the frames would render unstyled.
	 */
	$shapes = array(
		1 => 'iflynepal-team-portrait--one',
		2 => 'iflynepal-team-portrait--two',
		3 => 'iflynepal-team-portrait--three',
	);

	foreach ( iflynepal_team_portraits() as $index ) {
		$markup .= sprintf(
			'<figure class="iflynepal-team-portrait %1$s"><img loading="lazy" src="%2$s" alt="%3$s"></figure>',
			esc_attr( isset( $shapes[ $index ] ) ? $shapes[ $index ] : '' ),
			esc_url( iflynepal_team_portrait_image_url( $index ) ),
			esc_attr( iflynepal_team_portrait_image_alt( $index ) )
		);
	}

	$script = iflynepal_team_hero_script();

	if ( '' !== $script ) {
		$markup .= '<span class="iflynepal-team-hero__script" aria-hidden="true">' . esc_html( $script ) . '</span>';
	}

	return $markup;
}

/**
 * Renders the Global Representatives kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_reps_kicker() {
	return iflynepal_team_reps_kicker();
}

/**
 * Renders the Global Representatives heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_reps_title() {
	return iflynepal_team_reps_title();
}

/**
 * Renders the Global Representatives sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_reps_lead() {
	return iflynepal_team_reps_lead();
}

/**
 * Renders the representative cards.
 *
 * One fragment for the whole roster rather than one per card: removing a card
 * changes how many are left, and the grid is laid out off that count.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_representatives() {
	$markup = '';
	$label  = iflynepal_team_reps_label();

	foreach ( iflynepal_team_representatives() as $card ) {
		$image = iflynepal_team_representative_image_url( $card['index'] );
		$photo = '';

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-team-card__photo"><img loading="lazy" src="%1$s" alt="%2$s"></div>',
				esc_url( $image ),
				esc_attr( iflynepal_team_representative_image_alt( $card['index'], $card['name'], $card['country'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-team-card iflynepal-team-card--rep" data-iflynepal-reveal>%1$s<div class="iflynepal-team-card__body">%2$s<h3 class="iflynepal-team-card__name">%3$s</h3>%4$s</div></article>',
			$photo,
			'' === $label ? '' : '<small class="iflynepal-team-card__label">' . esc_html( $label ) . '</small>',
			iflynepal_kses_text( $card['name'] ),
			'' === $card['country'] ? '' : '<p class="iflynepal-team-card__meta">' . iflynepal_kses_text( $card['country'] ) . '</p>'
		);
	}

	return $markup;
}

/**
 * Renders the Executive Team heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_executive_title() {
	return iflynepal_team_executive_title();
}

/**
 * Renders the Executive Team sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_executive_lead() {
	return iflynepal_team_executive_lead();
}

/**
 * Renders the executive cards.
 *
 * The role appears twice by design — on a pill over the photograph and again
 * under the name — so the pill is marked decorative rather than read out
 * twice.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_team_members() {
	$markup = '';

	foreach ( iflynepal_team_members() as $card ) {
		$image = iflynepal_team_member_image_url( $card['index'] );
		$pill  = '';
		$photo = '';

		if ( '' !== $card['role'] ) {
			$pill = '<span class="iflynepal-team-card__pill" aria-hidden="true">' . esc_html( wp_strip_all_tags( $card['role'] ) ) . '</span>';
		}

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-team-card__photo">%1$s%2$s</div>',
				sprintf(
					'<img loading="lazy" src="%1$s" alt="%2$s">',
					esc_url( $image ),
					esc_attr( iflynepal_team_member_image_alt( $card['index'], $card['name'], $card['role'] ) )
				),
				$pill
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-team-card iflynepal-team-card--member" data-iflynepal-reveal>%1$s<div class="iflynepal-team-card__body"><h3 class="iflynepal-team-card__name">%2$s</h3>%3$s</div></article>',
			$photo,
			iflynepal_kses_text( $card['name'] ),
			'' === $card['role'] ? '' : '<p class="iflynepal-team-card__meta">' . iflynepal_kses_text( $card['role'] ) . '</p>'
		);
	}

	return $markup;
}
