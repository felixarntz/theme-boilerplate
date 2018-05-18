<?php
/**
 * Super_Awesome_Theme_Comments class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for handling comments including AJAX functionality.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Comments extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
	}

	/**
	 * Renders comments.
	 *
	 * @since 1.0.0
	 *
	 * @param array $comments Optional. List of WP_Comment objects. Default is
	 *                        comments for the current post.
	 */
	public function render_comments( $comments = null ) {
		wp_list_comments( $this->get_list_comments_args(), $comments );
	}

	/**
	 * Renders a comment.
	 *
	 * @since 1.0.0
	 *
	 * @global WP_Comment $comment       Current comment object.
	 * @global int        $comment_depth Current comment depth.
	 * @global array      $comment_args  Arguments for wp_list_comments().
	 *
	 * @param WP_Comment $comment Optional. Comment object to render. Default is the current comment.
	 * @param array      $args    Optional. Arguments for wp_list_comments().
	 * @param int        $depth   Optional. Current comment depth. Default 0.
	 * @param bool       $close   Optional. Whether to render the closing tag too. Default false.
	 */
	public function render_comment( $comment = null, $args = array(), $depth = 0, $close = false ) {
		$reset_global_comment = false;

		if ( ! isset( $GLOBALS['comment'] ) ) {
			if ( null === $comment ) {
				return;
			}

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
	 * Magic call method.
	 *
	 * Handles the widgets registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'handle_ajax_comment':
			case 'add_main_script_data':
			case 'maybe_enqueue_comment_reply_script':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Handles a comment submitted via AJAX.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $id     ID of the new comment.
	 * @param string $status Status of the new comment. Either '0' '1' or 'spam'.
	 */
	protected function handle_ajax_comment( $id, $status ) {
		if ( empty( $_GET['is_ajax'] ) || 'true' !== $_GET['is_ajax'] ) {
			return;
		}

		switch ( $status ) {
			case '0':
			case '1':
				$comment       = get_comment( $id );
				$comment_class = comment_class( 'super-awesome-theme-ajax-comment', $comment->comment_ID, $comment->comment_post_ID, false );

				$args           = $this->get_list_comments_args();
				$args['walker'] = null;

				ob_start();
				$this->render_comment( $comment, $args, 0, true );
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

	/**
	 * Adds script data for navigation functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_main_script_data() {
		$assets = $this->get_dependency( 'assets' );
		$script = $assets->get_registered_asset( 'super-awesome-theme-script' );

		if ( is_singular() && comments_open() ) {
			$script->add_data( 'comments', array(
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
			) );
		}
	}

	/**
	 * Enqueues the WordPress comment reply script as necessary.
	 *
	 * @since 1.0.0
	 */
	protected function maybe_enqueue_comment_reply_script() {
		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Gets the arguments to pass to wp_list_comments().
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of arguments.
	 */
	protected function get_list_comments_args() {

		/**
		 * Filters the comment author avatar size.
		 *
		 * @since 1.0.0
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$comment_author_avatar_size = apply_filters( 'super_awesome_theme_comment_author_avatar_size', 32 );

		return array(
			'walker'      => new Walker_Comment(),
			'max_depth'   => '',
			'style'       => 'ol',
			'callback'    => array( $this, 'render_comment' ),
			'avatar_size' => $comment_author_avatar_size,
			'short_ping'  => true,
		);
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'comment_post', array( $this, 'handle_ajax_comment' ), 20, 2 );
		add_action( 'wp_head', array( $this, 'add_main_script_data' ), 0, 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_comment_reply_script' ), 20, 0 );
	}
}
