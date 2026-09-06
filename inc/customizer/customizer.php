<?php
/**
 * Customizer bootstrap.
 *
 * Callbacks are required on every request because selective refresh calls them
 * from the front end; sections are required only while the Customizer is being
 * registered, since nothing else needs them.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/hero.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/explore.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/trust.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/people.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/faq.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/travel-guide.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/cta.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/about.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/about-country.php';
require_once IFLYNEPAL_DIR . '/inc/customizer/callbacks/footer.php';

/**
 * Registers the theme's panels and sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function iflynepal_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_panel(
		'iflynepal_homepage',
		array(
			'title'       => __( 'Homepage', 'iflynepal' ),
			'description' => __( 'Content for each section of the front page, in the order it appears.', 'iflynepal' ),
			'priority'    => 30,
		)
	);

	/*
	 * A panel of its own rather than another Homepage section: the two columns
	 * are edited separately and each needs a section, and a section cannot hold
	 * sections. It sits beside Homepage in the list, not inside it — panels
	 * cannot nest.
	 */
	$wp_customize->add_panel(
		'iflynepal_guides',
		array(
			'title'       => __( 'FAQ / Travel Guide', 'iflynepal' ),
			'description' => __( 'The planning section near the foot of the front page: questions on the left, travel guides on the right.', 'iflynepal' ),
			'priority'    => 31,
		)
	);

	/*
	 * The About page templates' own panel: Company is the About page, Nepal is
	 * the country reference. A panel rather than more Homepage sections
	 * because none of it is on the homepage — each appears only where its
	 * template is assigned, and each needs a section, which a section cannot
	 * hold.
	 */
	$wp_customize->add_panel(
		'iflynepal_about',
		array(
			'title'       => __( 'About', 'iflynepal' ),
			'description' => __( 'Content for the About page templates. Assign one to a page under Page Attributes > Template.', 'iflynepal' ),
			'priority'    => 32,
		)
	);

	/*
	 * The footer appears on every template, so it is a panel of its own
	 * rather than anything under Homepage. Its three link columns are not
	 * here — those are nav menus (inc/setup.php).
	 */
	$wp_customize->add_panel(
		'iflynepal_footer',
		array(
			'title'       => __( 'Footer', 'iflynepal' ),
			'description' => __( 'The navy band at the foot of every page. The link columns above it are menus — see Appearance > Menus.', 'iflynepal' ),
			'priority'    => 33,
		)
	);

	/*
	 * Control classes extend WP_Customize_Control, which only exists once the
	 * Customizer is being registered — so they load here rather than at the top
	 * of the file.
	 */
	require_once IFLYNEPAL_DIR . '/inc/customizer/controls/class-ifly-nepal-customize-heading-control.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/hero.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/explore.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/trust.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/people.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/faq.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/travel-guide.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/cta.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/about-company.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/about-country.php';
	require IFLYNEPAL_DIR . '/inc/customizer/sections/footer.php';
}
add_action( 'customize_register', 'iflynepal_customize_register' );

