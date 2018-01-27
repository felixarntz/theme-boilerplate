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
<aside class="footer-widgets" aria-label="<?php esc_attr_e( 'Footer', 'super-awesome-theme' ); ?>">
	<?php
	for ( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
		if ( ! is_active_sidebar( 'footer-' . $i ) ) {
			continue;
		}
		?>
		<div class="widget-column">
			<?php dynamic_sidebar( 'footer-' . $i ); ?>
		</div>
		<?php
	}
	?>
</aside><!-- .widget-area -->
