<?php
/**
 * Executive Team getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The roster closes the About page template (template-parts/team/executive-section.php)
 * and is edited in Appearance > Customize > About > Company. The `team` naming
 * is from when the Team page carried it; it is kept so the theme mods saved
 * under these setting IDs stay valid.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cards the Executive Team roster can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/team/repeaters.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TEAM_MEMBER_MAX = 20;

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
	$title = get_theme_mod( 'iflynepal_team_executive_title', IFLYNEPAL_TEAM_EXECUTIVE_TITLE_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$title = pll__( $title );
	}

	return iflynepal_kses_text( $title );
}

/**
 * Executive Team sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_team_executive_lead() {
	$lead = get_theme_mod( 'iflynepal_team_executive_lead', IFLYNEPAL_TEAM_EXECUTIVE_LEAD_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$lead = pll__( $lead );
	}

	return iflynepal_kses_text( $lead );
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

/* ---------------------------------------------------------- translations */

/**
 * Registers the Executive Team's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical note
 * on iflynepal_register_authors_pll_strings() in
 * inc/customizer/callbacks/authors.php), so registration can't live inside
 * the getters above — those run on the front end.
 *
 * Every card's name is left unregistered: they are real people's names, not
 * text to translate. Role text is registered elsewhere already, via the
 * ordinary __() calls in the card defaults above.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_team_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$group = 'iFlyNepal — About / Team';

	pll_register_string( 'Team executive title', get_theme_mod( 'iflynepal_team_executive_title', IFLYNEPAL_TEAM_EXECUTIVE_TITLE_DEFAULT ), $group );
	pll_register_string( 'Team executive lead', get_theme_mod( 'iflynepal_team_executive_lead', IFLYNEPAL_TEAM_EXECUTIVE_LEAD_DEFAULT ), $group );
}
add_action( 'admin_init', 'iflynepal_register_team_pll_strings', 22 );
