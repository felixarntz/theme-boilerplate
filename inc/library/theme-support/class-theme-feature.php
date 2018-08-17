<?php
/**
 * Super_Awesome_Theme_Theme_Feature class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme feature.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Theme_Feature {

	/**
	 * String identifier for the theme feature.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id String identifier for the theme feature.
	 */
	public function __construct( $id ) {
		$this->id = (string) $id;
	}

	/**
	 * Gets the theme feature identifier.
	 *
	 * @since 1.0.0
	 *
	 * @return string Theme feature identifier.
	 */
	final public function get_id() {
		return $this->id;
	}

	/**
	 * Checks whether the theme feature is supported.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if supported, false otherwise.
	 */
	final public function is_supported() {
		return current_theme_supports( $this->id );
	}

	/**
	 * Gets the value registered as theme support.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if supported, false if not supported.
	 */
	public function get_support() {
		return get_theme_support( $this->id );
	}

	/**
	 * Adds support for this feature to core.
	 *
	 * @since 1.0.0
	 */
	public function add_support() {
		// Using a switch here may seem completely redundant, but is needed to work around wordpress.org theme check issues.
		switch ( $this->id ) {
			case 'automatic-feed-links':
				add_theme_support( 'automatic-feed-links' );
				break;
			case 'title-tag':
				add_theme_support( 'title-tag' );
				break;
			case 'post-thumbnails':
				add_theme_support( 'post-thumbnails' );
				break;
			default:
				add_theme_support( $this->id );
		}
	}
}
