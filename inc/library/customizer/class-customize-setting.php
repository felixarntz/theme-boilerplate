<?php
/**
 * Super_Awesome_Theme_Customize_Setting class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a Customizer setting.
 *
 * Since core already has acceptable classes for these, this class only contains
 * constants for easy property access.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Customize_Setting {

	/**
	 * ID property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ID = 'id';

	/**
	 * Capability property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_CAPABILITY = 'capability';

	/**
	 * Type property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_TYPE = 'type';

	/**
	 * Default property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DEFAULT = 'default';

	/**
	 * Validate callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_VALIDATE_CALLBACK = 'validate_callback';

	/**
	 * Sanitize callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_SANITIZE_CALLBACK = 'sanitize_callback';

	/**
	 * Sanitize JS callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_SANITIZE_JS_CALLBACK = 'sanitize_js_callback';

	/**
	 * Transport property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_TRANSPORT = 'transport';

	/**
	 * Theme supports property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_THEME_SUPPORTS = 'theme_supports';

	/**
	 * Identifier of the theme mod type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_THEME_MOD = 'theme_mod';

	/**
	 * Identifier of the option type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_OPTION = 'option';

	/**
	 * Identifier of the refresh transport.
	 *
	 * @since 1.0.0
	 */
	const TRANSPORT_REFRESH = 'refresh';

	/**
	 * Identifier of the post message transport.
	 *
	 * @since 1.0.0
	 */
	const TRANSPORT_POST_MESSAGE = 'postMessage';
}
