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
	if ( empty( $color ) ) {
		return $color;
	}

	$rgb = super_awesome_theme_hex_to_rgb( $color );

	$darkened = array();
	foreach ( $rgb as $channel ) {
		$darkened[] = (int) round( $channel * ( 1.0 - $percentage / 100.0 ) );
	}

	return super_awesome_theme_rgb_to_hex( $darkened );
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
	if ( strlen( $color ) === 4 ) {
		$rgb = str_split( substr( $color, 1 ), 1 );
		$rgb = array_map( array( $this, 'duplicate_char' ), $rgb );
	} else {
		$rgb = str_split( substr( $color, 1 ), 2 );
	}

	return array_map( 'hexdec', $rgb );
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
	$hex = array_map( 'zeroise', array_map( 'dechex', $color ), array( 2, 2, 2 ) );

	return '#' . $hex[0] . $hex[1] . $hex[2];
}
