<?php
/**
 * Why-trust section getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * Same shape as the hero and Explore sections: each render callback is also
 * what the template calls, so the pencil-shortcut preview and the shipped page
 * come from the same code.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Feature bullets beside the promo card. The design is a two-by-two grid.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRUST_FEATURES = 4;

/**
 * Logos each band can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/homepage/trust/logos.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRUST_LOGO_MAX = 10;

/**
 * Default kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRUST_KICKER_DEFAULT = 'Why trust iFly Nepal';

/**
 * Default heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRUST_TITLE_DEFAULT = 'Trust should be visible before someone pays.';

/**
 * Stand-in promo photograph, used until the client's own image is uploaded.
 *
 * The card is a photographic panel, so it needs an image to hold its shape at
 * all — the same reasoning as the Explore cards, and unlike the hero.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRUST_PROMO_IMAGE_DEFAULT = 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?auto=format&fit=crop&w=1200&q=85';

/**
 * The icons a feature bullet can be given.
 *
 * A fixed set rather than an upload field: WordPress refuses SVG uploads by
 * default because an SVG is a script-bearing document, and a raster icon cannot
 * take its colour from the surrounding CSS the way these do. Each entry is
 * drawn in a 24x24 box; 'fill' marks the solid ones, which are painted rather
 * than stroked.
 *
 * @since 1.0.0
 *
 * @return array[] Icons keyed by slug, each with 'label', 'path' and 'fill'.
 */
function iflynepal_trust_icons() {
	return array(
		'globe'    => array(
			'label' => __( 'Globe', 'iflynepal' ),
			'path'  => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z',
			'fill'  => true,
		),
		'thumb-up' => array(
			'label' => __( 'Thumbs up', 'iflynepal' ),
			'path'  => 'M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z',
			'fill'  => true,
		),
		'card'     => array(
			'label' => __( 'Payment card', 'iflynepal' ),
			'path'  => 'M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z',
			'fill'  => true,
		),
		'badge'    => array(
			'label' => __( 'Award badge', 'iflynepal' ),
			'path'  => 'M9.68 13.69L12 11.93l2.31 1.76-.88-2.85L15.75 9h-2.84L12 6.19 11.09 9H8.25l1.87 1.84-.44 2.85zM20 10c0-4.42-3.58-8-8-8s-8 3.58-8 8c0 2.03.76 3.87 2 5.28V23l6-2 6 2v-7.72c1.24-1.41 2-3.25 2-5.28zm-8-6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6 2.69-6 6-6z',
			'fill'  => true,
		),
		'shield'   => array(
			'label' => __( 'Shield', 'iflynepal' ),
			'path'  => 'M12 3l7 3v5.4c0 4.3-2.9 7.6-7 9.6-4.1-2-7-5.3-7-9.6V6l7-3z',
			'fill'  => false,
		),
		'check'    => array(
			'label' => __( 'Tick', 'iflynepal' ),
			'path'  => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zM7.8 12.2l2.9 2.9 5.5-6',
			'fill'  => false,
		),
		'mountain' => array(
			'label' => __( 'Mountain', 'iflynepal' ),
			'path'  => 'M2.8 18.6l6.2-10.4 4.1 6.6 2.6-4 5.5 7.8z',
			'fill'  => false,
		),
		'pin'      => array(
			'label' => __( 'Map pin', 'iflynepal' ),
			'path'  => 'M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11zM14.4 10a2.4 2.4 0 1 1-4.8 0 2.4 2.4 0 0 1 4.8 0z',
			'fill'  => false,
		),
		'calendar' => array(
			'label' => __( 'Calendar', 'iflynepal' ),
			'path'  => 'M4.8 6.2h14.4v14H4.8zM4.8 10.4h14.4M8.6 3.6v4M15.4 3.6v4',
			'fill'  => false,
		),
		'chat'     => array(
			'label' => __( 'Message', 'iflynepal' ),
			'path'  => 'M21 11.5a8.4 8.4 0 0 1-8.5 8.4 8.6 8.6 0 0 1-3.9-.9L3 20.5l1.6-5A8.4 8.4 0 0 1 12.5 3 8.4 8.4 0 0 1 21 11.5z',
			'fill'  => false,
		),
		'people'   => array(
			'label' => __( 'People', 'iflynepal' ),
			'path'  => 'M9 11.4a3.7 3.7 0 1 0 0-7.4 3.7 3.7 0 0 0 0 7.4zM2.6 20.4c0-3.5 2.9-5.8 6.4-5.8s6.4 2.3 6.4 5.8M16.6 4.5a3.7 3.7 0 0 1 0 6.9M18.2 15c2.2.6 3.6 2.4 3.6 4.7',
			'fill'  => false,
		),
		'clock'    => array(
			'label' => __( 'Clock', 'iflynepal' ),
			'path'  => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zM12 7.4V12l3.2 2',
			'fill'  => false,
		),
	);
}

