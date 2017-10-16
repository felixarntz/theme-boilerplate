<?php
/**
 * Template part for displaying post meta
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
}

$time_string = sprintf( $time_string,
	esc_attr( get_the_date( 'c' ) ),
	esc_html( get_the_date() ),
	esc_attr( get_the_modified_date( 'c' ) ),
	esc_html( get_the_modified_date() )
);

?>
<div class="entry-meta"<?php super_awesome_theme_customize_post_context() ?>>

	<?php if ( super_awesome_theme_display_post_date() ) : ?>
		<span class="posted-on">
			<?php
			printf(
				/* translators: %s: post date. */
				esc_html_x( 'Posted on %s', 'post date', 'super-awesome-theme' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' // WPCS: XSS OK.
			);
			?>
		</span>
	<?php endif; ?>

	<?php if ( super_awesome_theme_display_post_author() ) : ?>
		<span class="byline">
			<?php
			printf(
				/* translators: %s: post author. */
				esc_html_x( 'by %s', 'post author', 'super-awesome-theme' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);
			?>
		</span>
	<?php endif; ?>

</div><!-- .entry-meta -->
