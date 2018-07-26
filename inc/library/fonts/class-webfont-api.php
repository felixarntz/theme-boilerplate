<?php
/**
 * Super_Awesome_Theme_Webfont_API class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a web font API.
 *
 * @since 1.0.0
 */
abstract class Super_Awesome_Theme_Webfont_API {

	/**
	 * Families part of this API.
	 *
	 * List of font family instances.
	 *
	 * @since 1.0.0
	 * @var array|null
	 */
	protected $families = null;

	/**
	 * Gets the slug of the web font API.
	 *
	 * Font families part of this API will be prefixed with that slug and a colon.
	 *
	 * @since 1.0.0
	 *
	 * @return string API slug.
	 */
	abstract public function get_slug();

	/**
	 * Gets the title of the web font API.
	 *
	 * @since 1.0.0
	 *
	 * @return string API title.
	 */
	abstract public function get_title();

	/**
	 * Gets the available font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of font family instances.
	 */
	public function get_families() {
		if ( null === $this->families ) {
			$slug = $this->get_slug();

			$this->families = get_transient( 'super_awesome_theme_' . SUPER_AWESOME_THEME_VERSION . '_' . $slug . '_fonts' );

			if ( false === $this->families ) {
				$this->families = $this->fetch_families();

				if ( ! is_array( $this->families ) ) {
					$this->families = array();
				}

				set_transient( 'super_awesome_theme_' . SUPER_AWESOME_THEME_VERSION . '_' . $slug . '_fonts', $this->families );
			}

			$this->families = array_filter( array_map( array( $this, 'data_to_object' ), $this->families ) );
		}

		return $this->families;
	}

	/**
	 * Loads the fonts by printing out the necessary `<link>` tag or similar.
	 *
	 * In case of a Customizer preview, the markup needs to be printed even if no fonts are available.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id_attr ID attribute to use for the outer tag to print. This has to be used in order
	 *                        to support a Customizer partial.
	 * @param array  $fonts   List of fonts to load. Each item is an associative arrays containing a `family`
	 *                        key with the font family instance, and a `weight` key with the desired font
	 *                        weight.
	 */
	abstract public function load_fonts( $id_attr, array $fonts );

	/**
	 * Fetches the available font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of font family data.
	 */
	abstract protected function fetch_families();

	/**
	 * Parses data for a web font family into a web font family object.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Web font family data.
	 * @return Super_Awesome_Theme_Webfont_Family Web font family object.
	 */
	protected function data_to_object( array $data ) {
		if ( ! isset( $data[ Super_Awesome_Theme_Webfont_Family::PROP_ID ] ) ) {
			return null;
		}

		$id = $this->get_slug() . ':' . $data[ Super_Awesome_Theme_Webfont_Family::PROP_ID ];
		unset( $data[ Super_Awesome_Theme_Webfont_Family::PROP_ID ] );

		$data[ Super_Awesome_Theme_Webfont_Family::PROP_API ] = $this->get_slug();

		return new Super_Awesome_Theme_Webfont_Family( $id, $data );
	}
}
