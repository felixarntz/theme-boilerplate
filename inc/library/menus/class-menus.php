<?php
/**
 * Super_Awesome_Theme_Menus class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Menus registry.
 *
 * Callbacks using an instance of this class should be passed to the
 * `on_init()` method.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Menus extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered menus.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $menus = array();

	/**
	 * Adds a callback to run on menus initialization.
	 *
	 * The callback receives the `Super_Awesome_Theme_Menus` instance
	 * as sole parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Callback initializing menus functionality.
	 */
	public function on_init( $callback ) {
		if ( did_action( 'super_awesome_theme_register_menus' ) ) {
			call_user_func( $callback, $this );
			return;
		}

		add_action( 'super_awesome_theme_register_menus', $callback, 10, 1 );
	}

	/**
	 * Registers a menu.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Menu $menu The menu instance.
	 * @return bool True on success, false on failure.
	 */
	public function register_menu( Super_Awesome_Theme_Menu $menu ) {
		$id = $menu->get_prop( Super_Awesome_Theme_Menu::PROP_ID );

		if ( isset( $this->menus[ $id ] ) ) {
			return false;
		}

		$this->menus[ $id ] = $menu;

		register_nav_menu( $id, $menu->get_prop( Super_Awesome_Theme_Menu::PROP_TITLE ) );

		register_sidebar( array(
			'id'            => $id,
			'name'          => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_TITLE ),
			'description'   => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_DESCRIPTION ),
			'before_widget' => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_BEFORE_WIDGET ),
			'after_widget'  => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_AFTER_WIDGET ),
			'before_title'  => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_BEFORE_TITLE ),
			'after_title'   => $menu->get_prop( Super_Awesome_Theme_Menu::PROP_AFTER_TITLE ),
		) );

		return true;
	}

	/**
	 * Gets a registered menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this menu.
	 * @return Super_Awesome_Theme_Menu Registered menu instance.
	 *
	 * @throws Super_Awesome_Theme_Menu_Not_Registered_Exception Thrown when $id does not identify a registered menu.
	 */
	public function get_registered_menu( $id ) {
		if ( ! isset( $this->menus[ $id ] ) ) {
			throw Super_Awesome_Theme_Menu_Not_Registered_Exception::from_id( $id );
		}

		return $this->menus[ $id ];
	}

	/**
	 * Gets all registered menus.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $menu pairs, where each $menu is a
	 *               registered Super_Awesome_Theme_Menu instance.
	 */
	public function get_registered_menus() {
		return $this->menus;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the menus registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'trigger_init':

				/**
				 * Fires when theme menus should be registered.
				 *
				 * Do not use this hook directly, but instead call provide your callback to
				 * the Super_Awesome_Theme_Menus::on_init() method.
				 *
				 * @since 1.0.0
				 *
				 * @param Super_Awesome_Theme_Menus $menus Menus handler instance.
				 */
				do_action( 'super_awesome_theme_register_menus', $this );
				break;
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'trigger_init' ), 100, 0 );
	}
}
