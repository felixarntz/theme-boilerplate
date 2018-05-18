<?php
/**
 * The bottom bar widget area
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

$bottom_bar  = super_awesome_theme()->get_component( 'widgets' )->get_registered_widget_area( 'bottom' );
$extra_class = super_awesome_theme_get_setting( 'bottom_bar_justify_content' );

?>

<div id="site-bottom-bar" class="site-bottom-bar inline-widget-area site-component is-flex <?php echo esc_attr( $extra_class ); ?>">
	<div class="site-component-inner">
		<?php
		if ( $bottom_bar->is_active() ) {
			$bottom_bar->render();
		} else {
			$credits_text = '<a href="' . esc_url( __( 'https://wordpress.org/', 'super-awesome-theme' ) ) . '">' . sprintf( __( 'Proudly powered by %s', 'super-awesome-theme' ), 'WordPress' ) . '</a>';

			/* translators: 1: theme name, 2: theme author name with link */
			$credits_text .= ' | ' . sprintf( __( 'Theme: %1$s by %2$s', 'super-awesome-theme' ), 'Super Awesome Theme', '<a href="' . esc_url( __( 'https://super-awesome-author.org', 'super-awesome-theme' ) ) . '">Super Awesome Author</a>' );

			if ( function_exists( 'get_the_privacy_policy_link' ) ) {
				$credits_text = get_the_privacy_policy_link( '', ' | ' ) . $credits_text;
			}

			$bottom_bar->render_single_widget( 'WP_Widget_Text', array( 'text' => $credits_text ) );
		}
		?>
	</div>
</div><!-- #site-bottom-bar -->
