/**
 * File social-navigation.customize-controls.js.
 *
 * Theme Customizer handling for the social navigation.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';

( ( wp ) => {
	const api  = wp.customize;
	const util = new CustomizeControlsUtil( api );

	api.bind( 'ready', () => {

		// Handle visibility of the social color controls.
		util.bindSettingToControls( 'nav_menu_locations[social]', [ 'social_text_color', 'social_background_color' ], ( value, control ) => {
			control.active.set( !! value );
		});
	});

} )( window.wp );
