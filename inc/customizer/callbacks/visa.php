<?php
/**
 * Visa Services page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The page is eight sections down one column: the hero, the three things the
 * office handles, the visa categories, the destinations grid, the step-by-step
 * process, the packages, the fee notice and the closing invitation. Five of
 * those are add/remove lists and the rest are fixed copy.
 *
 * Nothing here invents a second place to keep the office's phone number, email
 * or address — the closing band reads them from the Contact Us settings through
 * iflynepal_contact_plain(), which is the one place they are typed. A visa page
 * with its own copy of the number is a number that goes stale the day the
 * office moves.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Items the "what we handle" row can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/visa/repeaters.js through inc/customizer/customizer.php.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_SERVICE_MAX = 6;

/**
 * Cards the visa-categories grid can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_TYPE_MAX = 8;

/**
 * Cells the destinations grid can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_DESTINATION_MAX = 16;

/**
 * Steps the process list can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_STEP_MAX = 10;

/**
 * Packages the pricing row can carry.
 *
 * Three rather than the two the design ships with, so a third tier can be added
 * without a code change. The row is a grid that counts its own children, so it
 * lays out at two or at three without being told which.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_PACKAGE_MAX = 3;

/**
 * How many buttons the hero carries.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_BUTTONS = 2;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero kicker.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_KICKER_DEFAULT = 'Visa Services';

/**
 * Default hero headline.
 *
 * `em` marks the words that take the serif accent, the same as every other hero
 * on the site.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_TITLE_DEFAULT = 'Visa help from people who actually read the <em>fine print</em>.';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_LEAD_DEFAULT = 'A visa application is only as strong as its weakest document. Our visa team fills out your forms, checks every paper in your file, and gets you to your appointment prepared — so nothing gets left out and nothing gets rushed.';

/**
 * Default label on the hero's primary button.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_BUTTON_1_LABEL_DEFAULT = 'See our packages';

/**
 * Default link on the hero's primary button.
 *
 * An on-page anchor rather than a URL: the packages are further down this same
 * page, and iflynepal_sanitize_link() is the sanitizer that lets a `#` through.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_BUTTON_1_URL_DEFAULT = '#visa-packages';

/**
 * Default label on the hero's secondary button.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_BUTTON_2_LABEL_DEFAULT = 'Ask a question';

/**
 * Default link on the hero's secondary button.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_HERO_BUTTON_2_URL_DEFAULT = '#visa-contact';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * An image the theme already ships rather than one named for this page, which
 * would 404 until somebody produced it — and a hero whose photograph 404s is a
 * flat navy band with no sign of what is wrong. The About hero is the widest
 * frame in the theme at 2200px, so it holds up at the sizes this section is
 * shown at.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_VISA_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/about/hero-more-than-a-travel-company.jpg' );

/**
 * Hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_hero_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_hero_kicker', IFLYNEPAL_VISA_HERO_KICKER_DEFAULT ) );
}

/**
 * Hero headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_visa_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_hero_title', IFLYNEPAL_VISA_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_visa_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_hero_lead', IFLYNEPAL_VISA_HERO_LEAD_DEFAULT ) );
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the stand-in.
 */
function iflynepal_visa_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_visa_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_VISA_HERO_IMAGE_DEFAULT;
}

/**
 * One hero button's defaults.
 *
 * @since 1.0.0
 *
 * @param int $index Button number.
 * @return array{label:string,url:string} Defaults for that button.
 */
function iflynepal_visa_hero_button_default( $index ) {
	$defaults = array(
		1 => array(
			'label' => IFLYNEPAL_VISA_HERO_BUTTON_1_LABEL_DEFAULT,
			'url'   => IFLYNEPAL_VISA_HERO_BUTTON_1_URL_DEFAULT,
		),
		2 => array(
			'label' => IFLYNEPAL_VISA_HERO_BUTTON_2_LABEL_DEFAULT,
			'url'   => IFLYNEPAL_VISA_HERO_BUTTON_2_URL_DEFAULT,
		),
	);

	return isset( $defaults[ $index ] ) ? $defaults[ $index ] : array(
		'label' => '',
		'url'   => '',
	);
}

/**
 * One hero button.
 *
 * @since 1.0.0
 *
 * @param int $index Button number.
 * @return array{label:string,url:string} The button, label empty when unused.
 */
