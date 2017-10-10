<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
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
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class to indicate the sidebar mode.
	$classes[] = get_theme_mod( 'sidebar_mode', 'right-sidebar' );

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
