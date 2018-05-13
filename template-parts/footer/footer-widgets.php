<?php
/**
 * The template for displaying site info in the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$footer_widget_areas = super_awesome_theme()->get_component( 'footer_widget_areas' );

if ( ! $footer_widget_areas->should_display() ) {
	return;
}

?>
<aside class="footer-widgets site-component is-flex" aria-label="<?php esc_attr_e( 'Footer', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<?php
		foreach ( $footer_widget_areas->get_widget_area_names() as $name ) {
			if ( ! super_awesome_theme_is_widget_area_active( $name ) ) {
				continue;
			}

			$class = 'footer-widget-column' . ( $footer_widget_areas->is_wide_widget_area( $name ) ? ' footer-widget-column-wide' : '' );

			?>
			<div id="<?php echo esc_attr( $name ); ?>" class="<?php echo esc_attr( $class ); ?>">
				<?php super_awesome_theme_render_widget_area( $name ); ?>
			</div>
			<?php
		}
		?>
	</div>
</aside><!-- .widget-area -->
