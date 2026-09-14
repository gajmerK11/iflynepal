<?php
/**
 * A single blog post.
 *
 * The single article's template, section for section — the reading bar, the
 * full-viewport hero, the breadcrumb and details, the body with its sticky
 * sidebar, and the row of further reading. The parts read inc/sections.php for
 * the few things that differ between a blog and an article: the taxonomy the
 * breadcrumb and the related row work from, and what the copy calls a piece.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary" class="site-main ifn-retreats-page ifn-articles-page ifn-article-single">

		<?php
		/*
		 * Filled by assets/js/articles/single.js against the post body, so it
		 * reads full when the post ends rather than when the footer does.
		 * Decoration: it carries nothing a screen reader needs.
		 */
		?>
		<div class="read-progress" aria-hidden="true"></div>

		<?php
		get_template_part( 'template-parts/articles/single-hero-section' );
		get_template_part( 'template-parts/articles/single-intro-section' );
		get_template_part( 'template-parts/articles/single-main-section' );
		get_template_part( 'template-parts/articles/related-section' );
		?>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
