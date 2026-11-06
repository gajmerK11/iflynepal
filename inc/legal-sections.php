<?php
/**
 * Sustainability Policy: the two add/remove lists.
 *
 * "On this page" (up to twenty sections, each with a title, a sub-title and a
 * formatted body) and "Our commitment" (up to twenty cards, each with a title
 * and a short text). Everything the page shows from them — the index links on
 * the left, the clause cards on the right, the promise cards above — is
 * generated from these settings, so adding one in the Customizer adds it
 * everywhere.
 *
 * Both lists are seeded with the copy the page shipped with, so a site that
 * touches nothing is unchanged. Emptying an item's title removes it; the
 * Customizer's "Remove" button does exactly that.
 *
 * Settings are `iflynepal_sustainability_section_{n}_{title|subtitle|body}` and
 * `iflynepal_sustainability_card_{n}_{title|text}`.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/** How many sections the "On this page" list holds. */
const IFLYNEPAL_SUSTAINABILITY_SECTION_MAX = 20;

/** How many cards the "Our commitment" list holds. */
const IFLYNEPAL_SUSTAINABILITY_CARD_MAX = 20;

/**
 * Turns the shipped mini-markup copy into the HTML the rich-text fields hold.
 *
 * Only used to build defaults. Links keep root-relative addresses so a value an
 * editor saves does not carry this site's domain into the database; the
 * renderer resolves them against home_url().
 *
 * @since 1.0.0
 *
 * @param string $raw Mini-markup, see inc/legal-content.php.
 * @return string HTML.
 */
function iflynepal_legal_markup_to_html( $raw ) {
	$html   = '';
	$blocks = iflynepal_legal_parse( $raw );
	$count  = count( $blocks );

	for ( $i = 0; $i < $count; $i++ ) {
		$type = $blocks[ $i ]['type'];
		$text = preg_replace( '/\[([^\]]+)\]\(([^)\s]+)\)/', '<a href="$2">$1</a>', $blocks[ $i ]['text'] );

		if ( in_array( $type, array( 'li', 'tick' ), true ) ) {
			$items = '<li>' . $text . '</li>';

			while ( isset( $blocks[ $i + 1 ] ) && in_array( $blocks[ $i + 1 ]['type'], array( 'li', 'tick' ), true ) ) {
				++$i;
				$items .= '<li>' . preg_replace( '/\[([^\]]+)\]\(([^)\s]+)\)/', '<a href="$2">$1</a>', $blocks[ $i ]['text'] ) . '</li>';
			}

			$html .= '<ul>' . $items . '</ul>';
		} elseif ( 'sub' === $type ) {
			$html .= '<p><strong>' . $text . '</strong></p>';
		} else {
			$html .= '<p>' . $text . '</p>';
		}
	}

	return wp_kses_post( $html );
}

/**
 * The sections the page shipped with.
 *
 * @since 1.0.0
 *
 * @return array[] Keyed by slot number from 1: 'anchor', 'title', 'subtitle', 'body'.
 */
function iflynepal_sustainability_section_defaults() {
	$defaults = array();
	$n        = 0;

	foreach ( iflynepal_sustainability_clauses() as $anchor => $clause ) {
		++$n;
		$defaults[ $n ] = array(
			'anchor'   => $anchor,
			'title'    => $clause['title'],
			'subtitle' => $clause['note'],
			'body'     => iflynepal_legal_markup_to_html( iflynepal_legal_body_default( 'sustainability', $anchor ) ),
		);
	}

	return $defaults;
}

/**
 * The promise cards the page shipped with.
 *
 * @since 1.0.0
 *
 * @return array[] Keyed by slot number from 1: 'title', 'text'.
 */
function iflynepal_sustainability_card_defaults() {
	$extra    = iflynepal_legal_extra_defaults( 'sustainability' );
	$defaults = array();
	$n        = 0;

	foreach ( iflynepal_legal_parse( $extra['cards'] ) as $line ) {
		if ( 'card' !== $line['type'] ) {
			continue;
		}

		$parts          = array_pad( array_map( 'trim', explode( '|', $line['text'], 2 ) ), 2, '' );
		$defaults[ ++$n ] = array(
			'title' => $parts[0],
			'text'  => $parts[1],
		);
	}

	return $defaults;
}

