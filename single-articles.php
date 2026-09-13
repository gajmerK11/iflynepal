<?php
/**
 * A single article.
 *
 * The approved design, section for section: the reading bar across the top,
 * a full-viewport hero carrying the picture and the title, the breadcrumb and
 * the article's details under it, the body with its sticky sidebar, and the
 * row of further reading.
 *
 * Styled by assets/css/articles.css — the design's own stylesheet — rather than
 * by the theme's Tailwind build; the classes here are the design's.
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
		 * The bar is filled by assets/js/articles/single.js against the post
		 * body, so it reads full when the article ends rather than when the
		 * footer does. Decoration: it carries nothing a screen reader needs.
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
