<?php
/**
 * Customizer functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers Customizer functionality.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register( $wp_customize ) {

	/* Site Identity Settings */

	$wp_customize->add_setting( 'branding_location', array(
		'default'           => 'header',
		'transport'         => 'refresh',
		'validate_callback' => 'super_awesome_theme_customize_validate_branding_location',
	) );
	$wp_customize->add_control( 'branding_location', array(
		'section'     => 'title_tagline',
		'label'       => __( 'Display Location', 'super-awesome-theme' ),
		'description' => __( 'Specify where to display the site logo, title and tagline.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_branding_location_choices(),
	) );

	/* Header Media */

	$wp_customize->add_setting( 'header_position', array(
		'default'           => 'above_navbar',
		'transport'         => 'refresh',
		'validate_callback' => 'super_awesome_theme_customize_validate_header_position',
	) );
	$wp_customize->add_control( 'header_position', array(
		'section'     => 'header_image',
		'label'       => _x( 'Position', 'custom header', 'super-awesome-theme' ),
		'description' => __( 'Specify where to display the header image or video.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_header_position_choices(),
	) );

	$wp_customize->add_setting( 'header_textalign', array(
		'default'           => 'text-center',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_header_textalign',
	) );
	$wp_customize->add_control( 'header_textalign', array(
		'section' => 'header_image',
		'label'   => _x( 'Text Alignment', 'custom header', 'super-awesome-theme' ),
		'type'    => 'radio',
		'choices' => super_awesome_theme_customize_get_header_textalign_choices(),
	) );
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Validates the 'branding_location' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_branding_location( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_branding_location_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'branding_location' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_branding_location_choices() {
	return array(
		'header'       => __( 'In front of the header image', 'super-awesome-theme' ),
		'navbar_left'  => __( 'On the left inside the navigation bar', 'super-awesome-theme' ),
		'navbar_right' => __( 'On the right inside the navigation bar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'header_position' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_header_position( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_header_position_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'header_position' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_header_position_choices() {
	return array(
		'above_navbar' => __( 'Above the navigation bar', 'super-awesome-theme' ),
		'below_navbar' => __( 'Below the navigation bar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'header_textalign' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_header_textalign( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_header_textalign_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'header_textalign' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_header_textalign_choices() {
	return array(
		'text-left'   => _x( 'Left', 'alignment', 'super-awesome-theme' ),
		'text-center' => _x( 'Center', 'alignment', 'super-awesome-theme' ),
		'text-right'  => _x( 'Right', 'alignment', 'super-awesome-theme' ),
	);
}
