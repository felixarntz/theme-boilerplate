<?php
/**
 * Super_Awesome_Theme_Custom_Logo class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the custom logo feature.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Custom_Logo extends Super_Awesome_Theme_Theme_Component_Base {

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
		}
	}

	/**
	 * Registers the 'custom-logo' feature.
	 *
	 * @since 1.0.0
	 */
	protected function register_feature() {

		/**
		 * Filters the arguments for registering custom logo support.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Custom logo arguments.
		 */
		$args = apply_filters( 'super_awesome_theme_custom_logo_args', array(
			'height'      => 150,
			'width'       => 250,
			'flex-width'  => true,
		) );

		$this->get_dependency( 'theme_support' )->add_feature( new Super_Awesome_Theme_Args_Theme_Feature(
			'custom-logo',
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
