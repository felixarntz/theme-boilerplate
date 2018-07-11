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

		$this->require_dependency_class( 'Super_Awesome_Theme_Theme_Support' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Settings' );
		$this->require_dependency_class( 'Super_Awesome_Theme_Assets' );
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
	 *
	 * @throws BadMethodCallException Thrown when method name is invalid.
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case 'print_color_style':
			case 'add_block_editor_color_style':
			case 'print_color_style_css':
			case 'register_customize_partial':
			case 'register_customize_controls_js':
			case 'add_editor_color_palette_support':
			case 'register_base_colors_general':
			case 'register_base_colors_button':
			case 'register_base_colors_header':
			case 'register_base_colors_footer':
			case 'print_base_color_style_general':
			case 'print_base_color_style_button':
			case 'print_base_color_style_header':
			case 'print_base_color_style_footer':
				return call_user_func_array( array( $this, $method ), $args );
			default:
				/* translators: %s: method name */
				throw new BadMethodCallException( sprintf( __( 'Call to undefined method %s', 'super-awesome-theme' ), __CLASS__ . '::' . $method . '()' ) );
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
	 * Adds the color style CSS definitions to the block editor as inline CSS.
	 *
	 * @since 1.0.0
	 */
	protected function add_block_editor_color_style() {
		$assets     = $this->get_dependency( 'assets' );
		$stylesheet = $assets->get_registered_asset( 'super-awesome-theme-block-editor-style' );

		ob_start();
		$this->print_color_style_css();
		$style = ob_get_clean();

		$style = preg_replace( '/^(\s*)([a-z0-9\-\.\#\[\]"=: >+]+)(,| \{)$/mi', '$1.edit-post-visual-editor $2$3', $style );

		$stylesheet->add_inline_style( $style, 'after' );
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

		foreach ( $this->colors as $id => $color ) {
			$value        = $color->get_value();
			$shaded_value = $this->util()->darken_color( $value, 25 );

			if ( empty( $value ) ) {
				continue;
			}

			$color_class            = 'has-' . str_replace( '_', '-', $id ) . '-color';
			$background_color_class = 'has-' . str_replace( '_', '-', $id ) . '-background-color';

			?>
			.<?php echo esc_attr( $color_class ); ?> {
				color: <?php echo esc_attr( $value ); ?>;
			}

			.<?php echo esc_attr( $background_color_class ); ?> {
				background-color: <?php echo esc_attr( $value ); ?>;
			}

			a.<?php echo esc_attr( $color_class ); ?>,
			button.<?php echo esc_attr( $color_class ); ?>,
			input[type="button"].<?php echo esc_attr( $color_class ); ?>,
			input[type="reset"].<?php echo esc_attr( $color_class ); ?>,
			input[type="submit"].<?php echo esc_attr( $color_class ); ?>,
			.button.<?php echo esc_attr( $color_class ); ?>,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $color_class ); ?> {
				color: <?php echo esc_attr( $value ); ?>;
			}

			a.<?php echo esc_attr( $background_color_class ); ?>,
			button.<?php echo esc_attr( $background_color_class ); ?>,
			input[type="button"].<?php echo esc_attr( $background_color_class ); ?>,
			input[type="reset"].<?php echo esc_attr( $background_color_class ); ?>,
			input[type="submit"].<?php echo esc_attr( $background_color_class ); ?>,
			.button.<?php echo esc_attr( $background_color_class ); ?>,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $background_color_class ); ?> {
				background-color: <?php echo esc_attr( $value ); ?>;
			}

			a.<?php echo esc_attr( $color_class ); ?>:hover,
			a.<?php echo esc_attr( $color_class ); ?>:focus,
			button.<?php echo esc_attr( $color_class ); ?>:hover,
			button.<?php echo esc_attr( $color_class ); ?>:focus,
			input[type="button"].<?php echo esc_attr( $color_class ); ?>:hover,
			input[type="button"].<?php echo esc_attr( $color_class ); ?>:focus,
			input[type="reset"].<?php echo esc_attr( $color_class ); ?>:hover,
			input[type="reset"].<?php echo esc_attr( $color_class ); ?>:focus,
			input[type="submit"].<?php echo esc_attr( $color_class ); ?>:hover,
			input[type="submit"].<?php echo esc_attr( $color_class ); ?>:focus,
			.button.<?php echo esc_attr( $color_class ); ?>:hover,
			.button.<?php echo esc_attr( $color_class ); ?>:focus,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $color_class ); ?>:hover,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $color_class ); ?>:focus {
				color: <?php echo esc_attr( $shaded_value ); ?>;
			}

			a.<?php echo esc_attr( $background_color_class ); ?>:hover,
			a.<?php echo esc_attr( $background_color_class ); ?>:focus,
			button.<?php echo esc_attr( $background_color_class ); ?>:hover,
			button.<?php echo esc_attr( $background_color_class ); ?>:focus,
			input[type="button"].<?php echo esc_attr( $background_color_class ); ?>:hover,
			input[type="button"].<?php echo esc_attr( $background_color_class ); ?>:focus,
			input[type="reset"].<?php echo esc_attr( $background_color_class ); ?>:hover,
			input[type="reset"].<?php echo esc_attr( $background_color_class ); ?>:focus,
			input[type="submit"].<?php echo esc_attr( $background_color_class ); ?>:hover,
			input[type="submit"].<?php echo esc_attr( $background_color_class ); ?>:focus,
			.button.<?php echo esc_attr( $background_color_class ); ?>:hover,
			.button.<?php echo esc_attr( $background_color_class ); ?>:focus,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $background_color_class ); ?>:hover,
			.wp-block-button .wp-block-button__link.<?php echo esc_attr( $background_color_class ); ?>:focus {
				background-color: <?php echo esc_attr( $shaded_value ); ?>;
			}
			<?php
		}
	}

	/**
	 * Registers Customizer partial and tweaks core sections and controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Customizer $customizer Customizer instance.
	 */
	protected function register_customize_partial( $customizer ) {
		$partial_colors = array();

		if ( ! empty( $this->groups ) ) {
			$customizer->add_panel( 'colors', array(
				Super_Awesome_Theme_Customize_Panel::PROP_TITLE    => __( 'Colors', 'super-awesome-theme' ),
				Super_Awesome_Theme_Customize_Panel::PROP_PRIORITY => 40,
			) );

			// Adjust the original core section to become a sub-section of the colors panel.
			$orig_colors_section        = $customizer->get_section( 'colors' );
			$orig_colors_section->panel = 'colors';
			$orig_colors_section->title = __( 'Other Colors', 'super-awesome-theme' );

			foreach ( $this->groups as $id => $title ) {
				$customizer->add_section( $id, array(
					Super_Awesome_Theme_Customize_Section::PROP_PANEL => 'colors',
					Super_Awesome_Theme_Customize_Section::PROP_TITLE => $title,
				) );
			}
		}

		foreach ( $this->colors as $id => $color ) {
			if ( $color->get_prop( Super_Awesome_Theme_Color::PROP_LIVE_PREVIEW ) ) {
				$partial_colors[] = $id;
			}

			// Adjust core colors 'background_color' and 'header_textcolor'.
			if ( 'background_color' === $id || 'header_textcolor' === $id ) {
				$orig_color_control           = $customizer->get_control( $id );
				$orig_color_control->section  = $color->get_prop( Super_Awesome_Theme_Color::PROP_GROUP );
				$orig_color_control->label    = $color->get_prop( Super_Awesome_Theme_Color::PROP_TITLE );
				$orig_color_control->priority = 'header_textcolor' === $id ? 9 : 11;
			}
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
	 * Registers scripts for the Customizer controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Assets $assets Assets instance.
	 */
	protected function register_customize_controls_js( $assets ) {
		$data = array(
			'groups'            => array(),
			'colors'            => array(),
			'footerWidgetAreas' => super_awesome_theme( 'footer_widget_areas' )->get_widget_area_names(),
		);
		foreach ( $this->groups as $id => $title ) {
			$data['groups'][] = array(
				'id'    => $id,
				'title' => $title,
			);
		}

		foreach ( $this->colors as $id => $color ) {
			// Skip core colors 'background_color' and 'header_textcolor'.
			if ( 'background_color' === $id || 'header_textcolor' === $id ) {
				continue;
			}

			$data['colors'][] = $color->get_props();
		}

		$assets->register_asset( new Super_Awesome_Theme_Script(
			'super-awesome-theme-colors-customize-controls',
			get_theme_file_uri( '/assets/dist/js/colors.customize-controls.js' ),
			array(
				Super_Awesome_Theme_Script::PROP_DEPENDENCIES => array( 'customize-controls', 'wp-i18n' ),
				Super_Awesome_Theme_Script::PROP_VERSION      => SUPER_AWESOME_THEME_VERSION,
				Super_Awesome_Theme_Script::PROP_LOCATION     => Super_Awesome_Theme_Script::LOCATION_CUSTOMIZE_CONTROLS,
				Super_Awesome_Theme_Script::PROP_MIN_URI      => true,
				Super_Awesome_Theme_Script::PROP_DATA_NAME    => 'themeColorsControlsData',
				Super_Awesome_Theme_Script::PROP_DATA         => $data,
			)
		) );
	}

	/**
	 * Adds the registered colors to the editor color palette.
	 *
	 * @since 1.0.0
	 */
	protected function add_editor_color_palette_support() {
		$theme_support = $this->get_dependency( 'theme_support' );

		$color_palette = array();
		foreach ( $this->colors as $id => $color ) {
			$title = $color->get_prop( Super_Awesome_Theme_Color::PROP_TITLE );
			$value = $color->get_value();

			if ( empty( $value ) || 'blank' === $value || isset( $color_palette[ $value ] ) ) {
				continue;
			}

			$color_palette[ $value ] = array(
				'slug'  => $id,
				'name'  => $title,
				'color' => $value,
			);
		}

		$theme_support->add_feature( new Super_Awesome_Theme_List_Theme_Feature( 'editor-color-palette', array_values( $color_palette ) ) );
	}

	/**
	 * Registers the general base colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_base_colors_general() {
		$this->register_group( 'general_colors', __( 'General Colors', 'super-awesome-theme' ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'general_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#404040',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'general_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#21759b',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'wrap_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'general_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Wrap Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '',
		) ) );

		$default_background_color  = '#ffffff';
		$custom_background_feature = $this->get_dependency( 'theme_support' )->get_feature( 'custom-background' );
		if ( $custom_background_feature->is_supported() ) {
			$custom_background_args = $custom_background_feature->get_support();
			if ( ! empty( $custom_background_args['default-color'] ) ) {
				$default_background_color = '#' . $custom_background_args['default-color'];
			}
		}

		// This color is part of core.
		$this->register_color( new Super_Awesome_Theme_Color( 'background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'general_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => $default_background_color,
		) ) );

		$this->register_color_style_callback( array( $this, 'print_base_color_style_general' ) );
	}

	/**
	 * Registers the button base colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_base_colors_button() {
		$this->register_group( 'button_colors', __( 'Button Colors', 'super-awesome-theme' ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'button_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'button_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Button Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#404040',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'button_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'button_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Button Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#e6e6e6',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'button_primary_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'button_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Primary Button Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#ffffff',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'button_primary_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'button_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Primary Button Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#21759b',
		) ) );

		$this->register_color_style_callback( array( $this, 'print_base_color_style_button' ) );
	}

	/**
	 * Registers the header base colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_base_colors_header() {
		$this->register_group( 'header_colors', __( 'Header Colors', 'super-awesome-theme' ) );

		$default_header_textcolor = '#404040';
		$custom_header_feature    = $this->get_dependency( 'theme_support' )->get_feature( 'custom-header' );
		if ( $custom_header_feature->is_supported() ) {
			$custom_header_args = $custom_header_feature->get_support();
			if ( ! empty( $custom_header_args['default-text-color'] ) ) {
				$default_header_textcolor = '#' . $custom_header_args['default-text-color'];
			}
		}

		// This color is part of core.
		$this->register_color( new Super_Awesome_Theme_Color( 'header_textcolor', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'header_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Header Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => $default_header_textcolor,
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'header_link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'header_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Header Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#404040',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'header_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'header_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Header Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#ffffff',
		) ) );

		$this->register_color_style_callback( array( $this, 'print_base_color_style_header' ) );
	}

	/**
	 * Registers the footer base colors.
	 *
	 * @since 1.0.0
	 */
	protected function register_base_colors_footer() {
		$this->register_group( 'footer_colors', __( 'Footer Colors', 'super-awesome-theme' ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'footer_text_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'footer_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Footer Text Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#404040',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'footer_link_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'footer_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Footer Link Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#21759b',
		) ) );

		$this->register_color( new Super_Awesome_Theme_Color( 'footer_background_color', array(
			Super_Awesome_Theme_Color::PROP_GROUP   => 'footer_colors',
			Super_Awesome_Theme_Color::PROP_TITLE   => __( 'Footer Background Color', 'super-awesome-theme' ),
			Super_Awesome_Theme_Color::PROP_DEFAULT => '#ffffff',
		) ) );

		$this->register_color_style_callback( array( $this, 'print_base_color_style_footer' ) );
	}

	/**
	 * Prints general color styles.
	 *
	 * @since 1.0.0
	 */
	protected function print_base_color_style_general() {
		$text_color            = $this->get( 'text_color' );
		$text_focus_color      = $this->util()->darken_color( $text_color, 25 );
		$text_light_color      = $this->util()->lighten_color( $text_color, 100 );
		$link_color            = $this->get( 'link_color' );
		$link_focus_color      = $this->util()->darken_color( $link_color, 25 );
		$wrap_background_color = $this->get( 'wrap_background_color' );

		if ( ! empty( $text_color ) && ! empty( $text_focus_color ) && ! empty( $text_light_color ) ) {
			?>
			body,
			button,
			input,
			select,
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"],
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			input[type="number"],
			input[type="tel"],
			input[type="range"],
			input[type="date"],
			input[type="month"],
			input[type="week"],
			input[type="time"],
			input[type="datetime"],
			input[type="datetime-local"],
			input[type="color"],
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"]:focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			input[type="number"]:focus,
			input[type="tel"]:focus,
			input[type="range"]:focus,
			input[type="date"]:focus,
			input[type="month"]:focus,
			input[type="week"]:focus,
			input[type="time"]:focus,
			input[type="datetime"]:focus,
			input[type="datetime-local"]:focus,
			input[type="color"]:focus,
			textarea:focus {
				color: <?php echo esc_attr( $text_focus_color ); ?>;
			}

			::-webkit-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			::-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-ms-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			abbr,
			acronym {
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			hr,
			.wp-block-separator {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			tr {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			blockquote {
				color: <?php echo esc_attr( $text_color ); ?>;
				border-left-color: <?php echo esc_attr( $text_color ); ?>;
			}

			.wp-block-pullquote {
				border-top-color: <?php echo esc_attr( $text_color ); ?>;
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			blockquote cite,
			blockquote footer,
			.wp-block-quote cite,
			.wp-block-quote footer,
			.wp-block-pullquote cite,
			.wp-block-pullquote footer {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}
			<?php
		}

		if ( ! empty( $link_color ) && ! empty( $link_focus_color ) ) {
			?>
			a,
			a:visited {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			a:hover,
			a:focus,
			a:active {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}

			button.button-link,
			input[type="button"].button-link,
			input[type="reset"].button-link,
			input[type="submit"].button-link,
			.button.button-link {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			button.button-link:hover,
			button.button-link:focus,
			input[type="button"].button-link:hover,
			input[type="button"].button-link:focus,
			input[type="reset"].button-link:hover,
			input[type="reset"].button-link:focus,
			input[type="submit"].button-link:hover,
			input[type="submit"].button-link:focus,
			.button.button-link:hover,
			.button.button-link:focus {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}
			<?php
		}

		if ( super_awesome_theme_use_wrapped_layout() && ! empty( $wrap_background_color ) ) {
			?>
			.site {
				background-color: <?php echo esc_attr( $wrap_background_color ); ?>;
			}
			<?php
		}
	}

	/**
	 * Prints button color styles.
	 *
	 * @since 1.0.0
	 */
	protected function print_base_color_style_button() {
		$button_text_color                     = $this->get( 'button_text_color' );
		$button_background_color               = $this->get( 'button_background_color' );
		$button_background_focus_color         = $this->util()->darken_color( $button_background_color, 25 );
		$button_primary_text_color             = $this->get( 'button_primary_text_color' );
		$button_primary_background_color       = $this->get( 'button_primary_background_color' );
		$button_primary_background_focus_color = $this->util()->darken_color( $button_primary_background_color, 25 );

		if ( ! empty( $button_text_color ) && ! empty( $button_background_color ) && ! empty( $button_background_focus_color ) ) {
			?>
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			.button {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			button:hover,
			button:focus,
			input[type="button"]:hover,
			input[type="button"]:focus,
			input[type="reset"]:hover,
			input[type="reset"]:focus,
			input[type="submit"]:hover,
			input[type="submit"]:focus,
			.button:hover,
			.button:focus {
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}

			.wp-block-button .wp-block-button__link {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			.wp-block-button .wp-block-button__link:hover,
			.wp-block-button .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}
			<?php
		}

		if ( ! empty( $button_primary_text_color ) && ! empty( $button_primary_background_color ) && ! empty( $button_primary_background_focus_color ) ) {
			?>
			button.button-primary,
			input[type="button"].button-primary,
			input[type="reset"].button-primary,
			input[type="submit"].button-primary,
			.button.button-primary {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			button.button-primary:hover,
			button.button-primary:focus,
			input[type="button"].button-primary:hover,
			input[type="button"].button-primary:focus,
			input[type="reset"].button-primary:hover,
			input[type="reset"].button-primary:focus,
			input[type="submit"].button-primary:hover,
			input[type="submit"].button-primary:focus,
			.button.button-primary:hover,
			.button.button-primary:focus {
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link:hover,
			.wp-block-button.button-primary .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}
			<?php
		}
	}

	/**
	 * Prints header color styles.
	 *
	 * @since 1.0.0
	 */
	protected function print_base_color_style_header() {
		$header_text_color       = $this->get( 'header_textcolor' );
		$header_link_color       = $this->get( 'header_link_color' );
		$header_link_focus_color = $this->util()->darken_color( $header_link_color, 25 );
		$header_background_color = $this->get( 'header_background_color' );

		if ( ! empty( $header_text_color ) && 'blank' !== $header_text_color ) {
			?>
			.site-custom-header {
				color: <?php echo esc_attr( $header_text_color ); ?>;
			}
			<?php
		}

		if ( ! empty( $header_link_color ) && ! empty( $header_link_focus_color ) ) {
			?>
			.site-custom-header a,
			.site-custom-header a:visited {
				color: <?php echo esc_attr( $header_link_color ); ?>;
			}

			.site-custom-header a:hover,
			.site-custom-header a:focus,
			.site-custom-header a:active {
				color: <?php echo esc_attr( $header_link_focus_color ); ?>;
			}
			<?php
		}

		if ( ! empty( $header_background_color ) ) {
			?>
			.site-custom-header {
				background-color: <?php echo esc_attr( $header_background_color ); ?>;
			}
			<?php
		}
	}

	/**
	 * Prints footer color styles.
	 *
	 * @since 1.0.0
	 */
	protected function print_base_color_style_footer() {
		$footer_text_color       = $this->get( 'footer_text_color' );
		$footer_link_color       = $this->get( 'footer_link_color' );
		$footer_link_focus_color = $this->util()->darken_color( $footer_link_color, 25 );
		$footer_background_color = $this->get( 'footer_background_color' );

		if ( ! empty( $footer_text_color ) && ! empty( $footer_background_color ) ) {
			?>
			.footer-widgets,
			.social-navigation,
			.footer-navigation {
				color: <?php echo esc_attr( $footer_text_color ); ?>;
				background-color: <?php echo esc_attr( $footer_background_color ); ?>;
			}
			<?php
		}

		if ( ! empty( $footer_link_color ) && ! empty( $footer_link_focus_color ) ) {
			?>
			.footer-widgets a,
			.footer-widgets a:visited,
			.footer-navigation a,
			.footer-navigation a:visited {
				color: <?php echo esc_attr( $footer_link_color ); ?>;
			}

			.footer-widgets a:hover,
			.footer-widgets a:focus,
			.footer-widgets a:active,
			.footer-navigation a:hover,
			.footer-navigation a:focus,
			.footer-navigation a:active {
				color: <?php echo esc_attr( $footer_link_focus_color ); ?>;
			}
			<?php
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'after_setup_theme', array( $this, 'register_base_colors_general' ), 5, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_base_colors_button' ), 5, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_base_colors_header' ), 5, 0 );
		add_action( 'after_setup_theme', array( $this, 'register_base_colors_footer' ), 5, 0 );
		add_action( 'after_setup_theme', array( $this, 'add_editor_color_palette_support' ), PHP_INT_MAX, 0 );
		add_action( 'wp_head', array( $this, 'print_color_style' ), 10, 0 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'add_block_editor_color_style' ), 0, 0 );

		$customizer = $this->get_dependency( 'customizer' );
		$customizer->on_init( array( $this, 'register_customize_partial' ) );
		$customizer->on_js_controls_init( array( $this, 'register_customize_controls_js' ) );
	}
}
