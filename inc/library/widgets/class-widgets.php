<?php
/**
 * Super_Awesome_Theme_Widgets class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Widgets and widget areas registry.
 *
 * Callbacks using an instance of this class should be passed to the
 * `on_init()` method.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Widgets extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered widget areas.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $widget_areas = array();

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Icons' );
	}

	/**
	 * Adds a callback to run on Customizer initialization.
	 *
	 * The callback receives the `Super_Awesome_Theme_Customizer` instance
	 * as sole parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Callback initializing Customizer functionality.
	 */
	public function on_init( $callback ) {
		if ( did_action( 'super_awesome_theme_register_widgets' ) ) {
			call_user_func( $callback, $this );
			return;
		}

		add_action( 'super_awesome_theme_register_widgets', $callback );
	}

	/**
	 * Registers a widget.
	 *
	 * @since 1.0.0
	 *
	 * @global WP_Widget_Factory $wp_widget_factory Widget factory instance.
	 *
	 * @param Super_Awesome_Theme_Widget|string $widget_class_name Either a widget instance or widget class name.
	 * @return bool True on success, false on failure.
	 *
	 * @throws InvalidArgumentException Thrown when the widget is not a valid widget class.
	 */
	public function register_widget( $widget_class_name ) {
		global $wp_widget_factory;

		if ( ! is_subclass_of( $widget_class_name, 'Super_Awesome_Theme_Widget' ) ) {
			if ( is_object( $widget_class_name ) ) {
				$widget_class_name = get_class( $widget_class_name );
			}

			/* translators: %s: widget class name */
			throw new InvalidArgumentException( sprintf( __( '%s is not a valid widget class.', 'super-awesome-theme' ), $widget_class_name ) );
		}

		if ( is_object( $widget_class_name ) && in_array( $widget_class_name, $wp_widget_factory->widgets, true ) ) {
			return false;
		} elseif ( is_string( $widget_class_name ) && isset( $wp_widget_factory->widgets[ $widget_class_name ] ) ) {
			return false;
		}

		if ( is_object( $widget_class_name ) ) {
			register_widget( $widget_class_name );
		} else {

			// Do not call register_widget() so we can pass our custom param to the constructor
			// and still use the class name as widget key.
			$wp_widget_factory->widgets[ $widget_class_name ] = new $widget_class_name( $this );
		}

		return true;
	}

	/**
	 * Registers a widget area.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Widget_Area $widget_area The widget area instance.
	 * @return bool True on success, false on failure.
	 */
	public function register_widget_area( Super_Awesome_Theme_Widget_Area $widget_area ) {
		$id = $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_ID );

		if ( isset( $this->widget_areas[ $id ] ) ) {
			return false;
		}

		$this->widget_areas[ $id ] = $widget_area;

		register_sidebar( array(
			'id'            => $id,
			'name'          => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_TITLE ),
			'description'   => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION ),
			'before_widget' => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::BEFORE_WIDGET ),
			'after_widget'  => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::AFTER_WIDGET ),
			'before_title'  => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::BEFORE_TITLE ),
			'after_title'   => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::AFTER_TITLE ),
		) );

		return true;
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
			case 'trigger_init':
				$this->register_widget( 'Super_Awesome_Theme_Login_Links_Widget' );
				$this->register_widget( 'Super_Awesome_Theme_Social_Menu_Widget' );

				/**
				 * Fires when theme widgets and widget areas should be registered.
				 *
				 * Do not use this hook directly, but instead call provide your callback to
				 * the Super_Awesome_Theme_Widgets::on_init() method.
				 *
				 * @since 1.0.0
				 *
				 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
				 */
				do_action( 'super_awesome_theme_register_widgets', $this );
				break;
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'widgets_init', array( $this, 'trigger_init' ), 10, 0 );
	}
}
