<?php
/**
 * Super_Awesome_Theme_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme setting.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Setting {

	/**
	 * ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ID = 'id';

	/**
	 * Capability property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_CAPABILITY = 'capability';

	/**
	 * Default property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEFAULT = 'default';

	/**
	 * Validate callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_VALIDATE_CALLBACK = 'validate_callback';

	/**
	 * Sanitize callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_SANITIZE_CALLBACK = 'sanitize_callback';

	/**
	 * Parse callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_PARSE_CALLBACK = 'parse_callback';

	/**
	 * Unique string identifier for the setting.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Capability required to edit this setting.
	 *
	 * @since 1.0.0
	 * @var string|array
	 */
	protected $capability;

	/**
	 * The default value for the setting.
	 *
	 * @since 1.0.0
	 * @var mixed
	 */
	protected $default;

	/**
	 * Validation callback for the setting's value.
	 *
	 * @since 1.0.0
	 * @var callable
	 */
	protected $validate_callback;

	/**
	 * Sanitization callback for the setting's value in un-slashed form.
	 *
	 * @since 1.0.0
	 * @var callable
	 */
	protected $sanitize_callback;

	/**
	 * Parse callback for the setting's value coming from the database.
	 *
	 * @since 1.0.0
	 * @var callable
	 */
	protected $parse_callback;

	/**
	 * Constructor.
	 *
	 * Sets the setting definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this setting.
	 * @param array  $args Setting definition as $prop => $value pairs.
	 */
	public function __construct( $id, array $args = array() ) {
		$this->id = (string) $id;

		$defaults = $this->get_defaults();
		foreach ( $defaults as $prop => $default_value ) {
			if ( array_key_exists( $prop, $args ) ) {
				$this->$prop = $args[ $prop ];
			} else {
				$this->$prop = $default_value;
			}
		}
	}

	/**
	 * Gets the value for a setting property.
	 *
	 * @since 1.0.0
	 *
	 * @param string $prop Property name.
	 * @return mixed Property value.
	 *
	 * @throws InvalidArgumentException Thrown when $prop is invalid.
	 */
	public final function get_prop( $prop ) {
		$props = $this->get_props();

		if ( ! array_key_exists( $prop, $props ) ) {

			/* translators: 1: property name, 2: setting identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s setting.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all setting properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Setting properties including ID as $prop => $value pairs.
	 */
	public final function get_props() {
		$props = array( 'id' => $this->id );

		$default_props = array_keys( $this->get_defaults() );
		foreach ( $default_props as $prop ) {
			$props[ $prop ] = $this->$prop;
		}

		return $props;
	}

	/**
	 * Gets the current value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Current value for the setting, or the default value.
	 */
	public final function get_value() {
		$value = get_theme_mod( $this->id, $this->default );

		return $this->parse_value( $value );
	}

	/**
	 * Validates a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Error $validity Error object to add validation errors to.
	 * @param mixed    $value    Value to validate.
	 * @return bool|WP_Error True on success, error object on failure.
	 */
	public final function validate_value( WP_Error $validity, $value ) {
		$validity = $this->default_validation_callback( $validity, $value );

		if ( null !== $this->validate_callback ) {
			$validity = call_user_func( $this->validate_callback, $validity, $value );
		}

		if ( is_wp_error( $validity ) ) {
			if ( empty( $validity->errors ) ) {
				$validity = true;
			}
			return $validity;
		}

		if ( ! $validity ) {
			return new WP_Error( 'invalid_value', __( 'Invalid value.', 'super-awesome-theme' ) );
		}

		return true;
	}

	/**
	 * Sanitizes a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to sanitize.
	 * @return mixed Sanitized value.
	 */
	public final function sanitize_value( $value ) {
		$value = $this->default_sanitization_callback( $value );

		if ( null !== $this->sanitize_callback ) {
			$value = call_user_func( $this->sanitize_callback, $value );
		}

		return $value;
	}

	/**
	 * Parses a value for the setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to parse.
	 * @return mixed Parsed value.
	 */
	public final function parse_value( $value ) {
		$value = $this->default_parsing_callback( $value );

		if ( null !== $this->parse_callback ) {
			$value = call_user_func( $this->parse_callback, $value );
		}

		return $value;
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
		return $value;
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
		return $value;
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
		return array(
			self::PROP_CAPABILITY        => 'edit_theme_options',
			self::PROP_DEFAULT           => false,
			self::PROP_VALIDATE_CALLBACK => null,
			self::PROP_SANITIZE_CALLBACK => null,
			self::PROP_PARSE_CALLBACK    => null,
		);
	}
}