/**
 * Default copy for the four bullets, as the approved mockup has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_trust_feature_defaults() {
	return array(
		1 => array(
			'icon'        => 'globe',
			'title'       => __( 'Wide range of trips', 'iflynepal' ),
			'description' => __( 'Treks, cultural tours, wildlife and retreats — real choice across Nepal, not a fixed catalogue.', 'iflynepal' ),
		),
		2 => array(
			'icon'        => 'thumb-up',
			'title'       => __( 'Trusted by travellers', 'iflynepal' ),
			'description' => __( 'Verify the story on Google and Tripadvisor — review platforms we don’t control.', 'iflynepal' ),
		),
		3 => array(
			'icon'        => 'card',
			'title'       => __( 'Flexible & clear booking', 'iflynepal' ),
			'description' => __( 'See exactly what gets confirmed before you pay, with a Kathmandu contact to adjust plans.', 'iflynepal' ),
		),
		4 => array(
			'icon'        => 'badge',
			'title'       => __( 'Licensed & certified', 'iflynepal' ),
			'description' => __( 'Listed with Nepal Tourism Board, TAAN, NMA and KEEP — memberships you can check.', 'iflynepal' ),
		),
	);
}

/**
 * One bullet's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return array Defaults for that bullet.
 */
function iflynepal_trust_feature_default( $index ) {
	$defaults = iflynepal_trust_feature_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'icon'        => 'shield',
		'title'       => '',
		'description' => '',
	);
}

/**
 * Default copy for the promo card, as the approved mockup has it.
 *
 * @since 1.0.0
 *
 * @return array Promo defaults.
 */
function iflynepal_trust_promo_defaults() {
	return array(
		'kicker'       => __( 'Start planning', 'iflynepal' ),
		'title'        => __( 'Your Nepal adventure awaits', 'iflynepal' ),
		'description'  => __( 'Talk to a Kathmandu-based expert and shape a trek, tour or retreat around how you want to travel.', 'iflynepal' ),
		'button_label' => __( 'Plan Your Trip', 'iflynepal' ),
		'button_url'   => '#explore',
	);
}

/**
 * Constrains an icon slug to one this theme draws.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string A known slug, falling back to the first one registered.
 */
function iflynepal_sanitize_trust_icon( $value ) {
	$icons = iflynepal_trust_icons();

	if ( isset( $icons[ $value ] ) ) {
		return (string) $value;
	}

	return (string) key( $icons );
}

/* -------------------------------------------------------------------- copy */

/**
 * Kicker above the heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_trust_kicker() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_trust_kicker', IFLYNEPAL_TRUST_KICKER_DEFAULT ) );
}

/**
 * Section heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_trust_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_trust_title', IFLYNEPAL_TRUST_TITLE_DEFAULT ) );
}

/**
 * One bullet's icon slug.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Icon slug.
 */
function iflynepal_trust_feature_icon( $index ) {
	$default = iflynepal_trust_feature_default( $index );

	return iflynepal_sanitize_trust_icon( (string) get_theme_mod( 'iflynepal_trust_feature_' . $index . '_icon', $default['icon'] ) );
}

/**
 * One bullet's title.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Title text.
 */
function iflynepal_trust_feature_title( $index ) {
	$default = iflynepal_trust_feature_default( $index );

	return (string) get_theme_mod( 'iflynepal_trust_feature_' . $index . '_title', $default['title'] );
}

/**
 * One bullet's description.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Description HTML.
 */
function iflynepal_trust_feature_description( $index ) {
	$default = iflynepal_trust_feature_default( $index );

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_trust_feature_' . $index . '_description', $default['description'] ) );
}

/**
 * One promo card field.
 *
 * @since 1.0.0
 *
 * @param string $field One of the keys in iflynepal_trust_promo_defaults().
 * @return string Stored value, or the default.
 */
function iflynepal_trust_promo_field( $field ) {
	$defaults = iflynepal_trust_promo_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_trust_promo_' . $field, $default );
}

/* ------------------------------------------------------------------- media */

