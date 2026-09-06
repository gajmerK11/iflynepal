<?php
/**
 * Team: the Executive Team roster.
 *
 * The same head and grid as the representatives above it, on white rather than
 * the tinted band, with the taller card that carries a role pill over the
 * photograph. It has no kicker — the design gives this one the heading alone.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_team_has_executive() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-team-section"
	id="executive-team"
	data-iflynepal-motion
>
	<div class="iflynepal-team-section__inner">

		<div class="iflynepal-team-section__head" data-iflynepal-reveal>
			<h2 class="wp-block-heading iflynepal-team-section__heading" id="iflynepal-team-executive-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_team_executive_title();
				?>
			</h2>
			<p class="iflynepal-team-section__lead" id="iflynepal-team-executive-lead">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_team_executive_lead();
				?>
			</p>
		</div>

		<div class="iflynepal-team-grid iflynepal-team-grid--member" id="iflynepal-team-members">
			<?php
			// Names are kses-filtered and images escaped inside the render callback.
			echo iflynepal_render_team_members();
			?>
		</div>

	</div>
</section>