function iflynepal_visa_hero_button( $index ) {
	$default = iflynepal_visa_hero_button_default( $index );

	return array(
		'label' => (string) get_theme_mod( 'iflynepal_visa_hero_button_' . $index . '_label', $default['label'] ),
		'url'   => iflynepal_sanitize_link( iflynepal_customizer_get_link( 'iflynepal_visa_hero_button_' . $index . '_url', $default['url'] ) ),
	);
}

/* --------------------------------------------------------------- services */

/**
 * Default kicker above the services heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_SERVICES_KICKER_DEFAULT = 'What we handle for you';

/**
 * Default services heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_SERVICES_TITLE_DEFAULT = 'Three things stand between you and a clean application';

/**
 * Default services, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_visa_service_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Visa Counseling', 'iflynepal' ),
			'description' => __( 'Before you fill out a single form, we sit down with you to understand where you are travelling, why, and what that embassy expects. You leave knowing exactly which visa fits your situation.', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Document Preparation &amp; Review', 'iflynepal' ),
			'description' => __( 'We check every paper in your file on its own: bank statements, sponsor letters, travel history. If something looks weak or inconsistent, we tell you before the embassy does.', 'iflynepal' ),
		),
		3 => array(
			'title'       => __( 'Visa Appointment', 'iflynepal' ),
			'description' => __( 'From booking your biometrics slot to preparing you for a consular interview, we help you walk in ready and walk out with a clean application on record.', 'iflynepal' ),
		),
	);
}

/**
 * One service's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Service number.
 * @return array{title:string,description:string} Defaults for that service.
 */
function iflynepal_visa_service_default( $index ) {
	$defaults = iflynepal_visa_service_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
	);
}

/**
 * Kicker above the services heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_services_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_services_kicker', IFLYNEPAL_VISA_SERVICES_KICKER_DEFAULT ) );
}

/**
 * Services heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_visa_services_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_services_title', IFLYNEPAL_VISA_SERVICES_TITLE_DEFAULT ) );
}

/**
 * Whether the services section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_services() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_services_title() ) );
}

/**
 * The services that have a title, in order, each carrying its slot number.
 *
 * The numeral printed beside a service is its position in this list, not its
 * slot number, so removing the second of three renumbers the third to 02 rather
 * than leaving a gap. Counted in the renderer, which is where position is
 * known.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'index', 'title' and 'description'.
 */
function iflynepal_visa_services() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_VISA_SERVICE_MAX; $i++ ) {
		$default = iflynepal_visa_service_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_visa_service_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_visa_service_' . $i . '_description', $default['description'] ),
		);
	}

	return $rows;
}

/* ------------------------------------------------------------- categories */

/**
 * Default kicker above the categories heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_TYPES_KICKER_DEFAULT = 'Visa categories we handle';

/**
 * Default categories heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_TYPES_TITLE_DEFAULT = 'Whatever the reason for your trip, there is a visa type for it';

/**
 * Default visa categories, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_visa_type_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Tourist &amp; Visit Visa', 'iflynepal' ),
			'description' => __( 'For holidays, sightseeing, and short family visits abroad.', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Business Visa', 'iflynepal' ),
			'description' => __( 'For meetings, conferences, and short-term work trips.', 'iflynepal' ),
		),
		3 => array(
			'title'       => __( 'Spouse &amp; Partner Visa', 'iflynepal' ),
			'description' => __( 'For joining a husband, wife, or partner already settled overseas.', 'iflynepal' ),
		),
		4 => array(
			'title'       => __( 'Family &amp; Dependent Visa', 'iflynepal' ),
			'description' => __( 'For joining parents or children abroad, including Ex-British Gurkha family cases.', 'iflynepal' ),
		),
	);
}

/**
 * One category's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Category number.
 * @return array{title:string,description:string} Defaults for that category.
 */
function iflynepal_visa_type_default( $index ) {
	$defaults = iflynepal_visa_type_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
	);
}

/**
 * Kicker above the categories heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_types_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_types_kicker', IFLYNEPAL_VISA_TYPES_KICKER_DEFAULT ) );
}

/**
 * Categories heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_visa_types_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_types_title', IFLYNEPAL_VISA_TYPES_TITLE_DEFAULT ) );
}

/**
 * Whether the categories section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_types() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_types_title() ) );
}

/**
 * The visa categories that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'index', 'title' and 'description'.
 */
