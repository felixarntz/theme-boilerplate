<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Global used to access sidebar registration data.
 *
 * @global array $wp_registered_sidebars Associative array of registered sidebars.
 */
global $wp_registered_sidebars;

if ( ! super_awesome_theme_should_display_sidebar() ) {
	return;
}

$sidebar_slug = super_awesome_theme_get_sidebar_name();

if ( ! super_awesome_theme_is_widget_area_active( $sidebar_slug ) ) {
	return;
}

$sidebar_title = __( 'Primary Sidebar', 'super-awesome-theme' );
if ( isset( $wp_registered_sidebars[ $sidebar_slug ] ) ) {
	$sidebar_title = $wp_registered_sidebars[ $sidebar_slug ]['name'];
}

?>

			<aside id="sidebar" class="site-sidebar widget-area" aria-label="<?php echo esc_attr( $sidebar_title ); ?>">
				<?php super_awesome_theme_render_widget_area( $sidebar_slug ); ?>
			</aside><!-- #sidebar -->
