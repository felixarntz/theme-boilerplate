<?php
/**
 * Super_Awesome_Theme_Script class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme script.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Script extends Super_Awesome_Theme_Asset {

	/**
	 * Global JavaScript variable name for data passed from PHP.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $script_data_name;

	/**
	 * Data to pass to JavaScript in global variable.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $script_data;

	/**
	 * Registers the asset with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$uri = $this->uri;
		if ( $this->min_uri && $this->use_minified ) {
			$uri = $this->min_uri;
		}

		wp_register_script( $this->handle, $uri, $this->dependencies, $this->version, true );
	}

	/**
	 * Enqueues the asset in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @throws Super_Awesome_Theme_Asset_Not_Registered_Exception Thrown when the asset is not registered.
	 */
	public function enqueue() {
		if ( ! $this->is_registered() ) {

			/* translators: %s: asset identifier */
			throw new Super_Awesome_Theme_Asset_Not_Registered_Exception( sprintf( __( 'Script %s cannot be enqueued because it is not registered.', 'super-awesome-theme' ), $this->handle ) );
		}

		wp_enqueue_script( $this->handle );

		if ( ! empty( $this->script_data_name ) && ! empty( $this->script_data ) ) {
			wp_localize_script( $this->handle, $this->script_data_name, $this->script_data );
		}
	}

	/**
	 * Adds data to pass to JavaScript.
	 *
	 * That data will be part of the object passed to the script via a global variable.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key   Key to use as a property on the JavaScript object.
	 * @param mixed  $value Value for that property.
	 */
	public function add_data( $key, $value ) {
		$this->script_data[ $key ] = $value;
	}

	/**
	 * Checks whether the asset is registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if registered, false otherwise.
	 */
	public function is_registered() {
		return wp_script_is( $this->handle, 'registered' );
	}

	/**
	 * Checks whether the asset is enqueued in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if enqueued, false otherwise.
	 */
	public function is_enqueued() {
		return wp_script_is( $this->handle, 'enqueued' );
	}

	/**
	 * Gets the default asset definition properties to set.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default asset definition as $prop => $default_value pairs. Each
	 *               key present should have a class property of the same name. Defaults
	 *               should be present for every asset property, even if the default
	 *               is null.
	 */
	protected function get_defaults() {
		$defaults                     = parent::get_defaults();
		$defaults['script_data_name'] = '';
		$defaults['script_data']      = array();

		return $defaults;
	}
}
