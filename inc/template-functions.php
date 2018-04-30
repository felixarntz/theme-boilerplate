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

	return get_theme_mod( $post_type . '_use_excerpt', false );
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

	$default = in_array( $post_type, array( 'post', 'attachment' ), true );

	return get_theme_mod( $post_type . '_show_date', $default );
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
 * @return bool True if the terms of a specific taxonomy should be displayed for the post, false otherwise.
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

	$default = 'post' === $post_type;

	return get_theme_mod( $post_type . '_show_authorbox', $default );
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
	global $super_awesome_theme_attachment_metadata;

	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	if ( 'attachment' !== $post->post_type ) {
		return false;
	}

	if ( ! empty( $super_awesome_theme_attachment_metadata ) && ! empty( $super_awesome_theme_attachment_metadata['_id'] ) && (int) $super_awesome_theme_attachment_metadata['_id'] === (int) $post->ID ) {
		return $super_awesome_theme_attachment_metadata;
	}

	$meta = wp_get_attachment_metadata( $post->ID );
	if ( is_array( $meta ) ) {
		$meta['filename'] = basename( get_attached_file( $post->ID ) );

		if ( ! empty( $meta['filesize'] ) ) {
			$meta['filesize'] = size_format( strip_tags( $meta['filesize'] ), 2 );
		}

		if ( empty( $meta['fileformat'] ) && preg_match( '/^.*?\.(\w+)$/', get_attached_file( $post->ID ), $matches ) ) {
			$meta['fileformat'] = $matches[1];
		}

		if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
			$meta['dimensions'] = sprintf( '%1$s &#215; %2$s', number_format_i18n( $meta['width'] ), number_format_i18n( $meta['height'] ) );
		} else {
			$meta['dimensions'] = '';
		}

		if ( ! empty( $meta['image_meta'] ) ) {
			if ( ! empty( $meta['image_meta']['created_timestamp'] ) ) {
				$meta['image_meta']['created_timestamp'] = date_i18n( get_option( 'date_format' ), strip_tags( $meta['image_meta']['created_timestamp'] ) );
			}

			if ( ! empty( $meta['image_meta']['focal_length'] ) ) {
				$meta['image_meta']['focal_length'] = sprintf( '%smm', absint( $meta['image_meta']['focal_length'] ) );
			}

			if ( ! empty( $meta['image_meta']['shutter_speed'] ) ) {
				$meta['image_meta']['shutter_speed'] = floatval( strip_tags( $meta['image_meta']['shutter_speed'] ) );

				$speed = $meta['image_meta']['shutter_speed'];
				if ( ( 1 / $speed ) > 1 ) {
					$shutter = sprintf( '<sup>%s</sup>&#8260;', number_format_i18n( 1 ) );
					if ( number_format( ( 1 / $speed ), 1 ) === number_format( ( 1 / $speed ), 0 ) ) {
						$shutter .= sprintf( '<sub>%s</sub>', number_format_i18n( ( 1 / $speed ), 0, '.', '' ) );
					} else {
						$shutter .= sprintf( '<sub>%s</sub>', number_format_i18n( ( 1 / $speed ), 1, '.', '' ) );
					}
				}
			}

			if ( ! empty( $meta['image_meta']['aperture'] ) ) {
				$meta['image_meta']['aperture'] = sprintf( '<sup>f</sup>&#8260;<sub>%s</sub>', absint( $meta['image_meta']['aperture'] ) );
			}

			if ( ! empty( $meta['image_meta']['iso'] ) ) {
				$meta['image_meta']['iso'] = number_format_i18n( (int) $meta['image_meta']['iso'] );
			}
		}
	}

	return $meta;
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
	$meta = super_awesome_theme_get_attachment_metadata( $post );
	if ( ! $meta ) {
		return false;
	}

	if ( empty( $meta[ $field ] ) || ! is_string( $meta[ $field ] ) ) {
		if ( empty( $meta['image_meta'][ $field ] ) || ! is_string( $meta['image_meta'][ $field ] ) ) {
			return false;
		}

		$meta = $meta['image_meta'];
	}

	return get_theme_mod( 'attachment_show_metadata_' . $field, true );
}

/**
 * Gets the attachment metadata fields that can be rendered in an attachment template.
 *
 * @since 1.0.0
 *
 * @return array Associative array of `$field => $label` pairs.
 */
function super_awesome_theme_get_attachment_metadata_fields() {
	$metadata_fields = array(
		'dimensions'       => _x( 'Dimensions', 'attachment metadata', 'super-awesome-theme' ),
		'focal_length'     => _x( 'Focal Length', 'attachment metadata', 'super-awesome-theme' ),
		'shutter_speed'    => _x( 'Shutter Speed', 'attachment metadata', 'super-awesome-theme' ),
		'aperture'         => _x( 'Aperture', 'attachment metadata', 'super-awesome-theme' ),
		'iso'              => _x( 'ISO', 'attachment metadata', 'super-awesome-theme' ),
		'length_formatted' => _x( 'Run Time', 'attachment metadata', 'super-awesome-theme' ),
		'artist'           => _x( 'Artist', 'attachment metadata', 'super-awesome-theme' ),
		'album'            => _x( 'Album', 'attachment metadata', 'super-awesome-theme' ),
		'fileformat'       => _x( 'File Format', 'attachment metadata', 'super-awesome-theme' ),
		'filename'         => _x( 'File Name', 'attachment metadata', 'super-awesome-theme' ),
		'filesize'         => _x( 'File Size', 'attachment metadata', 'super-awesome-theme' ),
	);

	/**
	 * Filters the attachment metadata fields that can be rendered in an attachment template.
	 *
	 * Each of these fields will furthermore receive a Customizer setting to toggle it.
	 *
	 * @since 1.0.0
	 *
	 * @param array $metadata_fields Associative array of `$field => $label` pairs.
	 */
	return apply_filters( 'super_awesome_theme_attachment_metadata_fields', $metadata_fields );
}
