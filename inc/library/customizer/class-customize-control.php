<?php
/**
 * Super_Awesome_Theme_Customize_Control class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing a Customizer control.
 *
 * Since core already has acceptable classes for these, this class only contains
 * constants for easy property access.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Customize_Control {

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
	 * Section property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_SECTION = 'section';

	/**
	 * Type property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_TYPE = 'type';

	/**
	 * Title property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_TITLE = 'label';

	/**
	 * Description property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_DESCRIPTION = 'description';

	/**
	 * Priority property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_PRIORITY = 'priority';

	/**
	 * Active callback property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_ACTIVE_CALLBACK = 'active_callback';

	/**
	 * Input attributes property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_INPUT_ATTRS = 'input_attrs';

	/**
	 * Choices property name.
	 *
	 * @since 1.0.0
	 */
	const PROP_CHOICES = 'choices';

	/**
	 * Identifier of the checkbox type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_CHECKBOX = 'checkbox';

	/**
	 * Identifier of the radio type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_RADIO = 'radio';

	/**
	 * Identifier of the select type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_SELECT = 'select';

	/**
	 * Identifier of the textarea type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_TEXTAREA = 'textarea';

	/**
	 * Identifier of the color type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_COLOR = 'color';

	/**
	 * Identifier of the number type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_NUMBER = 'number';

	/**
	 * Identifier of the range type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_RANGE = 'range';

	/**
	 * Identifier of the text type.
	 *
	 * @since 1.0.0
	 */
	const TYPE_TEXT = 'text';
}
