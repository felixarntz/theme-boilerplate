<?php
/**
 * The bottom bar widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! is_active_sidebar( 'bottom' ) && ! is_customize_preview() ) {
	return;
}

?>

<div id="site-bottom-bar" class="site-bottom-bar inline-widget-area site-component is-flex">
	<div class="site-component-inner">
		<?php dynamic_sidebar( 'bottom' ); ?>
	</div>
</div><!-- #site-bottom-bar -->
