<?php
/**
 * Super_Awesome_Theme_Font_Family class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme font family.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Font_Family {

	/**
	 * ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ID = 'id';

	/**
	 * Label property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LABEL = 'label';

	/**
	 * Stack property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_STACK = 'stack';

	/**
	 * Group property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_GROUP = 'group';

	/**
	 * System fonts group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_SYSTEM = 'system';

	/**
	 * Sans serif group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_SANS_SERIF = 'sans-serif';

	/**
	 * Serif group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_SERIF = 'serif';

	/**
	 * Display group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_DISPLAY = 'display';

	/**
	 * Handwriting group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_HANDWRITING = 'handwriting';

	/**
	 * Monospace group name.
	 *
	 * @since 1.0.0
	 */
	const GROUP_MONOSPACE = 'monospace';

	/**
	 * Unique string identifier for the font family.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Label for the font family.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $label;

	/**
	 * Font family stack.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $stack;

	/**
	 * Font family group.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $group;

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
	 * Gets the font family stack as a string to use in CSS.
	 *
	 * @since 1.0.0
	 *
	 * @return string Family stack for the font family.
	 */
	final public function get_stack_string() {
		return implode( ', ', array_map( array( $this, 'enquote_stack_family' ), $this->stack ) );
	}

	/**
	 * Adds double-quotes to a font family if it contains whitespace.
	 *
	 * @since 1.0.0
	 *
	 * @param string $family Font family name.
	 * @return string Font family name, possibly including double-quotes.
	 */
	final private function enquote_stack_family( $family ) {
		$family = trim( $family, ' "' );
		if ( false !== strpos( $family, ' ' ) ) {
			return '"' . $family . '"';
		}

		return $family;
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
			self::PROP_LABEL => '',
			self::PROP_STACK => array(),
			self::PROP_GROUP => self::GROUP_SANS_SERIF,
		);
	}
}
