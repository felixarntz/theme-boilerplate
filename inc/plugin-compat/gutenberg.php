<?php
/**
 * Gutenberg compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various Gutenberg features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_gutenberg_setup() {
	$theme_colors = array(
		get_theme_mod( 'text_color', '#404040' ),
		super_awesome_theme_darken_color( get_theme_mod( 'text_color', '#404040' ), 25 ),
		super_awesome_theme_lighten_color( get_theme_mod( 'text_color', '#404040' ), 100 ),
		get_theme_mod( 'link_color', '#21759b' ),
		super_awesome_theme_darken_color( get_theme_mod( 'link_color', '#21759b' ), 25 ),
		get_theme_mod( 'wrap_background_color', '' ),
		get_theme_mod( 'button_text_color', '#404040' ),
		get_theme_mod( 'button_background_color', '#e6e6e6' ),
		super_awesome_theme_darken_color( get_theme_mod( 'button_background_color', '#e6e6e6' ), 25 ),
		get_theme_mod( 'button_primary_text_color', '#ffffff' ),
		get_theme_mod( 'button_primary_background_color', '#21759b' ),
		super_awesome_theme_darken_color( get_theme_mod( 'button_primary_background_color', '#21759b' ), 25 ),
	);
	$theme_colors = array_unique( $theme_colors );

	add_theme_support( 'align-wide' );
	add_theme_support( 'disable-custom-colors' );

	call_user_func_array( 'add_theme_support', array_merge( array( 'editor-color-palette' ), $theme_colors ) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_gutenberg_setup' );

/**
 * Enqueues the theme's Gutenberg editor stylesheet.
 *
 * @since 1.0.0
 */
function super_awesome_theme_gutenberg_enqueue_editor_style() {
	wp_enqueue_style( 'super-awesome-theme-block-editor-style', get_theme_file_uri( '/block-editor-style.css' ), array(), SUPER_AWESOME_THEME_VERSION );
	wp_style_add_data( 'super-awesome-theme-block-editor-style', 'rtl', 'replace' );
}
add_action( 'enqueue_block_editor_assets', 'super_awesome_theme_gutenberg_enqueue_editor_style' );
