<?php
/**
 * News archive hero: the photograph, the kicker, the headline and the search.
 *
 * The approved design's markup, class for class. It is the Articles archive's
 * hero with one addition — the "News Center" kicker above the headline, which
 * is what the rule in assets/css/news.css draws the two short rules either
 * side of.
 *
 * The headline's words are wrapped in `.w` spans in the markup rather than
 * being split by script, as the design has them, so the entrance can stagger
 * them without JavaScript having to touch the text first.
 *
 * Searching swaps the headline for the query and the standfirst for the count.
 * That is a page load: see iflynepal_news_pre_get_posts().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_image  = iflynepal_news_archive_hero_image_url();
$iflynepal_news_lead   = iflynepal_news_hero_lead();
$iflynepal_news_search = iflynepal_news_search_term();
$iflynepal_news_base   = iflynepal_news_archive_url();
$iflynepal_news_found  = (int) $GLOBALS['wp_query']->found_posts;
?>
<section class="hero" aria-labelledby="hero-title">

	<?php if ( $iflynepal_news_image ) : ?>
		<div class="hero-media">
			<img
				src="<?php echo esc_url( $iflynepal_news_image ); ?>"
				alt=""
				fetchpriority="high"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-copy">

			<span class="eyebrow news-kicker"><?php esc_html_e( 'News Center', 'iflynepal' ); ?></span>

			<?php if ( '' !== $iflynepal_news_search ) : ?>

				<h1 id="hero-title" class="is-search">
					<span class="w"><?php echo esc_html_x( 'You', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'searched', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'for:', 'search headline', 'iflynepal' ); ?></span>
					<em><?php echo esc_html( $iflynepal_news_search ); ?></em>
				</h1>

				<p class="lead" id="hero-lead">
					<?php if ( $iflynepal_news_found ) : ?>
						<?php
						printf(
							/* translators: %s: number of matching stories. */
							esc_html( _n( '%s story matches.', '%s stories match.', $iflynepal_news_found, 'iflynepal' ) ),
							esc_html( number_format_i18n( $iflynepal_news_found ) )
						);
						?>
						<a href="<?php echo esc_url( $iflynepal_news_base ); ?>"><?php esc_html_e( 'Clear search', 'iflynepal' ); ?></a>.
					<?php else : ?>
						<?php esc_html_e( 'Nothing matched. Try a trek, a region or a festival, or', 'iflynepal' ); ?>
						<a href="<?php echo esc_url( $iflynepal_news_base ); ?>"><?php esc_html_e( 'see all the news', 'iflynepal' ); ?></a>.
					<?php endif; ?>
				</p>

			<?php else : ?>

				<h1 id="hero-title">
					<span class="w"><?php echo esc_html_x( 'Stay', 'archive headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'updated', 'archive headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'with', 'archive headline', 'iflynepal' ); ?></span>
					<em><?php echo esc_html_x( 'iFly Nepal', 'archive headline', 'iflynepal' ); ?></em>
				</h1>

				<?php if ( '' !== $iflynepal_news_lead || is_customize_preview() ) : ?>
					<p class="lead" id="hero-lead"><?php echo esc_html( $iflynepal_news_lead ); ?></p>
				<?php endif; ?>

			<?php endif; ?>

			<form
				class="hero-search"
				id="ifn-search"
				role="search"
				method="get"
				action="<?php echo esc_url( $iflynepal_news_base ); ?>"
				data-anim="hero"
				data-hero-step="2"
			>
				<label class="sr-only" for="ifn-search-input"><?php esc_html_e( 'Search news', 'iflynepal' ); ?></label>
				<svg class="hero-search-ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/></svg>
				<input
					type="search"
					id="ifn-search-input"
					name="<?php echo esc_attr( IFLYNEPAL_NEWS_SEARCH_VAR ); ?>"
					value="<?php echo esc_attr( $iflynepal_news_search ); ?>"
					placeholder="<?php echo esc_attr( iflynepal_news_search_placeholder() ); ?>"
					autocomplete="off"
				>
				<button type="submit" class="button button--primary"><?php esc_html_e( 'Search', 'iflynepal' ); ?></button>
			</form>

		</div>
	</div>

</section>
