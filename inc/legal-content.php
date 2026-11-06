<?php
/**
 * Legal pages: one engine for the Privacy, Terms, Cookie and Sustainability
 * pages, so every piece of their copy is editable in the Customizer.
 *
 * Each page keeps its *register* of clauses (anchor, default title, default
 * sub-title) in its own inc file, and its default copy in
 * inc/legal-defaults.php. Everything an editor can change is a theme mod named
 * `iflynepal_{page}_{field}`; a mod that was never saved falls back to the
 * default, so a site that touches nothing is unchanged and the shipped
 * translations still apply.
 *
 * A clause body is one textarea written in a small markup, one block per line:
 *
 *   plain line          paragraph
 *   - text              bullet (consecutive bullets form one list)
 *   # text              small bold sub-heading
 *   !icon text          highlighted note; icon is cookie, mail or leaf (default leaf)
 *   =tag left | right   table row; tag is warn, ok or empty
 *   @ title | text      card (up to three icons are used, in order)
 *   ~ name | url        browser link
 *   ✓ text              tick-list item
 *
 * Inline: <strong>, <em>, <br>, `[label](url)` for a link (a url starting with
 * `/` is relative to the site), and the tokens {site_url}, {site_host} and
 * {email} (the office email from Customizer > Footer).
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

require_once IFLYNEPAL_DIR . '/inc/legal-defaults.php';

/**
 * The legal pages this engine drives.
 *
 * @since 1.0.0
 *
 * @return string[] Page label keyed by page key.
 */
function iflynepal_legal_pages() {
	return array(
		'privacy'        => __( 'Privacy Policy', 'iflynepal' ),
		'terms'          => __( 'Terms and Conditions', 'iflynepal' ),
		'cookie'         => __( 'Cookie Policy', 'iflynepal' ),
		'sustainability' => __( 'Sustainability Policy', 'iflynepal' ),
	);
}

/**
 * A page's clause register.
 *
 * @since 1.0.0
 *
 * @param string $page Page key.
 * @return array[] Clauses keyed by anchor, each with 'title' and 'note'.
 */
function iflynepal_legal_clauses( $page ) {
	$callback = 'iflynepal_' . $page . '_clauses';

	return function_exists( $callback ) ? (array) $callback() : array();
}

/**
 * The default body of a clause, as mini-markup.
 *
 * @since 1.0.0
 *
 * @param string $page   Page key.
 * @param string $anchor Clause anchor.
 * @return string Markup lines joined by newlines.
 */
function iflynepal_legal_body_default( $page, $anchor ) {
	$callback = 'iflynepal_' . $page . '_clause_body_defaults';

	if ( ! function_exists( $callback ) ) {
		return '';
	}

	$all = $callback();

	return isset( $all[ $anchor ] ) ? implode( "\n", $all[ $anchor ] ) : '';
}

/**
 * The theme-mod name of one field.
 *
 * @since 1.0.0
 *
 * @param string $page  Page key.
 * @param string $field Field key; hyphens become underscores.
 * @return string Theme-mod name.
 */
function iflynepal_legal_mod_name( $page, $field ) {
	return 'iflynepal_' . $page . '_' . str_replace( '-', '_', $field );
}

/**
 * One field's value: what was saved, else the default.
 *
 * A saved value goes through Polylang when it is active, as the Terms closing
 * card does; the default is already translated where it was built.
 *
 * @since 1.0.0
 *
 * @param string $page    Page key.
 * @param string $field   Field key.
 * @param string $default Default, already translated.
 * @return string Value.
 */
function iflynepal_legal_value( $page, $field, $default ) {
	$value = get_theme_mod( iflynepal_legal_mod_name( $page, $field ), null );

	if ( null === $value ) {
		return (string) $default;
	}

	if ( function_exists( 'pll__' ) ) {
		$value = pll__( $value );
	}

	return (string) $value;
}

