<?php
/**
 * Sustainability Policy: the promises, above the policy itself.
 *
 * Editable like the rest of the page: the heading and each card are
 * Customizer fields, and the cards are the add/remove list under Sustainability Policy > Our commitment. See inc/legal-content.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_kicker = iflynepal_legal_extra( 'sustainability', 'kicker' );
?>
<section
	class="wp-block-group iflynepal-legal"
	id="pledge"
	aria-labelledby="iflynepal-sustain-pledge-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-sustain-pledge-title">
				<?php echo iflynepal_legal_extra( 'sustainability', 'title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_extra( 'sustainability', 'lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-sustain-pledges">
			<?php
			// Every part is escaped inside the render callback.
			echo iflynepal_render_sustainability_pledges();
			?>
		</div>

	</div>
</section>
