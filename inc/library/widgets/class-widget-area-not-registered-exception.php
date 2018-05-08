<?php
/**
 * Super_Awesome_Theme_Widget_Area_Not_Registered_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when a widget area is not registered when it is requested.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Widget_Area_Not_Registered_Exception extends InvalidArgumentException {

	/**
	 * Creates an exception from a given widget area identifier.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Widget area identifier.
	 * @return Super_Awesome_Theme_Widget_Area_Not_Registered_Exception Exception for the given identifier.
	 */
	public static function from_id( $id ) {
		/* translators: %s: widget area identifier */
		$message = sprintf( __( '%s is not a registered widget area.', 'super-awesome-theme' ), $id );

		return new self( $message );
	}
}
