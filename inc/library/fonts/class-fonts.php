<?php
/**
 * Super_Awesome_Theme_Fonts class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class managing theme font settings.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Fonts extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Utility methods instance.
	 *
	 * @since 1.0.0
	 * @var Super_Awesome_Theme_Font_Util
	 */
	private $util;

	/**
	 * Registered theme font groups as $identifier => $title pairs.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $groups = array();

	/**
	 * Registered theme fonts.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $fonts = array();

	/**
	 * Constructor.
	 *
	 * Sets the required dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->util = new Super_Awesome_Theme_Font_Util();

		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Customizer' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Font_Families' );
	}

	/**
	 * Gets the value for a theme font setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this font setting.
	 * @return array Value for the font setting, or empty string if font is not registered.
	 */
	public function get( $id ) {
		if ( ! isset( $this->fonts[ $id ] ) ) {
			return array(
				'family' => '',
				'weight' => '400',
				'size'   => 1.0,
			);
		}

		return $this->fonts[ $id ]->get_value();
	}

	/**
	 * Registers a theme font.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Font $font Font to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_font( Super_Awesome_Theme_Font $font ) {
		$id = $font->get_prop( Super_Awesome_Theme_Font::PROP_ID );

		if ( isset( $this->fonts[ $id ] ) ) {
			return false;
		}

		$this->fonts[ $id ] = $font;

		$settings = $this->get_dependency( 'settings' );
		$settings->register_setting( $font->get_setting() );

		return true;
	}

	/**
	 * Registers a theme font group.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id    Unique string identifier for this font group.
	 * @param string $title Title for the font group.
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
	 * Registers a callback that should print CSS rules for font style.
	 *
	 * The callback receives the `Super_Awesome_Theme_Fonts` instance
	 * as sole parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Font style callback.
	 */
	public function register_font_style_callback( $callback ) {
		add_action( 'super_awesome_theme_font_style', $callback, 10, 1 );
	}

	/**
	 * Returns the font utility methods instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Super_Awesome_Theme_Font_Util Utility methods instance.
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
			case 'print_font_style':
			case 'add_block_editor_font_style':
			case 'print_font_style_css':
			case 'register_font_customize_control':
			case 'register_customize_partial':
			case 'register_customize_controls_js':
			case 'register_base_fonts_general':
			case 'print_base_font_style_general':
				return call_user_func_array( array( $this, $method ), $args );
		}
	}

	/**
	 * Prints the font style tag.
	 *
	 * @since 1.0.0
	 */
	protected function print_font_style() {
		?>
		<style id="super-awesome-theme-font-style" type="text/css">

			<?php $this->print_font_style_css(); ?>

		</style>
		<?php
	}

	/**
	 * Adds the font style CSS definitions to the block editor as inline CSS.
	 *
	 * @since 1.0.0
	 */
	protected function add_block_editor_font_style() {
		$assets     = $this->get_dependency( 'assets' );
		$stylesheet = $assets->get_registered_asset( 'super-awesome-theme-block-editor-style' );

		ob_start();
		$this->print_font_style_css();
		$style = ob_get_clean();

		$style = preg_replace( '/^(\s*)([a-z0-9\-\.\#\[\]"=: >+]+)(,| \{)$/mi', "$1.edit-post-visual-editor $2$3", $style );

		$stylesheet->add_inline_style( $style, 'after' );
	}

	/**
	 * Prints the font style CSS definitions.
	 *
	 * @since 1.0.0
	 */
	protected function print_font_style_css() {

		/**
		 * Fires when the custom font styles are printed inside a style tag.
		 *
		 * @since 1.0.0
		 *
		 * @param Super_Awesome_Theme_Fonts $fonts The theme fonts instance.
		 */
		do_action( 'super_awesome_theme_font_style', $this );
	}

	/**
	 * Registers the font Customize control type.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager instance.
	 */
	protected function register_font_customize_control( $wp_customize ) {
		require get_template_directory() . '/inc/library/fonts/class-font-customize-control.php';

		$wp_customize->register_control_type( 'Super_Awesome_Theme_Font_Customize_Control' );
	}

	/**
	 * Registers Customizer partial.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_partial( $customizer ) {
		if ( ! empty( $this->groups ) ) {
			$customizer->add_panel( 'fonts', array(
				Super_Awesome_Theme_Customize_Panel::PROP_TITLE    => __( 'Fonts', 'super-awesome-theme' ),
				Super_Awesome_Theme_Customize_Panel::PROP_PRIORITY => 41,
			) );

			$customizer->add_section( 'fonts', array(
				Super_Awesome_Theme_Customize_Section::PROP_PANEL    => 'fonts',
				Super_Awesome_Theme_Customize_Section::PROP_TITLE    => __( 'Other Fonts', 'super-awesome-theme' ),
				Super_Awesome_Theme_Customize_Section::PROP_PRIORITY => 40,
			) );

			foreach ( $this->groups as $id => $title ) {
				$customizer->add_section( $id, array(
					Super_Awesome_Theme_Customize_Section::PROP_PANEL => 'fonts',
					Super_Awesome_Theme_Customize_Section::PROP_TITLE => $title,
				) );
			}
		}

		$partial_fonts = array();
		foreach ( $this->fonts as $id => $font ) {
			if ( $font->get_prop( Super_Awesome_Theme_Font::PROP_LIVE_PREVIEW ) ) {
				$partial_fonts[] = $id;
			}
		}

		if ( ! empty( $partial_fonts ) ) {
			$customizer->add_partial( 'super_awesome_theme_font_style', array(
				Super_Awesome_Theme_Customize_Partial::PROP_SETTINGS            => $partial_fonts,
				Super_Awesome_Theme_Customize_Partial::PROP_SELECTOR            => '#super-awesome-theme-font-style',
				Super_Awesome_Theme_Customize_Partial::PROP_RENDER_CALLBACK     => array( $this, 'print_font_style_css' ),
				Super_Awesome_Theme_Customize_Partial::PROP_CONTAINER_INCLUSIVE => false,
				Super_Awesome_Theme_Customize_Partial::PROP_FALLBACK_REFRESH    => false,
			) );
		}
	}

	/**
	 * Registers scripts for the Customizer controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_controls_js( $assets ) {
		$data = array(
			'groups'           => array(),
			'fonts'            => array(),
			'fontFamilyGroups' => array(),
			'fontFamilies'     => array(),
			'fontWeights'      => array(),
		);
		foreach ( $this->groups as $id => $title ) {
			$data['groups'][] = array(
				'id'    => $id,
				'title' => $title,
			);
		}

		foreach ( $this->fonts as $font ) {
			$data['fonts'][] = $font->get_props();
		}

		$font_families = $this->get_dependency( 'font_families' );

		foreach ( $font_families->get_groups() as $id => $label ) {
			$data['fontFamilyGroups'][] = array(
				'id'    => $id,
				'label' => $label,
			);
		}

		foreach ( $font_families->get_registered_families() as $family ) {
			$family_data                = $family->get_props();
			$family_data['stackString'] = $family->get_stack_string();

			$data['fontFamilies'][] = $family_data;
		}

		foreach ( $font_families->get_weight_choices() as $id => $label ) {
			$data['fontWeights'][] = array(
				'id'    => $id,
				'label' => $label,
			);
		}

		// This workaround ensures the selectWoo assets are properly enqueued.
		$control = new Super_Awesome_Theme_Font_Customize_Control( $GLOBALS['wp_customize'], 'temp', array(
			'settings' => array(),
		) );
		$control->enqueue();

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-fonts-customize-controls',
			get_theme_file_uri( '/assets/dist/js/fonts.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n', 'underscore', 'selectWoo' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeFontsControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Registers the general base fonts.
	 *
	 * @since 1.0.0
	 */
	protected function register_base_fonts_general() {
		$this->register_group( 'general_fonts', __( 'General Fonts', 'super-awesome-theme' ) );

		$this->register_font( new Super_Awesome_Theme_Font( 'base_font', array(
			Super_Awesome_Theme_Font::PROP_GROUP   => 'general_fonts',
			Super_Awesome_Theme_Font::PROP_TITLE   => __( 'Base Font', 'super-awesome-theme' ),
			Super_Awesome_Theme_Font::PROP_DEFAULT => array(
				'family' => 'libre_franklin',
				'weight' => '400',
				'size'   => 1.0,
			),
		) ) );

		$this->register_font( new Super_Awesome_Theme_Font( 'heading_font', array(
			Super_Awesome_Theme_Font::PROP_GROUP   => 'general_fonts',
			Super_Awesome_Theme_Font::PROP_TITLE   => __( 'Heading Font', 'super-awesome-theme' ),
			Super_Awesome_Theme_Font::PROP_DEFAULT => array(
				'family' => 'libre_franklin',
				'weight' => '700',
				'size'   => 1.25,
			),
		) ) );

		$this->register_font_style_callback( array( $this, 'print_base_font_style_general' ) );
	}

	/**
	 * Prints general font styles.
	 *
	 * @since 1.0.0
	 */
	protected function print_base_font_style_general() {
		$base_font    = $this->get( 'base_font' );
		$heading_font = $this->get( 'heading_font' );

		if ( ! empty( $base_font['family'] ) ) {
			?>
			body,
			button,
			input,
			select,
			textarea {
				font-family: <?php echo str_replace( '&quot;', '"', esc_attr( $base_font['family'] ) ); ?>;
				font-weight: <?php echo esc_attr( $base_font['weight'] ); ?>;
				font-size: <?php echo esc_attr( '' . $base_font['size'] . 'rem' ); ?>;
			}
			<?php
		}

		if ( ! empty( $heading_font['family'] ) ) {
			?>
			h1,
			h2,
			h3,
			h4,
			h5,
			h6 {
				font-family: <?php echo str_replace( '&quot;', '"', esc_attr( $heading_font['family'] ) ); ?>;
				font-weight: <?php echo esc_attr( $heading_font['weight'] ); ?>;
			}

			<?php
			$sizes = array(
				'h1' => '' . ( 1.2 * $heading_font['size'] ) . 'rem',
				'h2' => '' . ( 1.0 * $heading_font['size'] ) . 'rem',
				'h3' => '' . ( 0.9 * $heading_font['size'] ) . 'rem',
				'h4' => '' . ( 0.8 * $heading_font['size'] ) . 'rem',
				'h5' => '' . ( 0.7 * $heading_font['size'] ) . 'rem',
				'h6' => '' . ( 0.6 * $heading_font['size'] ) . 'rem',
			);
			foreach ( $sizes as $heading_level => $size ) {
				?>
				<?php echo esc_attr( $heading_level ); ?> {
					font-size: <?php echo esc_attr( $size ); ?>;
				}
				<?php
			}
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_base_fonts_general' ), 5, 0 );
		add_action( 'wp_head', array( $this, 'print_font_style' ), 10, 0 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'add_block_editor_font_style' ), 0, 0 );
		add_action( 'customize_register', array( $this, 'register_font_customize_control' ), 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_partial' ) );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
	}
}
