<?php
/**
 * The single article's body, with the sidebar beside it.
 *
 * The design's two-column layout: a sticky card on the left holding the
 * contributors, the share control and the table of contents, and the post
 * itself on the right. Under 1080px the sidebar comes off and a copy of the
 * index sits above the post instead — both copies carry the same links, and
 * assets/js/articles/single.js keeps the two in step.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_main_body = iflynepal_article_body();
?>
<section class="post-main" aria-label="<?php esc_attr_e( 'Article', 'iflynepal' ); ?>">
	<div class="container post-layout">

		<?php
		get_template_part(
			'template-parts/articles/single-aside',
			null,
			array( 'headings' => $iflynepal_main_body['headings'] )
		);
		?>

		<div class="post-col">

			<?php if ( $iflynepal_main_body['headings'] ) : ?>
				<div class="toc-mobile">
					<h2 class="aside-label" id="toc-title-m"><?php esc_html_e( 'On this page', 'iflynepal' ); ?></h2>
					<nav class="index-list" aria-labelledby="toc-title-m">
						<?php foreach ( $iflynepal_main_body['headings'] as $iflynepal_main_heading ) : ?>
							<a href="#<?php echo esc_attr( $iflynepal_main_heading['id'] ); ?>"><?php echo esc_html( $iflynepal_main_heading['text'] ); ?></a>
						<?php endforeach; ?>
					</nav>
				</div>
			<?php endif; ?>

			<article class="post-content">
				<?php
				/*
				 * Editor content, already through the_content filters — the
				 * same escaping every other WordPress template relies on — and
				 * then through iflynepal_article_body(), which only adds ids
				 * and class names.
				 */
				echo $iflynepal_main_body['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				wp_link_pages(
					array(
						'before' => '<nav class="post-pages">',
						'after'  => '</nav>',
					)
				);
				?>
			</article>

		</div>

	</div>
</section>
