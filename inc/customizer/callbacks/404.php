<?php
/**
 * Not Found page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The page is one section: the kicker, the headline, a line of copy, two
 * actions, and a short set of signposts to the places a lost visitor was most
 * likely heading. Everything on it is copy — there is no query behind a 404, so
 * nothing here reads a post, and the numeral beside the copy is drawn in the
 * stylesheet rather than uploaded.
 *
 * Nothing invents a second home page link either: the primary action is
 * home_url() rather than a stored URL, because a home page that has to be typed
 * into the Customizer is a home page that breaks when the site moves domain.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Signposts the section can carry.
 *
 * A fixed count rather than an add/remove list: three is the whole of the
 * design, and a 404 with eleven suggestions on it is a second navigation menu
 * rather than a way out. Emptying a label drops that signpost, which is the
 * same escape hatch the CTA buttons use.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_LINKS = 3;

/* ------------------------------------------------------------------- copy */

/**
 * Default kicker.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_KICKER_DEFAULT = '404 error';

/**
 * Default headline.
 *
 * `span class="underline"` draws the hand-inked mark the rest of the site's
 * headings use, so the one heading on an otherwise bare page still reads as
 * this site's.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_TITLE_DEFAULT = 'Looks like you have wandered <span class="underline">off the map</span>.';

/**
 * Default line of copy under the headline.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_LEAD_DEFAULT = 'The page you are after has moved, been renamed, or never existed. Nothing is lost — here is the way back.';

/* ---------------------------------------------------------------- actions */

/**
 * Default label on the primary action.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_HOME_LABEL_DEFAULT = 'Take me home';

/**
 * Default label on the secondary action.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_404_BACK_LABEL_DEFAULT = 'Go back';

/* -------------------------------------------------------------- signposts */

/**
 * One signpost's defaults.
 *
 * Relative paths rather than absolute URLs, so they survive the move from
 * staging to the live domain without being re-typed.
 *
 * @since 1.0.0
 *
 * @param int $index Signpost number.
 * @return array{label:string,url:string,description:string} Defaults for that signpost.
 */
function iflynepal_404_link_default( $index ) {
	$defaults = array(
		1 => array(
			'label'       => 'Browse our journeys',
			'url'         => '/packages/',
			'description' => 'Every trip currently on offer, from day hikes to the long routes.',
		),
		2 => array(
			'label'       => 'Read the travel guides',
			'url'         => '/articles/',
			'description' => 'Route notes, packing lists and stories from the trail.',
		),
		3 => array(
			'label'       => 'Talk to our team',
			'url'         => '/contact-us/',
			'description' => 'Tell us what you were looking for and we will find it.',
		),
	);

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : array(
		'label'       => '',
		'url'         => '',
		'description' => '',
	);
}

/**
 * Kicker.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_404_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_404_kicker', IFLYNEPAL_404_KICKER_DEFAULT ) );
}

/**
 * Headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_404_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_404_title', IFLYNEPAL_404_TITLE_DEFAULT ) );
}

/**
 * Line of copy under the headline.
 *
 * @since 1.0.0
 *
 * @return string Copy HTML.
 */
function iflynepal_404_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_404_lead', IFLYNEPAL_404_LEAD_DEFAULT ) );
}

/**
 * Label on the primary action.
 *
 * @since 1.0.0
 *
 * @return string Label, empty when the button has been removed.
 */
function iflynepal_404_home_label() {
	return (string) get_theme_mod( 'iflynepal_404_home_label', IFLYNEPAL_404_HOME_LABEL_DEFAULT );
}

/**
 * Label on the secondary action.
 *
 * @since 1.0.0
 *
 * @return string Label, empty when the button has been removed.
 */
function iflynepal_404_back_label() {
	return (string) get_theme_mod( 'iflynepal_404_back_label', IFLYNEPAL_404_BACK_LABEL_DEFAULT );
}

/**
 * One signpost.
 *
 * @since 1.0.0
 *
 * @param int $index Signpost number.
 * @return array{label:string,url:string,description:string} The stored signpost.
 */
function iflynepal_404_link( $index ) {
	$default = iflynepal_404_link_default( $index );

	return array(
		'label'       => (string) get_theme_mod( 'iflynepal_404_link_' . $index . '_label', $default['label'] ),
		'url'         => iflynepal_sanitize_link( get_theme_mod( 'iflynepal_404_link_' . $index . '_url', $default['url'] ) ),
		'description' => (string) get_theme_mod( 'iflynepal_404_link_' . $index . '_description', $default['description'] ),
	);
}

/**
 * The signposts that have a label on them, in order.
 *
 * @since 1.0.0
 *
 * @return array<int,array{label:string,url:string,description:string}> Signposts in use.
 */
function iflynepal_404_links() {
	$links = array();

	for ( $index = 1; $index <= IFLYNEPAL_404_LINKS; $index++ ) {
		$link = iflynepal_404_link( $index );

		if ( '' === trim( $link['label'] ) ) {
			continue;
		}

		$links[] = $link;
	}

	return $links;
}

/* --------------------------------------------------------------- partials */

/**
 * Renders the kicker for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_render_404_kicker() {
	return iflynepal_404_kicker();
}

/**
 * Renders the headline for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_render_404_title() {
	return iflynepal_404_title();
}

/**
 * Renders the line of copy for selective refresh.
 *
 * @since 1.0.0
 *
 * @return string Copy HTML.
 */
function iflynepal_render_404_lead() {
	return iflynepal_404_lead();
}

/**
 * Renders both actions.
 *
 * The secondary is a button rather than a link because it steps the browser's
 * own history back, and it shows only when scripting is on — a dead "Go back"
 * is worse than no "Go back" on the one page a visitor is already confused by.
 * It is hidden by a stylesheet rule and revealed by a class
 * assets/js/not-found/actions.js puts on the document element, rather than by
 * an attribute on the button itself: the Customizer re-renders this markup on
 * every keystroke, and a state kept on the button would be lost each time.
 *
 * @since 1.0.0
 *
 * @return string Actions HTML.
 */
function iflynepal_render_404_actions() {
	$markup = '';

	$back = trim( iflynepal_404_back_label() );

	if ( '' !== $back ) {
		$markup .= sprintf(
			'<button type="button" class="iflynepal-button iflynepal-button--line iflynepal-404__back" data-iflynepal-history-back>%s</button>',
			esc_html( $back )
		);
	}

	$home = trim( iflynepal_404_home_label() );

	if ( '' !== $home ) {
		$markup .= sprintf(
			'<a class="iflynepal-button iflynepal-button--gold" %1$s>%2$s</a>',
			iflynepal_anchor_attr( home_url( '/' ) ),
			esc_html( $home )
		);
	}

	return $markup;
}

/**
 * Renders the signposts.
 *
 * @since 1.0.0
 *
 * @return string Signposts HTML.
 */
function iflynepal_render_404_links() {
	$markup = '';

	foreach ( iflynepal_404_links() as $link ) {
		$description = trim( $link['description'] );

		$markup .= sprintf(
			'<li class="iflynepal-404__link"><a class="iflynepal-404__link-label" %1$s>%2$s</a>%3$s</li>',
			iflynepal_anchor_attr( $link['url'] ? $link['url'] : home_url( '/' ) ),
			esc_html( $link['label'] ),
			'' === $description
				? ''
				: sprintf( '<p class="iflynepal-404__link-desc">%s</p>', esc_html( $description ) )
		);
	}

	return $markup;
}
