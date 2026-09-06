<?php
/**
 * Template Name: Contact Us
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/contact/hero-section' );
	get_template_part( 'template-parts/contact/enquiry-section' );
	get_template_part( 'template-parts/contact/representatives-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();

