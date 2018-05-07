<?php
/**
 * Custom widgets and related functionality
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Gets the identifiers for all inline sidebars.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_sidebars Inline sidebars list.
 *
 * @return array Array of sidebar IDs.
 */
function super_awesome_theme_get_inline_sidebars() {
	global $super_awesome_theme_inline_sidebars;

	if ( ! is_array( $super_awesome_theme_inline_sidebars ) ) {
		return array();
	}

	return $super_awesome_theme_inline_sidebars;
}

/**
 * Makes the given sidebars inline sidebars.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_sidebars Inline sidebars list.
 *
 * @param string|array $sidebars One or more sidebar identifiers.
 */
function super_awesome_theme_add_inline_sidebars( $sidebars ) {
	global $super_awesome_theme_inline_sidebars;

	$sidebars = array_values( (array) $sidebars );

	if ( ! is_array( $super_awesome_theme_inline_sidebars ) ) {
		$super_awesome_theme_inline_sidebars = array();
	}

	$super_awesome_theme_inline_sidebars = array_unique(
		array_merge( $super_awesome_theme_inline_sidebars, $sidebars )
	);
	sort( $super_awesome_theme_inline_sidebars );
}

/**
 * Makes the given inline sidebars default sidebars again.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_sidebars Inline sidebars list.
 *
 * @param string|array $sidebars One or more sidebar identifiers.
 */
function super_awesome_theme_remove_inline_sidebars( $sidebars ) {
	global $super_awesome_theme_inline_sidebars;

	$sidebars = array_values( (array) $sidebars );

	if ( ! is_array( $super_awesome_theme_inline_sidebars ) ) {
		$super_awesome_theme_inline_sidebars = array();
	}

	$super_awesome_theme_inline_sidebars = array_diff( $super_awesome_theme_inline_sidebars, $sidebars );
	sort( $super_awesome_theme_inline_sidebars );
}

/**
 * Gets the identifiers for all widgets that are allowed in inline sidebars.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_widgets Inline widgets list.
 *
 * @return array Array of widget IDs.
 */
function super_awesome_theme_get_inline_widgets() {
	global $super_awesome_theme_inline_widgets;

	if ( ! is_array( $super_awesome_theme_inline_widgets ) ) {
		return array();
	}

	return $super_awesome_theme_inline_widgets;
}

/**
 * Adds the given widget identifiers to the list of widgets allowed in inline sidebars.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_widgets Inline widgets list.
 *
 * @param string|array $widgets One or more widget identifiers.
 */
function super_awesome_theme_add_inline_widgets( $widgets ) {
	global $super_awesome_theme_inline_widgets;

	$widgets = array_values( (array) $widgets );

	if ( ! is_array( $super_awesome_theme_inline_widgets ) ) {
		$super_awesome_theme_inline_widgets = array();
	}

	$super_awesome_theme_inline_widgets = array_unique(
		array_merge( $super_awesome_theme_inline_widgets, $widgets )
	);
	sort( $super_awesome_theme_inline_widgets );
}

/**
 * Removes the given widget identifiers from the list of widgets allowed in inline sidebars.
 *
 * @since 1.0.0
 *
 * @global array $super_awesome_theme_inline_widgets Inline widgets list.
 *
 * @param string|array $widgets One or more widget identifiers.
 */
function super_awesome_theme_remove_inline_widgets( $widgets ) {
	global $super_awesome_theme_inline_widgets;

	$widgets = array_values( (array) $widgets );

	if ( ! is_array( $super_awesome_theme_inline_widgets ) ) {
		$super_awesome_theme_inline_widgets = array();
	}

	$super_awesome_theme_inline_widgets = array_diff( $super_awesome_theme_inline_widgets, $widgets );
	sort( $super_awesome_theme_inline_widgets );
}

/**
 * Ensures that inline sidebars only contain widgets that are allowed within them.
 *
 * This function essentially filters out all non-inline widgets within these sidebars.
 *
 * @since 1.0.0
 *
 * @param array $sidebars_widgets An associative array of sidebars and their widgets.
 * @return array Filtered array of sidebars and their widgets.
 */
function super_awesome_theme_ensure_inline_widgets_whitelist( $sidebars_widgets ) {
	$inline_sidebars = super_awesome_theme_get_inline_sidebars();
	$inline_widgets  = super_awesome_theme_get_inline_widgets();

	foreach ( $inline_sidebars as $sidebar_id ) {
		if ( empty( $sidebars_widgets[ $sidebar_id ] ) ) {
			continue;
		}

		if ( empty( $inline_widgets ) ) {
			$sidebars_widgets[ $sidebar_id ] = array();
			continue;
		}

		foreach ( $sidebars_widgets[ $sidebar_id ] as $index => $widget_instance_id ) {
			if ( preg_match( '/-(\d+)$/', $widget_instance_id, $matches ) ) {
				$widget_id = substr( $widget_instance_id, 0, - strlen( $matches[0] ) );
				if ( ! in_array( $widget_id, $inline_widgets, true ) ) {
					unset( $sidebars_widgets[ $sidebar_id ][ $index ] );
				}
			} elseif ( ! in_array( $widget_instance_id, $inline_widgets, true ) ) {
				unset( $sidebars_widgets[ $sidebar_id ][ $index ] );
			}
		}

		$sidebars_widgets[ $sidebar_id ] = array_values( $sidebars_widgets[ $sidebar_id ] );
	}

	return $sidebars_widgets;
}
add_filter( 'sidebars_widgets', 'super_awesome_theme_ensure_inline_widgets_whitelist' );
