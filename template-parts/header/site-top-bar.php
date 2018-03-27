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

?>

<div id="site-top-bar" class="site-top-bar inline-widget-area site-component is-flex">
	<div class="site-component-inner">
		<?php dynamic_sidebar( 'top' ); ?>
	</div>
</div><!-- #site-top-bar -->
