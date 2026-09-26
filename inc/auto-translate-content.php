<?php
/**
 * DeepL auto-translate for Posts, Articles, News and Testimonials.
 *
 * The Packages plugin (ifn-booking) already does this for packages; this file
 * is the same idea generalized to the theme's own post types, reusing the
 * plugin's DeepL client (iflynepal_deepl_translate_batch() and friends) and
 * settings rather than duplicating them — the API key is one site-wide
 * integration, not a per-content-type one.
 *
 * Runs on the same "+ Add" flow as the package version: Polylang's own
 * `use_block_editor_for_post` filter, fired once when a new translation is
 * created. Three things happen there, same division as packages:
 *
 *  - The featured image is carried over unconditionally (it is the same
 *    photograph regardless of language).
 *  - Every taxonomy term already checked is carried over, creating the term's
 *    translation first (parent first) if it does not exist yet — the same
 *    "assign the wrong-language term id and let Polylang's own listener
 *    translate it" trick the packages version uses, just generalized to any
 *    taxonomy on any translated post type instead of only Package Types.
 *  - The post's own text is translated: title, excerpt and (Testimonials
 *    only) the review fields. Body content is deliberately NOT translated
 *    here yet — see the note on iflynepal_content_translate_post() below.
 *
 * Silent on any failure, same as the packages version: no configured key, an
 * expired one, a timeout, a malformed response — every one of them leaves the
 * new post exactly as blank on the affected field as it was before this file
 * existed.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'iflynepal_deepl_api_key' ) ) {
	return; // The booking plugin, which owns the DeepL client, is not active.
}

/**
 * Carries a post's featured image over to its translation.
 *
 * Unscoped by post type on purpose — a photograph is the same photograph
 * regardless of which language the post reads in, whether it is a Package
 * (handled separately, in the plugin, alongside its own gallery and video),
 * a News item, an Article or a Testimonial's reviewer photo is its own meta
 * key and already covered by iflynepal_content_translate_testimonial() below.
 *
 * @since 1.0.0
 *
 * @param string[] $keys Meta keys already queued to copy or sync.
 * @return string[] Filtered meta keys.
 */
function iflynepal_content_sync_thumbnail( $keys ) {
	return array_unique( array_merge( $keys, array( '_thumbnail_id' ) ) );
}
add_filter( 'pll_copy_post_metas', 'iflynepal_content_sync_thumbnail' );

/**
 * Carries every taxonomy term a post has checked over to its translation,
 * creating the term's own translation first (parent first, for a hierarchical
 * taxonomy) if it does not exist yet.
 *
 * The same mechanism the packages plugin uses for Package Types
 * (`iflynepal_package_translate_types()`), generalized to any taxonomy on any
 * Polylang-translated post type: assigning the *source* language's term ids
 * to the new, already-translated post trips `PLL_CRUD_Posts::set_object_terms()`
 * — Polylang's own listener, always active, that notices a post is being
 * tagged with terms in the wrong language and translates or creates each one.
 * Package Types is excluded here only because it already has its own copy of
 * this running in the plugin; running it twice would be harmless but pointless.
 *
 * @since 1.0.0
 *
 * @param bool $is_block_editor Whether the post can be edited with the block editor.
 * @return bool Unmodified.
 */
function iflynepal_content_translate_taxonomies( $is_block_editor ) {
	global $post;
	static $done = array();

	if ( empty( $post ) || ! function_exists( 'PLL' ) || ! PLL() instanceof PLL_Admin_Base ) {
		return $is_block_editor;
	}

	$context_data = PLL()->links->get_data_from_new_post_translation_request();

	if ( empty( $context_data ) || ! empty( $done[ $context_data['from_post']->ID ] ) ) {
		return $is_block_editor;
	}

	$from_post_type = $context_data['from_post']->post_type;

	if ( ! PLL()->model->is_translated_post_type( $from_post_type ) ) {
		return $is_block_editor;
	}

	$done[ $context_data['from_post']->ID ] = true;

	foreach ( get_object_taxonomies( $from_post_type ) as $taxonomy ) {
		if ( defined( 'IFLYNEPAL_PACKAGE_TAXONOMY' ) && IFLYNEPAL_PACKAGE_TAXONOMY === $taxonomy ) {
			continue; // Already handled by the plugin's own copy of this.
		}

		if ( ! PLL()->model->is_translated_taxonomy( $taxonomy ) ) {
			continue;
		}

		$terms = wp_get_object_terms( $context_data['from_post']->ID, $taxonomy, array( 'fields' => 'ids' ) );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			wp_set_object_terms( $post->ID, $terms, $taxonomy );
		}
	}

	return $is_block_editor;
}
add_filter( 'use_block_editor_for_post', 'iflynepal_content_translate_taxonomies', 5000 );

