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
 *     @type int     $limit        Most reviews to show. -1 for all. Default -1.
 *     @type int[]   $include      Specific testimonial IDs, in the order given.
 *     @type string  $note         Handwritten note beside the platform links.
 *     @type bool    $show_sources Whether to draw the platform strip. Default true.
 *     @type array[] $sources      Platform links, each with 'key', 'label' and 'url'.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'id'           => 'proof',
		'kicker'       => __( 'Traveller proof', 'iflynepal' ),
		'limit'        => -1,
		'include'      => array(),
		'note'         => __( 'Others have shared theirs too, right here', 'iflynepal' ),
		'show_sources' => true,
		'sources'      => array(
			array(
				'key'   => 'google',
				'label' => __( 'Google Reviews', 'iflynepal' ),
				'url'   => 'https://www.google.com/search?q=iFly+Nepal+reviews',
			),
			array(
				'key'   => 'tripadvisor',
				'label' => __( 'Tripadvisor', 'iflynepal' ),
				'url'   => 'https://www.tripadvisor.com/Search?q=iFly%20Nepal',
			),
		),
	)
);

$iflynepal_testimonials = iflynepal_get_testimonials(
	array(
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
										<span class="iflynepal-testimonials__avatar" aria-hidden="true">
											<svg viewBox="0 0 40 40" focusable="false"><circle cx="20" cy="16" r="5.5"/><path d="M9.5 32.5c1.6-5 5.6-7.5 10.5-7.5s8.9 2.5 10.5 7.5"/></svg>
										</span>
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
			<div class="iflynepal-testimonials__verify" data-iflynepal-reveal>

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

						$iflynepal_source_key = isset( $iflynepal_source['key'] ) ? $iflynepal_source['key'] : '';
						?>
						<a class="iflynepal-testimonials__source" href="<?php echo esc_url( $iflynepal_source['url'] ); ?>" rel="noopener">
							<?php
							/*
							 * The brand marks are printed literally rather than
							 * built from data: they are multi-coloured logos, so
							 * they cannot take their colour from the button, and
							 * an editor has no business editing a trademark.
							 */
							switch ( $iflynepal_source_key ) {
								case 'google':
									?>
									<svg class="iflynepal-testimonials__brand" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
										<path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.46a5.52 5.52 0 0 1-2.4 3.62v3h3.88c2.27-2.09 3.58-5.17 3.58-8.81z"/>
										<path fill="#34A853" d="M12 24c3.24 0 5.96-1.08 7.94-2.92l-3.88-3c-1.08.72-2.45 1.15-4.06 1.15-3.13 0-5.78-2.11-6.73-4.96H1.26v3.09A11.99 11.99 0 0 0 12 24z"/>
										<path fill="#FBBC05" d="M5.27 14.27a7.2 7.2 0 0 1 0-4.54V6.64H1.26a12 12 0 0 0 0 10.72l4.01-3.09z"/>
										<path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.44-3.44C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.69 1.26 6.64l4.01 3.09C6.22 6.86 8.87 4.75 12 4.75z"/>
									</svg>
									<?php
									break;

								case 'tripadvisor':
									?>
									<svg class="iflynepal-testimonials__brand" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
										<circle cx="12" cy="12" r="11.5" fill="#34E0A1"/>
										<path fill="#000" d="M12 5.6c2.6 0 5 .63 7 1.72h3.4l-1.9 2.07c.5.83.79 1.8.79 2.85a5.5 5.5 0 0 1-9.29 3.99A5.5 5.5 0 0 1 2.71 12.24c0-1.04.29-2.02.79-2.85L1.6 7.32H5c2-1.09 4.4-1.72 7-1.72z"/>
										<circle cx="7.5" cy="12.3" r="3.1" fill="#fff"/><circle cx="7.5" cy="12.3" r="1.4" fill="#000"/>
										<circle cx="16.5" cy="12.3" r="3.1" fill="#fff"/><circle cx="16.5" cy="12.3" r="1.4" fill="#000"/>
									</svg>
									<?php
									break;
							}
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
