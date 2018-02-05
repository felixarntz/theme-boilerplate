<?php
/**
 * WP Site Identity compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various WP Site Identity features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_wpsi_setup() {
	add_theme_support( 'wp_site_identity', array(
		'css_properties'  => false,
		'css_callback'    => 'super_awesome_theme_wpsi_render_styles',
		'css_color_black' => '#404040',
		'css_color_white' => '#fff',
	) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_wpsi_setup' );

/**
 * Prints the inline stylesheet for the brand colors set by WP Site Identity.
 *
 * @since 1.0.0
 *
 * @param int   $id     ID attribute to use.
 * @param array $colors Array of $color_slug => $hex_code pairs.
 */
function super_awesome_theme_wpsi_render_styles( $id, $colors ) {
	?>
	<style id="<?php echo esc_attr( $id ); ?>" type="text/css">
		<?php if ( ! empty( $colors['primary'] ) ) : ?>
			a,
			a:visited {
				color: <?php echo esc_attr( $colors['primary'] ); ?>;
			}

			a:hover,
			a:focus,
			a:active {
				color: <?php echo esc_attr( $colors['primary_shade'] ); ?>;
			}

			button.button-primary,
			input[type="button"].button-primary,
			input[type="reset"].button-primary,
			input[type="submit"].button-primary,
			.button.button-primary {
				color: <?php echo esc_attr( $colors['primary_contrast'] ); ?>;
				background-color: <?php echo esc_attr( $colors['primary'] ); ?>;
			}

			button.button-primary:hover,
			button.button-primary:focus,
			input[type="button"].button-primary:hover,
			input[type="button"].button-primary:focus,
			input[type="reset"].button-primary:hover,
			input[type="reset"].button-primary:focus,
			input[type="submit"].button-primary:hover,
			input[type="submit"].button-primary:focus,
			.button.button-primary:hover,
			.button.button-primary:focus {
				background-color: <?php echo esc_attr( $colors['primary_shade'] ); ?>;
			}

			button.button-link,
			input[type="button"].button-link,
			input[type="reset"].button-link,
			input[type="submit"].button-link,
			.button.button-link {
				color: <?php echo esc_attr( $colors['primary'] ); ?>;
			}

			button.button-link:hover,
			button.button-link:focus,
			input[type="button"].button-link:hover,
			input[type="button"].button-link:focus,
			input[type="reset"].button-link:hover,
			input[type="reset"].button-link:focus,
			input[type="submit"].button-link:hover,
			input[type="submit"].button-link:focus,
			.button.button-link:hover,
			.button.button-link:focus {
				color: <?php echo esc_attr( $colors['primary_shade'] ); ?>;
			}

			.wp-audio-shortcode .mejs-controls .mejs-time-rail .mejs-time-current,
			.wp-video-shortcode .mejs-controls .mejs-time-rail .mejs-time-current {
				color: <?php echo esc_attr( $colors['primary_contrast'] ); ?>;
				background: <?php echo esc_attr( $colors['primary'] ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
