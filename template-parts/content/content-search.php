<?php
/**
 * Template part for displaying a result in a search page
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'template-parts/content/entry-header', get_post_type() ); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<?php get_template_part( 'template-parts/content/entry-footer', get_post_type() ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
