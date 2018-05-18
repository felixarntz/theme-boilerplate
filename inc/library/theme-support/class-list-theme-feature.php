<?php
/**
 * Super_Awesome_Theme_List_Theme_Feature class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme feature where a list must be passed.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_List_Theme_Feature extends Super_Awesome_Theme_Theme_Feature {

	/**
	 * String identifier for the theme feature.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * List values for the theme feature.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $values;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id     String identifier for the theme feature.
	 * @param array  $values Optional. List values for the theme feature.
	 */
	public function __construct( $id, array $values = array() ) {
		parent::__construct( $id );

		$this->values = $values;
	}

	/**
	 * Gets the value registered as theme support.
	 *
	 * @since 1.0.0
	 *
	 * @return array Theme support list values, or empty array if not supported.
	 */
	public function get_support() {
		$values = parent::get_support();

		if ( is_array( $values ) ) {
			return $values;
		}

		return array();
	}

	/**
	 * Adds support for this feature to core.
	 *
	 * @since 1.0.0
	 */
	public function add_support() {
		$args = $this->values;
		array_unshift( $args, $this->id );

		call_user_func_array( 'add_theme_support', $args );
	}
}
