<?php
/**
 * "From the articles": four more pieces, and a way to the whole category.
 *
 * The design's markup, class for class — the mist section with the drawn
 * underline in its heading, two rows of two cards, and the button on its own
 * rule underneath.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_related_posts = iflynepal_section_related_posts();

if ( ! $iflynepal_related_posts ) {
	return;
}

$iflynepal_related_labels   = iflynepal_section_labels();
$iflynepal_related_category = iflynepal_section_primary_category( get_the_ID() );
$iflynepal_related_all      = $iflynepal_related_category
	? get_term_link( $iflynepal_related_category )
	: iflynepal_section_archive_url();
$iflynepal_related_label    = $iflynepal_related_category
	? sprintf(
		/* translators: %s: the category's name, lowercased. */
		__( 'View all %s', 'iflynepal' ),
		strtolower( $iflynepal_related_category->name )
	)
	: $iflynepal_related_labels['view_all'];
?>
<section class="section section--mist related" aria-labelledby="related-title">
	<div class="container">

		<div class="section-head" data-anim>
			<span class="eyebrow"><?php echo esc_html( $iflynepal_related_labels['related_eyebrow'] ); ?></span>
			<h2 id="related-title"><?php
				printf(
					/* translators: %s: the word "reading", which carries the drawn underline. */
					esc_html__( 'Keep %s.', 'iflynepal' ),
					'<span class="ink-mark">' . esc_html__( 'reading', 'iflynepal' ) . '<i class="ink-line"></i></span>'
				);
			?></h2>
			<p class="lead"><?php echo esc_html( $iflynepal_related_labels['related_lead'] ); ?></p>
		</div>

		<div class="related-grid">
			<?php
			foreach ( $iflynepal_related_posts as $iflynepal_related_post ) :
				$GLOBALS['post'] = $iflynepal_related_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Restored by wp_reset_postdata() below.
				setup_postdata( $iflynepal_related_post );

				get_template_part(
					'template-parts/articles/card',
					null,
					array(
						'heading' => 'h3',
						'anim'    => true,
					)
				);
			endforeach;

			wp_reset_postdata();
			?>
		</div>

		<div class="related-foot">
			<a class="button button--primary" href="<?php echo esc_url( $iflynepal_related_all ); ?>"><?php echo esc_html( $iflynepal_related_label ); ?> <svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>
		</div>

	</div>
</section>
