<?php
/**
 * Tests for Super_Awesome_Theme_Settings
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * @group settings
 */
class Tests_Settings extends Super_Awesome_Theme_UnitTestCase {

	/**
	 * Tests retrieving the value for a registered setting.
	 *
	 * @covers Super_Awesome_Theme_Settings::get
	 */
	public function test_get_with_registered() {
		$settings = new Super_Awesome_Theme_Settings();

		$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting(
			'test_setting',
			array( Super_Awesome_Theme_Boolean_Setting::PROP_DEFAULT => true )
		) );

		$this->assertTrue( $settings->get( 'test_setting' ) );
	}

	/**
	 * Tests retrieving the value for an unregistered setting.
	 *
	 * @covers Super_Awesome_Theme_Settings::get
	 */
	public function test_get_with_unregistered() {
		$settings = new Super_Awesome_Theme_Settings();

		$this->assertNull( $settings->get( 'test_setting' ) );
	}

	/**
	 * Tests registering a setting.
	 *
	 * @covers Super_Awesome_Theme_Settings::register_setting
	 */
	public function test_register_setting() {
		$settings = new Super_Awesome_Theme_Settings();

		$this->assertTrue( $settings->register_setting( new Super_Awesome_Theme_Boolean_Setting( 'test_setting' ) ) );

		$this->assertFalse( $settings->register_setting( new Super_Awesome_Theme_Boolean_Setting( 'test_setting' ) ) );
	}

	/**
	 * Tests retrieving a registered setting instance.
	 *
	 * @covers Super_Awesome_Theme_Settings::get_registered_setting
	 */
	public function test_get_registered_setting_with_registered() {
		$settings = new Super_Awesome_Theme_Settings();

		$setting = new Super_Awesome_Theme_Boolean_Setting( 'test_setting' );

		$settings->register_setting( $setting );

		$this->assertSame( $setting, $settings->get_registered_setting( 'test_setting' ) );
	}

	/**
	 * Tests retrieving an unregistered setting instance.
	 *
	 * @covers Super_Awesome_Theme_Settings::get_registered_setting
	 * @expectedException Super_Awesome_Theme_Setting_Not_Registered_Exception
	 */
	public function test_get_registered_setting_with_unregistered() {
		$settings = new Super_Awesome_Theme_Settings();

		$settings->get_registered_setting( 'test_setting' );
	}

	/**
	 * Tests retrieving all registered setting instances.
	 *
	 * @covers Super_Awesome_Theme_Settings::get_registered_settings
	 */
	public function test_get_registered_settings() {
		$settings = new Super_Awesome_Theme_Settings();

		$test_settings = array(
			'test_setting'   => new Super_Awesome_Theme_Boolean_Setting( 'test_setting' ),
			'test_setting_2' => new Super_Awesome_Theme_String_Setting( 'test_setting_2' )
		);

		foreach ( $test_settings as $test_setting ) {
			$settings->register_setting( $test_setting );
		}

		$this->assertSame( $test_settings, $settings->get_registered_settings() );
	}

	/**
	 * Tests whether the call method works correctly to register settings in the Customizer.
	 *
	 * @covers Super_Awesome_Theme_Settings::__call
	 */
	public function test___call() {
		$settings = new Super_Awesome_Theme_Settings();

		$test_settings = array( 'test_setting', 'test_setting_2' );

		foreach ( $test_settings as $test_setting ) {
			$settings->register_setting( new Super_Awesome_Theme_Boolean_Setting( $test_setting ) );
		}

		if ( ! class_exists( 'WP_Customize_Manager' ) ) {
			require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
		}

		$wp_customize = new WP_Customize_Manager();
		$settings->__call( 'register_in_customizer', array( $wp_customize ) );

		foreach ( $test_settings as $test_setting ) {
			$this->assertInstanceOf( 'WP_Customize_Setting', $wp_customize->get_setting( $test_setting ) );
		}
	}

	/**
	 * Tests initializing the settings class.
	 *
	 * @covers Super_Awesome_Theme_Settings::run_initialization
	 */
	public function test_run_initialization() {
		$settings = new Super_Awesome_Theme_Settings();
		$settings->initialize();

		$this->assertSame( 1, has_action( 'customize_register', array( $settings, 'register_in_customizer' ) ) );
	}
}
