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
	$text_color       = get_theme_mod( 'text_color', '#404040' );
	$link_color       = get_theme_mod( 'link_color', '#21759b' );
	$link_hover_color = super_awesome_theme_darken_color( $link_color, 8 );

	add_theme_support( 'align-wide' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-color-palette',
		'#ffffff',
		'#f1f1f1',
		$text_color,
		$link_color,
		$link_hover_color
	);
}
add_action( 'after_setup_theme', 'super_awesome_theme_gutenberg_setup' );
