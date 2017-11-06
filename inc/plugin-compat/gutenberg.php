<?php
/**
 * Gutenberg compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

/**
 * Registers support for various Gutenberg features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_gutenberg_setup() {
	add_theme_support( 'gutenberg', array(
		'wide-images' => true,
		'colors'      => array(
			'#ffffff',
			'#f1f1f1',
			'#222222',
			'#404040',
			'#8f98a1',
			'#e6e6e6',
			'#21759b',
		),
	) );
}
add_action( 'after_setup_theme', 'super_awesome_theme_gutenberg_setup' );
