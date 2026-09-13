<?php
/**
 * The Articles archive, as rendered by all three of its templates.
 *
 * The post type archive, a category and a tag are the same page with a
 * different query behind it — the hero reads the queried term and the grid
 * reads the loop — so they share this file rather than holding three copies
 * of it.
 *
 * The classes on <main> are the design's own, and assets/css/articles.css is
 * scoped to them.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main ifn-retreats-page ifn-articles-page ifn-category-page">
	<?php
	get_template_part( 'template-parts/articles/hero-section' );
	get_template_part( 'template-parts/articles/list-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
