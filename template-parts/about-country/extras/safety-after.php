<?php
/**
 * Safety: the checklist.
 *
 * Every line here is something to do or not do, so the chapter is the list —
 * it has no prose block of its own.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<ul class="iflynepal-country-safety" id="iflynepal-country-safety" data-iflynepal-reveal>
	<?php
	// Each point is kses-filtered inside the render callback.
	echo iflynepal_render_country_safety();
	?>
</ul>