function iflynepal_visa_types() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_VISA_TYPE_MAX; $i++ ) {
		$default = iflynepal_visa_type_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_visa_type_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_visa_type_' . $i . '_description', $default['description'] ),
		);
	}

	return $rows;
}

/* ----------------------------------------------------------- destinations */

/**
 * Default kicker above the destinations heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_DESTINATIONS_KICKER_DEFAULT = 'Where you are headed';

/**
 * Default destinations heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_DESTINATIONS_TITLE_DEFAULT = 'Destinations we cover';

/**
 * Default note under the destinations grid.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_DESTINATIONS_NOTE_DEFAULT = 'Do not see your destination listed? Get in touch — we handle other countries on request too.';

/**
 * Default destinations, as the design has them.
 *
 * The code is the short label the grid prints above the name. It is typed
 * rather than looked up: "EU" for the Schengen area is not a country code at
 * all, and a lookup table would have no answer for it.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_visa_destination_defaults() {
	return array(
		1  => array(
			'code' => 'AU',
			'name' => __( 'Australia', 'iflynepal' ),
		),
		2  => array(
			'code' => 'GB',
			'name' => __( 'United Kingdom', 'iflynepal' ),
		),
		3  => array(
			'code' => 'JP',
			'name' => __( 'Japan', 'iflynepal' ),
		),
		4  => array(
			'code' => 'KR',
			'name' => __( 'South Korea', 'iflynepal' ),
		),
		5  => array(
			'code' => 'EU',
			'name' => __( 'Schengen', 'iflynepal' ),
		),
		6  => array(
			'code' => 'CA',
			'name' => __( 'Canada', 'iflynepal' ),
		),
		7  => array(
			'code' => 'AE',
			'name' => __( 'UAE', 'iflynepal' ),
		),
		8  => array(
			'code' => 'TH',
			'name' => __( 'Thailand', 'iflynepal' ),
		),
		9  => array(
			'code' => 'NZ',
			'name' => __( 'New Zealand', 'iflynepal' ),
		),
		10 => array(
			'code' => 'US',
			'name' => __( 'United States', 'iflynepal' ),
		),
	);
}

/**
 * One destination's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Destination number.
 * @return array{code:string,name:string} Defaults for that destination.
 */
function iflynepal_visa_destination_default( $index ) {
	$defaults = iflynepal_visa_destination_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'code' => '',
		'name' => '',
	);
}

/**
 * Kicker above the destinations heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_destinations_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_destinations_kicker', IFLYNEPAL_VISA_DESTINATIONS_KICKER_DEFAULT ) );
}

/**
 * Destinations heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_visa_destinations_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_destinations_title', IFLYNEPAL_VISA_DESTINATIONS_TITLE_DEFAULT ) );
}

/**
 * Note under the destinations grid.
 *
 * @since 1.0.0
 *
 * @return string Note HTML. Empty prints no note.
 */
function iflynepal_visa_destinations_note() {
	return iflynepal_kses_rich( get_theme_mod( 'iflynepal_visa_destinations_note', IFLYNEPAL_VISA_DESTINATIONS_NOTE_DEFAULT ) );
}

/**
 * Whether the destinations section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_destinations() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_destinations_title() ) );
}

/**
 * The destinations that have a name, in order.
 *
 * The name is what makes a cell real, not the code: a country the office covers
 * whose short label nobody typed is still a country the office covers, and it
 * prints with an empty code slot rather than disappearing.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'index', 'code' and 'name'.
 */
function iflynepal_visa_destinations() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_VISA_DESTINATION_MAX; $i++ ) {
		$default = iflynepal_visa_destination_default( $i );
		$name    = trim( (string) get_theme_mod( 'iflynepal_visa_destination_' . $i . '_name', $default['name'] ) );

		if ( '' === $name ) {
			continue;
		}

		$rows[] = array(
			'index' => $i,
			'code'  => trim( (string) get_theme_mod( 'iflynepal_visa_destination_' . $i . '_code', $default['code'] ) ),
			'name'  => $name,
		);
	}

	return $rows;
}

/* ----------------------------------------------------------------- process */

