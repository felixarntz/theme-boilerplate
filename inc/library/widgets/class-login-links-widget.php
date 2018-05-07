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
class Super_Awesome_Theme_Login_Links_Widget extends Super_Awesome_Theme_Widget {

	/**
	 * Gets the title of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Title for the widget.
	 */
	protected function get_title() {
		return __( 'Login Links', 'super-awesome-theme' );
	}

	/**
	 * Gets the description of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @return string Description for the widget.
	 */
	protected function get_description() {
		return __( 'Displays a login link and optionally a registration link with icons.', 'super-awesome-theme' );
	}

	/**
	 * Adds the available widget form fields.
	 *
	 * @since 1.0.0
	 */
	protected function add_fields() {
		$this->add_title_field();

		$this->add_field( 'show_register_link', array(
			self::FIELD_ARG_TYPE  => self::FIELD_TYPE_CHECKBOX,
			self::FIELD_ARG_TITLE => __( 'Show registration link?', 'super-awesome-theme' ),
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
		$login_url      = '';
		$login_label    = '';
		$register_url   = '';
		$register_label = '';

		if ( ! is_user_logged_in() ) {
			$login_url   = wp_login_url();
			$login_label = _x( 'Log in', 'action', 'super-awesome-theme' );

			if ( get_option( 'users_can_register' ) && ! empty( $instance['show_register_link'] ) ) {
				$register_url   = wp_registration_url();
				$register_label = _x( 'Register', 'action', 'super-awesome-theme' );
			}
		} else {
			$login_url   = wp_logout_url();
			$login_label = _x( 'Log out', 'action', 'super-awesome-theme' );
		}

		?>
		<ul>
			<?php if ( ! empty( $login_url ) && ! empty( $login_label ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $login_url ); ?>">
						<?php echo $this->manager->get_dependency( 'icons' )->get_svg( 'login' ); /* WPCS: XSS OK. */ ?>
						<?php echo esc_html( $login_label ); ?>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( ! empty( $register_url ) && ! empty( $register_label ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $register_url ); ?>">
						<?php echo $this->manager->get_dependency( 'icons' )->get_svg( 'register' ); /* WPCS: XSS OK. */ ?>
						<?php echo esc_html( $register_label ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<?php
	}
}
