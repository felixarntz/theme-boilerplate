<?php
/**
 * Super_Awesome_Theme_Custom_Header class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the custom header feature.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Custom_Header extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Theme_Support' );
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_feature':
			case 'print_header_style':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Registers the 'custom-header' feature.
	 *
	 * @since 1.0.0
	 */
	protected function register_feature() {
		$custom_header_width  = super_awesome_theme_use_wrapped_layout() ? 1152 : 2560;
		$custom_header_height = super_awesome_theme_use_wrapped_layout() ? 460 : 1024;

		/**
		 * Filters the arguments for registering custom header support.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Custom header arguments.
		 */
		$args = apply_filters( 'super_awesome_theme_custom_header_args', array(
			'default-image'          => '',
			'default-text-color'     => '404040',
			'width'                  => $custom_header_width,
			'height'                 => $custom_header_height,
			'flex-height'            => true,
			'wp-head-callback'       => array( $this, 'print_header_style' ),
			'video'                  => true,
		) );

		$this->get_dependency( 'theme_support' )->add_feature( new Super_Awesome_Theme_Args_Theme_Feature(
			'custom-header',
			$args
		) );
	}

	/**
	 * Prints the extra custom header styles.
	 *
	 * Header text color is handled manually with the other Customizer colors.
	 *
	 * @since 1.0.0
	 */
	protected function print_header_style() {
		if ( display_header_text() ) {
			return;
		}

		?>
		<style type="text/css">
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		</style>
		<?php
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_feature' ), 10, 0 );
	}
}
