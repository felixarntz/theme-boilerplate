<?php
/**
 * Asset management functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

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
	return super_awesome_theme()->get_component( 'icons' )->get_svg( $icon, $args );
}

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
	return super_awesome_theme()->get_component( 'social_navigation' )->get_social_links_icons();
}
