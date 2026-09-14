<?php
/**
 * Single article hero: the photograph and the title, and nothing else.
 *
 * Full viewport, unlike the archive's — the design shortens the archive hero
 * under the shared route class and undoes that here, so the piece opens on the
 * picture and the headline alone, and the details sit below the fold with the
 * breadcrumb.
 *
 * The headline's words are wrapped in `.w` spans so the entrance can stagger
 * them, exactly as the design's markup has them. One word of the design's
 * title is the gold accent; since the title is the editor's, the way to ask
 * for that here is to italicise a word in the title field — an `<em>` is left
 * whole and picks up the accent, and everything around it is split into words.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_single_image = iflynepal_section_single_hero_image_url();
?>
<section class="hero post-hero" aria-labelledby="hero-title">

	<?php if ( $iflynepal_single_image ) : ?>
		<div class="hero-media">
			<img
				src="<?php echo esc_url( $iflynepal_single_image ); ?>"
				alt=""
				fetchpriority="high"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-copy">
			<h1 id="hero-title"><?php
				// Escaped word by word inside the helper; <em> is the only tag kept.
				echo iflynepal_article_headline( get_the_title() );
			?></h1>
		</div>
	</div>

</section>
