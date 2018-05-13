<?php
/**
 * The template for displaying the footer navigation
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! super_awesome_theme_is_menu_active( 'footer' ) ) {
	return;
}

?>
<nav class="footer-navigation site-component" aria-label="<?php esc_attr_e( 'Footer Menu', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<?php super_awesome_theme_render_menu( 'footer' ); ?>
	</div>
</nav><!-- .footer-navigation -->
