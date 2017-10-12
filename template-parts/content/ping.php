<?php
/**
 * Template part for displaying a pingback or trackback
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

global $comment, $comment_depth, $comment_args;

?>
<div class="comment-body">
	<?php _e( 'Pingback:', 'super-awesome-theme' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit', 'super-awesome-theme' ), '<span class="edit-link">', '</span>' ); ?>
</div>
