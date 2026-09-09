<?php
/**
 * Cookie Policy: the four cookie types, above the policy itself.
 *
 * A summary of clause 02 rather than a separate claim: a reader who wants to
 * know what is set on their device and switch it off should not have to read
 * a numbered policy first. The wording is deliberately the same as the clause
 * it summarises — if one changes, change both.
 *
 * Not editable, for the same reason the clauses are not; see inc/cookie.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-legal"
	id="types"
	aria-labelledby="iflynepal-cookie-types-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<p class="iflynepal-legal-head__kicker">
				<?php esc_html_e( 'Types of cookies we use', 'iflynepal' ); ?>
			</p>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-cookie-types-title">
				<?php echo wp_kses_post( __( 'Four kinds, and <span class="underline">what each does</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'Only the first is required for the site to work. The other three you can decline in your browser at any time.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-cookie-types">

			<article class="iflynepal-cookie-type" data-iflynepal-reveal>
				<div class="iflynepal-cookie-type__icon" aria-hidden="true">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
				</div>
				<small class="iflynepal-cookie-type__eyebrow"><?php esc_html_e( 'Type 01', 'iflynepal' ); ?></small>
				<h3 class="wp-block-heading iflynepal-cookie-type__title"><?php esc_html_e( 'Essential Cookies', 'iflynepal' ); ?></h3>
				<p class="iflynepal-cookie-type__text"><?php esc_html_e( 'Necessary for basic site functionality — security, navigation, and booking.', 'iflynepal' ); ?></p>
				<span class="iflynepal-cookie-type__tag iflynepal-cookie-type__tag--required"><?php esc_html_e( 'Always on', 'iflynepal' ); ?></span>
			</article>

			<article class="iflynepal-cookie-type" data-iflynepal-reveal>
				<div class="iflynepal-cookie-type__icon" aria-hidden="true">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false"><path d="M3 3v18h18"/><path d="m7 15 4-5 3 3 5-7"/></svg>
				</div>
				<small class="iflynepal-cookie-type__eyebrow"><?php esc_html_e( 'Type 02', 'iflynepal' ); ?></small>
				<h3 class="wp-block-heading iflynepal-cookie-type__title"><?php esc_html_e( 'Analytical Cookies', 'iflynepal' ); ?></h3>
				<p class="iflynepal-cookie-type__text"><?php esc_html_e( 'Tools like Google Analytics show us how visitors use the site. These cookies are anonymous and help us improve performance.', 'iflynepal' ); ?></p>
				<span class="iflynepal-cookie-type__tag"><?php esc_html_e( 'Optional', 'iflynepal' ); ?></span>
			</article>

			<article class="iflynepal-cookie-type" data-iflynepal-reveal>
				<div class="iflynepal-cookie-type__icon" aria-hidden="true">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false"><path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3"/><path d="M1 14h6M9 8h6M17 16h6"/></svg>
				</div>
				<small class="iflynepal-cookie-type__eyebrow"><?php esc_html_e( 'Type 03', 'iflynepal' ); ?></small>
				<h3 class="wp-block-heading iflynepal-cookie-type__title"><?php esc_html_e( 'Functional Cookies', 'iflynepal' ); ?></h3>
				<p class="iflynepal-cookie-type__text"><?php esc_html_e( 'Remember your preferences — such as language or region — to improve your experience.', 'iflynepal' ); ?></p>
				<span class="iflynepal-cookie-type__tag"><?php esc_html_e( 'Optional', 'iflynepal' ); ?></span>
			</article>

			<article class="iflynepal-cookie-type" data-iflynepal-reveal>
				<div class="iflynepal-cookie-type__icon" aria-hidden="true">
					<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false"><path d="M3 11v3a1 1 0 0 0 1 1h3l4 4V6L7 10H4a1 1 0 0 0-1 1z"/><path d="M16 9a4 4 0 0 1 0 6"/></svg>
				</div>
				<small class="iflynepal-cookie-type__eyebrow"><?php esc_html_e( 'Type 04', 'iflynepal' ); ?></small>
				<h3 class="wp-block-heading iflynepal-cookie-type__title"><?php esc_html_e( 'Advertising Cookies', 'iflynepal' ); ?></h3>
				<p class="iflynepal-cookie-type__text"><?php esc_html_e( 'We may partner with advertising networks — Facebook or Google Ads, for example — to show relevant ads based on your browsing.', 'iflynepal' ); ?></p>
				<span class="iflynepal-cookie-type__tag"><?php esc_html_e( 'Optional', 'iflynepal' ); ?></span>
			</article>

		</div>
	</div>
</section>
