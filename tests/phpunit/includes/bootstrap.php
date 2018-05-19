<?php
/**
 * PHPUnit tests bootstrap file
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

// Disable xdebug backtrace.
if ( function_exists( 'xdebug_disable' ) ) {
	xdebug_disable();
}

$needs_custom_theme_dir = false;

if ( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	$test_root = getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit';

	if ( ! file_exists( getenv( 'WP_DEVELOP_DIR' ) . '/src/wp-content/themes/super-awesome-theme/functions.php' ) ) {
		$needs_custom_theme_dir = true;
	}
} elseif ( file_exists( '/tmp/wordpress-tests-lib/includes/bootstrap.php' ) ) {
	$test_root = '/tmp/wordpress-tests-lib';

	$needs_custom_theme_dir = true;
} else {
	$test_root = '../../../../../../tests/phpunit';
}

$GLOBALS['wp_tests_options'] = array(
	'template'   => 'super-awesome-theme',
	'stylesheet' => 'super-awesome-theme',
);

if ( $needs_custom_theme_dir ) {
	$GLOBALS['wp_tests_options']['template_root']   = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );
	$GLOBALS['wp_tests_options']['stylesheet_root'] = $GLOBALS['wp_tests_options']['template_root'];

	require_once $test_root . '/includes/functions.php';

	/**
	 * Registers the custom theme directory.
	 */
	function test_register_theme_directory() {
		register_theme_directory( $GLOBALS['wp_tests_options']['stylesheet_root'] );
	}
	tests_add_filter( 'setup_theme', 'test_register_theme_directory' );
}

require_once $test_root . '/includes/bootstrap.php';

require_once dirname( __FILE__ ) . '/testcase.php';

var_dump( STYLESHEETPATH );
require_once STYLESHEETPATH . '/functions.php';
