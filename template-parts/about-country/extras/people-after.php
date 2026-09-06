<?php
/**
 * People: the four regional cards.
 *
 * A photograph with the group's name laid over it — the same card the front
 * page's Explore section uses, with the hover-reveal dropped, because on a
 * reference page the name is the point rather than a tease.
 *
 * The grid is rendered even when every card has been removed, so the fragment
 * the Customizer replaces is still on the page and adding one back updates in
 * place rather than needing a full reload. An empty grid takes no space.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-country-bands" id="iflynepal-country-bands">
	<?php
	// Titles are kses-filtered and images escaped inside the render callback.
	echo iflynepal_render_country_bands();
	?>
</div>
