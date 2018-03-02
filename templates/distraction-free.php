<?php
/**
 * Template Name: Distraction Free Page
 *
 * Distraction-free template that uses the distraction-free primary navigation
 * and displays neither a sidebar nor footer widgets.
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

// This file should match the `singular.php` template exactly.
get_header();

?>

		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				if ( super_awesome_theme_use_post_format_templates() ) :
					get_template_part( 'template-parts/content/content-' . get_post_type(), get_post_format() );
				else :
					get_template_part( 'template-parts/content/content', get_post_type() );
				endif;

				if ( super_awesome_theme_display_post_navigation() ) :
					the_post_navigation();
				endif;

				if ( super_awesome_theme_display_post_comments() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

<?php

get_sidebar();
get_footer();
