<?php
/**
 * One news card, in three dresses.
 *
 * Called inside a loop, so it reads the current post. The design's markup,
 * class for class: the theme's trip card carrying the editorial body, with the
 * picture a second link to the same story — hidden from the accessibility tree
 * and out of the tab order, because the title link beneath says the same thing
 * in words.
 *
 * The three the design draws:
 *
 *   top      a tall card in the Top News row, with the gold corner pill;
 *   list     a horizontal card in the run of recent stories, the picture beside
 *            the body rather than above it;
 *   related  the row under a story, which labels itself with the section and
 *            the date the way an article card labels itself with its category.
 *
 * The first two put the date under the byline rather than above the title,
 * which is the `.news-byline` stack; the third keeps the articles' meta row.
 *
 * @since 1.0.0
 *
 * @package IFly_Nepal
 *
 * @var array $args {
 *     @type string $variant   One of 'top', 'list' or 'related'. Default 'list'.
 *     @type string $type_pill  Corner badge on the picture, e.g. "News". Only
 *                             the mixed grid on an author's own page passes
 *                             one (see template-parts/authors/author-layout.php)
 *                             and only for the 'related' variant — 'top'
 *                             already carries its own "Top news" pill.
 *     @type string $avatar_url The author's own uploaded photo, replacing the
 *                             initials disc. Same author-grid-only condition
 *                             as $type_pill; see articles/card.php's own copy
 *                             of this doc for why.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_card_variant    = isset( $args['variant'] ) ? (string) $args['variant'] : 'list';
$iflynepal_news_card_type_pill  = 'related' === $iflynepal_news_card_variant && isset( $args['type_pill'] ) ? (string) $args['type_pill'] : '';
$iflynepal_news_card_avatar_url = 'related' === $iflynepal_news_card_variant && isset( $args['avatar_url'] ) ? (string) $args['avatar_url'] : '';
$iflynepal_news_card_link    = get_permalink();
$iflynepal_news_card_author  = get_the_author();
$iflynepal_news_card_avatar  = iflynepal_article_initials( $iflynepal_news_card_author );
$iflynepal_news_card_classes = 'trip-card post-card';

if ( 'top' === $iflynepal_news_card_variant ) {
	$iflynepal_news_card_classes .= ' top-card';
} elseif ( 'list' === $iflynepal_news_card_variant ) {
	$iflynepal_news_card_classes .= ' news-card';
}

/* translators: %s: the story's title. */
$iflynepal_news_card_read = sprintf( __( 'Read: %s', 'iflynepal' ), iflynepal_article_plain_title() );
?>
<article class="<?php echo esc_attr( $iflynepal_news_card_classes ); ?>"<?php echo 'top' === $iflynepal_news_card_variant ? '' : ' data-cat="news"'; ?><?php echo 'list' === $iflynepal_news_card_variant ? '' : ' data-anim'; ?>>
	<a class="trip-img post-img" href="<?php echo esc_url( $iflynepal_news_card_link ); ?>" tabindex="-1" aria-hidden="true"><?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail(
				'large',
				array(
					'alt'     => '',
					'loading' => 'lazy',
					'sizes'   => '(max-width: 760px) 100vw, (max-width: 1200px) 50vw, 33vw',
				)
			);
		}

		if ( 'top' === $iflynepal_news_card_variant ) {
			printf(
				'<span class="pill pill--gold">%s</span>',
				esc_html__( 'Top news', 'iflynepal' )
			);
		} elseif ( '' !== $iflynepal_news_card_type_pill ) {
			printf( '<span class="pill">%s</span>', esc_html( $iflynepal_news_card_type_pill ) );
		}
	?></a>
	<div class="trip-body post-body">
		<?php if ( 'related' === $iflynepal_news_card_variant ) : ?>
			<div class="trip-meta post-meta"><a class="post-cat" href="<?php echo esc_url( iflynepal_news_archive_url() ); ?>"><?php esc_html_e( 'News', 'iflynepal' ); ?></a><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time></div>
		<?php endif; ?>
		<h3 class="post-title"><a href="<?php echo esc_url( $iflynepal_news_card_link ); ?>"><?php echo esc_html( iflynepal_article_plain_title() ); ?></a></h3>
		<p class="post-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30, '&hellip;' ) ); ?></p>
		<div class="trip-foot post-foot"><span class="post-author"><?php
			if ( '' !== $iflynepal_news_card_avatar_url ) {
				printf(
					'<span class="post-avatar post-avatar--photo" aria-hidden="true"><img src="%s" alt="" loading="lazy"></span>',
					esc_url( $iflynepal_news_card_avatar_url )
				);
			} elseif ( '' !== $iflynepal_news_card_avatar ) {
				printf(
					'<span class="post-avatar" aria-hidden="true">%s</span>',
					esc_html( $iflynepal_news_card_avatar )
				);
			}

			if ( 'related' === $iflynepal_news_card_variant ) {
				echo esc_html( $iflynepal_news_card_author );
			} else {
				printf(
					'<span class="news-byline"><b>%1$s</b><time datetime="%2$s">%3$s</time></span>',
					esc_html( $iflynepal_news_card_author ),
					esc_attr( get_the_date( 'Y-m-d' ) ),
					esc_html( get_the_date( 'j M Y' ) )
				);
			}
		?></span><a href="<?php echo esc_url( $iflynepal_news_card_link ); ?>" aria-label="<?php echo esc_attr( $iflynepal_news_card_read ); ?>"><?php esc_html_e( 'Read', 'iflynepal' ); ?> <svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a></div>
	</div>
</article>
