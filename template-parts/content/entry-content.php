<?php
/**
 * Template part for displaying a post content
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>
<div class="entry-content">
	<?php
	if ( ! is_singular( get_post_type() ) && super_awesome_theme_use_post_excerpt() ) {
		the_excerpt();
	} else {
		the_content( sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'super-awesome-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );
	}

	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'super-awesome-theme' ),
		'after'  => '</div>',
	) );
	?>
</div><!-- .entry-content -->
