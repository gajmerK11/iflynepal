<?php
/**
 * FAQ column getters and selective-refresh render callbacks.
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
 * Questions the column can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/homepage/guides/faq-items.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_FAQ_MAX = 10;

/**
 * Default kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_FAQ_KICKER_DEFAULT = 'Planning Nepal';

/**
 * Default heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_FAQ_TITLE_DEFAULT = 'Quick answers before you go.';

/**
 * Default questions and answers, as the approved mockup has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1, each with 'question' and 'answer'.
 */
function iflynepal_faq_defaults() {
	return array(
		1 => array(
			'question' => __( 'What is the best time to visit Nepal?', 'iflynepal' ),
			'answer'   => __( 'The right season depends on what you want to do. Autumn and spring are popular for trekking, while cultural trips, wildlife experiences and retreats can work well across a broader part of the year.', 'iflynepal' ),
		),
		2 => array(
			'question' => __( 'How many days should I spend in Nepal?', 'iflynepal' ),
			'answer'   => __( 'A week can cover a focused city-and-nature trip. Ten to fourteen days gives more room for a major trek, multi-destination tour or a travel-and-retreat combination.', 'iflynepal' ),
		),
		3 => array(
			'question' => __( 'Can I combine a Nepal tour with a retreat?', 'iflynepal' ),
			'answer'   => __( 'Yes. A trip can combine sightseeing or trekking with several quieter days for meditation, yoga or wellness. This is one of the clearest ways for iFly Nepal\'s travel and retreat services to work together.', 'iflynepal' ),
		),
	);
}

/**
 * One question's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Question number.
 * @return array Defaults for that question.
 */
function iflynepal_faq_default( $index ) {
	$defaults = iflynepal_faq_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'question' => '',
		'answer'   => '',
	);
}

/**
 * Default label and destination for the link under the questions.
 *
 * The mockup points this at its planner, which has no counterpart in the theme,
 * so it lands on the section that holds the nearest live equivalent.
 *
 * @since 1.0.0
 *
 * @return array Link defaults.
 */
function iflynepal_faq_cta_defaults() {
	return array(
		'label' => __( 'Still have a question? Ask the Kathmandu team', 'iflynepal' ),
		'url'   => '#people',
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
function iflynepal_faq_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_faq_kicker', IFLYNEPAL_FAQ_KICKER_DEFAULT ) );
}

/**
 * Column heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_faq_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_faq_title', IFLYNEPAL_FAQ_TITLE_DEFAULT ) );
}

/**
 * One link field.
 *
 * @since 1.0.0
 *
 * @param string $field Either 'label' or 'url'.
 * @return string Stored value, or the default.
 */
function iflynepal_faq_cta_field( $field ) {
	$defaults = iflynepal_faq_cta_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_faq_cta_' . $field, $default );
}

/**
 * The questions with something in them, in order.
 *
 * Emptying a question is how the Customizer's Remove button deletes it, so a
 * questionless slot is dropped rather than rendered as a bare answer.
 *
 * @since 1.0.0
 *
 * @return array[] Items, each with 'index', 'question' and 'answer'.
 */
function iflynepal_faq_items() {
	$items = array();

	for ( $i = 1; $i <= IFLYNEPAL_FAQ_MAX; $i++ ) {
		$default  = iflynepal_faq_default( $i );
		$question = trim( (string) get_theme_mod( 'iflynepal_faq_' . $i . '_question', $default['question'] ) );

		if ( '' === $question ) {
			continue;
		}

		$items[] = array(
			'index'    => $i,
			'question' => $question,
			'answer'   => (string) get_theme_mod( 'iflynepal_faq_' . $i . '_answer', $default['answer'] ),
		);
	}

	return $items;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_faq_kicker() {
	return iflynepal_faq_kicker();
}

/**
 * Renders the column heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_faq_title() {
	return iflynepal_faq_title();
}

/**
 * Renders the whole list of questions.
 *
 * One partial for the list rather than one per question: emptying a question
 * removes it, which changes how many there are, and a per-question partial
 * would leave an empty row standing where it had been.
 *
 * The first question is open on load, as the mockup has it.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_faq_items() {
	$markup = '';
	$number = 0;

	foreach ( iflynepal_faq_items() as $item ) {
		++$number;

		$answer_id = 'iflynepal-faq-answer-' . $item['index'];
		$is_open   = 1 === $number;

		$markup .= sprintf(
			'<article class="iflynepal-guides__faq-item%1$s">
				<button class="iflynepal-guides__faq-question" type="button" aria-expanded="%2$s" aria-controls="%3$s">
					<span>%4$s</span>
					<span class="iflynepal-guides__faq-mark"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5.2v13.6M5.2 12h13.6"/></svg></span>
				</button>
				<div class="iflynepal-guides__faq-answer" id="%3$s">%5$s</div>
			</article>',
			$is_open ? ' is-open' : '',
			$is_open ? 'true' : 'false',
			esc_attr( $answer_id ),
			esc_html( $item['question'] ),
			iflynepal_kses_text( $item['answer'] )
		);
	}

	return $markup;
}

/**
 * Renders the link under the questions.
 *
 * A label emptied in the Customizer removes the link.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_faq_cta() {
	$label = trim( iflynepal_faq_cta_field( 'label' ) );

	if ( '' === $label ) {
		return '';
	}

	return sprintf(
		'<a class="iflynepal-guides__link" href="%1$s">%2$s<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>',
		esc_url( iflynepal_faq_cta_field( 'url' ) ),
		esc_html( $label )
	);
}