/**
 * Default kicker above the process heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_PROCESS_KICKER_DEFAULT = 'Step by step';

/**
 * Default process heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_PROCESS_TITLE_DEFAULT = 'How your application moves from blank form to submitted file';

/**
 * Default steps, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_visa_step_defaults() {
	return array(
		1 => array(
			'title'       => __( 'Fill out your application', 'iflynepal' ),
			'description' => __( 'We complete your visa application or form together, matching every field to your passport and supporting documents.', 'iflynepal' ),
		),
		2 => array(
			'title'       => __( 'Get your document checklist', 'iflynepal' ),
			'description' => __( 'You receive a checklist built around your specific visa type and destination, so you know exactly what to gather and in what form.', 'iflynepal' ),
		),
		3 => array(
			'title'       => __( 'Collect and arrange your documents', 'iflynepal' ),
			'description' => __( 'We help you pull together what is missing and arrange your file in the order the embassy expects to see it.', 'iflynepal' ),
		),
		4 => array(
			'title'       => __( 'Upload or submit your application', 'iflynepal' ),
			'description' => __( 'We manage the upload or physical submission of your file, whether it goes through an embassy portal or a visa application center.', 'iflynepal' ),
		),
		5 => array(
			'title'       => __( 'Prepare for your appointment', 'iflynepal' ),
			'description' => __( 'We guide you through booking and preparing for your biometrics or in-person appointment, so there are no surprises on the day.', 'iflynepal' ),
		),
		6 => array(
			'title'       => __( 'Run the final submission check', 'iflynepal' ),
			'description' => __( 'Before anything goes in, we run one last checklist against your file to catch anything that might have been missed.', 'iflynepal' ),
		),
	);
}

/**
 * One step's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Step number.
 * @return array{title:string,description:string} Defaults for that step.
 */
function iflynepal_visa_step_default( $index ) {
	$defaults = iflynepal_visa_step_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'       => '',
		'description' => '',
	);
}

/**
 * Kicker above the process heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_process_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_process_kicker', IFLYNEPAL_VISA_PROCESS_KICKER_DEFAULT ) );
}

/**
 * Process heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_visa_process_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_process_title', IFLYNEPAL_VISA_PROCESS_TITLE_DEFAULT ) );
}

/**
 * Whether the process section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_process() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_process_title() ) );
}

/**
 * The steps that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'index', 'title' and 'description'.
 */
function iflynepal_visa_steps() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_VISA_STEP_MAX; $i++ ) {
		$default = iflynepal_visa_step_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_visa_step_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_visa_step_' . $i . '_description', $default['description'] ),
		);
	}

	return $rows;
}

/* ---------------------------------------------------------------- packages */

/**
 * Default kicker above the packages heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_PACKAGES_KICKER_DEFAULT = 'Choose your level of support';

/**
 * Default packages heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_PACKAGES_TITLE_DEFAULT = 'Two packages, built around how complex your case is';

/**
 * Splits a textarea typed one item per line into its lines.
 *
 * Shared by the package feature lists and the fee notice, which are the two
 * places on this page where the content is a short list rather than a
 * paragraph. Eleven settings for eleven one-line features is a Customizer panel
 * nobody can read; one textarea is a list anybody can reorder.
 *
 * @since 1.0.0
 *
 * @param string $raw Raw textarea value.
 * @return string[] Non-empty lines, trimmed, in order.
 */
function iflynepal_visa_lines( $raw ) {
	$lines = preg_split( '/\R/', (string) $raw );

	return array_values( array_filter( array_map( 'trim', (array) $lines ), 'strlen' ) );
}