/**
 * A page-heading field (hero headline, hero pill, heading, lead, index title).
 *
 * @since 1.0.0
 *
 * @param string $page  Page key.
 * @param string $field One of hero_title, hero_pill, head_kicker, head_title, head_lead, index_title.
 * @return string Value, as safe HTML.
 */
function iflynepal_legal_head( $page, $field ) {
	$defaults = iflynepal_legal_head_defaults( $page );
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return iflynepal_kses_text( iflynepal_legal_value( $page, $field, $default ) );
}

/**
 * A field of the extra block (cookie types, sustainability promises).
 *
 * @since 1.0.0
 *
 * @param string $page  Page key.
 * @param string $field kicker, title, lead or cards.
 * @param string $kind  'text' for safe HTML, 'raw' for the unprocessed value.
 * @return string Value.
 */
function iflynepal_legal_extra( $page, $field, $kind = 'text' ) {
	$defaults = iflynepal_legal_extra_defaults( $page );
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';
	$prefix   = 'cookie' === $page ? 'types' : 'pledge';
	$value    = iflynepal_legal_value( $page, $prefix . '_' . $field, $default );

	return 'raw' === $kind ? $value : iflynepal_kses_text( $value );
}

/**
 * A clause's title, sub-title or body.
 *
 * @since 1.0.0
 *
 * @param string $page   Page key.
 * @param string $anchor Clause anchor.
 * @param string $field  title, note or body.
 * @return string Raw value; escape or parse it at output.
 */
function iflynepal_legal_clause_value( $page, $anchor, $field ) {
	$clauses = iflynepal_legal_clauses( $page );

	if ( 'body' === $field ) {
		$default = iflynepal_legal_body_default( $page, $anchor );
	} else {
		$default = isset( $clauses[ $anchor ][ $field ] ) ? $clauses[ $anchor ][ $field ] : '';
	}

	return iflynepal_legal_value( $page, 'clause_' . $anchor . '_' . $field, $default );
}

/**
 * One clause's position in its page's register, counting from one.
 *
 * @since 1.0.0
 *
 * @param string $page   Page key.
 * @param string $anchor Clause anchor.
 * @return int Its number, or 0 when the anchor is not registered.
 */
function iflynepal_legal_clause_number( $page, $anchor ) {
	$position = array_search( $anchor, array_keys( iflynepal_legal_clauses( $page ) ), true );

	return false === $position ? 0 : (int) $position + 1;
}

/* ---------------------------------------------------------------- renderers */

/**
 * Renders the "On this page" index.
 *
 * No `href` — the active mark and the glide are added by
 * assets/js/legal/index.js.
 *
 * @since 1.0.0
 *
 * @param string $page Page key.
 * @return string Markup.
 */
function iflynepal_render_legal_index( $page ) {
	$markup = '';

	foreach ( array_keys( iflynepal_legal_clauses( $page ) ) as $anchor ) {
		$markup .= sprintf(
			'<a class="iflynepal-legal-index__link" %1$s>%2$s</a>',
			iflynepal_anchor_attr( '#' . $anchor ),
			esc_html( wp_strip_all_tags( iflynepal_legal_clause_value( $page, $anchor, 'title' ) ) )
		);
	}

	return $markup;
}

/**
 * Renders one clause's heading: number, title and the line under it.
 *
 * The number is zero-padded to two digits and hidden from assistive
 * technology — it is a visual index mark.
 *
 * @since 1.0.0
 *
 * @param string $page   Page key.
 * @param string $anchor Clause anchor.
 * @return string Markup, or an empty string for an unregistered anchor.
 */
