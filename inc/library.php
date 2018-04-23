<?php
/**
 * Library loader
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Theme main class and component base.
 */
require get_template_directory() . '/inc/library/class-theme.php';
require get_template_directory() . '/inc/library/interface-theme-component.php';
require get_template_directory() . '/inc/library/class-theme-component-base.php';
require get_template_directory() . '/inc/library/class-theme-component-not-provided-exception.php';

/**
 * Theme settings.
 */
require get_template_directory() . '/inc/library/settings/class-settings.php';
require get_template_directory() . '/inc/library/settings/class-setting.php';
require get_template_directory() . '/inc/library/settings/class-string-setting.php';
require get_template_directory() . '/inc/library/settings/class-integer-setting.php';
require get_template_directory() . '/inc/library/settings/class-float-setting.php';
require get_template_directory() . '/inc/library/settings/class-boolean-setting.php';
require get_template_directory() . '/inc/library/settings/class-enum-string-setting.php';
