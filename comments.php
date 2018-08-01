<?php
/**
 * The template for displaying comments
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php

	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$comment_count = (int) get_comments_number();
			if ( 1 === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'super-awesome-theme' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'super-awesome-theme' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<?php
		if ( super_awesome_theme_is_amp() ) {
			$comments_sort_attr = 'asc' === get_option( 'comment_order' ) ? ' sort="ascending"' : '';
			$comments_per_page  = get_option( 'page_comments' ) ? get_option( 'comments_per_page' ) : 10000;

			?>
			<amp-live-list id="amp-live-comment-list-<?php the_ID(); ?>" class="live-list" layout="container"<?php echo $comments_sort_attr; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> data-poll-interval="15000" data-max-items-per-page="<?php echo esc_attr( $comments_per_page ); ?>">
				<ol items class="comment-list">
					<?php super_awesome_theme( 'comments' )->render_comments(); ?>
				</ol><!-- .comment-list -->

				<div update class="live-list-button">
					<button class="button" on="tap:amp-live-comment-list-<?php the_ID(); ?>.update"><?php esc_html_e( 'New comment(s)', 'super-awesome-theme' ); ?></button>
				</div>
				<nav pagination>
					<?php the_comments_navigation(); ?>
				</nav>
			</amp-live-list>
			<?php
		} else {
			?>
			<ol class="comment-list">
				<?php super_awesome_theme( 'comments' )->render_comments(); ?>
			</ol><!-- .comment-list -->
			<?php

			the_comments_navigation();
		}
		?>

		<?php

		if ( ! comments_open() ) {
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'super-awesome-theme' ); ?></p>
			<?php
		}
	}

	comment_form();

	?>

</div><!-- #comments -->