function iflynepal_render_legal_clause_head( $page, $anchor ) {
	if ( ! isset( iflynepal_legal_clauses( $page )[ $anchor ] ) ) {
		return '';
	}

	return sprintf(
		'<div class="iflynepal-legal-clause__head">
			<span class="iflynepal-legal-clause__num" aria-hidden="true">%1$s</span>
			<div>
				<h3 class="wp-block-heading iflynepal-legal-clause__title" id="%2$s-title">%3$s</h3>
				<small class="iflynepal-legal-clause__note">%4$s</small>
			</div>
		</div>',
		esc_html( str_pad( (string) iflynepal_legal_clause_number( $page, $anchor ), 2, '0', STR_PAD_LEFT ) ),
		esc_attr( $anchor ),
		esc_html( wp_strip_all_tags( iflynepal_legal_clause_value( $page, $anchor, 'title' ) ) ),
		esc_html( wp_strip_all_tags( iflynepal_legal_clause_value( $page, $anchor, 'note' ) ) )
	);
}

/**
 * Resolves the tokens and `[label](url)` links in one line.
 *
 * @since 1.0.0
 *
 * @param string $text One line of mini-markup, without its marker.
 * @return string Safe HTML.
 */
function iflynepal_legal_inline( $text ) {
	$email = sanitize_email( iflynepal_footer_office_field( 'email' ) );

	if ( ! $email ) {
		$email = 'contact@iflynepal.com';
	}

	$text = strtr(
		$text,
		array(
			'{site_url}'  => esc_url( home_url( '/' ) ),
			'{site_host}' => esc_html( untrailingslashit( home_url() ) ),
			'{email}'     => esc_html( $email ),
		)
	);

	$text = preg_replace_callback(
		'/\[([^\]]+)\]\(([^)\s]+)\)/',
		static function ( $match ) {
			$url = '/' === substr( $match[2], 0, 1 ) ? home_url( $match[2] ) : $match[2];

			return '<a href="' . esc_url( $url ) . '">' . $match[1] . '</a>';
		},
		$text
	);

	return wp_kses_post( $text );
}

/**
 * The inline icons a note can carry.
 *
 * @since 1.0.0
 *
 * @return string[] SVG inner markup keyed by icon name.
 */
function iflynepal_legal_note_icons() {
	return array(
		'cookie' => '<circle cx="12" cy="12" r="9"/><path d="M9 9h.01M15 10h.01M10.5 14.5h.01M14.5 15h.01"/>',
		'mail'   => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'leaf'   => '<path d="M12 21c-4.5-2.5-7-6-7-10a7 7 0 0 1 14 0c0 4-2.5 7.5-7 10z"/><path d="M9 13l3-2 3 2"/>',
	);
}

/**
 * The icons the cards cycle through, in order.
 *
 * @since 1.0.0
 *
 * @return string[] SVG inner markup.
 */
function iflynepal_legal_card_icons() {
	return array(
		'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/>',
		'<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
		'<path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>',
	);
}

/**
 * The logo file for a browser name.
 *
 * @since 1.0.0
 *
 * @param string $name Browser name as written.
 * @return string File under assets/images/policy/browsers, or '' for an unknown browser.
 */
function iflynepal_legal_browser_icon( $name ) {
	$map = array(
		'chrome'  => 'googlechrome.svg',
		'firefox' => 'firefoxbrowser.svg',
		'safari'  => 'safari.svg',
		'edge'    => 'microsoftedge.svg',
	);

	foreach ( $map as $needle => $file ) {
		if ( false !== stripos( $name, $needle ) ) {
			return $file;
		}
	}

	return '';
}

/**
 * Splits a body into typed lines.
 *
 * @since 1.0.0
 *
 * @param string $raw Body as saved.
 * @return array[] Each with 'type' and 'text'; 'tag' for rows and notes.
 */
