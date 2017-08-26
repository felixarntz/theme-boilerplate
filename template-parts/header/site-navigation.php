<?php
/**
 * The template for displaying the primary site navigation in the header
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

?>
<nav id="site-navigation" class="main-navigation">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'super-awesome-theme' ); ?></button>
	<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
		) );
	?>
</nav><!-- #site-navigation -->
