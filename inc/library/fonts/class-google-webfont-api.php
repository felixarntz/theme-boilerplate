<?php
/**
 * Super_Awesome_Theme_Google_Webfont_API class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing the Google web font API.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Google_Webfont_API extends Super_Awesome_Theme_Webfont_API {

	/**
	 * Gets the slug of the web font API.
	 *
	 * Font families part of this API will be prefixed with that slug and a colon.
	 *
	 * @since 1.0.0
	 *
	 * @return string API slug.
	 */
	public function get_slug() {
		return 'google';
	}

	/**
	 * Fetches the available font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of font family data.
	 */
	protected function fetch_families() {
		$filename = get_theme_file_path( 'assets/resources/google-webfonts.json' );
		if ( ! file_exists( $filename ) ) {
			return array();
		}

		$json = json_decode( file_get_contents( $filename ), true );
		if ( ! is_array( $json ) || empty( $json['items'] ) ) {
			return array();
		}

		$families = array();
		foreach ( $json['items'] as $google_family ) {
			if ( empty( $google_family['family'] ) || empty( $google_family['files'] ) ) {
				continue;
			}

			$group    = ! empty( $google_family['category'] ) ? $google_family['category'] : Super_Awesome_Theme_Webfont_Family::GROUP_SANS_SERIF;
			$fallback = in_array( $group, array( 'sans-serif', 'serif', 'monospace' ), true ) ? $group : 'sans-serif';

			$weights = array();
			$files   = array();
			foreach ( $google_family['files'] as $variant => $file ) {
				if ( 'regular' === $variant ) {
					$variant = '400';
				} elseif ( 'italic' === $variant ) {
					$variant = '400italic';
				}

				$files[ $variant ] = $file;

				if ( ! is_numeric( $variant ) ) {
					continue;
				}

				$weights[] = $variant;
			}

			$families[] = array(
				Super_Awesome_Theme_Webfont_Family::PROP_ID      => $google_family['family'],
				Super_Awesome_Theme_Webfont_Family::PROP_LABEL   => $google_family['family'],
				Super_Awesome_Theme_Webfont_Family::PROP_STACK   => array( $google_family['family'], $fallback ),
				Super_Awesome_Theme_Webfont_Family::PROP_WEIGHTS => $weights,
				Super_Awesome_Theme_Webfont_Family::PROP_GROUP   => $group,
				Super_Awesome_Theme_Webfont_Family::PROP_FILES   => $files,
			);
		}

		return $families;
	}
}
