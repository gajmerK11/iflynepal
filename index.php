<?php
/**
 * The main template file — required fallback.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		echo '<p>' . esc_html__( 'Nothing found.', 'iflynepal' ) . '</p>';
	}
	?>
</main><!-- #primary -->

<?php
get_footer();
