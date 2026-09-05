<?php
/**
 * About page vision: one statement on a navy panel, centred, with nothing else
 * in it.
 *
 * Everything editable here lives in Appearance > Customize > About > Company.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-group iflynepal-about-vision" id="vision" data-iflynepal-motion>

	<div class="iflynepal-about-vision__panel" data-iflynepal-reveal>

		<p class="iflynepal-about-vision__kicker" id="iflynepal-about-vision-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_about_vision_title();
			?>
		</p>

		<p class="iflynepal-about-vision__statement" id="iflynepal-about-vision-content">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_about_vision_content();
			?>
		</p>

	</div>

</section>
