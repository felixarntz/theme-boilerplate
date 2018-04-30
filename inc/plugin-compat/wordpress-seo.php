<?php
/**
 * Yoast SEO compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

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
