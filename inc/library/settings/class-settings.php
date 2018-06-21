<?php
/**
 * Super_Awesome_Theme_Settings class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Theme settings registry.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Settings extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered theme settings.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $settings = array();

	/**
	 * Gets the value for a theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this setting.
	 * @return mixed Value for the setting, or null if setting is not registered.
	 */
	public function get( $id ) {
		if ( ! isset( $this->settings[ $id ] ) ) {
			return null;
		}

		return $this->settings[ $id ]->get_value();
	}

	/**
	 * Registers a theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Setting $setting Setting to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_setting( Super_Awesome_Theme_Setting $setting ) {
		$id = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );

		if ( isset( $this->settings[ $id ] ) ) {
			return false;
		}

		$this->settings[ $id ] = $setting;

		return true;
	}

	/**
	 * Gets a registered theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this setting.
	 * @return Super_Awesome_Theme_Setting Registered setting instance.
	 *
	 * @throws Super_Awesome_Theme_Setting_Not_Registered_Exception Thrown when $id does not identify a registered setting.
	 */
	public function get_registered_setting( $id ) {
		if ( ! isset( $this->settings[ $id ] ) ) {
			throw Super_Awesome_Theme_Setting_Not_Registered_Exception::from_id( $id );
		}

		return $this->settings[ $id ];
	}

	/**
	 * Gets all registered theme settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $setting pairs, where each $setting is a
	 *               registered Super_Awesome_Theme_Setting instance.
	 */
	public function get_registered_settings() {
		return $this->settings;
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
		if ( 'register_in_customizer' !== $method || empty( $args ) ) {
			return;
		}

		$wp_customize = $args[0];

		foreach ( $this->settings as $setting ) {
			$id   = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );
			$args = array(
				Super_Awesome_Theme_Customize_Setting::PROP_CAPABILITY           => $setting->get_prop( Super_Awesome_Theme_Setting::PROP_CAPABILITY ),
				Super_Awesome_Theme_Customize_Setting::PROP_TYPE                 => Super_Awesome_Theme_Customize_Setting::TYPE_THEME_MOD,
				Super_Awesome_Theme_Customize_Setting::PROP_DEFAULT              => $setting->get_prop( Super_Awesome_Theme_Setting::PROP_DEFAULT ),
				Super_Awesome_Theme_Customize_Setting::PROP_TRANSPORT            => Super_Awesome_Theme_Customize_Setting::TRANSPORT_REFRESH,
				Super_Awesome_Theme_Customize_Setting::PROP_VALIDATE_CALLBACK    => array( $setting, 'validate_value' ),
				Super_Awesome_Theme_Customize_Setting::PROP_SANITIZE_CALLBACK    => array( $setting, 'sanitize_value' ),
				Super_Awesome_Theme_Customize_Setting::PROP_SANITIZE_JS_CALLBACK => array( $setting, 'parse_value' ),
			);

			$wp_customize->add_setting( $id, $args );
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'customize_register', array( $this, 'register_in_customizer' ), 1, 1 );
	}
}
