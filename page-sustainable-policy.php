<?php
/**
 * Template Name: Sustainability Policy
 *
 * The Sustainability Policy page, built from fixed template parts rather than
 * editor content — the same arrangement as the Terms & Conditions, Cookie
 * Policy and Privacy Policy pages. Assign it to a page under Page Attributes >
 * Template.
 *
 * Editable in Customizer > Sustainability Policy: the hero photograph and the
 * Sustainability Coordinator card. The policy itself is a published document:
 * it is agreed and republished as a whole, so it lives in the template parts
 * rather than in theme mods.
 *
 * There is no closing card. The page ends on the policy, and the footer's own
 * office block is directly below it.
 *
 * Named `page-sustainable-policy.php` — "sustainable", not "sustainability" —
 * because that is the slug the live site publishes and the footer and the
 * Terms page link to, and a page with that slug picks the template up on its
 * own, per the theme's WP-native template naming.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/sustainability/hero-section' );
	get_template_part( 'template-parts/sustainability/pledge-section' );
	get_template_part( 'template-parts/sustainability/clauses-section' );
	?>
</main><!-- #primary -->

<?php
get_footer();
