<?php
/**
 * Super_Awesome_Theme_Image_Sizes class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the theme's image sizes.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Image_Sizes extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Sidebar' );
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_sizes':
			case 'calculate_content_image_sizes':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers the image sizes used by the theme.
	 *
	 * @since 1.0.0
	 */
	protected function register_sizes() {
		add_image_size( 'full-width', 2560, 9999 ); // Spans the full width for large screens.
		add_image_size( 'site-width', 1152, 9999 ); // Spans the site maximum width of 72rem, with unlimited height.
		add_image_size( 'content-width', 640, 9999 ); // Spans the content maximum width of 40rem, with unlimited height.

		set_post_thumbnail_size( 640, 360, true ); // 640px is 40rem, which is the site maximum width. 360px makes it 16:9 format.
	}

	/**
	 * Filters the sizes attribute generated for an image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $sizes The sizes attribute to filter.
	 * @param array  $size  Array with width and height.
	 * @return string Filtered sizes attribute.
	 */
	protected function calculate_content_image_sizes( $sizes, $size ) {
		$settings = $this->get_dependency( 'settings' );
		$sidebar  = $this->get_dependency( 'sidebar' );

		$content_width_rem = 40;
		$content_width_vw  = 100;
		$content_width_max = '100vw';

		if ( $sidebar->should_display_sidebar() ) {
			$sidebar_size = $settings->get( 'sidebar_size' );
			if ( 'large' === $sidebar_size ) {
				$multiplier = 0.5;
			} elseif ( 'small' === $sidebar_size ) {
				$multiplier = 0.75;
			} else {
				$multiplier = 0.6666666;
			}

			$content_width_rem = (int) floor( 72 * $multiplier ) - 2;
			$content_width_vw  = (int) floor( 100 * $multiplier );
			$content_width_max = '' . $content_width_rem . 'rem';
		}

		$image_width = $size[0];
		if ( $image_width >= $content_width_rem * 16 ) {
			$sizes = "(max-width: 40rem) 100vw, (max-width: 72rem) {$content_width_vw}vw, {$content_width_max}";
		}

		return $sizes;
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_sizes' ), 10, 0 );
		add_filter( 'wp_calculate_image_sizes', array( $this, 'calculate_content_image_sizes' ), 10, 2 );
	}
}
