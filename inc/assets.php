<?php
/**
 * Asset management functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function super_awesome_theme_enqueue_assets() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_style( 'super-awesome-theme-style', get_stylesheet_uri() );
	wp_style_add_data( 'super-awesome-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'super-awesome-theme-script', get_theme_file_uri( '/assets/dist/js/theme' . $min . '.js' ), array(), SUPER_AWESOME_THEME_VERSION, true );

	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/dist/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'super_awesome_theme_enqueue_assets' );

/**
 * Includes the icon sprite SVG in the footer.
 *
 * @since 1.0.0
 */
function super_awesome_theme_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_parent_theme_file_path( '/assets/dist/images/icons.svg' );

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'super_awesome_theme_include_svg_icons', 9999 );

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
function super_awesome_theme_get_svg( $icon, $args = array() ) {
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
 * Adjusts the social links menu to display SVG icons.
 *
 * @since 1.0.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string $item_output The menu item output with social icon.
 */
function super_awesome_theme_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	$social_icons = super_awesome_theme_get_social_links_icons();

	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . super_awesome_theme_get_svg( $value ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'super_awesome_theme_nav_menu_social_icons', 10, 4 );

/**
 * Adds a dropdown icon to a menu item in the primary navigation if it has children.
 *
 * @since 1.0.0
 *
 * @param string  $title The menu item's title.
 * @param WP_Post $item  The current menu item.
 * @param array   $args  An array of wp_nav_menu() arguments.
 * @return string $title The menu item's title with dropdown icon.
 */
function super_awesome_theme_dropdown_icon_to_menu_link( $title, $item, $args ) {
	if ( 'primary' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title .= super_awesome_theme_get_svg( 'angle-down' );
				break;
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'super_awesome_theme_dropdown_icon_to_menu_link', 10, 3 );

/**
 * Gets an array of supported social links (URL and icon name).
 *
 * @since 1.0.0
 *
 * @return array Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
 */
function super_awesome_theme_get_social_links_icons() {
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'docker.com'      => 'dockerhub',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'mailto:'         => 'envelope',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'github.com'      => 'github',
		'plus.google.com' => 'google-plus',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'medium.com'      => 'medium',
		'pscp.tv'         => 'periscope',
		'pinterest.com'   => 'pinterest',
		'getpocket.com'   => 'pocket',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filters the theme's supported social links icons.
	 *
	 * @since 1.0.0
	 *
	 * @param array $social_links_icons Array where URL fragment identifiers are the keys, and SVG icon identifiers are the values.
	 */
	return apply_filters( 'super_awesome_theme_social_links_icons', $social_links_icons );
}
