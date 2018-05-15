<?php
/**
 * Super_Awesome_Theme_Args_Theme_Feature class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme feature with arbitrary arguments.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Args_Theme_Feature extends Super_Awesome_Theme_Theme_Feature {

	/**
	 * String identifier for the theme feature.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Arbitrary arguments for the theme feature.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $args;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id   String identifier for the theme feature.
	 * @param array  $args Optional. Arbitrary arguments for the theme feature.
	 */
	public function __construct( $id, array $args = array() ) {
		parent::__construct( $id );

		$this->args = $args;
	}

	/**
	 * Gets the value registered as theme support.
	 *
	 * @since 1.0.0
	 *
	 * @return array Theme support arguments, or empty array if not supported.
	 */
	public function get_support() {
		$args = parent::get_support();

		if ( is_array( $args ) && isset( $args[0] ) ) {
			return $args[0];
		}

		return array();
	}

	/**
	 * Adds support for this feature to core.
	 *
	 * @since 1.0.0
	 */
	public function add_support() {
		add_theme_support( $this->id, $this->args );
	}
}
