<?php
/**
 * Super_Awesome_Theme_Webfont_Family class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme webfont family.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Webfont_Family extends Super_Awesome_Theme_Font_Family {

	/**
	 * Files property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_FILES = 'files';

	/**
	 * Font family files.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $files;

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
		$defaults                       = parent::get_defaults();
		$defaults[ self::PROP_INCLUDE ] = false;
		$defaults[ self::PROP_FILES ]   = array();

		return $defaults;
	}
}
