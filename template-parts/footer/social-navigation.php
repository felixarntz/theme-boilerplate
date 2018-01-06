<?php
/**
 * The template for displaying the social navigation in the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! has_nav_menu( 'social' ) ) {
	return;
}

?>
<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'super-awesome-theme' ); ?>">
	<?php
	wp_nav_menu( array(
		'theme_location' => 'social',
		'menu_class'     => 'social-links-menu',
		'depth'          => 1,
		'link_before'    => '<span class="screen-reader-text">',
		'link_after'     => '</span>' . super_awesome_theme_get_svg( 'chain' ),
		'container'      => false,
	) );
	?>
</nav><!-- .social-navigation -->
