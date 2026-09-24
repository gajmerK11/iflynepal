<?php
/**
 * People section getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * Same shape as the hero, Explore and Why-trust sections: each render callback
 * is also what the template calls, so the pencil-shortcut preview and the
 * shipped page come from the same code.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * People the rail can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/homepage/people/cards.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PEOPLE_CARD_MAX = 10;

/**
 * Default kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PEOPLE_KICKER_DEFAULT = 'People behind the journey';

/**
 * Default heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PEOPLE_TITLE_DEFAULT = 'Know who is responsible for your experience.';

/**
 * Default standfirst under the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_PEOPLE_LEAD_DEFAULT = 'Travellers and retreat guests should see real people before they book.';

/**
 * Default copy and destination for the contact pill.
 *
 * The mockup points this at its planner, which has no counterpart in the theme,
 * so the default lands on the Why-trust section instead — the nearest live
 * equivalent, since that is where the "Plan Your Trip" card sits. It wants
 * repointing at a real contact page once one exists.
 *
 * @since 1.0.0
 *
 * @return array Contact pill defaults.
 */
function iflynepal_people_cta_defaults() {
	return array(
		'label' => __( 'Talk to our team', 'iflynepal' ),
		'note'  => __( 'Kathmandu office · usually replies within a day', 'iflynepal' ),
		'url'   => '#trust',
	);
}

/**
 * Default cards, as the approved mockup has them.
 *
 * No photographs ship with them: these are the client's own colleagues, and a
 * stock portrait standing in for a named person would be a lie rather than a
 * placeholder. A card with no image drawn falls back to a neutral avatar.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_people_card_defaults() {
	return array(
		1 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Prakash', 'iflynepal' ),
			'country' => __( 'USA', 'iflynepal' ),
		),
		2 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Gus', 'iflynepal' ),
			'country' => __( 'UK', 'iflynepal' ),
		),
		3 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Raju', 'iflynepal' ),
			'country' => __( 'France', 'iflynepal' ),
		),
		4 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Vijay', 'iflynepal' ),
			'country' => __( 'Italy', 'iflynepal' ),
		),
		5 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Suraj', 'iflynepal' ),
			'country' => __( 'Australia', 'iflynepal' ),
		),
		6 => array(
			'title'   => __( 'Travel Expert', 'iflynepal' ),
			'name'    => __( 'Ayush', 'iflynepal' ),
			'country' => __( 'Japan', 'iflynepal' ),
		),
	);
}

/**
 * One card's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_people_card_default( $index ) {
	$defaults = iflynepal_people_card_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'   => '',
		'name'    => '',
		'country' => '',
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * Kicker above the heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_people_kicker() {
	$kicker = get_theme_mod( 'iflynepal_people_kicker', IFLYNEPAL_PEOPLE_KICKER_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$kicker = pll__( $kicker );
	}

	return iflynepal_kses_text( $kicker );
}

/**
 * Section heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_people_title() {
	$title = get_theme_mod( 'iflynepal_people_title', IFLYNEPAL_PEOPLE_TITLE_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$title = pll__( $title );
	}

	return iflynepal_kses_text( $title );
}

/**
 * Standfirst under the heading.
 *
 * @since 1.0.0
 *
 * @return string Standfirst HTML.
 */
function iflynepal_people_lead() {
	$lead = get_theme_mod( 'iflynepal_people_lead', IFLYNEPAL_PEOPLE_LEAD_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$lead = pll__( $lead );
	}

	return iflynepal_kses_text( $lead );
}

/**
 * One contact pill field.
 *
 * @since 1.0.0
 *
 * @param string $field One of the keys in iflynepal_people_cta_defaults().
 * @return string Stored value, or the default.
 */
function iflynepal_people_cta_field( $field ) {
	$defaults = iflynepal_people_cta_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';
	$value    = (string) get_theme_mod( 'iflynepal_people_cta_' . $field, $default );

	if ( 'url' !== $field && function_exists( 'pll__' ) ) {
		$value = pll__( $value );
	}

	return $value;
}

/**
 * One card's text field.
 *
 * @since 1.0.0
 *
 * @param int    $index Card number.
 * @param string $field One of 'title', 'name' or 'country'.
 * @return string Stored value, or the default.
 */
function iflynepal_people_card_field( $index, $field ) {
	$default = iflynepal_people_card_default( $index );
	$value   = trim(
		(string) get_theme_mod(
			'iflynepal_people_card_' . $index . '_' . $field,
			isset( $default[ $field ] ) ? $default[ $field ] : ''
		)
	);

	if ( 'name' !== $field && function_exists( 'pll__' ) ) {
		$value = pll__( $value );
	}

	return $value;
}

/**
 * The card numbers with someone in them, in order.
 *
 * Emptying the name is how the Customizer's Remove button deletes a card, so a
 * nameless slot is dropped rather than rendered as an anonymous photograph.
 *
 * @since 1.0.0
 *
 * @return int[] Card numbers.
 */
function iflynepal_people_cards() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_PEOPLE_CARD_MAX; $i++ ) {
		if ( '' !== iflynepal_people_card_field( $i, 'name' ) ) {
			$cards[] = $i;
		}
	}

	return $cards;
}

/**
 * Whether the rail has anyone to show.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_people_has_cards() {
	return (bool) iflynepal_people_cards();
}

/* ------------------------------------------------------------------- media */

/**
 * One card's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when none is set.
 */
function iflynepal_people_card_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_people_card_' . $index . '_image', 0 );

	if ( ! $attachment_id ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $attachment_id, 'large' );

	return $url ? $url : '';
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_people_kicker() {
	return iflynepal_people_kicker();
}

