<?php
/*
Template Name: Blank Page
*/

/**
 * @package WordPress_Theme
 */

get_header();

	// Start the Loop.
	while ( have_posts() ) : the_post();
		// Include the page content template.
		get_template_part( 'template-parts/content', 'bare' );
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;

get_footer();
