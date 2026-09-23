<?php
/**
 * The news story's sidebar: who filed it, where to share it, and what else is
 * new.
 *
 * The design's markup, class for class. It is the article's sidebar with the
 * table of contents replaced by the rail of recent headlines — a news story is
 * short enough not to need an index, and the reader of one is more likely to
 * want the next story than a way back up this one.
 *
 * The rail holds the same five stories the hero's ticker runs, this one left
 * out of both: the two are one list read twice, and a reader who has just
 * scrolled past the ticker should find the rail agreeing with it.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_news_aside_author   = (int) get_the_author_meta( 'ID' );
$iflynepal_news_aside_name     = get_the_author();
$iflynepal_news_aside_initials = iflynepal_article_initials( $iflynepal_news_aside_name );
$iflynepal_news_aside_role     = iflynepal_author_role( $iflynepal_news_aside_author );
$iflynepal_news_aside_share    = iflynepal_article_share_links();
$iflynepal_news_aside_latest   = iflynepal_news_latest( IFLYNEPAL_NEWS_LATEST, (int) get_the_ID() );

/*
 * The author's own photo (iFly Nepal Author Profile), same field the Authors
 * pages read, not a Gravatar: this team's accounts are a house byline as
 * often as a person, so there is nothing to request one for.
 */
$iflynepal_news_aside_photo_id = iflynepal_author_photo_id( $iflynepal_news_aside_author );
$iflynepal_news_aside_avatar   = $iflynepal_news_aside_photo_id ? (string) wp_get_attachment_image_url( $iflynepal_news_aside_photo_id, 'thumbnail' ) : '';

/*
 * This author's own social links (iFly Nepal Author Profile), not the site's
 * own brand accounts the footer's follow row reads — see inc/authors.php's
 * iflynepal_author_social_links(), which already leaves out whichever
 * networks this author left blank.
 */
$iflynepal_news_aside_socials = iflynepal_author_social_links( $iflynepal_news_aside_author );

