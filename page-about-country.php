<?php
/**
 * Template Name: About Nepal
 *
 * The About Nepal page — the country reference: geography, people, history,
 * climate, politics, flora and fauna, economy, safety and visas. Built from
 * fixed template parts rather than editor content, the same arrangement
 * front-page.php and page-about.php use. Assign it to a page under Page
 * Attributes > Template, and everything on it is edited in
 * Appearance > Customize > About > Nepal.
 *
 * Named `page-about-country.php` so a page whose slug is "about-country" picks
 * it up on its own as well, per the theme's WP-native template naming.
 *
 * The nine chapters all share one shape, so they are one template part called
 * nine times rather than nine near-identical files. A chapter whose heading has
 * been emptied returns early, which is how the Customizer hides one.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/about-country/hero-section' );
	get_template_part( 'template-parts/about-country/index-bar' );

	$iflynepal_first = true;

	foreach ( array_keys( iflynepal_country_chapters() ) as $iflynepal_slug ) {
		if ( ! iflynepal_country_has_chapter( $iflynepal_slug ) ) {
			continue;
		}

		get_template_part(
			'template-parts/about-country/chapter',
			null,
			array(
				'slug'  => $iflynepal_slug,
				'first' => $iflynepal_first,
			)
		);

		$iflynepal_first = false;
	}
	?>
</main><!-- #primary -->

<?php
get_footer();
