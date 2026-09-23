<?php
/**
 * One article card, in the archive grid and in the related row.
 *
 * Called inside a loop, so it reads the current post. The design's markup,
 * class for class: the theme's trip card carrying the editorial body, with the
 * picture a second link to the same article — hidden from the accessibility
 * tree and out of the tab order, because the title link beneath says the same
 * thing in words.
 *
 * @since 1.0.0
 *
 * @package IFly_Nepal
 *
 * @var array $args {
 *     @type string $heading  Heading level for the title. 'h2' in the archive
 *                            grid, where the card is a top-level item; 'h3' in
 *                            the related row, which sits under an h2 of its own.
 *     @type bool   $anim     Whether the card opts into the scroll reveal.
 *     @type string $type_pill Corner badge on the picture, e.g. "Article" or
 *                            "Blog". Only the mixed grid on an author's own
 *                            page passes one — see template-parts/authors/
 *                            author-layout.php; everywhere else the grid is
 *                            already all one type, so a label would repeat
 *                            what the page already says.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_card_heading  = isset( $args['heading'] ) && 'h3' === $args['heading'] ? 'h3' : 'h2';
$iflynepal_card_anim     = ! empty( $args['anim'] );
$iflynepal_card_type_pill = isset( $args['type_pill'] ) ? (string) $args['type_pill'] : '';
$iflynepal_card_id       = get_the_ID();
$iflynepal_card_link     = get_permalink();
$iflynepal_card_category = iflynepal_article_primary_category( $iflynepal_card_id );
$iflynepal_card_author   = get_the_author();
$iflynepal_card_initials = iflynepal_article_initials( $iflynepal_card_author );
?>
<article class="trip-card post-card"<?php echo $iflynepal_card_category ? ' data-cat="' . esc_attr( $iflynepal_card_category->slug ) . '"' : ''; ?><?php echo $iflynepal_card_anim ? ' data-anim' : ''; ?>>
	<a class="trip-img post-img" href="<?php echo esc_url( $iflynepal_card_link ); ?>" tabindex="-1" aria-hidden="true"><?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail(
				'large',
				array(
					'alt'     => '',
					'loading' => 'lazy',
					'sizes'   => '(max-width: 680px) 100vw, (max-width: 1020px) 50vw, 33vw',
				)
			);
		}

		if ( '' !== $iflynepal_card_type_pill ) {
			printf( '<span class="pill">%s</span>', esc_html( $iflynepal_card_type_pill ) );
		}
	?></a>
	<div class="trip-body post-body">
		<div class="trip-meta post-meta"><?php
			if ( $iflynepal_card_category ) {
				printf(
					'<a class="post-cat" href="%1$s">%2$s</a>',
					esc_url( get_term_link( $iflynepal_card_category ) ),
					esc_html( $iflynepal_card_category->name )
				);
			}
		?><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time></div>
		<<?php echo esc_html( $iflynepal_card_heading ); ?> class="post-title"><a href="<?php echo esc_url( $iflynepal_card_link ); ?>"><?php echo esc_html( iflynepal_article_plain_title() ); ?></a></<?php echo esc_html( $iflynepal_card_heading ); ?>>
		<p class="post-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '&hellip;' ) ); ?></p>
		<div class="trip-foot post-foot"><span class="post-author"><?php
			if ( '' !== $iflynepal_card_initials ) {
				printf(
					'<span class="post-avatar" aria-hidden="true">%s</span>',
					esc_html( $iflynepal_card_initials )
				);
			}
			echo esc_html( $iflynepal_card_author );
		?></span><a href="<?php echo esc_url( $iflynepal_card_link ); ?>" aria-label="
		<?php
		printf(
			/* translators: %s: the article's title. */
			esc_attr__( 'Read %s', 'iflynepal' ),
			esc_attr( iflynepal_article_plain_title() )
		);
		?>
		"><?php esc_html_e( 'Read', 'iflynepal' ); ?> <svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a></div>
	</div>
</article>