/**
 * Makes a saved rich-text value safe to print.
 *
 * Blank lines become paragraphs, lists get the theme's list class (a list that
 * follows a paragraph gets the spaced variant), and a link starting with `/` is
 * resolved against the site address.
 *
 * @since 1.0.0
 *
 * @param string $html Saved value.
 * @return string Safe HTML.
 */
function iflynepal_legal_rich( $html ) {
	$html = wpautop( wp_kses_post( (string) $html ) );

	$html = preg_replace( '#(</p>\s*)<(ul|ol)>#', '$1<$2 class="iflynepal-legal-rules iflynepal-legal-rules--spaced">', $html );
	$html = preg_replace( '#<(ul|ol)>#', '<$1 class="iflynepal-legal-rules">', $html );
	$html = preg_replace_callback(
		'#href="(/(?!/)[^"]*)"#',
		static function ( $match ) {
			return 'href="' . esc_url( home_url( $match[1] ) ) . '"';
		},
		$html
	);

	return $html;
}

/**
 * Makes a saved short rich-text value safe to print inside a single element.
 *
 * @since 1.0.0
 *
 * @param string $html Saved value.
 * @return string Safe inline HTML.
 */
function iflynepal_legal_rich_inline( $html ) {
	$html = wp_kses(
		(string) $html,
		array(
			'a'      => array(
				'href'   => true,
				'target' => true,
				'rel'    => true,
			),
			'strong' => array(),
			'b'      => array(),
			'em'     => array(),
			'i'      => array(),
			'u'      => array(),
			'br'     => array(),
		)
	);

	return preg_replace_callback(
		'#href="(/(?!/)[^"]*)"#',
		static function ( $match ) {
			return 'href="' . esc_url( home_url( $match[1] ) ) . '"';
		},
		$html
	);
}

/**
 * The sections to show, in order, with their anchors.
 *
 * An item whose title is still the shipped one keeps the shipped anchor, so a
 * link to `#environment` keeps working; any other gets an anchor made from its
 * title, numbered if two would collide.
 *
 * @since 1.0.0
 *
 * @return array[] Each with 'slot', 'anchor', 'title', 'subtitle' and 'body'.
 */
function iflynepal_sustainability_sections() {
	$defaults = iflynepal_sustainability_section_defaults();
	$sections = array();
	$seen     = array();

	for ( $n = 1; $n <= IFLYNEPAL_SUSTAINABILITY_SECTION_MAX; $n++ ) {
		$d     = isset( $defaults[ $n ] ) ? $defaults[ $n ] : array(
			'anchor'   => '',
			'title'    => '',
			'subtitle' => '',
			'body'     => '',
		);
		$title = iflynepal_legal_value( 'sustainability', 'section_' . $n . '_title', $d['title'] );

		if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
			continue;
		}

		$anchor = ( $d['anchor'] && $title === $d['title'] ) ? $d['anchor'] : sanitize_title( wp_strip_all_tags( $title ) );
		$anchor = $anchor ? $anchor : 'section-' . $n;
		$base   = $anchor;
		$suffix = 2;

		while ( isset( $seen[ $anchor ] ) ) {
			$anchor = $base . '-' . $suffix++;
		}

		$seen[ $anchor ] = true;

		$sections[] = array(
			'slot'     => $n,
			'anchor'   => $anchor,
			'title'    => $title,
			'subtitle' => iflynepal_legal_value( 'sustainability', 'section_' . $n . '_subtitle', $d['subtitle'] ),
			'body'     => iflynepal_legal_value( 'sustainability', 'section_' . $n . '_body', $d['body'] ),
		);
	}

	return $sections;
}

