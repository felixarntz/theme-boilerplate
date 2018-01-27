<?php
/**
 * Template part for displaying a comment
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

global $comment, $comment_depth, $comment_args;

?>
<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<footer class="comment-meta">
		<div class="comment-author vcard">
			<?php
			if ( 0 < $comment_args['avatar_size'] ) {
				echo get_avatar( $comment, $comment_args['avatar_size'] );
			}

			/* translators: %s: comment author link */
			printf( __( '%s <span class="says">says:</span>', 'super-awesome-theme' ),
				sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
			);
			?>
		</div><!-- .comment-author -->

		<div class="comment-metadata">
			<a href="<?php echo esc_url( get_comment_link( $comment, $comment_args ) ); ?>">
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php
					/* translators: 1: comment date, 2: comment time */
					printf( __( '%1$s at %2$s', 'super-awesome-theme' ), get_comment_date( '', $comment ), get_comment_time() );
					?>
				</time>
			</a>
			<?php edit_comment_link( __( 'Edit', 'super-awesome-theme' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .comment-metadata -->

		<?php if ( '0' == $comment->comment_approved ) : ?>
			<div class="notice notice-info">
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
			</div>
		<?php endif; ?>
	</footer><!-- .comment-meta -->

	<div class="comment-content">
		<?php comment_text(); ?>
	</div><!-- .comment-content -->

	<?php
	comment_reply_link( array_merge( $comment_args, array(
		'add_below' => 'div-comment',
		'depth'     => $comment_depth,
		'max_depth' => $comment_args['max_depth'],
		'before'    => '<div class="reply">',
		'after'     => '</div>'
	) ) );
	?>
</article><!-- .comment-body -->
