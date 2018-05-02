<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the body element.
 * @return array Modified classes.
 */
function super_awesome_theme_body_classes( $classes ) {
	// Add a class to indicate that a wrapped layout is used.
	if ( super_awesome_theme_use_wrapped_layout() ) {
		$classes[] = 'wrapped-layout';
	}

	// Add a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add a class to indicate that a custom header image is set.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class to indicate the sidebar mode.
	if ( ! super_awesome_theme_display_sidebar() ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = get_theme_mod( 'sidebar_mode', 'right-sidebar' );
	}

	// Add a class to indicate the sidebar size.
	$classes[] = 'sidebar-' . get_theme_mod( 'sidebar_size', 'medium' );

	return $classes;
}
add_filter( 'body_class', 'super_awesome_theme_body_classes' );

/**
 * Adds a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since 1.0.0
 */
function super_awesome_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'super_awesome_theme_pingback_header' );

/**
 * Replaces the "[...]" used for automatically generated excerpts with an accessible 'Continue reading' link.
 *
 * @since 1.0.0
 *
 * @return string Accessible 'Continue reading' link prepended with an ellipsis.
 */
function super_awesome_theme_excerpt_more() {
	$link = sprintf(
		wp_kses(
			/* translators: %s: post title */
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'super-awesome-theme' ),
			array(
				'span' => array(
					'class' => array(),
				),
			)
		),
		get_the_title()
	);

	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'super_awesome_theme_excerpt_more' );
