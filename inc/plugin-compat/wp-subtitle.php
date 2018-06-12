<?php
/**
 * WP Subtitle compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Prints the subtitle for any post.
 *
 * @since 1.0.0
 */
function super_awesome_theme_wp_subtitle_print_post_subtitle() {
	if ( is_singular() ) {
		the_subtitle( '<div class="entry-subtitle">', '</div>' );
	} else {
		the_subtitle( '<div class="entry-subtitle"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></div>' );
	}
}
add_action( 'super_awesome_theme_after_entry_title', 'super_awesome_theme_wp_subtitle_print_post_subtitle' );
