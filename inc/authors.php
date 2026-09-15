<?php
/**
 * The Authors directory and a single author's page.
 *
 * The architecture is CloudColleague's: an author is a WordPress user, not a
 * custom post type, so its content lives as user meta and its two pages are
 * WordPress's own author archive (author.php) and an ordinary Page carrying
 * a template (page-authors.php), not a plugin, not a CPT. The extra fields
 * are registered in inc/user-profile.php.
 *
 * This site's own shape differs from CloudColleague's in one place worth
 * recording: CloudColleague's author writes for exactly one of post / articles
 * / news, and picks a single dedicated section accordingly. This theme keeps
 * three editorial families too: Blogs (inc/blogs.php), Articles
 * (inc/cpts/article-cpt.php) and News (inc/cpts/news-cpt.php). But the
 * approved design shows an author with both Articles and News mixed into one
 * grid with a "View all" button per family they actually have, rather than
 * one family winning outright. iflynepal_author_post_type_actions() below is
 * what makes that combination hold for any mix of the three, not just the
 * pair the design happens to show.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------------------- requests */

/**
 * Whether the current request is the Authors directory.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_authors_archive() {
	return is_page_template( 'page-authors.php' );
}

/**
 * Whether the current request is a single author's page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function iflynepal_has_author() {
	return is_author();
}

/**
 * Docks the header from the first frame on a single author page.
 *
 * The header is transparent until scrolled past a `.hero`, and a single
 * author page has no `.hero` (its `.author-banner` is a shorter, plainer
 * band), so `iflynepal_has_hero()` correctly answers false for it and
 * assets/js/articles/motion.js never finds a `.hero` to dock the header
 * against. Without this the header would stay transparent for the whole
 * page: white type on a white bio section. The same fix the booking plugin
 * uses for its own hero-less single template.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_dock_header_on_author() {
	if ( ! is_author() ) {
		return;
	}
	?>
	<script>
		document.addEventListener( 'DOMContentLoaded', function () {
			var header = document.getElementById( 'iflynepal-header' );

			if ( header ) {
				header.classList.add( 'is-docked' );
			}
		} );
	</script>
	<?php
}
add_action( 'wp_head', 'iflynepal_dock_header_on_author' );

/**
 * The Authors directory's own URL, for the breadcrumb on a single author page.
 *
 * Found by its template rather than by slug, the way CloudColleague's
 * author-layout.php does it: an editor can rename or move the page and the
 * breadcrumb still finds it.
 *
 * @since 1.0.0
 *
 * @return string URL, falling back to the front page if no such page exists.
 */
function iflynepal_authors_archive_url() {
	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value' => 'page-authors.php', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'number'     => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0]->ID );

		if ( $url ) {
			return $url;
		}
	}

	return home_url( '/' );
}

/* ------------------------------------------------------------------- role */

/**
 * The short line under an author's name.
 *
 * One function for every place this site names an author, so the byline on an
 * article's aside card, the Authors directory card and the full author page
 * can never disagree: the Role field when set, this person's WordPress
 * biography when they have written one and no Role, and the house line
 * (this is a team byline as often as it is a person's) when neither exists.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string
 */
function iflynepal_author_role( $author_id ) {
	$role = trim( (string) get_user_meta( $author_id, 'iflynepal_author_role', true ) );

	if ( '' !== $role ) {
		return $role;
	}

	return iflynepal_article_author_line( $author_id );
}

/**
 * The handwritten note beside the role, on the full author page only.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string Empty when the editor left it blank.
 */
function iflynepal_author_hand_note( $author_id ) {
	return trim( (string) get_user_meta( $author_id, 'iflynepal_author_hand', true ) );
}

/* -------------------------------------------------------------------- bio */

/**
 * Whether the full author page has anything to put in its bio section.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return bool
 */
function iflynepal_author_has_bio( $author_id ) {
	return '' !== trim( (string) get_user_meta( $author_id, 'iflynepal_author_bio', true ) )
		|| array() !== iflynepal_author_expertise_pills( $author_id )
		|| '' !== trim( (string) get_user_meta( $author_id, 'iflynepal_author_experience', true ) )
		|| '' !== trim( (string) get_user_meta( $author_id, 'iflynepal_author_contribution', true ) );
}

