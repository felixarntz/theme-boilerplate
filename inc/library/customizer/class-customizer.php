<?php
/**
 * Super_Awesome_Theme_Customizer class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Customizer registry.
 *
 * Callbacks using an instance of this class should be passed to the
 * `on_init()` method.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Customizer extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Customize manager instance.
	 *
	 * @since 1.0.0
	 * @var WP_Customize_Manager
	 */
	private $wp_customize;

	/**
	 * The Customize preview script asset.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Script
	 */
	private $preview_script;

	/**
	 * The Customize preview script asset.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Script
	 */
	private $controls_script;

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
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
		if ( did_action( 'super_awesome_theme_customize_register_controls' ) ) {
			call_user_func( $callback, $this );
			return;
		}

		add_action( 'super_awesome_theme_customize_register_controls', $callback );
	}

	/**
	 * Registers a new Customizer panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string $panel_id   Unique panel identifier.
	 * @param array  $panel_args Optional. Panel arguments. Default empty array.
	 * @return WP_Customize_Panel Instance of the panel that was added.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception Thrown when the Customizer is not initialized yet.
	 */
	public function add_panel( $panel_id, $panel_args = array() ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $panel_id );
		}

		$panel = new WP_Customize_Panel( $this->wp_customize, $panel_id, $panel_args );

		return $this->wp_customize->add_panel( $panel );
	}

	/**
	 * Gets a registered Customizer panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string $panel_id Panel identifier.
	 * @return WP_Customize_Panel Panel instance.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception              Thrown when the Customizer is not initialized yet.
	 * @throws Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Thrown when the panel is not registered.
	 */
	public function get_panel( $panel_id ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $panel_id );
		}

		$panel = $this->wp_customize->get_panel( $panel_id );

		if ( ! $panel ) {
			throw Super_Awesome_Theme_Customize_Component_Not_Registered_Exception::from_panel_id( $panel_id );
		}

		return $panel;
	}

	/**
	 * Registers a new Customizer section.
	 *
	 * @since 1.0.0
	 *
	 * @param string $section_id   Unique section identifier.
	 * @param array  $section_args Optional. Section arguments. Default empty array.
	 * @return WP_Customize_Section Instance of the section that was added.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception Thrown when the Customizer is not initialized yet.
	 */
	public function add_section( $section_id, $section_args = array() ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $section_id );
		}

		$section = new WP_Customize_Section( $this->wp_customize, $section_id, $section_args );

		return $this->wp_customize->add_section( $section );
	}

	/**
	 * Gets a registered Customizer section.
	 *
	 * @since 1.0.0
	 *
	 * @param string $section_id Section identifier.
	 * @return WP_Customize_Section Section instance.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception              Thrown when the Customizer is not initialized yet.
	 * @throws Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Thrown when the section is not registered.
	 */
	public function get_section( $section_id ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $section_id );
		}

		$section = $this->wp_customize->get_section( $section_id );

		if ( ! $section ) {
			throw Super_Awesome_Theme_Customize_Component_Not_Registered_Exception::from_section_id( $section_id );
		}

		return $section;
	}

	/**
	 * Registers a new Customizer control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting_id   Setting identifier. Must reference a registered theme setting.
	 * @param array  $control_args Optional. Control arguments. Defaults will be populated depending
	 *                             on the setting definition.
	 * @return WP_Customize_Control Instance of the control that was added.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception Thrown when the Customizer is not initialized yet.
	 */
	public function add_control( $setting_id, $control_args = array() ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $setting_id );
		}

		$settings = $this->get_dependency( 'settings' );
		$setting  = $settings->get_registered_setting( $setting_id );

		if ( empty( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] ) ) {
			switch ( true ) {
				case $setting instanceof Super_Awesome_Theme_Boolean_Setting:
					$control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] = Super_Awesome_Theme_Customize_Control::TYPE_CHECKBOX;
					break;
				case $setting instanceof Super_Awesome_Theme_Float_Setting:
					$control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] = Super_Awesome_Theme_Customize_Control::TYPE_NUMBER;
					if ( empty( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ] ) ) {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ] = array();
					}
					$min = $setting->get_prop( Super_Awesome_Theme_Float_Setting::PROP_MIN );
					$max = $setting->get_prop( Super_Awesome_Theme_Float_Setting::PROP_MAX );
					if ( false !== $min && empty( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ]['min'] ) ) {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ]['min'] = $min;
					}
					if ( false !== $max && empty( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ]['max'] ) ) {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ]['max'] = $max;
					}
					if ( $setting instanceof Super_Awesome_Theme_Integer_Setting ) {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_INPUT_ATTRS ]['step'] = 1;
					}
					break;
				case $setting instanceof Super_Awesome_Theme_Enum_String_Setting:
					if ( empty( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_CHOICES ] ) ) {
						$enum                    = $setting->get_prop( Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM );
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_CHOICES ] = array_combine( $enum, $enum );
					}
					if ( count( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_CHOICES ] ) <= 5 ) {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] = Super_Awesome_Theme_Customize_Control::TYPE_RADIO;
					} else {
						$control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] = Super_Awesome_Theme_Customize_Control::TYPE_SELECT;
					}
					break;
				default:
					$control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] = Super_Awesome_Theme_Customize_Control::TYPE_TEXT;
			}
		}

		$control_class = 'WP_Customize_Control';
		if ( Super_Awesome_Theme_Customize_Control::TYPE_COLOR === $control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] ) {
			$control_class = 'WP_Customize_Color_Control';
			unset( $control_args[ Super_Awesome_Theme_Customize_Control::PROP_TYPE ] );
		}

		$control = new $control_class( $this->wp_customize, $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID ), $control_args );

		return $this->wp_customize->add_control( $control );
	}

	/**
	 * Gets a registered Customizer control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting_id Setting identifier. Must reference a registered theme setting.
	 * @return WP_Customize_Control Control instance.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception              Thrown when the Customizer is not initialized yet.
	 * @throws Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Thrown when the control is not registered.
	 */
	public function get_control( $setting_id ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $setting_id );
		}

		$settings   = $this->get_dependency( 'settings' );
		$setting    = $settings->get_registered_setting( $setting_id );
		$setting_id = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );

		$control = $this->wp_customize->get_control( $setting_id );

		if ( ! $control ) {
			throw Super_Awesome_Theme_Customize_Component_Not_Registered_Exception::from_control_id( $setting_id );
		}

		return $control;
	}

	/**
	 * Registers a new Customizer partial for selective refresh.
	 *
	 * @since 1.0.0
	 *
	 * @param string $partial_id   Unique partial identifier. If it matches a identifier
	 *                             of the setting, it will use that setting's value as trigger.
	 *                             Otherwise, a 'settings' array must be passed as part of the
	 *                             partial arguments.
	 * @param array  $partial_args Optional. Partial arguments. Default empty array.
	 * @return WP_Customize_Partial Instance of the partial that was added.
	 *
	 * @throws Super_Awesome_Theme_Customizer_Not_Loaded_Exception Thrown when the Customizer is not initialized yet.
	 */
	public function add_partial( $partial_id, $partial_args = array() ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $setting_id );
		}

		$partial = new WP_Customize_Partial( $this->wp_customize->selective_refresh, $partial_id, $partial_args );

		return $this->wp_customize->selective_refresh->add_partial( $partial );
	}

	/**
	 * Changes the transport mode of a registered setting for the Customizer.
	 *
	 * @param string $setting_id Setting identifier. Must reference a registered theme setting.
	 * @param string $transport  Transport mode. Either 'refresh' or 'postMessage'. By default,
	 *                           all settings are registered with 'postMessage'.
	 */
	public function set_setting_transport( $setting_id, $transport ) {
		if ( ! isset( $this->wp_customize ) ) {
			throw Super_Awesome_Theme_Customizer_Not_Loaded_Exception::from_method_and_id( __METHOD__, $setting_id );
		}

		$settings = $this->get_dependency( 'settings' );
		$setting  = $settings->get_registered_setting( $setting_id );

		$this->wp_customize->get_setting( $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID ) )->transport = $transport;
	}

	/**
	 * Gets the Customize preview script asset.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Script Customize preview script.
	 */
	public function get_preview_script() {
		return $this->get_dependency( 'assets' )->get_registered_asset( 'super-awesome-theme-customize-preview' );
	}

	/**
	 * Gets the Customize controls script asset.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Script Customize controls script.
	 */
	public function get_controls_script() {
		return $this->get_dependency( 'assets' )->get_registered_asset( 'super-awesome-theme-customize-controls' );
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
				if ( empty( $args ) ) {
					return;
				}

				$this->wp_customize = $args[0];

				$this->modify_core_defaults();

				/**
				 * Fires when theme functionality for the Customizer should be registered.
				 *
				 * Do not use this hook directly, but instead call provide your callback to
				 * the Super_Awesome_Theme_Customizer::on_init() method.
				 *
				 * @since 1.0.0
				 *
				 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
				 */
				do_action( 'super_awesome_theme_customize_register_controls', $this );
				break;
			case 'register_scripts':
				$this->register_scripts();
				break;
			case 'partial_blogname':
				bloginfo( 'name' );
				break;
			case 'partial_blogdescription':
				bloginfo( 'description' );
				break;
		}
	}

	/**
	 * Registers the Customizer preview and controls scripts.
	 *
	 * @since 1.0.0
	 */
	private function register_scripts() {
		$assets = $this->get_dependency( 'assets' );

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-customize-preview',
			get_theme_file_uri( '/assets/dist/js/customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview', 'customize-selective-refresh' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeCustomizeData',
			)
		) );

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-customize-controls',
			get_theme_file_uri( '/assets/dist/js/customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeCustomizeData',
			)
		) );

		$preview_script = $assets->get_registered_asset( 'super-awesome-theme-customize-preview' );

		$preview_script->add_data( 'headerTextalignChoices', super_awesome_theme_customize_get_header_textalign_choices() );
		$preview_script->add_data( 'sidebarModeChoices', super_awesome_theme_customize_get_sidebar_mode_choices() );
		$preview_script->add_data( 'sidebarSizeChoices', super_awesome_theme_customize_get_sidebar_size_choices() );
		$preview_script->add_data( 'barJustifyContentChoices', super_awesome_theme_customize_get_bar_justify_content_choices() );

		$controls_script = $assets->get_registered_asset( 'super-awesome-theme-customize-controls' );

		$controls_script->add_data( 'i18n', array(
			'blogSidebarEnabledNotice' => __( 'This page doesn&#8217;t support the blog sidebar. Navigate to the blog page or another page that supports it.', 'super-awesome-theme' ),
		) );
	}

	/**
	 * Modifies core defaults for the Customizer.
	 *
	 * The 'blogname' and 'blogdescription' settings are changed to use selective refresh.
	 *
	 * @since 1.0.0
	 */
	private function modify_core_defaults() {
		$core_setting_selectors = array(
			'blogname'        => '.site-title a',
			'blogdescription' => '.site-description',
		);

		foreach ( $core_setting_selectors as $setting => $selector ) {
			$this->wp_customize->get_setting( $setting )->transport = Super_Awesome_Theme_Customize_Setting::TRANSPORT_POST_MESSAGE;

			$this->wp_customize->selective_refresh->add_partial( $setting, array(
				Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR        => $selector,
				Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK => array( $this, 'partial_' . $setting ),
			) );
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'customize_register', array( $this, 'trigger_init' ), 10, 1 );
		add_action( 'after_setup_theme', array( $this, 'register_scripts' ), 10, 0 );
	}
}
