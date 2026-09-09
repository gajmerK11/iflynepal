<?php
/**
 * Terms & Conditions: the closing card — an invitation to ask about a clause,
 * with the contact details beside it.
 *
 * Every string here is a Customizer setting; see
 * inc/customizer/sections/terms.php. The three contact fields are blank by
 * default and follow the footer's office details, so a site that has only ever
 * filled the footer in still shows the right number.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section
	class="wp-block-group iflynepal-legal-final"
	id="terms-questions"
	aria-labelledby="iflynepal-terms-final-title"
	data-iflynepal-motion
>
	<div class="iflynepal-legal__inner">
		<div class="iflynepal-legal-accept" data-iflynepal-reveal>
			<div class="iflynepal-legal-accept__grid">

				<div class="iflynepal-legal-accept__copy">

					<p class="iflynepal-legal-accept__kicker" id="iflynepal-terms-cta-kicker">
						<?php echo iflynepal_render_terms_cta_kicker(); ?>
					</p>

					<h2 class="wp-block-heading iflynepal-legal-accept__title" id="iflynepal-terms-final-title">
						<span id="iflynepal-terms-cta-title"><?php echo iflynepal_render_terms_cta_title(); ?></span>
					</h2>

					<p class="iflynepal-legal-accept__text" id="iflynepal-terms-cta-text">
						<?php echo iflynepal_render_terms_cta_text(); ?>
					</p>

					<p class="iflynepal-legal-accept__script" id="iflynepal-terms-cta-script" aria-hidden="true">
						<?php echo iflynepal_render_terms_cta_script(); ?>
					</p>

					<div class="iflynepal-legal-accept__actions" id="iflynepal-terms-cta-actions">
						<?php echo iflynepal_render_terms_cta_actions(); ?>
					</div>

				</div>

				<aside class="iflynepal-legal-accept__contact">
					<div class="iflynepal-legal-accept__lines" id="iflynepal-terms-cta-lines">
						<?php echo iflynepal_render_terms_cta_lines(); ?>
					</div>
				</aside>

			</div>
		</div>
	</div>
</section>