/**
 * The opening paragraphs, ready to print.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string HTML, already escaped; empty when nothing is written.
 */
function iflynepal_author_bio_html( $author_id ) {
	$bio = trim( (string) get_user_meta( $author_id, 'iflynepal_author_bio', true ) );

	if ( '' === $bio ) {
		return '';
	}

	return iflynepal_kses_rich( wpautop( $bio ) );
}

/**
 * "Experience", ready to print.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string HTML, already escaped; empty when nothing is written.
 */
function iflynepal_author_experience_html( $author_id ) {
	$value = trim( (string) get_user_meta( $author_id, 'iflynepal_author_experience', true ) );

	if ( '' === $value ) {
		return '';
	}

	return iflynepal_kses_rich( wpautop( $value ) );
}

/**
 * "Contribution at iFly Nepal", ready to print.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return string HTML, already escaped; empty when nothing is written.
 */
function iflynepal_author_contribution_html( $author_id ) {
	$value = trim( (string) get_user_meta( $author_id, 'iflynepal_author_contribution', true ) );

	if ( '' === $value ) {
		return '';
	}

	return iflynepal_kses_rich( wpautop( $value ) );
}

/**
 * The expertise pills, each linking to the real Article Category it names.
 *
 * A slug that does not match a real, existing category is silently dropped:
 * an admin field is not the place to validate against a taxonomy that can
 * change after the field was last saved.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return array<int,array{name:string,url:string}> Pills, in the order typed.
 */
function iflynepal_author_expertise_pills( $author_id ) {
	$raw = trim( (string) get_user_meta( $author_id, 'iflynepal_author_expertise', true ) );

	if ( '' === $raw ) {
		return array();
	}

	$pills = array();

	foreach ( explode( ',', $raw ) as $piece ) {
		$slug = sanitize_title( trim( $piece ) );

		if ( '' === $slug ) {
			continue;
		}

		$term = get_term_by( 'slug', $slug, IFLYNEPAL_ARTICLE_CATEGORY );

		if ( ! $term instanceof WP_Term ) {
			continue;
		}

		$url = get_term_link( $term );

		if ( is_wp_error( $url ) ) {
			continue;
		}

		$pills[] = array(
			'name' => $term->name,
			'url'  => $url,
		);
	}

	return $pills;
}

/* --------------------------------------------------------------- socials */

/**
 * The social networks an author page can show, in the order the design
 * draws them, each with the icon markup the design uses for it.
 *
 * @since 1.0.0
 *
 * @return array<string,array{field:string,label:string,icon:string}>
 */