/**
 * Enqueues the scripts that drive the Customizer's own controls.
 *
 * These run in the Customizer panel, not on the front end, so they never reach
 * a visitor. One file per behaviour, grouped by the section it belongs to.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_customizer_controls_assets() {
	wp_enqueue_script(
		'iflynepal-customizer-repeater',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/repeater.js',
		array( 'jquery', 'customize-controls' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/repeater.js' ),
		true
	);

	wp_enqueue_script(
		'iflynepal-customizer-hero-trust-points',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/trust-points.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/trust-points.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-hero-trust-points',
		'iflynepalHeroTrust',
		array(
			'max'         => IFLYNEPAL_HERO_TRUST_MAX,
			'addLabel'    => __( 'Add trust point', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of trust points. */
				__( 'Maximum %d trust points allowed.', 'iflynepal' ),
				IFLYNEPAL_HERO_TRUST_MAX
			),
			/* translators: %d: trust point number. */
			'removeLabel' => __( 'Remove trust point %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-explore-links',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/explore/links.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/explore/links.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-explore-links',
		'iflynepalExploreLinks',
		array(
			'cards'       => range( 1, IFLYNEPAL_EXPLORE_CARDS ),
			'max'         => IFLYNEPAL_EXPLORE_LINK_MAX,
			'addLabel'    => __( 'Add link', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of links per card. */
				__( 'Maximum %d links allowed.', 'iflynepal' ),
				IFLYNEPAL_EXPLORE_LINK_MAX
			),
			/* translators: %d: link number. */
			'removeLabel' => __( 'Remove link %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-trust-logos',
		IFLYNEPAL_URI . '/assets/js/homepage/trust/logos.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/trust/logos.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-trust-logos',
		'iflynepalTrustLogos',
		array(
			'groups'      => array( 'partner', 'association' ),
			'max'         => IFLYNEPAL_TRUST_LOGO_MAX,
			'addLabel'    => __( 'Add logo', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of logos per band. */
				__( 'Maximum %d logos allowed.', 'iflynepal' ),
				IFLYNEPAL_TRUST_LOGO_MAX
			),
			/* translators: %d: logo number. */
			'removeLabel' => __( 'Remove logo %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-faq-items',
		IFLYNEPAL_URI . '/assets/js/homepage/guides/faq-items.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/guides/faq-items.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-faq-items',
		'iflynepalFaqItems',
		array(
			'max'         => IFLYNEPAL_FAQ_MAX,
			'addLabel'    => __( 'Add question', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of questions. */
				__( 'Maximum %d questions allowed.', 'iflynepal' ),
				IFLYNEPAL_FAQ_MAX
			),
			/* translators: %d: question number. */
			'removeLabel' => __( 'Remove question %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-about-story',
		IFLYNEPAL_URI . '/assets/js/about/story.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/about/story.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-about-story',
		'iflynepalAboutStory',
		array(
			'max'         => IFLYNEPAL_ABOUT_STORY_MAX,
			'addLabel'    => __( 'Add paragraph', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of paragraphs. */
				__( 'Maximum %d paragraphs allowed.', 'iflynepal' ),
				IFLYNEPAL_ABOUT_STORY_MAX
			),
			/* translators: %d: paragraph number. */
			'removeLabel' => __( 'Remove paragraph %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-about-offers',
		IFLYNEPAL_URI . '/assets/js/about/offers.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/about/offers.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-about-offers',
		'iflynepalAboutOffers',
		array(
			'max'         => IFLYNEPAL_ABOUT_OFFER_MAX,
			'addLabel'    => __( 'Add offering', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of offerings. */
				__( 'Maximum %d offerings allowed.', 'iflynepal' ),
				IFLYNEPAL_ABOUT_OFFER_MAX
			),
			/* translators: %d: offering number. */
			'removeLabel' => __( 'Remove offering %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-country-lists',
		IFLYNEPAL_URI . '/assets/js/about-country/repeaters.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/about-country/repeaters.js' ),
		true
	);

	/*
	 * Every add/remove list on the About Nepal page, described rather than
	 * coded: the page has eleven of them and they differ only in which
	 * settings they cover and what the buttons say.
	 */
	$iflynepal_country_lists = array();

	foreach ( array_keys( iflynepal_country_chapters() ) as $iflynepal_slug ) {
		if ( ! iflynepal_country_chapter_has_prose( $iflynepal_slug ) ) {
			continue;
		}

		$iflynepal_country_lists[] = array(
			'pattern'     => 'iflynepal_country_' . $iflynepal_slug . '_paragraph_%d',
			'max'         => IFLYNEPAL_COUNTRY_PARAGRAPH_MAX,
			// The chapter's banner is the last control before its paragraphs.
			'anchor'      => 'iflynepal_country_' . $iflynepal_slug . '_image',
			'addLabel'    => __( 'Add paragraph', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of paragraphs. */
				__( 'Maximum %d paragraphs allowed.', 'iflynepal' ),
				IFLYNEPAL_COUNTRY_PARAGRAPH_MAX
			),
			/* translators: %d: paragraph number. */
			'removeLabel' => __( 'Remove paragraph %d', 'iflynepal' ),
		);
	}

	$iflynepal_country_lists[] = array(
		'pattern'     => 'iflynepal_country_bring_paragraph_%d',
		'max'         => IFLYNEPAL_COUNTRY_PARAGRAPH_MAX,
		'anchor'      => 'iflynepal_country_bring_title',
		'addLabel'    => __( 'Add paragraph', 'iflynepal' ),
		'maxMessage'  => sprintf(
			/* translators: %d: maximum number of paragraphs. */
			__( 'Maximum %d paragraphs allowed.', 'iflynepal' ),
			IFLYNEPAL_COUNTRY_PARAGRAPH_MAX
		),
		/* translators: %d: paragraph number. */
		'removeLabel' => __( 'Remove paragraph %d', 'iflynepal' ),
	);

	$iflynepal_country_lists[] = array(
		'pattern'     => array(
			'iflynepal_country_band_%d_title',
			'iflynepal_country_band_%d_image',
		),
		'max'         => IFLYNEPAL_COUNTRY_BAND_MAX,
		'anchor'      => 'iflynepal_country_bands_heading',
		'addLabel'    => __( 'Add card', 'iflynepal' ),
		'maxMessage'  => sprintf(
			/* translators: %d: maximum number of cards. */
			__( 'Maximum %d cards allowed.', 'iflynepal' ),
			IFLYNEPAL_COUNTRY_BAND_MAX
		),
		/* translators: %d: card number. */
		'removeLabel' => __( 'Remove card %d', 'iflynepal' ),
	);

	$iflynepal_country_lists[] = array(
		'pattern'     => array(
			'iflynepal_country_region_%d_number',
			'iflynepal_country_region_%d_title',
			'iflynepal_country_region_%d_description',
			'iflynepal_country_region_%d_image',
		),
		'max'         => IFLYNEPAL_COUNTRY_REGION_MAX,
		'anchor'      => 'iflynepal_country_regions_heading',
		'addLabel'    => __( 'Add region', 'iflynepal' ),
		'maxMessage'  => sprintf(
			/* translators: %d: maximum number of regions. */
			__( 'Maximum %d regions allowed.', 'iflynepal' ),
			IFLYNEPAL_COUNTRY_REGION_MAX
		),
		/* translators: %d: region number. */
		'removeLabel' => __( 'Remove region %d', 'iflynepal' ),
	);

	$iflynepal_country_lists[] = array(
		'pattern'     => array(
			'iflynepal_country_sector_%d_title',
			'iflynepal_country_sector_%d_description',
			'iflynepal_country_sector_%d_icon',
		),
		'max'         => IFLYNEPAL_COUNTRY_SECTOR_MAX,
		'anchor'      => 'iflynepal_country_sectors_heading',
		'addLabel'    => __( 'Add sector', 'iflynepal' ),
		'maxMessage'  => sprintf(
			/* translators: %d: maximum number of sectors. */
			__( 'Maximum %d sectors allowed.', 'iflynepal' ),
			IFLYNEPAL_COUNTRY_SECTOR_MAX
		),
		/* translators: %d: sector number. */
		'removeLabel' => __( 'Remove sector %d', 'iflynepal' ),
	);

	$iflynepal_country_lists[] = array(
		'pattern'     => 'iflynepal_country_safety_%d',
		'max'         => IFLYNEPAL_COUNTRY_SAFETY_MAX,
		'anchor'      => 'iflynepal_country_safety_heading',
		'addLabel'    => __( 'Add point', 'iflynepal' ),
		'maxMessage'  => sprintf(
			/* translators: %d: maximum number of points. */
			__( 'Maximum %d points allowed.', 'iflynepal' ),
			IFLYNEPAL_COUNTRY_SAFETY_MAX
		),
		/* translators: %d: point number. */
		'removeLabel' => __( 'Remove point %d', 'iflynepal' ),
	);

	/*
	 * Two fields in these lists are never blank when a slot is unused: a
	 * region's numeral defaults to its own position, and a sector's icon
	 * defaults to a real glyph. The repeater decides a slot is in use by
	 * finding any field that is not its empty value, so both would keep every
	 * slot on screen. Their defaults are therefore passed through as what
	 * "empty" means for those fields.
	 */
	$iflynepal_sector_empties = array();

	for ( $iflynepal_sector = 1; $iflynepal_sector <= IFLYNEPAL_COUNTRY_SECTOR_MAX; $iflynepal_sector++ ) {
		$iflynepal_sector_default = iflynepal_country_sector_default( $iflynepal_sector );

		$iflynepal_sector_empties[ $iflynepal_sector ] = $iflynepal_sector_default['icon'];
	}

	wp_localize_script(
		'iflynepal-customizer-country-lists',
		'iflynepalCountryLists',
		array(
			'lists'       => $iflynepal_country_lists,
			'sectorIcons' => $iflynepal_sector_empties,
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-people-cards',
		IFLYNEPAL_URI . '/assets/js/homepage/people/cards.js',
		array( 'iflynepal-customizer-repeater' ),
		iflynepal_asset_version( 'assets/js/homepage/people/cards.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-people-cards',
		'iflynepalPeopleCards',
		array(
			'max'         => IFLYNEPAL_PEOPLE_CARD_MAX,
			'addLabel'    => __( 'Add person', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of people in the rail. */
				__( 'Maximum %d people allowed.', 'iflynepal' ),
				IFLYNEPAL_PEOPLE_CARD_MAX
			),
			/* translators: %d: person number. */
			'removeLabel' => __( 'Remove person %d', 'iflynepal' ),
		)
	);

	wp_enqueue_script(
		'iflynepal-customizer-hero-background-image',
		IFLYNEPAL_URI . '/assets/js/homepage/hero/background-image.js',
		array( 'jquery', 'customize-controls', 'media-views' ),
		iflynepal_asset_version( 'assets/js/homepage/hero/background-image.js' ),
		true
	);

	wp_localize_script(
		'iflynepal-customizer-hero-background-image',
		'iflynepalHeroImage',
		array(
			'minWidth'  => IFLYNEPAL_HERO_IMAGE_MIN_WIDTH,
			'minHeight' => IFLYNEPAL_HERO_IMAGE_MIN_HEIGHT,
			'minRatio'  => IFLYNEPAL_HERO_IMAGE_MIN_RATIO,
			'message'   => __( "The image's quality and size is not compatible", 'iflynepal' ),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'iflynepal_customizer_controls_assets' );

/**
 * Styles the group headings inside a section.
 *
 * A rule apiece, printed inline rather than shipped as a stylesheet: it is a
 * handful of declarations that only ever apply inside the Customizer panel, and
 * a separate file would be another request for them.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_customizer_controls_styles() {
	?>
	<style id="iflynepal-customizer-controls">
		.customize-control-iflynepal-heading {
			margin-bottom: 4px;
			padding-top: 16px;
			border-top: 1px solid #dcdcde;
		}

		.customize-control-iflynepal-heading .iflynepal-customize-heading {
			margin-bottom: 0;
			color: #1d2327;
			font-size: 14px;
			font-weight: 600;
		}

	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'iflynepal_customizer_controls_styles' );
