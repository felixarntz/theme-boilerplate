/**
 * File footer-widget-areas.customize-controls.js.
 *
 * Theme Customizer handling for the footer widget areas.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';
import getCustomizeAction from './customize/get-customize-action';

( ( wp, data, _ ) => {
	const api    = wp.customize;
	const util   = new CustomizeControlsUtil( api );
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'wide_footer_widget_area', ( wideFooterWidgetArea ) => {
			wideFooterWidgetArea.transport = 'postMessage';
		});

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'footer_widgets', {
				panel:           'layout',
				title:           __( 'Footer Widgets', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			api.control.add( new api.Control( 'wide_footer_widget_area', {
				setting:     'wide_footer_widget_area',
				section:     'footer_widgets',
				label:       __( 'Wide Footer Column', 'super-awesome-theme' ),
				description: __( 'If you like to reserve more space for one of your footer widget columns, you can select that one here.', 'super-awesome-theme' ),
				type:        'select',
				choices:     _.extend( {}, data.wideFooterWidgetAreaChoices ),
			}) );
		});

		// Handle visibility of the wide footer widget area control.
		util.bindSettingsToControls( data.footerWidgetAreas.map( widgetArea => 'sidebars_widgets[' + widgetArea + ']' ), [ 'wide_footer_widget_area' ], ( values, control ) => {
			let currentValue   = control.setting.get();
			let hasWidgets     = false;
			let newChoices     = _.extend( {}, data.wideFooterWidgetAreaChoices );
			let newChoicesHtml = [];

			_.each( values, ( value, settingId ) => {
				const widgetAreaId = settingId.replace( 'sidebars_widgets[', '' ).replace( ']', '' );

				if ( value.length ) {
					hasWidgets = true;
					return;
				}

				if ( ! newChoices[ widgetAreaId ] ) {
					return;
				}

				delete newChoices[ widgetAreaId ];
			});

			if ( ! newChoices[ currentValue ] ) {
				currentValue = Object.keys( newChoices )[0];
				control.setting.set( currentValue );
			}

			_.each( newChoices, ( label, value ) => {
				newChoicesHtml.push( '<option value="' + value + '"' + ( currentValue === value ? ' selected="selected"' : '' ) + '>' + label + '</option>' );
			});

			control.active.set( hasWidgets );
			control.params.choices = newChoices;
			control.container.find( 'select' ).html( newChoicesHtml.join( '' ) );
		});
	});

} )( window.wp, window.themeFooterWidgetAreasControlsData, window._ );
