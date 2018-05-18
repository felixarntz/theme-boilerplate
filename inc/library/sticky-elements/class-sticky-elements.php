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
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_settings':
			case 'register_customize_controls':
			case 'add_customizer_script_data':
			case 'add_main_script_data':
				return call_user_func_array( array( $this, $method ), $args );
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
			$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting(
				'sticky_' . $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_ID ),
				array(
					Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_DEFAULT ),
				)
			) );
		}
	}

	/**
	 * Registers Customizer controls for navbar behavior.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_controls( $customizer ) {
		if ( empty( $this->sticky_elements ) ) {
			return;
		}

		$customizer->add_section( 'layout', array(
			Super_Awesome_Theme_Customize_Section::PROP_TITLE    => __( 'Layout', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Section::PROP_PRIORITY => 45,
		) );

		foreach ( $this->sticky_elements as $sticky ) {
			$customizer->add_control( 'sticky_' . $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_ID ), array(
				Super_Awesome_Theme_Customize_Control::PROP_SECTION => 'layout',
				Super_Awesome_Theme_Customize_Control::PROP_TITLE   => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_LABEL ),
				Super_Awesome_Theme_Customize_Control::PROP_TYPE    => Super_Awesome_Theme_Customize_Control::TYPE_CHECKBOX,
			) );
		}
	}

	/**
	 * Adds script data for Customizer functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_customizer_script_data() {
		$customizer = $this->get_dependency( 'customizer' );

		$stickies = array();
		foreach ( $this->sticky_elements as $sticky ) {
			$stickies[] = array(
				'setting'  => 'sticky_' . $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_ID ),
				'selector' => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR ),
				'location' => $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_LOCATION ),
			);
		}

		$preview_script = $customizer->get_preview_script();
		$preview_script->add_data( 'stickyElements', $stickies );
	}

	/**
	 * Adds script data for navigation functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_main_script_data() {
		$assets   = $this->get_dependency( 'assets' );
		$settings = $this->get_dependency( 'settings' );

		$stickies = array();
		foreach ( $this->sticky_elements as $sticky ) {
			if ( ! $settings->get( 'sticky_' . $sticky->get_prop( Super_Awesome_Theme_Sticky_Element::PROP_ID ) ) ) {
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
		add_action( 'init', array( $this, 'register_settings' ), 100, 0 );
		add_action( 'init', array( $this, 'add_customizer_script_data' ), 100, 0 );
		add_action( 'wp_head', array( $this, 'add_main_script_data' ), 0, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_controls' ) );
	}
}
