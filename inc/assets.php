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
	if ( '</span>' . super_awesome_theme_get_svg( 'chain' ) === $args->link_after ) {
		$social_icons = super_awesome_theme_get_social_links_icons();

		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				return str_replace( $args->link_after, '</span>' . super_awesome_theme_get_svg( $value ), $item_output );
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
	return super_awesome_theme()->get_component( 'icons' )->get_social_links_icons();
}
