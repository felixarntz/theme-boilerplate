<?php
/**
 * Super Awesome Theme functions and definitions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

define( 'SUPER_AWESOME_THEME_VERSION', '1.0.0' );

/**
 * Loads the theme's textdomain.
 *
 * @since 1.0.0
 */
function super_awesome_theme_load_textdomain() {
	load_theme_textdomain( 'super-awesome-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'super_awesome_theme_load_textdomain', 0 );

/**
 * The theme only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Library loader.
 */
require get_template_directory() . '/inc/library.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * Additional theme functions to use from within templates.
 */
require get_template_directory() . '/inc/template-functions.php';

super_awesome_theme()
	->register_component( new Super_Awesome_Theme_Theme_Support() )
	->register_component( new Super_Awesome_Theme_Settings() )
	->register_component( new Super_Awesome_Theme_Assets() )
	->register_component( new Super_Awesome_Theme_Customizer() )
	->register_component( new Super_Awesome_Theme_Colors() )
	->register_component( new Super_Awesome_Theme_Font_Families() )
	->register_component( new Super_Awesome_Theme_Fonts() )
	->register_component( new Super_Awesome_Theme_Custom_Logo() )
	->register_component( new Super_Awesome_Theme_Custom_Header() )
	->register_component( new Super_Awesome_Theme_Custom_Background() )
	->register_component( new Super_Awesome_Theme_Distraction_Free_Mode() )
	->register_component( new Super_Awesome_Theme_Sticky_Elements() )
	->register_component( new Super_Awesome_Theme_Comments() )
	->register_component( new Super_Awesome_Theme_Widgets() )
	->register_component( new Super_Awesome_Theme_Menus() )
	->register_component( new Super_Awesome_Theme_Icons() )
	->register_component( new Super_Awesome_Theme_Content_Types() )
	->register_component( new Super_Awesome_Theme_Sidebar() )
	->register_component( new Super_Awesome_Theme_Navbar() )
	->register_component( new Super_Awesome_Theme_Top_Bar() )
	->register_component( new Super_Awesome_Theme_Bottom_Bar() )
	->register_component( new Super_Awesome_Theme_Footer_Widget_Areas() )
	->register_component( new Super_Awesome_Theme_Social_Navigation() )
	->register_component( new Super_Awesome_Theme_Footer_Navigation() )
	->register_component( new Super_Awesome_Theme_Image_Sizes() )
	->register_component( new Super_Awesome_Theme_AMP() )
	->resolve_dependencies()
	->initialize();

/**
 * Plugin compatibility.
 */
require get_template_directory() . '/inc/plugin-compat.php';
