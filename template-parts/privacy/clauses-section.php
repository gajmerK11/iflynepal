<?php
/**
 * Privacy Policy: the document itself — a sticky index beside fifteen clause
 * cards.
 *
 * The copy is written here rather than pulled from the Customizer. This is a
 * published policy: it is agreed and republished as a whole, not tuned clause
 * by clause by whoever is logged in. Changing the wording is a code change,
 * reviewed like one.
 *
 * The clause register — anchors, titles, sub-titles and therefore the numbering
 * and the index — lives in inc/privacy.php, so the index and the headings
 * cannot drift apart. Only the bodies are written below, each under the anchor
 * its register entry declares.
 *
 * Each sentence is one translatable string with its own `<strong>` inline,
 * rather than a printf with the emphasised phrase passed in — a translator
 * needs the whole sentence to move the emphasis to where their language puts
 * it. The same arrangement as the Terms & Conditions and Cookie Policy pages.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-privacy-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<p class="iflynepal-legal-head__kicker">
				<?php esc_html_e( 'Your data', 'iflynepal' ); ?>
			</p>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-privacy-title">
				<?php echo wp_kses_post( __( 'Privacy <span class="underline">Policy</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'What we collect, why we collect it, who it is shared with, how long we keep it, and the rights you have over it.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-privacy-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-privacy-index-title">
					<?php esc_html_e( 'On this page', 'iflynepal' ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-privacy-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_privacy_index();
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="who-we-are" aria-labelledby="who-we-are-title" data-iflynepal-reveal>
					<?php
					// Number, title and sub-title come from the register; all escaped there.
					echo iflynepal_render_privacy_clause_head( 'who-we-are' );
					?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li>
								<?php
								printf(
									/* translators: %s: the site's own address, as a link. */
									esc_html__( 'Our website address is %s.', 'iflynepal' ),
									'<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( untrailingslashit( home_url() ) ) . '</a>'
								);
								?>
							</li>
							<li><?php echo wp_kses_post( __( 'We are a leading <strong>travel and adventure agency in Nepal</strong>, offering trekking, cultural tours, retreats, workshops, volunteering, wildlife safaris, and multi-country experiences.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="information-we-collect" aria-labelledby="information-we-collect-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'information-we-collect' ); ?>
					<div class="iflynepal-legal-clause__body">

						<span class="iflynepal-legal-sublabel"><?php esc_html_e( 'Personal information', 'iflynepal' ); ?></span>

						<p><?php esc_html_e( 'We may collect the following when you interact with our site or services:', 'iflynepal' ); ?></p>
						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( '<strong>Name, email address, phone number</strong>, and mailing address.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Passport details</strong> for booking and permit processing.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Travel preferences and <strong>health-related information</strong> (when necessary).', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Feedback, comments, or questions submitted via forms.', 'iflynepal' ); ?></li>
						</ul>

						<span class="iflynepal-legal-sublabel"><?php esc_html_e( 'Payment information', 'iflynepal' ); ?></span>

						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Payments made through our site are securely processed by <strong>trusted third-party providers</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'We <strong>do not store</strong> your credit card or sensitive payment information.', 'iflynepal' ) ); ?></li>
						</ul>

					</div>
				</article>

				<article class="iflynepal-legal-clause" id="automatic-information" aria-labelledby="automatic-information-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'automatic-information' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( '<strong>IP address, device type</strong>, and browser information.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Location data</strong> (if enabled).', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Pages visited, time spent, and click activity.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="tracking-technologies" aria-labelledby="tracking-technologies-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'tracking-technologies' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php esc_html_e( 'We use cookies to improve your browsing experience. Cookies help us:', 'iflynepal' ); ?></p>
						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( 'Remember your <strong>preferences</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Analyse website performance</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Customise content and offers.', 'iflynepal' ); ?></li>
						</ul>
						<p class="iflynepal-legal-note">
							<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M9 9h.01M15 10h.01M10.5 14.5h.01M14.5 15h.01"/></svg>
							<span>
								<?php
								// The link is built and escaped inside the render callback.
								echo iflynepal_render_privacy_cookie_note();
								?>
							</span>
						</p>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="media-uploads" aria-labelledby="media-uploads-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'media-uploads' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'If you upload images (e.g. in blog comments), we advise <strong>removing embedded location data (EXIF GPS)</strong>, as visitors may extract such data.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="comments" aria-labelledby="comments-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'comments' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'We collect the data shown in the <strong>comment form</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'We also collect your <strong>IP address and browser user agent string</strong> to help detect spam.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'If you are using <strong>Gravatar</strong>, an anonymised email string may be used to display your profile photo.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="embedded-content" aria-labelledby="embedded-content-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'embedded-content' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Our blog or informational pages may include <strong>embedded content</strong> (videos, maps, articles, etc.).', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'These behave as if you visited the other website, which <strong>may collect data, use cookies, or track your interaction</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="how-we-use-data" aria-labelledby="how-we-use-data-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'how-we-use-data' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php esc_html_e( 'We use your data to:', 'iflynepal' ); ?></p>
						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( 'Process bookings and issue <strong>confirmations</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Customise itineraries and provide personalised experiences.', 'iflynepal' ); ?></li>
							<li><?php esc_html_e( 'Respond to enquiries and offer customer support.', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'Send newsletters, updates, and promotional content &mdash; <strong>only with your consent</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php esc_html_e( 'Comply with legal requirements or resolve disputes.', 'iflynepal' ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-sharing" aria-labelledby="data-sharing-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'data-sharing' ); ?>
					<div class="iflynepal-legal-clause__body">
						<p><?php echo wp_kses_post( __( 'We <strong>do not sell your data</strong>. We may share information with:', 'iflynepal' ) ); ?></p>
						<ul class="iflynepal-legal-rules iflynepal-legal-rules--spaced">
							<li><?php echo wp_kses_post( __( '<strong>Trusted third-party service providers</strong> (e.g. hotel partners, trekking guides, transportation companies).', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Payment processors</strong> and booking systems.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( '<strong>Legal authorities</strong>, only if required by law.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-retention" aria-labelledby="data-retention-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'data-retention' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php
						/*
						 * The Terms page's refund table, reused: the same term-and-badge
						 * rows, with the badge coloured for what it means — red where
						 * the data is never deleted, green where the reader controls it.
						 */
						?>
						<div class="iflynepal-legal-refunds">
							<div class="iflynepal-legal-refunds__row iflynepal-legal-refunds__row--warn">
								<span><?php esc_html_e( 'Comments and related metadata', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( 'Stored indefinitely', 'iflynepal' ); ?></b>
							</div>
							<div class="iflynepal-legal-refunds__row">
								<span><?php esc_html_e( 'Booking and contact data', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( 'Administrative, legal or tax purposes', 'iflynepal' ); ?></b>
							</div>
							<div class="iflynepal-legal-refunds__row iflynepal-legal-refunds__row--ok">
								<span><?php esc_html_e( 'Account information, if you create an account', 'iflynepal' ); ?></span>
								<b><?php esc_html_e( 'Editable by you at any time', 'iflynepal' ); ?></b>
							</div>
						</div>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="your-rights" aria-labelledby="your-rights-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'your-rights' ); ?>
					<div class="iflynepal-legal-clause__body">
						<div class="iflynepal-privacy-rights">
							<?php
							// Titles and text are escaped inside the render callback.
							echo iflynepal_render_privacy_rights();
							?>
						</div>
						<p class="iflynepal-legal-note">
							<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
							<span>
								<?php
								// The address is escaped inside the render callback.
								echo iflynepal_render_privacy_contact_note();
								?>
							</span>
						</p>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-security" aria-labelledby="data-security-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'data-security' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'We implement <strong>secure protocols</strong> to safeguard your personal data.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'While no system is completely immune, we strive to maintain the <strong>highest standards</strong> in data protection.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-transfers" aria-labelledby="data-transfers-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'data-transfers' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'Visitor comments may be checked through an <strong>automated spam detection service</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Booking data may be securely transferred to <strong>local service providers</strong> as needed for trip operations.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="third-party-links" aria-labelledby="third-party-links-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'third-party-links' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php esc_html_e( 'Our website may link to third-party sites (e.g. insurance providers, affiliate travel blogs).', 'iflynepal' ); ?></li>
							<li><?php echo wp_kses_post( __( 'We are <strong>not responsible for the privacy practices</strong> of these websites.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="policy-changes" aria-labelledby="policy-changes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_privacy_clause_head( 'policy-changes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<ul class="iflynepal-legal-rules">
							<li><?php echo wp_kses_post( __( 'We may update this Privacy Policy from time to time. Updates will be <strong>posted on this page</strong>.', 'iflynepal' ) ); ?></li>
							<li><?php echo wp_kses_post( __( 'Significant changes will be communicated via <strong>email or site notification</strong>.', 'iflynepal' ) ); ?></li>
						</ul>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
