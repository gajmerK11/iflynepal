<?php
/**
 * About Nepal index bar: the sticky row of chapter links under the header.
 *
 * Nine chapters is too many to scroll past hunting for one, so the bar docks
 * under the header and marks where the reader is. It is built from the
 * chapters that are actually shown, so hiding one in the Customizer drops its
 * link rather than leaving an anchor pointing at nothing.
 *
 * The active link is set by assets/js/about-country/index-bar.js. With
 * JavaScript off the links still work — they are ordinary fragment links; only
 * the "you are here" mark is missing.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_country_visible_chapters() ) {
	return;
}
?>
<nav class="iflynepal-country-index" aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>">
	<div class="iflynepal-country-index__scroll" id="iflynepal-country-index">
		<?php
		// Labels are escaped inside the render callback.
		echo iflynepal_render_country_index();
		?>
	</div>
</nav>
