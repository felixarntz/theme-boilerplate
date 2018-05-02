<?php
/**
 * Additional theme functions to use from within templates
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
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
 * Checks whether a wrapped layout should be used.
 *
 * @since 1.0.0
 *
 * @return bool True if a wrapped layout should be used, false otherwise.
 */
function super_awesome_theme_use_wrapped_layout() {
	/**
	 * Filters whether the theme should use a wrapped layout.
	 *
	 * By default, only the actual content has its maximum width limited, but the
	 * individual site parts themselves scale across full-width. A wrapped layout will
	 * limit the maximum width of the whole site instead.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $use_wrapped_layout Whether to use a wrapped layout. Default false.
	 */
	return apply_filters( 'super_awesome_theme_use_wrapped_layout', false );
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

	if ( ! post_type_supports( $post_type, 'comments' ) ) {
		return false;
	}

	return comments_open( $post ) || get_comments_number( $post );
}

/**
 * Checks whether the excerpt should be used for a post instead of its content.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the excerpt should be used for the post, false otherwise.
 */
function super_awesome_theme_use_post_excerpt( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	if ( ! post_type_supports( $post_type, 'author' ) ) {
		return false;
	}

	return super_awesome_theme()->get_component( 'settings' )->get( $post_type . '_use_excerpt' );
}

/**
 * Checks whether the date should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the date should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_date( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	return super_awesome_theme()->get_component( 'settings' )->get( $post_type . '_show_date' );
}

/**
 * Checks whether the author name should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the author name should be displayed for the post, false otherwise.
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

	return super_awesome_theme()->get_component( 'settings' )->get( $post_type . '_show_author' );
}

/**
 * Checks whether the terms of a specific taxonomy should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param string           $taxonomy Taxonomy slug.
 * @param WP_Post|int|null $post     Optional. Post to check for. Default is the current post.
 * @return bool True if the terms of a specific taxonomy should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_post_taxonomy_terms( $taxonomy, $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$post_type = $post->post_type;

	return super_awesome_theme()->get_component( 'settings' )->get( $post_type . '_show_terms_' . $taxonomy );
}

/**
 * Checks whether the author box should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the author box should be displayed for the post, false otherwise.
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

	return super_awesome_theme()->get_component( 'settings' )->get( $post_type . '_show_authorbox' );
}

/**
 * Checks whether a link to the author's posts should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return bool True if the author posts link should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_author_posts_link( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	/**
	 * Filters whether a link to the author's posts should be displayed for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param bool    $result Whether the author posts link should be displayed for the post.
	 * @param WP_Post $post   Current post object.
	 */
	return apply_filters( 'super_awesome_theme_display_author_posts_link', true, $post );
}

/**
 * Checks whether the sidebar should be displayed.
 *
 * @since 1.0.0
 *
 * @return bool True if the sidebar should be displayed, false otherwise.
 */
function super_awesome_theme_display_sidebar() {
	if ( ! super_awesome_theme_allow_display_sidebar() ) {
		return false;
	}

	return 'no-sidebar' !== get_theme_mod( 'sidebar_mode', 'right-sidebar' );
}

/**
 * Checks whether the current page does allow the sidebar to be displayed.
 *
 * @since 1.0.0
 *
 * @return bool True if the sidebar can be displayed, false otherwise.
 */
function super_awesome_theme_allow_display_sidebar() {
	$result = true;
	if ( super_awesome_theme_is_distraction_free() ) {
		$result = false;
	} elseif ( is_page_template( 'templates/full-width.php' ) ) {
		$result = false;
	}

	/**
	 * Filters whether to allow displaying the sidebar on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $result Whether to allow displaying the sidebar on the current page.
	 */
	return apply_filters( 'super_awesome_theme_allow_display_sidebar', $result );
}

/**
 * Gets the name of the sidebar to display on the current page.
 *
 * @since 1.0.0
 *
 * @return string The sidebar name.
 */
