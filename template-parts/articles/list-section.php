<?php
/**
 * The editorial archive: the category tabs, the grid and the pager.
 *
 * Drawn for Articles and for Blogs both, off whichever section's post type and
 * taxonomy inc/sections.php reports for the request.
 *
 * The approved design's markup, class for class. Its script stands in for the
 * server so the file can be clicked through on its own; here each of those
 * states is a page load, which is what the design's own comments say the WP
 * install would do — a tab is a link to the term archive, a page number is a
 * link to the paged URL, and the search is the hero form's GET.
 *
 * assets/js/articles/archive.js adds what is genuinely in-page: the white pill
 * that slides between tabs, the current tab scrolled to the middle of the row,
 * and the fades at either end of a row that scrolls.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

$iflynepal_list_section    = iflynepal_section();
$iflynepal_list_labels     = iflynepal_section_labels();
$iflynepal_list_search     = iflynepal_articles_search_term();
$iflynepal_list_base       = iflynepal_section_archive_url();
$iflynepal_list_term       = iflynepal_section_current_term();
$iflynepal_list_categories = '' === $iflynepal_list_search ? iflynepal_section_categories() : array();
$iflynepal_list_current    = ( $iflynepal_list_term && $iflynepal_list_section && $iflynepal_list_section['category'] === $iflynepal_list_term->taxonomy )
	? (int) $iflynepal_list_term->term_id
	: 0;
$iflynepal_list_page       = max( 1, (int) $wp_query->get( 'paged' ) );
$iflynepal_list_pages      = (int) $wp_query->max_num_pages;
?>
<section class="section post-archive" id="articles" aria-label="<?php echo esc_attr( $iflynepal_list_labels['archive'] ); ?>">
	<div class="container">

		<?php if ( $iflynepal_list_categories ) : ?>
			<div class="post-tabs-wrap" data-anim>
				<nav class="post-tabs" id="ifn-archive-tabs" aria-label="<?php echo esc_attr( $iflynepal_list_labels['categories_nav'] ); ?>">
					<span class="tab-thumb" aria-hidden="true"></span>
					<a class="post-tab" href="<?php echo esc_url( $iflynepal_list_base ); ?>" data-cat="all"<?php echo $iflynepal_list_current ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All', 'iflynepal' ); ?></a>
					<?php foreach ( $iflynepal_list_categories as $iflynepal_list_category ) : ?>
						<span class="tab-sep" aria-hidden="true"></span>
						<a class="post-tab" href="<?php echo esc_url( get_term_link( $iflynepal_list_category ) ); ?>" data-cat="<?php echo esc_attr( $iflynepal_list_category->slug ); ?>"<?php echo (int) $iflynepal_list_category->term_id === $iflynepal_list_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $iflynepal_list_category->name ); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>
		<?php endif; ?>

		<div class="post-grid" id="ifn-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/articles/card', null, array( 'heading' => 'h2' ) );
			endwhile;
			?>
		</div>

		<p class="post-empty" id="ifn-post-empty"<?php echo $wp_query->found_posts ? ' hidden' : ''; ?>><?php echo esc_html( $iflynepal_list_labels['empty'] ); ?></p>

		<?php if ( $iflynepal_list_pages > 1 ) : ?>
			<nav class="post-pagination" id="ifn-pagination" aria-label="<?php echo esc_attr( $iflynepal_list_labels['pages_nav'] ); ?>">
				<?php if ( $iflynepal_list_page > 1 ) : ?>
					<a class="pg-step pg-prev" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_list_page - 1 ) ); ?>" rel="prev"><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H5M11 6l-6 6 6 6"/></svg><?php esc_html_e( 'Previous', 'iflynepal' ); ?></a>
				<?php else : ?>
					<span class="pg-step pg-prev is-disabled"><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H5M11 6l-6 6 6 6"/></svg><?php esc_html_e( 'Previous', 'iflynepal' ); ?></span>
				<?php endif; ?>

				<div class="pg-nums">
					<?php foreach ( iflynepal_articles_pagination_numbers( $iflynepal_list_page, $iflynepal_list_pages ) as $iflynepal_list_num ) : ?>
						<?php if ( null === $iflynepal_list_num ) : ?>
							<span class="pg-dots" aria-hidden="true">&hellip;</span>
						<?php elseif ( $iflynepal_list_num === $iflynepal_list_page ) : ?>
							<span class="pg-num is-current" aria-current="page"><?php echo esc_html( number_format_i18n( $iflynepal_list_num ) ); ?></span>
						<?php else : ?>
							<a class="pg-num" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_list_num ) ); ?>"><?php echo esc_html( number_format_i18n( $iflynepal_list_num ) ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<span class="pg-count"><?php
					printf(
						/* translators: 1: current page number, 2: total pages. */
						esc_html__( 'Page %1$s of %2$s', 'iflynepal' ),
						esc_html( number_format_i18n( $iflynepal_list_page ) ),
						esc_html( number_format_i18n( $iflynepal_list_pages ) )
					);
				?></span>

				<?php if ( $iflynepal_list_page < $iflynepal_list_pages ) : ?>
					<a class="pg-step pg-next" href="<?php echo esc_url( iflynepal_articles_page_url( $iflynepal_list_page + 1 ) ); ?>" rel="next"><?php esc_html_e( 'Next', 'iflynepal' ); ?><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>
				<?php else : ?>
					<span class="pg-step pg-next is-disabled"><?php esc_html_e( 'Next', 'iflynepal' ); ?><svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></span>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

	</div>
</section>
