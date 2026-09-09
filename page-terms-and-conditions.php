<?php
/**
 * Template Name: Terms & Conditions
 *
 * The Terms & Conditions page, built from fixed template parts rather than
 * editor content — the same arrangement front-page.php and page-about.php use.
 * Assign it to a page under Page Attributes > Template.
 *
 * Unlike the other page templates, this one has **no Customizer section**. It
 * is a legal document: the wording is agreed as a whole and republished as a
 * whole, so it lives in the template parts rather than in theme mods. The one
 * thing it does read from settings is the head office block in the closing
 * card, borrowed from the footer's own so the phone number exists once.
 *
 * Named `page-terms-and-conditions.php` so a page whose slug is
 * "terms-and-conditions" — the URL the live site publishes and the footer
 * links to — picks it up on its own as well, per the theme's WP-native
 * template naming.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/terms/hero-section' );
	get_template_part( 'template-parts/terms/clauses-section' );
	get_template_part( 'template-parts/terms/contact-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
