<?php
/**
 * Front page.
 *
 * The homepage is built from fixed template parts.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/home/hero-section' );
	get_template_part( 'template-parts/home/explore-section' );
	get_template_part( 'template-parts/home/trust-section' );
	get_template_part( 'template-parts/home/people-section' );
	get_template_part( 'template-parts/sections/testimonials' );
	?>
</main><!-- #primary -->

<?php
get_footer();
