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
	 * Name of the Customizer section for widget settings.
	 *
	 * @since 1.0.0
	 */
	const CUSTOMIZER_SECTION = 'widget_areas';

	/**
	 * Registered widget areas.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $widget_areas = array();

	/**
	 * Inline widget area identifiers.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $inline_widget_areas = array();

	/**
	 * Inline widget identifiers.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $inline_widgets = array();

	/**
	 * Internal Customizer instance storage.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Customizer
	 */
	private $customizer;

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
		$this->require_dependency_class( 'Super_Awesome_Theme_Menus' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Icons' );
	}

	/**
	 * Adds a callback to run on widgets initialization.
	 *
	 * The callback receives the `Super_Awesome_Theme_Widgets` instance
	 * as sole parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Callback initializing widgets functionality.
	 */
	public function on_init( $callback ) {
		if ( did_action( 'super_awesome_theme_register_widgets' ) ) {
			call_user_func( $callback, $this );
			return;
		}

		add_action( 'super_awesome_theme_register_widgets', $callback, 10, 1 );
	}

	/**
	 * Adds a callback to run on widgets Customizer initialization.
	 *
	 * The callback receives the `Super_Awesome_Theme_Customizer` and the
	 * `Super_Awesome_Theme_Widgets` instances as parameters.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Callback initializing Customizer functionality.
	 */
	public function on_customizer_init( $callback ) {
		if ( did_action( 'super_awesome_theme_widgets_customize_register_controls' ) ) {
			call_user_func( $callback, $this->customizer, $this );
			return;
		}

		add_action( 'super_awesome_theme_widgets_customize_register_controls', $callback, 10, 2 );
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
			'before_widget' => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_BEFORE_WIDGET ),
			'after_widget'  => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_AFTER_WIDGET ),
			'before_title'  => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_BEFORE_TITLE ),
			'after_title'   => $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_AFTER_TITLE ),
		) );

		if ( $widget_area->get_prop( Super_Awesome_Theme_Widget_Area::PROP_INLINE ) ) {
			$this->add_inline_widget_areas( $id );
		}

		return true;
	}

	/**
	 * Gets a registered widget area.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this widget area.
	 * @return Super_Awesome_Theme_Widget_Area Registered widget area instance.
	 *
	 * @throws Super_Awesome_Theme_Widget_Area_Not_Registered_Exception Thrown when $id does not identify a registered widget area.
	 */
	public function get_registered_widget_area( $id ) {
		if ( ! isset( $this->widget_areas[ $id ] ) ) {
			throw Super_Awesome_Theme_Widget_Area_Not_Registered_Exception::from_id( $id );
		}

		return $this->widget_areas[ $id ];
	}

	/**
	 * Gets all registered widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $widget_area pairs, where each $widget_area is a
	 *               registered Super_Awesome_Theme_Widget_Area instance.
	 */
	public function get_registered_widget_areas() {
		return $this->widget_areas;
	}

	/**
	 * Gets the identifiers for all inline widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of widget area IDs.
	 */
	public function get_inline_widget_areas() {
		return $this->inline_widget_areas;
	}

	/**
	 * Makes the given widget areas inline widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $widget_areas One or more widget area identifiers.
	 */
	public function add_inline_widget_areas( $widget_areas ) {
		$widget_areas = array_values( (array) $widget_areas );

		$this->inline_widget_areas = array_unique( array_merge( $this->inline_widget_areas, $widget_areas ) );
		sort( $this->inline_widget_areas );
	}

	/**
	 * Makes the given inline widget areas default widget areas again.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $widget_areas One or more widget area identifiers.
	 */
	public function remove_inline_widget_areas( $widget_areas ) {
		$widget_areas = array_values( (array) $widget_areas );

		$this->inline_widget_areas = array_diff( $this->inline_widget_areas, $widget_areas );
		sort( $this->inline_widget_areas );
	}

	/**
	 * Gets the identifiers for all widgets that are allowed in inline widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of widget IDs.
	 */
	public function get_inline_widgets() {
		return $this->inline_widgets;
	}

	/**
	 * Adds the given widget identifiers to the list of widgets allowed in inline widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $widgets One or more widget identifiers.
	 */
	public function add_inline_widgets( $widgets ) {
		$widgets = array_values( (array) $widgets );

		$this->inline_widgets = array_unique( array_merge( $this->inline_widgets, $widgets ) );
		sort( $this->inline_widgets );
	}

	/**
	 * Removes the given widget identifiers from the list of widgets allowed in inline widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $widgets One or more widget identifiers.
	 */
	public function remove_inline_widgets( $widgets ) {
		$widgets = array_values( (array) $widgets );

		$this->inline_widgets = array_diff( $this->inline_widgets, $widgets );
		sort( $this->inline_widgets );
	}

	/**
	 * Magic call method.
	 *
	 * Handles the widgets registration action hook callbacks.
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
			case 'ensure_inline_widgets_whitelist':
			case 'register_customize_controls':
			case 'register_customize_controls_js':
				return call_user_func_array( array( $this, $method ), $args );
			case 'trigger_customizer_init':
				$this->customizer->add_section( self::CUSTOMIZER_SECTION, array(
					'panel'    => 'widgets',
					'title'    => __( 'Widget Area Settings', 'super-awesome-theme' ),
					'priority' => -1,
				) );

				/**
				 * Fires when theme widgets functionality for the Customizer should be registered.
				 *
				 * Do not use this hook directly, but instead call provide your callback to
				 * the Super_Awesome_Theme_Widgets::on_customizer_init() method.
				 *
				 * @since 1.0.0
				 *
				 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
				 * @param Super_Awesome_Theme_Widgets    $widgets    Widgets handler instance.
				 */
				do_action( 'super_awesome_theme_widgets_customize_register_controls', $this->customizer, $this );
				break;
			case 'trigger_init':
				$this->register_widget( 'Super_Awesome_Theme_Login_Links_Widget' );
				$this->register_widget( 'Super_Awesome_Theme_Social_Menu_Widget' );

				$this->add_inline_widgets( array(
					'categories',
					'custom_html',
					'meta',
					'nav_menu',
					'pages',
					'recent-comments',
					'recent-posts',
					'search',
					'text',
					'super_awesome_theme_login_links',
					'super_awesome_theme_social_menu',
				) );

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
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Ensures that inline sidebars only contain widgets that are allowed within them.
	 *
	 * This function essentially filters out all non-inline widgets within these sidebars.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sidebars_widgets An associative array of sidebars and their widgets.
	 * @return array Filtered array of sidebars and their widgets.
	 */
	protected function ensure_inline_widgets_whitelist( $sidebars_widgets ) {
		foreach ( $this->inline_widget_areas as $widget_area_id ) {
			if ( empty( $sidebars_widgets[ $widget_area_id ] ) ) {
				continue;
			}

			if ( empty( $this->inline_widgets ) ) {
				$sidebars_widgets[ $widget_area_id ] = array();
				continue;
			}

			foreach ( $sidebars_widgets[ $widget_area_id ] as $index => $widget_instance_id ) {
				if ( preg_match( '/-(\d+)$/', $widget_instance_id, $matches ) ) {
					$widget_id = substr( $widget_instance_id, 0, - strlen( $matches[0] ) );
					if ( ! in_array( $widget_id, $this->inline_widgets, true ) ) {
						unset( $sidebars_widgets[ $widget_area_id ][ $index ] );
					}
				} elseif ( ! in_array( $widget_instance_id, $this->inline_widgets, true ) ) {
					unset( $sidebars_widgets[ $widget_area_id ][ $index ] );
				}
			}

			$sidebars_widgets[ $widget_area_id ] = array_values( $sidebars_widgets[ $widget_area_id ] );
		}

		return $sidebars_widgets;
	}

	/**
	 * Registers Customizer controls, sections and a panel for all registered content types and their behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_controls( $customizer ) {
		$this->customizer = $customizer;

		if ( is_admin() ) {
			$this->trigger_customizer_init();
		} else {
			add_action( 'wp', array( $this, 'trigger_customizer_init' ), 10, 0 );
		}
	}

	/**
	 * Registers scripts for the Customizer controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_controls_js( $assets ) {
		$data = array(
			'inlineWidgetAreas' => $this->inline_widget_areas,
			'inlineWidgets'     => $this->inline_widgets,
		);

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-widgets-customize-controls',
			get_theme_file_uri( '/assets/dist/js/widgets.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeWidgetsControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'widgets_init', array( $this, 'trigger_init' ), 10, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_controls' ) );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
	}
}
