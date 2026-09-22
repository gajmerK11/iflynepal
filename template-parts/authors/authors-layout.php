<?php
/**
 * The Authors directory.
 *
 * CloudColleague's template-parts/authors/authors-layout.php, redrawn against
 * author-archive-design.html: the same short archive hero the Articles and
 * News archives use, then a grid of every author who has a published Blog,
 * Article or News story.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$iflynepal_authors = iflynepal_authors_list();
?>

<main id="primary" class="site-main ifn-retreats-page ifn-articles-page ifn-authors-page">

	<?php
	/*
	 * Suffixed the same way, and for the same reason, as the id in
	 * template-parts/articles/hero-section.php: inc/customizer/sections/
	 * articles.php and .../blogs.php both register a selective-refresh
	 * partial for "#hero-title", loading before .../authors.php does, so a
	 * bare id="hero-title" here would hand this page's pencil to whichever of
	 * those two panels' partials the Customizer resolves first rather than to
	 * Authors' own.
	 */
	?>
	<section class="hero" aria-labelledby="hero-title-authors">
		<div class="hero-media">
			<img
				src="<?php echo esc_url( iflynepal_authors_hero_image_url() ); ?>"
				alt=""
				fetchpriority="high"
				decoding="sync"
			>
		</div>

		<div class="container hero-inner">
			<div class="hero-copy">
				<span class="eyebrow"><?php esc_html_e( 'Our writers', 'iflynepal' ); ?></span>
				<h1 id="hero-title-authors"><?php echo iflynepal_authors_hero_title_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_hero_title_words() escapes via iflynepal_kses_text(). ?></h1>

				<?php $iflynepal_lead = iflynepal_authors_hero_lead(); ?>
				<?php if ( '' !== $iflynepal_lead || is_customize_preview() ) : ?>
					<p class="lead" id="hero-lead-authors"><?php echo esc_html( $iflynepal_lead ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="section authors-list" id="authors" aria-labelledby="authors-title">
		<div class="container">
			<div class="section-head" data-anim>
				<span class="eyebrow"><?php esc_html_e( 'Authors', 'iflynepal' ); ?></span>
				<h2 id="authors-title">
					<?php
					echo wp_kses( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses escapes.
						__( 'Written in <span class="ink-mark">Kathmandu<i class="ink-line"></i></span>', 'iflynepal' ),
						array(
							'span' => array( 'class' => array() ),
							'i'    => array( 'class' => array() ),
						)
					);
					?>
				</h2>
				<p class="lead"><?php esc_html_e( 'Every article carries the byline of the desk it came from. Follow one to read everything they have published.', 'iflynepal' ); ?></p>
			</div>

			<?php if ( ! empty( $iflynepal_authors ) ) : ?>
				<div class="authors-grid">
					<?php foreach ( $iflynepal_authors as $iflynepal_author ) : ?>
						<?php
						$iflynepal_author_id  = $iflynepal_author->ID;
						$iflynepal_author_url = get_author_posts_url( $iflynepal_author_id );
						$iflynepal_role       = iflynepal_author_role( $iflynepal_author_id );
						$iflynepal_photo_id   = iflynepal_author_photo_id( $iflynepal_author_id );
						$iflynepal_socials    = iflynepal_author_social_links( $iflynepal_author_id );
						?>
						<article class="author-card" data-anim>

							<?php if ( $iflynepal_photo_id ) : ?>
								<a class="author-card-photo" href="<?php echo esc_url( $iflynepal_author_url ); ?>" tabindex="-1" aria-hidden="true">
									<?php
									echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-escaped markup.
										$iflynepal_photo_id,
										'medium',
										false,
										array( 'loading' => 'lazy' )
									);
									?>
								</a>
							<?php endif; ?>

							<div class="author-card-body">
								<h2><a href="<?php echo esc_url( $iflynepal_author_url ); ?>"><?php echo esc_html( $iflynepal_author->display_name ); ?></a></h2>
								<?php if ( '' !== $iflynepal_role ) : ?>
									<p class="author-card-role"><?php echo esc_html( $iflynepal_role ); ?></p>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $iflynepal_socials ) ) : ?>
								<div class="author-card-socials">
									<?php foreach ( $iflynepal_socials as $iflynepal_social ) : ?>
										<a href="<?php echo esc_url( $iflynepal_social['url'] ); ?>" target="_blank" rel="noopener noreferrer"
											aria-label="<?php echo esc_attr( sprintf( /* translators: 1: author's name, 2: social network. */ __( '%1$s on %2$s', 'iflynepal' ), $iflynepal_author->display_name, $iflynepal_social['label'] ) ); ?>">
											<?php echo $iflynepal_social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup, no input. ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<a class="author-card-link" href="<?php echo esc_url( $iflynepal_author_url ); ?>">
								<?php esc_html_e( 'Read their articles', 'iflynepal' ); ?>
								<svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="authors-foot">
				<a class="button button--primary" href="<?php echo esc_url( iflynepal_articles_archive_url() ); ?>">
					<?php esc_html_e( 'Browse all articles', 'iflynepal' ); ?>
					<svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
				</a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
