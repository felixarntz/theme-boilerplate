<?php
/**
 * The template for displaying site info in the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>
<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'super-awesome-theme' ) ); ?>"><?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'super-awesome-theme' ), 'WordPress' );
	?></a>
	<span class="sep"> | </span>
	<?php
		/* translators: 1: Theme name, 2: Theme author. */
		printf( esc_html__( 'Theme: %1$s by %2$s.', 'super-awesome-theme' ), 'Super Awesome Theme', '<a href="https://super-awesome-author.org">Super Awesome Author</a>' );
	?>
</div><!-- .site-info -->
