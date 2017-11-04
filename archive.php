<?php
/**
 * The template for displaying archive pages
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

get_header();

?>

	<main id="main" class="site-main">

	<?php
	if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<?php
		while ( have_posts() ) : the_post();

			if ( super_awesome_theme_use_post_format_templates() ) :
				get_template_part( 'template-parts/content/content-' . get_post_type(), get_post_format() );
			else :
				get_template_part( 'template-parts/content/content', get_post_type() );
			endif;

		endwhile;

		the_posts_navigation();

	else :

		get_template_part( 'template-parts/content/none' );

	endif; ?>

	</main><!-- #main -->

<?php

get_sidebar();
get_footer();
