<?php
/**
 * Travel Guide column getters and selective-refresh render callbacks.
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
 * Guides the column can carry.
 *
 * Each one is a dropdown of published posts in the Customizer, so raising
 * this adds a dropdown and nothing else.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_GUIDE_MAX = 5;

/**
 * Default kicker above the heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_GUIDE_KICKER_DEFAULT = 'Nepal travel guide';

/**
 * Default heading.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_GUIDE_TITLE_DEFAULT = 'Plan with useful local context.';

/**
 * Published posts, as options for the guide dropdowns.
 *
 * Built once per language and shared by that language's five controls rather
 * than queried per control. The query asks for IDs only and skips the meta
 * and term caches, since the title is all the dropdown shows.
 *
 * On a multilingual site $lang narrows the list to that language's own posts
 * — the English dropdowns list only English posts, the French ones only
 * French posts — since a slot pointed at the wrong language's post would
 * silently show mixed-language guides on the front end. A non-default
 * language's entries carry the linked default-language title as a hint
 * (" — EN: ..."), because a French title alone does not say which English
 * post it is the translation of.
 *
 * @since 1.0.0
 *
 * @param string $lang Language slug, or '' for every language (non-multilingual site).
 * @return array Choices keyed by post ID, with 0 as the "none" option.
 */
function iflynepal_guide_post_choices( $lang = '' ) {
	static $choices = array();

	if ( isset( $choices[ $lang ] ) ) {
		return $choices[ $lang ];
	}

	$query_args = array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'numberposts'            => -1,
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	);

	$is_multilingual = iflynepal_customizer_is_multilingual();
	$default_lang    = $is_multilingual ? PLL()->options['default_lang'] : '';

	if ( '' !== $lang && $is_multilingual ) {
		$query_args['lang'] = $lang;
	}

	$list = array( 0 => __( '— Select a guide —', 'iflynepal' ) );

	foreach ( get_posts( $query_args ) as $id ) {
		$title = get_the_title( $id );

		if ( $is_multilingual && '' !== $lang && $lang !== $default_lang && function_exists( 'pll_get_post' ) ) {
			$original = pll_get_post( $id, $default_lang );

			if ( $original && (int) $original !== (int) $id ) {
				$title = sprintf(
					/* translators: 1: post title, 2: the default language's code (e.g. "EN"), 3: the same post's title in that language. */
					__( '%1$s — %2$s: %3$s', 'iflynepal' ),
					$title,
					strtoupper( $default_lang ),
					get_the_title( $original )
				);
			}
		}

		$list[ $id ] = $title;
	}

	$choices[ $lang ] = $list;

	return $list;
}

/**
 * Default label and destination for the link under the cards.
 *
 * @since 1.0.0
 *
 * @return array Link defaults.
 */
function iflynepal_guide_cta_defaults() {
	return array(
		'label' => __( 'Browse all Nepal guides', 'iflynepal' ),
		'url'   => '',
	);
}

/* -------------------------------------------------------------------- copy */

/**
 * Kicker above the heading.
 *
 * @since 1.0.0
 *
 * @return string Kicker HTML.
 */
function iflynepal_guide_kicker() {
	$kicker = get_theme_mod( 'iflynepal_guide_kicker', IFLYNEPAL_GUIDE_KICKER_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$kicker = pll__( $kicker );
	}

	return iflynepal_kses_text( $kicker );
}

/**
 * Column heading.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_guide_title() {
	$title = get_theme_mod( 'iflynepal_guide_title', IFLYNEPAL_GUIDE_TITLE_DEFAULT );

	if ( function_exists( 'pll__' ) ) {
		$title = pll__( $title );
	}

	return iflynepal_kses_text( $title );
}

/**
 * One link field.
 *
 * The URL falls back to the posts page, so the link points somewhere real
 * before anyone has set it.
 *
 * @since 1.0.0
 *
 * @param string $field Either 'label' or 'url'.
 * @return string Stored value, or the default.
 */
function iflynepal_guide_cta_field( $field ) {
	$defaults = iflynepal_guide_cta_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	if ( 'url' === $field ) {
		$value = iflynepal_customizer_get_link( 'iflynepal_guide_cta_url', $default );

		if ( '' === trim( $value ) ) {
			$posts_page = (int) get_option( 'page_for_posts' );

			return $posts_page ? (string) get_permalink( $posts_page ) : '';
		}

		return $value;
	}

	$value = (string) get_theme_mod( 'iflynepal_guide_cta_' . $field, $default );

	if ( function_exists( 'pll__' ) ) {
		$value = pll__( $value );
	}

	return $value;
}

