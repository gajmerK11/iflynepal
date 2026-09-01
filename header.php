<?php
/**
 * Header: document head, opening body, and the site header bar.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="iflynepal-skip" href="#primary"><?php esc_html_e( 'Skip to content', 'iflynepal' ); ?></a>

<header id="iflynepal-header" class="site-header fixed inset-x-0 top-0 z-50 text-white transition-[background,box-shadow] duration-[400ms] ease-out">
	<div class="iflynepal-container iflynepal-nav">

		<?php get_template_part( 'template-parts/header/site-branding' ); ?>
		<?php get_template_part( 'template-parts/header/site-navigation' ); ?>

	</div>
</header>
