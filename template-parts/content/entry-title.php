<?php
/**
 * Template part for displaying a post title
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Fires immediately before the title of any post will be printed.
 *
 * @since 1.0.0
 *
 * @param string $post_type Post type of the current post.
 */
do_action( 'super_awesome_theme_before_entry_title', get_post_type() );

if ( is_singular( get_post_type() ) && (int) get_the_ID() === (int) get_queried_object_id() ) {
	the_title( '<h1 class="entry-title">', '</h1>' );
} else {
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
}

/**
 * Fires immediately after the title of any post has been printed.
 *
 * @since 1.0.0
 *
 * @param string $post_type Post type of the current post.
 */
do_action( 'super_awesome_theme_after_entry_title', get_post_type() );
