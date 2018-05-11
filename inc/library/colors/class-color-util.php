<?php
/**
 * Super_Awesome_Theme_Color_Util class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class containing color modification utility methods.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Color_Util {

	/**
	 * Darkens a hex color string about a given percentage.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color      Hex color string.
	 * @param int    $percentage Percentage to darken about.
	 * @return string Darkened hex color string.
	 */
	public function darken_color( $color, $percentage ) {
		if ( empty( $color ) ) {
			return $color;
		}

		$rgb = $this->hex_to_rgb( $color );

		$darkened = array();
		foreach ( $rgb as $channel ) {
			$darkened_channel = (int) round( $channel * ( 1.0 - $percentage / 100.0 ) );
			if ( $darkened_channel < 0 ) {
				$darkened_channel = 0;
			}
			$darkened[] = $darkened_channel;
		}

		return $this->rgb_to_hex( $darkened );
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
	public function lighten_color( $color, $percentage ) {
		if ( empty( $color ) ) {
			return $color;
		}

		$rgb = $this->hex_to_rgb( $color );

		$lightened = array();
		foreach ( $rgb as $channel ) {
			$lightened_channel = (int) round( $channel * ( 1.0 + $percentage / 100.0 ) );
			if ( $lightened_channel > 255 ) {
				$lightened_channel = 255;
			}
			$lightened[] = $lightened_channel;
		}

		return $this->rgb_to_hex( $lightened );
	}

	/**
	 * Converts a hex color string into an RGB array.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color Hex color string.
	 * @return array RGB color array.
	 */
	public function hex_to_rgb( $color ) {
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
	public function rgb_to_hex( $color ) {
		$hex = array_map( 'zeroise', array_map( 'dechex', $color ), array( 2, 2, 2 ) );

		return '#' . $hex[0] . $hex[1] . $hex[2];
	}
}
