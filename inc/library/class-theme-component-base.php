<?php
/**
 * Super_Awesome_Theme_Theme_Component_Base class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Base class for a theme component.
 *
 * @since 1.0.0
 */
abstract class Super_Awesome_Theme_Theme_Component_Base implements Super_Awesome_Theme_Theme_Component {

	/**
	 * Required dependency classes and their implementations.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $dependencies = array();

	/**
	 * Map of short-hand identifiers and their dependency class.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $shorthands = array();

	/**
	 * Stores whether the component has been initialized.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private $initialized = false;

	/**
	 * Initializes the component's functionality by adding hooks etc.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the component was initialized, false if it had already been initialized before.
	 *
	 * @throws Super_Awesome_Theme_Theme_Component_Not_Provided_Exception Thrown when a dependency was not provided.
	 */
	public final function initialize() {
		if ( $this->initialized ) {
			return false;
		}

		foreach ( $this->dependencies as $class_name => $component ) {
			if ( ! $component ) {
				throw new Super_Awesome_Theme_Theme_Component_Not_Provided_Exception(
					sprintf(
						__( 'Cannot initialize theme component %1$s because required dependency %2$s was not provided.', 'super-awesome-theme' ),
						get_class( $this ),
						$class_name
					)
				);
			}
		}

		$this->initialized = true;

		$this->run_initialization();

		return true;
	}

	/**
	 * Provides a dependency implementation.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Theme_Component $component Component that implements a dependency.
	 * @return bool True if the dependency was set, false if it is not a dependency.
	 */
	public final function provide_dependency( Super_Awesome_Theme_Theme_Component $component ) {
		$component_class_name = get_class( $component );

		if ( array_key_exists( $component_class_name, $this->dependencies ) ) {
			$this->dependencies[ $component_class_name ] = $component;
			return true;
		}

		foreach ( $this->dependencies as $class_name => $dependency ) {
			if ( $component instanceof $class_name ) {
				$this->dependencies[ $class_name ] = $component;
				return true;
			}
		}

		return false;
	}

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
	public final function get_dependency( $class_name ) {
		if ( isset( $this->shorthands[ $class_name ] ) ) {
			$class_name = $this->shorthands[ $class_name ];
		} else {
			$class_name = $this->normalize_dependency_class_name( $class_name );
		}

		if ( ! isset( $this->dependencies[ $class_name ] ) ) {
			throw new Super_Awesome_Theme_Theme_Component_Not_Provided_Exception(
				sprintf(
					__( 'Required dependency %1$s for theme component %2$s was not provided.', 'super-awesome-theme' ),
					$class_name,
					get_class( $this )
				)
			);
		}

		return $this->dependencies[ $class_name ];
	}

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
	public final function get_dependency_classes() {
		return array_keys( $this->dependencies );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected abstract function run_initialization();

	/**
	 * Requires a class as a dependency.
	 *
	 * An implementation for that class must be set before the component can be
	 * initialized.
	 *
	 * This method should be called from the component's constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class_name Class name of the dependency, or shortened class name, with the
	 *                           theme prefix stripped.
	 */
	protected final function require_dependency_class( $class_name ) {
		$class_name = $this->normalize_dependency_class_name( $class_name );

		if ( ! array_key_exists( $class_name, $this->dependencies ) ) {
			$this->dependencies[ $class_name ] = null;

			$shorthand_identifier = $this->make_shorthand_identifier( $class_name );
			$this->shorthands[ $shorthand_identifier ] = $class_name;
		}
	}

	/**
	 * Normalizes a dependency class name, returning a full class name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class_name Class name of the dependency, or shortened class name, with the
	 *                           theme prefix stripped.
	 * @return string Full class name.
	 */
	private final function normalize_dependency_class_name( $class_name ) {
		if ( 0 !== strpos( $class_name, 'Super_Awesome_Theme_' ) ) {
			$class_name = 'Super_Awesome_Theme_' . $class_name;
		}

		return $class_name;
	}

	/**
	 * Returns the short-hand identifier for a full class name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class_name Full class name.
	 * @return string Short-hand identifier.
	 */
	private final function make_shorthand_identifier( $class_name ) {
		return strtolower( str_replace( 'Super_Awesome_Theme_', '', $class_name ) );
	}
}
