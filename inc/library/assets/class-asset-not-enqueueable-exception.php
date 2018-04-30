<?php
/**
 * Super_Awesome_Theme_Asset_Not_Enqueueable_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when an asset is not registered with WordPress when it should be enqueued.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Asset_Not_Enqueueable_Exception extends RuntimeException {

	/**
	 * Creates an exception from a given asset handle.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle Asset handle.
	 * @return Super_Awesome_Theme_Asset_Not_Enqueueable_Exception Exception for the given handle.
	 */
	public static function from_handle( $handle ) {
		/* translators: %s: asset handle */
		$message = sprintf( __( 'Asset %s cannot be enqueued because it is not registered.', 'super-awesome-theme' ), $handle );

		return new self( $message );
	}
}
