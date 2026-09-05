<?php
/**
 * About page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Buttons the hero carries.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_HERO_BUTTONS = 2;

/**
 * Paragraphs the Overview column can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/about/story.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_STORY_MAX = 8;

/**
 * Rows the What We Offer list can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/about/offers.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OFFER_MAX = 10;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero headline.
 *
 * `em` marks the word that takes the gold accent, the same as the front page's
 * headline — `<span class="hero-text-style">` does the same thing and is
 * accepted here too. The full stop sits outside the accent, as the design has
 * it.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_HERO_TITLE_DEFAULT = 'More than just a travel <em>company</em>.';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_HERO_LEAD_DEFAULT = 'Locally owned and deeply rooted in Nepali culture, our team understands the soul of this land&mdash;and we want you to feel it too.';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * The hero is a photograph under a scrim, so it needs an image to be the thing
 * the design describes at all. This is the frame the approved design ships.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_HERO_IMAGE_DEFAULT = 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=2200&q=88';

/**
 * Default label and destination for each hero button.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1, each with 'label' and 'url'.
 */
function iflynepal_about_hero_button_defaults() {
	return array(
		1 => array(
			'label' => __( 'What we offer', 'iflynepal' ),
			'url'   => '#offer',
		),
		2 => array(
			'label' => __( 'Talk to our team', 'iflynepal' ),
			'url'   => 'https://wa.me/9841771010',
		),
	);
}

/**
 * Hero headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_about_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_hero_title', IFLYNEPAL_ABOUT_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_about_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_hero_lead', IFLYNEPAL_ABOUT_HERO_LEAD_DEFAULT ) );
}

/**
 * One hero button's label and link.
 *
 * @since 1.0.0
 *
 * @param int $index Button number, 1 or 2.
 * @return array{label: string, url: string} Label and link. Label is empty when the button is off.
 */
function iflynepal_about_hero_button( $index ) {
	$defaults = iflynepal_about_hero_button_defaults();
	$default  = isset( $defaults[ $index ] ) ? $defaults[ $index ] : array(
		'label' => '',
		'url'   => '',
	);

	return array(
		'label' => (string) get_theme_mod( 'iflynepal_about_hero_button_' . $index . '_label', $default['label'] ),
		'url'   => (string) get_theme_mod( 'iflynepal_about_hero_button_' . $index . '_url', $default['url'] ),
	);
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the design's stand-in.
 */
function iflynepal_about_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_about_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_ABOUT_HERO_IMAGE_DEFAULT;
}

/* --------------------------------------------------------------- overview */

/**
 * Default kicker above the Overview heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OVERVIEW_KICKER_DEFAULT = 'About iFly Nepal';

/**
 * Default Overview heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OVERVIEW_TITLE_DEFAULT = 'Overview';

/**
 * Default Overview paragraphs, as the approved design has them.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_about_story_defaults() {
	return array(
		1 => __( 'Founded in 2021 in the vibrant city of Kathmandu, iFly Nepal is more than just a travel company&mdash;we are a collective of explorers, storytellers, and community advocates dedicated to creating travel experiences that leave lasting impressions. Locally owned and deeply rooted in Nepali culture, our team understands the soul of this land&mdash;and we want you to feel it too.', 'iflynepal' ),
		2 => __( 'At iFly Nepal, we believe travel should be more than just ticking destinations off a list. It should inspire, connect, and empower. Whether you&rsquo;re trekking through the world&rsquo;s tallest mountains, meditating in a remote monastery, sharing a meal with a village family, or joining a cultural dance workshop, we want you to experience Nepal, not just see it.', 'iflynepal' ),
		3 => __( 'We serve a wide spectrum of travelers&mdash;adventure seekers, wellness enthusiasts, volunteers, cultural explorers, and first-time visitors&mdash;offering both set itineraries and fully customized journeys across Nepal and beyond. Our approach is grounded in authenticity, sustainability, and human connection.', 'iflynepal' ),
	);
}

/**
 * One paragraph's default, with an empty fallback for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Paragraph number.
 * @return string Default text.
 */
function iflynepal_about_story_default( $index ) {
	$defaults = iflynepal_about_story_defaults();

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : '';
}

