<?php
/**
 * Template Name: Team
 *
 * The Team page — the hero, the global representatives, then the executive
 * team. Built from fixed template parts rather than editor content, the same
 * arrangement front-page.php, page-about.php and page-about-country.php use.
 * Assign it to a page under Page Attributes > Template, and everything on it is
 * edited in Appearance > Customize > About > Team.
 *
 * Named `page-team.php` so a page whose slug is "team" picks it up on its own
 * as well, per the theme's WP-native template naming.
 *
 * Either roster returns early when its heading has been emptied, which is how
 * the Customizer hides one.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/team/hero-section' );
	get_template_part( 'template-parts/team/representatives-section' );
	get_template_part( 'template-parts/team/executive-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
