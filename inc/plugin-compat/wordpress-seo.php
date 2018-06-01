<?php
/**
 * Yoast SEO compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Outputs the Yoast SEO breadcrumbs as applicable.
 *
 * @since 1.0.0
 */
function super_awesome_theme_yoast_seo_display_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		$before = '<nav id="site-breadcrumbs" class="site-breadcrumbs site-component" aria-label="' . esc_attr_x( 'You are here:', 'breadcrumbs', 'super-awesome-theme' ) . '"><div class="site-component-inner">';
		$after  = '</div></nav>';

		yoast_breadcrumb( $before, $after );
	}
}
add_action( 'super_awesome_theme_after_header', 'super_awesome_theme_yoast_seo_display_breadcrumbs' );

/**
 * Removes the author posts link from the authorbox if author archives are disabled.
 *
 * @since 1.0.0
 *
 * @param bool $result Whether the author posts link should be displayed for the post.
 * @return bool Possibly modified $result.
 */
function super_awesome_theme_yoast_seo_maybe_remove_author_posts_link( $result ) {
	if ( WPSEO_Options::get( 'disable-author', false ) ) {
		$result = false;
	}

	return $result;
}
add_filter( 'super_awesome_theme_display_author_posts_link', 'super_awesome_theme_yoast_seo_maybe_remove_author_posts_link' );
