<?php
/**
 * Sustainability Policy: the document itself — a sticky index beside the clause cards.
 *
 * Nothing here is written in the template. The heading and the index title are
 * Customizer fields, and the clauses are the add/remove list under
 * Customizer > Sustainability Policy > On this page. The index on the left and
 * the cards on the right are both generated from that list (see
 * inc/legal-sections.php), so they cannot drift apart.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_kicker = iflynepal_legal_head( 'sustainability', 'head_kicker' );
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-sustain-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-sustain-title">
				<?php echo iflynepal_legal_head( 'sustainability', 'head_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_head( 'sustainability', 'head_lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-sustain-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-sustain-index-title">
					<?php echo esc_html( wp_strip_all_tags( iflynepal_legal_head( 'sustainability', 'index_title' ) ) ); ?>
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
				<?php
				// Every clause, built from the "On this page" list and escaped in the render callback.
				echo iflynepal_render_sustainability_articles();
				?>
			</div>
		</div>
	</div>
</section>