/**
 * The post types this file translates title and excerpt for.
 *
 * Testimonials is deliberately not in this list — it supports neither the
 * title nor the excerpt (see iflynepal_register_testimonial_cpt()); its own
 * fields are translated by iflynepal_content_translate_testimonial() instead.
 *
 * @since 1.0.0
 *
 * @return string[]
 */
function iflynepal_content_translatable_post_types() {
	$types = array( 'post' );

	if ( defined( 'IFLYNEPAL_ARTICLE_POST_TYPE' ) ) {
		$types[] = IFLYNEPAL_ARTICLE_POST_TYPE;
	}

	if ( defined( 'IFLYNEPAL_NEWS_POST_TYPE' ) ) {
		$types[] = IFLYNEPAL_NEWS_POST_TYPE;
	}

	return $types;
}

/**
 * Translates a post's title and excerpt into another, already-created post.
 *
 * Body content is deliberately left alone. WordPress stores a block editor
 * post's content as HTML interleaved with `<!-- wp:… -->` block comments, and
 * DeepL's own HTML-aware translation mode does not reliably parse that
 * structure — a list block's comments sit *inside* its `<ul>`, between
 * sibling `<li>` tags, which is valid to WordPress and confirmed (tested
 * directly against the API while building this) to make DeepL's parser
 * reject the request outright on some block shapes and silently mangle the
 * markup on others. Automatically translating the body risks corrupting a
 * real post's content in a way an editor would have to notice and repair by
 * hand, which is a worse outcome than leaving it blank to write directly.
 *
 * @since 1.0.0
 *
 * @param int    $from_id     Source post.
 * @param int    $to_id       The new translation, already created.
 * @param string $source_lang Polylang language slug of the source.
 * @param string $target_lang Polylang language slug of the target.
 * @return void
 */
function iflynepal_content_translate_post( $from_id, $to_id, $source_lang, $target_lang ) {
	if ( '' === iflynepal_deepl_api_key() ) {
		return;
	}

	$from_post = get_post( $from_id );

	if ( ! $from_post instanceof WP_Post ) {
		return;
	}

	$texts = array();
	$jobs  = array();

	if ( '' !== $from_post->post_title ) {
		$texts[] = $from_post->post_title;
		$jobs[]  = 'post_title';
	}

	if ( '' !== trim( wp_strip_all_tags( $from_post->post_excerpt ) ) ) {
		$texts[] = $from_post->post_excerpt;
		$jobs[]  = 'post_excerpt';
	}

	if ( empty( $texts ) ) {
		return;
	}

	$target_code = iflynepal_deepl_lang_code( $target_lang, true );
	$source_code = iflynepal_deepl_lang_code( $source_lang, false );

	$translated = iflynepal_deepl_translate_batch( $texts, $target_code, $source_code );

	$update = array( 'ID' => $to_id );

	foreach ( $jobs as $index => $field ) {
		$value = isset( $translated[ $index ] ) ? $translated[ $index ] : '';

		if ( '' === $value ) {
			continue; // Failed or empty: leave this one field as it was.
		}

		$update[ $field ] = 'post_title' === $field ? sanitize_text_field( $value ) : wp_kses_post( $value );
	}

	if ( count( $update ) <= 1 ) {
		return;
	}

	wp_update_post( $update );

	/*
	 * wp_update_post() writes the database row, but this runs while
	 * post-new.php is still building the very same request that will render
	 * the title and excerpt fields from its own already-fetched $post object —
	 * a PHP object reference the write above never touches. Setting it
	 * directly here is what makes the fields show the translated values
	 * immediately instead of only after a reload.
	 */
	global $post;

	if ( $post instanceof WP_Post && (int) $post->ID === (int) $to_id ) {
		foreach ( $update as $field => $value ) {
			if ( 'ID' !== $field ) {
				$post->$field = $value;
			}
		}
	}
}

