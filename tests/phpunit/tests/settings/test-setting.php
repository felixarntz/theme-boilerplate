<?php
/**
 * Tests for Super_Awesome_Theme_Setting
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Tests for the Super_Awesome_Theme_Setting class.
 *
 * @group settings
 */
class Tests_Setting extends Super_Awesome_Theme_UnitTestCase {

	/**
	 * Setting instance used for testing.
	 *
	 * @var Super_Awesome_Theme_Setting|null
	 */
	private $setting = null;

	/**
	 * Sets up the setting instance to use for testing.
	 */
	public function setUp() {
		$this->setting = new Super_Awesome_Theme_Setting(
			'my_setting',
			array(
				Super_Awesome_Theme_Setting::PROP_DEFAULT           => 3,
				Super_Awesome_Theme_Setting::PROP_SANITIZE_CALLBACK => 'absint',
				Super_Awesome_Theme_Setting::PROP_PARSE_CALLBACK    => 'absint',
			)
		);
	}

	/**
	 * Tests retrieving a setting property.
	 *
	 * @covers Super_Awesome_Theme_Setting::get_prop
	 * @dataProvider data_get_prop
	 *
	 * @param string $prop  Setting property.
	 * @param mixed  $value Setting property value.
	 */
	public function test_get_prop( $prop, $value ) {
		$this->assertSame( $value, $this->setting->get_prop( $prop ) );
	}

	/**
	 * Data provider for test_get_prop().
	 *
	 * @return array Data to pass to the test method.
	 */
	public function data_get_prop() {
		$props = $this->get_expected_props();

		$data = array();
		foreach ( $props as $prop => $value ) {
			$data[] = array( $prop, $value );
		}

		return $data;
	}

	/**
	 * Tests retrieving all setting properties.
	 *
	 * @covers Super_Awesome_Theme_Setting::get_props
	 */
	public function test_get_props() {
		$this->assertSameSets( $this->get_expected_props(), $this->setting->get_props() );
	}

	/**
	 * Tests retrieving the current value for the setting when a value is set.
	 *
	 * @covers Super_Awesome_Theme_Setting::get_value
	 */
	public function test_get_value_with_value_set() {
		set_theme_mod( 'my_setting', '5' );
		$result = $this->setting->get_value();
		remove_theme_mod( 'my_setting' );

		$this->assertSame( 5, $result );
	}

	/**
	 * Tests retrieving the current value for the setting when no value is set.
	 *
	 * @covers Super_Awesome_Theme_Setting::get_value
	 */
	public function test_get_value_without_value_set() {
		$this->assertSame( 3, $this->setting->get_value() );
	}

	/**
	 * Tests validating a setting value without any validation callback.
	 *
	 * @covers Super_Awesome_Theme_Setting::validate_value
	 */
	public function test_validate_value_without_callback() {
		$this->assertTrue( $this->setting->validate_value( new WP_Error(), 'hello' ) );
	}

	/**
	 * Tests validating a valid setting value with a validation callback.
	 *
	 * @covers Super_Awesome_Theme_Setting::validate_value
	 */
	public function test_validate_value_with_callback_and_valid_value() {
		$setting = new Super_Awesome_Theme_Setting(
			'my_setting',
			array(
				Super_Awesome_Theme_Setting::PROP_VALIDATE_CALLBACK => array( $this, 'validation_callback_wp_error' ),
			)
		);

		$this->assertTrue( $setting->validate_value( new WP_Error(), 41 ) );
	}

	/**
	 * Tests validating an invalid setting value with a validation callback using WP_Error.
	 *
	 * @covers Super_Awesome_Theme_Setting::validate_value
	 */
	public function test_validate_value_with_callback_and_invalid_value_and_wp_error() {
		$setting = new Super_Awesome_Theme_Setting(
			'my_setting',
			array(
				Super_Awesome_Theme_Setting::PROP_VALIDATE_CALLBACK => array( $this, 'validation_callback_wp_error' ),
			)
		);

		$result = $setting->validate_value( new WP_Error(), 42 );

		$this->assertWPError( $result );
		$this->assertSame( 'no_42_allowed', $result->get_error_code() );
	}

	/**
	 * Tests validating an invalid setting value with a validation callback using a boolean.
	 *
	 * @covers Super_Awesome_Theme_Setting::validate_value
	 */
	public function test_validate_value_with_callback_and_invalid_value_and_bool() {
		$setting = new Super_Awesome_Theme_Setting(
			'my_setting',
			array(
				Super_Awesome_Theme_Setting::PROP_VALIDATE_CALLBACK => array( $this, 'validation_callback_bool' ),
			)
		);

		$result = $setting->validate_value( new WP_Error(), 42 );

		$this->assertWPError( $result );
		$this->assertSame( 'invalid_value', $result->get_error_code() );
	}

	/**
	 * Tests sanitizing a setting value.
	 *
	 * @covers Super_Awesome_Theme_Setting::sanitize_value
	 */
	public function test_sanitize_value() {
		$this->assertSame( 4, $this->setting->sanitize_value( '4' ) );
	}

	/**
	 * Tests parsing a setting value.
	 *
	 * @covers Super_Awesome_Theme_Setting::parse_value
	 */
	public function test_parse_value() {
		$this->assertSame( 4, $this->setting->parse_value( '4' ) );
	}

	/**
	 * Validation callback preventing a value from being 42, using WP_Error.
	 *
	 * @param WP_Error $validity Error object to add validation errors to.
	 * @param mixed    $value    Value to validate.
	 * @return bool|WP_Error True on success, error object on failure.
	 */
	public function validation_callback_wp_error( $validity, $value ) {
		$value = (int) $value;

		if ( 42 === $value ) {
			$validity->add( 'no_42_allowed', 'The value must not be equal to 42.' );
		}

		return $validity;
	}

	/**
	 * Validation callback preventing a value from being 42, using a boolean.
	 *
	 * @param WP_Error $validity Error object to add validation errors to.
	 * @param mixed    $value    Value to validate.
	 * @return bool True on success, false on failure.
	 */
	public function validation_callback_bool( $validity, $value ) {
		$value = (int) $value;

		if ( 42 === $value ) {
			return false;
		}

		return true;
	}

	/**
	 * Gets the expected props and values for the setting instance used for testing.
	 *
	 * @return array Array of $prop => $value pairs.
	 */
	private function get_expected_props() {
		return array(
			Super_Awesome_Theme_Setting::PROP_ID                => 'my_setting',
			Super_Awesome_Theme_Setting::PROP_CAPABILITY        => 'edit_theme_options',
			Super_Awesome_Theme_Setting::PROP_DEFAULT           => 3,
			Super_Awesome_Theme_Setting::PROP_VALIDATE_CALLBACK => null,
			Super_Awesome_Theme_Setting::PROP_SANITIZE_CALLBACK => 'absint',
			Super_Awesome_Theme_Setting::PROP_PARSE_CALLBACK    => 'absint',
		);
	}
}
