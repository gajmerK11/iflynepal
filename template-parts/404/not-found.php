<?php
/**
 * Not Found: the whole of the 404 page.
 *
 * Two columns on a mist band — the copy and the way out on the left, the drawn
 * numeral on the right — carrying the same furniture as every other section on
 * the site: the navy kicker, the display heading with its inked underline, the
 * gold primary action.
 *
 * No page hero here on purpose. A hero is a photograph and a promise, and this
 * page has nothing to promise: the visitor is lost and wants the shortest route
 * out, which is the heading, two buttons and three signposts, all above the
 * fold.
 *
 * Everything editable here lives in Appearance > Customize > Not Found (404).
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-group iflynepal-404 iflynepal-section--mist" data-iflynepal-motion>
	<div class="iflynepal-404__inner">

		<div class="iflynepal-404__copy">

			<p class="iflynepal-404__kicker" id="iflynepal-404-kicker" data-iflynepal-reveal>
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_404_kicker();
				?>
			</p>

			<h1 class="wp-block-heading iflynepal-404__title" id="iflynepal-404-title" data-iflynepal-reveal>
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_404_title();
				?>
			</h1>

			<p class="iflynepal-404__lead" id="iflynepal-404-lead" data-iflynepal-reveal>
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_404_lead();
				?>
			</p>

			<div class="iflynepal-404__actions" id="iflynepal-404-actions" data-iflynepal-reveal>
				<?php
				// Labels and the home URL are escaped inside the render callback.
				echo iflynepal_render_404_actions();
				?>
			</div>

			<?php
			/*
			 * Dropped rather than printed empty when every label has been
			 * cleared: a bare rule under the buttons with nothing on it reads as
			 * something that failed to load.
			 */
			?>
			<?php if ( iflynepal_404_links() ) : ?>
				<ul class="iflynepal-404__links" id="iflynepal-404-links" data-iflynepal-reveal>
					<?php
					// Labels, URLs and sub-lines are escaped inside the render callback.
					echo iflynepal_render_404_links();
					?>
				</ul>
			<?php endif; ?>

		</div>

		<?php
		/*
		 * The numeral. Drawn in the stylesheet rather than uploaded, and hidden
		 * from assistive technology — the kicker beside it already says "404
		 * error", and the number read out twice is noise.
		 */
		?>
		<div class="iflynepal-404__figure" aria-hidden="true" data-iflynepal-reveal>
			<p class="iflynepal-404__numeral">404</p>
		</div>

	</div>
</section>
