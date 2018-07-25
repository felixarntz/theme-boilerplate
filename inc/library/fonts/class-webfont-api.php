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
	 * Gets the available font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of font family instances.
	 */
	public function get_families() {
		if ( null === $this->families ) {
			$this->families = get_transient( 'super_awesome_theme_' . SUPER_AWESOME_THEME_VERSION . '_webfonts_' . $this->get_slug() );

			if ( false === $this->families ) {
				$this->families = $this->fetch_families();

				if ( ! is_array( $this->families ) ) {
					$this->families = array();
				}

				set_transient( 'super_awesome_theme_' . SUPER_AWESOME_THEME_VERSION . '_webfonts_' . $this->get_slug(), $this->families );
			}

			$this->families = array_filter( array_map( array( $this, 'data_to_object' ), $this->families ) );
		}

		return $this->families;
	}

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

		return new Super_Awesome_Theme_Webfont_Family( $id, $data );
	}
}