/**
 * Renders the section heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_people_title() {
	return iflynepal_people_title();
}

/**
 * Renders the standfirst.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_people_lead() {
	return iflynepal_people_lead();
}

/**
 * Renders the contact pill.
 *
 * A label emptied in the Customizer removes the pill, the same way an emptied
 * link label removes an Explore card link. The pulsing dot is decorative and is
 * hidden from assistive technology; the note beside the label is not, since it
 * carries the office and the reply time.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_people_cta() {
	$label = trim( iflynepal_people_cta_field( 'label' ) );

	if ( '' === $label ) {
		return '';
	}

	$note = trim( iflynepal_people_cta_field( 'note' ) );

	return sprintf(
		'<a class="iflynepal-people__cta" %1$s>
			<span class="iflynepal-people__cta-icon">
				<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.4 8.6 8.6 0 0 1-3.9-.9L3 20.5l1.6-5A8.4 8.4 0 0 1 12.5 3 8.4 8.4 0 0 1 21 11.5z"/></svg>
				<span class="iflynepal-people__cta-dot" aria-hidden="true"></span>
			</span>
			<span class="iflynepal-people__cta-text"><strong>%2$s</strong>%3$s</span>
			<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
		</a>',
		iflynepal_anchor_attr( iflynepal_people_cta_field( 'url' ) ),
		esc_html( $label ),
		'' === $note ? '' : '<em>' . esc_html( $note ) . '</em>'
	);
}

/**
 * Renders one card's photograph.
 *
 * A card with no image uploaded gets a neutral avatar rather than an empty
 * frame, so the rail keeps its shape while the client's own photographs are
 * still being gathered.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_people_card_photo( $index ) {
	$url = iflynepal_people_card_image_url( $index );

	if ( '' === $url ) {
		return '<span class="iflynepal-people__avatar" aria-hidden="true"><svg viewBox="0 0 40 40" focusable="false"><circle cx="20" cy="16" r="5.5"/><path d="M9.5 32.5c1.6-5 5.6-7.5 10.5-7.5s8.9 2.5 10.5 7.5"/></svg></span>';
	}

	$name    = iflynepal_people_card_field( $index, 'name' );
	$title   = iflynepal_people_card_field( $index, 'title' );
	$country = iflynepal_people_card_field( $index, 'country' );

	/*
	 * The alt text says who the person is and what they do, as the mockup's
	 * does — a bare name would leave a screen reader with no idea why the
	 * photograph is on the page.
	 */
	if ( '' !== $title && '' !== $country ) {
		$alt = sprintf(
			/* translators: 1: person's name, 2: their role, 3: the country they look after. */
			__( '%1$s, %2$s for %3$s', 'iflynepal' ),
			$name,
			$title,
			$country
		);
	} elseif ( '' !== $title ) {
		$alt = sprintf(
			/* translators: 1: person's name, 2: their role. */
			__( '%1$s, %2$s', 'iflynepal' ),
			$name,
			$title
		);
	} else {
		$alt = $name;
	}

	return sprintf(
		'<img class="iflynepal-people__photo-image" src="%1$s" alt="%2$s" loading="lazy" decoding="async">',
		esc_url( $url ),
		esc_attr( $alt )
	);
}

/**
 * Renders one card's name.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_people_card_name( $index ) {
	return esc_html( iflynepal_people_card_field( $index, 'name' ) );
}

/**
 * Renders one card's country.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Markup.
 */
function iflynepal_render_people_card_country( $index ) {
	return esc_html( iflynepal_people_card_field( $index, 'country' ) );
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the People section's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical note
 * on iflynepal_register_authors_pll_strings() in
 * inc/customizer/callbacks/authors.php), so registration can't live inside
 * the getters above — those run on the front end. Card names are not
 * registered: they are people's actual names, not copy to translate.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_people_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	pll_register_string( 'People kicker', get_theme_mod( 'iflynepal_people_kicker', IFLYNEPAL_PEOPLE_KICKER_DEFAULT ), 'iFlyNepal — Homepage / People' );
	pll_register_string( 'People title', get_theme_mod( 'iflynepal_people_title', IFLYNEPAL_PEOPLE_TITLE_DEFAULT ), 'iFlyNepal — Homepage / People', true );
	pll_register_string( 'People lead', get_theme_mod( 'iflynepal_people_lead', IFLYNEPAL_PEOPLE_LEAD_DEFAULT ), 'iFlyNepal — Homepage / People' );

	$cta_defaults = iflynepal_people_cta_defaults();

	pll_register_string( 'People CTA label', get_theme_mod( 'iflynepal_people_cta_label', $cta_defaults['label'] ), 'iFlyNepal — Homepage / People' );
	pll_register_string( 'People CTA note', get_theme_mod( 'iflynepal_people_cta_note', $cta_defaults['note'] ), 'iFlyNepal — Homepage / People' );

	for ( $index = 1; $index <= IFLYNEPAL_PEOPLE_CARD_MAX; $index++ ) {
		$default = iflynepal_people_card_default( $index );

		if ( '' === $default['title'] && '' === $default['country'] ) {
			continue;
		}

		pll_register_string( "People card $index title", get_theme_mod( "iflynepal_people_card_{$index}_title", $default['title'] ), 'iFlyNepal — Homepage / People' );
		pll_register_string( "People card $index country", get_theme_mod( "iflynepal_people_card_{$index}_country", $default['country'] ), 'iFlyNepal — Homepage / People' );
	}
}
add_action( 'admin_init', 'iflynepal_register_people_pll_strings', 15 );
