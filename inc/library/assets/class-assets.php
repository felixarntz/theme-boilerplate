<?php
/**
 * Super_Awesome_Theme_Assets class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Theme assets registry.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Assets extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered theme assets.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $assets = array();

	/**
	 * Internal current location for asset filtering.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $current_location = '';

	/**
	 * Registers a theme asset.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Asset $asset Asset to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_asset( Super_Awesome_Theme_Asset $asset ) {
		$handle = $asset->get( 'handle' );

		if ( isset( $this->assets[ $handle ] ) ) {
			return false;
		}

		$this->assets[ $handle ] = $asset;

		return true;
	}

	/**
	 * Gets a registered theme asset.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle Unique string handle for this asset.
	 * @return Super_Awesome_Theme_Asset Registered asset instance.
	 *
	 * @throws InvalidArgumentException Thrown when $handle does not identify a registered asset.
	 */
	public function get_registered_asset( $handle ) {
		if ( ! isset( $this->assets[ $handle ] ) ) {

			/* translators: %s: asset handle */
			throw new InvalidArgumentException( sprintf( __( '%s is not a registered asset.', 'super-awesome-theme' ), $handle ) );
		}

		return $this->assets[ $handle ];
	}

	/**
	 * Gets all registered theme assets.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $asset pairs, where each $asset is a
	 *               registered Super_Awesome_Theme_Asset instance.
	 */
	public function get_registered_assets() {
		return $this->assets;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the register and enqueue action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		if ( ! preg_match( '/^(register|enqueue)_([a-z_]+)$/', $method, $matches ) ) {
			return;
		}

		$assets = $this->filter_assets_by_location( $this->assets, $matches[1] );
		foreach ( $assets as $asset ) {
			call_user_func( array( $asset, $matches[1] ) );
		}
	}

	/**
	 * Filters assets for a given location.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $assets   Array of Super_Awesome_Theme_Asset objects.
	 * @param string $location Location to filter assets for. Can be either
	 *                         'frontend', 'admin', 'customize_preview' or 'customize_controls'.
	 * @return array Filtered $assets array.
	 */
	private function filter_assets_by_location( $assets, $location ) {
		$this->current_location = $location;
		$assets                 = array_filter( $assets, array( $this, 'filter_asset_by_location' ) );
		$this->current_location = '';

		return $assets;
	}

	/**
	 * Filter callback for assets that should be used for the current location.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Asset $asset Asset to check.
	 * @return bool True if the asset should be included, false otherwise.
	 */
	private function filter_asset_by_location( $asset ) {
		return $this->current_location === $asset->get( 'location' );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend' ), 1, 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ), 10, 0 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin' ), 1, 0 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ), 10, 0 );
		add_action( 'customize_preview_init', array( $this, 'register_customize_preview' ), 1, 0 );
		add_action( 'customize_preview_init', array( $this, 'enqueue_customize_preview' ), 10, 0 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_customize_controls' ), 1, 0 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customize_controls' ), 10, 0 );
	}
}
