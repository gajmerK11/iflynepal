<?php
/**
 * Cookie Policy: the document itself — a sticky index beside five clause cards.
 *
 * The copy is written here rather than pulled from the Customizer. This is a
 * published policy: it is agreed and republished as a whole, not tuned clause
 * by clause by whoever is logged in. Changing the wording is a code change,
 * reviewed like one.
 *
 * The clause register — anchors, titles, sub-titles and therefore the numbering
 * and the index — lives in inc/cookie.php, so the index and the headings cannot
 * drift apart. Only the bodies are written below, each under the anchor its
 * register entry declares.
 *
 * Each sentence is one translatable string with its own `<strong>` inline,
 * rather than a printf with the emphasised phrase passed in — a translator
 * needs the whole sentence to move the emphasis to where their language puts
 * it. The same arrangement as the Terms & Conditions page.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-cookie-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<p class="iflynepal-legal-head__kicker">
				<?php esc_html_e( 'The policy in full', 'iflynepal' ); ?>
			</p>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-cookie-title">
				<?php echo wp_kses_post( __( 'Cookie <span class="underline">Policy</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'What cookies are, whose cookies run on our pages, how to manage them, and how this policy changes over time.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-cookie-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-cookie-index-title">
					<?php esc_html_e( 'On this page', 'iflynepal' ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-cookie-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_cookie_index();
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="what-are-cookies" aria-labelledby="what-are-cookies-title" data-iflynepal-reveal>
					<?php
					// Number, title and sub-title come from the register; all escaped there.
					echo iflynepal_render_cookie_clause_head( 'what-are-cookies' );
					?>
					<div class="iflynepal-legal-clause__body">
						<p><?php echo wp_kses_post( __( 'Cookies are <strong>small data files stored on your device</strong> when you visit our site. They help us improve your experience, remember your preferences, and analyse site traffic.', 'iflynepal' ) ); ?></p>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cookie-types" aria-labelledby="cookie-types-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_cookie_clause_head( 'cookie-types' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( '<strong>Essential cookies</strong> — necessary for basic site functionality, such as security, navigation and booking.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Analytical cookies</strong> — we use tools like Google Analytics to understand how visitors interact with our website. These cookies are anonymous and help us improve site performance.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Functional cookies</strong> — these remember your preferences, such as language or region, to enhance your experience.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Advertising cookies</strong> — we may partner with advertising networks, such as Facebook or Google Ads, to display relevant ads based on your browsing behaviour.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="third-party-cookies" aria-labelledby="third-party-cookies-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_cookie_clause_head( 'third-party-cookies' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Our site may contain <strong>embedded content</strong> — videos or social media buttons, for example — which may place its own cookies.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'We <strong>do not control these cookies</strong>. Please refer to the policies of the sites they come from.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cookie-management" aria-labelledby="cookie-management-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_cookie_clause_head( 'cookie-management' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php esc_html_e( 'You can manage or disable cookies in your browser settings:', 'iflynepal' ); ?></p>
						<div class="iflynepal-cookie-browsers">
							<?php
							// Names and links are escaped inside the render callback.
							echo iflynepal_render_cookie_browsers();
							?>
						</div>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="policy-updates" aria-labelledby="policy-updates-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_cookie_clause_head( 'policy-updates' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php echo wp_kses_post( __( 'We may revise this Cookie Policy to reflect changes in <strong>law or technology</strong>. Check back periodically to stay informed.', 'iflynepal' ) ); ?></p>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
