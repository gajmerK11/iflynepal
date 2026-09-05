<?php
/**
 * The site footer's navy band: three link columns and the head office, then
 * the brand line with its review chips, the follow row, and the legal bar.
 *
 * The three link columns are nav menus. Each takes its heading from the name
 * of the menu assigned to it under Appearance > Menus, so a column is added,
 * renamed, reordered or removed without touching a template — the same
 * arrangement CloudColleague uses. A slot with no menu assigned renders
 * nothing at all rather than an empty heading.
 *
 * Everything else lives in Appearance > Customize > Footer.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_assigned_menus = get_nav_menu_locations();
$iflynepal_office_heading = trim( iflynepal_footer_office_field( 'heading' ) );

/*
 * Rendered once here only to decide whether each row is worth a wrapper —
 * an empty review list would otherwise leave its "Recommended on" label
 * standing on its own. The markup itself is echoed from the callbacks at
 * the point of use, which is where the escaping sniff can see them.
 */
$iflynepal_office_body = iflynepal_render_footer_office();
$iflynepal_reviews     = iflynepal_render_footer_reviews();
$iflynepal_socials     = iflynepal_render_footer_socials();
$iflynepal_has_legal   = has_nav_menu( IFLYNEPAL_FOOTER_LEGAL_LOCATION );
?>
<footer class="iflynepal-footer" aria-label="<?php esc_attr_e( 'Site footer', 'iflynepal' ); ?>">
	<div class="iflynepal-footer__inner">

		<div class="iflynepal-footer__primary">

			<?php foreach ( iflynepal_footer_menu_slots() as $iflynepal_location => $iflynepal_label ) : ?>
				<?php
				$iflynepal_menu = isset( $iflynepal_assigned_menus[ $iflynepal_location ] )
					? wp_get_nav_menu_object( $iflynepal_assigned_menus[ $iflynepal_location ] )
					: null;

				if ( ! $iflynepal_menu ) {
					continue;
				}
				?>
				<nav class="iflynepal-footer__col" aria-label="<?php echo esc_attr( $iflynepal_menu->name ); ?>">
					<h3 class="iflynepal-footer__col-title"><?php echo esc_html( $iflynepal_menu->name ); ?></h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => $iflynepal_location,
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'walker'         => new IFly_Nepal_Footer_Nav_Walker(),
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endforeach; ?>

			<?php if ( '' !== $iflynepal_office_heading || '' !== $iflynepal_office_body ) : ?>
				<section class="iflynepal-footer__office">
					<h3 class="iflynepal-footer__col-title" id="iflynepal-footer-office-heading">
						<?php
						// Escaped inside the render callback.
						echo iflynepal_render_footer_office_heading();
						?>
					</h3>
					<address id="iflynepal-footer-office">
						<?php
						// Values are escaped and kses-filtered inside the render callback.
						echo iflynepal_render_footer_office();
						?>
					</address>
				</section>
			<?php endif; ?>

		</div>

		<div class="iflynepal-footer__brand-row">

			<div class="iflynepal-footer__brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php endif; ?>
				<p class="iflynepal-footer__blurb" id="iflynepal-footer-blurb">
					<?php
					// Sanitized by iflynepal_kses_text() on save and again on read.
					echo iflynepal_render_footer_blurb();
					?>
				</p>
			</div>

			<div class="iflynepal-footer__reviews"<?php echo '' === $iflynepal_reviews ? ' hidden' : ''; ?>>
				<span class="iflynepal-footer__row-label"><?php esc_html_e( 'Recommended on', 'iflynepal' ); ?></span>
				<div class="iflynepal-footer__review-list" id="iflynepal-footer-reviews">
					<?php
					// Labels and URLs are escaped inside the render callback.
					echo iflynepal_render_footer_reviews();
					?>
				</div>
			</div>

		</div>

		<div class="iflynepal-footer__follow"<?php echo '' === $iflynepal_socials ? ' hidden' : ''; ?>>
			<span class="iflynepal-footer__row-label"><?php esc_html_e( 'Follow us', 'iflynepal' ); ?></span>
			<div class="iflynepal-footer__social-list" id="iflynepal-footer-socials">
				<?php
				// URLs are escaped inside the render callback.
				echo iflynepal_render_footer_socials();
				?>
			</div>
		</div>

		<div class="iflynepal-footer__bottom">
			<span id="iflynepal-footer-copyright">
				<?php
				// Escaped inside the render callback.
				echo iflynepal_render_footer_copyright();
				?>
			</span>

			<?php if ( $iflynepal_has_legal ) : ?>
				<nav class="iflynepal-footer__legal" aria-label="<?php esc_attr_e( 'Legal links', 'iflynepal' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => IFLYNEPAL_FOOTER_LEGAL_LOCATION,
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'walker'         => new IFly_Nepal_Footer_Nav_Walker(),
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>

	</div>
</footer>

<?php
/*
 * Outside the footer element on purpose: it is fixed to the viewport and
 * belongs to the page, not to the footer's content. Ships hidden and is
 * revealed by assets/js/footer/back-to-top.js once there is somewhere to
 * scroll back to, so it never appears as a dead control with scripting off.
 */
?>
<button type="button" id="iflynepal-back-to-top" class="iflynepal-back-to-top" hidden aria-label="<?php esc_attr_e( 'Back to top', 'iflynepal' ); ?>">
	<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>
