<?php
/**
 * Super Awesome Theme functions and definitions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
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
 * Theme setup.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Asset management functions.
 */
require get_template_directory() . '/inc/assets.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * Additional theme functions to use from within templates.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Jetpack compatibility.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
