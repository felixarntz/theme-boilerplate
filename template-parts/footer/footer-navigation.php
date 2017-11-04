<?php
/**
 * The template for displaying the footer navigation
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

if ( ! has_nav_menu( 'footer' ) ) {
	return;
}

?>
<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'super-awesome-theme' ); ?>">
	<?php
	wp_nav_menu( array(
		'theme_location' => 'footer',
		'menu_class'     => 'footer-menu',
		'depth'          => 1,
		'container'      => false,
	) );
	?>
</nav><!-- .footer-navigation -->
