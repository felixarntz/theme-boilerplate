<?php
/**
 * Plugin compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Jetpack compatibility.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/plugin-compat/jetpack.php';
}

/**
 * WooCommerce compatibility.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/plugin-compat/woocommerce.php';
}

/**
 * Easy Digital Downloads compatibility.
 */
if ( function_exists( 'EDD' ) ) {
	require get_template_directory() . '/inc/plugin-compat/easy-digital-downloads.php';
}

/**
 * WP Site Identity compatibility.
 */
if ( function_exists( 'wpsi' ) ) {
	require get_template_directory() . '/inc/plugin-compat/wp-site-identity.php';
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
if ( function_exists( 'register_block_type' ) ) {
	require get_template_directory() . '/inc/plugin-compat/gutenberg.php';
}

/**
 * Torro Forms compatibility.
 */
if ( function_exists( 'torro' ) ) {
	require get_template_directory() . '/inc/plugin-compat/torro-forms.php';
}

/**
 * Yoast SEO compatibility.
 */
if ( defined( 'WPSEO_VERSION' ) ) {
	require get_template_directory() . '/inc/plugin-compat/wordpress-seo.php';
}