/**
 * Kicker above the Overview heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_about_overview_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_overview_kicker', IFLYNEPAL_ABOUT_OVERVIEW_KICKER_DEFAULT ) );
}

/**
 * Overview heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_about_overview_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_overview_title', IFLYNEPAL_ABOUT_OVERVIEW_TITLE_DEFAULT ) );
}

/**
 * The Overview paragraphs that have text, in order.
 *
 * Emptying a paragraph is how the Customizer's Remove button deletes it, so an
 * empty slot is skipped rather than rendered as a blank line.
 *
 * @since 1.0.0
 *
 * @return string[] Paragraph HTML.
 */
function iflynepal_about_story_paragraphs() {
	$paragraphs = array();

	for ( $i = 1; $i <= IFLYNEPAL_ABOUT_STORY_MAX; $i++ ) {
		$value = trim( (string) get_theme_mod( 'iflynepal_about_story_' . $i, iflynepal_about_story_default( $i ) ) );

		if ( '' === $value ) {
			continue;
		}

		$paragraphs[] = $value;
	}

	return $paragraphs;
}

/* ------------------------------------------------------------ promo card */

/**
 * Stand-in photograph for the promo card.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_PROMO_IMAGE_DEFAULT = 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?auto=format&fit=crop&w=1200&q=85';

/**
 * Default copy for the card beside the Overview text.
 *
 * @since 1.0.0
 *
 * @return array Card defaults.
 */
function iflynepal_about_promo_defaults() {
	return array(
		'kicker'       => __( 'Start planning', 'iflynepal' ),
		'title'        => __( 'Tell us how you want to travel', 'iflynepal' ),
		'description'  => __( 'Talk to a Kathmandu-based expert and shape a trek, tour, retreat or volunteer placement around you.', 'iflynepal' ),
		'button_label' => __( 'Plan Your Trip', 'iflynepal' ),
		'button_url'   => 'https://wa.me/9841771010',
		'image_alt'    => __( 'A traveller looking out over the Himalaya in Nepal', 'iflynepal' ),
	);
}

/**
 * One promo card field.
 *
 * @since 1.0.0
 *
 * @param string $field Field key.
 * @return string Stored value, or the default.
 */
function iflynepal_about_promo_field( $field ) {
	$defaults = iflynepal_about_promo_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_about_promo_' . $field, $default );
}

/**
 * Promo card photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the design's stand-in.
 */
function iflynepal_about_promo_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_about_promo_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_ABOUT_PROMO_IMAGE_DEFAULT;
}

/**
 * Promo card photograph alt text.
 *
 * An uploaded image brings its own description from the media library; the
 * stand-in falls back to the one the design ships. The card's own copy never
 * says what the picture shows, so it is not decorative.
 *
 * @since 1.0.0
 *
 * @return string Alt text.
 */
function iflynepal_about_promo_image_alt() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_about_promo_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$defaults = iflynepal_about_promo_defaults();

	return $defaults['image_alt'];
}

/* ------------------------------------------------------------------ vision */

/**
 * Default kicker over the vision statement.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_VISION_TITLE_DEFAULT = 'Our Vision';

/**
 * Default vision statement.
 *
 * `accent` is the class an editor puts on a span to give a phrase the gold
 * treatment inside the navy panel.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_VISION_CONTENT_DEFAULT = 'To redefine the way people experience Nepal and its neighboring regions by offering thoughtful, inclusive, and responsible travel opportunities that empower local communities and honor <span class="accent">cultural integrity</span>.';

/**
 * Kicker over the vision statement.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_about_vision_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_vision_title', IFLYNEPAL_ABOUT_VISION_TITLE_DEFAULT ) );
}

/**
 * The vision statement itself.
 *
 * @since 1.0.0
 *
 * @return string Statement HTML.
 */
function iflynepal_about_vision_content() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_vision_content', IFLYNEPAL_ABOUT_VISION_CONTENT_DEFAULT ) );
}

/* ------------------------------------------------------------------ offers */