/**
 * Translates a Testimonial's review fields into another, already-created
 * testimonial.
 *
 * Unlike Posts/Articles/News, every one of Testimonials' fields is plain-text
 * post meta (see class-ifly-nepal-testimonial-meta-box.php) rather than block
 * editor content, so none of the body-content risk above applies here — the
 * review headline and body are translated the same straightforward way the
 * packages plugin translates a package's prose fields.
 *
 * The reviewer's name and photo are carried over unchanged, never translated:
 * a name is a name in every language, and the photo is the same person's
 * face. The country is translated — "Germany" reads as "Allemagne" in
 * French, and it is short, plain text with nothing else in the field to
 * confuse a translation. The pages/archives this review is set to display
 * on are copied unchanged too; a French page this review isn't tied to yet
 * would need the editor's own eye regardless of what this file could guess.
 *
 * @since 1.0.0
 *
 * @param int $from_id Source testimonial.
 * @param int $to_id   The new translation, already created.
 * @return void
 */
function iflynepal_content_translate_testimonial( $from_id, $to_id ) {
	if ( '' === iflynepal_deepl_api_key() ) {
		return;
	}

	// Copied verbatim, never translated.
	foreach ( array( '_iflynepal_reviewer_name', '_iflynepal_reviewer_photo' ) as $meta_key ) {
		$value = get_post_meta( $from_id, $meta_key, true );

		if ( '' !== $value ) {
			update_post_meta( $to_id, $meta_key, $value );
		}
	}

	foreach ( get_post_meta( $from_id, IFLYNEPAL_TESTIMONIAL_TARGET_KEY, false ) as $value ) {
		add_post_meta( $to_id, IFLYNEPAL_TESTIMONIAL_TARGET_KEY, $value );
	}

	$texts = array();
	$jobs  = array();

	foreach ( array( '_iflynepal_review_headline', '_iflynepal_review_body', '_iflynepal_reviewer_country' ) as $meta_key ) {
		$value = (string) get_post_meta( $from_id, $meta_key, true );

		if ( '' === $value ) {
			continue;
		}

		$texts[] = $value;
		$jobs[]  = $meta_key;
	}

	if ( empty( $texts ) ) {
		return;
	}

	$source_lang = PLL()->model->post->get_language( $from_id );
	$target_lang = PLL()->model->post->get_language( $to_id );

	if ( ! $source_lang || ! $target_lang ) {
		return;
	}

	$target_code = iflynepal_deepl_lang_code( $target_lang->slug, true );
	$source_code = iflynepal_deepl_lang_code( $source_lang->slug, false );

	$translated = iflynepal_deepl_translate_batch( $texts, $target_code, $source_code );

	foreach ( $jobs as $index => $meta_key ) {
		$value = isset( $translated[ $index ] ) ? $translated[ $index ] : '';

		if ( '' === $value ) {
			continue;
		}

		update_post_meta( $to_id, $meta_key, sanitize_text_field( $value ) );
	}
}

/**
 * Hooks the two translators above into the same "new translation" request
 * the taxonomy and featured-image copies above already use.
 *
 * @since 1.0.0
 *
 * @param bool $is_block_editor Whether the post can be edited with the block editor.
 * @return bool Unmodified.
 */
function iflynepal_content_translate_new_post( $is_block_editor ) {
	global $post;
	static $done = array();

	if ( empty( $post ) || '' === iflynepal_deepl_api_key() || ! function_exists( 'PLL' ) || ! PLL() instanceof PLL_Admin_Base ) {
		return $is_block_editor;
	}

	$context_data = PLL()->links->get_data_from_new_post_translation_request();

	if ( empty( $context_data ) || ! empty( $done[ $context_data['from_post']->ID ] ) ) {
		return $is_block_editor;
	}

	$from_post_type = $context_data['from_post']->post_type;

	if ( defined( 'IFLYNEPAL_TESTIMONIAL_POST_TYPE' ) && IFLYNEPAL_TESTIMONIAL_POST_TYPE === $from_post_type ) {
		$done[ $context_data['from_post']->ID ] = true;
		iflynepal_content_translate_testimonial( $context_data['from_post']->ID, $post->ID );

		return $is_block_editor;
	}

	if ( ! in_array( $from_post_type, iflynepal_content_translatable_post_types(), true ) ) {
		return $is_block_editor;
	}

	$done[ $context_data['from_post']->ID ] = true;

	$source_lang = PLL()->model->post->get_language( $context_data['from_post']->ID );

	if ( ! $source_lang || ! $context_data['new_lang'] instanceof PLL_Language ) {
		return $is_block_editor;
	}

	iflynepal_content_translate_post(
		$context_data['from_post']->ID,
		$post->ID,
		$source_lang->slug,
		$context_data['new_lang']->slug
	);

	return $is_block_editor;
}
add_filter( 'use_block_editor_for_post', 'iflynepal_content_translate_new_post', 5002 );
