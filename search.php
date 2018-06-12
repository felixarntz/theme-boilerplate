<?php
/**
 * The template for displaying search results pages
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

get_header();

?>

			<main id="main" class="site-main">

				<?php
				if ( have_posts() ) {
					get_template_part( 'template-parts/header/generic-page-header' );

					while ( have_posts() ) {
						the_post();

						if ( super_awesome_theme_use_post_format_templates() ) {
							get_template_part( 'template-parts/content/content-' . get_post_type(), get_post_format() );
						} else {
							get_template_part( 'template-parts/content/content', get_post_type() );
						}
					}

					the_posts_navigation();
				} else {
					get_template_part( 'template-parts/content/none' );
				}
				?>

			</main><!-- #main -->

<?php

get_sidebar();
get_footer();
