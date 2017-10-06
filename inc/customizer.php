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
 * Enqueues the script for the Customizer preview.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_preview_js() {
	wp_enqueue_script( 'super-awesome-theme-customizer', get_theme_file_uri( '/assets/dist/js/customizer.js' ), array( 'customize-preview' ), SUPER_AWESOME_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'super_awesome_theme_customize_preview_js' );
