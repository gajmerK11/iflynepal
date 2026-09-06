<?php
/**
 * Contact page hero and head-office card.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="wp-block-cover iflynepal-hero iflynepal-contact-hero" aria-labelledby="iflynepal-contact-hero-title">
	<div class="iflynepal-hero__media" id="iflynepal-contact-hero-media" aria-hidden="true">
		<?php echo iflynepal_render_contact_hero_image(); ?>
	</div>

	<div class="wp-block-cover__inner-container iflynepal-contact-hero__inner">
		<div class="iflynepal-hero__copy iflynepal-contact-hero__copy">
			<p class="iflynepal-hero__kicker" id="iflynepal-contact-hero-kicker"><?php echo iflynepal_contact_text( 'hero_kicker' ); ?></p>
			<h1 class="wp-block-heading iflynepal-hero__title" id="iflynepal-contact-hero-title"><?php echo iflynepal_contact_text( 'hero_title' ); ?></h1>
			<p class="iflynepal-hero__lead" id="iflynepal-contact-hero-lead"><?php echo iflynepal_contact_text( 'hero_lead' ); ?></p>
			<div class="wp-block-buttons iflynepal-hero__actions">
				<?php echo iflynepal_render_contact_hero_primary_button(); ?>
				<?php echo iflynepal_render_contact_hero_secondary_button(); ?>
			</div>
			<?php if ( iflynepal_contact_plain( 'hero_script' ) ) : ?>
				<p class="iflynepal-contact-hero__script" id="iflynepal-contact-hero-script" aria-hidden="true"><?php echo esc_html( iflynepal_contact_plain( 'hero_script' ) ); ?></p>
			<?php endif; ?>
		</div>

		<aside class="iflynepal-contact-office" aria-labelledby="iflynepal-contact-office-title">
			<p class="iflynepal-contact-office__label" id="iflynepal-contact-office-title"><?php echo esc_html( iflynepal_contact_plain( 'office_label' ) ); ?></p>
			<h2 id="iflynepal-contact-office-address"><?php echo iflynepal_contact_text( 'office_address' ); ?></h2>
			<div class="iflynepal-contact-office__lines">
				<p><?php echo iflynepal_contact_icon( 'phone' ); ?><?php echo iflynepal_render_contact_office_phone(); ?></p>
				<p><?php echo iflynepal_contact_icon( 'clock' ); ?><span id="iflynepal-contact-office-hours"><?php echo esc_html( iflynepal_contact_plain( 'office_hours' ) ); ?></span></p>
				<p><?php echo iflynepal_contact_icon( 'mail' ); ?><?php echo iflynepal_render_contact_office_email(); ?></p>
			</div>
		</aside>
	</div>

	<?php if ( iflynepal_contact_plain( 'hero_scroll_label' ) ) : ?>
		<a class="iflynepal-contact-hero__scroll" id="iflynepal-contact-hero-scroll" href="#enquiry"><?php echo iflynepal_render_contact_hero_scroll_label(); ?></a>
	<?php endif; ?>
</section>
