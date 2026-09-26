<?php
/**
 * A "Translations" column for every Polylang-translated post type and
 * taxonomy's admin list table.
 *
 * Polylang's own per-language columns (one flag/pencil/"+" icon per language)
 * already let an editor jump between a post and its translation, but only
 * from whichever side they happen to have open — there is no single glance
 * that shows both languages' titles together. This column adds that: one
 * cell, next to Title/Name, linking straight to every other language's
 * translation (or straight to creating one, if it does not exist yet).
 *
 * Generic over whichever post types and taxonomies Polylang is managing
 * language for — Packages, Articles, News, Testimonials, Package Types and
 * so on all get it automatically, with nothing here naming any of them,
 * because it reads the list from Polylang's own model rather than assuming
 * it.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The column's machine name, shared by every list table it appears on.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_TRANSLATIONS_COLUMN = 'iflynepal_translations';

/**
 * Registers the column on every translated post type's and taxonomy's list
 * table.
 *
 * Hooked to admin_init at a low priority so it runs after Polylang
 * (PLL_Admin_Base) has built its own list of translated post types and
 * taxonomies from the site's settings — asking before that would see an
 * empty list.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_register_translation_columns() {
	if ( ! is_admin() || ! function_exists( 'PLL' ) || ! PLL() instanceof PLL_Admin_Base ) {
		return;
	}

	foreach ( PLL()->model->get_translated_post_types() as $iflynepal_post_type ) {
		add_filter( "manage_{$iflynepal_post_type}_posts_columns", 'iflynepal_translation_column_header' );
		add_action( "manage_{$iflynepal_post_type}_posts_custom_column", 'iflynepal_translation_post_column_content', 10, 2 );
	}

	foreach ( PLL()->model->get_translated_taxonomies() as $iflynepal_taxonomy ) {
		add_filter( "manage_edit-{$iflynepal_taxonomy}_columns", 'iflynepal_translation_column_header' );
		add_filter( "manage_{$iflynepal_taxonomy}_custom_column", 'iflynepal_translation_term_column_content', 10, 3 );
	}
}
add_action( 'admin_init', 'iflynepal_register_translation_columns', 20 );

/**
 * Inserts the column right after Title (posts) or Name (terms).
 *
 * @since 1.0.0
 *
 * @param string[] $columns Existing columns, keyed by slug.
 * @return string[] Filtered columns.
 */
function iflynepal_translation_column_header( $columns ) {
	$new      = array();
	$inserted = false;

	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;

		if ( ! $inserted && in_array( $key, array( 'title', 'name' ), true ) ) {
			$new[ IFLYNEPAL_TRANSLATIONS_COLUMN ] = __( 'Translations', 'iflynepal' );
			$inserted                             = true;
		}
	}

	if ( ! $inserted ) {
		$new[ IFLYNEPAL_TRANSLATIONS_COLUMN ] = __( 'Translations', 'iflynepal' );
	}

	return $new;
}

/**
 * One link per language, for a single list-table cell.
 *
 * Shared between the post and term column renderers below — both end up
 * with the same "a translation exists, or it doesn't" choice per language,
 * just reached through different Polylang model calls.
 *
 * @since 1.0.0
 *
 * @param PLL_Language $language        The other language being offered.
 * @param int           $translation_id 0 when no translation exists yet.
 * @param string        $edit_link      Edit URL, when a translation exists.
 * @param string        $title          The translation's title/name, when it exists.
 * @param string        $new_link       URL to create the translation, when it does not exist yet.
 * @return string HTML, or '' when the current user cannot even create one
 *                (Polylang's own capability check already declined the link).
 */
function iflynepal_translation_column_link( $language, $translation_id, $edit_link, $title, $new_link ) {
	$flag = is_object( $language ) && ! empty( $language->flag ) ? $language->flag . ' ' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Polylang's own escaped flag markup.

	if ( $translation_id && '' !== $edit_link ) {
		return sprintf(
			'<a href="%1$s">%2$s%3$s</a>',
			esc_url( $edit_link ),
			$flag, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
			esc_html( $title )
		);
	}

	if ( '' === $new_link ) {
		return '';
	}

	return sprintf(
		'<a href="%1$s" class="iflynepal-translation-add">%2$s+ %3$s</a>',
		esc_url( $new_link ),
		$flag, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
		esc_html( $language->name )
	);
}

