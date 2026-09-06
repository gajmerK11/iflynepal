<?php
/**
 * Visa: the fee schedule, then the trekking-permit note.
 *
 * The schedule is deliberately not editable. It is roughly fifteen numbered
 * clauses of government fee regulation whose lettering ("2(a)", "1(b)") is
 * cross-referenced inside the clauses themselves, so a Customizer form that
 * let an editor add, remove or reorder them would quietly break those
 * references. When the Department of Immigration changes a fee, this template
 * is the place to change it — which is also the place a developer would check
 * the wording against the source.
 *
 * The permit note below it is editable, because it is the one part written in
 * the company's own voice rather than transcribed.
 *
 * A schedule is looked up rather than read start to finish, so it folds. The
 * first block is open because it is the one every visitor needs.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="iflynepal-country-schedule" data-iflynepal-reveal>

	<details open>
		<summary><?php esc_html_e( 'Tourist visa', 'iflynepal' ); ?></summary>
		<p><?php esc_html_e( 'Foreigner who intends to visit Nepal must hold valid passport or any travel document equivalent to passport issued by the government. for visiting a foreign country prior to apply for visa.', 'iflynepal' ); ?></p>
		<p><b><?php esc_html_e( 'a. Entry:', 'iflynepal' ); ?></b> <?php esc_html_e( 'No foreigner is entitled to enter into and stay in Nepal without valid visa. Tourist entry visa can be obtained for the following duration from Nepalese Embassy or Consulate or other mission offices or immigration offices located on entry points in Nepal.', 'iflynepal' ); ?></p>
		<p><?php esc_html_e( 'b. Chinese citizen are requested to apply in Nepalese Embassy or other Nepalese diplomatic missions as there is no provision of on arrival visa for them.', 'iflynepal' ); ?></p>
	</details>

	<details>
		<summary><?php esc_html_e( 'c. Visa Fee', 'iflynepal' ); ?></summary>

		<h4><?php esc_html_e( '1. Fee required to obtain Tourist Visa from Nepalese diplomatic agencies and entry points:', 'iflynepal' ); ?></h4>
		<ul class="iflynepal-country-fee">
			<li><span class="iflynepal-country-fee__key">a</span><span><?php esc_html_e( 'US $ 25 or equivalent foreign currency for Tourist Visa with Multiple Entry for 15 days.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">b</span><span><?php esc_html_e( 'US $ 40 or equivalent foreign currency for Tourist Visa with Multiple Entry for 30 days.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">c</span><span><?php esc_html_e( 'US $ 100 or equivalent foreign currency for Tourist Visa with Multiple Entry for 100 days.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">d</span><span><?php esc_html_e( 'Regardless of the provision stated in 1(a) and 1(b), tourists with passport from South Asian Association for Regional Cooperation (SAARC) nations aren’t required to pay visa fee for 30 days.', 'iflynepal' ); ?></span></li>
		</ul>

		<h4><?php esc_html_e( '2. Fee to be levied for renewal or regularization of tourist visa', 'iflynepal' ); ?></h4>
		<ul class="iflynepal-country-fee">
			<li><span class="iflynepal-country-fee__key">a</span><span><?php esc_html_e( 'Nepalese currency equivalent to US $ 2 per day to renew the validity of tourist visa.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">b</span><span><?php esc_html_e( 'If multiple entry facility is required to be valid for the renewed period, additional US $ 20 along with fees prescribed in 2 (a) has to be paid.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">c</span><span><?php esc_html_e( 'Foreigner who have stayed here without renewing visa, need to pay Nepalese currency equivalent to US $ 3 per day along with the reqired extension fee.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">d</span><span><?php esc_html_e( 'Foreigners, who have already overstayed for more than 150 days without renewing tourist visa shall be levied the fees referred in clause 2(c) and a penalty of Rs 50,000 as per the Immigration Act.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">e</span><span><?php esc_html_e( 'Regardless of provision stated in 2(a), 15 days is counted as minimum extension period and visa fee is charged accordingly. For extension period more than 15 days, visa fee is charged as per the provision of 2(a).', 'iflynepal' ); ?></span></li>
		</ul>
	</details>

	<details>
		<summary><?php esc_html_e( 'Note', 'iflynepal' ); ?></summary>
		<ul class="iflynepal-country-fee">
			<li><span class="iflynepal-country-fee__key">&mdash;</span><span><?php esc_html_e( 'The tourist visa shall be granted for a period in maximum of 150 days in a visa year (Visa years means January to December).', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">&mdash;</span><span><?php esc_html_e( 'A tourist who has departed before the expiry of the period specified in the visa issued in a visa year shall not be allowed to use the visa by adding the remaining period to another visa year.', 'iflynepal' ); ?></span></li>
			<li><span class="iflynepal-country-fee__key">&mdash;</span><span><?php esc_html_e( 'However, foreigner visitors, who have entered the country towards the end of a visa year, can use the remainder of his visa period in another visa year.', 'iflynepal' ); ?></span></li>
		</ul>
	</details>

</div>

<div class="iflynepal-country-permit" data-iflynepal-reveal>
	<span class="iflynepal-country-permit__mark">
		<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
			<path d="M6 3h9l4 4v14H6z"/>
			<path d="M14.5 3v4.5H19"/>
			<path d="M9 13h6M9 17h4"/>
		</svg>
	</span>
	<div>
		<h3 class="iflynepal-country-permit__title" id="iflynepal-country-permit-title">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_country_permit_title();
			?>
		</h3>
		<p class="iflynepal-country-permit__text" id="iflynepal-country-permit-text">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_country_permit_text();
			?>
		</p>
	</div>
</div>
