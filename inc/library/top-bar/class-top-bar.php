<?php
/**
 * Super_Awesome_Theme_Top_Bar class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for the theme top bar.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Top_Bar extends Super_Awesome_Theme_Theme_Component_Base {

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
		$this->require_dependency_class( 'Super_Awesome_Theme_Widgets' );
	}

	/**
	 * Gets the available choices for the 'top_bar_justify_content' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_top_bar_justify_content_choices() {
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
			case 'register_customize_controls':
			case 'add_customizer_script_data':
			case 'print_color_style':
			case 'needs_colors':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Registers settings for top bar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'top_bar_justify_content',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_top_bar_justify_content_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'space-between',
			)
		) );
	}

	/**
	 * Registers widget areas for the top bar.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
	 */
	protected function register_widget_areas( $widgets ) {
		$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
			'top',
			array(
				Super_Awesome_Theme_Widget_Area::PROP_TITLE       => __( 'Top Bar', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => __( 'Add widgets here to appear in a narrow bar at the very top of the screen.', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_INLINE      => true,
			)
		) );
	}

	/**
	 * Registers top bar colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_colors() {
		$colors = $this->get_dependency( 'colors' );

		$colors->register_group( 'top_bar_colors', __( 'Top Bar Colors', 'super-awesome-theme' ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'top_bar_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP           => 'top_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE           => __( 'Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT         => '#ffffff',
			Super_Awesome_Theme_Color::PROP_ACTIVE_CALLBACK => array( $this, 'needs_colors' ),
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'top_bar_link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP           => 'top_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE           => __( 'Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT         => '#ffffff',
			Super_Awesome_Theme_Color::PROP_ACTIVE_CALLBACK => array( $this, 'needs_colors' ),
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'top_bar_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP           => 'top_bar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE           => __( 'Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT         => '#21759b',
			Super_Awesome_Theme_Color::PROP_ACTIVE_CALLBACK => array( $this, 'needs_colors' ),
		) ) );

		$colors->register_color_style_callback( array( $this, 'print_color_style' ) );
	}

	/**
	 * Registers Customizer controls for top bar behavior.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 * @param Super_Awesome_Theme_Widgets    $widgets    Widgets handler instance.
	 */
	protected function register_customize_controls( $customizer, $widgets ) {
		$customizer->add_control( 'top_bar_justify_content', array(
			Super_Awesome_Theme_Customize_Control::PROP_SECTION     => Super_Awesome_Theme_Widgets::CUSTOMIZER_SECTION,
			Super_Awesome_Theme_Customize_Control::PROP_TITLE       => __( 'Top Bar Justify Content', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_DESCRIPTION => __( 'Specify how the widgets in the top bar are aligned.', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_TYPE        => Super_Awesome_Theme_Customize_Control::TYPE_RADIO,
			Super_Awesome_Theme_Customize_Control::PROP_CHOICES     => $this->get_top_bar_justify_content_choices(),
		) );
	}

	/**
	 * Adds script data for Customizer functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_customizer_script_data() {
		$customizer = $this->get_dependency( 'customizer' );

		$preview_script = $customizer->get_preview_script();
		$preview_script->add_data( 'topBarJustifyContentChoices', $this->get_top_bar_justify_content_choices() );
	}

	/**
	 * Prints color styles for the top bar.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Colors $colors The theme colors instance.
	 */
	protected function print_color_style( $colors ) {
		$top_bar_text_color       = $colors->get( 'top_bar_text_color' );
		$top_bar_background_color = $colors->get( 'top_bar_background_color' );

		if ( empty( $top_bar_text_color ) || empty( $top_bar_background_color ) ) {
			return;
		}

		?>
		.site-top-bar {
			color: <?php echo esc_attr( $top_bar_text_color ); ?>;
			background-color: <?php echo esc_attr( $top_bar_background_color ); ?>;
		}
		<?php

		$top_bar_link_color       = $colors->get( 'top_bar_link_color' );
		$top_bar_link_focus_color = $colors->util()->darken_color( $top_bar_link_color, 25 );

		if ( empty( $top_bar_link_color ) || empty( $top_bar_link_focus_color ) ) {
			return;
		}

		?>
		.site-top-bar a,
		.site-top-bar a:visited {
			color: <?php echo esc_attr( $top_bar_link_color ); ?>;
		}

		.site-top-bar a:hover,
		.site-top-bar a:focus,
		.site-top-bar a:active {
			color: <?php echo esc_attr( $top_bar_link_focus_color ); ?>;
		}
		<?php
	}

	/**
	 * Checks whether the top bar colors need to be used.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the top bar colors need to be used, false otherwise.
	 */
	protected function needs_colors() {
		$widgets = $this->get_dependency( 'widgets' );
		return $widgets->get_registered_widget_area( 'top' )->is_active();
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'init', array( $this, 'register_settings' ), 0, 0 );
		add_action( 'init', array( $this, 'register_colors' ), 7, 0 );
		add_action( 'init', array( $this, 'add_customizer_script_data' ), 10, 0 );

		$widgets = $this->get_dependency( 'widgets' );
		$widgets->on_init( array( $this, 'register_widget_areas' ) );
		$widgets->on_customizer_init( array( $this, 'register_customize_controls' ) );
	}
}
