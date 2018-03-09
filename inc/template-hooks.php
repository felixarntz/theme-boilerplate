<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Handles JavaScript and SVG detection.
 *
 * @since 1.0.0
 */
function super_awesome_theme_js_svg_detection() {
	?>
	<script>
		(function( html ) {
			function supportsInlineSVG() {
				var div = document.createElement( 'div' );
				div.innerHTML = '<svg/>';
				return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
			}

			html.className = html.className.replace( /(\s*)no-js(\s*)/, '$1js$2' );

			if ( true === supportsInlineSVG() ) {
				html.className = html.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
			}
		})( document.documentElement );
	</script>
	<?php
}
add_action( 'wp_head', 'super_awesome_theme_js_svg_detection', 0 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the body element.
 * @return array Modified classes.
 */
function super_awesome_theme_body_classes( $classes ) {
	// Adds a class to indicate that a wrapped layout is used.
	if ( super_awesome_theme_use_wrapped_layout() ) {
		$classes[] = 'wrapped-layout';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class to indicate the sidebar mode.
	if ( ! super_awesome_theme_display_sidebar() ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = get_theme_mod( 'sidebar_mode', 'right-sidebar' );
	}

	// Adds a class to indicate the sidebar size.
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

/**
 * Disable core styles for the special 'wp-signup.php' and 'wp-activate.php' pages.
 *
 * @since 1.0.0
 *
 * @param string $name Identifier of the header to load.
 */
function super_awesome_theme_disable_special_page_styles( $name ) {
	if ( 'wp-signup' === $name ) {
		remove_action( 'wp_head', 'wpmu_signup_stylesheet' );
	} elseif ( 'wp-activate' === $name ) {
		remove_action( 'wp_head', 'wpmu_activate_stylesheet' );
	}
}
add_action( 'get_header', 'super_awesome_theme_disable_special_page_styles' );

/**
 * Sets up global attachment metadata.
 *
 * This is a utility hook to make the super_awesome_theme_get_attachment_metadata() function
 * more performant when in the loop.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_attachment_metadata Metadata array for the current post.
 *
 * @param WP_Post $post Post object.
 */
function super_awesome_theme_setup_attachment_metadata( $post ) {
	global $super_awesome_theme_attachment_metadata;

	if ( 'attachment' === $post->post_type ) {
		$super_awesome_theme_attachment_metadata = super_awesome_theme_get_attachment_metadata( $post->ID );
		$super_awesome_theme_attachment_metadata['_id'] = $post->ID;
	} elseif ( isset( $super_awesome_theme_attachment_metadata ) ) {
		unset( $super_awesome_theme_attachment_metadata );
	}
}
add_action( 'the_post', 'super_awesome_theme_setup_attachment_metadata' );
