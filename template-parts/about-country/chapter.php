<?php
/**
 * About Nepal chapter: one country section.
 *
 * Every chapter follows the same reading order — a centred head, a wide
 * banner, then the source copy — so this one part renders all nine rather than
 * there being nine near-identical files. What differs between them is a
 * component apiece, which lives in template-parts/about-country/extras/ and is
 * pulled in either side of the prose.
 *
 * Everything editable here lives in Appearance > Customize > About > Nepal.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @param array $args {
 *     @type string $slug  Chapter slug, one of the keys of iflynepal_country_chapters().
 *     @type bool   $first Whether this is the first chapter shown, which clears the index bar.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_slug = isset( $args['slug'] ) ? (string) $args['slug'] : '';

if ( '' === $iflynepal_slug || ! iflynepal_country_has_chapter( $iflynepal_slug ) ) {
	return;
}

$iflynepal_chapter = iflynepal_country_chapter( $iflynepal_slug );
$iflynepal_banner  = iflynepal_country_chapter_image_url( $iflynepal_slug );

$iflynepal_classes = array( 'wp-block-group', 'iflynepal-country-chapter' );

if ( ! empty( $iflynepal_chapter['mist'] ) ) {
	$iflynepal_classes[] = 'iflynepal-section--mist';
}

if ( ! empty( $args['first'] ) ) {
	$iflynepal_classes[] = 'iflynepal-country-chapter--first';
}
?>
<section
	class="<?php echo esc_attr( implode( ' ', $iflynepal_classes ) ); ?>"
	id="<?php echo esc_attr( $iflynepal_slug ); ?>"
	data-iflynepal-motion
>
	<div class="iflynepal-country-chapter__inner">

		<div class="iflynepal-country-chapter__head" data-iflynepal-reveal>
			<p class="iflynepal-country-chapter__kicker" id="iflynepal-country-<?php echo esc_attr( $iflynepal_slug ); ?>-eyebrow">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_country_chapter_eyebrow( $iflynepal_slug );
				?>
			</p>
			<h2 class="wp-block-heading iflynepal-country-chapter__heading" id="iflynepal-country-<?php echo esc_attr( $iflynepal_slug ); ?>-title">
				<?php
				// Sanitized by iflynepal_kses_text() on save and again on read.
				echo iflynepal_render_country_chapter_title( $iflynepal_slug );
				?>
			</h2>
		</div>

		<?php if ( $iflynepal_banner ) : ?>
			<figure class="iflynepal-country-chapter__banner" data-iflynepal-reveal>
				<img
					loading="lazy"
					src="<?php echo esc_url( $iflynepal_banner ); ?>"
					alt="<?php echo esc_attr( iflynepal_country_chapter_image_alt( $iflynepal_slug ) ); ?>"
				>
			</figure>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/about-country/extras/' . $iflynepal_slug . '-before' ); ?>

		<?php if ( iflynepal_country_chapter_has_prose( $iflynepal_slug ) ) : ?>
			<div class="iflynepal-country-prose" id="iflynepal-country-<?php echo esc_attr( $iflynepal_slug ); ?>-prose" data-iflynepal-reveal>
				<?php
				// Each paragraph is kses-filtered inside the render callback.
				echo iflynepal_render_country_chapter_prose( $iflynepal_slug );
				?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/about-country/extras/' . $iflynepal_slug . '-after' ); ?>

	</div>
</section>