function iflynepal_legal_parse( $raw ) {
	$blocks = array();

	foreach ( preg_split( '/\R/', (string) $raw ) as $line ) {
		$line = trim( $line );

		if ( '' === $line ) {
			continue;
		}

		if ( preg_match( '/^!([a-z]+)?\s+(.*)$/', $line, $m ) ) {
			$blocks[] = array(
				'type' => 'note',
				'tag'  => $m[1],
				'text' => $m[2],
			);
		} elseif ( preg_match( '/^=([a-z]+)?\s+(.*)$/', $line, $m ) ) {
			$blocks[] = array(
				'type' => 'row',
				'tag'  => $m[1],
				'text' => $m[2],
			);
		} elseif ( preg_match( '/^@(!)?\s+(.*)$/', $line, $m ) ) {
			$blocks[] = array(
				'type' => 'card',
				'tag'  => $m[1] ? 'required' : '',
				'text' => $m[2],
			);
		} elseif ( preg_match( '/^(-|#|~|✓)\s+(.*)$/u', $line, $m ) ) {
			$types    = array(
				'-' => 'li',
				'#' => 'sub',
				'~' => 'browser',
				'✓' => 'tick',
			);
			$blocks[] = array(
				'type' => $types[ $m[1] ],
				'tag'  => '',
				'text' => $m[2],
			);
		} else {
			$blocks[] = array(
				'type' => 'p',
				'tag'  => '',
				'text' => $line,
			);
		}
	}

	return $blocks;
}

/**
 * Renders one clause's body.
 *
 * @since 1.0.0
 *
 * @param string $page   Page key.
 * @param string $anchor Clause anchor.
 * @return string Markup.
 */
function iflynepal_render_legal_body( $page, $anchor ) {
	$blocks = iflynepal_legal_parse( iflynepal_legal_clause_value( $page, $anchor, 'body' ) );
	$out    = '';
	$count  = count( $blocks );
	$prev   = '';
	$icons  = iflynepal_legal_note_icons();
	$cards  = iflynepal_legal_card_icons();
	$svg    = array(
		'path' => array( 'd' => true ),
	);

	for ( $i = 0; $i < $count; $i++ ) {
		$block = $blocks[ $i ];
		$type  = $block['type'];

		// Group consecutive lines of one kind into a single container.
		$group = array( $block );

		if ( in_array( $type, array( 'li', 'row', 'card', 'browser', 'tick' ), true ) ) {
			while ( isset( $blocks[ $i + 1 ] ) && $blocks[ $i + 1 ]['type'] === $type ) {
				$group[] = $blocks[ ++$i ];
			}
		}

		switch ( $type ) {
			case 'sub':
				$out .= '<span class="iflynepal-legal-sublabel">' . iflynepal_legal_inline( $block['text'] ) . '</span>';
				break;

			case 'p':
				$out .= '<p>' . iflynepal_legal_inline( $block['text'] ) . '</p>';
				break;

			case 'li':
				$spaced = in_array( $prev, array( 'p', 'row' ), true ) ? ' iflynepal-legal-rules--spaced' : '';
				$out   .= '<ul class="iflynepal-legal-rules' . $spaced . '">';
				foreach ( $group as $item ) {
					$out .= '<li>' . iflynepal_legal_inline( $item['text'] ) . '</li>';
				}
				$out .= '</ul>';
				break;

			case 'note':
				$name = isset( $icons[ $block['tag'] ] ) ? $block['tag'] : 'leaf';
				$out .= '<p class="iflynepal-legal-note"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">'
					. wp_kses( $icons[ $name ], array_merge( $svg, array( 'circle' => array( 'cx' => true, 'cy' => true, 'r' => true ), 'rect' => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true ) ) ) )
					. '</svg><span>' . iflynepal_legal_inline( $block['text'] ) . '</span></p>';
				break;

			case 'row':
				$out .= '<div class="iflynepal-legal-refunds">';
				foreach ( $group as $row ) {
					$parts = array_map( 'trim', explode( '|', $row['text'], 2 ) );
					$mod   = in_array( $row['tag'], array( 'warn', 'ok' ), true ) ? ' iflynepal-legal-refunds__row--' . $row['tag'] : '';
					$out  .= '<div class="iflynepal-legal-refunds__row' . $mod . '"><span>' . iflynepal_legal_inline( $parts[0] ) . '</span><b>'
						. iflynepal_legal_inline( isset( $parts[1] ) ? $parts[1] : '' ) . '</b></div>';
				}
				$out .= '</div>';
				break;

			case 'card':
				$out .= '<div class="iflynepal-privacy-rights">';
				foreach ( $group as $n => $card ) {
					$parts = array_map( 'trim', explode( '|', $card['text'], 2 ) );
					$out  .= sprintf(
						'<div class="iflynepal-privacy-right">
							<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%1$s</svg>
							<h4 class="wp-block-heading iflynepal-privacy-right__title">%2$s</h4>
							<p class="iflynepal-privacy-right__text">%3$s</p>
						</div>',
						wp_kses( $cards[ $n % count( $cards ) ], $svg ),
						iflynepal_legal_inline( $parts[0] ),
						iflynepal_legal_inline( isset( $parts[1] ) ? $parts[1] : '' )
					);
				}
				$out .= '</div>';
				break;

			case 'browser':
				$out .= '<div class="iflynepal-cookie-browsers">';
				foreach ( $group as $browser ) {
					$parts = array_map( 'trim', explode( '|', $browser['text'], 2 ) );
					$icon  = iflynepal_legal_browser_icon( $parts[0] );
					$out  .= sprintf(
						'<a class="iflynepal-cookie-browser" href="%1$s" target="_blank" rel="noopener">%2$s<span>%3$s</span><svg class="iflynepal-ico iflynepal-cookie-browser__arrow" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M8 7h9v9"/></svg></a>',
						esc_url( isset( $parts[1] ) ? $parts[1] : '' ),
						$icon ? '<img src="' . esc_url( IFLYNEPAL_URI . '/assets/images/policy/browsers/' . $icon ) . '" alt="" width="22" height="22" loading="lazy" decoding="async">' : '',
						esc_html( wp_strip_all_tags( $parts[0] ) )
					);
				}
				$out .= '</div>';
				break;

			case 'tick':
				$out .= '<ul class="iflynepal-sustain-frameworks">';
				foreach ( $group as $item ) {
					$out .= '<li class="iflynepal-sustain-framework"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20 6 9 17l-5-5"/></svg><span>'
						. iflynepal_legal_inline( $item['text'] ) . '</span></li>';
				}
				$out .= '</ul>';
				break;
		}

		$prev = 'row' === $type ? 'row' : $type;
	}

	return $out;
}

