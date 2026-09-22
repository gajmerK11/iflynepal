<?php
/**
 * Primary navigation, the "Plan My Trip" call to action, and the mobile toggle.
 *
 * The call to action is a normal menu item carrying the "nav-cta" CSS class
 * (Appearance > Menus > Screen Options > CSS Classes). It is pulled out of the
 * collapsing link list and rendered beside the toggle, so it stays visible on
 * mobile the way the design has it — iflynepal_nav_menu_css_class() hides it in
 * the list below so it is never shown twice.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_cta = iflynepal_get_nav_cta_item();
?>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav id="iflynepal-nav" class="iflynepal-nav-links" aria-label="<?php esc_attr_e( 'Primary navigation', 'iflynepal' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'iflynepal-menu',
				// One level of nesting: a top-level item and its dropdown.
				'depth'          => 2,
				'walker'         => new IFly_Nepal_Nav_Walker(),
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
<?php endif; ?>

<div class="iflynepal-nav-side">

	<?php
	/*
	 * Client-directed: the WhatsApp action sits at the right-hand end of the
	 * bar, before the call to action rather than after it — the CTA is still
	 * the header's one primary action, and the chat is the quieter way to ask.
	 * It draws nothing when no number is configured.
	 */
	get_template_part( 'template-parts/header/whatsapp-button' );
	?>

	<?php if ( $iflynepal_cta ) : ?>
		<a class="iflynepal-button iflynepal-button--outline iflynepal-nav-cta" <?php echo iflynepal_anchor_attr( $iflynepal_cta['url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper. ?>>
			<?php echo esc_html( $iflynepal_cta['title'] ); ?>
		</a>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<button
			id="iflynepal-menu-toggle"
			class="iflynepal-menu-btn"
			type="button"
			aria-expanded="false"
			aria-controls="iflynepal-nav"
			aria-label="<?php esc_attr_e( 'Open navigation', 'iflynepal' ); ?>"
			data-label-open="<?php esc_attr_e( 'Open navigation', 'iflynepal' ); ?>"
			data-label-close="<?php esc_attr_e( 'Close navigation', 'iflynepal' ); ?>"
		>
			<svg class="iflynepal-ico iflynepal-ico-menu" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 7.5h16M4 12h16M4 16.5h16"/></svg>
			<svg class="iflynepal-ico iflynepal-ico-close" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/></svg>
		</button>
	<?php endif; ?>

</div>