/**
 * Renders the "On this page" index from the sections.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_sustainability_index() {
	$markup = '';

	foreach ( iflynepal_sustainability_sections() as $section ) {
		$markup .= sprintf(
			'<a class="iflynepal-legal-index__link" %1$s>%2$s</a>',
			iflynepal_anchor_attr( '#' . $section['anchor'] ),
			esc_html( wp_strip_all_tags( $section['title'] ) )
		);
	}

	return $markup;
}

/**
 * Renders every clause card on the right.
 *
 * The Sustainability Coordinator card follows the sixth slot, where it sat in
 * the Governance clause.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_sustainability_articles() {
	$markup = '';
	$number = 0;

	foreach ( iflynepal_sustainability_sections() as $section ) {
		++$number;

		$coordinator = '';

		if ( 6 === $section['slot'] ) {
			$coordinator = '<div id="iflynepal-sustain-coordinator">' . iflynepal_render_sustainability_coordinator() . '</div>';
		}

		$markup .= sprintf(
			'<article class="iflynepal-legal-clause" id="%1$s" aria-labelledby="%1$s-title" data-iflynepal-reveal>
				<div class="iflynepal-legal-clause__head">
					<span class="iflynepal-legal-clause__num" aria-hidden="true">%2$s</span>
					<div>
						<h3 class="wp-block-heading iflynepal-legal-clause__title" id="%1$s-title">%3$s</h3>
						%4$s
					</div>
				</div>
				<div class="iflynepal-legal-clause__body">%5$s%6$s</div>
			</article>',
			esc_attr( $section['anchor'] ),
			esc_html( str_pad( (string) $number, 2, '0', STR_PAD_LEFT ) ),
			esc_html( wp_strip_all_tags( $section['title'] ) ),
			'' !== trim( $section['subtitle'] ) ? '<small class="iflynepal-legal-clause__note">' . esc_html( wp_strip_all_tags( $section['subtitle'] ) ) . '</small>' : '',
			iflynepal_legal_rich( $section['body'] ),
			$coordinator // Built and escaped by iflynepal_render_sustainability_coordinator().
		);
	}

	return $markup;
}

/**
 * Renders the "Our commitment" cards.
 *
 * Each card reveals on its own, as the design staggers them. The six icons
 * cycle, so a seventh card reuses the first.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_sustainability_pledges() {
	$icons    = array(
		'<path d="M12 21c-4.5-2.5-7-6-7-10a7 7 0 0 1 14 0c0 4-2.5 7.5-7 10z"/><path d="M12 21v-9M9.5 14 12 12l2.5 2"/>',
		'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
		'<path d="M3 21h18M6 21V9l6-5 6 5v12"/><path d="M10 21v-6h4v6"/>',
		'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
		'<circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 2"/>',
		'<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
	);
	$kses     = array(
		'path'   => array( 'd' => true ),
		'circle' => array(
			'cx' => true,
			'cy' => true,
			'r'  => true,
		),
	);
	$defaults = iflynepal_sustainability_card_defaults();
	$markup   = '';
	$shown    = 0;

	for ( $n = 1; $n <= IFLYNEPAL_SUSTAINABILITY_CARD_MAX; $n++ ) {
		$d     = isset( $defaults[ $n ] ) ? $defaults[ $n ] : array(
			'title' => '',
			'text'  => '',
		);
		$title = iflynepal_legal_value( 'sustainability', 'card_' . $n . '_title', $d['title'] );

		if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
			continue;
		}

		// An uploaded icon replaces the built-in one; PNG, JPG, SVG, WebP and GIF all go through an <img>.
		$icon_url = '';
		$icon_id  = (int) get_theme_mod( iflynepal_legal_mod_name( 'sustainability', 'card_' . $n . '_icon' ), 0 );

		if ( $icon_id ) {
			$icon_url = (string) wp_get_attachment_image_url( $icon_id, 'full' );
		}

		$icon_markup = $icon_url
			? '<img class="iflynepal-sustain-pledge__img" src="' . esc_url( $icon_url ) . '" alt="" width="28" height="28" loading="lazy" decoding="async">'
			: '<svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false">' . wp_kses( $icons[ $shown % count( $icons ) ], $kses ) . '</svg>';

		$markup .= sprintf(
			'<article class="iflynepal-sustain-pledge" data-iflynepal-reveal>
				<div class="iflynepal-sustain-pledge__icon" aria-hidden="true">%1$s</div>
				<h3 class="wp-block-heading iflynepal-sustain-pledge__title">%2$s</h3>
				<p class="iflynepal-sustain-pledge__text">%3$s</p>
			</article>',
			$icon_markup, // Built and escaped above.
			esc_html( wp_strip_all_tags( $title ) ),
			iflynepal_legal_rich_inline( iflynepal_legal_value( 'sustainability', 'card_' . $n . '_text', $d['text'] ) )
		);

		++$shown;
	}

	return $markup;
}

/**
 * Registers the controls of both lists.
 *
 * Called from iflynepal_legal_register_customizer() inside customize_register.
 * The slot controls are all registered up front and the shared repeater hides
 * the unused ones behind an Add button; see assets/js/legal/customizer.js.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function iflynepal_sustainability_register_lists( $wp_customize ) {
	require_once IFLYNEPAL_DIR . '/inc/customizer/controls/class-ifly-nepal-customize-rich-text-control.php';

	$lists = array(
		array(
			'section'  => 'iflynepal_sustainability_legal_sections',
			'prefix'   => 'section',
			'max'      => IFLYNEPAL_SUSTAINABILITY_SECTION_MAX,
			'defaults' => iflynepal_sustainability_section_defaults(),
			'fields'   => array(
				'title'    => array( __( 'Title', 'iflynepal' ), 'text', 'iflynepal_kses_text' ),
				'subtitle' => array( __( 'Sub title', 'iflynepal' ), 'text', 'iflynepal_kses_text' ),
				'body'     => array( __( 'Body', 'iflynepal' ), 'rich', 'iflynepal_legal_sanitize_body' ),
			),
			'noun'     => __( 'Section', 'iflynepal' ),
		),
		array(
			'section'  => 'iflynepal_sustainability_legal_extra',
			'prefix'   => 'card',
			'max'      => IFLYNEPAL_SUSTAINABILITY_CARD_MAX,
			'defaults' => iflynepal_sustainability_card_defaults(),
			'fields'   => array(
				'title' => array( __( 'Title', 'iflynepal' ), 'text', 'iflynepal_kses_text' ),
				'icon'  => array( __( 'Icon', 'iflynepal' ), 'media', 'absint' ),
				'text'  => array( __( 'Text', 'iflynepal' ), 'rich-short', 'iflynepal_legal_sanitize_body' ),
			),
			'noun'     => __( 'Card', 'iflynepal' ),
		),
	);

	$priority = 1000;

	foreach ( $lists as $list ) {
		for ( $n = 1; $n <= $list['max']; $n++ ) {
			foreach ( $list['fields'] as $key => $meta ) {
				$id      = iflynepal_legal_mod_name( 'sustainability', $list['prefix'] . '_' . $n . '_' . $key );
				$default = isset( $list['defaults'][ $n ][ $key ] ) ? $list['defaults'][ $n ][ $key ] : ( 'media' === $meta[1] ? 0 : '' );
				$label   = sprintf( '%1$s %2$d: %3$s', $list['noun'], $n, $meta[0] );

				$wp_customize->add_setting(
					$id,
					array(
						'default'           => $default,
						'sanitize_callback' => $meta[2],
						'transport'         => 'refresh',
					)
				);

				if ( 'media' === $meta[1] ) {
					$wp_customize->add_control(
						new WP_Customize_Media_Control(
							$wp_customize,
							$id,
							array(
								'label'       => $label,
								'description' => __( 'Optional. PNG, JPG, SVG, WebP or GIF, ideally square. Leave empty to use the built-in icon.', 'iflynepal' ),
								'section'     => $list['section'],
								'priority'    => ++$priority,
								'mime_type'   => 'image',
							)
						)
					);
				} elseif ( 0 === strpos( $meta[1], 'rich' ) ) {
					$wp_customize->add_control(
						new IFly_Nepal_Customize_Rich_Text_Control(
							$wp_customize,
							$id,
							array(
								'label'    => $label,
								'section'  => $list['section'],
								'priority' => ++$priority,
								'rows'     => 'rich' === $meta[1] ? 10 : 4,
								'lists'    => 'rich' === $meta[1],
							)
						)
					);
				} else {
					$wp_customize->add_control(
						$id,
						array(
							'label'    => $label,
							'section'  => $list['section'],
							'priority' => ++$priority,
							'type'     => 'text',
						)
					);
				}
			}
		}
	}
}

/**
 * The two lists, described for assets/js/legal/customizer.js.
 *
 * @since 1.0.0
 *
 * @return array[] Lists with their setting patterns, anchor control and labels.
 */