/**
 * Renders the cookie-type or promise cards.
 *
 * @since 1.0.0
 *
 * @param string $page Page key: 'cookie' or 'sustainability'.
 * @return string Markup.
 */
function iflynepal_render_legal_extra_cards( $page ) {
	$out   = '';
	$n     = 0;
	$icons = array(
		'cookie'         => array(
			'<rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
			'<path d="M3 3v18h18"/><path d="m7 15 4-5 3 3 5-7"/>',
			'<path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3"/><path d="M1 14h6M9 8h6M17 16h6"/>',
			'<path d="M3 11v3a1 1 0 0 0 1 1h3l4 4V6L7 10H4a1 1 0 0 0-1 1z"/><path d="M16 9a4 4 0 0 1 0 6"/>',
		),
	);
	$kses  = array(
		'path'   => array( 'd' => true ),
		'rect'   => array(
			'x'      => true,
			'y'      => true,
			'width'  => true,
			'height' => true,
			'rx'     => true,
		),
		'circle' => array(
			'cx' => true,
			'cy' => true,
			'r'  => true,
		),
	);

	if ( ! isset( $icons[ $page ] ) ) {
		return '';
	}

	foreach ( iflynepal_legal_parse( iflynepal_legal_extra( $page, 'cards', 'raw' ) ) as $line ) {
		if ( 'card' !== $line['type'] ) {
			continue;
		}

		$icon = wp_kses( $icons[ $page ][ $n % count( $icons[ $page ] ) ], $kses );
		++$n;

		if ( 'cookie' === $page ) {
			$parts = array_pad( array_map( 'trim', explode( '|', $line['text'], 4 ) ), 4, '' );
			$out  .= sprintf(
				'<article class="iflynepal-cookie-type" data-iflynepal-reveal>
					<div class="iflynepal-cookie-type__icon" aria-hidden="true"><svg class="iflynepal-ico" viewBox="0 0 24 24" focusable="false">%1$s</svg></div>
					<small class="iflynepal-cookie-type__eyebrow">%2$s</small>
					<h3 class="wp-block-heading iflynepal-cookie-type__title">%3$s</h3>
					<p class="iflynepal-cookie-type__text">%4$s</p>
					<span class="iflynepal-cookie-type__tag%5$s">%6$s</span>
				</article>',
				$icon,
				iflynepal_legal_inline( $parts[0] ),
				iflynepal_legal_inline( $parts[1] ),
				iflynepal_legal_inline( $parts[2] ),
				'required' === $line['tag'] ? ' iflynepal-cookie-type__tag--required' : '',
				iflynepal_legal_inline( $parts[3] )
			);
		}
	}

	return $out;
}

