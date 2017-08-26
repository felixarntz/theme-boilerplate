<?php
/**
 * Template part for displaying a post footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

?>
<footer class="entry-footer">

	<?php get_template_part( 'template-parts/content/entry-terms', get_post_type() ); ?>

	<?php if ( ! is_singular() && ! post_password_required() && post_type_supports( get_post_type(), 'comments' ) && ( comments_open() || get_comments_number() ) ) : ?>
		<span class="comments-link">
			<?php
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'super-awesome-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			?>
		</span>
	<?php endif; ?>

	<?php
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Edit<span class="screen-reader-text"> %s</span>', 'super-awesome-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
	?>

</footer><!-- .entry-footer -->
