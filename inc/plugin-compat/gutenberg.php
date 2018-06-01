<?php
/**
 * Gutenberg compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

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