/**
 * The chosen posts, in the order they were chosen.
 *
 * A slot holding a post that has since been deleted or unpublished is skipped
 * rather than rendered as an empty card.
 *
 * @since 1.0.0
 *
 * @return array[] Guides, each with 'id', 'title', 'url', 'category' and 'thumbnail'.
 */
function iflynepal_guide_posts() {
	$guides = array();

	for ( $i = 1; $i <= IFLYNEPAL_GUIDE_MAX; $i++ ) {
		$post_id = (int) iflynepal_customizer_get_choice( 'iflynepal_guide_post_' . $i, 0 );

		if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
			continue;
		}

		$guides[] = array(
			'id'        => $post_id,
			'title'     => get_the_title( $post_id ),
			'url'       => (string) get_permalink( $post_id ),
			'category'  => iflynepal_guide_post_category( $post_id ),
			'thumbnail' => (int) get_post_thumbnail_id( $post_id ),
		);
	}

	return $guides;
}

/**
 * The label above a guide's title: its first category.
 *
 * The default category is skipped where a post has a real one as well, so a
 * post left in "Uncategorised" alongside a proper category reads correctly.
 *
 * @since 1.0.0
 *
 * @param int $post_id Post to read.
 * @return string Category name, empty when the post has none.
 */
function iflynepal_guide_post_category( $post_id ) {
	$categories = get_the_category( $post_id );

	if ( ! $categories ) {
		return '';
	}

	$default = (int) get_option( 'default_category' );

	foreach ( $categories as $category ) {
		if ( (int) $category->term_id !== $default ) {
			return $category->name;
		}
	}

	return $categories[0]->name;
}

/**
 * Whether the column has anything to list.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_guide_has_posts() {
	return (bool) iflynepal_guide_posts();
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the kicker text.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_guide_kicker() {
	return iflynepal_guide_kicker();
}

/**
 * Renders the column heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_guide_title() {
	return iflynepal_guide_title();
}

/**
 * Renders the guide cards.
 *
 * One partial for the whole list, because choosing or clearing a post changes
 * how many cards there are.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_guide_posts() {
	$markup = '';

	foreach ( iflynepal_guide_posts() as $guide ) {
		$image = $guide['thumbnail']
			? wp_get_attachment_image(
				$guide['thumbnail'],
				'medium',
				false,
				array(
					'class'   => 'iflynepal-guides__card-image',
					'alt'     => '',
					'loading' => 'lazy',
				)
			)
			: '<span class="iflynepal-guides__card-image iflynepal-guides__card-image--empty" aria-hidden="true"></span>';

		$markup .= sprintf(
			'<a class="iflynepal-guides__card" %1$s>%2$s<span class="iflynepal-guides__card-copy">%3$s<strong>%4$s</strong></span></a>',
			iflynepal_anchor_attr( $guide['url'] ),
			$image,
			'' === $guide['category'] ? '' : '<small>' . esc_html( $guide['category'] ) . '</small>',
			esc_html( $guide['title'] )
		);
	}

	return $markup;
}

/**
 * Renders the link under the cards.
 *
 * A label emptied in the Customizer removes the link.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_guide_cta() {
	$label = trim( iflynepal_guide_cta_field( 'label' ) );
	$url   = iflynepal_guide_cta_field( 'url' );

	if ( '' === $label || '' === $url ) {
		return '';
	}

	return sprintf(
		'<a class="iflynepal-guides__link" %1$s>%2$s<svg class="iflynepal-ico iflynepal-ico-arr" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>',
		iflynepal_anchor_attr( $url ),
		esc_html( $label )
	);
}

/* ---------------------------------------------------------- translations */

/**
 * Registers the Travel Guide column's Customizer text with Polylang.
 *
 * Pll_register_string() only takes effect in wp-admin (see the identical note
 * on iflynepal_register_authors_pll_strings() in
 * inc/customizer/callbacks/authors.php), so registration can't live inside
 * the getters above — those run on the front end. The guide cards themselves
 * are real posts, not Customizer text, so they translate through Polylang's
 * ordinary post-translation flow instead of this.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_guide_pll_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	pll_register_string( 'Guide kicker', get_theme_mod( 'iflynepal_guide_kicker', IFLYNEPAL_GUIDE_KICKER_DEFAULT ), 'iFlyNepal — Homepage / Travel Guide' );
	pll_register_string( 'Guide title', get_theme_mod( 'iflynepal_guide_title', IFLYNEPAL_GUIDE_TITLE_DEFAULT ), 'iFlyNepal — Homepage / Travel Guide', true );

	$cta_defaults = iflynepal_guide_cta_defaults();

	pll_register_string( 'Guide CTA label', get_theme_mod( 'iflynepal_guide_cta_label', $cta_defaults['label'] ), 'iFlyNepal — Homepage / Travel Guide' );
}
add_action( 'admin_init', 'iflynepal_register_guide_pll_strings', 17 );
