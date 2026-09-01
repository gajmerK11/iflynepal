<?php
/**
 * Front page.
 *
 * The homepage is built from fixed template parts, not editor content — there
 * is no block editor in this theme, so the sections below are the only source
 * of the page's markup.
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
	?>
</main><!-- #primary -->

<?php
get_footer();
