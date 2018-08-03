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
	<?php
	if ( $comment_args['avatar_size'] > 0 ) {
		?>
		<div class="comment-avatar">
			<?php echo get_avatar( $comment, $comment_args['avatar_size'] ); ?>
		</div><!-- .comment-avatar -->
		<?php
	}
	?>
	<div class="comment-wrap">
		<footer class="comment-meta">
			<div class="comment-author">
				<?php comment_author_link( $comment ); ?>
			</div><!-- .comment-author -->

			<div class="comment-date">
				<a href="<?php echo esc_url( get_comment_link( $comment, $comment_args ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php
						/* translators: 1: comment date, 2: comment time */
						echo esc_html( sprintf( __( '%1$s at %2$s', 'super-awesome-theme' ), get_comment_date( '', $comment ), get_comment_time() ) );
						?>
					</time>
				</a>
			</div><!-- .comment-date -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="notice notice-info">
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'super-awesome-theme' ); ?></p>
				</div>
			<?php endif; ?>
		</footer><!-- .comment-meta -->

		<div class="comment-content">
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<div class="comment-action-links">
			<ul>
				<?php
				comment_reply_link( array_merge( $comment_args, array(
					'add_below' => 'div-comment',
					'depth'     => $comment_depth,
					'max_depth' => $comment_args['max_depth'],
					'before'    => '<li class="reply-link">',
					'after'     => '</li>',
				) ) );

				edit_comment_link( __( 'Edit', 'super-awesome-theme' ), '<li class="edit-link">', '</li>' );
				?>
			</ul>
		</div><!-- .comment-action-links -->
	</div><!-- .comment-wrap -->
</article><!-- .comment-body -->