/**
 * Default packages, as the design has them.
 *
 * `carries` is the optional "everything in Basic" line, printed above the list
 * with a different mark, because it is a different kind of statement from the
 * features under it — it points at another package rather than naming a thing
 * the office does.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_visa_package_defaults() {
	return array(
		1 => array(
			'name'     => __( 'Basic', 'iflynepal' ),
			'tagline'  => __( 'Application and submission, for straightforward cases where your documents are largely ready', 'iflynepal' ),
			'badge'    => '',
			'carries'  => '',
			'features' => implode(
				"\n",
				array(
					__( 'Visa application and form filling', 'iflynepal' ),
					__( 'Document checklist for your specific visa type', 'iflynepal' ),
					__( 'Basic document collection and arrangement', 'iflynepal' ),
					__( 'Upload and submission assistance', 'iflynepal' ),
					__( 'Appointment and biometrics guidance', 'iflynepal' ),
					__( 'Final submission checklist', 'iflynepal' ),
				)
			),
		),
		2 => array(
			'name'     => __( 'Standard', 'iflynepal' ),
			'tagline'  => __( 'Complete visa assistance, for applications with financial documents, sponsors, or an interview stage', 'iflynepal' ),
			'badge'    => __( 'Most chosen', 'iflynepal' ),
			'carries'  => __( 'Everything in Basic', 'iflynepal' ),
			'features' => implode(
				"\n",
				array(
					__( 'Detailed review of every document', 'iflynepal' ),
					__( 'Financial and bank statement review', 'iflynepal' ),
					__( 'Sponsor and invitation document review', 'iflynepal' ),
					__( 'Cover and explanation letter preparation', 'iflynepal' ),
					__( 'Travel itinerary review and preparation', 'iflynepal' ),
					__( 'Cross-checking consistency across all documents', 'iflynepal' ),
					__( 'Identifying weak or missing documents, with fixes', 'iflynepal' ),
					__( 'Final quality review of your full application', 'iflynepal' ),
					__( 'Interview preparation, where applicable', 'iflynepal' ),
					__( 'Submission and follow-up guidance', 'iflynepal' ),
				)
			),
		),
	);
}

/**
 * One package's defaults, with empty fallbacks for an unused slot.
 *
 * @since 1.0.0
 *
 * @param int $index Package number.
 * @return array Defaults for that package.
 */
function iflynepal_visa_package_default( $index ) {
	$defaults = iflynepal_visa_package_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'name'     => '',
		'tagline'  => '',
		'badge'    => '',
		'carries'  => '',
		'features' => '',
	);
}

/**
 * Kicker above the packages heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_visa_packages_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_packages_kicker', IFLYNEPAL_VISA_PACKAGES_KICKER_DEFAULT ) );
}

/**
 * Packages heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the section.
 */
function iflynepal_visa_packages_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_packages_title', IFLYNEPAL_VISA_PACKAGES_TITLE_DEFAULT ) );
}

/**
 * Whether the packages section is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_packages() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_packages_title() ) );
}

/**
 * The packages that have a name, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'index', 'name', 'tagline', 'badge', 'carries' and
 *                 'features', the last already split into lines.
 */
function iflynepal_visa_packages() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_VISA_PACKAGE_MAX; $i++ ) {
		$default = iflynepal_visa_package_default( $i );
		$name    = trim( (string) get_theme_mod( 'iflynepal_visa_package_' . $i . '_name', $default['name'] ) );

		if ( '' === $name ) {
			continue;
		}

		$rows[] = array(
			'index'    => $i,
			'name'     => $name,
			'tagline'  => (string) get_theme_mod( 'iflynepal_visa_package_' . $i . '_tagline', $default['tagline'] ),
			'badge'    => trim( (string) get_theme_mod( 'iflynepal_visa_package_' . $i . '_badge', $default['badge'] ) ),
			'carries'  => trim( (string) get_theme_mod( 'iflynepal_visa_package_' . $i . '_carries', $default['carries'] ) ),
			'features' => iflynepal_visa_lines( get_theme_mod( 'iflynepal_visa_package_' . $i . '_features', $default['features'] ) ),
		);
	}

	return $rows;
}

/* ------------------------------------------------------------------ notice */

/**
 * Default notice heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_NOTICE_TITLE_DEFAULT = 'Please note';

/**
 * Default notice body, one paragraph per line.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_NOTICE_BODY_DEFAULT = "Government visa fees, VFS or biometric fees, translation, notarization, insurance, valuation and other third-party costs are separate from our service fee.\nOur service fee is for professional visa application assistance and is non-refundable once work has commenced. Visa approval is solely at the discretion of the respective embassy or immigration authority, and we do not guarantee visa approval.";

/**
 * Notice heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the band.
 */
function iflynepal_visa_notice_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_notice_title', IFLYNEPAL_VISA_NOTICE_TITLE_DEFAULT ) );
}