/* -------------------------------------------------------------- Polylang */

/**
 * Registers every saved legal string with Polylang, so each can be translated.
 *
 * Only values that were actually saved are registered — an untouched field is
 * translated through the theme's own .po files.
 *
 * @since 1.0.0
 */
function iflynepal_legal_register_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	foreach ( array_keys( iflynepal_legal_pages() ) as $page ) {
		foreach ( iflynepal_legal_customizer_fields( $page ) as $field ) {
			$value = get_theme_mod( iflynepal_legal_mod_name( $page, $field['key'] ), null );

			if ( is_string( $value ) && '' !== $value ) {
				pll_register_string( $page . ' ' . $field['key'], $value, 'iFly Nepal: legal pages', 'body' === $field['kind'] || 'cards' === $field['kind'] );
			}
		}
	}
}
add_action( 'init', 'iflynepal_legal_register_strings', 20 );

/**
 * Registers the saved Sustainability list items with Polylang.
 *
 * @since 1.0.0
 */
function iflynepal_legal_register_list_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$names = array();

	for ( $n = 1; $n <= IFLYNEPAL_SUSTAINABILITY_SECTION_MAX; $n++ ) {
		foreach ( array( 'title', 'subtitle', 'body' ) as $key ) {
			$names[] = 'section_' . $n . '_' . $key;
		}
	}

	for ( $n = 1; $n <= IFLYNEPAL_SUSTAINABILITY_CARD_MAX; $n++ ) {
		foreach ( array( 'title', 'text' ) as $key ) {
			$names[] = 'card_' . $n . '_' . $key;
		}
	}

	foreach ( $names as $name ) {
		$value = get_theme_mod( iflynepal_legal_mod_name( 'sustainability', $name ), null );

		if ( is_string( $value ) && '' !== $value ) {
			pll_register_string( 'sustainability ' . $name, $value, 'iFly Nepal: legal pages', false !== strpos( $name, 'body' ) );
		}
	}
}
add_action( 'init', 'iflynepal_legal_register_list_strings', 20 );

/* ------------------------------------------------------------- Customizer */

/**
 * Sanitizes a body textarea: the inline tags the renderer allows, nothing else.
 *
 * `wp_kses_post()` keeps newlines and the markers; the markers `-`, `#`, `!`,
 * `=`, `@`, `~` and `✓` are plain text to it.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string Sanitized value.
 */
function iflynepal_legal_sanitize_body( $value ) {
	return wp_kses_post( (string) $value );
}

/**
 * Every Customizer field of a page, in display order.
 *
 * @since 1.0.0
 *
 * @param string $page Page key.
 * @return array[] Each with 'key', 'kind' (line, text, body, cards), 'label', 'section' and 'default'.
 */
