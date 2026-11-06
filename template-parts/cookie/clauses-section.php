<?php
/**
 * Cookie Policy: the document itself — a sticky index beside the clause cards.
 *
 * Nothing here is written in the template. The heading, the index title, each
 * clause's title, sub-title and body are all editable in the Customizer, so
 * this file is only the frame; the copy and its defaults come from
 * inc/legal-content.php and inc/legal-defaults.php. The index is generated from
 * the same clause register as the headings, so the two cannot drift apart.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_kicker = iflynepal_legal_head( 'cookie', 'head_kicker' );
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-cookie-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-cookie-title">
				<?php echo iflynepal_legal_head( 'cookie', 'head_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_head( 'cookie', 'head_lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-cookie-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-cookie-index-title">
					<?php echo esc_html( wp_strip_all_tags( iflynepal_legal_head( 'cookie', 'index_title' ) ) ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-cookie-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_legal_index( 'cookie' );
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="what-are-cookies" aria-labelledby="what-are-cookies-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'cookie', 'what-are-cookies' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'cookie', 'what-are-cookies' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cookie-types" aria-labelledby="cookie-types-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'cookie', 'cookie-types' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'cookie', 'cookie-types' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="third-party-cookies" aria-labelledby="third-party-cookies-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'cookie', 'third-party-cookies' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'cookie', 'third-party-cookies' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="cookie-management" aria-labelledby="cookie-management-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'cookie', 'cookie-management' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'cookie', 'cookie-management' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="policy-updates" aria-labelledby="policy-updates-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'cookie', 'policy-updates' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'cookie', 'policy-updates' ); ?>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
