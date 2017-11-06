<?php
/**
 * Plugin compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Jetpack compatibility.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/plugin-compat/jetpack.php';
}

/**
 * Easy Digital Downloads compatibility.
 */
if ( function_exists( 'EDD' ) ) {
	require get_template_directory() . '/inc/plugin-compat/easy-digital-downloads.php';
}

/**
 * WP Subtitle compatibility.
 */
if ( function_exists( 'the_subtitle' ) ) {
	require get_template_directory() . '/inc/plugin-compat/wp-subtitle.php';
}

/**
 * WP Ajaxify Comments compatibility.
 */
if ( defined( 'WPAC_PLUGIN_NAME' ) ) {
	require get_template_directory() . '/inc/plugin-compat/wp-ajaxify-comments.php';
}

/**
 * Gutenberg compatibility.
 */
if ( defined( 'GUTENBERG_VERSION' ) ) {
	require get_template_directory() . '/inc/plugin-compat/gutenberg.php';
}
