<?php
/**
 * Super_Awesome_Theme_Widget_Area class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a widget area.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Widget_Area {

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
	 * Description property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DESCRIPTION = 'description';

	/**
	 * Before widget property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_BEFORE_WIDGET = 'before_widget';

	/**
	 * After widget property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_AFTER_WIDGET = 'after_widget';

	/**
	 * Before title property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_BEFORE_TITLE = 'before_title';

	/**
	 * After title property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_AFTER_TITLE = 'after_title';

	/**
	 * Inline property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_INLINE = 'inline';

	/**
	 * Unique string identifier for the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Title of the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $title;

	/**
	 * Description of the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $description;

	/**
	 * HTML markup to print before each widget in the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $before_widget;

	/**
	 * HTML markup to print after each widget in the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $after_widget;

	/**
	 * HTML markup to print before each widget title in the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $before_title;

	/**
	 * HTML markup to print after each widget title in the widget area.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $after_title;

	/**
	 * Whether this is an inline widget area.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	protected $inline;

	/**
	 * Constructor.
	 *
	 * Sets the widget area definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   Unique string identifier for this widget area.
	 * @param array  $args Widget area definition as $prop => $value pairs.
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

		if ( empty( $this->before_widget ) || empty( $this->after_widget ) ) {
			if ( $this->inline ) {
				$this->before_widget = '<div id="%1$s" class="inline-widget %2$s">';
				$this->after_widget  = '</div>';
			} else {
				$this->before_widget = '<section id="%1$s" class="widget %2$s">';
				$this->after_widget  = '</section>';
			}
		}

		if ( empty( $this->before_title ) || empty( $this->after_title ) ) {
			if ( $this->inline ) {
				$this->before_title = '<span class="inline-widget-title">';
				$this->after_title  = '</span>';
			} else {
				$this->before_title = '<h2 class="widget-title">';
				$this->after_title  = '</h2>';
			}
		}
	}

	/**
	 * Renders the widget area output.
	 *
	 * @since 1.0.0
	 */
	final public function render() {
		dynamic_sidebar( $this->id );
	}

	/**
	 * Checks whether the widget area is active (i.e. has content).
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the widget area is active, false otherwise.
	 */
	final public function is_active() {
		return is_active_sidebar( $this->id );
	}

	/**
	 * Renders a single arbitrary widget as if it was part of this widget area.
	 *
	 * @since 1.0.0
	 *
	 * @param string $widget   The widget's PHP class name that was used for register_widget().
	 * @param array  $instance Optional. The widget's instance settings. Default empty array.
	 */
	final public function render_single_widget( $widget, $instance = array() ) {
		the_widget(
			$widget,
			$instance,
			array(
				'before_widget' => str_replace( array( ' id="%1$s"', '%2$s' ), array( '', '%s' ), $this->before_widget ),
				'after_widget'  => $this->after_widget,
				'before_title'  => $this->before_title,
				'after_title'   => $this->after_title,
			)
		);
	}

	/**
	 * Gets the value for a widget area property.
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

			/* translators: 1: property name, 2: widget area identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s widget area.', 'super-awesome-theme' ), $prop, $this->id ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all widget area properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Widget area properties including ID as $prop => $value pairs.
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
	 * Gets the default widget area definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default widget area definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every widget area property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		return array(
			self::PROP_TITLE         => '',
			self::PROP_DESCRIPTION   => '',
			self::PROP_BEFORE_WIDGET => '',
			self::PROP_AFTER_WIDGET  => '',
			self::PROP_BEFORE_TITLE  => '',
			self::PROP_AFTER_TITLE   => '',
			self::PROP_INLINE        => false,
		);
	}
}
