<?php
/**
 * Super_Awesome_Theme_Enum_String_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting in string format that is one of a set of possible values.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Enum_String_Setting extends Super_Awesome_Theme_String_Setting {

	/**
	 * Whitelist of choices the value can be.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $enum;

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

		if ( ! in_array( (string) $value, array_map( 'strval', $this->enum ), true ) ) {
			$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
		}

		return $validity;
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
		$defaults         = parent::get_defaults();
		$defaults['enum'] = array();

		return $defaults;
	}
}
