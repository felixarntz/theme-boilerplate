<?php
/**
 * Super_Awesome_Theme_Stylesheet class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme stylesheet.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Stylesheet extends Super_Awesome_Theme_Asset {

	/**
	 * The media for which this stylesheet has been defined.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $media;

	/**
	 * Whether the stylesheet has a right-to-left version indicated
	 * by a '-rtl' suffix before the file extension.
	 * @var [type]
	 */
	protected $has_rtl;

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

		wp_register_style( $this->handle, $uri, $this->dependencies, $this->version, $this->media );

		if ( $this->has_rtl ) {
			wp_style_add_data( $this->handle, 'rtl', 'replace' );
		}
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
			throw new Super_Awesome_Theme_Asset_Not_Registered_Exception( sprintf( __( 'Stylesheet %s cannot be enqueued because it is not registered.', 'super-awesome-theme' ), $this->handle ) );
		}

		wp_enqueue_style( $this->handle );
	}

	/**
	 * Checks whether the asset is registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if registered, false otherwise.
	 */
	public function is_registered() {
		return wp_style_is( $this->handle, 'registered' );
	}

	/**
	 * Checks whether the asset is enqueued in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if enqueued, false otherwise.
	 */
	public function is_enqueued() {
		return wp_style_is( $this->handle, 'enqueued' );
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
		$defaults            = parent::get_defaults();
		$defaults['media']   = 'all';
		$defaults['has_rtl'] = false;

		return $defaults;
	}
}
