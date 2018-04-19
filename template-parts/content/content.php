<?php
/**
 * Template part for displaying a post
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'template-parts/content/entry-header', get_post_type() ); ?>

	<?php get_template_part( 'template-parts/content/entry-content', get_post_type() ); ?>

	<?php get_template_part( 'template-parts/content/entry-footer', get_post_type() ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
