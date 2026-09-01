<?php
/**
 * iFly Nepal theme bootstrap.
 *
 * Loads the theme's feature files. All logic lives in inc/.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'IFLYNEPAL_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'IFLYNEPAL_DIR', get_template_directory() );
define( 'IFLYNEPAL_URI', get_template_directory_uri() );

require_once IFLYNEPAL_DIR . '/inc/setup.php';
require_once IFLYNEPAL_DIR . '/inc/enqueue.php';
require_once IFLYNEPAL_DIR . '/inc/template-tags.php';
require_once IFLYNEPAL_DIR . '/inc/template-functions.php';
require_once IFLYNEPAL_DIR . '/inc/customizer.php';
