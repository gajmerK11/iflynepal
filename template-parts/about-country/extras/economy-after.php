<?php
/**
 * Economy: the four sectors.
 *
 * The same two-by-two feature grid as the front page's Why-trust bullets, with
 * a paragraph in place of a line — so it carries a block of its own rather than
 * the trust classes, which are sized for one sentence.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-country-sectors" id="iflynepal-country-sectors">
	<?php
	// Copy is kses-filtered and the icon path is kses-filtered to SVG shapes.
	echo iflynepal_render_country_sectors();
	?>
</div>
