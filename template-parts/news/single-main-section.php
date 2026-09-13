<?php
/**
 * The news story's body, with the sidebar beside it.
 *
 * The design's two-column layout: a card on the left holding the contributors,
 * the share control and the rail of recent headlines, and the story itself on
 * the right. Under 1080px the card lies down above the story rather than coming
 * off, because unlike an article's sidebar it carries nothing that is repeated
 * further down the page.
 *
 * The design closes the story with a "Filed under News · date" line. It is not
 * printed: every story on this install is filed under News, so the line names
 * the only section there is, and the date it carries is already in the details
 * row under the breadcrumb.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_main_body = iflynepal_news_body();
?>
<section class="post-main" aria-label="<?php esc_attr_e( 'News story', 'iflynepal' ); ?>">
	<div class="container post-layout">

		<?php get_template_part( 'template-parts/news/single-aside' ); ?>

		<div class="post-col">

			<article class="post-content">
				<?php
				/*
				 * Editor content, already through the_content filters — the
				 * same escaping every other WordPress template relies on — and
				 * then through iflynepal_article_body(), which only adds ids
				 * and class names.
				 */
				echo $iflynepal_news_main_body['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				wp_link_pages(
					array(
						'before' => '<nav class="post-pages">',
						'after'  => '</nav>',
					)
				);
				?>
			</article>

		</div>

	</div>
</section>
