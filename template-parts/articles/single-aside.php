<?php
/**
 * The single article's sticky sidebar: who wrote it, where to share it, and
 * the table of contents.
 *
 * The design's markup, class for class. The index is built from the h2s in the
 * rendered body — see iflynepal_article_body(), which gives each of them an id
 * on the way past — so an editor never has to keep a list in step with the
 * piece.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 *
 * @var array $args {
 *     @type array $headings Index entries, each with 'id' and 'text'.
 * }
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_aside_headings = isset( $args['headings'] ) ? (array) $args['headings'] : array();
$iflynepal_aside_author   = (int) get_the_author_meta( 'ID' );
$iflynepal_aside_name     = get_the_author();
$iflynepal_aside_initials = iflynepal_article_initials( $iflynepal_aside_name );
$iflynepal_aside_role     = iflynepal_author_role( $iflynepal_aside_author );
$iflynepal_aside_share    = iflynepal_article_share_links();

/*
 * The author's own photo (iFly Nepal Author Profile), same field the Authors
 * pages read, not a Gravatar: this team's accounts are a house byline as
 * often as a person, so there is nothing to request one for.
 */
$iflynepal_aside_photo_id = iflynepal_author_photo_id( $iflynepal_aside_author );
$iflynepal_aside_avatar   = $iflynepal_aside_photo_id ? (string) wp_get_attachment_image_url( $iflynepal_aside_photo_id, 'thumbnail' ) : '';

/*
 * This author's own social links (iFly Nepal Author Profile), not the site's
 * own brand accounts the footer's follow row reads — see inc/authors.php's
 * iflynepal_author_social_links(), which already leaves out whichever
 * networks this author left blank.
 */
$iflynepal_aside_socials = iflynepal_author_social_links( $iflynepal_aside_author );

/* The share menu's own two brand icons; the follow row above uses each social's own icon. */
$iflynepal_aside_icons = array(
	'facebook' => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M24 12.07C24 5.44 18.63.07 12 .07S0 5.44 0 12.07c0 5.99 4.39 10.95 10.13 11.85v-8.38H7.08v-3.47h3.05V9.43c0-3 1.79-4.67 4.53-4.67 1.31 0 2.69.24 2.69.24v2.95h-1.52c-1.49 0-1.95.92-1.95 1.87v2.25h3.33l-.53 3.47h-2.8v8.38C19.61 23.03 24 18.06 24 12.07z"/></svg>',
	'x'        => '<svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24H16.17l-4.71-6.23-5.4 6.23H2.74l7.73-8.84L1.25 2.25H8.08l4.26 5.63 5.9-5.63zm-1.16 17.52h1.83L7.08 4.13H5.12l11.96 15.64z"/></svg>',
);
?>
<aside class="post-aside" aria-label="<?php echo esc_attr( iflynepal_section_labels()['aside_about'] ); ?>">
	<div class="aside-card">

		<div class="aside-block">
			<h2 class="aside-label"><?php esc_html_e( 'Contributors', 'iflynepal' ); ?></h2>
			<a class="aside-author" href="<?php echo esc_url( get_author_posts_url( $iflynepal_aside_author ) ); ?>">
				<?php if ( '' !== $iflynepal_aside_avatar ) : ?>
					<span class="post-avatar post-avatar--photo" aria-hidden="true"><img src="<?php echo esc_url( $iflynepal_aside_avatar ); ?>" alt="" loading="lazy"></span>
				<?php elseif ( '' !== $iflynepal_aside_initials ) : ?>
					<span class="post-avatar" aria-hidden="true"><?php echo esc_html( $iflynepal_aside_initials ); ?></span>
				<?php endif; ?>
				<span><strong><?php echo esc_html( $iflynepal_aside_name ); ?></strong><small><?php echo esc_html( $iflynepal_aside_role ); ?></small></span>
			</a>
		</div>

		<hr class="aside-rule">

		<div class="share-row">
			<div class="share-wrap">
				<button type="button" class="icon-btn share-btn" id="share-btn" aria-haspopup="true" aria-expanded="false" aria-controls="share-menu" aria-label="<?php esc_attr_e( 'Share this article', 'iflynepal' ); ?>"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><circle cx="18" cy="5" r="2.6"/><circle cx="6" cy="12" r="2.6"/><circle cx="18" cy="19" r="2.6"/><path d="m8.3 13.3 7.4 4.4M15.7 6.3 8.3 10.7"/></svg></button>
				<div class="share-menu" id="share-menu" role="menu" aria-label="<?php esc_attr_e( 'Share this article', 'iflynepal' ); ?>">
					<button type="button" role="menuitem" id="share-copy" data-url="<?php echo esc_url( $iflynepal_aside_share['url'] ); ?>"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><path d="M13.8 10.2a4 4 0 0 0-5.6 0l-4 4a4 4 0 1 0 5.6 5.6l1.1-1.1m-.7-4.9a4 4 0 0 0 5.6 0l4-4a4 4 0 0 0-5.6-5.6l-1.1 1.1"/></svg><span data-copied="<?php esc_attr_e( 'Link copied', 'iflynepal' ); ?>"><?php esc_html_e( 'Copy link', 'iflynepal' ); ?></span></button>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_aside_share['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" class="ico-line" aria-hidden="true"><path d="M20.5 11.7a8.6 8.6 0 0 1-12.7 7.5L3.5 20.5l1.4-4.1a8.6 8.6 0 1 1 15.6-4.7Z"/><path d="M9.2 8.6c.2 2.9 2.7 5.5 5.6 5.8l1.2-1.2 1.9.8-.4 1.8c-4.4.3-8.8-4.1-8.5-8.5l1.8-.4.8 1.9Z"/></svg><?php esc_html_e( 'WhatsApp', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_aside_share['facebook'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo $iflynepal_aside_icons['facebook']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fixed markup declared above. ?><?php esc_html_e( 'Facebook', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_aside_share['x'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo $iflynepal_aside_icons['x']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fixed markup declared above. ?><?php esc_html_e( 'X (Twitter)', 'iflynepal' ); ?></a>
					<a role="menuitem" href="<?php echo esc_url( $iflynepal_aside_share['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" class="ico-solid" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zm1.78 13.02H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/></svg><?php esc_html_e( 'LinkedIn', 'iflynepal' ); ?></a>
				</div>
			</div>
			<?php foreach ( $iflynepal_aside_socials as $iflynepal_aside_social ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( $iflynepal_aside_social['url'] ); ?>" target="_blank" rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( sprintf( /* translators: 1: author's name, 2: social network. */ __( '%1$s on %2$s', 'iflynepal' ), $iflynepal_aside_name, $iflynepal_aside_social['label'] ) ); ?>"><?php
					echo $iflynepal_aside_social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iflynepal_author_social_links() returns fixed markup, no input.
				?></a>
			<?php endforeach; ?>
		</div>

		<?php if ( $iflynepal_aside_headings ) : ?>
			<hr class="aside-rule">
			<div class="aside-toc">
				<h2 class="aside-label" id="toc-title"><?php esc_html_e( 'On this page', 'iflynepal' ); ?></h2>
				<nav class="index-list" id="cc-toc-list" aria-labelledby="toc-title">
					<?php foreach ( $iflynepal_aside_headings as $iflynepal_aside_heading ) : ?>
						<a <?php echo iflynepal_anchor_attr( '#' . $iflynepal_aside_heading['id'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper. ?>><?php echo esc_html( $iflynepal_aside_heading['text'] ); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>
		<?php endif; ?>

	</div>
</aside>
