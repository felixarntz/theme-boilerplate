<?php
/**
 * The template for displaying the generic page header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( super_awesome_theme_use_page_header() ) {
	return;
}

?>

				<header class="generic-page-header">
					<?php get_template_part( 'template-parts/header/page-header-content' ); ?>
				</header><!-- .generic-page-header -->
