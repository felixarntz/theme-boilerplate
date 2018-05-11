<?php
/**
 * The template for displaying the social navigation in the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! super_awesome_theme_is_menu_active( 'social' ) ) {
	return;
}

?>
<nav class="social-navigation site-component" aria-label="<?php esc_attr_e( 'Social Links Menu', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<?php super_awesome_theme_render_menu( 'social' ); ?>
	</div>
</nav><!-- .social-navigation -->
