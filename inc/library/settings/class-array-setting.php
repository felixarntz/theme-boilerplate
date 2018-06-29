<?php
/**
 * Super_Awesome_Theme_Array_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting in array format.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Array_Setting extends Super_Awesome_Theme_Setting {

	/**
	 * Setting to use for each individual array item.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Setting
	 */
	protected $items_setting;

	/**
	 * Constructor.
	 *
	 * Sets the setting definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string                      $id            Unique string identifier for this setting.
	 * @param array                       $args          Setting definition as $prop => $value pairs.
	 * @param Super_Awesome_Theme_Setting $items_setting Optional. Setting to use for each individual array item.
	 */
	public function __construct( $id, array $args = array(), Super_Awesome_Theme_Setting $items_setting = null ) {
		$this->items_setting = $items_setting;

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

		if ( null !== $this->items_setting ) {
			foreach ( $value as $item_value ) {
				$this->items_setting->validate_value( $validity, $item_value );
			}
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

		if ( null !== $this->items_setting ) {
			foreach ( $value as $index => $item_value ) {
				$value[ $index ] = $this->items_setting->sanitize_value( $item_value );
			}
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

		if ( null !== $this->items_setting ) {
			foreach ( $value as $index => $item_value ) {
				$value[ $index ] = $this->items_setting->parse_value( $item_value );
			}
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

		return $defaults;
	}
}
