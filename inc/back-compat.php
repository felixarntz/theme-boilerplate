<?php
/**
 * Back compatibility functions for WordPress versions prior to 4.7
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Prevents switching to the theme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since 1.0.0
 */
function super_awesome_theme_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'super_awesome_theme_upgrade_notice' );
}
add_action( 'after_switch_theme', 'super_awesome_theme_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to the theme
 * on WordPress versions prior to 4.7.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function super_awesome_theme_upgrade_notice() {
	$message = sprintf( __( 'Super Awesome Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'super-awesome-theme' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function super_awesome_theme_customize() {
	wp_die( sprintf( __( 'Super Awesome Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'super-awesome-theme' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'super_awesome_theme_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function super_awesome_theme_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Super Awesome Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'super-awesome-theme' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'super_awesome_theme_preview' );
