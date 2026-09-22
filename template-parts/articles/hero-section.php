<?php
/**
 * The editorial archive hero: the photograph, the headline and the search field.
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
 * by iflynepal_hero_title_words(), since the headline is an editor's to write.
 *
 * Searching swaps the headline for the query and the standfirst for the count.
 * That is a page load: see iflynepal_articles_pre_get_posts().
 *
 * Drawn for both editorial sections. Which one it is drawing, and so which
 * theme mods the hero reads and what its copy calls a piece, comes from
 * inc/sections.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_articles_image  = iflynepal_section_hero_image_url();
$iflynepal_articles_lead   = iflynepal_section_hero_lead();
$iflynepal_articles_search = iflynepal_articles_search_term();
$iflynepal_articles_base   = iflynepal_section_archive_url();
$iflynepal_articles_found  = (int) $GLOBALS['wp_query']->found_posts;
$iflynepal_articles_labels = iflynepal_section_labels();

/*
 * Articles and Blogs are two different Customizer panels reading and writing
 * two different theme mods, but this one template draws the hero for both —
 * so a plain id="hero-title" would be the same id on every page either panel
 * could be previewing. The Customizer's selective-refresh pencil resolves an
 * edit shortcut by matching its registered CSS selector against the preview
 * DOM, with no idea which panel's data actually produced the element it
 * found: both inc/customizer/sections/articles.php and .../blogs.php
 * register a partial for "#hero-title", so on every page — /blogs included —
 * whichever of the two loads first (articles.php does, in customizer.php)
 * wins the id and its pencil, regardless of which section is actually being
 * viewed. Suffixing the id with the section key gives each panel a selector
 * only its own pages ever contain.
 */
$iflynepal_hero_title_id = 'hero-title-' . iflynepal_section_key();
$iflynepal_hero_lead_id  = 'hero-lead-' . iflynepal_section_key();
?>
<section class="hero" aria-labelledby="<?php echo esc_attr( $iflynepal_hero_title_id ); ?>">

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

				<h1 id="<?php echo esc_attr( $iflynepal_hero_title_id ); ?>" class="is-search">
					<span class="w"><?php echo esc_html_x( 'You', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'searched', 'search headline', 'iflynepal' ); ?></span>
					<span class="w"><?php echo esc_html_x( 'for:', 'search headline', 'iflynepal' ); ?></span>
					<em><?php echo esc_html( $iflynepal_articles_search ); ?></em>
				</h1>

				<p class="lead" id="<?php echo esc_attr( $iflynepal_hero_lead_id ); ?>">
					<?php if ( $iflynepal_articles_found ) : ?>
						<?php
						// Escaped inside the helper, which is where the plural is chosen.
						echo iflynepal_section_match_count( $iflynepal_articles_found ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<a class="button button--quiet" href="<?php echo esc_url( $iflynepal_articles_base ); ?>"><?php esc_html_e( 'Clear search', 'iflynepal' ); ?></a>
					<?php else : ?>
						<?php esc_html_e( 'Nothing matched. Try a trek, a region or a festival.', 'iflynepal' ); ?>
						<a class="button button--quiet" href="<?php echo esc_url( $iflynepal_articles_base ); ?>"><?php echo esc_html( $iflynepal_articles_labels['browse_all'] ); ?></a>
					<?php endif; ?>
				</p>

			<?php else : ?>

				<h1 id="<?php echo esc_attr( $iflynepal_hero_title_id ); ?>"><?php echo iflynepal_section_hero_title_html(); ?></h1>

				<?php if ( '' !== $iflynepal_articles_lead || is_customize_preview() ) : ?>
					<p class="lead" id="<?php echo esc_attr( $iflynepal_hero_lead_id ); ?>"><?php echo esc_html( $iflynepal_articles_lead ); ?></p>
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
				<label class="sr-only" for="ifn-search-input"><?php echo esc_html( $iflynepal_articles_labels['search_label'] ); ?></label>
				<svg class="hero-search-ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/></svg>
				<input
					type="search"
					id="ifn-search-input"
					name="<?php echo esc_attr( IFLYNEPAL_ARTICLES_SEARCH_VAR ); ?>"
					value="<?php echo esc_attr( $iflynepal_articles_search ); ?>"
					placeholder="<?php echo esc_attr( iflynepal_section_search_placeholder() ); ?>"
					autocomplete="off"
				>
				<button type="submit" class="button button--primary"><?php esc_html_e( 'Search', 'iflynepal' ); ?></button>
			</form>

		</div>
	</div>

</section>
