<?php
/**
 * CSR: the pledge band.
 *
 * A kicker over one large line, centred on white. It is a blockquote rather
 * than a heading because it is a quoted pledge, not a section title — nothing
 * follows it that it names.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! iflynepal_csr_has_pledge() ) {
	return;
}
?>
<section
	class="wp-block-group iflynepal-csr-pledge"
	id="initiatives"
	aria-label="<?php esc_attr_e( 'Sustainable travel pledge', 'iflynepal' ); ?>"
	data-iflynepal-motion
>
	<div class="iflynepal-csr-pledge__inner" data-iflynepal-reveal>
		<p class="iflynepal-csr-pledge__kicker" id="iflynepal-csr-pledge-kicker">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_csr_pledge_kicker();
			?>
		</p>
		<blockquote class="iflynepal-csr-pledge__quote" id="iflynepal-csr-pledge">
			<?php
			// Sanitized by iflynepal_kses_text() on save and again on read.
			echo iflynepal_render_csr_pledge();
			?>
		</blockquote>
	</div>
</section>
