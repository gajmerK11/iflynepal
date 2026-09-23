<?php
/**
 * The Top News row: the three stories an editor has flagged to lead the page.
 *
 * The approved design's markup, class for class. The band is left out
 * altogether when nothing is flagged — three empty columns would read as a
 * fault rather than as an editorial choice — and the archive's own run of
 * stories below carries the same three again, which is how the design has it.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_top_stories = iflynepal_news_top_stories();

if ( ! $iflynepal_top_stories ) {
	return;
}

$iflynepal_top_note = iflynepal_news_top_note();
?>
<section class="news-section" id="top-news" aria-labelledby="top-news-title" data-hide-on-search>
	<div class="container">

		<div class="news-head" data-anim>
			<div>
				<span class="eyebrow"><?php echo esc_html( iflynepal_news_top_eyebrow() ); ?></span>
				<h2 id="top-news-title"><?php echo iflynepal_news_top_heading_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses filtered. ?></h2>
			</div>
			<?php if ( '' !== $iflynepal_top_note ) : ?>
				<p><?php echo esc_html( $iflynepal_top_note ); ?></p>
			<?php endif; ?>
		</div>

		<div class="top-grid">
			<?php
			foreach ( $iflynepal_top_stories as $iflynepal_top_story ) :
				$GLOBALS['post'] = $iflynepal_top_story; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Restored by wp_reset_postdata() below.
				setup_postdata( $iflynepal_top_story );

				get_template_part(
					'template-parts/news/card',
					null,
					array( 'variant' => 'top' )
				);
			endforeach;

			wp_reset_postdata();
			?>
		</div>

	</div>
</section>
