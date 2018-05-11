<?php
/**
 * Super_Awesome_Theme_Colors class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing theme color settings.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Colors extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Utility methods instance.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Color_Util
	 */
	private $util;

	/**
	 * Registered theme color groups as $identifier => $title pairs.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $groups = array();

	/**
	 * Registered theme colors.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $colors = array();

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->util = new Super_Awesome_Theme_Color_Util();

		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
	}

	/**
	 * Gets the value for a theme color setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this color setting.
	 * @return string Value for the color setting, or empty string if color is not registered.
	 */
	public function get( $id ) {
		if ( ! isset( $this->colors[ $id ] ) ) {
			return '';
		}

		return $this->colors[ $id ]->get_value();
	}

	/**
	 * Registers a theme color.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Color $color Color to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_color( Super_Awesome_Theme_Color $color ) {
		$id = $color->get_prop( Super_Awesome_Theme_Color::PROP_ID );

		if ( isset( $this->colors[ $id ] ) ) {
			return false;
		}

		$this->colors[ $id ] = $color;

		$settings = $this->get_dependency( 'settings' );
		$settings->register_setting( $color->get_setting() );

		return true;
	}

	/**
	 * Registers a theme color group.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id    Unique string identifier for this color group.
	 * @param string $title Title for the color group.
	 * @return bool True on success, false on failure.
	 */
	public function register_group( $id, $title ) {
		if ( isset( $this->groups[ $id ] ) ) {
			return false;
		}

		$this->groups[ $id ] = $title;

		return true;
	}

	/**
	 * Registers a callback that should print CSS rules for color style.
	 *
	 * The callback receives the `Super_Awesome_Theme_Colors` instance
	 * as sole parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Color style callback.
	 */
	public function register_color_style_callback( $callback ) {
		add_action( 'super_awesome_theme_color_style', $callback, 10, 1 );
	}

	/**
	 * Returns the color utility methods instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Color_Util Utility methods instance.
	 */
	public function util() {
		return $this->util;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the Customizer registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'print_color_style':
			case 'print_color_style_css':
			case 'register_customize_controls':
				call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Prints the color style tag.
	 *
	 * @since 1.0.0
	 */
	protected function print_color_style() {
		?>
		<style id="super-awesome-theme-color-style" type="text/css">

			<?php $this->print_color_style_css(); ?>

		</style>
		<?php
	}

	/**
	 * Prints the color style CSS definitions.
	 *
	 * @since 1.0.0
	 */
	protected function print_color_style_css() {

		/**
		 * Fires when the custom color styles are printed inside a style tag.
		 *
		 * @since 1.0.0
		 *
		 * @param Super_Awesome_Theme_Colors $colors The theme colors instance.
		 */
		do_action( 'super_awesome_theme_color_style', $this );
	}

	/**
	 * Registers Customizer controls, sections and a panel for all registered content types and their behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_controls( $customizer ) {
		if ( ! empty( $this->groups ) ) {
			$customizer->add_panel( 'colors', array(
				Super_Awesome_Theme_Customize_Panel::PROP_TITLE    => __( 'Colors', 'super-awesome-theme' ),
				Super_Awesome_Theme_Customize_Panel::PROP_PRIORITY => 40,
			) );

			// Adjust the original core section to become a sub-section of the colors panel.
			$orig_colors_section = $customizer->get_section( 'colors' );
			$orig_colors_section->panel = 'colors';
			$orig_colors_section->title = __( 'Other Colors', 'super-awesome-theme' );

			foreach ( $this->groups as $id => $title ) {
				$customizer->add_section( $id, array(
					Super_Awesome_Theme_Customize_Section::PROP_PANEL => 'colors',
					Super_Awesome_Theme_Customize_Section::PROP_TITLE => $title,
				) );
			}
		}

		$partial_colors = array();

		foreach ( $this->colors as $id => $color ) {
			if ( $color->get_prop( Super_Awesome_Theme_Color::PROP_LIVE_PREVIEW ) ) {
				$partial_colors[] = $id;
			} else {
				$customizer->set_setting_transport( $id, Super_Awesome_Theme_Customize_Setting::TRANSPORT_REFRESH );
			}

			$customizer->add_control( $id, array(
				Super_Awesome_Theme_Customize_Control::PROP_SECTION         => $color->get_prop( Super_Awesome_Theme_Color::PROP_GROUP ),
				Super_Awesome_Theme_Customize_Control::PROP_TITLE           => $color->get_prop( Super_Awesome_Theme_Color::PROP_TITLE ),
				Super_Awesome_Theme_Customize_Control::PROP_TYPE            => Super_Awesome_Theme_Customize_Control::TYPE_COLOR,
				Super_Awesome_Theme_Customize_Control::PROP_ACTIVE_CALLBACK => array( $color, 'is_active' ),
			) );
		}

		if ( ! empty( $partial_colors ) ) {
			$customizer->add_partial( 'super_awesome_theme_color_style', array(
				Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => $partial_colors,
				Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '#super-awesome-theme-color-style',
				Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'print_color_style_css' ),
				Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => false,
				Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
			) );
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'wp_head', array( $this, 'print_color_style' ), 10, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_controls' ) );
	}
}
