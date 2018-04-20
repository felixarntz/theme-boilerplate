<?php
/**
 * Super_Awesome_Theme_Theme class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Main class of the theme.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Theme {

	/**
	 * Registered theme components.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $components = array();

	/**
	 * Map of components and their dependants.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $dependants_map = array();

	/**
	 * Registers a theme component.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Theme_Component $component Component that implements a dependency.
	 * @return Super_Awesome_Theme_Theme Theme instance for chaining.
	 */
	public function register_component( Super_Awesome_Theme_Theme_Component $component ) {
		$dependency_classes = $component->get_dependency_classes();
		foreach ( $dependency_classes as $class_name ) {
			if ( ! isset( $this->dependants_map[ $class_name ] ) ) {
				$this->dependants_map[ $class_name ] = array();
			}

			$this->dependants_map[ $class_name ][] = $component;
		}

		$shorthand_identifier                      = $this->make_shorthand_identifier( get_class( $component ) );
		$this->components[ $shorthand_identifier ] = $component;

		return $this;
	}

	/**
	 * Gets a registered theme component.
	 *
	 * @since 1.0.0
	 *
	 * @param string $shorthand_identifier Short-hand identifier of the component, which is the class name
	 *                                     without the theme prefix all lowercased.
	 * @return Super_Awesome_Theme_Theme_Component|null Theme component, or null if not registered.
	 */
	public function get_component( $shorthand_identifier ) {
		if ( ! isset( $this->components[ $shorthand_identifier ] ) ) {
			return null;
		}

		return $this->components[ $shorthand_identifier ];
	}

	/**
	 * Resolves all dependencies for the registered theme components.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Theme Theme instance for chaining.
	 */
	public function resolve_dependencies() {
		foreach ( $this->components as $component ) {
			foreach ( $this->dependants_map as $class_name => $dependants ) {
				if ( $component instanceof $class_name ) {
					foreach ( $dependants as $dependant ) {
						$dependant->provide_dependency( $component );
					}
				}
			}
		}

		return $this;
	}

	/**
	 * Initializes all registered theme components.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Theme Theme instance for chaining.
	 */
	public function initialize() {
		foreach ( $this->components as $component ) {
			$component->initialize();
		}

		return $this;
	}

	/**
	 * Returns the short-hand identifier for a full class name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class_name Full class name.
	 * @return string Short-hand identifier.
	 */
	private function make_shorthand_identifier( $class_name ) {
		return strtolower( str_replace( 'Super_Awesome_Theme_', '', $class_name ) );
	}
}
