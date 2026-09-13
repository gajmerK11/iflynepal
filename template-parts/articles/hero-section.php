<?php
/**
 * Articles archive hero: the photograph, the headline and the search field.
 *
 * The markup is the approved design's, class for class, and it is styled by
 * assets/css/articles.css rather than by the theme's own hero component. The
 * two are the same hero — the same scrim, the same headline scale, the same
 * shine on the accent word — but the design shortens it for an archive and
 * puts a search capsule where the other heroes have buttons, and matching that
 * exactly is the point here.
 *
 * The headline's words are wrapped in `.w` spans in the markup rather than
 * being split by script, as the design has them, so the entrance can stagger
 * them without JavaScript having to touch the text first. The wrapping is done
 * by iflynepal_articles_hero_title_html(), since the headline is an editor's
 * to write.
 *
 * Searching swaps the headline for the query and the standfirst for the count.
 * That is a page load: see iflynepal_articles_pre_get_posts().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_articles_image  = iflynepal_articles_hero_image_url();
$iflynepal_articles_lead   = iflynepal_articles_hero_lead();
$iflynepal_articles_search = iflynepal_articles_search_term();
$iflynepal_articles_base   = iflynepal_articles_archive_url();
$iflynepal_articles_found  = (int) $GLOBALS['wp_query']->found_posts;
?>
<section class="hero" aria-labelledby="hero-title">

	<?php if ( $iflynepal_articles_image ) : ?>
		<div class="hero-media">
			<img
				src="<?php echo esc_url( $iflynepal_articles_image ); ?>"
				alt=""
				fetchpriority="high"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-copy">

			<?php if ( '' !== $iflynepal_articles_search ) : ?>

				<h1 id="hero-title" class="is-search">
					<span class="w"><?php echo esc_html_x( 'You', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'searched', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'for:', 'search headline', 'iflynepal' ); ?></span>
					<em><?php echo esc_html( $iflynepal_articles_search ); ?></em>
				</h1>

				<p class="lead" id="hero-lead">
					<?php if ( $iflynepal_articles_found ) : ?>
						<?php
						printf(
							/* translators: %s: number of matching articles. */
							esc_html( _n( '%s article matches.', '%s articles match.', $iflynepal_articles_found, 'iflynepal' ) ),
							esc_html( number_format_i18n( $iflynepal_articles_found ) )
						);
						?>
						<a class="button button--quiet" href="<?php echo esc_url( $iflynepal_articles_base ); ?>"><?php esc_html_e( 'Clear search', 'iflynepal' ); ?></a>
					<?php else : ?>
						<?php esc_html_e( 'Nothing matched. Try a trek, a region or a festival.', 'iflynepal' ); ?>
						<a class="button button--quiet" href="<?php echo esc_url( $iflynepal_articles_base ); ?>"><?php esc_html_e( 'Browse every article', 'iflynepal' ); ?></a>
					<?php endif; ?>
				</p>

			<?php else : ?>

				<h1 id="hero-title"><?php echo iflynepal_articles_hero_title_html(); ?></h1>

				<?php if ( '' !== $iflynepal_articles_lead || is_customize_preview() ) : ?>
					<p class="lead" id="hero-lead"><?php echo esc_html( $iflynepal_articles_lead ); ?></p>
				<?php endif; ?>

			<?php endif; ?>

			<form
				class="hero-search"
				id="ifn-search"
				role="search"
				method="get"
				action="<?php echo esc_url( $iflynepal_articles_base ); ?>"
				data-anim="hero"
				data-hero-step="2"
			>
				<label class="sr-only" for="ifn-search-input"><?php esc_html_e( 'Search articles', 'iflynepal' ); ?></label>
				<svg class="hero-search-ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/></svg>
				<input
					type="search"
					id="ifn-search-input"
					name="<?php echo esc_attr( IFLYNEPAL_ARTICLES_SEARCH_VAR ); ?>"
					value="<?php echo esc_attr( $iflynepal_articles_search ); ?>"
					placeholder="<?php echo esc_attr( iflynepal_articles_search_placeholder() ); ?>"
					autocomplete="off"
				>
				<button type="submit" class="button button--primary"><?php esc_html_e( 'Search', 'iflynepal' ); ?></button>
			</form>

		</div>
	</div>

</section>
