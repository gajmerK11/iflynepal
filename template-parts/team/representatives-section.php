<?php
/**
 * Team: the Global Representatives roster.
 *
 * A centred head over a grid of photographic cards, on the tinted band. The
 * cards are rendered even when every one has been removed, so the fragment the
 * Customizer replaces is still on the page and adding one back updates in
 * place rather than needing a full reload. An empty grid takes no space.
 *
 * Emptying the heading in the Customizer hides the whole section — the
 * convention the rest of the theme uses one level up, at the chapter.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_team_has_reps() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-team-section iflynepal-section--mist"
	id="representatives"
	data-iflynepal-motion
>
	<div class="iflynepal-team-section__inner">

		<div class="iflynepal-team-section__head" data-iflynepal-reveal>
			<p class="iflynepal-team-section__kicker" id="iflynepal-team-reps-kicker">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_team_reps_kicker();
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-team-section__heading" id="iflynepal-team-reps-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_team_reps_title();
				?>
			</h2>
			<p class="iflynepal-team-section__lead" id="iflynepal-team-reps-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_team_reps_lead();
				?>
			</p>
		</div>

		<div class="iflynepal-team-grid" id="iflynepal-team-representatives">
			<?php
			// Names are kses-filtered and images escaped inside the render callback.
			echo iflynepal_render_team_representatives();
			?>
		</div>

	</div>
</section>
