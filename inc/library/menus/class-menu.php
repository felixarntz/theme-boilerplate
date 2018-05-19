<?php
/**
 * Super_Awesome_Theme_Menu class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a menu.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Menu {

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
	 * Menu ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_MENU_ID = 'menu_id';

	/**
	 * Menu class property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_MENU_CLASS = 'menu_class';

	/**
	 * Before property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_BEFORE = 'before';

	/**
	 * After property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_AFTER = 'after';

	/**
	 * Link before property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LINK_BEFORE = 'link_before';

	/**
	 * Link after property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LINK_AFTER = 'link_after';

	/**
	 * Depth property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEPTH = 'depth';

	/**
	 * Fallback CB property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_FALLBACK_CB = 'fallback_cb';

	/**
	 * Unique string identifier for the menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Title of the menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $title;

	/**
	 * ID attribute to use for the menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $menu_id;

	/**
	 * CSS class to use for the menu.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $menu_class;

	/**
	 * HTML markup to print before each link markup.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $before;

	/**
	 * HTML markup to print after each link markup.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $after;

	/**
	 * HTML markup to print before each link text.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $link_before;

	/**
	 * HTML markup to print after each link text.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $link_after;

	/**
	 * How many levels of the hierarchy to include. 0 means all.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	protected $depth;

	/**
	 * Callback to use in case the menu has no content.
	 *
	 * @since 1.0.0
	 * @var callable|bool
	 */
	protected $fallback_cb;

	/**
	 * Constructor.
	 *
	 * Sets the menu definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this menu.
	 * @param array  $args Menu definition as $prop => $value pairs.
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
	 * Renders the menu output.
	 *
	 * @since 1.0.0
	 *
	 * @param int|string $menu Optional. Menu ID or slug to render that menu instead of the default menu
	 *                         present in the theme location. Default null.
	 */
	final public function render( $menu = null ) {
		$args = array(
			'theme_location' => $this->id,
			'menu_id'        => $this->menu_id,
			'menu_class'     => $this->menu_class,
			'before'         => $this->before,
			'after'          => $this->after,
			'link_before'    => $this->link_before,
			'link_after'     => $this->link_after,
			'depth'          => $this->depth,
			'fallback_cb'    => $this->fallback_cb,
			'container'      => false,
		);

		if ( $menu ) {
			$menu = wp_get_nav_menu_object( $menu );
			if ( $menu ) {
				$args['menu'] = $menu;
				unset( $args['theme_location'] );
			}
		}

		wp_nav_menu( $args );
	}

	/**
	 * Checks whether the menu is active (i.e. has content).
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the menu is active, false otherwise.
	 */
	final public function is_active() {
		return has_nav_menu( $this->id );
	}

	/**
	 * Gets the value for a menu property.
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

			/* translators: 1: property name, 2: menu identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s menu.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all menu properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Menu properties including ID as $prop => $value pairs.
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
	 * Gets the default menu definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default menu definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every menu property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		return array(
			self::PROP_TITLE       => '',
			self::PROP_MENU_ID     => '',
			self::PROP_MENU_CLASS  => 'menu',
			self::PROP_BEFORE      => '',
			self::PROP_AFTER       => '',
			self::PROP_LINK_BEFORE => '',
			self::PROP_LINK_AFTER  => '',
			self::PROP_DEPTH       => 0,
			self::PROP_FALLBACK_CB => false,
		);
	}
}
