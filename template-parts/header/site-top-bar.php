<?php
/**
 * The top bar widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! super_awesome_theme_is_widget_area_active( 'top' ) ) {
	return;
}

$extra_class = super_awesome_theme_get_setting( 'top_bar_justify_content' );

?>

<div id="site-top-bar" class="site-top-bar inline-widget-area site-component is-flex <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php super_awesome_theme_render_widget_area( 'top' ); ?>
	</div>
</div><!-- #site-top-bar -->
