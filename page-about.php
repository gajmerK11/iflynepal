<?php
/**
 * Template Name: About
 *
 * The About page, built from fixed template parts rather than editor content —
 * the same arrangement front-page.php uses. Assign it to a page under Page
 * Attributes > Template, and everything on it is edited in
 * Appearance > Customize > About.
 *
 * Named `page-about.php` so a page whose slug is "about" picks it up on its
 * own as well, per the theme's WP-native template naming.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/about/hero-section' );
	get_template_part( 'template-parts/about/overview-section' );
	get_template_part( 'template-parts/about/vision-section' );
	get_template_part( 'template-parts/about/offer-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
