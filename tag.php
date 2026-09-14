<?php
/**
 * One blog tag, at /blog-tag/{tag}/.
 *
 * The archive templates all render the same page; see the layout part for what
 * it is made of. A tag has no tab row of its own — the tabs are the category
 * list — and the design draws the page the same way either way.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'template-parts/articles/archive-layout' );