function iflynepal_author_social_networks() {
	return array(
		'facebook'  => array(
			'field' => 'iflynepal_author_social_facebook',
			'label' => __( 'Facebook', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M24 12.07C24 5.44 18.63.07 12 .07S0 5.44 0 12.07c0 5.99 4.39 10.95 10.13 11.85v-8.38H7.08v-3.47h3.05V9.43c0-3 1.79-4.67 4.53-4.67 1.31 0 2.69.24 2.69.24v2.95h-1.52c-1.49 0-1.95.92-1.95 1.87v2.25h3.33l-.53 3.47h-2.8v8.38C19.61 23.03 24 18.06 24 12.07z"/></svg>',
		),
		'instagram' => array(
			'field' => 'iflynepal_author_social_instagram',
			'label' => __( 'Instagram', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.4" cy="6.6" r=".6" fill="currentColor"/></svg>',
		),
		'youtube'   => array(
			'field' => 'iflynepal_author_social_youtube',
			'label' => __( 'YouTube', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10.2 9.4 4.6 2.6-4.6 2.6z" fill="currentColor"/></svg>',
		),
		'x'         => array(
			'field' => 'iflynepal_author_social_x',
			'label' => __( 'X', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24H16.17l-4.71-6.23-5.4 6.23H2.74l7.73-8.84L1.25 2.25H8.08l4.26 5.63 5.9-5.63zm-1.16 17.52h1.83L7.08 4.13H5.12l11.96 15.64z"/></svg>',
		),
		'whatsapp'  => array(
			'field' => 'iflynepal_author_social_whatsapp',
			'label' => __( 'WhatsApp', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><path d="M20.5 11.6a8.5 8.5 0 0 1-12.6 7.4L3.5 20.5l1.6-4.3a8.5 8.5 0 1 1 15.4-4.6Z"/><path d="M9 9.4c.3 2.3 2.3 4.3 4.6 4.6l1-1.2 1.7.8c-.2 1-1.1 1.6-2.1 1.5A6.6 6.6 0 0 1 8.1 9c-.1-1 .5-1.9 1.5-2.1l.8 1.7-1.4.8Z"/></svg>',
		),
		'website'   => array(
			'field' => 'iflynepal_author_social_website',
			'label' => __( 'Website', 'iflynepal' ),
			'icon'  => '<svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><circle cx="12" cy="12" r="9.2"/><path d="M2.8 12h18.4"/><path d="M12 2.8a14 14 0 0 1 3.7 9.2A14 14 0 0 1 12 21.2 14 14 0 0 1 8.3 12 14 14 0 0 1 12 2.8Z"/></svg>',
		),
	);
}

/**
 * The social links an author has actually filled in, in display order.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return array<int,array{slug:string,url:string,label:string,icon:string}>
 */
function iflynepal_author_social_links( $author_id ) {
	$links = array();

	foreach ( iflynepal_author_social_networks() as $slug => $network ) {
		$url = trim( (string) get_user_meta( $author_id, $network['field'], true ) );

		if ( '' === $url ) {
			continue;
		}

		$links[] = array(
			'slug'  => $slug,
			'url'   => $url,
			'label' => $network['label'],
			'icon'  => $network['icon'],
		);
	}

	return $links;
}

/* ---------------------------------------------------------------- photo */

/**
 * The attachment ID of an author's uploaded photo.
 *
 * Zero when none is set. The Authors directory card leaves the photo slot
 * out of the markup entirely in that case, rather than falling back to a
 * Gravatar placeholder, so this is asked for as its own question rather than
 * folded into get_avatar().
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return int Attachment ID, 0 when none.
 */
function iflynepal_author_photo_id( $author_id ) {
	return (int) get_user_meta( $author_id, 'iflynepal_author_photo', true );
}

/* ---------------------------------------------------------------- stats */

/**
 * How many distinct Article Categories an author's articles are filed under.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return int
 */
function iflynepal_author_topic_count( $author_id ) {
	$ids = get_posts(
		array(
			'post_type'        => IFLYNEPAL_ARTICLE_POST_TYPE,
			'author'           => $author_id,
			'posts_per_page'   => -1,
			'fields'           => 'ids',
			'no_found_rows'    => true,
			'suppress_filters' => false,
		)
	);

	if ( empty( $ids ) ) {
		return 0;
	}

	$terms = wp_get_object_terms( $ids, IFLYNEPAL_ARTICLE_CATEGORY, array( 'fields' => 'ids' ) );

	return is_wp_error( $terms ) ? 0 : count( array_unique( $terms ) );
}

/**
 * The counts under the social row on the full author page.
 *
 * Each stat is left out when it is zero. The design's three facts (Articles,
 * News stories, Topics covered) all assume the author has articles; a
 * blogs-only author has no topics to report and no news either, and a stats
 * row of zeroes is not a stat.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return array<int,array{value:int,label:string}>
 */
function iflynepal_author_stats( $author_id ) {
	$stats = array();

	$articles = (int) count_user_posts( $author_id, IFLYNEPAL_ARTICLE_POST_TYPE, true );
	$news     = (int) count_user_posts( $author_id, IFLYNEPAL_NEWS_POST_TYPE, true );
	$topics   = iflynepal_author_topic_count( $author_id );

	if ( $articles ) {
		$stats[] = array(
			'value' => $articles,
			/* translators: %s: number of articles, already formatted. */
			'label' => _n( 'Article', 'Articles', $articles, 'iflynepal' ),
		);
	}

	if ( $news ) {
		$stats[] = array(
			'value' => $news,
			'label' => _n( 'News story', 'News stories', $news, 'iflynepal' ),
		);
	}

	if ( $topics ) {
		$stats[] = array(
			'value' => $topics,
			'label' => _n( 'Topic covered', 'Topics covered', $topics, 'iflynepal' ),
		);
	}

	return $stats;
}

/* ----------------------------------------------------------------- posts */

/**
 * Whichever of the three editorial families this author has written in.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return array{blogs:bool,articles:bool,news:bool}
 */
function iflynepal_author_post_type_flags( $author_id ) {
	return array(
		'blogs'    => count_user_posts( $author_id, 'post', true ) > 0,
		'articles' => count_user_posts( $author_id, IFLYNEPAL_ARTICLE_POST_TYPE, true ) > 0,
		'news'     => count_user_posts( $author_id, IFLYNEPAL_NEWS_POST_TYPE, true ) > 0,
	);
}

/**
 * The recent posts grid: the author's own writing across all three families,
 * newest first.
 *
 * A single mixed query rather than CloudColleague's exclusive branches
 * (blogs, or articles, or news, whichever wins): the approved design shows an
 * author with Articles and News side by side in one grid, dated against each
 * other rather than grouped by type, and a mixed query is the only thing
 * that produces that order for any combination of the three families.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @param int $limit     Optional. How many at most. Default 6, the design's own count.
 * @return WP_Post[]
 */
function iflynepal_author_posts( $author_id, $limit = 6 ) {
	return get_posts(
		array(
			'post_type'           => array( 'post', IFLYNEPAL_ARTICLE_POST_TYPE, IFLYNEPAL_NEWS_POST_TYPE ),
			'author'              => $author_id,
			'posts_per_page'      => (int) $limit,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'suppress_filters'    => false,
		)
	);
}

/**
 * The "View all …" buttons under the posts grid, one per family the author
 * actually has, in the order the design's own two-button case draws them:
 * the quieter outline buttons before the one primary button.
 *
 * @since 1.0.0
 *
 * @param int $author_id Author.
 * @return array<int,array{label:string,url:string,style:string}>
 */
function iflynepal_author_post_type_actions( $author_id ) {
	$flags   = iflynepal_author_post_type_flags( $author_id );
	$actions = array();

	if ( $flags['blogs'] ) {
		$actions[] = array(
			'label' => __( 'View all blogs', 'iflynepal' ),
			'url'   => iflynepal_blogs_archive_url(),
			'style' => 'button--outline',
		);
	}

	if ( $flags['news'] ) {
		$actions[] = array(
			'label' => __( 'View all news', 'iflynepal' ),
			'url'   => iflynepal_news_archive_url(),
			'style' => 'button--outline',
		);
	}

	if ( $flags['articles'] ) {
		$actions[] = array(
			'label' => __( 'View all articles', 'iflynepal' ),
			'url'   => iflynepal_articles_archive_url(),
			'style' => 'button--primary',
		);
	}

	return $actions;
}

/* ----------------------------------------------------------------- list */

/**
 * The authors shown on the Authors directory: whoever has a published Blog,
 * Article or News story, by display name.
 *
 * No role filter, unlike CloudColleague's `role__in`: this team's accounts
 * are not consistently on an "author" or "contributor" role, so the only
 * reliable question is the one that actually matters: has this person
 * published something a visitor can read.
 *
 * @since 1.0.0
 *
 * @return WP_User[]
 */
function iflynepal_authors_list() {
	return get_users(
		array(
			'has_published_posts' => array( 'post', IFLYNEPAL_ARTICLE_POST_TYPE, IFLYNEPAL_NEWS_POST_TYPE ),
			'orderby'             => 'display_name',
			'order'               => 'ASC',
		)
	);
}
