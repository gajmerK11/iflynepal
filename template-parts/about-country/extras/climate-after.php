<?php
/**
 * Climate: the comparison table, then the packing lists.
 *
 * The table is deliberately not editable. It is six readings across three
 * cities with a two-row header, which a Customizer form would turn into
 * eighteen numeric fields nobody could check at a glance, and the averages
 * change on the order of decades. The same reasoning covers the two packing
 * lists: they are a fixed checklist the client supplied, not marketing copy.
 * Changing any of it is a template edit, which is the honest cost.
 *
 * The heading and paragraph between the two are editable, because those are
 * the parts that get reworded.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-country-table" data-iflynepal-reveal>
	<table class="iflynepal-country-climate">
		<thead>
			<tr>
				<th scope="col" rowspan="2"><?php esc_html_e( 'Place', 'iflynepal' ); ?></th>
				<th scope="colgroup" colspan="3"><?php esc_html_e( 'Summer (May, June, July)', 'iflynepal' ); ?></th>
				<th scope="colgroup" colspan="3"><?php esc_html_e( 'Winter (Dec, Jan, Feb)', 'iflynepal' ); ?></th>
			</tr>
			<tr>
				<th scope="col"><?php esc_html_e( 'Max (°C)', 'iflynepal' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Min (°C)', 'iflynepal' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Rain (mm)', 'iflynepal' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Max (°C)', 'iflynepal' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Min (°C)', 'iflynepal' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Rain (mm)', 'iflynepal' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row"><?php esc_html_e( 'Kathmandu', 'iflynepal' ); ?></th>
				<td class="is-summer">28.1</td>
				<td class="is-summer">19.5</td>
				<td class="is-summer">312</td>
				<td class="is-winter">19.3</td>
				<td class="is-winter">3.0</td>
				<td class="is-winter">15.4</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Pokhara', 'iflynepal' ); ?></th>
				<td class="is-summer">29.7</td>
				<td class="is-summer">21.3</td>
				<td class="is-summer">829.7</td>
				<td class="is-winter">20.3</td>
				<td class="is-winter">7.7</td>
				<td class="is-winter">26.3</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Chitwan', 'iflynepal' ); ?></th>
				<td class="is-summer">33.0</td>
				<td class="is-summer">25.3</td>
				<td class="is-summer">404.0</td>
				<td class="is-winter">24.1</td>
				<td class="is-winter">8.3</td>
				<td class="is-winter">13.8</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="iflynepal-country-chapter__head iflynepal-country-chapter__head--bring" data-iflynepal-reveal>
	<h2 class="wp-block-heading iflynepal-country-chapter__heading" id="iflynepal-country-bring-title">
		<?php
		// Sanitized by iflynepal_kses_text() on save and again on read.
		echo iflynepal_render_country_bring_title();
		?>
	</h2>
</div>

<div class="iflynepal-country-prose" id="iflynepal-country-bring-prose" data-iflynepal-reveal>
	<?php
	// Each paragraph is kses-filtered inside the render callback.
	echo iflynepal_render_country_bring_prose();
	?>
</div>

<div class="iflynepal-country-packing" data-iflynepal-reveal>
	<section class="iflynepal-country-packing__list">
		<h3><?php esc_html_e( 'Recommended Items', 'iflynepal' ); ?></h3>
		<ul>
			<li><b><?php esc_html_e( 'Basic First Aid Kit:', 'iflynepal' ); ?></b> <?php esc_html_e( 'A full supply of any medication you require for the duration of your stay, along with the prescription.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Contact Lenses (if applicable):', 'iflynepal' ); ?></b> <?php esc_html_e( 'Spare lenses and enough solution.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Torch / Flashlight:', 'iflynepal' ); ?></b> <?php esc_html_e( 'A head torch is especially useful during power cuts.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Sleeping Bag / Sleeping Bag Liner:', 'iflynepal' ); ?></b> <?php esc_html_e( '(depending on season)', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Footwear:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Hiking boots', 'iflynepal' ); ?></li>
			<li><?php esc_html_e( 'Flip-flops', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Outerwear:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Waterproof jacket (a lightweight fold-away jacket is fine)', 'iflynepal' ); ?></li>
			<li><?php esc_html_e( 'Fleece jacket (during winter months)', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Clothing:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Light-weight cotton clothing', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Insect Protection:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Mosquito repellent', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Sun Protection:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Sun cream', 'iflynepal' ); ?></li>
			<li><?php esc_html_e( 'Sunglasses', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Water Purification:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Water purification tablets and/or high-quality water purifier', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Air Quality Protection:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Face mask (depending on the time of year, Kathmandu can become very polluted and dusty).', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Documentation:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Passport photos (you’ll need these for trekking permits, buying a SIM card, and for your Cheers volunteer card).', 'iflynepal' ); ?></li>
		</ul>
	</section>
	<section class="iflynepal-country-packing__list">
		<h3><?php esc_html_e( 'Optional Items', 'iflynepal' ); ?></h3>
		<ul>
			<li><b><?php esc_html_e( 'Currency:', 'iflynepal' ); ?></b> <?php esc_html_e( 'A few examples of your local currency.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Language Aid:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Basic Learner’s English/Nepali dictionary.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Creative Supplies:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Coloured pencils and pens, drawing books, stickers.', 'iflynepal' ); ?></li>
			<li><b><?php esc_html_e( 'Educational Resources:', 'iflynepal' ); ?></b> <?php esc_html_e( 'Books/materials on teaching English/English Grammar for your reference.', 'iflynepal' ); ?></li>
		</ul>
	</section>
</div>
