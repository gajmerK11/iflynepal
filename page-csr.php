<?php
/**
 * Template Name: CSR
 *
 * The CSR page — the hero, the commitment, the pledge band, the sustainability
 * pillars, the community projects, the ways tourism empowers, the
 * accountability statement and the closing invitation. Built from fixed
 * template parts rather than editor content, the same arrangement
 * front-page.php and the other About templates use. Assign it to a page under
 * Page Attributes > Template, and everything on it is edited in
 * Appearance > Customize > About > CSR.
 *
 * Named `page-csr.php` so a page whose slug is "csr" picks it up on its own as
 * well, per the theme's WP-native template naming.
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
	get_template_part( 'template-parts/csr/hero-section' );
	get_template_part( 'template-parts/csr/commitment-section' );
	get_template_part( 'template-parts/csr/pledge-section' );
	get_template_part( 'template-parts/csr/pillars-section' );
	get_template_part( 'template-parts/csr/community-section' );
	get_template_part( 'template-parts/csr/empowerment-section' );
	get_template_part( 'template-parts/csr/accountability-section' );
	get_template_part( 'template-parts/csr/close-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
