<?php
/**
 * Sustainability Policy: the six promises, above the policy itself.
 *
 * The page's summary, the way the Cookie Policy opens on its four cookie
 * types: a reader who wants the gist should have it before a numbered policy.
 * The cards are generated from inc/sustainability.php.
 *
 * Not editable, for the same reason the clauses are not; see
 * inc/sustainability.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-legal"
	id="pledge"
	aria-labelledby="iflynepal-sustain-pledge-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<p class="iflynepal-legal-head__kicker">
				<?php esc_html_e( 'Our commitment', 'iflynepal' ); ?>
			</p>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-sustain-pledge-title">
				<?php echo wp_kses_post( __( 'Six promises we <span class="underline">hold ourselves to</span>', 'iflynepal' ) ); ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php esc_html_e( 'Sustainability is not just an environmental concern — it is an integrated approach involving ethical business, community empowerment, cultural respect and climate-conscious travel.', 'iflynepal' ); ?>
			</p>
		</div>

		<div class="iflynepal-sustain-pledges">
			<?php
			// Titles and text are escaped inside the render callback.
			echo iflynepal_render_sustainability_pledges();
			?>
		</div>

	</div>
</section>
