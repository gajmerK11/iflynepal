<?php
/**
 * Single news story hero: the photograph, the flag, the headline, the ticker.
 *
 * The design reads this the way a news front reads a lead photograph — the
 * headline sits low and left over a bottom-heavy shade, under a kicker saying
 * what kind of story it is, and the latest headlines run along the foot of the
 * picture. That shape is the `.news-hero` rules in assets/css/news.css undoing
 * the centred article hero above them.
 *
 * The ticker's list is written out twice, the second copy hidden from the
 * accessibility tree and out of the tab order, because the animation that
 * scrolls it moves the track by half its width — one copy's worth — and so
 * loops without a seam.
 *
 * The headline's words are wrapped in `.w` spans so the entrance can stagger
 * them, exactly as the design's markup has them. One phrase of the design's
 * title is the gold accent; since the title is the editor's, the way to ask
 * for that here is to italicise a word in the title field.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_hero_image  = iflynepal_news_hero_image_url();
$iflynepal_news_hero_topic  = iflynepal_news_topic();
$iflynepal_news_hero_ticker = iflynepal_news_latest( IFLYNEPAL_NEWS_LATEST, (int) get_the_ID() );
?>
<section class="hero post-hero news-hero" aria-labelledby="hero-title">

	<?php if ( $iflynepal_news_hero_image ) : ?>
		<div class="hero-media">
			<img
				src="<?php echo esc_url( $iflynepal_news_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-copy news-hero-copy">
			<div class="news-kicker-row">
				<span class="news-flag"><i aria-hidden="true"></i><?php esc_html_e( 'News', 'iflynepal' ); ?></span>
				<?php if ( '' !== $iflynepal_news_hero_topic ) : ?>
					<span class="news-topic"><?php echo esc_html( $iflynepal_news_hero_topic ); ?></span>
				<?php endif; ?>
			</div>
			<h1 id="hero-title"><?php
				// Escaped word by word inside the helper; <em> is the only tag kept.
				echo iflynepal_article_headline( get_the_title() );
			?></h1>
		</div>
	</div>

	<?php if ( $iflynepal_news_hero_ticker ) : ?>
		<div class="news-ticker" role="region" aria-label="<?php esc_attr_e( 'Latest news', 'iflynepal' ); ?>">
			<span class="news-ticker-label"><?php esc_html_e( 'Latest', 'iflynepal' ); ?></span>
			<div class="news-ticker-window">
				<ul class="news-ticker-track"><?php
				foreach ( array( false, true ) as $iflynepal_news_hero_copy ) {
					foreach ( $iflynepal_news_hero_ticker as $iflynepal_news_hero_item ) {
						printf(
							'<li%1$s><time datetime="%2$s">%3$s</time><a href="%4$s"%5$s>%6$s</a></li>',
							$iflynepal_news_hero_copy ? ' aria-hidden="true"' : '',
							esc_attr( get_the_date( 'Y-m-d', $iflynepal_news_hero_item ) ),
							esc_html( get_the_date( 'j M', $iflynepal_news_hero_item ) ),
							esc_url( get_permalink( $iflynepal_news_hero_item ) ),
							$iflynepal_news_hero_copy ? ' tabindex="-1"' : '',
							esc_html( iflynepal_article_plain_title( $iflynepal_news_hero_item ) )
						);
					}
				}
				?></ul>
			</div>
		</div>
	<?php endif; ?>

</section>
