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
require get_template_directory() . '/inc/library/settings/class-float-setting.php';
require get_template_directory() . '/inc/library/settings/class-integer-setting.php';
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
require get_template_directory() . '/inc/library/customizer/class-customize-panel.php';
require get_template_directory() . '/inc/library/customizer/class-customize-section.php';
require get_template_directory() . '/inc/library/customizer/class-customize-control.php';
require get_template_directory() . '/inc/library/customizer/class-customize-setting.php';
require get_template_directory() . '/inc/library/customizer/class-customize-partial.php';

/**
 * Theme colors.
 */
require get_template_directory() . '/inc/library/colors/class-colors.php';
require get_template_directory() . '/inc/library/colors/class-color-util.php';
require get_template_directory() . '/inc/library/colors/class-color.php';

/**
 * Theme widgets.
 */
require get_template_directory() . '/inc/library/widgets/class-widgets.php';
require get_template_directory() . '/inc/library/widgets/class-widget-area-not-registered-exception.php';
require get_template_directory() . '/inc/library/widgets/class-widget-area.php';
require get_template_directory() . '/inc/library/widgets/class-widget.php';
require get_template_directory() . '/inc/library/widgets/class-login-links-widget.php';
require get_template_directory() . '/inc/library/widgets/class-social-menu-widget.php';

/**
 * Theme menus.
 */
require get_template_directory() . '/inc/library/menus/class-menus.php';
require get_template_directory() . '/inc/library/menus/class-menu-not-registered-exception.php';
require get_template_directory() . '/inc/library/menus/class-menu.php';

/**
 * Theme icons.
 */
require get_template_directory() . '/inc/library/icons/class-icons.php';

/**
 * Theme content types.
 */
require get_template_directory() . '/inc/library/content-types/class-content-types.php';
require get_template_directory() . '/inc/library/content-types/class-attachment-metadata.php';

/**
 * Theme sidebar.
 */
require get_template_directory() . '/inc/library/sidebar/class-sidebar.php';

/**
 * Theme footer widget areas.
 */
require get_template_directory() . '/inc/library/footer-widget-areas/class-footer-widget-areas.php';

/**
 * Theme social navigation.
 */
require get_template_directory() . '/inc/library/social-navigation/class-social-navigation.php';

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
