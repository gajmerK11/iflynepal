<?php
/**
 * A single news story.
 *
 * The approved design, section for section: the reading bar across the top, a
 * full-viewport hero carrying the picture, the flag, the headline and the
 * ticker of recent headlines along its foot, the breadcrumb and the story's
 * details under it, the body with its sidebar, and the row of further stories.
 *
 * Styled by assets/css/articles.css and assets/css/news.css — the designs' own
 * stylesheets — rather than by the theme's Tailwind build; the classes here are
 * the designs'.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary" class="site-main ifn-retreats-page ifn-articles-page ifn-article-single ifn-news-single">

		<?php
		/*
		 * The bar is filled by assets/js/articles/single.js against the post
		 * body, so it reads full when the story ends rather than when the
		 * footer does. Decoration: it carries nothing a screen reader needs.
		 */
		?>
		<div class="read-progress" aria-hidden="true"></div>

		<?php
		get_template_part( 'template-parts/news/single-hero-section' );
		get_template_part( 'template-parts/news/single-intro-section' );
		get_template_part( 'template-parts/news/single-main-section' );
		get_template_part( 'template-parts/news/related-section' );
		?>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
