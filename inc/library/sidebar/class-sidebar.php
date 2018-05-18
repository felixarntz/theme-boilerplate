<?php
/**
 * Super_Awesome_Theme_Sidebar class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class responsible for the theme sidebar.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Sidebar extends Super_Awesome_Theme_Theme_Component_Base {

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
	}

	/**
	 * Gets the name of the sidebar to display on the current page.
	 *
	 * @since 1.0.0
	 *
	 * @return string The sidebar name.
	 */
	public function get_sidebar_name() {
		$sidebar_name = 'primary';

		if ( $this->get_dependency( 'settings' )->get( 'blog_sidebar_enabled' ) && $this->allow_display_blog_sidebar() ) {
			$sidebar_name = 'blog';
		}

		/**
		 * Filters the name of the sidebar to display on the current page.
		 *
		 * @since 1.0.0
		 *
		 * @param string $sidebar_name The sidebar name. By default either 'primary' or 'blog'.
		 */
		return apply_filters( 'super_awesome_theme_get_sidebar_name', $sidebar_name );
	}

	/**
	 * Checks whether the sidebar should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the sidebar should be displayed, false otherwise.
	 */
	public function should_display_sidebar() {
		if ( ! $this->allow_display_sidebar() ) {
			return false;
		}

		return 'no_sidebar' !== $this->get_dependency( 'settings' )->get( 'sidebar_mode' );
	}

	/**
	 * Checks whether the current page does allow the sidebar to be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the sidebar can be displayed, false otherwise.
	 */
	public function allow_display_sidebar() {
		$result = ! $this->get_dependency( 'distraction_free_mode' )->is_distraction_free();

		/**
		 * Filters whether to allow displaying the sidebar on the current page.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $result Whether to allow displaying the sidebar on the current page.
		 */
		return apply_filters( 'super_awesome_theme_allow_display_sidebar', $result );
	}

	/**
	 * Checks whether the current page does allow the blog sidebar to be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the blog sidebar can be displayed, false otherwise.
	 */
	public function allow_display_blog_sidebar() {
		$result = false;

		if ( is_singular() ) {
			if ( 'post' === get_post_type() ) {
				$result = true;
			}
		} elseif ( is_home() || is_category() || is_tag() || is_date() || 'post' === get_query_var( 'post_type' ) ) {
			$result = true;
		}

		/**
		 * Filters whether to allow displaying the blog sidebar on the current page.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $result Whether to allow displaying the blog sidebar on the current page.
		 */
		return apply_filters( 'super_awesome_theme_allow_display_blog_sidebar', $result );
	}

	/**
	 * Gets the available choices for the 'sidebar_mode' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_sidebar_mode_choices() {
		return array(
			'no_sidebar'    => __( 'No Sidebar', 'super-awesome-theme' ),
			'left_sidebar'  => __( 'Left Sidebar', 'super-awesome-theme' ),
			'right_sidebar' => __( 'Right Sidebar', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets the available choices for the 'sidebar_size' setting.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array where values are the keys, and labels are the values.
	 */
	public function get_sidebar_size_choices() {
		return array(
			'small'  => __( 'Small', 'super-awesome-theme' ),
			'medium' => __( 'Medium', 'super-awesome-theme' ),
			'large'  => __( 'Large', 'super-awesome-theme' ),
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
			case 'register_customize_controls':
			case 'add_customizer_script_data':
				return call_user_func_array( array( $this, $method ), $args );
			case 'add_sidebar_body_classes':
				if ( empty( $args ) ) {
					return;
				}

				$settings = $this->get_dependency( 'settings' );

				$classes = $args[0];
				if ( ! $this->should_display_sidebar() ) {
					$classes[] = 'no-sidebar';
				} else {
					$classes[] = str_replace( '_', '-', $settings->get( 'sidebar_mode' ) );
				}
				$classes[] = 'sidebar-' . $settings->get( 'sidebar_size' );

				return $classes;
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
			'sidebar_mode',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_sidebar_mode_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'right_sidebar',
			)
		) );

		$settings->register_setting( new Super_Awesome_Theme_Enum_String_Setting(
			'sidebar_size',
			array(
				Super_Awesome_Theme_Enum_String_Setting::PROP_ENUM    => array_keys( $this->get_sidebar_size_choices() ),
				Super_Awesome_Theme_Enum_String_Setting::PROP_DEFAULT => 'medium',
			)
		) );

		$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting(
			'blog_sidebar_enabled',
			array( Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => false )
		) );
	}

	/**
	 * Registers widget areas for the sidebar.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Widgets $widgets Widgets handler instance.
	 */
	protected function register_widget_areas( $widgets ) {
		$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
			'primary',
			array(
				Super_Awesome_Theme_Widget_Area::PROP_TITLE       => __( 'Primary Sidebar', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => __( 'Add widgets here to appear in the sidebar for your main content.', 'super-awesome-theme' ),
			)
		) );

		$blog_sidebar_description = __( 'Add widgets here to appear in the sidebar for blog posts and archive pages.', 'super-awesome-theme' );
		if ( ! $this->get_dependency( 'settings' )->get( 'blog_sidebar_enabled' ) ) {
			if ( 'customize.php' === $GLOBALS['pagenow'] ) {
				$blog_sidebar_description .= ' <a href="" onclick="wp.customize.control( \'blog_sidebar_enabled\' ).focus();return false;">' . __( 'You need to enable the sidebar first.', 'super-awesome-theme' ) . '</a>';
			} else {

				// WordPress only allows arbitrary HTML here since version 4.9.7.
				if ( version_compare( $GLOBALS['wp_version'], '4.9.7', '>=' ) ) {
					$blog_sidebar_description .= ' <a href="' . esc_url( admin_url( 'customize.php?autofocus[control]=blog_sidebar_enabled' ) ) . '">' . __( 'You need to enable the sidebar in the Customizer first.', 'super-awesome-theme' ) . '</a>';
				} else {
					$blog_sidebar_description .= ' ' . __( 'You need to enable the sidebar in the Customizer first.', 'super-awesome-theme' );
				}
			}
		}

		$widgets->register_widget_area( new Super_Awesome_Theme_Widget_Area(
			'blog',
			array(
				Super_Awesome_Theme_Widget_Area::PROP_TITLE       => __( 'Blog Sidebar', 'super-awesome-theme' ),
				Super_Awesome_Theme_Widget_Area::PROP_DESCRIPTION => $blog_sidebar_description,
			)
		) );
	}

	/**
	 * Registers Customizer controls for sidebar behavior.
	 *
	 * @since 1.0.0
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 * @param Super_Awesome_Theme_Widgets    $widgets    Widgets handler instance.
	 */
	protected function register_customize_controls( $customizer, $widgets ) {
		$customizer->add_control( 'sidebar_mode', array(
			Super_Awesome_Theme_Customize_Control::PROP_SECTION         => Super_Awesome_Theme_Widgets::CUSTOMIZER_SECTION,
			Super_Awesome_Theme_Customize_Control::PROP_TITLE           => __( 'Sidebar Mode', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_DESCRIPTION     => __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_TYPE            => Super_Awesome_Theme_Customize_Control::TYPE_RADIO,
			Super_Awesome_Theme_Customize_Control::PROP_CHOICES         => $this->get_sidebar_mode_choices(),
			Super_Awesome_Theme_Customize_Control::PROP_ACTIVE_CALLBACK => array( $this, 'allow_display_sidebar' ),
		) );

		$customizer->add_control( 'sidebar_size', array(
			Super_Awesome_Theme_Customize_Control::PROP_SECTION         => Super_Awesome_Theme_Widgets::CUSTOMIZER_SECTION,
			Super_Awesome_Theme_Customize_Control::PROP_TITLE           => __( 'Sidebar Size', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_DESCRIPTION     => __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_TYPE            => Super_Awesome_Theme_Customize_Control::TYPE_RADIO,
			Super_Awesome_Theme_Customize_Control::PROP_CHOICES         => $this->get_sidebar_size_choices(),
			Super_Awesome_Theme_Customize_Control::PROP_ACTIVE_CALLBACK => array( $this, 'allow_display_sidebar' ),
		) );

		$customizer->add_control( 'blog_sidebar_enabled', array(
			Super_Awesome_Theme_Customize_Control::PROP_SECTION         => Super_Awesome_Theme_Widgets::CUSTOMIZER_SECTION,
			Super_Awesome_Theme_Customize_Control::PROP_TITLE           => __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_DESCRIPTION     => __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
			Super_Awesome_Theme_Customize_Control::PROP_TYPE            => Super_Awesome_Theme_Customize_Control::TYPE_CHECKBOX,
			Super_Awesome_Theme_Customize_Control::PROP_ACTIVE_CALLBACK => array( $this, 'allow_display_blog_sidebar' ),
		) );

		$customizer->add_partial( 'blog_sidebar_enabled', array(
			Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '#sidebar',
			Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => 'get_sidebar',
			Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => true,
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
		$preview_script->add_data( 'sidebarModeChoices', $this->get_sidebar_mode_choices() );
		$preview_script->add_data( 'sidebarSizeChoices', $this->get_sidebar_size_choices() );

		$controls_script = $customizer->get_controls_script();
		$controls_script->add_data( 'blogSidebarEnabledNotice', __( 'This page doesn&#8217;t support the blog sidebar. Navigate to the blog page or another page that supports it.', 'super-awesome-theme' ) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'init', array( $this, 'register_settings' ), 0, 0 );
		add_action( 'init', array( $this, 'add_customizer_script_data' ), 10, 0 );
		add_filter( 'body_class', array( $this, 'add_sidebar_body_classes' ), 10, 1 );

		$widgets = $this->get_dependency( 'widgets' );
		$widgets->on_init( array( $this, 'register_widget_areas' ) );
		$widgets->on_customizer_init( array( $this, 'register_customize_controls' ) );
	}
}
