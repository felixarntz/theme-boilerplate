<?php
/**
 * Utility functions used by the theme
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Darkens a hex color string about a given percentage.
 *
 * @since 1.0.0
 *
 * @param string $color      Hex color string.
 * @param int    $percentage Percentage to darken about.
 * @return string Darkened hex color string.
 */
function super_awesome_theme_darken_color( $color, $percentage ) {
	return super_awesome_theme()->get_component( 'colors' )->util()->darken_color( $color, $percentage );
}

/**
 * Lightens a hex color string about a given percentage.
 *
 * @since 1.0.0
 *
 * @param string $color      Hex color string.
 * @param int    $percentage Percentage to darken about.
 * @return string Lightened hex color string.
 */
function super_awesome_theme_lighten_color( $color, $percentage ) {
	return super_awesome_theme()->get_component( 'colors' )->util()->lighten_color( $color, $percentage );
}

/**
 * Converts a hex color string into an RGB array.
 *
 * @since 1.0.0
 *
 * @param string $color Hex color string.
 * @return array RGB color array.
 */
function super_awesome_theme_hex_to_rgb( $color ) {
	return super_awesome_theme()->get_component( 'colors' )->util()->hex_to_rgb( $color );
}

/**
 * Converts an RGB array into a hex color string.
 *
 * @since 1.0.0
 *
 * @param array $color RGB color array.
 * @return string Hex color string.
 */
function super_awesome_theme_rgb_to_hex( $color ) {
	return super_awesome_theme()->get_component( 'colors' )->util()->rgb_to_hex( $color );
}
