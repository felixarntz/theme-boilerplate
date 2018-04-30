<?php
/**
 * Super_Awesome_Theme_Customizer_Not_Initialized_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when a Customizer method is called while the Customizer is not initialized.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Customizer_Not_Initialized_Exception extends RuntimeException {

	/**
	 * Creates an exception from a given method and ID passed to that method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Customizer method name.
	 * @param string $id     ID passed to the called method.
	 * @return Super_Awesome_Theme_Customizer_Not_Initialized_Exception Exception for the given values.
	 */
	public static function from_method_and_id( $method, $id ) {
		/* translators: 1: method name, 2: identifier */
		$message = sprintf( __( 'Customizer method %1$s with ID %2$s cannot be called before Customizer initialization.', 'super-awesome-theme' ), $method, $id );

		return new self( $message );
	}
}