function super_awesome_theme_get_sidebar_name() {
	$sidebar_name = 'primary';

	if ( get_theme_mod( 'blog_sidebar_enabled' ) && super_awesome_theme_allow_display_blog_sidebar() ) {
		$sidebar_name = 'blog';
	}

	/**
	 * Filters the name of the sidebar to display on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $sidebar_name The sidebar name. By default either 'primary' or 'blog'.
	 */
	return apply_filters( 'super_awesome_theme_get_sidebar_name', $sidebar_name );
}

/**
 * Checks whether the current page does allow the blog sidebar to be displayed.
 *
 * @since 1.0.0
 *
 * @return bool True if the blog sidebar can be displayed, false otherwise.
 */
function super_awesome_theme_allow_display_blog_sidebar() {
	$result = false;

	if ( is_singular() ) {
		if ( 'post' === get_post_type() ) {
			$result = true;
		}
	} elseif ( is_home() || is_category() || is_tag() || is_date() || 'post' === get_query_var( 'post_type' ) ) {
		$result = true;
	}

	/**
	 * Filters whether to allow displaying the blog sidebar on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $result Whether to allow displaying the blog sidebar on the current page.
	 */
	return apply_filters( 'super_awesome_theme_allow_display_blog_sidebar', $result );
}

/**
 * Gets the name of the primary navigation to display on the current page.
 *
 * @since 1.0.0
 *
 * @return string The primary navigation name, either 'primary' or 'primary_df'.
 */
function super_awesome_theme_get_navigation_name() {
	$result = 'primary';

	if ( super_awesome_theme_is_distraction_free() ) {
		$result = 'primary_df';
	}

	/**
	 * Filters the name of the primary navigation to display on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $result The identifier of the primary navigation to display.
	 */
	return apply_filters( 'super_awesome_theme_get_navigation_name', $result );
}

/**
 * Checks whether the current page should be displayed in distraction-free mode.
 *
 * By default, distraction-free pages use the special distraction-free navigation,
 * and they display neither sidebar nor footer widgets.
 *
 * @since 1.0.0
 *
 * @global string $pagenow Current WordPress file.
 *
 * @return bool True if the current page should be displayed in distraction-free mode, false otherwise.
 */
function super_awesome_theme_is_distraction_free() {
	global $pagenow;

	$result = false;

	if ( is_page_template( 'templates/distraction-free.php' ) ) {
		$result = true;
	} elseif ( is_page_template( 'templates/login.php' ) ) {
		$result = true;
	} elseif ( 'wp-signup.php' === $pagenow ) {
		$result = true;
	} elseif ( 'wp-activate.php' === $pagenow ) {
		$result = true;
	}

	/**
	 * Filters whether the current page should be displayed in distraction-free mode.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $result Whether to display the page in distraction-free mode. Default depends on the page template.
	 */
	return apply_filters( 'super_awesome_theme_is_distraction_free', $result );
}

/**
 * Gets formatted attachment metadata for a post.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_attachment_metadata Metadata array for the current post.
 *
 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
 * @return array|bool Attachment metadata, or false on failure.
 */
function super_awesome_theme_get_attachment_metadata( $post = null ) {
	return super_awesome_theme()->get_component( 'content_types' )->attachment_metadata()->get_for_post( $post );
}

/**
 * Checks whether the attachment metadata value of a specific field should be displayed for a post.
 *
 * @since 1.0.0
 *
 * @param string           $field Attachment metadata field to display.
 * @param WP_Post|int|null $post  Optional. Post to check for. Default is the current post.
 * @return bool True if the attachment metadata value should be displayed for the post, false otherwise.
 */
function super_awesome_theme_display_attachment_metadata( $field, $post = null ) {
	return super_awesome_theme()->get_component( 'content_types' )->attachment_metadata()->display_field_for_post( $field, $post );
}

/**
 * Gets the attachment metadata fields that can be rendered in an attachment template.
 *
 * @since 1.0.0
 *
 * @return array Associative array of `$field => $label` pairs.
 */
function super_awesome_theme_get_attachment_metadata_fields() {
	return super_awesome_theme()->get_component( 'content_types' )->attachment_metadata()->get_fields();
}
