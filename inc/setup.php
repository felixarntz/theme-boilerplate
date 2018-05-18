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
	add_image_size( 'site-width', 1152, 9999 ); // Spans the site maximum width of 72rem, with unlimited height.
	add_image_size( 'content-width', 640, 9999 ); // Spans the content maximum width of 40rem, with unlimited height.

	set_post_thumbnail_size( 640, 360, true ); // 640px is 40rem, which is the site maximum width. 360px makes it 16:9 format.
}
add_action( 'after_setup_theme', 'super_awesome_theme_setup' );
