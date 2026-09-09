<?php
/**
 * Template Name: Cookie Policy
 *
 * The Cookie Policy page, built from fixed template parts rather than editor
 * content — the same arrangement page-terms-and-conditions.php uses.
 * Assign it to a page under Page Attributes > Template.
 *
 * Only the hero photograph is editable (Customizer > Cookie Policy). The
 * policy itself is a published document: it is agreed and republished as a
 * whole, so it lives in the template parts rather than in theme mods.
 *
 * There is no closing card. The page ends on the policy, and the footer's own
 * office block is directly below it.
 *
 * Named `page-cookie-policy.php` so a page whose slug is "cookie-policy" — the
 * URL the live site publishes and the footer links to — picks it up on its own
 * as well, per the theme's WP-native template naming.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/cookie/hero-section' );
	get_template_part( 'template-parts/cookie/types-section' );
	get_template_part( 'template-parts/cookie/clauses-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