/**
 * Promo card background image URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL.
 */
function iflynepal_trust_promo_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_trust_promo_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_TRUST_PROMO_IMAGE_DEFAULT;
}

/**
 * The attachment IDs in one logo band, in order, skipping empty slots.
 *
 * Emptying a slot is how the Customizer's Remove button deletes a logo, so a
 * zero is dropped rather than rendered as a blank chip.
 *
 * @since 1.0.0
 *
 * @param string $group Either 'partner' or 'association'.
 * @return int[] Attachment IDs.
 */
function iflynepal_trust_logos( $group ) {
	$ids = array();

	for ( $i = 1; $i <= IFLYNEPAL_TRUST_LOGO_MAX; $i++ ) {
		$id = (int) get_theme_mod( 'iflynepal_trust_' . $group . '_' . $i, 0 );

		if ( $id ) {
			$ids[] = $id;
		}
	}

	return $ids;
}

/**
 * Whether either logo band has anything to show.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_trust_has_logos() {
	return (bool) iflynepal_trust_logos( 'partner' ) || (bool) iflynepal_trust_logos( 'association' );
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_kicker() {
	return iflynepal_trust_kicker();
}

/**
 * Renders the section heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_title() {
	return iflynepal_trust_title();
}

/**
 * Renders one bullet's icon.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Markup.
 */
function iflynepal_render_trust_feature_icon( $index ) {
	$icons = iflynepal_trust_icons();
	$slug  = iflynepal_trust_feature_icon( $index );
	$icon  = $icons[ $slug ];

	return sprintf(
		'<svg class="iflynepal-trust__glyph%1$s" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="%2$s"/></svg>',
		$icon['fill'] ? ' iflynepal-trust__glyph--fill' : '',
		esc_attr( $icon['path'] )
	);
}

/**
 * Renders one bullet's title.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Markup.
 */
function iflynepal_render_trust_feature_title( $index ) {
	return esc_html( iflynepal_trust_feature_title( $index ) );
}

/**
 * Renders one bullet's description.
 *
 * @since 1.0.0
 *
 * @param int $index Bullet number.
 * @return string Markup.
 */
function iflynepal_render_trust_feature_description( $index ) {
	return iflynepal_trust_feature_description( $index );
}

/**
 * Renders the promo card's kicker.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_promo_kicker() {
	return esc_html( iflynepal_trust_promo_field( 'kicker' ) );
}

/**
 * Renders the promo card's title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_promo_title() {
	return iflynepal_kses_text( iflynepal_trust_promo_field( 'title' ) );
}

/**
 * Renders the promo card's description.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_promo_description() {
	return iflynepal_kses_text( iflynepal_trust_promo_field( 'description' ) );
}

/**
 * Renders the promo card's button.
 *
 * A label emptied in the Customizer removes the button, the same way an emptied
 * link label removes an Explore card link.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_trust_promo_button() {
	$label = trim( iflynepal_trust_promo_field( 'button_label' ) );

	if ( '' === $label ) {
		return '';
	}

	return sprintf(
		'<a class="iflynepal-button iflynepal-button--light iflynepal-trust__promo-button" href="%1$s">%2$s<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>',
		esc_url( iflynepal_trust_promo_field( 'button_url' ) ),
		esc_html( $label )
	);
}

/**
 * Renders one logo band's track, with the run duplicated.
 *
 * The marquee scrolls the track to -50% and starts over, so the second copy is
 * what stands in the gap while the first is scrolling away. It is hidden from
 * assistive technology, which would otherwise read every logo twice.
 *
 * @since 1.0.0
 *
 * @param string $group Either 'partner' or 'association'.
 * @return string Markup.
 */
function iflynepal_render_trust_logos( $group ) {
	$ids = iflynepal_trust_logos( $group );

	if ( ! $ids ) {
		return '';
	}

	$markup = '';

	foreach ( array( false, true ) as $is_duplicate ) {
		foreach ( $ids as $id ) {
			$image = wp_get_attachment_image(
				$id,
				'medium',
				false,
				array(
					'class'   => 'iflynepal-trust__logo-image',
					'loading' => 'lazy',
					'alt'     => $is_duplicate ? '' : trim( (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) ),
				)
			);

			if ( ! $image ) {
				continue;
			}

			$markup .= sprintf(
				'<span class="iflynepal-trust__logo"%1$s>%2$s</span>',
				$is_duplicate ? ' aria-hidden="true"' : '',
				$image
			);
		}
	}

	return $markup;
}