/**
 * Default kicker above the What We Offer heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OFFER_KICKER_DEFAULT = 'What We Offer';

/**
 * Default What We Offer heading, with the inked underline on one word.
 *
 * `underline` is the class an editor puts on a span to mark a word, the same
 * one the Explore and CTA headings use.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OFFER_TITLE_DEFAULT = 'Six ways we put a <span class="underline">journey</span> together';

/**
 * Default lead under the What We Offer heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ABOUT_OFFER_LEAD_DEFAULT = 'Set itineraries and fully customized journeys, across Nepal and beyond.';

/**
 * Default rows, as the approved design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_about_offer_defaults() {
	return array(
		1 => array(
			'number'      => '01',
			'title'       => __( 'Tailored Tours &amp; Cultural Journeys', 'iflynepal' ),
			'description' => __( 'We design travel experiences that reflect your interests and pace&mdash;from spiritual pilgrimages in Lumbini to cultural circuits in the Kathmandu Valley, jungle safaris in Chitwan to sunrise views over the Annapurna range', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'Heritage architecture in the Kathmandu Valley', 'iflynepal' ),
		),
		2 => array(
			'number'      => '02',
			'title'       => __( 'Trekking &amp; Adventure Travel', 'iflynepal' ),
			'description' => __( 'Explore the iconic trails of Everest, Annapurna, and Langtang, or venture into the remote corners of Mustang, Dolpo, or Kanchenjunga. Our experienced, licensed guides&mdash;including female trekking leaders&mdash;prioritize your safety, comfort, and connection with nature.', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'Trekkers on a Himalayan trail in Nepal', 'iflynepal' ),
		),
		3 => array(
			'number'      => '03',
			'title'       => __( 'Wellness &amp; Retreats', 'iflynepal' ),
			'description' => __( 'We organize mindfulness and wellness retreats in serene locations&mdash;like yoga in Pokhara, monastery stays in the hills of Solu, or shamanic healing journeys in western Nepal. Our retreats are ideal for those looking to reconnect with themselves and the natural world.', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'A quiet wellness and meditation setting in Nepal', 'iflynepal' ),
		),
		4 => array(
			'number'      => '04',
			'title'       => __( 'Volunteering &amp; Community Engagement', 'iflynepal' ),
			'description' => __( 'From teaching in rural schools to working on permaculture farms or shadowing in local clinics, we offer meaningful placements for travelers who want to give back. Our volunteer programs are thoughtfully developed with community needs in mind.', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'A community gathering outdoors in rural Nepal', 'iflynepal' ),
		),
		5 => array(
			'number'      => '05',
			'title'       => __( 'Cultural Workshops &amp; Experiences', 'iflynepal' ),
			'description' => __( 'Roll momos with a local chef, learn traditional Thangka painting, try your hand at wood carving, or join in a vibrant local festival. These moments often become the most cherished parts of the journey.', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'Festival lamps during a Nepali celebration', 'iflynepal' ),
		),
		6 => array(
			'number'      => '06',
			'title'       => __( 'Travel Services &amp; Logistics', 'iflynepal' ),
			'description' => __( 'We offer a full suite of travel support&mdash;from domestic and international air ticketing, hotel bookings, and vehicle rentals to visa assistance, insurance coordination, and emergency heli-rescue services. We also support outbound travel for Nepali travelers looking to explore international destinations.', 'iflynepal' ),
			'image'       => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=84',
			'image_alt'   => __( 'The Himalaya beneath a clear Nepal sky', 'iflynepal' ),
		),
	);
}

/**
 * One row's defaults, with empty fallbacks for an index that has none.
 *
 * The numeral still gets a value past the six the design ships, so a row added
 * in the Customizer is numbered rather than blank.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return array Defaults for that row.
 */
function iflynepal_about_offer_default( $index ) {
	$defaults = iflynepal_about_offer_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'number'      => str_pad( (string) $index, 2, '0', STR_PAD_LEFT ),
		'title'       => '',
		'description' => '',
		'image'       => '',
		'image_alt'   => '',
	);
}

/**
 * Kicker above the What We Offer heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_about_offer_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_offer_kicker', IFLYNEPAL_ABOUT_OFFER_KICKER_DEFAULT ) );
}

/**
 * What We Offer heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_about_offer_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_offer_title', IFLYNEPAL_ABOUT_OFFER_TITLE_DEFAULT ) );
}

/**
 * Lead under the What We Offer heading.
 *
 * @since 1.0.0
 *
 * @return string Lead HTML.
 */
function iflynepal_about_offer_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_about_offer_lead', IFLYNEPAL_ABOUT_OFFER_LEAD_DEFAULT ) );
}

/**
 * One row's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_about_offer_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_about_offer_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_about_offer_default( $index );

	return $default['image'];
}

/**
 * One row's photograph alt text.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return string Alt text.
 */
function iflynepal_about_offer_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_about_offer_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_about_offer_default( $index );

	return $default['image_alt'];
}

/**
 * The rows that have a title, in order.
 *
 * Emptying a title is how the Customizer's Remove button deletes a row, so a
 * titleless slot is dropped rather than rendered as a numbered blank.
 *
 * @since 1.0.0
 *
 * @return array[] Rows, each with 'index', 'number', 'title' and 'description'.
 */
