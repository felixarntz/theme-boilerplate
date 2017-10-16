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
	if ( is_singular() ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
	} else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}
	?>

	<?php get_template_part( 'template-parts/content/entry-meta', get_post_type() ); ?>

</header><!-- .entry-header -->
