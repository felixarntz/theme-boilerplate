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
			$wp_query = new WP_Query(); // phpcs:ignore WordPress.Variables.GlobalVariables.OverrideProhibited
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
 * Gets the value for a theme setting.
 *
 * @since 1.0.0
 *
 * @param string $id Unique string identifier for this setting.
 * @return mixed Value for the setting, or null if setting is not registered.
 */
function super_awesome_theme_get_setting( $id ) {
	return super_awesome_theme( 'settings' )->get( $id );
}

/**
 * Renders a registered widget area.
 *
 * @since 1.0.0
 *
 * @param string $id Unique string identifier for this widget area.
 */
function super_awesome_theme_render_widget_area( $id ) {
	super_awesome_theme( 'widgets' )->get_registered_widget_area( $id )->render();
}

/**
 * Checks whether a registered widget area is active (i.e. has content).
 *
 * @since 1.0.0
 *
 * @param string $id Unique string identifier for this widget area.
 * @return bool True if the widget area is active, false otherwise.
 */
function super_awesome_theme_is_widget_area_active( $id ) {
	return super_awesome_theme( 'widgets' )->get_registered_widget_area( $id )->is_active();
}

/**
 * Renders a registered menu.
 *
 * @since 1.0.0
 *
 * @param string $id Unique string identifier for this menu.
 */
function super_awesome_theme_render_menu( $id ) {
	super_awesome_theme( 'menus' )->get_registered_menu( $id )->render();
}

/**
 * Checks whether a registered menu is active (i.e. has content).
 *
 * @since 1.0.0
 *
 * @param string $id Unique string identifier for this menu.
 * @return bool True if the menu is active, false otherwise.
 */
function super_awesome_theme_is_menu_active( $id ) {
	return super_awesome_theme( 'menus' )->get_registered_menu( $id )->is_active();
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
 * Checks whether a page header should be used for the current context.
 *
 * @since 1.0.0
 *
 * @return bool True if a page header should be used, false otherwise.
 */
function super_awesome_theme_use_page_header() {
	return super_awesome_theme( 'content_types' )->should_use_page_header();
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

	return super_awesome_theme( 'content_types' )->should_use_post_format_templates( $post->post_type );
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

	return super_awesome_theme( 'content_types' )->should_display_post_navigation( $post->post_type );
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

	if ( ! super_awesome_theme( 'content_types' )->should_display_post_comments( $post->post_type ) ) {
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

	return super_awesome_theme( 'content_types' )->should_use_post_excerpt( $post->post_type );
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

	return super_awesome_theme( 'content_types' )->should_display_post_date( $post->post_type );
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

	return super_awesome_theme( 'content_types' )->should_display_post_author( $post->post_type );
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

	return super_awesome_theme( 'content_types' )->should_display_post_taxonomy_terms( $taxonomy, $post->post_type );
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

	return super_awesome_theme( 'content_types' )->should_display_post_authorbox( $post->post_type );
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
function super_awesome_theme_should_display_sidebar() {
	return super_awesome_theme( 'sidebar' )->should_display_sidebar();
}

/**
 * Gets the name of the sidebar to display on the current page.
 *
 * @since 1.0.0
 *
 * @return string The sidebar name.
 */
function super_awesome_theme_get_sidebar_name() {
	return super_awesome_theme( 'sidebar' )->get_sidebar_name();
}

/**
 * Gets the name of the primary navigation to display on the current page.
 *
 * @since 1.0.0
 *
 * @return string The primary navigation name, either 'primary' or 'primary_df'.
 */
function super_awesome_theme_get_navigation_name() {
	return super_awesome_theme( 'navbar' )->get_navigation_name();
}

/**
 * Checks whether the current page should be displayed in distraction-free mode.
 *
 * By default, distraction-free pages use the special distraction-free navigation,
 * and they display neither sidebar nor footer widgets.
 *
 * @since 1.0.0
 *
 * @return bool True if the current page should be displayed in distraction-free mode, false otherwise.
 */
function super_awesome_theme_is_distraction_free() {
	return super_awesome_theme( 'distraction_free_mode' )->is_distraction_free();
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
	return super_awesome_theme( 'content_types' )->attachment_metadata()->get_for_post( $post );
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
	return super_awesome_theme( 'content_types' )->attachment_metadata()->display_field_for_post( $field, $post );
}

/**
 * Gets the attachment metadata fields that can be rendered in an attachment template.
 *
 * @since 1.0.0
 *
 * @return array Associative array of `$field => $label` pairs.
 */
function super_awesome_theme_get_attachment_metadata_fields() {
	return super_awesome_theme( 'content_types' )->attachment_metadata()->get_fields();
}

/**
 * Gets SVG markup for a specific icon.
 *
 * @since 1.0.0
 *
 * @param string $icon SVG icon identifier.
 * @param array  $args {
 *     Optional. Additional parameters for displaying the SVG.
 *
 *     @type string $title SVG title. Default empty.
 *     @type string $desc  SVG description. Default empty.
 *     @type bool   $fallback Whether to create fallback markup. Default false.
 * }
 * @return string SVG markup for the icon.
 */
function super_awesome_theme_get_svg( $icon, $args = array() ) {
	return super_awesome_theme( 'icons' )->get_svg( $icon, $args );
}
