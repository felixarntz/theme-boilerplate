/**
 * File top-bar.customize-controls.js.
 *
 * Theme Customizer handling for the top bar.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';
import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api    = wp.customize;
	const util   = new CustomizeControlsUtil( api );
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'top_bar_justify_content', ( topBarJustifyContent ) => {
			topBarJustifyContent.transport = 'postMessage';
		});

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'top_bar', {
				panel:           'layout',
				title:           __( 'Top Bar', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			api.control.add( new api.Control( 'top_bar_justify_content', {
				setting:     'top_bar_justify_content',
				section:     'top_bar',
				label:       __( 'Top Bar Justify Content', 'super-awesome-theme' ),
				description: __( 'Specify how the content in the top bar is aligned.', 'super-awesome-theme' ),
				type:        'radio',
				choices:     data.topBarJustifyContentChoices,
			}) );
		});

		// Handle visibility of the top bar controls.
		util.bindSettingToControls( 'sidebars_widgets[top]', [ 'top_bar_justify_content', 'sticky_top_bar', 'top_bar_text_color', 'top_bar_link_color', 'top_bar_background_color' ], ( value, control ) => {
			control.active.set( !! value.length );
		});
	});

} )( window.wp, window.themeTopBarControlsData );
