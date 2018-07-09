<?php
/**
 * Super_Awesome_Theme_Custom_Background class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the custom background feature.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Custom_Background extends Super_Awesome_Theme_Theme_Component_Base {

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
				return call_user_func_array( array( $this, $method ), $args );
			default:
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers the 'custom-background' feature.
	 *
	 * @since 1.0.0
	 */
	protected function register_feature() {

		/**
		 * Filters the arguments for registering custom background support.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Custom background arguments.
		 */
		$args = apply_filters( 'super_awesome_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) );

		$this->get_dependency( 'theme_support' )->add_feature( new Super_Awesome_Theme_Args_Theme_Feature(
			'custom-background',
			$args
		) );
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