/**
 * Whether the notice band is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_notice() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_notice_title() ) );
}

/**
 * The notice paragraphs, one per line in the Customizer.
 *
 * @since 1.0.0
 *
 * @return string[] Non-empty paragraphs, in order.
 */
function iflynepal_visa_notice_paragraphs() {
	return iflynepal_visa_lines( get_theme_mod( 'iflynepal_visa_notice_body', IFLYNEPAL_VISA_NOTICE_BODY_DEFAULT ) );
}

/* --------------------------------------------------------------------- cta */

/**
 * Default closing heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_CTA_TITLE_DEFAULT = 'Ready to start your <em>application</em>?';

/**
 * Default closing copy.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_CTA_LEAD_DEFAULT = 'Tell us where you are headed and what kind of visa you need. We will tell you honestly whether Basic or Standard is the right fit for your case.';

/**
 * Default label on the closing button.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_CTA_BUTTON_LABEL_DEFAULT = 'Get in touch';

/**
 * Default link on the closing button.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_VISA_CTA_BUTTON_URL_DEFAULT = '/contact-us/';

/**
 * Closing heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML. Empty hides the band.
 */
function iflynepal_visa_cta_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_cta_title', IFLYNEPAL_VISA_CTA_TITLE_DEFAULT ) );
}

/**
 * Closing copy.
 *
 * @since 1.0.0
 *
 * @return string Copy HTML.
 */
function iflynepal_visa_cta_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_visa_cta_lead', IFLYNEPAL_VISA_CTA_LEAD_DEFAULT ) );
}

/**
 * Whether the closing band is shown.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_visa_has_cta() {
	return '' !== trim( wp_strip_all_tags( iflynepal_visa_cta_title() ) );
}

/**
 * The closing button.
 *
 * @since 1.0.0
 *
 * @return array{label:string,url:string} The button, label empty when unused.
 */
function iflynepal_visa_cta_button() {
	return array(
		'label' => (string) get_theme_mod( 'iflynepal_visa_cta_button_label', IFLYNEPAL_VISA_CTA_BUTTON_LABEL_DEFAULT ),
		'url'   => iflynepal_sanitize_link( iflynepal_customizer_get_link( 'iflynepal_visa_cta_button_url', IFLYNEPAL_VISA_CTA_BUTTON_URL_DEFAULT ) ),
	);
}

/**
 * The office's contact lines, read from the Contact Us settings.
 *
 * Not fields of this page's own. The office has one phone number, one address
 * and one inbox, and a visa page that keeps a second copy of them is a second
 * copy to forget on the day any of the three changes. A line the Contact
 * settings leave empty is dropped rather than printed as a label with nothing
 * after it.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'label', 'value' and 'href' ('' when not a link).
 */
function iflynepal_visa_contact_lines() {
	if ( ! function_exists( 'iflynepal_contact_plain' ) ) {
		return array();
	}

	$lines  = array();
	$phone  = iflynepal_contact_plain( 'office_phone' );
	$email  = sanitize_email( iflynepal_contact_plain( 'office_email' ) );
	$office = iflynepal_contact_plain( 'office_address' );

	if ( '' !== $phone ) {
		$lines[] = array(
			'label' => __( 'Phone / WhatsApp', 'iflynepal' ),
			'value' => $phone,
			'href'  => 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ),
		);
	}

	if ( is_email( $email ) ) {
		$lines[] = array(
			'label' => __( 'Email', 'iflynepal' ),
			'value' => $email,
			'href'  => 'mailto:' . $email,
		);
	}

	if ( '' !== $office ) {
		/*
		 * The address is stored with a <br> in it, because the Contact page sets
		 * it over two lines. Here it runs inline beside its label, so the break
		 * becomes the comma it would have been if it had been written for one
		 * line — rather than a tag printed as text or a line that breaks mid-row.
		 *
		 * A comma already at the end of the first line is eaten by the same
		 * pattern. The default address is "Tarkeshwor-2,<br>KATHMANDU, NEPAL",
		 * which would otherwise come out with a double comma in it.
		 */
		$lines[] = array(
			'label' => __( 'Office', 'iflynepal' ),
			'value' => trim( wp_strip_all_tags( preg_replace( '/\s*,?\s*<br\s*\/?>\s*/i', ', ', $office ) ) ),
			'href'  => '',
		);
	}

	return $lines;
}

