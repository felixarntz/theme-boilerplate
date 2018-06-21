/**
 * File bottom-bar.customize-controls.js.
 *
 * Theme Customizer handling for the bottom bar.
 */

import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api    = wp.customize;
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'bottom_bar_justify_content', ( bottomBarJustifyContent ) => {
			bottomBarJustifyContent.transport = 'postMessage';
		});

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'bottom_bar', {
				panel:           'layout',
				title:           __( 'Bottom Bar', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			api.control.add( new api.Control( 'bottom_bar_justify_content', {
				setting:     'bottom_bar_justify_content',
				section:     'bottom_bar',
				label:       __( 'Bottom Bar Justify Content', 'super-awesome-theme' ),
				description: __( 'Specify how the content in the bottom bar is aligned.', 'super-awesome-theme' ),
				type:        'radio',
				choices:     data.bottomBarJustifyContentChoices,
			}) );
		});
	});

} )( window.wp, window.themeBottomBarControlsData );
