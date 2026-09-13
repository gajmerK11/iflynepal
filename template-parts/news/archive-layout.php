<?php
/**
 * The News archive.
 *
 * Three bands: the hero with its search, the row of three Top News stories,
 * and the run of recent ones with the pager under it.
 *
 * The Top News row leads the section, so it is rendered on the first page of
 * it and nowhere else. It comes off on a search — there is nothing top about a
 * result — which is what the design's `data-hide-on-search` marks; here that
 * is a page load, so the band is simply not rendered. It comes off on page two
 * for the same reason: it is the head of the list rather than part of it, and
 * the three stories in it are in the run below in any case.
 *
 * The classes on <main> are the design's own, and assets/css/articles.css plus
 * assets/css/news.css are scoped to them.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main ifn-retreats-page ifn-articles-page ifn-news-page">
	<?php
	get_template_part( 'template-parts/news/hero-section' );

	if ( '' === iflynepal_news_search_term() && ! is_paged() ) {
		get_template_part( 'template-parts/news/top-section' );
	}

	get_template_part( 'template-parts/news/list-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
