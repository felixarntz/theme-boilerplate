/**
 * File navbar.customize-controls.js.
 *
 * Theme Customizer handling for the navbar.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';
import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api    = wp.customize;
	const util   = new CustomizeControlsUtil( api );
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'navbar_position', 'navbar_justify_content', ( navbarPosition, navbarJustifyContent ) => {
			navbarPosition.transport       = 'postMessage';
			navbarJustifyContent.transport = 'postMessage';
		});

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'navbar', {
				panel:           'layout',
				title:           __( 'Navbar', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			api.control.add( new api.Control( 'navbar_position', {
				setting: 'navbar_position',
				section: 'navbar',
				label:   __( 'Navbar Position', 'super-awesome-theme' ),
				type:    'radio',
				choices: data.navbarPositionChoices,
			}) );

			api.control.add( new api.Control( 'navbar_justify_content', {
				setting:     'navbar_justify_content',
				section:     'navbar',
				label:       __( 'Navbar Justify Content', 'super-awesome-theme' ),
				description: __( 'Specify how the content in the navbar is aligned.', 'super-awesome-theme' ),
				type:        'radio',
				choices:     data.navbarJustifyContentChoices,
			}) );
		});

		// Handle visibility of the sticky navbar control.
		util.bindSettingToControls( 'navbar_position', [ 'sticky_navbar' ], ( value, control ) => {
			const isSide = [ 'left', 'right' ].includes( value );

			control.active.set( ! isSide );

			// If navbar is displayed on the side, also force the sticky navbar setting to change.
			if ( isSide ) {
				api.instance( 'sticky_navbar', setting => {
					setting.set( false );
				});
			}
		});
	});

} )( window.wp, window.themeNavbarControlsData );
