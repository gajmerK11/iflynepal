<?php
/**
 * Cookie Policy: the four cookie types, above the policy itself.
 *
 * Editable like the rest of the page: the heading and each card are
 * Customizer fields (Cookie Policy > Cookie types). See inc/legal-content.php.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_kicker = iflynepal_legal_extra( 'cookie', 'kicker' );
?>
<section
	class="wp-block-group iflynepal-legal"
	id="types"
	aria-labelledby="iflynepal-cookie-types-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-cookie-types-title">
				<?php echo iflynepal_legal_extra( 'cookie', 'title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_extra( 'cookie', 'lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-cookie-types">
			<?php
			// Every part is escaped inside the render callback.
			echo iflynepal_render_legal_extra_cards( 'cookie' );
			?>
		</div>

	</div>
</section>
