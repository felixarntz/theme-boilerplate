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

	if ( ! post_type_supports( $post_type, 'post-formats' ) ) {
		return false;
	}

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

	$post_type_object = get_post_type_object( $post->post_type );
	if ( ! $post_type_object ) {
		return false;
	}

	return (bool) $post_type_object->has_archive;
}

/**
 * Checks whether comments should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if comments should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_comments( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	return post_type_supports( $post_type, 'comments' ) && ( comments_open( $post ) || get_comments_number( $post ) );
}

/**
 * Checks whether the date should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return True if the date should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_date( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	$default = in_array( $post_type, array( 'post', 'attachment' ), true );

	return get_theme_mod( $post_type . '_show_date', $default );
}

/**
 * Checks whether the author name should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return True if the author name should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_author( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	if ( ! post_type_supports( $post_type, 'author' ) ) {
		return false;
	}

	$default = in_array( $post_type, array( 'post', 'attachment' ), true );

	return get_theme_mod( $post_type . '_show_author', $default );
}

/**
 * Checks whether the terms of a specific taxonomy should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param string           $taxonomy Taxonomy slug.
 * @param WP_Post|int|null $post     Optional. Post to check for. Default is the current post.
 * @return True if the terms of a specific taxonomy should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_taxonomy_terms( $taxonomy, $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	return get_theme_mod( $post_type . '_show_terms_' . $taxonomy, true );
}

/**
 * Checks whether the author box should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return True if the author box should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_authorbox( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	if ( ! post_type_supports( $post_type, 'author' ) ) {
		return false;
	}

	$default = 'post' === $post_type;

	return get_theme_mod( $post_type . '_show_authorbox', $default );
}

/**
 * Prints a post context attribute to be used by the Customizer.
 *
 * This function should be used on all selectors for selective refresh partials
 * which need to be aware of their post context.
 * The attribute is only printed when the current request is a customize preview.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to print the attribute for. Default is the current post.
 */
function super_awesome_theme_customize_post_context( $post = null ) {
	if ( ! is_customize_preview() ) {
		return;
	}

	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}

	$context = array(
		'post_id' => (int) $post->ID,
	);

	printf( ' data-customize-partial-placement-context="%s"', esc_attr( wp_json_encode( $context ) ) );
}

/**
 * Checks whether the sidebar should be displayed.
 *
 * @since 1.0.0
 *
 * @return bool True if the sidebar should be displayed, false otherwise.
 */
function super_awesome_theme_display_sidebar() {
	$is_customize_preview = is_customize_preview();

	$result = 'no-sidebar' !== get_theme_mod( 'sidebar_mode', 'right-sidebar' ) || $is_customize_preview;

	/**
	 * Filters whether the sidebar should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $result               Whether to display the sidebar. Default depends on the 'sidebar_mode' theme mod.
	 * @param bool $is_customize_preview Whether the page is currently being viewed in the Customizer.
	 */
	return apply_filters( 'super_awesome_theme_display_sidebar', $result, $is_customize_preview );
}

/**
 * Gets the name of the sidebar to display on the current page.
 *
 * @since 1.0.0
 *
 * @return string The sidebar name, either 'primary' or 'blog'.
 */
function super_awesome_theme_get_sidebar_name() {
	$result = 'primary';

	if ( get_theme_mod( 'blog_sidebar_enabled' ) ) {
		if ( is_singular() ) {
			if ( 'post' === get_post_type() ) {
				$result = 'blog';
			}
		} elseif ( is_home() || is_category() || is_tag() || is_date() || 'post' === get_query_var( 'post_type' ) ) {
			$result = 'blog';
		}
	}

	/**
	 * Filters the name of the sidebar to display on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $result The identifier of the sidebar to display.
	 */
	return apply_filters( 'super_awesome_theme_get_sidebar_name', $result );
}
