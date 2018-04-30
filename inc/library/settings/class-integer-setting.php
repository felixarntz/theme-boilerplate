<?php
/**
 * Super_Awesome_Theme_Integer_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting in integer format.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Integer_Setting extends Super_Awesome_Theme_Setting {

	/**
	 * Minimum allowed value, or false for no restriction.
	 *
	 * @since 1.0.0
	 * @var int|bool
	 */
	protected $min;

	/**
	 * Maximum allowed value, or false for no restriction.
	 *
	 * @since 1.0.0
	 * @var int|bool
	 */
	protected $max;

	/**
	 * Performs default validation for a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Error $validity Error object to add validation errors to.
	 * @param mixed $value       Value to validate.
	 * @return WP_Error Error object to add possible errors to.
	 */
	protected function default_validation_callback( WP_Error $validity, $value ) {
		$validity = parent::default_validation_callback( $validity, $value );

		if ( false !== $this->min && (int) $value < $this->min ) {
			$validity->add( 'value_too_small', sprintf( __( 'Value must not be smaller than %s.', 'super-awesome-theme' ), number_format_i18n( $this->min, 0 ) ) );
		}

		if ( false !== $this->max && (int) $value > $this->max ) {
			$validity->add( 'value_too_great', sprintf( __( 'Value must not be greater than %s.', 'super-awesome-theme' ), number_format_i18n( $this->max, 0 ) ) );
		}

		return $validity;
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
		return (int) parent::default_sanitization_callback( $value );
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
		return (int) parent::default_parsing_callback( $value );
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
		$defaults            = parent::get_defaults();
		$defaults['default'] = 0;
		$defaults['min']     = false;
		$defaults['max']     = false;

		return $defaults;
	}
}
