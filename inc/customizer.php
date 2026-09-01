<?php
/**
 * Customizer settings.
 *
 * The hero's background media all lives here — the still shown first, the
 * video that plays over it, its poster frame, and a fallback source. There is
 * no block editor to hold any of this, so all four are plain Customizer
 * settings under one section.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default hero still — the image the design ships with.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HERO_STILL_DEFAULT = 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=2200&q=88';

/**
 * Default poster frame for the hero video.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_HERO_POSTER_DEFAULT = 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1600&q=70';

/**
 * Registers the hero media section.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function iflynepal_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section(
		'iflynepal_hero',
		array(
			'title'       => esc_html__( 'Hero Background', 'iflynepal' ),
			'description' => esc_html__( 'The still image sits under the hero video and is what visitors see first.', 'iflynepal' ),
			'priority'    => 30,
		)
	);

	$settings = array(
		'iflynepal_hero_video_url'          => array(
			'default' => '',
			'label'   => esc_html__( 'Video URL', 'iflynepal' ),
			'help'    => esc_html__( 'Background clip that plays over the still. Leave empty to show the still only.', 'iflynepal' ),
		),
		'iflynepal_hero_still_url'          => array(
			'default' => IFLYNEPAL_HERO_STILL_DEFAULT,
			'label'   => esc_html__( 'Still image URL', 'iflynepal' ),
			'help'    => esc_html__( 'Shown immediately and behind the video. This is the largest element on the page — keep it under 150 KB.', 'iflynepal' ),
		),
		'iflynepal_hero_poster_url'         => array(
			'default' => IFLYNEPAL_HERO_POSTER_DEFAULT,
			'label'   => esc_html__( 'Video poster URL', 'iflynepal' ),
			'help'    => esc_html__( 'Frame shown while the video loads.', 'iflynepal' ),
		),
		'iflynepal_hero_video_fallback_url' => array(
			'default' => '',
			'label'   => esc_html__( 'Fallback video URL', 'iflynepal' ),
			'help'    => esc_html__( 'Optional second source, played when the primary video cannot be loaded.', 'iflynepal' ),
		),
	);

	foreach ( $settings as $id => $config ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $config['default'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$id,
			array(
				'label'       => $config['label'],
				'description' => $config['help'],
				'section'     => 'iflynepal_hero',
				'type'        => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'iflynepal_customize_register' );

/**
 * Hero background video URL.
 *
 * @since 1.0.0
 *
 * @return string URL, or an empty string when unset.
 */
function iflynepal_hero_video_url() {
	return (string) get_theme_mod( 'iflynepal_hero_video_url', '' );
}

/**
 * Hero still image URL.
 *
 * @since 1.0.0
 *
 * @return string URL, or an empty string when cleared.
 */
function iflynepal_hero_still_url() {
	return (string) get_theme_mod( 'iflynepal_hero_still_url', IFLYNEPAL_HERO_STILL_DEFAULT );
}

/**
 * Hero video poster frame URL.
 *
 * @since 1.0.0
 *
 * @return string URL.
 */
function iflynepal_hero_poster_url() {
	return (string) get_theme_mod( 'iflynepal_hero_poster_url', IFLYNEPAL_HERO_POSTER_DEFAULT );
}

/**
 * Fallback hero video URL, used when the primary source cannot be loaded.
 *
 * @since 1.0.0
 *
 * @return string URL, or an empty string when unset.
 */
function iflynepal_hero_video_fallback_url() {
	return (string) get_theme_mod( 'iflynepal_hero_video_fallback_url', '' );
}

/**
 * Scheme and host serving the hero still, for the preconnect hint.
 *
 * @since 1.0.0
 *
 * @return string Origin, or an empty string when the still is same-origin or unset.
 */
function iflynepal_hero_still_origin() {
	$url = iflynepal_hero_still_url();

	if ( '' === $url ) {
		return '';
	}

	$parts = wp_parse_url( $url );

	if ( empty( $parts['scheme'] ) || empty( $parts['host'] ) ) {
		return '';
	}

	// Same-origin assets need no hint.
	if ( wp_parse_url( home_url(), PHP_URL_HOST ) === $parts['host'] ) {
		return '';
	}

	return $parts['scheme'] . '://' . $parts['host'];
}
