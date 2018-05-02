<?php
/**
 * Super_Awesome_Theme_Attachment_Metadata class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing attachment metadata.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Attachment_Metadata {

	/**
	 * Theme settings instance.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Settings
	 */
	private $settings;

	/**
	 * Available attachment metadata fields and their labels.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $fields = array();

	/**
	 * Internal metadata cache.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $cache = array();

	/**
	 * Constructor.
	 *
	 * Initializes the available metadata fields.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Settings $settings Theme settings instance.
	 */
	public function __construct( Super_Awesome_Theme_Settings $settings ) {
		$this->settings = $settings;

		$this->fields = array(
			'dimensions'       => _x( 'Dimensions', 'attachment metadata', 'super-awesome-theme' ),
			'focal_length'     => _x( 'Focal Length', 'attachment metadata', 'super-awesome-theme' ),
			'shutter_speed'    => _x( 'Shutter Speed', 'attachment metadata', 'super-awesome-theme' ),
			'aperture'         => _x( 'Aperture', 'attachment metadata', 'super-awesome-theme' ),
			'iso'              => _x( 'ISO', 'attachment metadata', 'super-awesome-theme' ),
			'length_formatted' => _x( 'Run Time', 'attachment metadata', 'super-awesome-theme' ),
			'artist'           => _x( 'Artist', 'attachment metadata', 'super-awesome-theme' ),
			'album'            => _x( 'Album', 'attachment metadata', 'super-awesome-theme' ),
			'fileformat'       => _x( 'File Format', 'attachment metadata', 'super-awesome-theme' ),
			'filename'         => _x( 'File Name', 'attachment metadata', 'super-awesome-theme' ),
			'filesize'         => _x( 'File Size', 'attachment metadata', 'super-awesome-theme' ),
		);
	}

	/**
	 * Gets formatted attachment metadata for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post|int|null $post Optional. Post to check for. Default is the current post.
	 * @return array|bool Attachment metadata, or false on failure.
	 */
	public function get_for_post( $post = null ) {
		$post = get_post( $post );
		if ( ! $post ) {
			return false;
		}

		if ( 'attachment' !== $post->post_type ) {
			return false;
		}

		if ( isset( $this->cache[ $post->ID ] ) ) {
			return $this->cache[ $post->ID ];
		}

		$meta = wp_get_attachment_metadata( $post->ID );
		if ( is_array( $meta ) ) {
			$meta['filename'] = basename( get_attached_file( $post->ID ) );

			if ( ! empty( $meta['filesize'] ) ) {
				$meta['filesize'] = size_format( strip_tags( $meta['filesize'] ), 2 );
			}

			if ( empty( $meta['fileformat'] ) && preg_match( '/^.*?\.(\w+)$/', get_attached_file( $post->ID ), $matches ) ) {
				$meta['fileformat'] = $matches[1];
			}

			if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
				$meta['dimensions'] = sprintf( '%1$s &#215; %2$s', number_format_i18n( $meta['width'] ), number_format_i18n( $meta['height'] ) );
			} else {
				$meta['dimensions'] = '';
			}

			if ( ! empty( $meta['image_meta'] ) ) {
				if ( ! empty( $meta['image_meta']['created_timestamp'] ) ) {
					$meta['image_meta']['created_timestamp'] = date_i18n( get_option( 'date_format' ), strip_tags( $meta['image_meta']['created_timestamp'] ) );
				}

				if ( ! empty( $meta['image_meta']['focal_length'] ) ) {
					$meta['image_meta']['focal_length'] = sprintf( '%smm', absint( $meta['image_meta']['focal_length'] ) );
				}

				if ( ! empty( $meta['image_meta']['shutter_speed'] ) ) {
					$meta['image_meta']['shutter_speed'] = floatval( strip_tags( $meta['image_meta']['shutter_speed'] ) );

					$speed = $meta['image_meta']['shutter_speed'];
					if ( ( 1 / $speed ) > 1 ) {
						$shutter = sprintf( '<sup>%s</sup>&#8260;', number_format_i18n( 1 ) );
						if ( number_format( ( 1 / $speed ), 1 ) === number_format( ( 1 / $speed ), 0 ) ) {
							$shutter .= sprintf( '<sub>%s</sub>', number_format_i18n( ( 1 / $speed ), 0, '.', '' ) );
						} else {
							$shutter .= sprintf( '<sub>%s</sub>', number_format_i18n( ( 1 / $speed ), 1, '.', '' ) );
						}
					}
				}

				if ( ! empty( $meta['image_meta']['aperture'] ) ) {
					$meta['image_meta']['aperture'] = sprintf( '<sup>f</sup>&#8260;<sub>%s</sub>', absint( $meta['image_meta']['aperture'] ) );
				}

				if ( ! empty( $meta['image_meta']['iso'] ) ) {
					$meta['image_meta']['iso'] = number_format_i18n( (int) $meta['image_meta']['iso'] );
				}
			}
		}

		$this->cache[ $post->ID ] = $meta;

		return $meta;
	}

	/**
	 * Checks whether the attachment metadata value of a specific field should be displayed for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param string           $field Attachment metadata field to display.
	 * @param WP_Post|int|null $post  Optional. Post to check for. Default is the current post.
	 * @return bool True if the attachment metadata value should be displayed for the post, false otherwise.
	 */
	public function display_field_for_post( $field, $post = null ) {
		if ( ! isset( $this->fields[ $field ] ) ) {
			return false;
		}

		$meta = $this->get_for_post( $post );
		if ( ! $meta ) {
			return false;
		}

		if ( empty( $meta[ $field ] ) || ! is_string( $meta[ $field ] ) ) {
			if ( empty( $meta['image_meta'][ $field ] ) || ! is_string( $meta['image_meta'][ $field ] ) ) {
				return false;
			}
		}

		return $this->settings->get( 'attachment_show_metadata_' . $field );
	}

	/**
	 * Gets the attachment metadata fields that can be rendered in an attachment template.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of `$field => $label` pairs.
	 */
	public function get_fields() {
		return $this->fields;
	}
}
