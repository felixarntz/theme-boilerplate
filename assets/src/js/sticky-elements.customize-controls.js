/**
 * File sticky-elements.customize-controls.js.
 *
 * Theme Customizer handling for sticky element controls.
 */

import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api    = wp.customize;
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'sticky_elements', {
				panel:           'layout',
				title:           __( 'Sticky Content', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			data.stickyElements.forEach( sticky => {
				api.instance( sticky.setting, setting => {
					setting.transport = 'postMessage';
				});

				api.control.add( new api.Control( sticky.setting, {
					setting: sticky.setting,
					section: 'sticky_elements',
					label:   sticky.label,
					type:    'checkbox',
				}) );
			});
		});
	});

} )( window.wp, window.themeStickyElementsControlsData );
