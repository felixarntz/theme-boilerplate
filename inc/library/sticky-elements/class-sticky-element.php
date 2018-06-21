<?php
/**
 * Super_Awesome_Theme_Sticky_Element class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a sticky theme frontend element.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Sticky_Element {

	/**
	 * ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ID = 'id';

	/**
	 * Selector property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_SELECTOR = 'selector';

	/**
	 * Label property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LABEL = 'label';

	/**
	 * Default property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEFAULT = 'default';

	/**
	 * Location property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LOCATION = 'location';

	/**
	 * Identifier for the top location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_TOP = 'top';

	/**
	 * Identifier for the bottom location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_BOTTOM = 'bottom';

	/**
	 * Unique string identifier for the sticky element.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Selector for this sticky element.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $selector;

	/**
	 * Label for this sticky element's checkbox in the Customizer.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $label;

	/**
	 * The default value for the sticky element.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	protected $default;

	/**
	 * Location where the sticky element should stick. Either 'top' or 'bottom'.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $location;

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
	 * Sets the sticky element definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this sticky element.
	 * @param array  $args Sticky element definition as $prop => $value pairs.
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

		$this->setting = new Super_Awesome_Theme_Boolean_Setting( 'sticky_' . $this->id, array(
			Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => $this->default,
		) );
	}

	/**
	 * Gets the value for a sticky element property.
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

			/* translators: 1: property name, 2: sticky element identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s sticky element.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all sticky element properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Sticky element properties including ID as $prop => $value pairs.
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
	 * Gets the setting instance for this color.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Setting Theme color setting.
	 */
	final public function get_setting() {
		return $this->setting;
	}

	/**
	 * Checks whether the sticky element is currently sticky.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if element is sticky, false otherwise.
	 */
	final public function is_sticky() {
		return $this->setting->get_value();
	}

	/**
	 * Gets the default sticky element definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default sticky element definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every sticky element property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		return array(
			self::PROP_SELECTOR => '',
			self::PROP_LABEL    => '',
			self::PROP_DEFAULT  => false,
			self::PROP_LOCATION => self::LOCATION_TOP,
		);
	}
}
