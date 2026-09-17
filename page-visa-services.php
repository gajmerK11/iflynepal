<?php
/**
 * Template Name: Visa Services
 *
 * The Visa Services page — the hero, the three things the office handles, the
 * visa categories, the destinations grid, the step-by-step process, the two
 * packages, the fee notice and the closing invitation. Built from fixed
 * template parts rather than editor content, the same arrangement
 * front-page.php and the About templates use. Assign it to a page under Page
 * Attributes > Template, and everything on it is edited in
 * Appearance > Customize > Visa Services.
 *
 * Named `page-visa-services.php` so a page whose slug is "visa-services" picks
 * it up on its own as well, per the theme's WP-native template naming.
 *
 * Each section returns early when its heading has been emptied, which is how
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
	get_template_part( 'template-parts/visa/hero-section' );
	get_template_part( 'template-parts/visa/services-section' );
	get_template_part( 'template-parts/visa/types-section' );
	get_template_part( 'template-parts/visa/destinations-section' );
	get_template_part( 'template-parts/visa/process-section' );
	get_template_part( 'template-parts/visa/packages-section' );
	get_template_part( 'template-parts/visa/notice-section' );
	get_template_part( 'template-parts/visa/cta-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
