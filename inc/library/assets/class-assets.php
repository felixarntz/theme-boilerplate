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
		switch ( $method ) {
			case 'register_main_assets':
			case 'disable_special_page_styles':
			case 'print_detect_js_svg_support_script':
			case 'set_jed_locale_data':
				return call_user_func_array( array( $this, $method ), $args );
			case 'register':
				foreach ( $this->assets as $asset ) {
					if ( $asset->is_registered() ) {
						continue;
					}
					$asset->register();
				}
				break;
			default:
				if ( ! preg_match( '/^(register|enqueue)_([a-z_]+)$/', $method, $matches ) ) {
					return;
				}

				$assets = $this->filter_assets_by_location( $this->assets, $matches[2] );
				foreach ( $assets as $asset ) {
					call_user_func( array( $asset, $matches[1] ) );
				}
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
			'wp-i18n',
			get_theme_file_uri( '/assets/dist/js/wp-i18n.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_VERSION   => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION  => '',
				Super_Awesome_Theme_Script::PROP_MIN_URI   => true,
			)
		) );

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

		$this->register_asset( new Super_Awesome_Theme_Stylesheet(
			'super-awesome-theme-block-editor-style',
			get_theme_file_uri( '/block-editor-style.css' ),
			array(
				Super_Awesome_Theme_Stylesheet::PROP_VERSION  => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Stylesheet::PROP_LOCATION => Super_Awesome_Theme_Stylesheet::LOCATION_BLOCK_EDITOR,
				Super_Awesome_Theme_Stylesheet::PROP_HAS_RTL  => true,
			)
		) );

		add_editor_style();
	}

	/**
	 * Disables core styles for the special 'wp-signup.php' and 'wp-activate.php' pages.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Identifier of the header to load.
	 */
	private function disable_special_page_styles( $name ) {
		if ( 'wp-signup' === $name ) {
			remove_action( 'wp_head', 'wpmu_signup_stylesheet' );
		} elseif ( 'wp-activate' === $name ) {
			remove_action( 'wp_head', 'wpmu_activate_stylesheet' );
		}
	}

	/**
	 * Handles JavaScript and SVG support detection.
	 *
	 * The classes 'no-js' and 'no-svg' on the html tag are replaced with
	 * 'js' and 'svg' classes as appropriate.
	 *
	 * @since 1.0.0
	 */
	private function print_detect_js_svg_support_script() {
		?>
		<script>
			(function( html ) {
				function supportsInlineSVG() {
					var div = document.createElement( 'div' );
					div.innerHTML = '<svg/>';
					return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
				}

				html.className = html.className.replace( /(\s*)no-js(\s*)/, '$1js$2' );

				if ( true === supportsInlineSVG() ) {
					html.className = html.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
				}
			})( document.documentElement );
		</script>
		<?php
	}

	/**
	 * Sets locale data on the wp-i18n script.
	 *
	 * @since 1.0.0
	 */
	private function set_jed_locale_data() {
		$locale_data = $this->get_jed_locale_data_for_domain( 'super-awesome-theme' );

		$wp_i18n = $this->get_registered_asset( 'wp-i18n' );
		$wp_i18n->add_inline_script( 'wp.i18n.setLocaleData( ' . json_encode( $locale_data ) . ' );' );
	}

	/**
	 * Gets JED-formatted locale data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $domain Textdomain to get loale data for.
	 * @return array Locale data.
	 */
	private function get_jed_locale_data_for_domain( $domain ) {
		$translations = get_translations_for_domain( $domain );

		$locale = array(
			'' => array(
				'domain' => $domain,
				'lang'   => is_admin() ? get_user_locale() : get_locale(),
			),
		);

		if ( ! empty( $translations->headers['Plural-Forms'] ) ) {
			$locale['']['plural_forms'] = $translations->headers['Plural-Forms'];
		}

		foreach ( $translations->entries as $msgid => $entry ) {
			if ( ! empty( $entry->references ) ) {
				$js_references = preg_grep( '/^inc\/js-i18n.php:(\d+)$/', $entry->references );
				if ( empty( $js_references ) ) {
					continue;
				}
			}

			$locale[ $msgid ] = $entry->translations;
		}

		return $locale;
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_main_assets' ), 10, 0 );
		add_action( 'get_header', array( $this, 'disable_special_page_styles' ), 10, 1 );
		add_action( 'wp_head', array( $this, 'print_detect_js_svg_support_script' ), 0, 0 );
		add_action( 'init', array( $this, 'set_jed_locale_data' ), 10, 0 );

		$location_hooks = array(
			Super_Awesome_Theme_Asset::LOCATION_FRONTEND           => 'wp_enqueue_scripts',
			Super_Awesome_Theme_Asset::LOCATION_ADMIN              => 'admin_enqueue_scripts',
			Super_Awesome_Theme_Asset::LOCATION_LOGIN              => 'login_enqueue_scripts',
			Super_Awesome_Theme_Asset::LOCATION_BLOCK_EDITOR       => 'enqueue_block_editor_assets',
			Super_Awesome_Theme_Asset::LOCATION_CUSTOMIZE_PREVIEW  => 'customize_preview_init',
			Super_Awesome_Theme_Asset::LOCATION_CUSTOMIZE_CONTROLS => 'customize_controls_enqueue_scripts',
		);

		foreach ( $location_hooks as $location => $hookname ) {
			add_action( $hookname, array( $this, 'register' ), 1, 0 );
			add_action( $hookname, array( $this, 'enqueue_' . $location ), 10, 0 );
		}
	}
}
