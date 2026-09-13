<?php
/**
 * A single news story: the pieces the design's single template needs.
 *
 * Much less than a single article needs, because a story is shorter and the
 * design draws it plainer — there is no table of contents, no FAQ list and no
 * numbered chapters, so the sidebar is only the contributors card, the share
 * control and the rail of recent headlines.
 *
 * What the two do share lives in inc/article-single.php and is called from
 * here rather than copied: the pass over the rendered content, the reading
 * time, the headline splitter, the author's initials and the share links are
 * the same work under the same stylesheet.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * How many stories the "More from the News Center" row holds.
 *
 * Four, in one row of four, as the design draws it.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_NEWS_RELATED = 4;

/**
 * The rendered story, dressed the way the news design has it.
 *
 * The shared pass, with the two differences the news body asks for: the
 * standfirst carries `news-lede` as well as `post-lede`, and it opens with the
 * dateline rather than with a dropped capital.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Story. Defaults to the one in the loop.
 * @return array{html:string,headings:array<int,array{id:string,text:string}>} Body and index.
 */
function iflynepal_news_body( $post_id = null ) {
	return iflynepal_article_body( $post_id, iflynepal_news_body_args( $post_id ) );
}

/**
 * The arguments the story's body is rendered with.
 *
 * Split out so the reading time can ask for the same body rather than a second
 * rendering of the same content.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Story. Defaults to the one in the loop.
 * @return array<string,string> Arguments for iflynepal_article_body().
 */
function iflynepal_news_body_args( $post_id = null ) {
	return array(
		'lede_class' => 'news-lede',
		'dateline'   => iflynepal_news_place( $post_id ),
	);
}

/**
 * How long the story takes to read, in whole minutes.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Story. Defaults to the one in the loop.
 * @return int Minutes.
 */
function iflynepal_news_read_minutes( $post_id = null ) {
	return iflynepal_article_read_minutes( $post_id, iflynepal_news_body_args( $post_id ) );
}

/**
 * The stories the closing row offers next.
 *
 * Newest first, this one excluded. There is no taxonomy to prefer a nearer
 * story by — every story is filed under News — so recency is the whole of the
 * ordering, and it is the same run the ticker and the sidebar's rail show.
 *
 * @since 1.0.0
 *
 * @return WP_Post[] Stories, at most IFLYNEPAL_NEWS_RELATED of them.
 */
function iflynepal_news_related() {
	return iflynepal_news_latest( IFLYNEPAL_NEWS_RELATED, (int) get_the_ID() );
}
