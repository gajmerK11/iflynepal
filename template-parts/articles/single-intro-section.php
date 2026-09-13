<?php
/**
 * Under the single article's hero: the breadcrumb, then the date and the
 * reading time, with a rule under them.
 *
 * The design's markup, class for class.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$iflynepal_intro_category = iflynepal_article_primary_category( get_the_ID() );
$iflynepal_intro_minutes  = iflynepal_article_read_minutes();
?>
<div class="post-intro">
	<div class="container">

		<nav class="post-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iflynepal' ); ?>" data-anim>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iflynepal' ); ?></a><svg class="crumb-sep" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
			<a href="<?php echo esc_url( iflynepal_articles_archive_url() ); ?>"><?php esc_html_e( 'Articles', 'iflynepal' ); ?></a><?php
			if ( $iflynepal_intro_category ) {
				printf(
					'<svg class="crumb-sep" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg><a href="%1$s">%2$s</a>',
					esc_url( get_term_link( $iflynepal_intro_category ) ),
					esc_html( $iflynepal_intro_category->name )
				);
			}
			?><svg class="crumb-sep" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
			<span aria-current="page"><?php echo esc_html( iflynepal_article_plain_title() ); ?></span>
		</nav>

		<div class="post-meta-row" data-anim>
			<span><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15" rx="3"/><path d="M8 3v4M16 3v4M3.5 10h17"/></svg><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time></span>
			<i class="dot" aria-hidden="true"></i>
			<span><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg><?php
			printf(
				/* translators: %s: number of minutes. */
				esc_html__( '%s min read', 'iflynepal' ),
				esc_html( number_format_i18n( $iflynepal_intro_minutes ) )
			);
			?></span>
		</div>

	</div>
</div>
