<?php
/**
 * Cookie Policy hero: a photograph under a scrim, the headline, and the pill
 * that scrolls to the cookie types.
 *
 * The same hero as the Terms & Conditions page — no kicker, no sub-title, no
 * buttons — rather than the design's two-column version with a summary card
 * beside it. The two legal pages should open the same way.
 *
 * It carries the shared `iflynepal-hero` classes and is driven by the same
 * assets/js/homepage/hero/hero.js, which guards each of the absent pieces.
 * That script is also what swaps the header from transparent to solid on
 * scroll, so this page has to answer yes to iflynepal_has_hero().
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page iflynepal-hero--legal">

	<div class="iflynepal-hero__media" aria-hidden="true">
		<img
			class="iflynepal-hero__still"
			src="<?php echo esc_url( iflynepal_cookie_hero_image_url() ); ?>"
			alt=""
			fetchpriority="high"
			loading="eager"
			decoding="sync"
		>
	</div>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<h1 class="wp-block-heading iflynepal-hero__title">
				<?php echo iflynepal_legal_head( 'cookie', 'hero_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h1>

		</div>
	</div>

	<a class="iflynepal-legal-hero__scroll" <?php echo iflynepal_anchor_attr( '#types' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper. ?>>
		<?php echo esc_html( wp_strip_all_tags( iflynepal_legal_head( 'cookie', 'hero_pill' ) ) ); ?>
		<span aria-hidden="true">&#8595;</span>
	</a>

</section>
