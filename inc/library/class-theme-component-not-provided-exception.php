<?php
/**
 * Super_Awesome_Theme_Theme_Component_Not_Provided_Exception class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Exception thrown when a dependency was not provided when initializing.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Theme_Component_Not_Provided_Exception extends RuntimeException {

	/**
	 * Creates an exception from given dependency and component class names.
	 *
	 * @since 1.0.0
	 *
	 * @param string $dependency_class_name Dependency class name.
	 * @param string $component_class_name  Theme component class name.
	 * @return Super_Awesome_Theme_Theme_Component_Not_Provided_Exception Exception for the given handle.
	 */
	public static function from_dependency_and_component( $dependency_class_name, $component_class_name ) {
		/* translators: 1: dependency class name, 2: component class name */
		$message = sprintf( __( 'Required dependency %1$s for theme component %2$s was not provided.', 'super-awesome-theme' ), $dependency_class_name, $component_class_name );

		return new self( $message );
	}
}
