<?php
/**
 * Super_Awesome_Theme_Customize_Component_Not_Registered_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when a Customizer component is not registered when it is requested.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Customize_Component_Not_Registered_Exception extends InvalidArgumentException {

	/**
	 * Creates an exception from a given panel identifier.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Customizer panel identifier.
	 * @return Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Exception for the given identifier.
	 */
	public static function from_panel_id( $id ) {
		/* translators: %s: panel identifier */
		$message = sprintf( __( '%s is not a registered Customizer panel.', 'super-awesome-theme' ), $id );

		return new self( $message );
	}

	/**
	 * Creates an exception from a given section identifier.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Customizer section identifier.
	 * @return Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Exception for the given identifier.
	 */
	public static function from_section_id( $id ) {
		/* translators: %s: section identifier */
		$message = sprintf( __( '%s is not a registered Customizer section.', 'super-awesome-theme' ), $id );

		return new self( $message );
	}

	/**
	 * Creates an exception from a given control identifier.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Customizer control identifier.
	 * @return Super_Awesome_Theme_Customize_Component_Not_Registered_Exception Exception for the given identifier.
	 */
	public static function from_control_id( $id ) {
		/* translators: %s: control identifier */
		$message = sprintf( __( '%s is not a registered Customizer control.', 'super-awesome-theme' ), $id );

		return new self( $message );
	}
}
