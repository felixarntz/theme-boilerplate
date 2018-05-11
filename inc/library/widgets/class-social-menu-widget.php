<?php
/**
 * Super_Awesome_Theme_Social_Menu_Widget class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class used to display a social menu in a widget area.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Social_Menu_Widget extends Super_Awesome_Theme_Widget {

	/**
	 * Gets the title of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Title for the widget.
	 */
	protected function get_title() {
		return __( 'Social Menu', 'super-awesome-theme' );
	}

	/**
	 * Gets the description of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Description for the widget.
	 */
	protected function get_description() {
		return __( 'Displays a social menu with icons.', 'super-awesome-theme' );
	}

	/**
	 * Adds the available widget form fields.
	 *
	 * @since 1.0.0
	 */
	protected function add_fields() {
		$this->add_title_field();

		$menus        = wp_get_nav_menus();
		$menu_choices = array( '0' => __( '&mdash; Select &mdash;', 'super-awesome-theme' ) );
		foreach ( $menus as $menu ) {
			$menu_choices[ (string) $menu->term_id ] = $menu->name;
		}

		$this->add_field( 'nav_menu', array(
			self::FIELD_ARG_TYPE    => self::FIELD_TYPE_SELECT,
			self::FIELD_ARG_TITLE   => __( 'Select Menu', 'super-awesome-theme' ),
			self::FIELD_ARG_CHOICES => $menu_choices,
		) );
	}

	/**
	 * Renders the widget for a given instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current widget instance.
	 */
	protected function render( array $instance ) {
		$menus = $this->manager->get_dependency( 'menus' );
		$menus->get_registered_menu( 'social' )->render( (int) $instance['nav_menu'] );
	}

	/**
	 * Checks whether the widget can be rendered for a given instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current widget instance.
	 * @return bool True if the settings qualify the widget to be rendered, false otherwise.
	 */
	protected function can_render( array $instance ) {
		if ( empty( $instance['nav_menu'] ) ) {
			return false;
		}

		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );
		if ( ! $nav_menu ) {
			return false;
		}

		return true;
	}
}
