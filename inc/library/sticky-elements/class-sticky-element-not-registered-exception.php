<?php
/**
 * Super_Awesome_Theme_Sticky_Element_Not_Registered_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when a sticky element is not registered when it is requested.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Sticky_Element_Not_Registered_Exception extends InvalidArgumentException {

	/**
	 * Creates an exception from a given sticky element identifier.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Sticky element identifier.
	 * @return Super_Awesome_Theme_Sticky_Element_Not_Registered_Exception Exception for the given handle.
	 */
	public static function from_id( $id ) {
		/* translators: %s: sticky element identifier */
		$message = sprintf( __( '%s is not a registered sticky element.', 'super-awesome-theme' ), $id );

		return new self( $message );
	}
}