function iflynepal_legal_customizer_fields( $page ) {
	$fields = array();
	$head   = iflynepal_legal_head_defaults( $page );
	$extra  = iflynepal_legal_extra_defaults( $page );

	$heading = array(
		'hero_title'  => array( __( 'Hero headline', 'iflynepal' ), 'line' ),
		'hero_pill'   => array( __( 'Hero button label', 'iflynepal' ), 'line' ),
		'head_kicker' => array( __( 'Kicker above the heading', 'iflynepal' ), 'line' ),
		'head_title'  => array( __( 'Heading', 'iflynepal' ), 'line' ),
		'head_lead'   => array( __( 'Introduction', 'iflynepal' ), 'text' ),
		'index_title' => array( __( 'Index title', 'iflynepal' ), 'line' ),
	);

	foreach ( $heading as $key => $meta ) {
		$fields[] = array(
			'key'     => $key,
			'kind'    => $meta[1],
			'label'   => $meta[0],
			'section' => ( 'sustainability' === $page && 'index_title' === $key ) ? 'sections' : 'heading',
			'default' => isset( $head[ $key ] ) ? $head[ $key ] : '',
		);
	}

	if ( $extra ) {
		$prefix = 'cookie' === $page ? 'types' : 'pledge';
		$names  = array(
			'kicker' => array( __( 'Kicker', 'iflynepal' ), 'line' ),
			'title'  => array( __( 'Heading', 'iflynepal' ), 'line' ),
			'lead'   => array( __( 'Introduction', 'iflynepal' ), 'text' ),
			'cards'  => array( __( 'Cards', 'iflynepal' ), 'cards' ),
		);

		foreach ( $names as $key => $meta ) {
			// The Sustainability cards are an add/remove list; see inc/legal-sections.php.
			if ( 'sustainability' === $page && 'cards' === $key ) {
				continue;
			}

			$fields[] = array(
				'key'     => $prefix . '_' . $key,
				'kind'    => $meta[1],
				'label'   => $meta[0],
				'section' => 'extra',
				'default' => $extra[ $key ],
			);
		}
	}

	// The Sustainability clauses are an add/remove list too, so they have no fixed fields.
	foreach ( 'sustainability' === $page ? array() : iflynepal_legal_clauses( $page ) as $anchor => $clause ) {
		$fields[] = array(
			'key'     => 'clause_' . str_replace( '-', '_', $anchor ) . '_title',
			'kind'    => 'line',
			'label'   => __( 'Title', 'iflynepal' ),
			'section' => $anchor,
			'default' => $clause['title'],
		);
		$fields[] = array(
			'key'     => 'clause_' . str_replace( '-', '_', $anchor ) . '_note',
			'kind'    => 'line',
			'label'   => __( 'Line under the title', 'iflynepal' ),
			'section' => $anchor,
			'default' => $clause['note'],
		);
		$fields[] = array(
			'key'     => 'clause_' . str_replace( '-', '_', $anchor ) . '_body',
			'kind'    => 'body',
			'label'   => __( 'Content', 'iflynepal' ),
			'section' => $anchor,
			'default' => iflynepal_legal_body_default( $page, $anchor ),
		);
	}

	return $fields;
}