/* The share menu's own two brand icons; the follow row above uses each social's own icon. */
$iflynepal_news_aside_icons = array(
	'facebook' => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M24 12.07C24 5.44 18.63.07 12 .07S0 5.44 0 12.07c0 5.99 4.39 10.95 10.13 11.85v-8.38H7.08v-3.47h3.05V9.43c0-3 1.79-4.67 4.53-4.67 1.31 0 2.69.24 2.69.24v2.95h-1.52c-1.49 0-1.95.92-1.95 1.87v2.25h3.33l-.53 3.47h-2.8v8.38C19.61 23.03 24 18.06 24 12.07z"/></svg>',
	'x'        => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24H16.17l-4.71-6.23-5.4 6.23H2.74l7.73-8.84L1.25 2.25H8.08l4.26 5.63 5.9-5.63zm-1.16 17.52h1.83L7.08 4.13H5.12l11.96 15.64z"/></svg>',
);
?>
<aside class="post-aside" aria-label="<?php esc_attr_e( 'About this news', 'iflynepal' ); ?>">
	<div class="aside-card">

		<div class="aside-block">
			<h2 class="aside-label"><?php esc_html_e( 'Contributors', 'iflynepal' ); ?></h2>
			<a class="aside-author" href="<?php echo esc_url( get_author_posts_url( $iflynepal_news_aside_author ) ); ?>">
				<?php if ( '' !== $iflynepal_news_aside_avatar ) : ?>
					<span class="post-avatar post-avatar--photo" aria-hidden="true"><img src="<?php echo esc_url( $iflynepal_news_aside_avatar ); ?>" alt="" loading="lazy"></span>
				<?php elseif ( '' !== $iflynepal_news_aside_initials ) : ?>
					<span class="post-avatar" aria-hidden="true"><?php echo esc_html( $iflynepal_news_aside_initials ); ?></span>
				<?php endif; ?>
				<span><strong><?php echo esc_html( $iflynepal_news_aside_name ); ?></strong><small><?php echo esc_html( $iflynepal_news_aside_role ); ?></small></span>
			</a>
		</div>

		<hr class="aside-rule">

		<div class="share-row">
			<div class="share-wrap">
				<button type="button" class="icon-btn share-btn" id="share-btn" aria-haspopup="true" aria-expanded="false" aria-controls="share-menu" aria-label="<?php esc_attr_e( 'Share this news', 'iflynepal' ); ?>"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><circle cx="18" cy="5" r="2.6"/><circle cx="6" cy="12" r="2.6"/><circle cx="18" cy="19" r="2.6"/><path d="m8.3 13.3 7.4 4.4M15.7 6.3 8.3 10.7"/></svg></button>
				<div class="share-menu" id="share-menu" role="menu" aria-label="<?php esc_attr_e( 'Share this news', 'iflynepal' ); ?>">
					<button type="button" role="menuitem" id="share-copy" data-url="<?php echo esc_url( $iflynepal_news_aside_share['url'] ); ?>"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><path d="M13.8 10.2a4 4 0 0 0-5.6 0l-4 4a4 4 0 1 0 5.6 5.6l1.1-1.1m-.7-4.9a4 4 0 0 0 5.6 0l4-4a4 4 0 0 0-5.6-5.6l-1.1 1.1"/></svg><span data-copied="<?php esc_attr_e( 'Link copied', 'iflynepal' ); ?>"><?php esc_html_e( 'Copy link', 'iflynepal' ); ?></span></button>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_news_aside_share['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><path d="M20.5 11.7a8.6 8.6 0 0 1-12.7 7.5L3.5 20.5l1.4-4.1a8.6 8.6 0 1 1 15.6-4.7Z"/><path d="M9.2 8.6c.2 2.9 2.7 5.5 5.6 5.8l1.2-1.2 1.9.8-.4 1.8c-4.4.3-8.8-4.1-8.5-8.5l1.8-.4.8 1.9Z"/></svg><?php esc_html_e( 'WhatsApp', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_news_aside_share['facebook'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo $iflynepal_news_aside_icons['facebook']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fixed markup declared above. ?><?php esc_html_e( 'Facebook', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_news_aside_share['x'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo $iflynepal_news_aside_icons['x']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fixed markup declared above. ?><?php esc_html_e( 'X (Twitter)', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_news_aside_share['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zm1.78 13.02H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/></svg><?php esc_html_e( 'LinkedIn', 'iflynepal' ); ?></a>
				</div>
			</div>
			<?php foreach ( $iflynepal_news_aside_socials as $iflynepal_news_aside_social ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( $iflynepal_news_aside_social['url'] ); ?>" target="_blank" rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( sprintf( /* translators: 1: author's name, 2: social network. */ __( '%1$s on %2$s', 'iflynepal' ), $iflynepal_news_aside_name, $iflynepal_news_aside_social['label'] ) ); ?>"><?php
					echo $iflynepal_news_aside_social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_author_social_links() returns fixed markup, no input.
				?></a>
			<?php endforeach; ?>
		</div>

		<?php if ( $iflynepal_news_aside_latest ) : ?>
			<hr class="aside-rule">
			<div class="aside-latest">
				<h2 class="aside-label"><?php esc_html_e( 'Latest news', 'iflynepal' ); ?></h2>
				<ol>
					<?php foreach ( $iflynepal_news_aside_latest as $iflynepal_news_aside_item ) : ?>
						<li><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $iflynepal_news_aside_item ) ); ?>"><?php echo esc_html( get_the_date( 'j M', $iflynepal_news_aside_item ) ); ?></time><a href="<?php echo esc_url( get_permalink( $iflynepal_news_aside_item ) ); ?>"><?php echo esc_html( iflynepal_article_plain_title( $iflynepal_news_aside_item ) ); ?></a></li>
					<?php endforeach; ?>
				</ol>
				<a class="aside-more" href="<?php echo esc_url( iflynepal_news_archive_url() ); ?>"><?php esc_html_e( 'All news', 'iflynepal' ); ?> <svg class="link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg></a>
			</div>
		<?php endif; ?>

	</div>
</aside>
