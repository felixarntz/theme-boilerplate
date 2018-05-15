<?php
/**
 * Theme setup
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various WordPress features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_setup() {

	// TODO: Add theme support for starter content.

	add_image_size( 'site-width', 1152, 9999 ); // Spans the site maximum width of 72rem, with unlimited height.
	add_image_size( 'content-width', 640, 9999 ); // Spans the content maximum width of 40rem, with unlimited height.

	set_post_thumbnail_size( 640, 360, true ); // 640px is 40rem, which is the site maximum width. 360px makes it 16:9 format.

	add_editor_style();
}
add_action( 'after_setup_theme', 'super_awesome_theme_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 *
 * @global int $content_width
 */
function super_awesome_theme_content_width() {
	global $content_width;

	/**
	 * Filters the theme's content width.
	 *
	 * @since 1.0.0
	 *
	 * @param int $content_width The theme's content width.
	 */
	$content_width = apply_filters( 'super_awesome_theme_content_width', 640 ); // 640px is 40rem, which is the content maximum width.
}
add_action( 'after_setup_theme', 'super_awesome_theme_content_width', 0 );