/**
 * Fills the column for one post row.
 *
 * @since 1.0.0
 *
 * @param string $column  Column slug.
 * @param int    $post_id Post ID.
 * @return void
 */
function iflynepal_translation_post_column_content( $column, $post_id ) {
	if ( IFLYNEPAL_TRANSLATIONS_COLUMN !== $column ) {
		return;
	}

	$own_language = PLL()->model->post->get_language( $post_id );

	if ( ! $own_language ) {
		esc_html_e( '(no language set)', 'iflynepal' );

		return;
	}

	$post  = get_post( $post_id );
	$links = array();

	foreach ( PLL()->model->get_languages_list() as $iflynepal_language ) {
		if ( $iflynepal_language->slug === $own_language->slug ) {
			continue;
		}

		$translation_id = PLL()->model->post->get_translation( $post_id, $iflynepal_language );
		$edit_link      = $translation_id ? (string) get_edit_post_link( $translation_id, 'raw' ) : '';
		$title          = $translation_id ? get_the_title( $translation_id ) : '';
		$new_link       = $translation_id || ! $post instanceof WP_Post
			? ''
			: PLL()->links->get_new_post_translation_link( $post, $iflynepal_language );

		$link = iflynepal_translation_column_link( $iflynepal_language, $translation_id, $edit_link, $title, $new_link );

		if ( '' !== $link ) {
			$links[] = $link;
		}
	}

	echo $links ? implode( '<br>', $links ) : '&mdash;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Every link is escaped as it is built.
}

/**
 * Fills the column for one term row.
 *
 * A filter, not an action — the term list table asks every custom column
 * for its content and prints whatever is returned, rather than letting the
 * callback echo directly the way the post list table does.
 *
 * @since 1.0.0
 *
 * @param string $content     Existing cell content.
 * @param string $column      Column slug.
 * @param int    $term_id     Term ID.
 * @return string Filtered content.
 */
function iflynepal_translation_term_column_content( $content, $column, $term_id ) {
	if ( IFLYNEPAL_TRANSLATIONS_COLUMN !== $column ) {
		return $content;
	}

	$term = get_term( $term_id );

	if ( ! $term instanceof WP_Term ) {
		return $content;
	}

	$own_language = PLL()->model->term->get_language( $term_id );

	if ( ! $own_language ) {
		return esc_html__( '(no language set)', 'iflynepal' );
	}

	// Any post type the taxonomy is attached to works; it only names the
	// screen the "+ Add" link opens on, not which posts get tagged.
	$taxonomy_object = get_taxonomy( $term->taxonomy );
	$post_type       = $taxonomy_object && ! empty( $taxonomy_object->object_type ) ? reset( $taxonomy_object->object_type ) : 'post';

	$links = array();

	foreach ( PLL()->model->get_languages_list() as $iflynepal_language ) {
		if ( $iflynepal_language->slug === $own_language->slug ) {
			continue;
		}

		$translation_id = PLL()->model->term->get_translation( $term_id, $iflynepal_language );
		$translation    = $translation_id ? get_term( $translation_id ) : null;
		$edit_link      = $translation instanceof WP_Term ? (string) get_edit_term_link( $translation, $translation->taxonomy ) : '';
		$name           = $translation instanceof WP_Term ? $translation->name : '';
		$new_link       = $translation_id
			? ''
			: PLL()->links->get_new_term_translation_link( $term, $post_type, $iflynepal_language );

		$link = iflynepal_translation_column_link( $iflynepal_language, $translation_id, $edit_link, $name, $new_link );

		if ( '' !== $link ) {
			$links[] = $link;
		}
	}

	return $links ? implode( '<br>', $links ) : '&mdash;';
}
