<?php
/**
 * "More from the News Center": four more stories, and a way to the archive.
 *
 * The design's markup, class for class — the mist section with the drawn
 * underline in its heading, one row of four cards, and the button on its own
 * rule underneath.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_related = iflynepal_news_related();

if ( ! $iflynepal_news_related ) {
	return;
}
?>
<section class="section section--mist related" aria-labelledby="related-title">
	<div class="container">

		<div class="section-head" data-anim>
			<span class="eyebrow"><?php esc_html_e( 'Other news', 'iflynepal' ); ?></span>
			<h2 id="related-title"><?php
				printf(
					/* translators: %s: the words "News Center", which carry the drawn underline. */
					esc_html__( 'More from the %s.', 'iflynepal' ),
					'<span class="ink-mark">' . esc_html__( 'News Center', 'iflynepal' ) . '<i class="ink-line"></i></span>'
				);
			?></h2>
			<p class="lead"><?php esc_html_e( 'The latest trip news and announcements from our team in Kathmandu.', 'iflynepal' ); ?></p>
		</div>

		<div class="related-grid">
			<?php
			foreach ( $iflynepal_news_related as $iflynepal_news_related_story ) :
				$GLOBALS['post'] = $iflynepal_news_related_story; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Restored by wp_reset_postdata() below.
				setup_postdata( $iflynepal_news_related_story );

				get_template_part(
					'template-parts/news/card',
					null,
					array( 'variant' => 'related' )
				);
			endforeach;

			wp_reset_postdata();
			?>
		</div>

		<div class="related-foot">
			<a class="button button--primary" href="<?php echo esc_url( iflynepal_news_archive_url() ); ?>"><?php esc_html_e( 'View all news', 'iflynepal' ); ?> <svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>
		</div>

	</div>
</section>
