<?php
/**
 * Super_Awesome_Theme_Color class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme color.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Color {

	/**
	 * ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ID = 'id';

	/**
	 * Title property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_TITLE = 'title';

	/**
	 * Group property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_GROUP = 'group';

	/**
	 * Default property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEFAULT = 'default';

	/**
	 * Live preview property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LIVE_PREVIEW = 'live_preview';

	/**
	 * Active callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ACTIVE_CALLBACK = 'active_callback';

	/**
	 * Unique string identifier for the color.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Title for the color.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $title;

	/**
	 * Group the color belongs to.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $group;

	/**
	 * The default value for the color.
	 *
	 * @since 1.0.0
	 * @var mixed
	 */
	protected $default;

	/**
	 * Whether this color can be live-previewed in the Customizer.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	protected $live_preview;

	/**
	 * Active callback to check whether the color is active.
	 *
	 * @since 1.0.0
	 * @var callable|null
	 */
	protected $active_callback;

	/**
	 * Setting instance for this color.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Setting
	 */
	protected $setting;

	/**
	 * Constructor.
	 *
	 * Sets the color definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this color.
	 * @param array  $args Color definition as $prop => $value pairs.
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

		$this->setting = new Super_Awesome_Theme_String_Setting( $this->id, array(
			Super_Awesome_Theme_String_Setting::PROP_DEFAULT           => $this->default,
			Super_Awesome_Theme_String_Setting::PROP_SANITIZE_CALLBACK => 'maybe_hash_hex_color',
		) );
	}

	/**
	 * Gets the value for a color property.
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

			/* translators: 1: property name, 2: color identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s color.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all color properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Color properties including ID as $prop => $value pairs.
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
	 * Gets the current value for the color setting.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Current value for the color setting.
	 */
	public final function get_value() {
		return $this->setting->get_value();
	}

	/**
	 * Gets the setting instance for this color.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Setting Theme color setting.
	 */
	public final function get_setting() {
		return $this->setting;
	}

	/**
	 * Checks whether this color is active in the theme.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the color is active, false otherwise.
	 */
	public function is_active() {
		if ( is_callable( $this->active_callback ) ) {
			return call_user_func( $this->active_callback );
		}

		return true;
	}

	/**
	 * Gets the default color definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default color definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every color property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		return array(
			self::PROP_TITLE           => '',
			self::PROP_GROUP           => 'colors',
			self::PROP_DEFAULT         => '',
			self::PROP_LIVE_PREVIEW    => true,
			self::PROP_ACTIVE_CALLBACK => null,
		);
	}
}
