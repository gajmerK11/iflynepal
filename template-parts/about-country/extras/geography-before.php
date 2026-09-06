<?php
/**
 * Geography: the note under the banner.
 *
 * The two ends of the country's altitude range, called out before the prose
 * because the figures are what the chapter is remembered for. It sits between
 * the banner and the copy, which is why it is a "-before" extra.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-country-note" data-iflynepal-reveal>
	<span class="iflynepal-country-note__label" id="iflynepal-country-note-label">
		<?php
		// Escaped inside the render callback.
		echo iflynepal_render_country_note_label();
		?>
	</span>
	<h3 class="iflynepal-country-note__title" id="iflynepal-country-note-title">
		<?php
		// Sanitized by iflynepal_kses_text() on save and again on read.
		echo iflynepal_render_country_note_title();
		?>
	</h3>
	<p class="iflynepal-country-note__text" id="iflynepal-country-note-text">
		<?php
		// Sanitized by iflynepal_kses_text() on save and again on read.
		echo iflynepal_render_country_note_text();
		?>
	</p>
</div>
