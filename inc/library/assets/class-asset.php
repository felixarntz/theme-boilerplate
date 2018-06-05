<?php
/**
 * Super_Awesome_Theme_Asset class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a theme asset.
 *
 * @since 1.0.0
 */
abstract class Super_Awesome_Theme_Asset {

	/**
	 * Handle property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_HANDLE = 'handle';

	/**
	 * URI property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_URI = 'uri';

	/**
	 * Dependencies property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEPENDENCIES = 'dependencies';

	/**
	 * Version property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_VERSION = 'version';

	/**
	 * Location property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_LOCATION = 'location';

	/**
	 * Minified URI property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_MIN_URI = 'min_uri';

	/**
	 * Identifier of the frontend location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_FRONTEND = 'frontend';

	/**
	 * Identifier of the admin location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_ADMIN = 'admin';

	/**
	 * Identifier of the block editor location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_BLOCK_EDITOR = 'block_editor';

	/**
	 * Identifier of the Customize preview location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_CUSTOMIZE_PREVIEW = 'customize_preview';

	/**
	 * Identifier of the Customize controls location.
	 *
	 * @since 1.0.0
	 */
	const LOCATION_CUSTOMIZE_CONTROLS = 'customize_controls';

	/**
	 * Unique handle for the asset.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $handle;

	/**
	 * Full URI to the asset.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $uri;

	/**
	 * List of dependency handles for this asset.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $dependencies;

	/**
	 * Asset version number.
	 *
	 * @since 1.0.0
	 * @var string|bool|null
	 */
	protected $version;

	/**
	 * Where this asset should be used.
	 *
	 * Can be either 'frontend', 'admin', 'customize_preview' or 'customize_controls'.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $location;

	/**
	 * Full URI to the minified asset, or true if it's the regular $uri
	 * with a `.min` suffix, or false if no minified asset.
	 *
	 * @since 1.0.0
	 * @var string|bool
	 */
	protected $min_uri;

	/**
	 * Constructor.
	 *
	 * Sets the asset definition.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle Unique handle for this asset.
	 * @param string $uri    Full URI to the asset.
	 * @param array  $args   Asset definition as $prop => $value pairs.
	 */
	public function __construct( $handle, $uri, array $args = array() ) {
		$this->handle = (string) $handle;
		$this->uri    = (string) $uri;

		$defaults = $this->get_defaults();
		foreach ( $defaults as $prop => $default_value ) {
			if ( array_key_exists( $prop, $args ) ) {
				$this->$prop = $args[ $prop ];
			} else {
				$this->$prop = $default_value;
			}
		}

		if ( is_bool( $this->min_uri ) && $this->min_uri ) {
			$this->min_uri = $this->get_minified_uri( $this->uri );
		}
	}

	/**
	 * Gets the value for an asset property.
	 *
	 * @since 1.0.0
	 *
	 * @param string $prop Property name.
	 * @return mixed Property value.
	 *
	 * @throws InvalidArgumentException Thrown when $prop is invalid.
	 */
	final public function get_prop( $prop ) {
		$props = $this->get_props();

		if ( ! array_key_exists( $prop, $props ) ) {

			/* translators: 1: property name, 2: asset identifier */
			throw new InvalidArgumentException( sprintf( __( '%1$s is not a valid property of the %2$s asset.', 'super-awesome-theme' ), $prop, $this->handle ) );
		}

		return $props[ $prop ];
	}

	/**
	 * Gets the values for all asset properties.
	 *
	 * @since 1.0.0
	 *
	 * @return array Asset properties including handle and URI as $prop => $value pairs.
	 */
	final public function get_props() {
		$props = array(
			'handle' => $this->handle,
			'uri'    => $this->uri,
		);

		$default_props = array_keys( $this->get_defaults() );
		foreach ( $default_props as $prop ) {
			$props[ $prop ] = $this->$prop;
		}

		return $props;
	}

	/**
	 * Registers the asset with WordPress.
	 *
	 * @since 1.0.0
	 */
	abstract public function register();

	/**
	 * Enqueues the asset in WordPress.
	 *
	 * @since 1.0.0
	 */
	abstract public function enqueue();

	/**
	 * Checks whether the asset is registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if registered, false otherwise.
	 */
	abstract public function is_registered();

	/**
	 * Checks whether the asset is enqueued in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if enqueued, false otherwise.
	 */
	abstract public function is_enqueued();

	/**
	 * Gets the minified URI from a regular URI.
	 *
	 * The URI will be the same, with a '.min' suffix applied before the file extension.
	 *
	 * @since 1.0.0
	 *
	 * @param string $uri Base URI to an asset.
	 * @return string Minified URI based on $uri.
	 */
	final protected function get_minified_uri( $uri ) {
		$parts    = explode( '/', $uri );
		$filename = array_pop( $parts );
		$query    = '';

		if ( false !== strpos( $filename, '?' ) ) {
			list( $filename, $query ) = explode( '?', $filename, 2 );
			$query                    = '?' . $query;
		}

		$filename = preg_replace( '/\.([A-Za-z0-9]+)$/', '.min.$1', $filename );

		return implode( '/', $parts ) . '/' . $filename . $query;
	}

	/**
	 * Checks whether to use the minified asset file, if available.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if minified asset should be used, false otherwise.
	 */
	protected function use_minified() {
		return ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG;
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
		return array(
			self::PROP_DEPENDENCIES => array(),
			self::PROP_VERSION      => null,
			self::PROP_LOCATION     => self::LOCATION_FRONTEND,
			self::PROP_MIN_URI      => false,
		);
	}
}
