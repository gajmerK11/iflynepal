<?php
/**
 * Terms & Conditions hero: a photograph under a scrim, the headline, and the
 * pill that scrolls to the document.
 *
 * The plainest hero on the site — no kicker, no sub-title, no buttons. It
 * carries the same `iflynepal-hero` classes as every other hero and is driven
 * by the same assets/js/homepage/hero/hero.js, which guards each of those
 * absent pieces. That script is also what swaps the header from transparent to
 * solid on scroll, so this page has to answer yes to iflynepal_has_hero().
 *
 * Nothing here is editable: the page is a legal document, not a marketing
 * page, so it has no Customizer section.
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
			src="<?php echo esc_url( iflynepal_terms_hero_image_url() ); ?>"
			alt=""
			fetchpriority="high"
			loading="eager"
			decoding="sync"
		>
	</div>

	<div class="wp-block-cover__inner-container">
		<div class="wp-block-group iflynepal-hero__copy">

			<h1 class="wp-block-heading iflynepal-hero__title">
				<?php
				printf(
					/* translators: %s: the word "Conditions", set in the accent face. */
					esc_html__( 'Terms & %s', 'iflynepal' ),
					'<em>' . esc_html__( 'Conditions', 'iflynepal' ) . '</em>'
				);
				?>
			</h1>

		</div>
	</div>

	<a class="iflynepal-legal-hero__scroll" href="#terms">
		<?php esc_html_e( 'Read the terms', 'iflynepal' ); ?>
		<span aria-hidden="true">&#8595;</span>
	</a>

</section>
