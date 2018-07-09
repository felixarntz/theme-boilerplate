<?php
/**
 * Super_Awesome_Theme_Distraction_Free_Mode class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing distraction-free mode.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Distraction_Free_Mode extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Internal flag to store whether the current page is in distraction-free mode.
	 *
	 * @since 1.0.0
	 * @var bool|null
	 */
	private $is_distraction_free = null;

	/**
	 * Checks whether the current page should be displayed in distraction-free mode.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the current page should be displayed in distraction-free mode, false otherwise.
	 */
	public function is_distraction_free() {
		if ( null !== $this->is_distraction_free ) {
			return $this->is_distraction_free;
		}

		$result = false;

		if ( is_page_template( 'templates/landing-page.php' ) ) {
			$result = true;
		} elseif ( is_page_template( 'templates/login.php' ) ) {
			$result = true;
		} elseif ( 'wp-signup.php' === $GLOBALS['pagenow'] ) {
			$result = true;
		} elseif ( 'wp-activate.php' === $GLOBALS['pagenow'] ) {
			$result = true;
		}

		/**
		 * Filters whether the current page should be displayed in distraction-free mode.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $result Whether to display the page in distraction-free mode. Default depends on the page template.
		 */
		$this->is_distraction_free = apply_filters( 'super_awesome_theme_is_distraction_free', $result );

		return $this->is_distraction_free;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the widgets registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		if ( 'add_distraction_free_body_class' === $method ) {
			if ( empty( $args ) ) {
				return;
			}

			$classes = $args[0];

			if ( $this->is_distraction_free() ) {
				$classes[] = 'is-distraction-free';
			}

			return $classes;
		}

		throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_filter( 'body_class', array( $this, 'add_distraction_free_body_class' ), 10, 1 );
	}
}