function iflynepal_sustainability_list_config() {
	return array(
		array(
			'patterns'    => array(
				iflynepal_legal_mod_name( 'sustainability', 'section_%d_title' ),
				iflynepal_legal_mod_name( 'sustainability', 'section_%d_subtitle' ),
				iflynepal_legal_mod_name( 'sustainability', 'section_%d_body' ),
			),
			'max'         => IFLYNEPAL_SUSTAINABILITY_SECTION_MAX,
			'anchor'      => iflynepal_legal_mod_name( 'sustainability', 'index_title' ),
			'addLabel'    => __( 'Add a section', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of sections. */
				__( 'Maximum %d sections allowed.', 'iflynepal' ),
				IFLYNEPAL_SUSTAINABILITY_SECTION_MAX
			),
			/* translators: %d: section number. */
			'removeLabel' => __( 'Remove section %d', 'iflynepal' ),
		),
		array(
			'patterns'    => array(
				iflynepal_legal_mod_name( 'sustainability', 'card_%d_title' ),
				iflynepal_legal_mod_name( 'sustainability', 'card_%d_icon' ),
				iflynepal_legal_mod_name( 'sustainability', 'card_%d_text' ),
			),
			'max'         => IFLYNEPAL_SUSTAINABILITY_CARD_MAX,
			'anchor'      => iflynepal_legal_mod_name( 'sustainability', 'pledge_lead' ),
			'addLabel'    => __( 'Add a card', 'iflynepal' ),
			'maxMessage'  => sprintf(
				/* translators: %d: maximum number of cards. */
				__( 'Maximum %d cards allowed.', 'iflynepal' ),
				IFLYNEPAL_SUSTAINABILITY_CARD_MAX
			),
			/* translators: %d: card number. */
			'removeLabel' => __( 'Remove card %d', 'iflynepal' ),
		),
	);
}

