<?php
/**
 * The template for displaying any single post
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

get_header(); ?>

	<div id="primary" class="content-area">
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
	</div><!-- #primary -->

<?php
if ( super_awesome_theme_display_sidebar() ) {
	get_sidebar( super_awesome_theme_get_sidebar_name() );
}

get_footer();
