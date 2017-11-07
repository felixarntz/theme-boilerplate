<?php
/**
 * Torro Forms compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

add_filter( 'torro_load_frontend_css', '__return_false' );

/**
 * Adjusts the CSS classes to use for forms.
 *
 * @since 1.0.0
 *
 * @param array $wrap_classes Original form classes.
 * @return array Modified form classes.
 */
function super_awesome_theme_torro_forms_adjust_form_class( $form_classes ) {
	$form_classes[] = 'form-horizontal';

	return $form_classes;
}
add_filter( 'torro_form_classes', 'super_awesome_theme_torro_forms_adjust_form_class' );

/**
 * Adjusts the CSS classes to use for element wrappers.
 *
 * @since 1.0.0
 *
 * @param array $wrap_classes Original wrap classes.
 * @return array Modified wrap classes.
 */
function super_awesome_theme_torro_forms_adjust_wrap_class( $wrap_classes ) {
	$wrap_classes[] = 'form-group';

	return $wrap_classes;
}
add_filter( 'torro_element_wrap_classes', 'super_awesome_theme_torro_forms_adjust_wrap_class' );

/**
 * Gets the default CSS class to use for buttons.
 *
 * @since 1.0.0
 *
 * @param string $button_class Original button CSS class.
 * @return string CSS class for buttons.
 */
function super_awesome_theme_torro_forms_get_button_class( $button_class ) {
	return $button_class . ' button';
}
add_filter( 'torro_form_button_class', 'super_awesome_theme_torro_forms_get_button_class' );

/**
 * Gets the default CSS class to use for primary buttons.
 *
 * @since 1.0.0
 *
 * @param string $button_primary_class Original primary button CSS class.
 * @return string CSS class for primary buttons.
 */
function super_awesome_theme_torro_forms_get_button_primary_class( $button_primary_class ) {
	return $button_primary_class . ' button-primary';
}
add_filter( 'torro_form_button_primary_class', 'super_awesome_theme_torro_forms_get_button_primary_class' );

/**
 * Gets the default CSS class to use for notices.
 *
 * @since 1.0.0
 *
 * @param string $notice_class Original notice CSS class.
 * @param string $type         Notice type.
 * @return string CSS class for notices of the given type.
 */
function super_awesome_theme_torro_forms_get_notice_class( $notice_class, $type ) {
	return $notice_class . " notice notice-{$type}";
}
add_filter( 'torro_form_notice_class', 'super_awesome_theme_torro_forms_get_notice_class', 10, 2 );
