<?php
/**
 * Super_Awesome_Theme_Footer_Widget_Areas class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for the theme footer widget areas.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Footer_Widget_Areas extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Footer widget area count.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	protected $widget_area_count;

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
		$this->require_dependency_class( 'Super_Awesome_Theme_Widgets' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Distraction_Free_Mode' );

		/**
		 * Filters the theme's footer widget area count.
		 *
		 * This count determines how many footer widget area columns the theme contains.
		 *
		 * @since 1.0.0
		 *
		 * @param int $count Footer widget area count.
		 */
		$this->widget_area_count = apply_filters( 'super_awesome_theme_footer_widget_area_count', 4 );
	}

	/**
	 * Gets the footer widget area identifiers.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of footer widget area identifiers.
	 */
	public function get_widget_area_names() {
		$names = array();

		for ( $i = 1; $i <= $this->widget_area_count; $i++ ) {
			$names[] = 'footer-' . $i;
		}

		return $names;
	}

	/**
	 * Checks whether the footer widget areas should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the footer widget areas should be displayed, false otherwise.
	 */
	public function should_display() {
		if ( $this->get_dependency( 'distraction_free_mode' )->is_distraction_free() ) {
			return false;
		}

		return $this->has_active();
	}

	/**
	 * Checks whether at least one of the footer widget areas is active (i.e. has content).
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if footer widget areas are active, false otherwise.
	 */
	public function has_active() {
		$widgets = $this->get_dependency( 'widgets' );

		for ( $i = 1; $i <= $this->widget_area_count; $i++ ) {
			$widget_area = $widgets->get_registered_widget_area( 'footer-' . $i );
			if ( $widget_area->is_active() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks whether a given footer widget area is set as the wide column.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Footer widget area identifier.
	 * @return bool True if the footer area is the wide column, false otherwise.
	 */
	public function is_wide_widget_area( $name ) {
		return $name === $this->get_dependency( 'settings' )->get( 'wide_footer_widget_area' );
	}

	/**
	 * Gets the available choices for the 'wide_footer_widget_area' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_wide_footer_widget_area_choices() {
		$choices = array( '' => _x( 'None', 'widget area dropdown', 'super-awesome-theme' ) );

		for ( $i = 1; $i <= $this->widget_area_count; $i++ ) {

			/* translators: %s: widget area number */
			$choices[ 'footer-' . $i ] = sprintf( __( 'Footer %s', 'super-awesome-theme' ), number_format_i18n( $i ) );
		}

		return $choices;
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
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_settings':
			case 'register_widget_areas':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers settings for sidebar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'wide_footer_widget_area',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_wide_footer_widget_area_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => '',
			)
		) );
	}

	/**
	 * Registers widget areas for the sidebar.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
	 */
	protected function register_widget_areas( $widgets ) {
		for ( $i = 1; $i <= $this->widget_area_count; $i++ ) {
			$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
				'footer-' . $i,
				array(
					/* translators: %s: widget area number */
					Super_Awesome_Theme_Widget_Area::PROP_TITLE       => sprintf( __( 'Footer %s', 'super-awesome-theme' ), number_format_i18n( $i ) ),
					Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => __( 'Add widgets here to appear in your footer.', 'super-awesome-theme' ),
				)
			) );
		}
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
			'super-awesome-theme-footer-widget-areas-customize-controls',
			get_theme_file_uri( '/assets/dist/js/footer-widget-areas.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'underscore', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeFooterWidgetAreasControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'footerWidgetAreas'           => $this->get_widget_area_names(),
					'wideFooterWidgetAreaChoices' => $this->get_wide_footer_widget_area_choices(),
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
			'super-awesome-theme-footer-widget-areas-customize-preview',
			get_theme_file_uri( '/assets/dist/js/footer-widget-areas.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
			)
		) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_settings' ), 10, 0 );

		$widgets = $this->get_dependency( 'widgets' );
		$widgets->on_init( array( $this, 'register_widget_areas' ) );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
