<?php
/**
 * Super_Awesome_Theme_Bottom_Bar class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for the theme bottom bar.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Bottom_Bar extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Colors' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Sticky_Elements' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Widgets' );
	}

	/**
	 * Checks whether the bottom bar is currently sticky.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if bottom bar is sticky, false otherwise.
	 */
	public function is_sticky() {
		$sticky_elements = $this->get_dependency( 'sticky_elements' );

		$bottom_bar = $sticky_elements->get_registered_sticky_element( 'bottom_bar' );

		return $bottom_bar->is_sticky();
	}

	/**
	 * Gets the available choices for the 'bottom_bar_justify_content' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_bottom_bar_justify_content_choices() {
		return array(
			'space-between' => _x( 'Space Between', 'alignment', 'super-awesome-theme' ),
			'centered'      => _x( 'Centered', 'alignment', 'super-awesome-theme' ),
		);
	}

	/**
	 * Magic call method.
	 *
	 * Handles the widgets registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_settings':
			case 'register_widget_areas':
			case 'register_colors':
			case 'register_sticky':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
			case 'print_color_style':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers settings for bottom bar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'bottom_bar_justify_content',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_bottom_bar_justify_content_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'space-between',
			)
		) );
	}

	/**
	 * Registers widget areas for the bottom bar.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
	 */
	protected function register_widget_areas( $widgets ) {
		$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
			'bottom',
			array(
				Super_Awesome_Theme_Widget_Area::PROP_TITLE       => __( 'Bottom Bar', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => __( 'Add widgets here to appear in a narrow bar at the very bottom of the screen.', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_INLINE      => true,
			)
		) );
	}

	/**
	 * Registers bottom bar colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_colors() {
		$colors = $this->get_dependency( 'colors' );

		$colors->register_group( 'bottom_bar_colors', __( 'Bottom Bar Colors', 'super-awesome-theme' ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'bottom_bar_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'bottom_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Bottom Bar Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#ffffff',
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'bottom_bar_link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'bottom_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Bottom Bar Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#ffffff',
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'bottom_bar_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'bottom_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Bottom Bar Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#21759b',
		) ) );

		$colors->register_color_style_callback( array( $this, 'print_color_style' ) );
	}

	/**
	 * Registers the bottom bar as a sticky frontend element.
	 *
	 * @since 1.0.0
	 */
	protected function register_sticky() {
		$sticky_elements = $this->get_dependency( 'sticky_elements' );

		$sticky_elements->register_sticky_element( new Super_Awesome_Theme_Sticky_Element(
			'bottom_bar',
			array(
				Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR => '#site-bottom-bar',
				Super_Awesome_Theme_Sticky_Element::PROP_LABEL    => __( 'Stick the bottom bar to the bottom of the page when scrolling?', 'super-awesome-theme' ),
				Super_Awesome_Theme_Sticky_Element::PROP_LOCATION => Super_Awesome_Theme_Sticky_Element::LOCATION_BOTTOM,
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
			'super-awesome-theme-bottom-bar-customize-controls',
			get_theme_file_uri( '/assets/dist/js/bottom-bar.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeBottomBarControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'bottomBarJustifyContentChoices' => $this->get_bottom_bar_justify_content_choices(),
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
			'super-awesome-theme-bottom-bar-customize-preview',
			get_theme_file_uri( '/assets/dist/js/bottom-bar.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeBottomBarPreviewData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'bottomBarJustifyContentChoices' => $this->get_bottom_bar_justify_content_choices(),
				),
			)
		) );
	}

	/**
	 * Prints color styles for the bottom bar.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Colors $colors The theme colors instance.
	 */
	protected function print_color_style( $colors ) {
		$bottom_bar_text_color       = $colors->get( 'bottom_bar_text_color' );
		$bottom_bar_background_color = $colors->get( 'bottom_bar_background_color' );

		if ( empty( $bottom_bar_text_color ) || empty( $bottom_bar_background_color ) ) {
			return;
		}

		?>
		.site-bottom-bar {
			color: <?php echo esc_attr( $bottom_bar_text_color ); ?>;
			background-color: <?php echo esc_attr( $bottom_bar_background_color ); ?>;
		}
		<?php

		$bottom_bar_link_color       = $colors->get( 'bottom_bar_link_color' );
		$bottom_bar_link_focus_color = $colors->util()->darken_color( $bottom_bar_link_color, 25 );

		if ( empty( $bottom_bar_link_color ) || empty( $bottom_bar_link_focus_color ) ) {
			return;
		}

		?>
		.site-bottom-bar a,
		.site-bottom-bar a:visited {
			color: <?php echo esc_attr( $bottom_bar_link_color ); ?>;
		}

		.site-bottom-bar a:hover,
		.site-bottom-bar a:focus,
		.site-bottom-bar a:active {
			color: <?php echo esc_attr( $bottom_bar_link_focus_color ); ?>;
		}
		<?php
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_settings' ), 0, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_colors' ), 7, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_sticky' ), 0, 0 );

		$widgets = $this->get_dependency( 'widgets' );
		$widgets->on_init( array( $this, 'register_widget_areas' ) );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
