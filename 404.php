<?php
/**
 * The Not Found (404) template.
 *
 * One fixed template part rather than editor content, the same arrangement
 * front-page.php and the page templates use. Everything on it is edited in
 * Appearance > Customize > Not Found (404).
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/404/not-found' ); ?>
</main><!-- #primary -->

<?php
get_footer();
