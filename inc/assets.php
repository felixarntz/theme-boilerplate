<?php
/**
 * Asset management functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function super_awesome_theme_enqueue_assets() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'super-awesome-theme-style', get_stylesheet_uri(), array(), SUPER_AWESOME_THEME_VERSION );
	wp_style_add_data( 'super-awesome-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'super-awesome-theme-script', get_theme_file_uri( '/assets/dist/js/theme' . $min . '.js' ), array(), SUPER_AWESOME_THEME_VERSION, true );

	$theme_data = array();

	if ( has_nav_menu( 'primary' ) ) {
		$theme_data['navigation'] = array(
			'icon' => super_awesome_theme_get_svg( 'angle-down', array( 'fallback' => true ) ),
			'i18n' => array(
				'expand'   => __( 'Expand child menu', 'super-awesome-theme' ),
				'collapse' => __( 'Collapse child menu', 'super-awesome-theme' ),
			),
		);
	}

	if ( is_singular() && comments_open() ) {
		$theme_data['comments'] = array(
			'i18n' => array(
				'processing'    => __( 'Processing...', 'super-awesome-theme' ),
				'badResponse'   => __( 'Bad response code.', 'super-awesome-theme' ),
				'invalidJson'   => __( 'Invalid JSON response.', 'super-awesome-theme' ),
				/* translators: %s: edit comment URL */
				'flood'         => sprintf( __( 'Your comment was either a duplicate or you are posting too rapidly. <a href="%s">Edit your comment</a>', 'super-awesome-theme' ), '#comment' ),
				'error'         => __( 'There were errors in submitting your comment; complete the missing fields and try again!', 'super-awesome-theme' ),
				'emailInvalid'  => __( 'This email address appears to be invalid.', 'super-awesome-theme' ),
				'required'      => __( 'This is a required field.', 'super-awesome-theme' ),
				'commentsTitle' => sprintf(
					/* translators: 1: title. */
					__( 'One thought on &ldquo;%1$s&rdquo;', 'super-awesome-theme' ),
					'<span>' . get_the_title() . '</span>'
				),
			),
		);

		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	if ( ! empty( $theme_data ) ) {
		wp_localize_script( 'super-awesome-theme-script', 'themeData', $theme_data );
	}
}
add_action( 'wp_enqueue_scripts', 'super_awesome_theme_enqueue_assets' );

/**
 * Handles a comment submitted via AJAX.
 *
 * @since 1.0.0
 *
 * @param int    $id     ID of the new comment.
 * @param string $status Status of the new comment. Either '0' '1' or 'spam'.
 */
function super_awesome_theme_handle_ajax_comment( $id, $status ) {
	if ( empty( $_GET['is_ajax'] ) || 'true' !== $_GET['is_ajax'] ) {
		return;
	}

	switch ( $status ) {
		case '0':
		case '1':
			$comment       = get_comment( $id );
			$comment_class = comment_class( 'super-awesome-theme-ajax-comment', $comment->comment_ID, $comment->comment_post_ID, false );

			$args = super_awesome_theme_get_list_comments_args();
			$args['walker'] = null;

			ob_start();
			super_awesome_theme_render_comment( $comment, $args, 0, true );
			$comment_output = ob_get_clean();

			if ( 0 === (int) $comment->comment_parent ) {
				$output = $comment_output;
			} else {
				switch ( $args['style'] ) {
					case 'div':
						$output = $comment_output;
						break;
					case 'ol':
						$output = '<ol class="children">' . "\n" . $comment_output . '</ol><!-- .children -->' . "\n";
						break;
					case 'ul':
					default:
						$output = '<ul class="children">' . "\n" . $comment_output . '</ul><!-- .children -->' . "\n";
				}
			}

			if ( '0' === (string) $status ) {
				$message = __( 'Thanks for commenting! Your comment has been sent for moderation and should be approved soon.', 'super-awesome-theme' );
			} else {
				/* translators: %s: comment URL */
				$message = sprintf( __( 'Thanks for commenting! Your comment has been approved. <a href="%s">Read your comment</a>', 'super-awesome-theme' ), "#comment-$id" );
			}

			wp_send_json( array(
				'response' => $output,
				'success'  => 1,
				'status'   => $message,
			), 200 );
			break;
		case 'spam':
			wp_send_json( array(
				'response' => '',
				'success'  => 0,
				'status'   => __( 'Your comment has been marked as spam.', 'super-awesome-theme' ),
			), 200 );
			break;
		default:
			wp_send_json( array(
				'response' => '',
				'success'  => 0,
				'status'   => __( 'An unknown error occurred while trying to post your comment.', 'super-awesome-theme' ),
			), 200 );
	}

	exit;
}
add_action( 'comment_post', 'super_awesome_theme_handle_ajax_comment', 20, 2 );

/**
 * Renders a comment.
 *
 * @since 1.0.0
 *
 * @global WP_Comment $comment       Current comment object.
 * @global int        $comment_depth Current comment depth.
 * @global array      $comment_args  Arguments for wp_list_comments().
 *
 * @param WP_Comment $comment Current comment object.
 * @param array      $args    Arguments for wp_list_comments().
 * @param int        $depth   Optional. Current comment depth. Default 0.
 * @param bool       $close   Optional. Whether to render the closing tag too. Default false.
 */
