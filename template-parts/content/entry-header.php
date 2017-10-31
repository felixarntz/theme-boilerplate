<?php
/**
 * Template part for displaying a post header
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

?>
<header class="entry-header">

	<?php
	/**
	 * Fires immediately before the title of any post will be printed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type of the current post.
	 */
	do_action( 'super_awesome_theme_before_entry_title', get_post_type() );

	if ( is_singular() ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
	} else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}

	/**
	 * Fires immediately after the title of any post has been printed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type of the current post.
	 */
	do_action( 'super_awesome_theme_after_entry_title', get_post_type() );
	?>

	<?php get_template_part( 'template-parts/content/entry-meta', get_post_type() ); ?>

</header><!-- .entry-header -->
