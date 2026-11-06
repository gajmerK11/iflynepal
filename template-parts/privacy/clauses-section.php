<?php
/**
 * Privacy Policy: the document itself — a sticky index beside the clause cards.
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

$iflynepal_kicker = iflynepal_legal_head( 'privacy', 'head_kicker' );
?>
<section
	class="wp-block-group iflynepal-section--mist iflynepal-legal"
	id="policy"
	aria-labelledby="iflynepal-privacy-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">

		<div class="iflynepal-legal-head" data-iflynepal-reveal>
			<?php if ( '' !== $iflynepal_kicker ) : ?>
				<p class="iflynepal-legal-head__kicker">
					<?php echo $iflynepal_kicker; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
				</p>
			<?php endif; ?>
			<h2 class="wp-block-heading iflynepal-legal-head__title" id="iflynepal-privacy-title">
				<?php echo iflynepal_legal_head( 'privacy', 'head_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</h2>
			<p class="iflynepal-legal-head__lead">
				<?php echo iflynepal_legal_head( 'privacy', 'head_lead' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized by iflynepal_kses_text(). ?>
			</p>
		</div>

		<div class="iflynepal-legal-layout">

			<aside class="iflynepal-legal-index" aria-labelledby="iflynepal-privacy-index-title" data-iflynepal-reveal>
				<h2 class="iflynepal-legal-index__title" id="iflynepal-privacy-index-title">
					<?php echo esc_html( wp_strip_all_tags( iflynepal_legal_head( 'privacy', 'index_title' ) ) ); ?>
				</h2>
				<nav
					class="iflynepal-legal-index__list"
					id="iflynepal-privacy-index"
					aria-label="<?php esc_attr_e( 'Sections on this page', 'iflynepal' ); ?>"
				>
					<?php
					// Titles are escaped inside the render callback.
					echo iflynepal_render_legal_index( 'privacy' );
					?>
				</nav>
			</aside>

			<div class="iflynepal-legal-body">

				<article class="iflynepal-legal-clause" id="who-we-are" aria-labelledby="who-we-are-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'who-we-are' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'who-we-are' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="information-we-collect" aria-labelledby="information-we-collect-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'information-we-collect' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'information-we-collect' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="automatic-information" aria-labelledby="automatic-information-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'automatic-information' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'automatic-information' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="tracking-technologies" aria-labelledby="tracking-technologies-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'tracking-technologies' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'tracking-technologies' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="media-uploads" aria-labelledby="media-uploads-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'media-uploads' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'media-uploads' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="comments" aria-labelledby="comments-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'comments' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'comments' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="embedded-content" aria-labelledby="embedded-content-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'embedded-content' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'embedded-content' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="how-we-use-data" aria-labelledby="how-we-use-data-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'how-we-use-data' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'how-we-use-data' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-sharing" aria-labelledby="data-sharing-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'data-sharing' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'data-sharing' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-retention" aria-labelledby="data-retention-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'data-retention' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'data-retention' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="your-rights" aria-labelledby="your-rights-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'your-rights' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'your-rights' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-security" aria-labelledby="data-security-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'data-security' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'data-security' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="data-transfers" aria-labelledby="data-transfers-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'data-transfers' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'data-transfers' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="third-party-links" aria-labelledby="third-party-links-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'third-party-links' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'third-party-links' ); ?>
					</div>
				</article>

				<article class="iflynepal-legal-clause" id="policy-changes" aria-labelledby="policy-changes-title" data-iflynepal-reveal>
					<?php echo iflynepal_render_legal_clause_head( 'privacy', 'policy-changes' ); ?>
					<div class="iflynepal-legal-clause__body">
						<?php echo iflynepal_render_legal_body( 'privacy', 'policy-changes' ); ?>
					</div>
				</article>

			</div>
		</div>
	</div>
</section>
