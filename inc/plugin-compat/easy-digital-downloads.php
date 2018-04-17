<?php
/**
 * Easy Digital Downloads compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

// add_filter( 'edd_get_option_disable_styles', '__return_true' );

/**
 * Ensures that the Easy Digital Downloads checkout page is rendered in distraction-free mode.
 *
 * @since 1.0.0
 *
 * @param bool $result Whether to display the page in distraction-free mode.
 * @return bool Possibly modified $result value.
 */
function super_awesome_theme_edd_make_checkout_distraction_free( $result ) {
	if ( edd_is_checkout() ) {
		return true;
	}

	return $result;
}
add_filter( 'super_awesome_theme_is_distraction_free', 'super_awesome_theme_edd_make_checkout_distraction_free' );

/**
 * Adds the default button classes to button defaults for Easy Digital Downloads purchase links.
 *
 * @since 1.0.0
 *
 * @param array $defaults Easy Digital Downloads purchase link defaults.
 * @return array Modified $defaults data.
 */
function super_awesome_theme_edd_adjust_purchase_link_defaults( $defaults ) {
	$defaults['class'] .= ' button';

	if ( is_singular( 'download' ) ) {
		$defaults['class'] .= ' button-primary';
	}

	return $defaults;
}
add_filter( 'edd_purchase_link_defaults', 'super_awesome_theme_edd_adjust_purchase_link_defaults' );

/**
 * Adds the default button classes to button defaults for Easy Digital Downloads purchase link shortcodes.
 *
 * @since 1.0.0
 *
 * @param array $out      Combined data of $atts filled with $defaults.
 * @param array $defaults Easy Digital Downloads purchase link defaults.
 * @param array $atts     Attributes passed to the shortcode.
 * @return array Possibly modified $out data.
 */
function super_awesome_theme_edd_adjust_purchase_link_shortcode_defaults( $out, $defaults, $atts ) {
	// If the class attribute is manually provided, do not change anything.
	if ( ! empty( $atts['class'] ) ) {
		return $out;
	}

	return super_awesome_theme_edd_adjust_purchase_link_defaults( $out );
}
add_filter( 'shortcode_atts_purchase_link', 'super_awesome_theme_edd_adjust_purchase_link_shortcode_defaults', 10, 3 );
