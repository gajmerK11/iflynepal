<?php
/**
 * The Blogs archive at /blogs/ — the page assigned as the Posts page.
 *
 * The same layout the Articles archive uses, drawing this section's posts and
 * categories; see the layout part for what it is made of, and inc/sections.php
 * for how one set of templates serves both sections.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'template-parts/articles/archive-layout' );
