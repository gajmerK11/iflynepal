<?php
/**
 * Flora and Fauna: the four vegetation regions.
 *
 * The same rows as the About page's "What we offer" — a photograph with a
 * numbered card laid over it, alternating sides down the page — so they carry
 * the same `iflynepal-about-offer` classes and take their layout from the same
 * stylesheet block rather than a copy of it.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-about-offers__rows iflynepal-country-regions" id="iflynepal-country-regions">
	<?php
	// Copy is kses-filtered and images escaped inside the render callback.
	echo iflynepal_render_country_regions();
	?>
</div>
