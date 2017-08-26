<?php
/**
 * Additional theme functions to use from within templates
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Loads a template part into a template.
 *
 * In addition to the similar core function it supports passing arbitrary data to the template.
 *
 * @since 1.0.0
 *
 * @global WP_Query $wp_query Main query.
 *
 * @param string $slug The slug name for the generic template.
 * @param string $name Optional. The name of the specialized template. Default null.
 * @param mixed  $data Optional. Arbitrary data to pass to the template. The data will be available
 *                     in a $data variable. Default null.
 */
function super_awesome_theme_get_template_part( $slug, $name = null, $data = null ) {
	global $wp_query;

	$do_change = false;
	if ( null !== $data ) {
		$do_change = true;

		$query_set = true;
		if ( ! isset( $wp_query ) ) {
			$wp_query = new WP_Query();
			$query_set = false;
		}

		$wp_query->query_vars['data'] = $data;
	}

	get_template_part( $slug, $name );

	if ( $do_change ) {
		if ( $query_set ) {
			unset( $wp_query->query_vars['data'] );
		} else {
			unset( $wp_query );
		}
	}
}

/**
 * Checks whether post format templates should be used for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if post format templates should be used for the post, false otherwise.
 */
function super_awesome_theme_use_post_format_templates( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	$result = 'post' === $post_type ? true : false;

	/**
	 * Filters whether to use post format templates for a post.
	 *
	 * If you set this to true, you must ensure there is at least a `template-parts/content/content-{$posttype}.php` file
	 * present in the theme.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $result    Whether to use post format templates. Default is true for type 'post', false otherwise.
	 * @param string $post_type Post type slug.
	 * @param int    $post_id   Post ID.
	 */
	return apply_filters( 'super_awesome_theme_use_post_format_templates', $result, $post_type, $post->ID );
}

/**
 * Checks whether the navigation to the previous and next post should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the post navigation should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_navigation( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	$result = 'post' === $post_type ? true : false;

	/**
	 * Filters whether to display the navigation to the previous and next post for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $result    Whether to display the post navigation. Default is true for type 'post', false otherwise.
	 * @param string $post_type Post type slug.
	 * @param int    $post_id   Post ID.
	 */
	return apply_filters( 'super_awesome_theme_display_post_navigation', $result, $post_type, $post->ID );
}

/**
 * Checks whether entry metadata should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if entry metadata should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_entry_meta( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	$result = 'post' === $post_type ? true : false;

	/**
	 * Filters whether to display entry meta for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $result    Whether to display entry meta. Default is true for type 'post', false otherwise.
	 * @param string $post_type Post type slug.
	 * @param int    $post_id   Post ID.
	 */
	return apply_filters( 'super_awesome_theme_display_entry_meta', $result, $post_type, $post->ID );
}
