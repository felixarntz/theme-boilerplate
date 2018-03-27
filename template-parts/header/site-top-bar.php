<?php
/**
 * The top bar widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! is_active_sidebar( 'top' ) && ! is_customize_preview() ) {
	return;
}

$extra_class = get_theme_mod( 'top_bar_justify_content', 'space-between' );

?>

<div id="site-top-bar" class="site-top-bar inline-widget-area site-component is-flex <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php dynamic_sidebar( 'top' ); ?>
	</div>
</div><!-- #site-top-bar -->
