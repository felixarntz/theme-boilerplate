<?php
/**
 * Super_Awesome_Theme_Navbar class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for the theme navbar.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Navbar extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Colors' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Distraction_Free_Mode' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Sticky_Elements' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Widgets' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Menus' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Icons' );
	}

	/**
	 * Gets the name of the primary navigation to display on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @return string The primary navigation name, either 'primary' or 'primary_df'.
	 */
	public function get_navigation_name() {
		$result = 'primary';

		if ( $this->get_dependency( 'distraction_free_mode' )->is_distraction_free() ) {
			$result = 'primary_df';
		}

		/**
		 * Filters the name of the primary navigation to display on the current page.
		 *
		 * @since 1.0.0
		 *
		 * @param string $result The identifier of the primary navigation to display.
		 */
		return apply_filters( 'super_awesome_theme_get_navigation_name', $result );
	}

	/**
	 * Checks whether the navbar should be displayed on the side of the page.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if navbar should be displayed vertically on the side, false otherwise.
	 */
	public function is_side() {
		$settings = $this->get_dependency( 'settings' );

		return in_array( $settings->get( 'navbar_position' ), array( 'left', 'right' ), true );
	}

	/**
	 * Checks whether the navbar is currently sticky.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if navbar is sticky, false otherwise.
	 */
	public function is_sticky() {
		$sticky_elements = $this->get_dependency( 'sticky_elements' );

		$navbar = $sticky_elements->get_registered_sticky_element( 'navbar' );

		return $navbar->is_sticky();
	}

	/**
	 * Gets the available choices for the 'navbar_position' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_navbar_position_choices() {
		return array(
			'above-header' => _x( 'Top of the page, above header', 'navbar position', 'super-awesome-theme' ),
			'below-header' => _x( 'Top of the page, below header', 'navbar position', 'super-awesome-theme' ),
			'left'         => _x( 'Left side of the page', 'navbar position', 'super-awesome-theme' ),
			'right'        => _x( 'Right side of the page', 'navbar position', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets the available choices for the 'navbar_justify_content' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_navbar_justify_content_choices() {
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
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_settings':
			case 'register_widget_areas':
			case 'register_menus':
			case 'register_colors':
			case 'register_sticky':
			case 'register_customize_controls_js':
			case 'register_customize_preview_js':
			case 'add_main_script_data':
			case 'print_color_style':
			case 'add_dropdown_icon_to_menu_link':
				return call_user_func_array( array( $this, $method ), $args );
			case 'add_navbar_body_classes':
				if ( empty( $args ) ) {
					return;
				}

				$settings = $this->get_dependency( 'settings' );

				$classes   = $args[0];
				$classes[] = 'navbar-' . $settings->get( 'navbar_position' );

				return $classes;
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers settings for navbar behavior.
	 *
	 * @since 1.0.0
	 */
	protected function register_settings() {
		$settings = $this->get_dependency( 'settings' );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'navbar_position',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_navbar_position_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'above-header',
			)
		) );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'navbar_justify_content',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_navbar_justify_content_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'space-between',
			)
		) );
	}

	/**
	 * Registers widget areas for the navbar.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
	 */
	protected function register_widget_areas( $widgets ) {
		$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
			'nav-extra',
			array(
				Super_Awesome_Theme_Widget_Area::PROP_TITLE       => __( 'Navbar Extra', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => __( 'Add widgets here to appear as additional content in the navbar beside the main navigation menu.', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_INLINE      => ! $this->is_side(),
			)
		) );
	}

	/**
	 * Registers the main navigation menus.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Menus $menus Menus handler instance.
	 */
	protected function register_menus( $menus ) {
		$menus->register_menu( new Super_Awesome_Theme_Menu( 'primary', array(
			Super_Awesome_Theme_Menu::PROP_TITLE       => __( 'Primary Menu', 'super-awesome-theme' ),
			Super_Awesome_Theme_Menu::PROP_MENU_ID     => 'primary-menu',
			Super_Awesome_Theme_Menu::PROP_FALLBACK_CB => 'wp_page_menu',
		) ) );

		$menus->register_menu( new Super_Awesome_Theme_Menu( 'primary_df', array(
			Super_Awesome_Theme_Menu::PROP_TITLE   => __( 'Primary Menu (Landing Page)', 'super-awesome-theme' ),
			Super_Awesome_Theme_Menu::PROP_MENU_ID => 'primary-menu',
		) ) );
	}

	/**
	 * Registers navbar colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_colors() {
		$colors = $this->get_dependency( 'colors' );

		$colors->register_group( 'navbar_colors', __( 'Navbar Colors', 'super-awesome-theme' ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'navbar_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'navbar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Navbar Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#404040',
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'navbar_link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'navbar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Navbar Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#21759b',
		) ) );

		$colors->register_color( new Super_Awesome_Theme_Color( 'navbar_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'navbar_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Navbar Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#eeeeee',
		) ) );

		$colors->register_color_style_callback( array( $this, 'print_color_style' ) );
	}

	/**
	 * Registers the navbar as a sticky frontend element.
	 *
	 * @since 1.0.0
	 */
	protected function register_sticky() {
		$sticky_elements = $this->get_dependency( 'sticky_elements' );

		$sticky_elements->register_sticky_element( new Super_Awesome_Theme_Sticky_Element(
			'navbar',
			array(
				Super_Awesome_Theme_Sticky_Element::PROP_SELECTOR => '#site-navbar',
				Super_Awesome_Theme_Sticky_Element::PROP_LABEL    => __( 'Stick the navbar to the top of the page when scrolling?', 'super-awesome-theme' ),
				Super_Awesome_Theme_Sticky_Element::PROP_LOCATION => Super_Awesome_Theme_Sticky_Element::LOCATION_TOP,
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
			'super-awesome-theme-navbar-customize-controls',
			get_theme_file_uri( '/assets/dist/js/navbar.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeNavbarControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'navbarPositionChoices'       => $this->get_navbar_position_choices(),
					'navbarJustifyContentChoices' => $this->get_navbar_justify_content_choices(),
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
			'super-awesome-theme-navbar-customize-preview',
			get_theme_file_uri( '/assets/dist/js/navbar.customize-preview.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-preview' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_PREVIEW,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeNavbarPreviewData',
				Super_Awesome_Theme_Script::PROP_DATA         => array(
					'navbarPositionChoices'       => $this->get_navbar_position_choices(),
					'navbarJustifyContentChoices' => $this->get_navbar_justify_content_choices(),
				),
			)
		) );
	}

	/**
	 * Adds script data for navigation functionality.
	 *
	 * @since 1.0.0
	 */
	protected function add_main_script_data() {
		$assets = $this->get_dependency( 'assets' );
		$script = $assets->get_registered_asset( 'super-awesome-theme-script' );

		if ( has_nav_menu( $this->get_navigation_name() ) ) {
			$script->add_data( 'navigation', array(
				'icon' => $this->get_dependency( 'icons' )->get_svg( 'angle-down', array( 'fallback' => true ) ),
				'i18n' => array(
					'expand'   => __( 'Expand child menu', 'super-awesome-theme' ),
					'collapse' => __( 'Collapse child menu', 'super-awesome-theme' ),
				),
			) );
		}
	}

	/**
	 * Prints color styles for the navbar.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Colors $colors The theme colors instance.
	 */
	protected function print_color_style( $colors ) {
		$navbar_text_color       = $colors->get( 'navbar_text_color' );
		$navbar_background_color = $colors->get( 'navbar_background_color' );

		if ( empty( $navbar_text_color ) || empty( $navbar_background_color ) ) {
			return;
		}

		?>
		.site-navbar {
			color: <?php echo esc_attr( $navbar_text_color ); ?>;
			background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
		}

		.js .site-navbar .site-navigation .site-navigation-content,
		.amp .site-navbar .site-navigation .site-navigation-content {
			background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
		}
		<?php

		$navbar_link_color       = $colors->get( 'navbar_link_color' );
		$navbar_link_focus_color = $colors->util()->darken_color( $navbar_link_color, 25 );

		if ( empty( $navbar_link_color ) || empty( $navbar_link_focus_color ) ) {
			return;
		}

		?>
		.site-navbar a,
		.site-navbar a:visited {
			color: <?php echo esc_attr( $navbar_link_color ); ?>;
		}

		.site-navbar a:hover,
		.site-navbar a:focus,
		.site-navbar a:active {
			color: <?php echo esc_attr( $navbar_link_focus_color ); ?>;
		}
		<?php
	}

	/**
	 * Adds a dropdown icon to a menu item in the primary navigation if it has children.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $title The menu item's title.
	 * @param WP_Post $item  The current menu item.
	 * @param array   $args  An array of wp_nav_menu() arguments.
	 * @return string $title The menu item's title with dropdown icon.
	 */
	protected function add_dropdown_icon_to_menu_link( $title, $item, $args ) {
		if ( in_array( $args->theme_location, array( 'primary', 'primary_df' ), true ) ) {
			foreach ( $item->classes as $value ) {
				if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
					$title .= $this->get_dependency( 'icons' )->get_svg( 'angle-down' );
					break;
				}
			}
		}

		return $title;
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_settings' ), 0, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_colors' ), 6, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_sticky' ), 0, 0 );
		add_filter( 'body_class', array( $this, 'add_navbar_body_classes' ), 10, 1 );
		add_action( 'wp_head', array( $this, 'add_main_script_data' ), 0, 0 );
		add_filter( 'nav_menu_item_title', array( $this, 'add_dropdown_icon_to_menu_link' ), 10, 3 );

		$widgets = $this->get_dependency( 'widgets' );
		$widgets->on_init( array( $this, 'register_widget_areas' ) );

		$menus = $this->get_dependency( 'menus' );
		$menus->on_init( array( $this, 'register_menus' ) );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
		$customizer->on_js_preview_init( array( $this, 'register_customize_preview_js' ) );
	}
}