/**
 * Registers the Customizer sections and controls of all four legal pages.
 *
 * Called from inc/customizer/customizer.php inside customize_register. The
 * hero photograph, the Terms closing card and the Sustainability Coordinator
 * keep their own sections; everything else is registered here from one list.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function iflynepal_legal_register_customizer( $wp_customize ) {
	$syntax = __( 'One block per line. Plain line = paragraph. "- " bullet. "# " small heading. "!leaf " (or !cookie, !mail) highlighted note. "=warn left | right" (or =ok, or = alone) table row. "@ title | text" card. "~ name | url" browser link. Inline: <strong>, <em>, [label](url), {email}, {site_url}.', 'iflynepal' );
	$count  = 0;

	foreach ( array_keys( iflynepal_legal_pages() ) as $page ) {
		$panel    = 'iflynepal_' . $page;
		$clauses  = iflynepal_legal_clauses( $page );
		$sections = array(
			'heading' => array( __( 'Headings & introduction', 'iflynepal' ), 15 ),
			'extra'   => array( 'cookie' === $page ? __( 'Cookie types', 'iflynepal' ) : __( 'Our commitment', 'iflynepal' ), 16 ),
			'sections' => array( __( 'On this page', 'iflynepal' ), 17 ),
		);
		$n        = 0;

		foreach ( 'sustainability' === $page ? array() : $clauses as $anchor => $clause ) {
			++$n;
			$sections[ $anchor ] = array(
				sprintf( '%02d · %s', $n, wp_strip_all_tags( $clause['title'] ) ),
				100 + $n,
			);
		}

		$used = array();

		foreach ( iflynepal_legal_customizer_fields( $page ) as $field ) {
			$used[ $field['section'] ] = true;
		}

		foreach ( $sections as $slug => $meta ) {
			if ( empty( $used[ $slug ] ) ) {
				continue;
			}

			$wp_customize->add_section(
				'iflynepal_' . $page . '_legal_' . str_replace( '-', '_', $slug ),
				array(
					'title'       => $meta[0],
					'description' => 'sections' === $slug
						? __( 'Each section appears as a link in the index on the left and as a card on the right, in this order. Use "Add a section" for up to 20; the formatting buttons above the body add bold, italic, links and lists. Blank line = new paragraph. The Sustainability Coordinator card follows section 6.', 'iflynepal' )
						: ( 'sustainability' === $page && 'extra' === $slug
							? __( 'The heading and intro above the promise cards, then the cards themselves. Use "Add a card" for up to 20; the buttons add bold, italic and links to the text of a card.', 'iflynepal' )
							: ( in_array( $slug, array( 'heading', 'extra' ), true )
						? __( 'Wrap a word in <em>word</em> or <span class="underline">word</span> for the accent. Leave a field exactly as it is to keep the original wording and its translations.', 'iflynepal' )
						: __( 'The clause as it appears on the page. Edit the content in the box below; the format is explained under it.', 'iflynepal' ) ) ),
					'panel'       => $panel,
					'priority'    => $meta[1],
				)
			);
		}

		foreach ( iflynepal_legal_customizer_fields( $page ) as $field ) {
			$id      = iflynepal_legal_mod_name( $page, $field['key'] );
			$body    = in_array( $field['kind'], array( 'body', 'cards' ), true );
			$section = 'iflynepal_' . $page . '_legal_' . str_replace( '-', '_', $field['section'] );

			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $field['default'],
					'sanitize_callback' => $body ? 'iflynepal_legal_sanitize_body' : 'iflynepal_kses_text',
					'transport'         => 'refresh',
				)
			);

			$args = array(
				'label'    => $field['label'],
				'section'  => $section,
				'priority' => ++$count,
				'type'     => 'line' === $field['kind'] ? 'text' : 'textarea',
			);

			if ( $body ) {
				$args['input_attrs'] = array( 'rows' => 'body' === $field['kind'] ? 12 : 8 );
				$args['description'] = 'cards' === $field['kind']
					? ( 'cookie' === $page
						? __( 'One card per line: "@ eyebrow | title | text | tag". Use "@!" instead of "@" for the always-on card.', 'iflynepal' )
						: __( 'One card per line: "@ title | text".', 'iflynepal' ) )
					: $syntax;
			}

			$wp_customize->add_control( $id, $args );
		}
	}

	iflynepal_sustainability_register_lists( $wp_customize );
}

require_once IFLYNEPAL_DIR . '/inc/legal-sections.php';
