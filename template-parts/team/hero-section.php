<?php
/**
 * Team hero: a photograph under a scrim, the headline, the sub-title and the
 * portrait cluster.
 *
 * The same component as the front page's and the About pages' heroes — it
 * carries the same `iflynepal-hero` classes and is driven by the same
 * assets/js/homepage/hero/hero.js, which guards every piece this one does not
 * have (the video, the ambient sound, the trust bullets, the buttons). That
 * script also swaps the header from transparent to solid on scroll; without it
 * this page would keep white nav links over white content once the hero was
 * scrolled past.
 *
 * What this hero adds over the others is the second column: three portraits in
 * an arrangement, and the handwritten note under them.
 *
 * Everything editable here lives in Appearance > Customize > About > Team.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_team_hero_image = iflynepal_team_hero_image_url();
$iflynepal_team_portraits  = iflynepal_team_portraits();
$iflynepal_team_scroll     = iflynepal_team_hero_scroll_label();
?>
<section class="wp-block-cover iflynepal-hero iflynepal-hero--page iflynepal-hero--team">

	<?php if ( $iflynepal_team_hero_image ) : ?>
		<div class="iflynepal-hero__media" aria-hidden="true">
			<img
				class="iflynepal-hero__still"
				src="<?php echo esc_url( $iflynepal_team_hero_image ); ?>"
				alt=""
				fetchpriority="high"
				loading="eager"
				decoding="sync"
			>
		</div>
	<?php endif; ?>

	<div class="wp-block-cover__inner-container">
		<div class="iflynepal-team-hero__grid">

			<div class="wp-block-group iflynepal-hero__copy">

				<p class="iflynepal-hero__kicker" id="iflynepal-team-hero-kicker">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_team_hero_kicker();
					?>
				</p>

				<h1 class="wp-block-heading iflynepal-hero__title iflynepal-team-hero__title" id="iflynepal-team-hero-title">
					<?php
					// Both lines are kses-filtered and the mark escaped inside the render callback.
					echo iflynepal_render_team_hero_title();
					?>
				</h1>

				<p class="iflynepal-hero__lead" id="iflynepal-team-hero-lead">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_team_hero_lead();
					?>
				</p>

			</div>

			<?php if ( $iflynepal_team_portraits ) : ?>
				<div
					class="iflynepal-team-hero__cluster"
					id="iflynepal-team-portraits"
					aria-label="<?php esc_attr_e( 'Members of the iFly Nepal team', 'iflynepal' ); ?>"
				>
					<?php
					// Images are escaped inside the render callback.
					echo iflynepal_render_team_portraits();
					?>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<?php if ( '' !== $iflynepal_team_scroll && iflynepal_team_has_reps() ) : ?>
		<a class="iflynepal-team-hero__scroll" href="#representatives">
			<?php echo esc_html( $iflynepal_team_scroll ); ?>
			<span aria-hidden="true">&#8595;</span>
		</a>
	<?php endif; ?>

</section>
