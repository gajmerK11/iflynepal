<?php
/**
 * Sustainability Policy: the document itself — a sticky index beside fourteen
 * clause cards.
 *
 * The copy is written here rather than pulled from the Customizer. This is a
 * published policy: it is agreed and republished as a whole, not tuned clause
 * by clause by whoever is logged in. Changing the wording is a code change,
 * reviewed like one. The one exception is the coordinator card in clause 06,
 * which names a person rather than a commitment.
 *
 * The clause register — anchors, titles, sub-titles and therefore the numbering
 * and the index — lives in inc/sustainability.php, so the index and the
 * headings cannot drift apart. Only the bodies are written below, each under
 * the anchor its register entry declares.
 *
 * Each sentence is one translatable string with its own `<strong>` inline,
 * rather than a printf with the emphasised phrase passed in — a translator
 * needs the whole sentence to move the emphasis to where their language puts
 * it. The same arrangement as the other legal pages.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-sustain-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<p class="iflynepal-legal-head__kicker">
				<?php esc_html_e( 'The policy in full', 'iflynepal' ); ?>
			</p>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-sustain-title">
				<?php echo wp_kses_post( __( 'Sustainability <span class="underline">Policy</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'Our core values, how they are integrated across operations, and how we keep improving on them.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-sustain-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-sustain-index-title">
					<?php esc_html_e( 'On this page', 'iflynepal' ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-sustain-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_sustainability_index();
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="introduction" aria-labelledby="introduction-title" data-iflynepal-reveal>
					<?php
					// Number, title and sub-title come from the register; all escaped there.
					echo iflynepal_render_sustainability_clause_head( 'introduction' );
					?>
					<div class="iflynepal-legal-clause__body">
						<p><?php echo wp_kses_post( __( 'At iFly Nepal, we believe that tourism should benefit <strong>people, planet, and prosperity</strong>. As a responsible travel company, we are committed to ensuring that our operations protect the natural environment, uplift local communities, and celebrate cultural heritage while providing life-changing experiences for our travellers.', 'iflynepal' ) ); ?></p>
						<p><?php esc_html_e( 'We recognise that sustainability is not just an environmental concern — it is an integrated approach involving ethical business practices, community empowerment, cultural respect, and climate-conscious travel. This policy outlines the commitments, values and practices that guide all aspects of our operations and partnerships.', 'iflynepal' ); ?></p>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="environment" aria-labelledby="environment-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'environment' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Reduce greenhouse gas emissions and <strong>offset unavoidable carbon</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Promote <strong>low-impact travel</strong>, especially trekking, cycling, and nature tours.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Discourage single-use plastics and promote <strong>refillable water systems</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Support biodiversity conservation and <strong>avoid wildlife exploitation</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Adopt energy-efficient, water-saving, and waste-reducing office practices.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="community" aria-labelledby="community-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'community' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Prioritise <strong>local guides, homestays, artisans</strong>, and transport providers.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Invest in community projects such as <strong>school support, health care, and training</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Facilitate voluntourism programmes with <strong>genuine community benefit</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Encourage travellers to shop, eat, and stay local.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="fair-employment" aria-labelledby="fair-employment-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'fair-employment' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Comply with <strong>Nepal’s labour laws</strong> and international human rights standards.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Ensure <strong>fair wages, safe working conditions, and insurance</strong> for all staff and field crew.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Provide regular training and capacity-building for our team.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Maintain a <strong>safe, inclusive, and harassment-free</strong> workplace.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="ethical-conduct" aria-labelledby="ethical-conduct-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'ethical-conduct' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Operate transparently and maintain <strong>financial integrity</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Prohibit bribery, fraud, and corruption</strong> at all levels.', 'iflynepal' ) ); ?></li>
							<li>
								<?php
								// The link is built and escaped inside the render callback.
								echo iflynepal_render_sustainability_policy_link( 'privacy' );
								?>
							</li>
							<li><?php esc_html_e( 'Promote honesty, safety, and respect in all services delivered.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="governance" aria-labelledby="governance-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'governance' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'A dedicated <strong>Sustainability Coordinator</strong> oversees implementation, reporting, and continuous improvement of our policies.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Sustainability is a <strong>standing agenda item</strong> in all management meetings.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'We periodically assess performance through <strong>measurable KPIs</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
						<div id="iflynepal-sustain-coordinator">
							<?php
							// Name and contact details are escaped inside the render callback.
							echo iflynepal_render_sustainability_coordinator();
							?>
						</div>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="in-the-field" aria-labelledby="in-the-field-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'in-the-field' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Educate clients and guides on responsible trekking and <strong>Leave No Trace</strong> principles.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Encourage porters and staff to <strong>collect waste on trails</strong> where possible.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Choose <strong>eco-certified accommodation</strong> and transport services.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Recommend <strong>filtered or boiled water</strong> over bottled water to travellers.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Partner only with suppliers who adhere to fair trade and sustainability standards.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="in-the-office" aria-labelledby="in-the-office-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'in-the-office' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Use <strong>LED lighting</strong>, minimise power use, and follow a “switch off” protocol.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Recycle waste and use <strong>reusable containers</strong> and office supplies.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Print only when necessary and use <strong>FSC-certified or recycled paper</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Offer water stations, avoiding plastic bottles in-office.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="transportation" aria-labelledby="transportation-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'transportation' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Regularly service vehicles for <strong>fuel efficiency and emission control</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Promote the use of <strong>electric vehicles</strong> where possible.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Offset carbon emissions</strong> from flights and transport through verified projects.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="food-beverage" aria-labelledby="food-beverage-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'food-beverage' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Partner with <strong>local farms</strong> and prefer organic, seasonal, and vegetarian options.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Minimise <strong>food waste</strong> in tours and office events.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Provide reusable containers for packed meals and discourage single-use packaging.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cultural-heritage" aria-labelledby="cultural-heritage-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'cultural-heritage' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Provide <strong>cultural briefings</strong> to travellers before tours.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Respect <strong>sacred sites, local customs, and dress codes</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Avoid and discourage purchase of <strong>illicit or unsustainable souvenirs</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="monitoring" aria-labelledby="monitoring-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'monitoring' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Hold <strong>biannual internal reviews</strong> and sustainability training sessions.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Include sustainability feedback in <strong>client post-trip evaluations</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Regularly update policies based on staff input, client feedback, and industry innovations.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Establish a <strong>grievance mechanism</strong> for local stakeholders.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="public-communication" aria-labelledby="public-communication-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'public-communication' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Share our <strong>sustainability progress</strong> on our website and social media.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Engage travellers through <strong>pre-departure materials</strong> and on-trip education.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Promote sustainable tourism advocacy in partnership with <strong>NGOs and networks</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="policies-in-practice" aria-labelledby="policies-in-practice-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_sustainability_clause_head( 'policies-in-practice' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php esc_html_e( 'We operate under specific guiding frameworks, including:', 'iflynepal' ); ?></p>
						<ul class="iflynepal-sustain-frameworks">
							<?php
							// Names are escaped inside the render callback.
							echo iflynepal_render_sustainability_frameworks();
							?>
						</ul>
						<p class="iflynepal-legal-note">
							<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 21c-4.5-2.5-7-6-7-10a7 7 0 0 1 14 0c0 4-2.5 7.5-7 10z"/><path d="M9 13l3-2 3 2"/></svg>
							<span>
								<?php
								// The link is built and escaped inside the render callback.
								echo iflynepal_render_sustainability_policy_link( 'terms' );
								?>
							</span>
						</p>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
