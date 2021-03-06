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
 * Theme support.
 */
require get_template_directory() . '/inc/library/theme-support/class-theme-support.php';
require get_template_directory() . '/inc/library/theme-support/class-theme-feature.php';
require get_template_directory() . '/inc/library/theme-support/class-args-theme-feature.php';
require get_template_directory() . '/inc/library/theme-support/class-list-theme-feature.php';

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
require get_template_directory() . '/inc/library/settings/class-array-setting.php';
require get_template_directory() . '/inc/library/settings/class-object-setting.php';

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
 * Theme fonts.
 */
require get_template_directory() . '/inc/library/fonts/class-font-families.php';
require get_template_directory() . '/inc/library/fonts/class-font-family-not-registered-exception.php';
require get_template_directory() . '/inc/library/fonts/class-font-family.php';
require get_template_directory() . '/inc/library/fonts/class-webfont-family.php';
require get_template_directory() . '/inc/library/fonts/class-webfont-api.php';
require get_template_directory() . '/inc/library/fonts/class-google-webfont-api.php';
require get_template_directory() . '/inc/library/fonts/class-fonts.php';
require get_template_directory() . '/inc/library/fonts/class-font-util.php';
require get_template_directory() . '/inc/library/fonts/class-font.php';

/**
 * Theme custom logo.
 */
require get_template_directory() . '/inc/library/custom-logo/class-custom-logo.php';

/**
 * Theme custom header.
 */
require get_template_directory() . '/inc/library/custom-header/class-custom-header.php';

/**
 * Theme custom background.
 */
require get_template_directory() . '/inc/library/custom-background/class-custom-background.php';

/**
 * Theme distraction-free mode.
 */
require get_template_directory() . '/inc/library/distraction-free-mode/class-distraction-free-mode.php';

/**
 * Theme sticky frontend elements.
 */
require get_template_directory() . '/inc/library/sticky-elements/class-sticky-elements.php';
require get_template_directory() . '/inc/library/sticky-elements/class-sticky-element-not-registered-exception.php';
require get_template_directory() . '/inc/library/sticky-elements/class-sticky-element.php';

/**
 * Theme comments.
 */
require get_template_directory() . '/inc/library/comments/class-comments.php';

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
 * Theme navbar.
 */
require get_template_directory() . '/inc/library/navbar/class-navbar.php';

/**
 * Theme top bar.
 */
require get_template_directory() . '/inc/library/top-bar/class-top-bar.php';

/**
 * Theme bottom bar.
 */
require get_template_directory() . '/inc/library/bottom-bar/class-bottom-bar.php';

/**
 * Theme footer widget areas.
 */
require get_template_directory() . '/inc/library/footer-widget-areas/class-footer-widget-areas.php';

/**
 * Theme social navigation.
 */
require get_template_directory() . '/inc/library/social-navigation/class-social-navigation.php';

/**
 * Theme footer navigation.
 */
require get_template_directory() . '/inc/library/footer-navigation/class-footer-navigation.php';

/**
 * Theme image sizes.
 */
require get_template_directory() . '/inc/library/image-sizes/class-image-sizes.php';

/**
 * Theme AMP support.
 */
require get_template_directory() . '/inc/library/amp/class-amp.php';

/**
 * Gets the main theme class instance.
 *
 * @since 1.0.0
 *
 * @param string $component Optional. If given, the component of that name is returned instead
 *                          of the main theme class. Default empty string.
 * @return Super_Awesome_Theme_Theme Main theme class instance.
 */
function super_awesome_theme( $component = '' ) {
	static $theme = null;

	if ( null === $theme ) {
		$theme = new Super_Awesome_Theme_Theme();
	}

	if ( ! empty( $component ) ) {
		return $theme->get_component( $component );
	}

	return $theme;
}
