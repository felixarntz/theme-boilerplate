<?php
/**
 * Super_Awesome_Theme_Sticky_Elements class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for managing sticky frontend elements.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Sticky_Elements extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered theme sticky elements.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $sticky_elements = array();

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
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
	}

	/**
	 * Registers a sticky theme frontend element.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Sticky_Element $sticky Sticky element to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_sticky_element( Super_Awesome_Theme_Sticky_Element $sticky ) {
		$id = $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_ID );

		if ( isset( $this->sticky_elements[ $id ] ) ) {
			return false;
		}

		$this->sticky_elements[ $id ] = $sticky;

		return true;
	}

	/**
	 * Gets a registered sticky theme frontend element.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this setting.
	 * @return Super_Awesome_Theme_Sticky_Element Registered setting instance.
	 *
	 * @throws Super_Awesome_Theme_Sticky_Element_Not_Registered_Exception Thrown when $id does not identify a registered setting.
	 */
	public function get_registered_sticky_element( $id ) {
		if ( ! isset( $this->sticky_elements[ $id ] ) ) {
			throw Super_Awesome_Theme_Sticky_Element_Not_Registered_Exception::from_id( $id );
		}

		return $this->sticky_elements[ $id ];
	}

	/**
	 * Gets all registered sticky theme frontend elements.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $sticky pairs, where each $sticky is a
	 *               registered Super_Awesome_Theme_Sticky_Element instance.
	 */
	public function get_registered_sticky_elements() {
		return $this->sticky_elements;
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
			case 'register_settings':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
			case 'add_main_script_data':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers settings for navbar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		foreach ( $this->sticky_elements as $sticky ) {
			$settings->register_setting( $sticky->get_setting() );
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
			'stickyElements' => array(),
		);

		foreach ( $this->sticky_elements as $id => $sticky ) {
			$props            = $sticky->get_props();
			$props['setting'] = $sticky->get_setting()->get_prop( Super_Awesome_Theme_Setting::PROP_ID );

			$data['stickyElements'][] = $props;
		}

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-sticky-elements-customize-controls',
			get_theme_file_uri( '/assets/dist/js/sticky-elements.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeStickyElementsControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Registers scripts for the Customizer preview.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_preview_js( $assets ) {
		$data = array(
			'stickyElements' => array(),
		);

		foreach ( $this->sticky_elements as $id => $sticky ) {
			$data['stickyElements'][] = array(
				'setting'  => $sticky->get_setting()->get_prop( Super_Awesome_Theme_Setting::PROP_ID ),
				'selector' => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR ),
				'location' => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_LOCATION ),
			);
		}

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-sticky-elements-customize-preview',
			get_theme_file_uri( '/assets/dist/js/sticky-elements.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeStickyElementsPreviewData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Adds script data for navigation functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_main_script_data() {
		$assets = $this->get_dependency( 'assets' );

		$stickies = array();
		foreach ( $this->sticky_elements as $sticky ) {
			if ( ! $sticky->get_setting()->get_value() ) {
				continue;
			}

			$selector = $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR );
			$location = $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_LOCATION );

			$stickies[ $selector ] = $location;
		}

		$script = $assets->get_registered_asset( 'super-awesome-theme-script' );
		$script->add_data( 'sticky', $stickies );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_settings' ), 100, 0 );
		add_action( 'wp_head', array( $this, 'add_main_script_data' ), 0, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
