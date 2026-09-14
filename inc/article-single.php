<?php
/**
 * A single article: the pieces the design's single template needs.
 *
 * The reading time, the table of contents, the share links, the related row,
 * and the pass over the rendered content that gives core's blocks the class
 * names the design's stylesheet is written against.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Words a minute, for the "N min read" line.
 *
 * 200 is the figure the design's copy was written to and the one most reading
 * estimates settle on for prose of this kind.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLE_WPM = 200;

/**
 * How many articles the "From the articles" row holds.
 *
 * Four, in two rows of two, as the design draws it.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_ARTICLE_RELATED = 4;

/* ------------------------------------------------------------ the content */

/**
 * The rendered content, plus the hooks the single template reads off it.
 *
 * Run once per article and cached, because three things need it: the body
 * itself, the table of contents in the sidebar, and the copy of that index
 * that sits above the post on a narrow screen. Rendering the content three
 * times to answer the same question would run every block filter three times.
 *
 * The pass does four things, all of them class and id work the design's
 * stylesheet assumes an editor has done by hand:
 *
 *   - every h2 and h3 is given an id, so the index can link to it;
 *   - the first paragraph becomes the standfirst with the dropped capital;
 *   - core's quote and image blocks pick up the design's names;
 *   - a run of core Details blocks is wrapped as the FAQ list.
 *
 * The design's remaining classes — `post-pick` on a recommendation — stay the
 * editor's to apply: there is no shape in the markup that tells one apart from
 * an ordinary paragraph that happens to open in bold.
 *
 * A post whose editor has already applied those classes keeps them: each step
 * adds rather than replaces, and skips an element that already carries the
 * class.
 *
 * News stories run through the same pass — the two designs share a body
 * stylesheet — and ask for the two differences their design draws through
 * $args: the standfirst carries `news-lede` as well, and it opens with the
 * dateline in small capitals rather than with a dropped capital.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Post to read. Defaults to the one in the loop.
 * @param array    $args {
 *     Optional. How the standfirst is dressed.
 *
 *     @type string $lede_class Extra class for the first paragraph. Default ''.
 *     @type string $dateline   Place to open the first paragraph with. Default ''.
 * }
 * @return array{html:string,headings:array<int,array{id:string,text:string}>} Body and index.
 */
