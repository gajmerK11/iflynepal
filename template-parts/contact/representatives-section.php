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
			<p class="iflynepal-contact-eyebrow"><?php echo iflynepal_contact_text( 'reps_kicker' ); ?></p>
			<h2 id="iflynepal-contact-representatives-title"><?php echo iflynepal_contact_text( 'reps_title' ); ?></h2>
			<p><?php echo iflynepal_contact_text( 'reps_lead' ); ?></p>
		</header>

		<div class="iflynepal-team-grid iflynepal-contact-reps">
			<?php foreach ( iflynepal_contact_representatives() as $iflynepal_rep ) : ?>
				<article class="iflynepal-team-card iflynepal-contact-rep" data-iflynepal-reveal>
					<div class="iflynepal-team-card__photo"><img src="<?php echo esc_url( iflynepal_contact_representative_image_url( $iflynepal_rep['index'] ) ); ?>" alt="<?php echo esc_attr( iflynepal_contact_representative_image_alt( $iflynepal_rep ) ); ?>" loading="lazy"><span class="iflynepal-contact-rep__country"><?php echo esc_html( $iflynepal_rep['country'] ); ?></span></div>
					<div class="iflynepal-team-card__body"><h3 class="iflynepal-team-card__name"><?php echo esc_html( $iflynepal_rep['name'] ); ?></h3><a class="iflynepal-contact-rep__phone" href="tel:<?php echo esc_attr( $iflynepal_rep['phone'] ); ?>"><?php echo iflynepal_contact_icon( 'phone' ); ?><?php echo esc_html( $iflynepal_rep['phone_label'] ); ?></a><?php if ( $iflynepal_rep['channel'] ) : ?><p class="iflynepal-contact-rep__channel"><?php echo esc_html( $iflynepal_rep['channel'] ); ?></p><?php endif; ?></div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