function super_awesome_theme_render_comment( $comment, $args, $depth = 0, $close = false ) {
	$reset_global_comment = false;
	if ( ! isset( $GLOBALS['comment'] ) ) {
		$GLOBALS['comment'] = $comment;

		$reset_global_comment = true;
	}

	$reset_global_comment_depth = false;
	if ( ! isset( $GLOBALS['comment_depth'] ) ) {
		$GLOBALS['comment_depth'] = $depth;

		$reset_global_comment_depth = true;
	}

	$has_children = false;
	if ( ! empty( $args['walker'] ) ) {
		$has_children = $args['walker']->has_children;
	}

	$post_type = get_post_type( $comment->comment_post_ID );

	$GLOBALS['comment_args'] = $args;

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	echo '<' . $tag . ' id="' . esc_attr( 'comment-' . get_comment_ID() ) . '" ' . comment_class( $has_children ? 'parent' : '', $comment, null, false ) . '>' . "\n"; // WPCS: XSS OK.

	if ( 'trackback' === $comment->comment_type ) {
		get_template_part( 'template-parts/content/trackback', $post_type );
	} elseif ( 'pingback' === $comment->comment_type ) {
		get_template_part( 'template-parts/content/pingback', $post_type );
	} else {
		get_template_part( 'template-parts/content/comment', $post_type );
	}

	if ( $close ) {
		echo '</' . $tag . '><!-- #' . esc_attr( 'comment-' . get_comment_ID() ) . ' -->' . "\n"; // WPCS: XSS OK.
	}

	if ( $reset_global_comment ) {
		unset( $GLOBALS['comment'] );
	}

	if ( $reset_global_comment_depth ) {
		unset( $GLOBALS['comment_depth'] );
	}

	unset( $GLOBALS['comment_args'] );
}

/**
 * Gets the arguments to pass to wp_list_comments().
 *
 * @since 1.0.0
 *
 * @return array Array of arguments.
 */
function super_awesome_theme_get_list_comments_args() {
	/**
	 * Filters the arguments to pass to wp_list_comments().
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Array of arguments.
	 */
	return apply_filters( 'super_awesome_theme_list_comments_args', array(
		'walker'      => new Walker_Comment(),
		'max_depth'   => '',
		'style'       => 'ol',
		'callback'    => 'super_awesome_theme_render_comment',
		'avatar_size' => 32,
		'short_ping'  => true,
	) );
}

/**
 * Includes the icon sprite SVG in the footer.
 *
 * @since 1.0.0
 */
function super_awesome_theme_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_parent_theme_file_path( '/assets/dist/images/icons.svg' );

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'super_awesome_theme_include_svg_icons', 9999 );

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
	$args = wp_parse_args( $args, array(
		'title'    => '',
		'desc'     => '',
		'fallback' => false,
	) );

	$unique_id       = '';
	$aria_hidden     = ' aria-hidden="true"';
	$aria_labelledby = '';

	if ( ! empty( $args['title'] ) ) {
		$unique_id       = uniqid();
		$aria_hidden     = '';
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( ! empty( $args['desc'] ) ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	$svg = '<svg class="icon icon-' . esc_attr( $icon ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	if ( ! empty( $args['title'] ) ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		if ( ! empty( $args['desc'] ) ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	// The whitespace is a work around to a keyboard navigation bug in Safari 10. See https://core.trac.wordpress.org/ticket/38387.
	$svg .= ' <use href="#icon-' . esc_attr( $icon ) . '" xlink:href="#icon-' . esc_attr( $icon ) . '"></use> ';

	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $icon ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}

/**
 * Adjusts the social links menu to display SVG icons.
 *
 * @since 1.0.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string $item_output The menu item output with social icon.
 */
function super_awesome_theme_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	$social_icons = super_awesome_theme_get_social_links_icons();

	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . super_awesome_theme_get_svg( $value ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'super_awesome_theme_nav_menu_social_icons', 10, 4 );

/**
 * Adds a dropdown icon to a menu item in the primary navigation if it has children.
 *
 * @since 1.0.0
 *
 * @param string  $title The menu item's title.
 * @param WP_Post $item  The current menu item.
 * @param array   $args  An array of wp_nav_menu() arguments.
 * @return string $title The menu item's title with dropdown icon.
 */
function super_awesome_theme_dropdown_icon_to_menu_link( $title, $item, $args ) {
	if ( 'primary' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title .= super_awesome_theme_get_svg( 'angle-down' );
				break;
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'super_awesome_theme_dropdown_icon_to_menu_link', 10, 3 );

/**
 * Gets an array of supported social links (URL and icon name).
 *
 * @since 1.0.0
 *
 * @return array Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
 */
function super_awesome_theme_get_social_links_icons() {
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'docker.com'      => 'dockerhub',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'mailto:'         => 'envelope',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'github.com'      => 'github',
		'plus.google.com' => 'google-plus',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'medium.com'      => 'medium',
		'pscp.tv'         => 'periscope',
		'pinterest.com'   => 'pinterest',
		'getpocket.com'   => 'pocket',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filters the theme's supported social links icons.
	 *
	 * @since 1.0.0
	 *
	 * @param array $social_links_icons Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
	 */
	return apply_filters( 'super_awesome_theme_social_links_icons', $social_links_icons );
}