function iflynepal_about_offers() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_ABOUT_OFFER_MAX; $i++ ) {
		$default = iflynepal_about_offer_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_about_offer_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'number'      => (string) get_theme_mod( 'iflynepal_about_offer_' . $i . '_number', $default['number'] ),
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_about_offer_' . $i . '_description', $default['description'] ),
		);
	}

	return $rows;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the hero headline.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_hero_title() {
	return iflynepal_about_hero_title();
}

/**
 * Renders the hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_hero_lead() {
	return iflynepal_about_hero_lead();
}

/**
 * Renders both hero buttons, skipping either one whose label has been emptied.
 *
 * The blue action leads and the outlined one follows, as the design has it.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_hero_actions() {
	$modifiers = array(
		1 => 'iflynepal-btn--primary',
		2 => 'iflynepal-btn--ghost',
	);

	$markup = '';

	foreach ( $modifiers as $index => $modifier ) {
		$button = iflynepal_about_hero_button( $index );

		if ( '' === trim( $button['label'] ) ) {
			continue;
		}

		$markup .= sprintf(
			'<div class="wp-block-button %1$s"><a class="wp-block-button__link wp-element-button" href="%2$s">%3$s</a></div>',
			esc_attr( $modifier ),
			esc_url( $button['url'] ),
			esc_html( $button['label'] )
		);
	}

	return $markup;
}

/**
 * Renders the Overview kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_overview_kicker() {
	return iflynepal_about_overview_kicker();
}

/**
 * Renders the Overview heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_overview_title() {
	return iflynepal_about_overview_title();
}

/**
 * Renders the whole Overview column.
 *
 * One partial for the column rather than one per paragraph: emptying a
 * paragraph removes it, which changes how many there are, and a per-paragraph
 * partial would leave an empty block standing where it had been.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_story() {
	$markup = '';

	foreach ( iflynepal_about_story_paragraphs() as $paragraph ) {
		$markup .= '<p>' . iflynepal_kses_text( $paragraph ) . '</p>';
	}

	return $markup;
}

/**
 * Renders the promo card's kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_promo_kicker() {
	return esc_html( iflynepal_about_promo_field( 'kicker' ) );
}

/**
 * Renders the promo card's title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_promo_title() {
	return iflynepal_kses_text( iflynepal_about_promo_field( 'title' ) );
}

/**
 * Renders the promo card's description.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_promo_description() {
	return iflynepal_kses_text( iflynepal_about_promo_field( 'description' ) );
}

/**
 * Renders the promo card's button.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_promo_button() {
	$label = trim( iflynepal_about_promo_field( 'button_label' ) );

	if ( '' === $label ) {
		return '';
	}

	return sprintf(
		'<a class="iflynepal-button iflynepal-button--light iflynepal-trust__promo-button" href="%1$s">%2$s<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>',
		esc_url( iflynepal_about_promo_field( 'button_url' ) ),
		esc_html( $label )
	);
}

/**
 * Renders the vision kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_vision_title() {
	return iflynepal_about_vision_title();
}

/**
 * Renders the vision statement.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_vision_content() {
	return iflynepal_about_vision_content();
}

/**
 * Renders the What We Offer kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_offer_kicker() {
	return iflynepal_about_offer_kicker();
}

/**
 * Renders the What We Offer heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_offer_title() {
	return iflynepal_about_offer_title();
}

/**
 * Renders the What We Offer lead.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_offer_lead() {
	return iflynepal_about_offer_lead();
}

/**
 * Renders the whole list of offer rows.
 *
 * One partial for the list rather than one per row: the rows alternate sides
 * off their position in the list, so removing one re-sides every row after it.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_about_offers() {
	$markup = '';

	foreach ( iflynepal_about_offers() as $row ) {
		$image  = iflynepal_about_offer_image_url( $row['index'] );
		$photo  = '';
		$number = trim( $row['number'] );

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-about-offer__photo"><img loading="lazy" src="%1$s" alt="%2$s"></div>',
				esc_url( $image ),
				esc_attr( iflynepal_about_offer_image_alt( $row['index'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-about-offer" data-iflynepal-reveal>%1$s<div class="iflynepal-about-offer__copy">%2$s<h3 class="iflynepal-about-offer__title">%3$s</h3><p class="iflynepal-about-offer__desc">%4$s</p></div></article>',
			$photo,
			'' === $number ? '' : '<span class="iflynepal-about-offer__num">' . esc_html( $number ) . '</span>',
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}
