<?php
/**
 * Template Name: Privacy Policy
 *
 * The Privacy Policy page, built from fixed template parts rather than editor
 * content — the same arrangement page-terms-and-conditions.php and
 * page-cookie-policy.php use. Assign it to a page under Page Attributes >
 * Template.
 *
 * Only the hero photograph is editable (Customizer > Privacy Policy). The
 * policy itself is a published document: it is agreed and republished as a
 * whole, so it lives in the template parts rather than in theme mods.
 *
 * There is no closing card. The page ends on the policy, and the footer's own
 * office block is directly below it.
 *
 * Named `page-privacy-policy.php` so a page whose slug is "privacy-policy" —
 * the URL the live site publishes, the footer links to and WordPress itself
 * suggests for its privacy page — picks it up on its own as well, per the
 * theme's WP-native template naming.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/privacy/hero-section' );
	get_template_part( 'template-parts/privacy/clauses-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
