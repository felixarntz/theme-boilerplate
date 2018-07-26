<?php
/**
 * Super_Awesome_Theme_Font class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme font.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Font {

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
	 * Unique string identifier for the font.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Title for the font.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $title;

	/**
	 * Group the font belongs to.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $group;

	/**
	 * The default value for the font.
	 *
	 * @since 1.0.0
	 * @var mixed
	 */
	protected $default;

	/**
	 * Whether this font can be live-previewed in the Customizer.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	protected $live_preview;

	/**
	 * Setting instance for this font.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Setting
	 */
	protected $setting;

	/**
	 * Constructor.
	 *
	 * Sets the font definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this font.
	 * @param array  $args Font definition as $prop => $value pairs.
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

		if ( is_string( $this->default ) ) {
			$this->default = array( 'family' => $this->default );
		}

		$this->default = wp_parse_args( $this->default, array(
			'family' => '',
			'weight' => '400',
			'size'   => 1.0,
		) );

		/**
		 * Filters the available font family choices.
		 *
		 * @since 1.0.0
		 *
		 * @param array Font family choices as $value => $label pairs.
		 */
		$family_choices = apply_filters( 'super_awesome_theme_font_family_choices', array() );

		/**
		 * Filters the available font weight choices.
		 *
		 * @since 1.0.0
		 *
		 * @param array Font weight choices as $value => $label pairs.
		 */
		$weight_choices = apply_filters( 'super_awesome_theme_font_weight_choices', array() );

		$this->setting = new Super_Awesome_Theme_Object_Setting( $this->id, array(), array(
			new Super_Awesome_Theme_Enum_String_Setting( 'family', array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $family_choices ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => $this->default['family'],
			) ),
			new Super_Awesome_Theme_Enum_String_Setting( 'weight', array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $weight_choices ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => $this->default['weight'],
			) ),
			new Super_Awesome_Theme_Float_Setting( 'size', array(
				Super_Awesome_Theme_Float_Setting::PROP_MIN     => 0.5,
				Super_Awesome_Theme_Float_Setting::PROP_MAX     => 3.0,
				Super_Awesome_Theme_Float_Setting::PROP_DEFAULT => $this->default['size'],
			) ),
		) );
	}

	/**
	 * Gets the value for a font property.
	 *
	 * @since 1.0.0
	 *
	 * @param string $prop Property name.
	 * @return mixed Property value.
	 *
	 * @throws InvalidArgumentException Thrown when $prop is invalid.
	 */
	final public function get_prop( $prop ) {
		$props = $this->get_props();

		if ( ! array_key_exists( $prop, $props ) ) {

			/* translators: 1: property name, 2: font identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s font.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all font properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Font properties including ID as $prop => $value pairs.
	 */
	final public function get_props() {
		$props = array( 'id' => $this->id );

		$default_props = array_keys( $this->get_defaults() );
		foreach ( $default_props as $prop ) {
			$props[ $prop ] = $this->$prop;
		}

		return $props;
	}

	/**
	 * Gets the current value for the font setting.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Current value for the font setting.
	 */
	final public function get_value() {
		$value = $this->setting->get_value();

		/**
		 * Filters the font family stack string to use for a given font family identifier.
		 *
		 * @since 1.0.0
		 *
		 * @param string $stack_string Font family stack string to use in CSS, or empty string.
		 * @param string $family_id    Font family identifier, or empty string.
		 */
		$value['family_stack'] = apply_filters( 'super_awesome_theme_font_family_stack', '', $value['family'] );

		return $value;
	}

	/**
	 * Gets the setting instance for this font.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Setting Theme font setting.
	 */
	final public function get_setting() {
		return $this->setting;
	}

	/**
	 * Gets the default font definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default font definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every font property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		return array(
			self::PROP_TITLE        => '',
			self::PROP_GROUP        => 'fonts',
			self::PROP_DEFAULT      => array(),
			self::PROP_LIVE_PREVIEW => true,
		);
	}
}
