<?php
/**
 * The bottom bar widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! is_active_sidebar( 'bottom' ) ) {
	return;
}

$extra_class = get_theme_mod( 'bottom_bar_justify_content', 'space-between' );

?>

<div id="site-bottom-bar" class="site-bottom-bar inline-widget-area site-component is-flex <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php dynamic_sidebar( 'bottom' ); ?>
	</div>
</div><!-- #site-bottom-bar -->
