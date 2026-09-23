<?php
/**
 * A single author's page.
 *
 * CloudColleague's template-parts/authors/author-layout.php, redrawn against
 * author-single-design.html: the banner photograph, the avatar pulled up
 * over it, the name and role, the social row and post/topic counts, a
 * breadcrumb, the bio (opening paragraphs, expertise pills, Experience and
 * Contribution), and the author's own recent writing across whichever of
 * Blogs, Articles and News they have published in.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$iflynepal_author = get_queried_object();

if ( ! $iflynepal_author instanceof WP_User ) {
	get_footer();
	return;
}
?>

<?php
/*
 * No `site-main` on this <main>, deliberately. That class carries
 * `:not(.has-iflynepal-hero) .site-main{padding-top:92px}` (main.css), the
 * clearance a page with a solid-from-load header needs. This page's header
 * is solid from load too (iflynepal_dock_header_on_author()), but the
 * banner right under it already reaches the very top of the document, the
 * same way the package plugin's hero-less single template does. Adding the
 * 92px here left a visible band of plain white between the bottom of the
 * docked header and the top of the banner, the gap the padding is sized
 * for on a page that has no image to sit flush against.
 */
?>
<main id="primary" class="ifn-retreats-page ifn-articles-page ifn-author-page">

	<section class="author-banner" aria-hidden="true">
		<img src="<?php echo esc_url( iflynepal_author_banner_image_url() ); ?>" alt="">
	</section>

	<section class="author-head" aria-labelledby="author-name">
		<div class="container">
			<div class="author-avatar">
				<?php
				// Core-escaped markup; iflynepal_author_custom_avatar_data() swaps in the uploaded photo when there is one.
				echo get_avatar( $iflynepal_author->ID, 343, '', esc_attr( $iflynepal_author->display_name ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>

			<span class="eyebrow"><?php esc_html_e( 'Author', 'iflynepal' ); ?></span>
			<h1 id="author-name"><?php echo esc_html( $iflynepal_author->display_name ); ?></h1>

			<?php
			$iflynepal_role = iflynepal_author_role( $iflynepal_author->ID );
			$iflynepal_hand = iflynepal_author_hand_note( $iflynepal_author->ID );

			if ( '' !== $iflynepal_role ) :
				?>
				<p class="author-role">
					<?php echo esc_html( $iflynepal_role ); ?>
					<?php if ( '' !== $iflynepal_hand ) : ?>
						<span class="author-hand"><?php echo esc_html( $iflynepal_hand ); ?></span>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<?php
			$iflynepal_socials = iflynepal_author_social_links( $iflynepal_author->ID );

			if ( ! empty( $iflynepal_socials ) ) :
				?>
				<div class="author-socials">
					<?php foreach ( $iflynepal_socials as $iflynepal_social ) : ?>
						<a class="author-social" href="<?php echo esc_url( $iflynepal_social['url'] ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo $iflynepal_social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup, no input. ?>
							<?php echo esc_html( $iflynepal_social['label'] ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	</section>

	<section class="author-crumbs-strip" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iflynepal' ); ?>">
		<div class="container">
			<nav class="post-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iflynepal' ); ?>" data-anim>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iflynepal' ); ?></a>
				<svg class="crumb-sep" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
				<a href="<?php echo esc_url( iflynepal_authors_archive_url() ); ?>"><?php esc_html_e( 'Authors', 'iflynepal' ); ?></a>
				<svg class="crumb-sep" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
				<span aria-current="page"><?php echo esc_html( $iflynepal_author->display_name ); ?></span>
			</nav>
		</div>
	</section>

	<?php if ( iflynepal_author_has_bio( $iflynepal_author->ID ) ) : ?>
		<section class="author-bio" aria-labelledby="bio-title">
			<div class="container">
				<h2 class="sr-only" id="bio-title">
					<?php
					printf(
						/* translators: %s: author's display name. */
						esc_html__( 'About %s', 'iflynepal' ),
						esc_html( $iflynepal_author->display_name )
					);
					?>
				</h2>

				<?php $iflynepal_bio = iflynepal_author_bio_html( $iflynepal_author->ID ); ?>
				<?php if ( '' !== $iflynepal_bio ) : ?>
					<div class="bio-lede" data-anim><?php echo $iflynepal_bio; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_author_bio_html() escapes. ?></div>
				<?php endif; ?>

				<?php $iflynepal_pills = iflynepal_author_expertise_pills( $iflynepal_author->ID ); ?>
				<?php if ( ! empty( $iflynepal_pills ) ) : ?>
					<div class="bio-card" data-anim>
						<h2><?php esc_html_e( 'Expertise', 'iflynepal' ); ?></h2>
						<div class="bio-pills">
							<?php foreach ( $iflynepal_pills as $iflynepal_pill ) : ?>
								<a href="<?php echo esc_url( $iflynepal_pill['url'] ); ?>"><?php echo esc_html( $iflynepal_pill['name'] ); ?></a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php $iflynepal_experience = iflynepal_author_experience_html( $iflynepal_author->ID ); ?>
				<?php if ( '' !== $iflynepal_experience ) : ?>
					<div class="bio-block" data-anim>
						<h2><?php esc_html_e( 'Experience', 'iflynepal' ); ?></h2>
						<?php echo $iflynepal_experience; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_author_experience_html() escapes. ?>
					</div>
				<?php endif; ?>

				<?php $iflynepal_contribution = iflynepal_author_contribution_html( $iflynepal_author->ID ); ?>
				<?php if ( '' !== $iflynepal_contribution ) : ?>
					<div class="bio-block" data-anim>
						<h2>
							<?php
							/*
							 * The site's own name, literal rather than
							 * bloginfo( 'name' ): the option holds
							 * "iFlyNepal" with no space, one word, while
							 * every brand mention in this theme's own
							 * markup (the footer's, the front page's)
							 * writes the two-word "iFly Nepal" the design
							 * always means.
							 */
							echo wp_kses( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses escapes.
								__( 'Contribution at <span class="ink-mark">iFly Nepal<i class="ink-line"></i></span>', 'iflynepal' ),
								array(
									'span' => array( 'class' => array() ),
									'i'    => array( 'class' => array() ),
								)
							);
							?>
						</h2>
						<?php echo $iflynepal_contribution; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_author_contribution_html() escapes. ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php
	$iflynepal_posts = iflynepal_author_posts( $iflynepal_author->ID );

	if ( ! empty( $iflynepal_posts ) ) :
		$iflynepal_post_flags = iflynepal_author_post_type_flags( $iflynepal_author->ID );
		?>
		<section class="section section--mist author-posts" id="posts" aria-labelledby="posts-title">
			<div class="container">
				<div class="section-head" data-anim>
					<span class="eyebrow"><?php esc_html_e( 'From this author', 'iflynepal' ); ?></span>
					<h2 id="posts-title">
						<?php
						printf(
							'%1$s <span class="ink-mark">%2$s<i class="ink-line"></i></span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Both pieces are escaped below.
							esc_html__( 'Read my', 'iflynepal' ),
							esc_html( iflynepal_author_content_label( $iflynepal_post_flags ) )
						);
						?>
					</h2>
					<p class="lead"><?php esc_html_e( 'Trek guides, retreat stories and trip news, written by the people who plan the journeys.', 'iflynepal' ); ?></p>
				</div>

				<div class="post-grid">
					<?php
					global $post;

					foreach ( $iflynepal_posts as $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Restored by wp_reset_postdata() below; the card partials read the loop.
						setup_postdata( $post );

						if ( IFLYNEPAL_NEWS_POST_TYPE === get_post_type() ) {
							get_template_part(
								'template-parts/news/card',
								null,
								array(
									'variant'   => 'related',
									'type_pill' => __( 'News', 'iflynepal' ),
								)
							);
						} elseif ( IFLYNEPAL_ARTICLE_POST_TYPE === get_post_type() ) {
							get_template_part(
								'template-parts/articles/card',
								null,
								array(
									'heading'   => 'h2',
									'type_pill' => __( 'Article', 'iflynepal' ),
								)
							);
						} else {
							get_template_part(
								'template-parts/articles/card',
								null,
								array(
									'heading'   => 'h2',
									'type_pill' => __( 'Blog', 'iflynepal' ),
								)
							);
						}
					endforeach;

					wp_reset_postdata();
					?>
				</div>

				<?php $iflynepal_actions = iflynepal_author_post_type_actions( $iflynepal_author->ID ); ?>
				<?php if ( ! empty( $iflynepal_actions ) ) : ?>
					<div class="author-posts-foot">
						<?php foreach ( $iflynepal_actions as $iflynepal_action ) : ?>
							<a class="button <?php echo esc_attr( $iflynepal_action['style'] ); ?>" href="<?php echo esc_url( $iflynepal_action['url'] ); ?>">
								<?php echo esc_html( $iflynepal_action['label'] ); ?>
								<svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

</main><!-- #primary -->

<?php
get_footer();
