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
require get_template_directory() . '/inc/library/settings/class-setting-not-registered-exception.php';
require get_template_directory() . '/inc/library/settings/class-setting.php';
require get_template_directory() . '/inc/library/settings/class-string-setting.php';
require get_template_directory() . '/inc/library/settings/class-integer-setting.php';
require get_template_directory() . '/inc/library/settings/class-float-setting.php';
require get_template_directory() . '/inc/library/settings/class-boolean-setting.php';
require get_template_directory() . '/inc/library/settings/class-enum-string-setting.php';

/**
 * Theme assets.
 */
require get_template_directory() . '/inc/library/assets/class-assets.php';
require get_template_directory() . '/inc/library/assets/class-asset-not-registered-exception.php';
require get_template_directory() . '/inc/library/assets/class-asset-not-enqueueable-exception.php';
require get_template_directory() . '/inc/library/assets/class-asset.php';
require get_template_directory() . '/inc/library/assets/class-script.php';
require get_template_directory() . '/inc/library/assets/class-stylesheet.php';

/**
 * Theme customizer.
 */
require get_template_directory() . '/inc/library/customizer/class-customizer.php';
require get_template_directory() . '/inc/library/customizer/class-customize-component-not-registered-exception.php';
require get_template_directory() . '/inc/library/customizer/class-customizer-not-initialized-exception.php';

/**
 * Gets the main theme class instance.
 *
 * @since 1.0.0
 *
 * @return Super_Awesome_Theme_Theme Main theme class instance.
 */
function super_awesome_theme() {
	static $theme = null;

	if ( null === $theme ) {
		$theme = new Super_Awesome_Theme_Theme();
	}

	return $theme;
}