/* ------------------------------------------------- selective-refresh render */

/**
 * Renders the hero kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_hero_kicker() {
	return iflynepal_visa_hero_kicker();
}

/**
 * Renders the hero headline.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_hero_title() {
	return iflynepal_visa_hero_title();
}

/**
 * Renders the hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_hero_lead() {
	return iflynepal_visa_hero_lead();
}

/**
 * Renders the hero's buttons.
 *
 * The first takes the gold fill and the second the outline, the same pairing
 * every other hero on the site uses, so the page's primary action is the one
 * that looks primary wherever the visitor has come from.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_hero_actions() {
	$modifiers = array(
		1 => 'iflynepal-btn--primary',
		2 => 'iflynepal-btn--ghost',
	);

	$markup = '';

	foreach ( $modifiers as $index => $modifier ) {
		$button = iflynepal_visa_hero_button( $index );

		if ( '' === trim( $button['label'] ) ) {
			continue;
		}

		$markup .= sprintf(
			'<div class="wp-block-button %1$s"><a class="wp-block-button__link wp-element-button" %2$s>%3$s</a></div>',
			esc_attr( $modifier ),
			iflynepal_anchor_attr( $button['url'] ),
			esc_html( $button['label'] )
		);
	}

	return $markup;
}

/**
 * Renders the services kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_services_kicker() {
	return iflynepal_visa_services_kicker();
}

/**
 * Renders the services heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_services_title() {
	return iflynepal_visa_services_title();
}

/**
 * Renders the services.
 *
 * The numeral is the item's place in the printed row, counted here, so removing
 * one renumbers the rest rather than leaving a hole at 02.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_services() {
	$markup   = '';
	$position = 0;

	foreach ( iflynepal_visa_services() as $row ) {
		++$position;

		$markup .= sprintf(
			'<article class="iflynepal-visa-service" data-iflynepal-reveal><span class="iflynepal-visa-service__num" aria-hidden="true">%1$s</span><h3 class="iflynepal-visa-service__title">%2$s</h3><p class="iflynepal-visa-service__desc">%3$s</p></article>',
			esc_html( str_pad( (string) $position, 2, '0', STR_PAD_LEFT ) ),
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the categories kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_types_kicker() {
	return iflynepal_visa_types_kicker();
}

/**
 * Renders the categories heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_types_title() {
	return iflynepal_visa_types_title();
}

/**
 * Renders the visa categories.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_types() {
	$markup = '';

	foreach ( iflynepal_visa_types() as $row ) {
		$markup .= sprintf(
			'<article class="iflynepal-visa-type" data-iflynepal-reveal><h3 class="iflynepal-visa-type__title">%1$s</h3><p class="iflynepal-visa-type__desc">%2$s</p></article>',
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the destinations kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_destinations_kicker() {
	return iflynepal_visa_destinations_kicker();
}

/**
 * Renders the destinations heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_destinations_title() {
	return iflynepal_visa_destinations_title();
}

/**
 * Renders the note under the destinations grid.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_destinations_note() {
	return iflynepal_visa_destinations_note();
}

/**
 * Renders the destinations grid.
 *
 * The code is printed inside an `aria-hidden` span: it is a visual label above
 * the country name, and a screen reader that reads "A U Australia" is reading
 * the same word twice.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_destinations() {
	$markup = '';

	foreach ( iflynepal_visa_destinations() as $row ) {
		$code = '';

		if ( '' !== $row['code'] ) {
			$code = sprintf(
				'<span class="iflynepal-visa-dest__code" aria-hidden="true">%s</span>',
				esc_html( $row['code'] )
			);
		}

		$markup .= sprintf(
			'<div class="iflynepal-visa-dest" data-iflynepal-reveal>%1$s<span class="iflynepal-visa-dest__name">%2$s</span></div>',
			$code,
			esc_html( $row['name'] )
		);
	}

	return $markup;
}

/**
 * Renders the process kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_process_kicker() {
	return iflynepal_visa_process_kicker();
}

/**
 * Renders the process heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_process_title() {
	return iflynepal_visa_process_title();
}

/**
 * Renders the process steps.
 *
 * An ordered list rather than a stack of articles, because the order is the
 * content: step four after step three is the whole point of the section, and a
 * list is how that reaches a screen reader without the numeral having to be
 * read out as decoration. The numerals themselves are drawn by CSS from the
 * list, so removing a step renumbers the rest with nothing to recount.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_steps() {
	$markup = '';

	foreach ( iflynepal_visa_steps() as $row ) {
		$markup .= sprintf(
			'<li class="iflynepal-visa-step" data-iflynepal-reveal><h3 class="iflynepal-visa-step__title">%1$s</h3><p class="iflynepal-visa-step__desc">%2$s</p></li>',
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the packages kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_packages_kicker() {
	return iflynepal_visa_packages_kicker();
}

/**
 * Renders the packages heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_packages_title() {
	return iflynepal_visa_packages_title();
}

/**
 * Renders the packages.
 *
 * A package carrying a badge takes the raised treatment, so which one the
 * office wants chosen is a line of text in the Customizer rather than a class
 * somebody has to move in the template.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_packages() {
	$markup = '';

	foreach ( iflynepal_visa_packages() as $row ) {
		$badge = '';
		$class = 'iflynepal-visa-package';

		if ( '' !== $row['badge'] ) {
			$class .= ' iflynepal-visa-package--featured';
			$badge  = sprintf(
				'<span class="iflynepal-visa-package__badge">%s</span>',
				esc_html( $row['badge'] )
			);
		}

		$items = '';

		if ( '' !== $row['carries'] ) {
			$items .= sprintf(
				'<li class="iflynepal-visa-package__item iflynepal-visa-package__item--carries">%s</li>',
				esc_html( $row['carries'] )
			);
		}

		foreach ( $row['features'] as $feature ) {
			$items .= sprintf(
				'<li class="iflynepal-visa-package__item">%s</li>',
				esc_html( $feature )
			);
		}

		$tagline = '';

		if ( '' !== trim( wp_strip_all_tags( $row['tagline'] ) ) ) {
			$tagline = sprintf(
				'<p class="iflynepal-visa-package__tagline">%s</p>',
				iflynepal_kses_text( $row['tagline'] )
			);
		}

		$markup .= sprintf(
			'<article class="%1$s" data-iflynepal-reveal>%2$s<h3 class="iflynepal-visa-package__name">%3$s</h3>%4$s<ul class="iflynepal-visa-package__list">%5$s</ul></article>',
			esc_attr( $class ),
			$badge,
			iflynepal_kses_text( $row['name'] ),
			$tagline,
			$items
		);
	}

	return $markup;
}

/**
 * Renders the notice heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_notice_title() {
	return iflynepal_visa_notice_title();
}

/**
 * Renders the notice paragraphs.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_notice_body() {
	$markup = '';

	foreach ( iflynepal_visa_notice_paragraphs() as $paragraph ) {
		$markup .= sprintf( '<p>%s</p>', iflynepal_kses_rich( $paragraph ) );
	}

	return $markup;
}

/**
 * Renders the closing heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_cta_title() {
	return iflynepal_visa_cta_title();
}

/**
 * Renders the closing copy.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_cta_lead() {
	return iflynepal_visa_cta_lead();
}

/**
 * Renders the closing button.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_cta_button() {
	$button = iflynepal_visa_cta_button();

	if ( '' === trim( $button['label'] ) ) {
		return '';
	}

	return sprintf(
		'<div class="wp-block-button iflynepal-btn--primary"><a class="wp-block-button__link wp-element-button" %1$s>%2$s</a></div>',
		iflynepal_anchor_attr( $button['url'] ),
		esc_html( $button['label'] )
	);
}

/**
 * Renders the office's contact lines under the closing copy.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_visa_contact_lines() {
	$markup = '';

	foreach ( iflynepal_visa_contact_lines() as $line ) {
		$value = esc_html( $line['value'] );

		if ( '' !== $line['href'] ) {
			$value = sprintf(
				'<a %1$s>%2$s</a>',
				iflynepal_anchor_attr( $line['href'] ),
				esc_html( $line['value'] )
			);
		}

		$markup .= sprintf(
			'<div class="iflynepal-visa-contact__line"><span class="iflynepal-visa-contact__label">%1$s</span><span class="iflynepal-visa-contact__value">%2$s</span></div>',
			esc_html( $line['label'] ),
			$value
		);
	}

	return $markup;
}
