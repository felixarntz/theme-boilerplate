<?php
/**
 * Super_Awesome_Theme_Custom_Header class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the custom header feature.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Custom_Header extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Theme_Support' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
	}

	/**
	 * Gets the available choices for the 'branding_location' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_branding_location_choices() {
		return array(
			'header'       => __( 'In front of the header image', 'super-awesome-theme' ),
			'navbar_left'  => __( 'On the left inside the navigation bar', 'super-awesome-theme' ),
			'navbar_right' => __( 'On the right inside the navigation bar', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets the available choices for the 'header_position' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_header_position_choices() {
		return array(
			'above_navbar' => __( 'Above the navigation bar', 'super-awesome-theme' ),
			'below_navbar' => __( 'Below the navigation bar', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets the available choices for the 'header_textalign' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_header_textalign_choices() {
		return array(
			'text-left'   => _x( 'Left', 'alignment', 'super-awesome-theme' ),
			'text-center' => _x( 'Center', 'alignment', 'super-awesome-theme' ),
			'text-right'  => _x( 'Right', 'alignment', 'super-awesome-theme' ),
		);
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_feature':
			case 'print_header_style':
			case 'register_settings':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
			case 'add_customizer_script_data':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Registers the 'custom-header' feature.
	 *
	 * @since 1.0.0
	 */
	protected function register_feature() {
		$custom_header_width  = super_awesome_theme_use_wrapped_layout() ? 1152 : 2560;
		$custom_header_height = super_awesome_theme_use_wrapped_layout() ? 460 : 1024;

		/**
		 * Filters the arguments for registering custom header support.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Custom header arguments.
		 */
		$args = apply_filters( 'super_awesome_theme_custom_header_args', array(
			'default-image'          => '',
			'default-text-color'     => '404040',
			'width'                  => $custom_header_width,
			'height'                 => $custom_header_height,
			'flex-height'            => true,
			'wp-head-callback'       => array( $this, 'print_header_style' ),
			'video'                  => true,
		) );

		$this->get_dependency( 'theme_support' )->add_feature( new Super_Awesome_Theme_Args_Theme_Feature(
			'custom-header',
			$args
		) );
	}

	/**
	 * Prints the extra custom header styles.
	 *
	 * Header text color is handled manually with the other Customizer colors.
	 *
	 * @since 1.0.0
	 */
	protected function print_header_style() {
		if ( display_header_text() ) {
			return;
		}

		?>
		<style type="text/css">
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		</style>
		<?php
	}

	/**
	 * Registers settings for navbar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'branding_location',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_branding_location_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'header',
			)
		) );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'header_position',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_header_position_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'below_navbar',
			)
		) );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'header_textalign',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_header_textalign_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'text-center',
			)
		) );
	}

	/**
	 * Registers scripts for the Customizer controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_controls_js( $assets ) {
		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-custom-header-customize-controls',
			get_theme_file_uri( '/assets/dist/js/custom-header.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeCustomHeaderControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'brandingLocationChoices' => $this->get_branding_location_choices(),
					'headerPositionChoices'   => $this->get_header_position_choices(),
					'headerTextalignChoices'  => $this->get_header_textalign_choices(),
				),
			)
		) );
	}

	/**
	 * Registers scripts for the Customizer preview.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_preview_js( $assets ) {
		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-custom-header-customize-preview',
			get_theme_file_uri( '/assets/dist/js/custom-header.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeCustomHeaderPreviewData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'headerTextalignChoices' => $this->get_header_textalign_choices(),
				),
			)
		) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_feature' ), 10, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_settings' ), 0, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