/* ------------------------------------------------------------ SVG uploads */

/**
 * Lets administrators upload SVG icons to the Media Library.
 *
 * WordPress refuses SVG by default because a file can carry script. It is
 * allowed here for users who may already post unfiltered HTML, and every SVG is
 * checked on upload by iflynepal_legal_check_svg().
 *
 * @since 1.0.0
 *
 * @param array $mimes Allowed types.
 * @return array Allowed types.
 */
function iflynepal_legal_allow_svg( $mimes ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'iflynepal_legal_allow_svg' );

/**
 * Gives an SVG its type back after WordPress's content sniffing drops it.
 *
 * @since 1.0.0
 *
 * @param array  $data     File data.
 * @param string $file     Full path.
 * @param string $filename Name.
 * @return array File data.
 */
function iflynepal_legal_svg_filetype( $data, $file, $filename ) {
	if ( empty( $data['type'] ) && 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) && current_user_can( 'unfiltered_html' ) ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'iflynepal_legal_svg_filetype', 10, 3 );

/**
 * Rejects an SVG that contains script, event handlers or external references.
 *
 * @since 1.0.0
 *
 * @param array $file Upload being handled.
 * @return array The upload, with an error set when the SVG is unsafe.
 */
function iflynepal_legal_check_svg( $file ) {
	if ( 'svg' !== strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) || empty( $file['tmp_name'] ) ) {
		return $file;
	}

	$content = (string) file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local temp file.

	if ( preg_match( '/<\s*script|<\s*foreignObject|\son[a-z]+\s*=|javascript:|<!ENTITY|xlink:href\s*=\s*[\x22\x27]\s*https?:/i', $content ) ) {
		$file['error'] = __( 'This SVG contains script or external references and was rejected. Export a plain SVG and upload it again.', 'iflynepal' );
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'iflynepal_legal_check_svg' );
