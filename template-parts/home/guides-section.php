<?php
/**
 * The planning section: questions on the left, travel guides on the right.
 *
 * Two columns that read as one section but are edited separately, under
 * Appearance > Customize > FAQ / Travel Guide.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-group iflynepal-guides" id="guides">
	<div class="iflynepal-guides__inner">

		<div class="iflynepal-guides__column" data-iflynepal-reveal>
			<p class="iflynepal-guides__kicker" id="iflynepal-faq-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_faq_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-guides__title" id="iflynepal-faq-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_faq_title();
				?>
			</h2>

			<div class="iflynepal-guides__faq" id="iflynepal-faq-items">
				<?php
				// Questions are escaped and answers kses-filtered in the render callback.
				echo iflynepal_render_faq_items();
				?>
			</div>

			<div class="iflynepal-guides__link-wrap" id="iflynepal-faq-cta">
				<?php
				// Label and URL are escaped inside the render callback.
				echo iflynepal_render_faq_cta();
				?>
			</div>
		</div>

		<div class="iflynepal-guides__column" data-iflynepal-reveal>
			<p class="iflynepal-guides__kicker" id="iflynepal-guide-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_guide_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-guides__title" id="iflynepal-guide-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_guide_title();
				?>
			</h2>

			<div class="iflynepal-guides__cards" id="iflynepal-guide-posts">
				<?php
				// Titles are escaped and images built by wp_get_attachment_image().
				echo iflynepal_render_guide_posts();
				?>
			</div>

			<div class="iflynepal-guides__link-wrap" id="iflynepal-guide-cta">
				<?php
				// Label and URL are escaped inside the render callback.
				echo iflynepal_render_guide_cta();
				?>
			</div>
		</div>

	</div>
</section>
