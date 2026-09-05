<?php
/**
 * Footer getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default line beside the logo.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_FOOTER_BLURB_DEFAULT = 'Local journeys across trekking, tours, wildlife, workshops, volunteering and meaningful retreats in Nepal.';

/**
 * The review platforms shown in the "Recommended on" row.
 *
 * A subset of the testimonial registry, in the order the design has them. The
 * URLs are NOT stored separately — see iflynepal_footer_reviews() — so adding a
 * platform here is enough to put it in the footer, provided it also exists in
 * iflynepal_testimonial_platforms().
 *
 * @since 1.0.0
 *
 * @return string[] Platform slugs.
 */
function iflynepal_footer_review_slugs() {
	return array( 'google', 'tripadvisor', 'trustpilot' );
}

/**
 * The social networks the follow row can carry.
 *
 * Adding one is a single entry here: the Customizer grows a field and the row
 * grows a button, with nothing else to change. Slugs are stored, so reordering
 * this list is safe and renaming a slug is not.
 *
 * `brand` is the colour the button fills with on hover — the network's own, so
 * the row reads as the set of places the company actually is.
 *
 * The marks are deliberately simplified single-colour glyphs, the same call the
 * testimonial platform icons make: recognisable at 18px, without shipping a
 * half-remembered trademark. The design pulls these from an icon CDN at render
 * time; they are inlined here instead, so the footer costs no extra requests
 * and works with no third-party origin involved.
 *
 * @since 1.0.0
 *
 * @return array[] Networks keyed by slug, each with 'label', 'brand', 'placeholder' and 'path'.
 */
