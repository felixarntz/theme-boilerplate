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
		$handle = $asset->get_prop( Super_Awesome_Theme_Asset::PROP_HANDLE );

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
	 * @throws Super_Awesome_Theme_Asset_Not_Registered_Exception Thrown when $handle does not identify a registered asset.
	 */
	public function get_registered_asset( $handle ) {
		if ( ! isset( $this->assets[ $handle ] ) ) {
			throw Super_Awesome_Theme_Asset_Not_Registered_Exception::from_handle( $handle );
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
	 * Gets the main script asset.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Script Main script.
	 */
	public function get_main_script() {
		return $this->get_registered_asset( 'super-awesome-theme-script' );
	}

	/**
	 * Gets the main stylesheet asset.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Script Main stylesheet.
	 */
	public function get_main_stylesheet() {
		return $this->get_registered_asset( 'super-awesome-theme-style' );
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
		if ( 'register_main_assets' === $method ) {
			$this->register_main_assets();
			return;
		}

		if ( ! preg_match( '/^(register|enqueue)_([a-z_]+)$/', $method, $matches ) ) {
			return;
		}

		$assets = $this->filter_assets_by_location( $this->assets, $matches[2] );
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
		return $this->current_location === $asset->get_prop( Super_Awesome_Theme_Asset::PROP_LOCATION );
	}

	/**
	 * Registers the main script and stylesheet for the theme.
	 *
	 * @since 1.0.0
	 */
	private function register_main_assets() {
		$this->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-script',
			get_theme_file_uri( '/assets/dist/js/theme.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_VERSION   => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION  => Super_Awesome_Theme_Script::LOCATION_FRONTEND,
				Super_Awesome_Theme_Script::PROP_MIN_URI   => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME => 'themeData',
			)
		) );

		$this->register_asset( new Super_Awesome_Theme_Stylesheet(
			'super-awesome-theme-style',
			get_stylesheet_uri(),
			array(
				Super_Awesome_Theme_Stylesheet::PROP_VERSION  => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Stylesheet::PROP_LOCATION => Super_Awesome_Theme_Stylesheet::LOCATION_FRONTEND,
				Super_Awesome_Theme_Stylesheet::PROP_HAS_RTL  => true,
			)
		) );

		$script = $this->get_registered_asset( 'super-awesome-theme-script' );

		$sticky = array(
			'stickToTopIds'    => array(),
			'stickToBottomIds' => array(),
		);
		if ( (bool) get_theme_mod( 'sticky_top_bar', false ) ) {
			$sticky['stickToTopIds'][] = 'site-top-bar';
		}
		if ( (bool) get_theme_mod( 'sticky_navbar', false ) ) {
			$sticky['stickToTopIds'][] = 'site-navbar';
		}
		if ( (bool) get_theme_mod( 'sticky_bottom_bar', false ) ) {
			$sticky['stickToBottomIds'][] = 'site-bottom-bar';
		}

		$script->add_data( 'sticky', $sticky );

		if ( has_nav_menu( 'primary' ) ) {
			$script->add_data( 'navigation', array(
				'icon' => super_awesome_theme_get_svg( 'angle-down', array( 'fallback' => true ) ),
				'i18n' => array(
					'expand'   => __( 'Expand child menu', 'super-awesome-theme' ),
					'collapse' => __( 'Collapse child menu', 'super-awesome-theme' ),
				),
			) );
		}

		if ( is_singular() && comments_open() ) {
			$script->add_data( 'comments', array(
				'i18n' => array(
					'processing'    => __( 'Processing...', 'super-awesome-theme' ),
					'badResponse'   => __( 'Bad response code.', 'super-awesome-theme' ),
					'invalidJson'   => __( 'Invalid JSON response.', 'super-awesome-theme' ),
					/* translators: %s: edit comment URL */
					'flood'         => sprintf( __( 'Your comment was either a duplicate or you are posting too rapidly. <a href="%s">Edit your comment</a>', 'super-awesome-theme' ), '#comment' ),
					'error'         => __( 'There were errors in submitting your comment; complete the missing fields and try again!', 'super-awesome-theme' ),
					'emailInvalid'  => __( 'This email address appears to be invalid.', 'super-awesome-theme' ),
					'required'      => __( 'This is a required field.', 'super-awesome-theme' ),
					'commentsTitle' => sprintf(
						/* translators: 1: title. */
						__( 'One thought on &ldquo;%1$s&rdquo;', 'super-awesome-theme' ),
						'<span>' . get_the_title() . '</span>'
					),
				),
			) );

			if ( get_option( 'thread_comments' ) ) {
				// TODO: Hook this in at an appropriate location.
				add_action( 'wp_enqueue_scripts', function() {
					wp_enqueue_script( 'comment-reply' );
				});
			}
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_main_assets' ), 10, 0 );

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
