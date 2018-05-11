<?php
/**
 * Super_Awesome_Theme_Icons class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Theme icons handling.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Icons extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Whether SVG icons are used on the current page.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private $needs_svg = false;

	/**
	 * Gets SVG markup for a specific icon.
	 *
	 * @since 1.0.0
	 *
	 * @param string $icon SVG icon identifier.
	 * @param array  $args {
	 *     Optional. Additional parameters for displaying the SVG.
	 *
	 *     @type string $title SVG title. Default empty.
	 *     @type string $desc  SVG description. Default empty.
	 *     @type bool   $fallback Whether to create fallback markup. Default false.
	 * }
	 * @return string SVG markup for the icon.
	 */
	public function get_svg( $icon, array $args = array() ) {
		$this->needs_svg = true;

		$args = wp_parse_args( $args, array(
			'title'    => '',
			'desc'     => '',
			'fallback' => false,
		) );

		$unique_id       = '';
		$aria_hidden     = ' aria-hidden="true"';
		$aria_labelledby = '';

		if ( ! empty( $args['title'] ) ) {
			$unique_id       = uniqid();
			$aria_hidden     = '';
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

			if ( ! empty( $args['desc'] ) ) {
				$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
			}
		}

		$svg = '<svg class="icon icon-' . esc_attr( $icon ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

		if ( ! empty( $args['title'] ) ) {
			$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

			if ( ! empty( $args['desc'] ) ) {
				$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}

		// The whitespace is a work around to a keyboard navigation bug in Safari 10. See https://core.trac.wordpress.org/ticket/38387.
		$svg .= ' <use href="#icon-' . esc_attr( $icon ) . '" xlink:href="#icon-' . esc_attr( $icon ) . '"></use> ';

		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $icon ) . '"></span>';
		}

		$svg .= '</svg>';

		return $svg;
	}

	/**
	 * Prints the SVG content.
	 *
	 * @since 1.0.0
	 */
	public function print_svg() {
		$svg_icons = get_theme_file_path( '/assets/dist/images/icons.svg' );

		if ( ! file_exists( $svg_icons ) ) {
			return;
		}

		require_once( $svg_icons );
	}

	/**
	 * Prints the SVG content if necessary.
	 *
	 * This should be called before the closing body tag of the page, so that icons loaded
	 * can reference the file.
	 *
	 * The content is only printed if at least one icon is used in the current page.
	 *
	 * @since 1.0.0
	 */
	public function maybe_print_svg() {
		if ( ! $this->needs_svg ) {
			return;
		}

		$this->print_svg();
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'wp_footer', array( $this, 'maybe_print_svg' ), 9999, 0 );
		add_action( 'admin_footer', array( $this, 'maybe_print_svg' ), 9999, 0 );
		add_action( 'login_footer', array( $this, 'maybe_print_svg' ), 9999, 0 );
	}
}