function iflynepal_footer_social_networks() {
	return array(
		'facebook'  => array(
			'label'       => __( 'Facebook', 'iflynepal' ),
			'brand'       => '#1877f2',
			'placeholder' => 'https://www.facebook.com/iFlytoNepal',
			'path'        => 'M13.4 21v-8h2.7l.4-3.1h-3.1V7.85c0-.9.25-1.5 1.55-1.5h1.65V3.6c-.29-.04-1.27-.13-2.42-.13-2.4 0-4.03 1.46-4.03 4.15V9.9H7.4V13h2.75v8z',
		),
		'x'         => array(
			'label'       => __( 'X', 'iflynepal' ),
			'brand'       => '#111111',
			'placeholder' => 'https://x.com/iFlytoNepal',
			'path'        => 'M17.53 3h3.2l-6.99 7.99L22 21h-6.44l-5.04-6.59L4.75 21h-3.2l7.48-8.55L1.6 3h6.6l4.56 6.03zm-1.12 16.08h1.77L7.68 4.83H5.78z',
		),
		'instagram' => array(
			'label'       => __( 'Instagram', 'iflynepal' ),
			'brand'       => '#e4405f',
			'placeholder' => 'https://www.instagram.com/iflytonepal/',
			'path'        => 'M8 2h8a6 6 0 0 1 6 6v8a6 6 0 0 1-6 6H8a6 6 0 0 1-6-6V8a6 6 0 0 1 6-6zm0 2a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4zm4 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm5.5-3.2a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z',
		),
		'linkedin'  => array(
			'label'       => __( 'LinkedIn', 'iflynepal' ),
			'brand'       => '#0a66c2',
			'placeholder' => 'https://www.linkedin.com/company/iflytonepal',
			'path'        => 'M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zm7 0h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.4c0-1.29-.02-2.95-1.8-2.95-1.8 0-2.07 1.4-2.07 2.85V21h-4z',
		),
		'medium'    => array(
			'label'       => __( 'Medium', 'iflynepal' ),
			'brand'       => '#111111',
			'placeholder' => 'https://medium.com/@iflytonepal',
			'path'        => 'M2.9 7.4a.86.86 0 0 0-.28-.73L.55 4.18v-.37h6.42l4.96 10.88L16.3 3.81H22.4v.37l-1.77 1.7a.52.52 0 0 0-.2.5v12.5a.52.52 0 0 0 .2.5l1.73 1.7v.37h-8.7v-.37l1.79-1.74c.18-.18.18-.23.18-.5V8.73l-4.98 12.65h-.67L4.28 8.73v8.48c-.05.36.07.72.33.98l2.33 2.83v.37H.29v-.37L2.62 18.2a1.1 1.1 0 0 0 .29-.99z',
		),
		'youtube'   => array(
			'label'       => __( 'YouTube', 'iflynepal' ),
			'brand'       => '#ff0000',
			'placeholder' => 'https://www.youtube.com/@iFlyNepal',
			'path'        => 'M22.5 7.2a2.7 2.7 0 0 0-1.9-1.9C18.9 4.8 12 4.8 12 4.8s-6.9 0-8.6.5A2.7 2.7 0 0 0 1.5 7.2C1 8.9 1 12 1 12s0 3.1.5 4.8a2.7 2.7 0 0 0 1.9 1.9c1.7.5 8.6.5 8.6.5s6.9 0 8.6-.5a2.7 2.7 0 0 0 1.9-1.9c.5-1.7.5-4.8.5-4.8s0-3.1-.5-4.8zM9.8 15.3V8.7l5.7 3.3z',
		),
		'reddit'    => array(
			'label'       => __( 'Reddit', 'iflynepal' ),
			'brand'       => '#ff4500',
			'placeholder' => 'https://www.reddit.com/user/iFlyNepal/',
			'path'        => 'M22 12.1a2.1 2.1 0 0 0-3.56-1.5 10.3 10.3 0 0 0-5.6-1.79l.95-4.48 3.11.66a1.5 1.5 0 1 0 .18-1l-3.5-.74a.5.5 0 0 0-.6.39l-1.06 5.17a10.3 10.3 0 0 0-5.68 1.79 2.1 2.1 0 1 0-2.3 3.43c-.03.21-.05.42-.05.63 0 3.2 3.74 5.8 8.35 5.8s8.35-2.6 8.35-5.8c0-.21-.02-.42-.05-.63A2.1 2.1 0 0 0 22 12.1ZM7.6 13.6a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm8.37 3.96c-1.02 1.02-2.98 1.1-3.56 1.1-.58 0-2.54-.08-3.56-1.1a.39.39 0 0 1 .55-.55c.64.64 2.02.87 3.01.87s2.37-.23 3.01-.87a.39.39 0 0 1 .55.55Zm-.07-2.46a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z',
		),
		'tiktok'    => array(
			'label'       => __( 'TikTok', 'iflynepal' ),
			'brand'       => '#111111',
			'placeholder' => 'https://www.tiktok.com/@iFlyNepal',
			'path'        => 'M16.6 5.82A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 0 1-2.59 2.5 2.59 2.59 0 0 1 0-5.18c.27 0 .53.04.77.12v-3.2a5.8 5.8 0 0 0-.77-.05 5.78 5.78 0 1 0 5.78 5.78V9.01a7.35 7.35 0 0 0 4.29 1.38V7.3a4.29 4.29 0 0 1-3.33-1.48z',
		),
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * The line beside the logo.
 *
 * @since 1.0.0
 *
 * @return string Blurb HTML.
 */
function iflynepal_footer_blurb() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_footer_blurb', IFLYNEPAL_FOOTER_BLURB_DEFAULT ) );
}

/**
 * Default head office details, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array Office defaults.
 */
function iflynepal_footer_office_defaults() {
	return array(
		'heading' => __( 'Head office', 'iflynepal' ),
		'address' => __( 'Tarkeshwor-2,<br>Kathmandu, Nepal', 'iflynepal' ),
		'phone'   => '+977 9841771010',
		'hours'   => __( '9:00 AM to 5:00 PM', 'iflynepal' ),
		'email'   => 'contact@iflynepal.com',
	);
}

/**
 * One head office field.
 *
 * @since 1.0.0
 *
 * @param string $field Field key.
 * @return string Stored value, or the default.
 */
function iflynepal_footer_office_field( $field ) {
	$defaults = iflynepal_footer_office_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_footer_office_' . $field, $default );
}

/**
 * The line along the bottom of the footer, after the year and site name.
 *
 * @since 1.0.0
 *
 * @return string Copyright text.
 */
function iflynepal_footer_copyright() {
	return (string) get_theme_mod( 'iflynepal_footer_copyright', __( 'All rights reserved.', 'iflynepal' ) );
}

/* ----------------------------------------------------------------- reviews */

/**
 * The review links shown in the "Recommended on" row.
 *
 * Reads the option the Testimonials > Add External Testimonial Links screen
 * writes, filtered to the platforms the footer shows. The Customizer controls
 * in the Footer panel write to that same option rather than to theme mods, so
 * a review URL is typed once and both places follow it — see
 * inc/customizer/sections/footer.php.
 *
 * @since 1.0.0
 *
 * @return array[] Links, each with 'slug', 'label', 'name' and 'url'.
 */
function iflynepal_footer_reviews() {
	$wanted = array_flip( iflynepal_footer_review_slugs() );
	$links  = array();

	foreach ( iflynepal_testimonial_links() as $link ) {
		if ( isset( $wanted[ $link['slug'] ] ) ) {
			$links[] = $link;
		}
	}

	return $links;
}

/* ---------------------------------------------------------------- socials */

/**
 * The social links that have a URL, in registry order.
 *
 * Emptying a field is how a network is removed from the row, so a blank one is
 * skipped rather than rendered as a dead button.
 *
 * @since 1.0.0
 *
 * @return array[] Networks, each with 'slug', 'label', 'brand', 'path' and 'url'.
 */
function iflynepal_footer_socials() {
	$socials = array();

	foreach ( iflynepal_footer_social_networks() as $slug => $network ) {
		$url = trim( (string) get_theme_mod( 'iflynepal_footer_social_' . $slug, $network['placeholder'] ) );

		if ( '' === $url ) {
			continue;
		}

		$socials[] = array(
			'slug'  => $slug,
			'label' => $network['label'],
			'brand' => $network['brand'],
			'path'  => $network['path'],
			'url'   => $url,
		);
	}

	return $socials;
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the line beside the logo.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_blurb() {
	return iflynepal_footer_blurb();
}

/**
 * Renders the head office column heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_office_heading() {
	return esc_html( iflynepal_footer_office_field( 'heading' ) );
}

/**
 * Renders the head office block.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_office() {
	$address = trim( iflynepal_footer_office_field( 'address' ) );
	$phone   = trim( iflynepal_footer_office_field( 'phone' ) );
	$hours   = trim( iflynepal_footer_office_field( 'hours' ) );
	$email   = trim( iflynepal_footer_office_field( 'email' ) );

	$markup = '';

	if ( '' !== $address ) {
		$markup .= '<p class="iflynepal-footer__office-address">' . iflynepal_kses_text( $address ) . '</p>';
	}

	if ( '' !== $phone ) {
		$markup .= sprintf(
			'<p class="iflynepal-footer__contact"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8 3H5a2 2 0 0 0-2 2c0 8.84 7.16 16 16 16a2 2 0 0 0 2-2v-3l-5-1-1.5 2.5a13 13 0 0 1-8-8L9 8z"/></svg><a href="%1$s">%2$s</a></p>',
			esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ),
			esc_html( $phone )
		);
	}

	if ( '' !== $hours ) {
		$markup .= sprintf(
			'<p class="iflynepal-footer__contact"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span>%s</span></p>',
			esc_html( $hours )
		);
	}

	if ( '' !== $email ) {
		$markup .= sprintf(
			'<p class="iflynepal-footer__contact"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 5h18v14H3z"/><path d="m3 7 9 6 9-6"/></svg><a href="%1$s">%2$s</a></p>',
			esc_url( 'mailto:' . $email ),
			esc_html( $email )
		);
	}

	return $markup;
}

/**
 * Renders the "Recommended on" chips.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_reviews() {
	$markup = '';

	foreach ( iflynepal_footer_reviews() as $review ) {
		$markup .= sprintf(
			'<a class="iflynepal-footer__chip" href="%1$s" target="_blank" rel="noopener"><span class="iflynepal-footer__chip-icon">%2$s</span>%3$s</a>',
			esc_url( $review['url'] ),
			// Built from a fixed registry of inline SVG, no editor input in it.
			iflynepal_render_testimonial_platform_icon( $review['slug'], 'iflynepal-footer__chip-mark' ),
			esc_html( $review['name'] )
		);
	}

	return $markup;
}

/**
 * Renders the social buttons.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_socials() {
	$markup = '';

	foreach ( iflynepal_footer_socials() as $social ) {
		$markup .= sprintf(
			'<a class="iflynepal-footer__social" style="--iflynepal-brand:%1$s" href="%2$s" target="_blank" rel="noopener" aria-label="%3$s"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="%4$s"/></svg></a>',
			esc_attr( $social['brand'] ),
			esc_url( $social['url'] ),
			esc_attr(
				sprintf(
					/* translators: 1: site name, 2: social network name. */
					__( '%1$s on %2$s', 'iflynepal' ),
					get_bloginfo( 'name' ),
					$social['label']
				)
			),
			esc_attr( $social['path'] )
		);
	}

	return $markup;
}

/**
 * Renders the copyright line.
 *
 * The year comes from the clock rather than a setting, so it can never go
 * stale, and the site name from Settings > General rather than a second field.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_footer_copyright() {
	return sprintf(
		/* translators: 1: current year, 2: site name, 3: rights statement. */
		esc_html__( '© %1$s %2$s. %3$s', 'iflynepal' ),
		esc_html( gmdate( 'Y' ) ),
		'<strong>' . esc_html( get_bloginfo( 'name' ) ) . '</strong>',
		esc_html( iflynepal_footer_copyright() )
	);
}
