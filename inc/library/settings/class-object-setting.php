<?php
/**
 * Super_Awesome_Theme_Object_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting in object format.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Object_Setting extends Super_Awesome_Theme_Setting {

	/**
	 * Settings to use for each individual object property.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $properties_settings;

	/**
	 * Constructor.
	 *
	 * Sets the setting definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id                  Unique string identifier for this setting.
	 * @param array  $args                Setting definition as $prop => $value pairs.
	 * @param array  $properties_settings Optional. Settings to use for each individual object property.
	 */
	public function __construct( $id, array $args = array(), array $properties_settings = array() ) {
		$this->properties_settings = $properties_settings;

		parent::__construct( $id, $args );
	}

	/**
	 * Performs default validation for a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Error $validity Error object to add validation errors to.
	 * @param mixed    $value    Value to validate.
	 * @return WP_Error Error object to add possible errors to.
	 */
	protected function default_validation_callback( WP_Error $validity, $value ) {
		$value = (array) $value;

		foreach ( $this->properties_settings as $setting ) {
			$id             = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );
			$property_value = array_key_exists( $id, $value ) ? $value[ $id ] : null;

			$setting->validate_value( $validity, $property_value );
		}

		return parent::default_validation_callback( $validity, $value );
	}

	/**
	 * Performs default sanitization for a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to sanitize.
	 * @return mixed Sanitized value.
	 */
	protected function default_sanitization_callback( $value ) {
		$value = (array) $value;

		foreach ( $this->properties_settings as $setting ) {
			$id             = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );
			$default        = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_DEFAULT );
			$property_value = array_key_exists( $id, $value ) ? $value[ $id ] : $default;

			$value[ $id ] = $setting->sanitize_value( $property_value );
		}

		return parent::default_sanitization_callback( $value );
	}

	/**
	 * Performs default parsing for a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to parse.
	 * @return mixed Parsed value.
	 */
	protected function default_parsing_callback( $value ) {
		$value = (array) $value;

		foreach ( $this->properties_settings as $setting ) {
			$id             = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );
			$default        = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_DEFAULT );
			$property_value = array_key_exists( $id, $value ) ? $value[ $id ] : $default;

			$value[ $id ] = $setting->parse_value( $property_value );
		}

		return parent::default_parsing_callback( $value );
	}

	/**
	 * Gets the default setting definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default setting definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every setting property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		$defaults                       = parent::get_defaults();
		$defaults[ self::PROP_DEFAULT ] = array();
		foreach ( $this->properties_settings as $setting ) {
			$id      = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_ID );
			$default = $setting->get_prop( Super_Awesome_Theme_Setting::PROP_DEFAULT );

			$defaults[ self::PROP_DEFAULT ][ $id ] = $default;
		}

		return $defaults;
	}
}
