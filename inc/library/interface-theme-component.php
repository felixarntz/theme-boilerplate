<?php
/**
 * Super_Awesome_Theme_Theme_Component interface
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Interface for a theme component.
 *
 * @since 1.0.0
 */
interface Super_Awesome_Theme_Theme_Component {

	/**
	 * Initializes the component's functionality by adding hooks etc.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the component was initialized, false otherwise.
	 *
	 * @throws Super_Awesome_Theme_Theme_Component_Not_Provided_Exception Thrown when a dependency was not provided.
	 */
	public function initialize();

	/**
	 * Provides a dependency implementation.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Theme_Component $component Component that implements a dependency.
	 * @return bool True if the dependency was set, false if it is not a dependency.
	 */
	public function provide_dependency( Super_Awesome_Theme_Theme_Component $component );

	/**
	 * Gets a provided dependency implementation, if available.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class_name Class name of the dependency, or shortened class name, with the
	 *                           theme prefix stripped, possibly lowercased.
	 * @return Super_Awesome_Theme_Theme_Component Provided theme component dependency implementation.
	 *
	 * @throws Super_Awesome_Theme_Theme_Component_Not_Provided_Exception Thrown when a dependency was not provided.
	 */
	public function get_dependency( $class_name );

	/**
	 * Gets all classes required as a dependency.
	 *
	 * Implementations for these classes must be set before the component can be
	 * initialized.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of class names.
	 */
	public function get_dependency_classes();
}
