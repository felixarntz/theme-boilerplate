<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

if ( ! is_active_sidebar( 'primary' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Primary Sidebar', 'super-awesome-theme' ); ?>">
	<?php dynamic_sidebar( 'primary' ); ?>
</aside><!-- #secondary -->
