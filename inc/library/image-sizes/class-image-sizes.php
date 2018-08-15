<?php
/**
 * Super_Awesome_Theme_Image_Sizes class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing the theme's image sizes.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Image_Sizes extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Selectable image sizes as `$slug => $label` pairs.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $selectable_sizes = array();

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Sidebar' );
	}

	/**
	 * Registers an image size.
	 *
	 * @since 1.0.0
	 *
	 * @param string      $slug       Image size identifier.
	 * @param int         $width      Image width in pixels.
	 * @param int         $height     Image height in pixels.
	 * @param bool        $crop       Optional. Whether to crop to the specified width. Default false.
	 * @param bool|string $selectable Optional. Whether to make the size available for selection when
	 *                                inserting an image into the editor. Passing a string will use that
	 *                                value as label for the image size (recommended). Default false.
	 */
	public function add_size( $slug, $width, $height, $crop = false, $selectable = false ) {
		add_image_size( $slug, $width, $height, $crop );

		if ( $selectable ) {
			$this->selectable_sizes[ $slug ] = is_string( $selectable ) ? $selectable : $slug;
		}
	}

	/**
	 * Checks if an image size exists.
	 *
	 * Only considers custom image sizes, not the WordPress built-in ones.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Image size identifier.
	 * @return bool True if the image size exists, false if not.
	 */
	public function has_size( $slug ) {
		return has_image_size( $slug );
	}

	/**
	 * Removes an image size.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Image size identifier.
	 */
	public function remove_size( $slug ) {
		if ( isset( $this->selectable_sizes[ $slug ] ) ) {
			unset( $this->selectable_sizes[ $slug ] );
		}

		remove_image_size( $slug );
	}

	/**
	 * Magic call method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'register_sizes':
			case 'filter_selectable_sizes':
			case 'calculate_content_image_sizes':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
		}
	}

	/**
	 * Registers the image sizes used by the theme.
	 *
	 * @since 1.0.0
	 */
	protected function register_sizes() {
		$rem = 16;

		// The maximum site width is 72rem.
		$this->add_size( 'site-width', 72 * $rem, 9999, false, __( 'Site Width', 'super-awesome-theme' ) );

		// The maximum content width is 40rem.
		$this->add_size( 'content-width', 40 * $rem, 9999, false, __( 'Content Width', 'super-awesome-theme' ) );

		// Featured images span the maximum content width and should be in 16:9 aspect ratio.
		set_post_thumbnail_size( 40 * $rem, ( ( 40 * $rem ) / 16 ) * 9, true );
	}

	/**
	 * Filters the selectable image sizes, including custom selectable sizes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sizes Image sizes as `$slug => $label` pairs.
	 * @return array Filtered image sizes.
	 */
	protected function filter_selectable_sizes( array $sizes ) {
		return array_merge( $sizes, $this->selectable_sizes );
	}

	/**
	 * Filters the sizes attribute generated for an image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $sizes The sizes attribute to filter.
	 * @param array  $size  Array with width and height.
	 * @return string Filtered sizes attribute.
	 */
	protected function calculate_content_image_sizes( $sizes, $size ) {
		$settings = $this->get_dependency( 'settings' );
		$sidebar  = $this->get_dependency( 'sidebar' );

		$rem         = 16;
		$image_width = $size[0];

		if ( $sidebar->should_display_sidebar() ) {
			$max_width      = 72 * $rem;
			$double_padding = 2 * $rem;
			$breakpoint     = 48 * $rem;

			$sidebar_size = $settings->get( 'sidebar_size' );
			switch ( $sidebar_size ) {
				case 'large':
					$max_content_width    = 36 * $rem;
					$max_content_width_vw = 50;
					break;
				case 'small':
					$max_content_width    = 54 * $rem;
					$max_content_width_vw = 75;
					break;
				default:
					$max_content_width    = 48 * $rem;
					$max_content_width_vw = 66.666666;
			}

			$max_content_width_minus_padding  = $max_content_width - $double_padding;

			if ( $image_width > $breakpoint && $image_width > $max_content_width ) {
				$sizes = "(max-width: {$breakpoint}px) calc(100vw - {$double_padding}px), (max-width: {$max_width}px) calc({$max_content_vw}vw - {$double_padding}px), {$max_content_width_minus_padding}px";
			} else {
				$sizes = "(max-width: {$breakpoint}px) calc(100vw - {$double_padding}px), {$image_width}px";
			}
		} else {
			// WordPress doesn't expose the context, so we assume 'alignwide' as best bet.
			$context = 'alignwide';

			switch ( $context ) {
				case 'alignwide':
					$max_width      = 72 * $rem;
					$double_padding = 2 * $rem;
					break;
				case 'alignfull':
					$max_width      = 0;
					$double_padding = 0;
					break;
				default:
					$max_width      = 40 * $rem;
					$double_padding = 2 * $rem;
			}

			$max_width_minus_padding  = $max_width - $double_padding;
			$image_width_plus_padding = $image_width + $double_padding;

			if ( $double_padding > 0 ) {
				if ( $max_width > 0 && $image_width > $max_width ) {
					$sizes = "(max-width: {$max_width}px) calc(100vw - {$double_padding}px), {$max_width_minus_padding}px";
				} else {
					$sizes = "(max-width: {$image_width_plus_padding}px) calc(100vw - {$double_padding}px), {$image_width}px";
				}
			} else {
				if ( $max_width > 0 && $image_width > $max_width ) {
					$sizes = "(max-width: {$max_width}px) 100vw, {$max_width}px";
				} else {
					$sizes = "(max-width: {$image_width}px) 100vw, {$image_width}px";
				}
			}
		}

		return $sizes;
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_sizes' ), 10, 0 );
		add_filter( 'image_size_names_choose', array( $this, 'filter_selectable_sizes' ), 10, 1 );
		add_filter( 'wp_calculate_image_sizes', array( $this, 'calculate_content_image_sizes' ), 10, 2 );
	}
}
