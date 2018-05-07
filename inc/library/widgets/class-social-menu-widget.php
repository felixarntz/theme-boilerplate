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
		add_filter( 'walker_nav_menu_start_el', array( $this, 'filter_menu_social_icons' ), 10, 4 );

		wp_nav_menu( array(
			'menu'        => wp_get_nav_menu_object( (int) $instance['nav_menu'] ),
			'depth'       => 1,
			'link_before' => '<span class="screen-reader-text">',
			'link_after'  => '</span>' . $this->manager->get_dependency( 'icons' )->get_svg( 'chain' ),
			'container'   => false,
		) );

		remove_filter( 'walker_nav_menu_start_el', array( $this, 'filter_menu_social_icons' ), 10 );
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

	/**
	 * Adjusts the menu to display the accurate SVG icons.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $item_output The menu item output.
	 * @param WP_Post $item        Menu item object.
	 * @param int     $depth       Depth of the menu.
	 * @param array   $args        wp_nav_menu() arguments.
	 * @return string $item_output The menu item output with social icon.
	 */
	public function filter_menu_social_icons( $item_output, $item, $depth, $args ) {
		$social_icons = $this->manager->get_dependency( 'icons' )->get_social_links_icons();

		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				return str_replace( $args->link_after, '</span>' . $this->manager->get_dependency( 'icons' )->get_svg( $value ), $item_output );
			}
		}

		return $item_output;
	}
}
