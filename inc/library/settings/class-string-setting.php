<?php
/**
 * Super_Awesome_Theme_String_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting in string format.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_String_Setting extends Super_Awesome_Theme_Setting {

	/**
	 * Performs default sanitization for a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to sanitize.
	 * @return mixed Sanitized value.
	 */
	protected function default_sanitization_callback( $value ) {
		return (string) parent::default_sanitization_callback( $value );
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
		return (string) parent::default_parsing_callback( $value );
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
		$defaults['default'] = '';

		return $defaults;
	}
}
