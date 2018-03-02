<?php
/**
 * The template for displaying the primary site navigation in the header
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$menu_slug = super_awesome_theme_get_navigation_name();

if ( ! has_nav_menu( $menu_slug ) ) {
	return;
}

?>
<nav id="site-navigation" class="main-navigation site-component" aria-label="<?php esc_attr_e( 'Primary Menu', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<?php
			echo super_awesome_theme_get_svg( 'bars' ); // WPCS: XSS OK.
			echo super_awesome_theme_get_svg( 'close' ); // WPCS: XSS OK.
			esc_html_e( 'Menu', 'super-awesome-theme' );
			?>
		</button>
		<?php
		/**
		 * Fires immediately before the site navigation will be printed.
		 *
		 * @since 1.0.0
		 */
		do_action( 'super_awesome_theme_before_site_navigation' );

		wp_nav_menu( array(
			'theme_location' => $menu_slug,
			'menu_id'        => 'primary-menu',
			'container'      => false,
		) );

		/**
		 * Fires immediately after the site navigation has been printed.
		 *
		 * @since 1.0.0
		 */
		do_action( 'super_awesome_theme_after_site_navigation' );
		?>
	</div>
</nav><!-- #site-navigation -->
