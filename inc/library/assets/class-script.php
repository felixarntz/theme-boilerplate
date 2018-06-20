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
	 * Script data name property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DATA_NAME = 'data_name';

	/**
	 * Script data property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DATA = 'data';

	/**
	 * Inline scripts to print before or after the main script.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $inline_scripts = array();

	/**
	 * Global JavaScript variable name for data passed from PHP.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $data_name;

	/**
	 * Data to pass to JavaScript in global variable.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $data = array();

	/**
	 * Registers the asset with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$uri = $this->uri;
		if ( $this->min_uri && $this->use_minified() ) {
			$uri = $this->min_uri;
		}

		wp_register_script( $this->handle, $uri, $this->dependencies, $this->version, true );

		foreach ( $this->inline_scripts as $inline_script ) {
			wp_add_inline_script( $this->handle, $inline_script['script'], $inline_script['position'] );
		}

		$this->inline_scripts = array();
	}

	/**
	 * Enqueues the asset in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @throws Super_Awesome_Theme_Asset_Not_Enqueueable_Exception Thrown when the asset is not registered.
	 */
	public function enqueue() {
		if ( ! $this->is_registered() ) {
			throw Super_Awesome_Theme_Asset_Not_Enqueueable_Exception::from_handle( $this->handle );
		}

		wp_enqueue_script( $this->handle );

		if ( ! empty( $this->data_name ) && ! empty( $this->data ) ) {
			wp_localize_script( $this->handle, $this->data_name, $this->data );
		}
	}

	/**
	 * Adds an inline script to print before or after the main script.
	 *
	 * @since 1.0.0
	 *
	 * @param string $script   JavaScript code to be printed. Must not contain the script tags.
	 * @param string $position Optional. Either 'before' or 'after'. Default 'after'.
	 */
	public function add_inline_script( $script, $position = 'after' ) {
		if ( $this->is_registered() ) {
			wp_add_inline_script( $this->handle, $script, $position );
			return;
		}

		$this->inline_scripts[] = array(
			'script'   => $script,
			'position' => $position,
		);
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
		$this->data[ $key ] = $value;
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
		$defaults                         = parent::get_defaults();
		$defaults[ self::PROP_DATA_NAME ] = '';
		$defaults[ self::PROP_DATA ]      = array();

		return $defaults;
	}
}
