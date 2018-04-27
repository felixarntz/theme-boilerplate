<?php
/**
 * The template for displaying site info in the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( super_awesome_theme_is_distraction_free() ) {
	return;
}

$footer_widget_area_count = super_awesome_theme_get_footer_widget_area_count();
$wide_footer_widget_area  = (int) get_theme_mod( 'wide_footer_widget_area', 0 );

$has_active = false;
for( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
	if ( is_active_sidebar( 'footer-' . $i ) ) {
		$has_active = true;
		break;
	}
}

if ( ! $has_active ) {
	return;
}
?>
<aside class="footer-widgets site-component is-flex" aria-label="<?php esc_attr_e( 'Footer', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<?php
		for ( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
			$class = 'footer-widget-column' . ( $i === $wide_footer_widget_area ? ' footer-widget-column-wide' : '' );
			if ( ! is_active_sidebar( 'footer-' . $i ) ) {
				continue;
			}
			?>
			<div id="<?php echo esc_attr( 'footer-widget-column-' . $i ); ?>" class="<?php echo esc_attr( $class ); ?>">
				<?php dynamic_sidebar( 'footer-' . $i ); ?>
			</div>
			<?php
		}
		?>
	</div>
</aside><!-- .widget-area -->
