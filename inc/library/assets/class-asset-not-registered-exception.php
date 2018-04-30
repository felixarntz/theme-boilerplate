<?php
/**
 * Super_Awesome_Theme_Asset_Not_Registered_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when an asset is not registered when it is requested.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Asset_Not_Registered_Exception extends InvalidArgumentException {

	/**
	 * Creates an exception from a given asset handle.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle Asset handle.
	 * @return Super_Awesome_Theme_Asset_Not_Registered_Exception Exception for the given handle.
	 */
	public static function from_handle( $handle ) {
		/* translators: %s: asset handle */
		$message = sprintf( __( '%s is not a registered asset.', 'super-awesome-theme' ), $handle );

		return new self( $message );
	}
}
