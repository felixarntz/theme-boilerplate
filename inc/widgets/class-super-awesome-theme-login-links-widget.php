<?php
/**
 * Super_Awesome_Theme_Login_Links_Widget class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class used to display login and register in a widget area.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Login_Links_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * Sets the widget definition arguments.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct( 'super_awesome_theme_login_links', __( 'Login Links', 'super-awesome-theme' ), array(
			'classname'                   => 'widget_login_links',
			'description'                 => __( 'Displays a login link and optionally a registration link with icons.', 'super-awesome-theme' ),
			'customize_selective_refresh' => true,
		) );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {

	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for the current instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for the current instance.
	 * @return array|bool Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Outputs the widget settings form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Settings for the current instance.
	 */
	public function form( $instance ) {

	}
}
