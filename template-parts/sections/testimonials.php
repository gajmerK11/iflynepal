<?php
/**
 * Traveller proof: a carousel of reviews, with the platforms they can be
 * checked on beneath it.
 *
 * Reusable. Every page that shows testimonials loads this one file and passes
 * what differs, so the design is defined once:
 *
 *     get_template_part(
 *         'template-parts/sections/testimonials',
 *         null,
 *         array(
 *             'id'      => 'retreat-proof',
 *             'kicker'  => __( 'Retreat guests', 'iflynepal' ),
 *             'limit'   => 6,
 *         )
 *     );
 *
 * Content comes from the Testimonials post type, not from this file.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @param array $args {
 *     Optional. Passed through get_template_part().
 *
 *     @type string  $id           Section id, used as the anchor. Default 'proof'.
 *     @type string  $kicker       Small line above the cards. Default 'Traveller proof'.
 *     @type int|string $page      Page whose reviews to show. 'current' (the default)
 *                                reads the page being viewed; 0 shows every review.
 *     @type int     $limit        Most reviews to show. -1 for all. Default -1.
 *     @type int[]   $include      Specific testimonial IDs, in the order given.
 *     @type string  $note         Handwritten note. Defaults to the one saved on
 *                                Testimonials > Add External Testimonial Links.
 *     @type bool    $show_sources Whether to draw the platform strip. Default true.
 *     @type array[] $sources      Platform links, each with 'slug', 'label' and 'url'.
 *                                Defaults to the links saved on that same screen.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'page'         => 'current',
		'id'           => 'proof',
		'kicker'       => __( 'Traveller proof', 'iflynepal' ),
		'limit'        => -1,
		'include'      => array(),
		'note'         => iflynepal_testimonial_links_note(),
		'show_sources' => true,
		'sources'      => iflynepal_testimonial_links(),
	)
);

$iflynepal_testimonials = iflynepal_get_testimonials(
	array(
		'page'    => $iflynepal_args['page'],
		'limit'   => $iflynepal_args['limit'],
		'include' => $iflynepal_args['include'],
	)
);

// Nothing published yet: the section is left out rather than drawn empty.
if ( ! $iflynepal_testimonials ) {
	return;
}
?>
<section class="wp-block-group iflynepal-testimonials" id="<?php echo esc_attr( $iflynepal_args['id'] ); ?>">

	<?php if ( '' !== $iflynepal_args['kicker'] ) : ?>
		<div class="iflynepal-testimonials__inner">
			<div class="iflynepal-testimonials__head" data-iflynepal-reveal>
				<p class="iflynepal-testimonials__kicker"><?php echo esc_html( $iflynepal_args['kicker'] ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<?php
	/*
	 * The carousel is announced as one region and takes focus itself, so the
	 * arrow keys have somewhere to land. Cards either side of the middle are
	 * dimmed by the script, never by the stylesheet — with JavaScript off this
	 * is a plain readable row.
	 */
	?>
	<div
		class="iflynepal-testimonials__carousel"
		role="region"
		aria-roledescription="carousel"
		aria-label="<?php esc_attr_e( 'Traveller testimonials, use the left and right arrow keys', 'iflynepal' ); ?>"
		tabindex="0"
		data-iflynepal-reveal
	>
		<div class="iflynepal-testimonials__scale">
			<div class="iflynepal-testimonials__viewport">
				<ul class="iflynepal-testimonials__track">
					<?php foreach ( $iflynepal_testimonials as $iflynepal_testimonial ) : ?>
						<?php $iflynepal_byline = iflynepal_testimonial_byline( $iflynepal_testimonial ); ?>
						<li class="iflynepal-testimonials__item">
							<figure class="iflynepal-testimonials__card">
								<?php if ( '' !== trim( $iflynepal_testimonial['headline'] ) ) : ?>
									<h3 class="wp-block-heading iflynepal-testimonials__headline">
										<?php
										printf(
											/* translators: %s: the review's headline, shown in quotation marks. */
											esc_html__( '&ldquo;%s&rdquo;', 'iflynepal' ),
											esc_html( $iflynepal_testimonial['headline'] )
										);
										?>
									</h3>
								<?php endif; ?>

								<blockquote class="iflynepal-testimonials__quote">
									<?php echo esc_html( $iflynepal_testimonial['body'] ); ?>
								</blockquote>

								<?php if ( '' !== $iflynepal_byline ) : ?>
									<figcaption class="iflynepal-testimonials__by">
										<?php if ( $iflynepal_testimonial['photo'] ) : ?>
											<?php
											// Built by wp_get_attachment_image(), which escapes its own output.
											echo wp_get_attachment_image(
												$iflynepal_testimonial['photo'],
												array( 80, 80 ),
												false,
												array(
													'class' => 'iflynepal-testimonials__photo',
													'alt' => '',
													'loading' => 'lazy',
												)
											); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
										<?php else : ?>
											<span class="iflynepal-testimonials__avatar" aria-hidden="true">
												<svg viewBox="0 0 40 40" focusable="false"><circle cx="20" cy="16" r="5.5"/><path d="M9.5 32.5c1.6-5 5.6-7.5 10.5-7.5s8.9 2.5 10.5 7.5"/></svg>
											</span>
										<?php endif; ?>
										<span class="iflynepal-testimonials__name"><?php echo esc_html( $iflynepal_byline ); ?></span>
									</figcaption>
								<?php endif; ?>
							</figure>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

	<?php if ( $iflynepal_args['show_sources'] && $iflynepal_args['sources'] ) : ?>
		<div class="iflynepal-testimonials__inner">
			<?php
			/*
			 * No reveal hook on this block, deliberately. The platform buttons and
			 * the note beside them are simply present from the first paint and stay
			 * that way; they are not scrolled into being like the heading and the
			 * cards above them.
			 */
			?>
			<div class="iflynepal-testimonials__verify">

				<?php if ( '' !== $iflynepal_args['note'] ) : ?>
					<span class="iflynepal-testimonials__note">
						<b><?php echo esc_html( $iflynepal_args['note'] ); ?></b>
						<svg viewBox="0 0 112 48" fill="none" aria-hidden="true" focusable="false">
							<path d="M2 34c14 6 29 9 45 8 20-1 38-8 58-19" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 7" stroke-linecap="round"/>
							<path d="M91 15.5 107.5 22.5 99.5 37" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
				<?php endif; ?>

				<div class="iflynepal-testimonials__sources">
					<?php foreach ( $iflynepal_args['sources'] as $iflynepal_source ) : ?>
						<?php
						if ( empty( $iflynepal_source['url'] ) || empty( $iflynepal_source['label'] ) ) {
							continue;
						}

						$iflynepal_slug = isset( $iflynepal_source['slug'] ) ? $iflynepal_source['slug'] : '';
						?>
						<a class="iflynepal-testimonials__source" href="<?php echo esc_url( $iflynepal_source['url'] ); ?>" rel="noopener">
							<?php
							/*
							 * The brand mark comes from the theme's own platform registry
							 * as literal markup: these are multi-coloured logos, so they
							 * cannot take their colour from the button around them, and a
							 * trademark is not an editor's to edit.
							 */
							echo iflynepal_render_testimonial_platform_icon( $iflynepal_slug );
							?>
							<?php echo esc_html( $iflynepal_source['label'] ); ?>
							<svg class="iflynepal-ico iflynepal-ico-ext" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M8.5 7H17v8.5"/></svg>
						</a>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
	<?php endif; ?>

</section>
