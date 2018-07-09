<?php
/**
 * Super_Awesome_Theme_Footer_Navigation class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing the footer navigation.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Footer_Navigation extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Menus' );
	}

	/**
	 * Checks whether the footer navigation menu  is active (i.e. has content).
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the menu  is active, false otherwise.
	 */
	public function is_active() {
		return $this->get_dependency( 'menus' )->get_registered_menu( 'footer' )->is_active();
	}

	/**
	 * Magic call method.
	 *
	 * Handles the Customizer registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_menu':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers the footer navigation menu.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Menus $menus Menus handler instance.
	 */
	protected function register_menu( $menus ) {
		$menus->register_menu( new Super_Awesome_Theme_Menu( 'footer', array(
			Super_Awesome_Theme_Menu::PROP_TITLE      => __( 'Footer Menu', 'super-awesome-theme' ),
			Super_Awesome_Theme_Menu::PROP_MENU_CLASS => 'footer-menu',
			Super_Awesome_Theme_Menu::PROP_DEPTH      => 1,
		) ) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		$menus = $this->get_dependency( 'menus' );
		$menus->on_init( array( $this, 'register_menu' ) );
	}
}
