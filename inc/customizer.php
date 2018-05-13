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

	/* Colors */

	$wp_customize->add_section( 'navbar_colors', array(
		'panel' => 'colors',
		'title' => __( 'Navbar Colors', 'super-awesome-theme' ),
	) );

	$wp_customize->add_setting( 'navbar_text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_text_color', array(
		'section' => 'navbar_colors',
		'label'   => __( 'Navbar Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'navbar_link_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_link_color', array(
		'section' => 'navbar_colors',
		'label'   => __( 'Navbar Link Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'navbar_background_color', array(
		'default'              => '#eeeeee',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_background_color', array(
		'section' => 'navbar_colors',
		'label'   => __( 'Navbar Background Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_section( 'top_bar_colors', array(
		'panel'           => 'colors',
		'title'           => __( 'Top Bar Colors', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_top_bar_colors',
	) );

	$wp_customize->add_setting( 'top_bar_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_text_color', array(
		'section'         => 'top_bar_colors',
		'label'           => __( 'Top Bar Text Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_top_bar_colors',
	) ) );

	$wp_customize->add_setting( 'top_bar_link_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_link_color', array(
		'section'         => 'top_bar_colors',
		'label'           => __( 'Top Bar Link Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_top_bar_colors',
	) ) );

	$wp_customize->add_setting( 'top_bar_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_background_color', array(
		'section'         => 'top_bar_colors',
		'label'           => __( 'Top Bar Background Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_top_bar_colors',
	) ) );

	$wp_customize->add_section( 'bottom_bar_colors', array(
		'panel'           => 'colors',
		'title'           => __( 'Bottom Bar Colors', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_bottom_bar_colors',
	) );

	$wp_customize->add_setting( 'bottom_bar_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_text_color', array(
		'section'         => 'bottom_bar_colors',
		'label'           => __( 'Bottom Bar Text Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_bottom_bar_colors',
	) ) );

	$wp_customize->add_setting( 'bottom_bar_link_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_link_color', array(
		'section'         => 'bottom_bar_colors',
		'label'           => __( 'Bottom Bar Link Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_bottom_bar_colors',
	) ) );

	$wp_customize->add_setting( 'bottom_bar_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bar_background_color', array(
		'section'         => 'bottom_bar_colors',
		'label'           => __( 'Bottom Bar Background Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_customize_needs_bottom_bar_colors',
	) ) );

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

	/* Widget Settings */

	if ( is_admin() ) {
		super_awesome_theme_customize_register_widget_area_settings();
	} else {
		add_action( 'wp', 'super_awesome_theme_customize_register_widget_area_settings' );
	}

	/* Customizer-generated CSS */

	$wp_customize->selective_refresh->add_partial( 'super_awesome_theme_customizer_styles', array(
		'settings'            => array(
			'navbar_text_color',
			'navbar_link_color',
			'navbar_background_color',
			'top_bar_text_color',
			'top_bar_link_color',
			'top_bar_background_color',
			'bottom_bar_text_color',
			'bottom_bar_link_color',
			'bottom_bar_background_color',
		),
		'selector'            => '#super-awesome-theme-customizer-styles',
		'render_callback'     => 'super_awesome_theme_customize_partial_styles',
		'container_inclusive' => false,
		'fallback_refresh'    => false,
	) );
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Registers additional Customizer functionality for widget areas.
 *
 * @since 1.0.0
 *
 * @global WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register_widget_area_settings() {
	global $wp_customize;

	$wp_customize->add_setting( 'top_bar_justify_content', array(
		'default'           => 'space-between',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_bar_justify_content',
	) );
	$wp_customize->add_control( 'top_bar_justify_content', array(
		'section'     => 'widget_areas',
		'label'       => __( 'Top Bar Justify Content', 'super-awesome-theme' ),
		'description' => __( 'Specify how the widgets in the top bar are aligned.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_bar_justify_content_choices(),
	) );

	$wp_customize->add_setting( 'bottom_bar_justify_content', array(
		'default'           => 'space-between',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_bar_justify_content',
	) );
	$wp_customize->add_control( 'bottom_bar_justify_content', array(
		'section'     => 'widget_areas',
		'label'       => __( 'Bottom Bar Justify Content', 'super-awesome-theme' ),
		'description' => __( 'Specify how the widgets in the bottom bar are aligned.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_bar_justify_content_choices(),
	) );
}

/**
 * Prints styles generated through the Customizer.
 *
 * @since 1.0.0
 */
function super_awesome_theme_print_customizer_styles() {
	$navbar_text_color                     = get_theme_mod( 'navbar_text_color', '#404040' );
	$navbar_link_color                     = get_theme_mod( 'navbar_link_color', '#21759b' );
	$navbar_link_focus_color               = super_awesome_theme_darken_color( $navbar_link_color, 25 );
	$navbar_background_color               = get_theme_mod( 'navbar_background_color', '#eeeeee' );
	$top_bar_text_color                    = get_theme_mod( 'top_bar_text_color', '#ffffff' );
	$top_bar_link_color                    = get_theme_mod( 'top_bar_link_color', '#ffffff' );
	$top_bar_link_focus_color              = super_awesome_theme_darken_color( $top_bar_link_color, 25 );
	$top_bar_background_color              = get_theme_mod( 'top_bar_background_color', '#21759b' );
	$bottom_bar_text_color                 = get_theme_mod( 'bottom_bar_text_color', '#ffffff' );
	$bottom_bar_link_color                 = get_theme_mod( 'bottom_bar_link_color', '#ffffff' );
	$bottom_bar_link_focus_color           = super_awesome_theme_darken_color( $bottom_bar_link_color, 25 );
	$bottom_bar_background_color           = get_theme_mod( 'bottom_bar_background_color', '#21759b' );

	?>
	<style id="super-awesome-theme-customizer-styles" type="text/css">
		<?php if ( ! empty( $navbar_text_color ) && ! empty( $navbar_background_color ) ) : ?>
			.site-navbar {
				color: <?php echo esc_attr( $navbar_text_color ); ?>;
				background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
			}

			.js .site-navbar .site-navigation .site-navigation-content {
				background-color: <?php echo esc_attr( $navbar_background_color ); ?>;
			}

			<?php if ( ! empty( $navbar_link_color ) && ! empty( $navbar_link_focus_color ) ) : ?>
				.site-navbar a,
				.site-navbar a:visited {
					color: <?php echo esc_attr( $navbar_link_color ); ?>;
				}

				.site-navbar a:hover,
				.site-navbar a:focus,
				.site-navbar a:active {
					color: <?php echo esc_attr( $navbar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ! empty( $top_bar_text_color ) && ! empty( $top_bar_background_color ) ) : ?>
			.site-top-bar {
				color: <?php echo esc_attr( $top_bar_text_color ); ?>;
				background-color: <?php echo esc_attr( $top_bar_background_color ); ?>;
			}

			<?php if ( ! empty( $top_bar_link_color ) && ! empty( $top_bar_link_focus_color ) ) : ?>
				.site-top-bar a,
				.site-top-bar a:visited {
					color: <?php echo esc_attr( $top_bar_link_color ); ?>;
				}

				.site-top-bar a:hover,
				.site-top-bar a:focus,
				.site-top-bar a:active {
					color: <?php echo esc_attr( $top_bar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ! empty( $bottom_bar_text_color ) && ! empty( $bottom_bar_background_color ) ) : ?>
			.site-bottom-bar {
				color: <?php echo esc_attr( $bottom_bar_text_color ); ?>;
				background-color: <?php echo esc_attr( $bottom_bar_background_color ); ?>;
			}

			<?php if ( ! empty( $bottom_bar_link_color ) && ! empty( $bottom_bar_link_focus_color ) ) : ?>
				.site-bottom-bar a,
				.site-bottom-bar a:visited {
					color: <?php echo esc_attr( $bottom_bar_link_color ); ?>;
				}

				.site-bottom-bar a:hover,
				.site-bottom-bar a:focus,
				.site-bottom-bar a:active {
					color: <?php echo esc_attr( $bottom_bar_link_focus_color ); ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'super_awesome_theme_print_customizer_styles' );

/**
 * Renders the Customizer styles for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_styles() {
	ob_start();
	super_awesome_theme_print_customizer_styles();
	$output = ob_get_clean();

	echo preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $output ); // WPCS: XSS OK.
}

/**
 * Checks whether the top bar color controls are needed.
 *
 * @since 1.0.0
 *
 * @return bool True if top bar color controls should be active, false otherwise.
 */
function super_awesome_theme_customize_needs_top_bar_colors() {
	return is_active_sidebar( 'top' );
}

/**
 * Checks whether the bottom bar color controls are needed.
 *
 * @since 1.0.0
 *
 * @return bool True if bottom bar color controls should be active, false otherwise.
 */
function super_awesome_theme_customize_needs_bottom_bar_colors() {
	return is_active_sidebar( 'bottom' );
}

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

/**
 * Validates the 'top_bar_justify_content' and 'bottom_bar_justify_content' customizer settings.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_bar_justify_content( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_bar_justify_content_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'top_bar_justify_content' and 'bottom_bar_justify_content' customizer settings.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_bar_justify_content_choices() {
	return array(
		'space-between' => _x( 'Space Between', 'alignment', 'super-awesome-theme' ),
		'centered'      => _x( 'Centered', 'alignment', 'super-awesome-theme' ),
	);
}
