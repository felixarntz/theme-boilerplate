<?php
/**
 * PHPUnit tests bootstrap file
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

// disable xdebug backtrace
if ( function_exists( 'xdebug_disable' ) ) {
	xdebug_disable();
}

if ( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	$test_root = getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit';
} elseif ( file_exists( '/tmp/wordpress-tests-lib/includes/bootstrap.php' ) ) {
	$test_root = '/tmp/wordpress-tests-lib';
} else {
	$test_root = '../../../../../../tests/phpunit';
}

define( 'WP_THEME_DIR', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
define( 'WP_DEFAULT_THEME', 'super-awesome-theme' );

$GLOBALS['wp_tests_options'] = array(
	'template'        => 'super-awesome-theme',
	'stylesheet'      => 'super-awesome-theme',
	'template_root'   => WP_THEME_DIR,
	'stylesheet_root' => WP_THEME_DIR,
);

require_once $test_root . '/includes/functions.php';

function test_register_theme_directory() {
	register_theme_directory( WP_THEME_DIR );
}
tests_add_filter( 'setup_theme', 'test_register_theme_directory' );

require_once $test_root . '/includes/bootstrap.php';

require_once dirname( __FILE__ ) . '/testcase.php';
