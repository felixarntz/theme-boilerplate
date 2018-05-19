<?php
/**
 * Template part for displaying a pingback
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

global $comment, $comment_depth, $comment_args;

?>
<div class="comment-body">
	<?php esc_html_e( 'Pingback:', 'super-awesome-theme' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit', 'super-awesome-theme' ), '<span class="edit-link">', '</span>' ); ?>
</div>
