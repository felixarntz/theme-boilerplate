<?php
/**
 * WP Subtitle compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Prints the subtitle for any post.
 *
 * @since 1.0.0
 */
function super_awesome_theme_wp_subtitle_print_post_subtitle() {
	if ( is_singular() ) {
		the_subtitle( '<p class="entry-subtitle">', '</p>' );
	} else {
		the_subtitle( '<p class="entry-subtitle"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></p>' );
	}
}
add_action( 'super_awesome_theme_after_entry_title', 'super_awesome_theme_wp_subtitle_print_post_subtitle' );
