<?php
/**
 * The sidebar containing the widget area for blog and single post content
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

if ( ! is_active_sidebar( 'blog' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'blog' ); ?>
</aside><!-- #secondary -->
