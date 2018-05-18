<?php
/**
 * Gutenberg compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various Gutenberg features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_gutenberg_setup() {
	$colors        = super_awesome_theme()->get_component( 'colors' );
	$theme_support = super_awesome_theme()->get_component( 'theme_support' );

	$theme_colors = array(
		$colors->get( 'text_color' ),
		$colors->util()->darken_color( $colors->get( 'text_color' ), 25 ),
		$colors->util()->lighten_color( $colors->get( 'text_color' ), 100 ),
		$colors->get( 'link_color' ),
		$colors->util()->darken_color( $colors->get( 'link_color' ), 25 ),
		$colors->get( 'wrap_background_color' ),
		$colors->get( 'button_text_color' ),
		$colors->get( 'button_background_color' ),
		$colors->util()->darken_color( $colors->get( 'button_background_color' ), 25 ),
		$colors->get( 'button_primary_text_color' ),
		$colors->get( 'button_primary_background_color' ),
		$colors->util()->darken_color( $colors->get( 'button_primary_background_color' ), 25 ),
	);
	$theme_colors = array_unique( array_filter( $theme_colors ) );

	$theme_support->add_feature( new Super_Awesome_Theme_Theme_Feature( 'align-wide' ) );
	$theme_support->add_feature( new Super_Awesome_Theme_Theme_Feature( 'disable-custom-colors' ) );
	$theme_support->add_feature( new Super_Awesome_Theme_List_Theme_Feature( 'editor-color-palette', $theme_colors ) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_gutenberg_setup', 100 );

/**
 * Enqueues the theme's Gutenberg editor stylesheet.
 *
 * @since 1.0.0
 */
function super_awesome_theme_gutenberg_enqueue_editor_style() {
	$assets = super_awesome_theme()->get_component( 'assets' );

	$assets->register_asset( new Super_Awesome_Theme_Stylesheet(
		'super-awesome-theme-block-editor-style',
		get_theme_file_uri( '/block-editor-style.css' ),
		array(
			Super_Awesome_Theme_Stylesheet::PROP_VERSION  => SUPER_AWESOME_THEME_VERSION,
			Super_Awesome_Theme_Stylesheet::PROP_LOCATION => 'block_editor',
			Super_Awesome_Theme_Stylesheet::PROP_HAS_RTL  => true,
		)
	) );

	$stylesheet = $assets->get_registered_asset( 'super-awesome-theme-block-editor-style' );
	$stylesheet->register();
	$stylesheet->enqueue();
}
add_action( 'enqueue_block_editor_assets', 'super_awesome_theme_gutenberg_enqueue_editor_style' );
