<?php
/**
 * About page "What we offer": a centred head, then the offerings as rows on a
 * twelve-column field, each a photograph with a card laid over it, alternating
 * sides down the page.
 *
 * Everything editable here lives in Appearance > Customize > About > Company.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-group iflynepal-section--mist iflynepal-about-offers" id="offer" data-iflynepal-motion>
	<div class="iflynepal-about-offers__inner">

		<div class="iflynepal-about-offers__head" data-iflynepal-reveal>
			<p class="iflynepal-about-offers__kicker" id="iflynepal-about-offer-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_about_offer_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-about-offers__heading" id="iflynepal-about-offer-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_about_offer_title();
				?>
			</h2>
			<p class="iflynepal-about-offers__lead" id="iflynepal-about-offer-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_about_offer_lead();
				?>
			</p>
		</div>

		<div class="iflynepal-about-offers__rows" id="iflynepal-about-offers">
			<?php
			// Copy is kses-filtered and images escaped inside the render callback.
			echo iflynepal_render_about_offers();
			?>
		</div>

	</div>
</section>
