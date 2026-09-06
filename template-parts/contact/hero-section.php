<?php
/**
 * Contact page hero and head-office card.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_phone      = iflynepal_contact_plain( 'office_phone' );
$iflynepal_phone_href = preg_replace( '/[^0-9+]/', '', $iflynepal_phone );
$iflynepal_email      = sanitize_email( iflynepal_contact_plain( 'office_email' ) );
?>
<section class="wp-block-cover iflynepal-hero iflynepal-contact-hero" aria-labelledby="iflynepal-contact-hero-title">
	<div class="iflynepal-hero__media" aria-hidden="true">
		<img class="iflynepal-hero__still" src="<?php echo esc_url( iflynepal_contact_hero_image_url() ); ?>" alt="" fetchpriority="high" loading="eager" decoding="sync">
	</div>

	<div class="wp-block-cover__inner-container iflynepal-contact-hero__inner">
		<div class="iflynepal-hero__copy iflynepal-contact-hero__copy">
			<p class="iflynepal-hero__kicker"><?php echo iflynepal_contact_text( 'hero_kicker' ); ?></p>
			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-contact-hero-title"><?php echo iflynepal_contact_text( 'hero_title' ); ?></h1>
			<p class="iflynepal-hero__lead"><?php echo iflynepal_contact_text( 'hero_lead' ); ?></p>
			<div class="wp-block-buttons iflynepal-hero__actions">
				<?php if ( iflynepal_contact_plain( 'hero_primary_label' ) && iflynepal_contact_link( 'hero_primary_url' ) ) : ?>
					<a class="iflynepal-button iflynepal-button--light" href="<?php echo esc_url( iflynepal_contact_link( 'hero_primary_url' ) ); ?>"><?php echo esc_html( iflynepal_contact_plain( 'hero_primary_label' ) ); ?></a>
				<?php endif; ?>
				<?php if ( iflynepal_contact_plain( 'hero_secondary_label' ) && iflynepal_contact_link( 'hero_secondary_url' ) ) : ?>
					<a class="iflynepal-button iflynepal-button--outline" href="<?php echo esc_url( iflynepal_contact_link( 'hero_secondary_url' ) ); ?>"><?php echo esc_html( iflynepal_contact_plain( 'hero_secondary_label' ) ); ?></a>
				<?php endif; ?>
			</div>
			<?php if ( iflynepal_contact_plain( 'hero_script' ) ) : ?>
				<p class="iflynepal-contact-hero__script" aria-hidden="true"><?php echo esc_html( iflynepal_contact_plain( 'hero_script' ) ); ?></p>
			<?php endif; ?>
		</div>

		<aside class="iflynepal-contact-office" aria-labelledby="iflynepal-contact-office-title">
			<p class="iflynepal-contact-office__label" id="iflynepal-contact-office-title"><?php echo esc_html( iflynepal_contact_plain( 'office_label' ) ); ?></p>
			<h2><?php echo iflynepal_contact_text( 'office_address' ); ?></h2>
			<div class="iflynepal-contact-office__lines">
				<p><?php echo iflynepal_contact_icon( 'phone' ); ?><a href="tel:<?php echo esc_attr( $iflynepal_phone_href ); ?>"><?php echo esc_html( $iflynepal_phone ); ?></a></p>
				<p><?php echo iflynepal_contact_icon( 'clock' ); ?><span><?php echo esc_html( iflynepal_contact_plain( 'office_hours' ) ); ?></span></p>
				<p><?php echo iflynepal_contact_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $iflynepal_email ); ?>"><?php echo esc_html( $iflynepal_email ); ?></a></p>
			</div>
		</aside>
	</div>

	<?php if ( iflynepal_contact_plain( 'hero_scroll_label' ) ) : ?>
		<a class="iflynepal-contact-hero__scroll" href="#enquiry"><?php echo esc_html( iflynepal_contact_plain( 'hero_scroll_label' ) ); ?> <span aria-hidden="true">&#8595;</span></a>
	<?php endif; ?>
</section>
