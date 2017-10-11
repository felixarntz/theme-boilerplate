<?php
/**
 * Customizer functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Registers Customizer functionality.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'super_awesome_theme_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'super_awesome_theme_customize_partial_blogdescription',
	) );

	/* Sidebar Settings */

	$wp_customize->add_section( 'sidebars', array(
		'title'    => __( 'Sidebars', 'super-awesome-theme' ),
		'priority' => 105,
	) );

	$wp_customize->add_setting( 'sidebar_mode', array(
		'default'           => 'right-sidebar',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_mode',
	) );
	$wp_customize->add_control( 'sidebar_mode', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Mode', 'super-awesome-theme' ),
		'description' => __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_mode_choices(),
	) );

	$wp_customize->add_setting( 'sidebar_size', array(
		'default'           => 'medium',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_size',
	) );
	$wp_customize->add_control( 'sidebar_size', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Size', 'super-awesome-theme' ),
		'description' => __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );

	$wp_customize->add_setting( 'blog_sidebar_enabled', array(
		'default'           => '',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'blog_sidebar_enabled', array(
		'section'     => 'sidebars',
		'label'       => __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
		'description' => __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
		'type'        => 'checkbox',
	) );
	$wp_customize->selective_refresh->add_partial( 'blog_sidebar_enabled', array(
		'selector'            => '#secondary',
		'render_callback'     => 'super_awesome_theme_customize_partial_blog_sidebar_enabled',
		'container_inclusive' => true,
	) );
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Renders the site title for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Renders the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Validates the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_mode( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_mode_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_mode_choices() {
	return array(
		'no-sidebar'    => __( 'No Sidebar', 'super-awesome-theme' ),
		'left-sidebar'  => __( 'Left Sidebar', 'super-awesome-theme' ),
		'right-sidebar' => __( 'Right Sidebar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_size( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_size_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_size_choices() {
	return array(
		'small'  => __( 'Small', 'super-awesome-theme' ),
		'medium' => __( 'Medium', 'super-awesome-theme' ),
		'large'  => __( 'Large', 'super-awesome-theme' ),
	);
}

/**
 * Renders the primary or blog sidebar for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blog_sidebar_enabled() {
	get_sidebar( super_awesome_theme_get_current_sidebar_name() );
}

/**
 * Enqueues the script for the Customizer controls.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_controls_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-controls', get_theme_file_uri( '/assets/dist/js/customize-controls' . $min . '.js' ), array(), SUPER_AWESOME_THEME_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'super_awesome_theme_customize_controls_js' );

/**
 * Enqueues the script for the Customizer preview.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_preview_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-preview', get_theme_file_uri( '/assets/dist/js/customize-preview' . $min . '.js' ), array( 'customize-preview' ), SUPER_AWESOME_THEME_VERSION, true );
	wp_localize_script( 'super-awesome-theme-customize-preview', 'themeCustomizeData', array(
		'sidebarModeChoices' => super_awesome_theme_customize_get_sidebar_mode_choices(),
		'sidebarSizeChoices' => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );
}
add_action( 'customize_preview_init', 'super_awesome_theme_customize_preview_js' );
