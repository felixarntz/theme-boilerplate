<?php
/**
 * Asset management functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function super_awesome_theme_enqueue_assets() {
	wp_enqueue_style( 'super-awesome-theme-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'super-awesome-theme-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), SUPER_AWESOME_THEME_VERSION, true );

	wp_enqueue_script( 'super-awesome-theme-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), SUPER_AWESOME_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'super_awesome_theme_enqueue_assets' );
