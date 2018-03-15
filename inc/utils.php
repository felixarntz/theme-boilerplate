<?php
/**
 * Utility functions used by the theme
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Darkens a hex color string about a given percentage.
 *
 * @since 1.0.0
 *
 * @param string $color      Hex color string.
 * @param int    $percentage Percentage to darken about.
 * @return string Darkened hex color string.
 */
function super_awesome_theme_darken_color( $color, $percentage ) {
	if ( empty( $color ) ) {
		return $color;
	}

	$rgb = super_awesome_theme_hex_to_rgb( $color );

	$darkened = array();
	foreach ( $rgb as $channel ) {
		$darkened_channel = (int) round( $channel * ( 1.0 - $percentage / 100.0 ) );
		if ( $darkened_channel < 0 ) {
			$darkened_channel = 0;
		}
		$darkened[] = $darkened_channel;
	}

	return super_awesome_theme_rgb_to_hex( $darkened );
}

/**
 * Lightens a hex color string about a given percentage.
 *
 * @since 1.0.0
 *
 * @param string $color      Hex color string.
 * @param int    $percentage Percentage to darken about.
 * @return string Lightened hex color string.
 */
function super_awesome_theme_lighten_color( $color, $percentage ) {
	if ( empty( $color ) ) {
		return $color;
	}

	$rgb = super_awesome_theme_hex_to_rgb( $color );

	$lightened = array();
	foreach ( $rgb as $channel ) {
		$lightened_channel = (int) round( $channel * ( 1.0 + $percentage / 100.0 ) );
		if ( $lightened_channel > 255 ) {
			$lightened_channel = 255;
		}
		$lightened[] = $lightened_channel;
	}

	return super_awesome_theme_rgb_to_hex( $lightened );
}

/**
 * Converts a hex color string into an RGB array.
 *
 * @since 1.0.0
 *
 * @param string $color Hex color string.
 * @return array RGB color array.
 */
function super_awesome_theme_hex_to_rgb( $color ) {
	if ( strlen( $color ) === 4 ) {
		$rgb = str_split( substr( $color, 1 ), 1 );
		$rgb = array_map( array( $this, 'duplicate_char' ), $rgb );
	} else {
		$rgb = str_split( substr( $color, 1 ), 2 );
	}

	return array_map( 'hexdec', $rgb );
}

/**
 * Converts an RGB array into a hex color string.
 *
 * @since 1.0.0
 *
 * @param array $color RGB color array.
 * @return string Hex color string.
 */
function super_awesome_theme_rgb_to_hex( $color ) {
	$hex = array_map( 'zeroise', array_map( 'dechex', $color ), array( 2, 2, 2 ) );

	return '#' . $hex[0] . $hex[1] . $hex[2];
}

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
		$GLOBALS['comment'] = $comment; // WPCS: override ok.

		$reset_global_comment = true;
	}

	$reset_global_comment_depth = false;
	if ( ! isset( $GLOBALS['comment_depth'] ) ) {
		$GLOBALS['comment_depth'] = $depth; // WPCS: override ok.

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
