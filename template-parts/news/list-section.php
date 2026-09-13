<?php
/**
 * The News archive: the run of recent stories and the pager.
 *
 * The approved design's markup, class for class. Its script stands in for the
 * server so the file can be clicked through on its own; here each of those
 * states is a page load, which is what the design's own comments say the WP
 * install would do — a page number is a link to the paged URL, and the search
 * is the hero form's GET.
 *
 * The pager's shape and its links are the Articles archive's: the two archives
 * page identically, so the two helpers in inc/articles.php serve both rather
 * than being written twice.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

$iflynepal_news_list_page  = max( 1, (int) $wp_query->get( 'paged' ) );
$iflynepal_news_list_pages = (int) $wp_query->max_num_pages;
?>
<section class="news-section" id="articles" aria-labelledby="recent-news-title">
	<div class="container">

		<div class="news-head" data-anim>
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Recent news', 'iflynepal' ); ?></span>
				<h2 id="recent-news-title"><?php esc_html_e( 'Latest from Kathmandu', 'iflynepal' ); ?></h2>
			</div>
		</div>

		<div class="news-grid" id="ifn-post-grid" data-noun="story" data-nouns="stories" data-browse="see all the news">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part(
					'template-parts/news/card',
					null,
					array( 'variant' => 'list' )
				);
			endwhile;
			?>
		</div>

		<p class="post-empty" id="ifn-post-empty"<?php echo $wp_query->found_posts ? ' hidden' : ''; ?>><?php esc_html_e( 'No news found.', 'iflynepal' ); ?></p>

		<?php if ( $iflynepal_news_list_pages > 1 ) : ?>
			<nav class="post-pagination" id="ifn-pagination" aria-label="<?php esc_attr_e( 'News pages', 'iflynepal' ); ?>">
				<?php if ( $iflynepal_news_list_page > 1 ) : ?>
					<a class="pg-step pg-prev" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_news_list_page - 1 ) ); ?>" rel="prev"><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H5M11 6l-6 6 6 6"/></svg><?php esc_html_e( 'Previous', 'iflynepal' ); ?></a>
				<?php else : ?>
					<span class="pg-step pg-prev is-disabled"><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H5M11 6l-6 6 6 6"/></svg><?php esc_html_e( 'Previous', 'iflynepal' ); ?></span>
				<?php endif; ?>

				<div class="pg-nums">
					<?php foreach ( iflynepal_articles_pagination_numbers( $iflynepal_news_list_page, $iflynepal_news_list_pages ) as $iflynepal_news_list_num ) : ?>
						<?php if ( null === $iflynepal_news_list_num ) : ?>
							<span class="pg-dots" aria-hidden="true">&hellip;</span>
						<?php elseif ( $iflynepal_news_list_num === $iflynepal_news_list_page ) : ?>
							<span class="pg-num is-current" aria-current="page"><?php echo esc_html( number_format_i18n( $iflynepal_news_list_num ) ); ?></span>
						<?php else : ?>
							<a class="pg-num" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_news_list_num ) ); ?>"><?php echo esc_html( number_format_i18n( $iflynepal_news_list_num ) ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<span class="pg-count"><?php
					printf(
						/* translators: 1: current page number, 2: total pages. */
						esc_html__( 'Page %1$s of %2$s', 'iflynepal' ),
						esc_html( number_format_i18n( $iflynepal_news_list_page ) ),
						esc_html( number_format_i18n( $iflynepal_news_list_pages ) )
					);
				?></span>

				<?php if ( $iflynepal_news_list_page < $iflynepal_news_list_pages ) : ?>
					<a class="pg-step pg-next" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_news_list_page + 1 ) ); ?>" rel="next"><?php esc_html_e( 'Next', 'iflynepal' ); ?><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>
				<?php else : ?>
					<span class="pg-step pg-next is-disabled"><?php esc_html_e( 'Next', 'iflynepal' ); ?><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></span>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

	</div>
</section>
