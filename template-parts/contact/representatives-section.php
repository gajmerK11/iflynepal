<?php
/**
 * Contact page worldwide representatives.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_contact_has_representatives() ) {
	return;
}
?>
<section class="wp-block-group iflynepal-contact-section" id="representatives" data-iflynepal-motion aria-labelledby="iflynepal-contact-representatives-title">
	<div class="iflynepal-contact-container">
		<header class="iflynepal-contact-head" data-iflynepal-reveal>
			<p class="iflynepal-contact-eyebrow" id="iflynepal-contact-reps-kicker"><?php echo iflynepal_contact_text( 'reps_kicker' ); ?></p>
			<h2 id="iflynepal-contact-representatives-title"><?php echo iflynepal_contact_text( 'reps_title' ); ?></h2>
			<p id="iflynepal-contact-reps-lead"><?php echo iflynepal_contact_text( 'reps_lead' ); ?></p>
		</header>

		<div class="iflynepal-team-grid iflynepal-contact-reps">
			<?php foreach ( iflynepal_contact_representatives() as $iflynepal_rep ) : ?>
				<?php echo iflynepal_contact_representative_card_markup( $iflynepal_rep ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
