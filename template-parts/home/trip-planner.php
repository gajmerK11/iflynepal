<?php
/**
 * Trip planner: the hero search bar.
 *
 * The three dropdowns are filled from taxonomy terms, so the option text lives
 * in exactly one place — the terms themselves. Until the companion plugin
 * (registers the trip post type and these taxonomies) exists, every field is
 * skipped and only the submit button renders — see iflynepal-context.md, this
 * is deliberate: no plugin is being built yet.
 *
 * The form is a public, read-only GET search against the trip archive, so it
 * carries no nonce by design: nothing here changes state, and a nonce on a
 * cacheable search URL would expire and break shared links. Every submitted
 * value is validated against real terms by the companion plugin before it
 * reaches a query.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_fields = array(
	array(
		'key'         => 'interest',
		'taxonomy'    => 'iflynepal_interest',
		'label'       => __( 'I want to', 'iflynepal' ),
		'placeholder' => '',
	),
	array(
		'key'         => 'duration',
		'taxonomy'    => 'iflynepal_duration',
		'label'       => __( 'I have', 'iflynepal' ),
		'placeholder' => '',
	),
	array(
		'key'         => 'season',
		'taxonomy'    => 'iflynepal_season',
		'label'       => __( 'Travelling', 'iflynepal' ),
		'placeholder' => __( 'Not sure yet', 'iflynepal' ),
	),
);

$iflynepal_action = function_exists( 'iflynepal_trips_search_url' )
	? iflynepal_trips_search_url()
	: home_url( '/' );
?>
<form
	class="iflynepal-trip-search"
	action="<?php echo esc_url( $iflynepal_action ); ?>"
	method="get"
	role="search"
	aria-label="<?php esc_attr_e( 'Find your Nepal experience', 'iflynepal' ); ?>"
>
	<?php
	foreach ( $iflynepal_fields as $iflynepal_field ) :
		if ( '' === $iflynepal_field['taxonomy'] || ! taxonomy_exists( $iflynepal_field['taxonomy'] ) ) {
			continue;
		}

		$iflynepal_terms = get_terms(
			array(
				'taxonomy'   => $iflynepal_field['taxonomy'],
				'hide_empty' => false,
				'orderby'    => 'term_id',
				'order'      => 'ASC',
			)
		);

		if ( is_wp_error( $iflynepal_terms ) || empty( $iflynepal_terms ) ) {
			continue;
		}

		$iflynepal_id       = 'iflynepal-' . $iflynepal_field['key'];
		$iflynepal_selected = isset( $_GET[ $iflynepal_field['taxonomy'] ] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			? sanitize_title( wp_unslash( $_GET[ $iflynepal_field['taxonomy'] ] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			: '';
		?>
		<div class="iflynepal-search-field">
			<label for="<?php echo esc_attr( $iflynepal_id ); ?>">
				<?php echo esc_html( $iflynepal_field['label'] ); ?>
			</label>
			<select id="<?php echo esc_attr( $iflynepal_id ); ?>" name="<?php echo esc_attr( $iflynepal_field['taxonomy'] ); ?>">
				<?php if ( '' !== $iflynepal_field['placeholder'] ) : ?>
					<option value=""><?php echo esc_html( $iflynepal_field['placeholder'] ); ?></option>
				<?php endif; ?>
				<?php foreach ( $iflynepal_terms as $iflynepal_term ) : ?>
					<option
						value="<?php echo esc_attr( $iflynepal_term->slug ); ?>"
						<?php selected( $iflynepal_selected, $iflynepal_term->slug ); ?>
					>
						<?php echo esc_html( $iflynepal_term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endforeach; ?>

	<button class="iflynepal-button iflynepal-button--dark" type="submit">
		<?php esc_html_e( 'Find My Trip', 'iflynepal' ); ?>
		<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
	</button>
</form>
