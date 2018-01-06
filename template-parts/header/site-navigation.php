<?php
/**
 * The template for displaying the primary site navigation in the header
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$menu_slug = super_awesome_theme_get_navigation_name();

if ( ! has_nav_menu( $menu_slug ) ) {
	return;
}

?>
<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'super-awesome-theme' ); ?>">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<?php
		echo super_awesome_theme_get_svg( 'bars' );
		echo super_awesome_theme_get_svg( 'close' );
		esc_html_e( 'Menu', 'super-awesome-theme' );
		?>
	</button>
	<?php
	wp_nav_menu( array(
		'theme_location' => $menu_slug,
		'menu_id'        => 'primary-menu',
		'container'      => false,
	) );
	?>
</nav><!-- #site-navigation -->