function iflynepal_article_body( $post_id = null, $args = array() ) {
	static $cache = array();

	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	$args    = wp_parse_args(
		$args,
		array(
			'lede_class' => '',
			'dateline'   => '',
		)
	);
	$key     = $post_id . '|' . $args['lede_class'] . '|' . $args['dateline'];

	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core's filter, applied rather than declared.
	$html = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
	$html = str_replace( ']]>', ']]&gt;', $html );

	$result = array(
		'html'     => $html,
		'headings' => array(),
	);

	if ( '' === trim( wp_strip_all_tags( $html ) ) || ! class_exists( 'DOMDocument' ) ) {
		$cache[ $key ] = $result;

		return $result;
	}

	$document = new DOMDocument();
	$previous = libxml_use_internal_errors( true );

	/*
	 * The content is a fragment, not a document, and it is UTF-8. The XML
	 * declaration is what tells libxml the encoding without it mangling
	 * multi-byte characters; the html/body wrapper it then adds is stripped
	 * back off below.
	 */
	$document->loadHTML(
		'<?xml encoding="UTF-8"?><html><body>' . $html . '</body></html>',
		LIBXML_HTML_NODEFDTD
	);

	libxml_clear_errors();
	libxml_use_internal_errors( $previous );

	$xpath = new DOMXPath( $document );
	$used  = array();

	/* ------------------------------------------------------------- headings */

	foreach ( $xpath->query( '//h2 | //h3' ) as $heading ) {
		$text = trim( $heading->textContent ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.

		if ( '' === $text ) {
			continue;
		}

		$id = $heading->getAttribute( 'id' );

		if ( '' === $id ) {
			$id   = sanitize_title( $text );
			$id   = '' === $id ? 'section' : $id;
			$stem = $id;
			$n    = 2;

			while ( isset( $used[ $id ] ) ) {
				$id = $stem . '-' . $n;
				++$n;
			}

			$heading->setAttribute( 'id', $id );
		}

		$used[ $id ] = true;

		// Only the h2s carry the index; h3s are months and sub-points inside one.
		if ( 'h2' === $heading->nodeName ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.
			$result['headings'][] = array(
				'id'   => $id,
				'text' => $text,
			);
		}
	}

	/* ----------------------------------------------------------- the classes */

	$first = $xpath->query( '//body/p' )->item( 0 );

	if ( $first ) {
		iflynepal_article_add_class( $first, 'post-lede' );

		if ( '' !== $args['lede_class'] ) {
			iflynepal_article_add_class( $first, $args['lede_class'] );
		}

		/*
		 * The dateline is the story's own, not the editor's — it is set in the
		 * sidebar and prints in the details row too — so it is put at the head
		 * of the standfirst here rather than typed into the paragraph. A
		 * standfirst that already opens with one is left alone, which is what
		 * lets an editor override the placement by hand.
		 */
		if ( '' !== $args['dateline'] && ! iflynepal_article_has_dateline( $first ) ) {
			$dateline = $document->createElement( 'span' );
			$dateline->setAttribute( 'class', 'dateline' );
			$dateline->appendChild( $document->createTextNode( $args['dateline'] ) );

			$first->insertBefore( $document->createTextNode( ' ' ), $first->firstChild ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.
			$first->insertBefore( $dateline, $first->firstChild ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.
		}
	}

	foreach ( $xpath->query( '//blockquote' ) as $quote ) {
		iflynepal_article_add_class( $quote, 'post-quote' );
	}

	foreach ( $xpath->query( '//figure[img]' ) as $figure ) {
		iflynepal_article_add_class( $figure, 'post-figure' );
	}

	/* --------------------------------------------------------------- the FAQs */

	$details = $xpath->query( '//body/details' );

	if ( $details->length ) {
		$wrapper = $document->createElement( 'div' );
		$wrapper->setAttribute( 'class', 'post-faqs' );
		$details->item( 0 )->parentNode->insertBefore( $wrapper, $details->item( 0 ) ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.

		foreach ( $details as $item ) {
			$wrapper->appendChild( $item );
		}
	}

	/* --------------------------------------------------------------- back out */

	$body = $document->getElementsByTagName( 'body' )->item( 0 );
	$out  = '';

	foreach ( $body->childNodes as $child ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMNode's own property name.
		$out .= $document->saveHTML( $child );
	}

	$result['html'] = $out;
	$cache[ $key ]  = $result;

	return $result;
}

/**
 * Whether a standfirst already opens with a dateline.
 *
 * @since 1.0.0
 *
 * @param DOMElement $paragraph The first paragraph.
 * @return bool
 */
function iflynepal_article_has_dateline( $paragraph ) {
	foreach ( $paragraph->getElementsByTagName( 'span' ) as $span ) {
		$classes = preg_split( '/\s+/', trim( $span->getAttribute( 'class' ) ), -1, PREG_SPLIT_NO_EMPTY );

		if ( in_array( 'dateline', $classes, true ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Adds a class to an element without disturbing the ones it has.
 *
 * @since 1.0.0
 *
 * @param DOMElement $element   Element to mark.
 * @param string     $new_class Class to add.
 * @return void
 */
function iflynepal_article_add_class( $element, $new_class ) {
	$classes = preg_split( '/\s+/', trim( $element->getAttribute( 'class' ) ), -1, PREG_SPLIT_NO_EMPTY );

	if ( in_array( $new_class, $classes, true ) ) {
		return;
	}

	$classes[] = $new_class;

	$element->setAttribute( 'class', implode( ' ', $classes ) );
}

/**
 * How long the article takes to read, in whole minutes.
 *
 * Never less than one: "0 min read" is not an answer.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Post. Defaults to the one in the loop.
 * @param array    $args    Body arguments; see iflynepal_article_body(). Pass the
 *                          same ones the page renders with, so the content is
 *                          rendered once rather than twice.
 * @return int Minutes.
 */
function iflynepal_article_read_minutes( $post_id = null, $args = array() ) {
	$body  = iflynepal_article_body( $post_id, $args );
	$words = str_word_count( wp_strip_all_tags( $body['html'] ) );

	return max( 1, (int) ceil( $words / IFLYNEPAL_ARTICLE_WPM ) );
}

/**
 * A title, split into the spans the hero's entrance staggers.
 *
 * Every word is wrapped in `.w`, which is what the design's markup has and
 * what the motion script tweens. An `<em>` in the title is left whole and
 * becomes the gold accent word — the one piece of the headline an editor can
 * shape, and the only tag kept: everything else is escaped away.
 *
 * @since 1.0.0
 *
 * @param string $title Post title, as WordPress returns it.
 * @return string Finished, escaped markup.
 */
function iflynepal_article_headline( $title ) {
	$title = trim( wp_kses( $title, array( 'em' => array() ) ) );

	if ( '' === $title ) {
		return '';
	}

	// Split on the accent, keeping it, so the two sides can be worded separately.
	$chunks = preg_split( '#(<em>.*?</em>)#i', $title, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
	$out    = array();

	foreach ( $chunks as $chunk ) {
		if ( preg_match( '#^<em>#i', $chunk ) ) {
			$out[] = '<em>' . esc_html( wp_strip_all_tags( $chunk ) ) . '</em>';

			continue;
		}

		foreach ( preg_split( '/\s+/', trim( $chunk ), -1, PREG_SPLIT_NO_EMPTY ) as $word ) {
			$out[] = '<span class="w">' . esc_html( $word ) . '</span>';
		}
	}

	return implode( ' ', $out );
}

/**
 * A title with its hero accent taken back out.
 *
 * The accent a hero draws in gold is an `<em>` in the title field, which is the
 * only way an editor can say "this word". Everywhere else the title appears —
 * a card, a breadcrumb, a ticker, a list of headlines — the designs print it
 * plain, so the tag comes off again rather than italicising a card title.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post|null $post Post. Defaults to the one in the loop.
 * @return string Title, with every tag stripped.
 */
function iflynepal_article_plain_title( $post = null ) {
	return wp_strip_all_tags( get_the_title( $post ) );
}

/* ------------------------------------------------------------ the sidebar */

/**
 * The line under the author's name in the contributors card.
 *
 * The author's biography when they have written one, and the house line the
 * design prints otherwise — the byline on this site is a team rather than a
 * person, and "Trip planning team, Kathmandu" is what that team is.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string
 */
function iflynepal_article_author_line( $author_id ) {
	$bio = trim( (string) get_the_author_meta( 'description', $author_id ) );

	if ( '' !== $bio ) {
		return $bio;
	}

	return __( 'Trip planning team, Kathmandu', 'iflynepal' );
}

/**
 * One of the site's own social profiles, as the footer has it.
 *
 * The four buttons beside the share control are the site's accounts, not this
 * article's, so they read the same settings the footer's follow row does
 * rather than growing a second set to keep in step.
 *
 * @since 1.0.0
 *
 * @param string $slug Network slug, as inc/customizer/callbacks/footer.php keys them.
 * @return string URL, empty when the network is unknown or the field cleared.
 */
function iflynepal_article_social_url( $slug ) {
	$networks = iflynepal_footer_social_networks();

	if ( ! isset( $networks[ $slug ] ) ) {
		return '';
	}

	return trim( (string) get_theme_mod( 'iflynepal_footer_social_' . $slug, $networks[ $slug ]['placeholder'] ) );
}

/**
 * Where the share menu points, for the article being viewed.
 *
 * @since 1.0.0
 *
 * @return array<string,string> Destinations keyed by network.
 */
function iflynepal_article_share_links() {
	$url   = get_permalink();
	$title = get_the_title();

	return array(
		'url'      => $url,
		'whatsapp' => 'https://wa.me/?text=' . rawurlencode( $title . ' ' . $url ),
		'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
		'x'        => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $title ),
		'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ),
	);
}

/* ------------------------------------------------------------ the related */

/**
 * The articles the closing row offers next.
 *
 * Same category first, newest first, the article itself excluded. Short of
 * four, the rest of the archive tops the row up rather than leaving a gap in
 * a two-by-two grid.
 *
 * @since 1.0.0
 *
 * @return WP_Post[] Articles, at most IFLYNEPAL_ARTICLE_RELATED of them.
 */
function iflynepal_article_related() {
	return iflynepal_section_related( IFLYNEPAL_ARTICLE_POST_TYPE, IFLYNEPAL_ARTICLE_CATEGORY );
}

/**
 * The pieces a section's closing row offers next.
 *
 * The rule above, written once for both sections: same category first, newest
 * first, this piece excluded, the rest of the archive topping the row up.
 *
 * @since 1.0.0
 *
 * @param string $post_type Post type to draw from.
 * @param string $taxonomy  Taxonomy the category comes from.
 * @return WP_Post[] Posts, at most IFLYNEPAL_ARTICLE_RELATED of them.
 */
function iflynepal_section_related( $post_type, $taxonomy ) {
	$post_id  = (int) get_the_ID();
	$category = iflynepal_section_primary_category( $post_id );
	$args     = array(
		'post_type'              => $post_type,
		'post_status'            => 'publish',
		'posts_per_page'         => IFLYNEPAL_ARTICLE_RELATED,
		'post__not_in'           => array( $post_id ),
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
	);

	$posts = array();

	if ( $category ) {
		$in_category = get_posts(
			$args + array(
				'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- One term, on a single-article request.
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => $category->term_id,
					),
				),
			)
		);

		$posts = $in_category;
	}

	if ( count( $posts ) < IFLYNEPAL_ARTICLE_RELATED ) {
		$exclude = array_merge( array( $post_id ), wp_list_pluck( $posts, 'ID' ) );

		$posts = array_merge(
			$posts,
			get_posts(
				array_merge(
					$args,
					array(
						'posts_per_page' => IFLYNEPAL_ARTICLE_RELATED - count( $posts ),
						'post__not_in'   => $exclude,
					)
				)
			)
		);
	}

	return $posts;
}
