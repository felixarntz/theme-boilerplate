/**
 * File colors.customize-controls.js.
 *
 * Theme Customizer handling for color controls.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';
import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api              = wp.customize;
	const util             = new CustomizeControlsUtil( api );
	const hasWrappedLayout = new api.Value( false );
	const hasCustomHeader  = new api.Value( false );
	const hasPageHeader    = new api.Value( false );
	const hasFooterWidgets = new api.Value( false );
	const hasFooterMenus   = new api.Value( false );

	api.bind( 'ready', () => {

		api.panel.instance( 'colors', panel => {
			const customizeAction = getCustomizeAction( panel.id );

			data.groups.forEach( group => {
				if ( api.section.instance( group.id ) ) {
					return;
				}

				api.section.add( new api.Section( group.id, {
					panel:           panel.id,
					title:           group.title,
					customizeAction: customizeAction,
				}) );
			});

			data.colors.forEach( color => {
				if ( color.live_preview ) {
					api.instance( color.id, setting => {
						setting.transport = 'postMessage';
					});
				}

				api.control.add( new api.ColorControl( color.id, {
					setting: color.id,
					section: color.group,
					label:   color.title,
					type:    'color',
				}) );
			});
		});

		// Handle the hasWrappedLayout value.
		api.previewer.bind( 'hasWrappedLayout', value => {
			hasWrappedLayout.set( value );
		});

		// Handle the hasCustomHeader value.
		util.bindSettings( [ 'header_image', 'header_video', 'external_header_video' ], values => {
			hasCustomHeader.set( !! ( values.header_image && values.header_image.length && 'remove-header' !== values.header_image || values.header_video && values.header_video.length || values.external_header_video && values.external_header_video.length ) );
		});

		// Handle the hasPageHeader value.
		api.previewer.bind( 'hasPageHeader', value => {
			hasPageHeader.set( value );
		});

		// Handle the hasFooterWidgets value.
		util.bindSettings( data.footerWidgetAreas.map( widgetArea => 'sidebars_widgets[' + widgetArea + ']' ), values => {
			const areasWithWidgets = Object.values( values ).filter( widgets => !! widgets.length );

			hasFooterWidgets.set( !! areasWithWidgets.length );
		});

		// Handle the hasFooterMenus value.
		util.bindSettings( [ 'nav_menu_locations[social]', 'nav_menu_locations[footer]' ], values => {
			const locationsWithMenu = Object.values( values ).filter( menuId => !! menuId );

			hasFooterMenus.set( !! locationsWithMenu.length );
		});

		// Handle visibility of the wrap background color control.
		api.control.instance( 'wrap_background_color', control => {
			function updateWrapBackgroundColorActive() {
				control.active.set( hasWrappedLayout.get() );
			}
			updateWrapBackgroundColorActive();
			hasWrappedLayout.bind( updateWrapBackgroundColorActive );
		});

		// Handle visibility of the header background color control.
		api.control.instance( 'header_background_color', control => {
			function updateHeaderBackgroundColorActive() {
				control.active.set( ! hasCustomHeader.get() && ! hasPageHeader.get() );
			}
			updateHeaderBackgroundColorActive();
			hasCustomHeader.bind( updateHeaderBackgroundColorActive );
			hasPageHeader.bind( updateHeaderBackgroundColorActive );
		});

		// Handle visibility of the footer color controls.
		api.control.instance( 'footer_text_color', 'footer_link_color', 'footer_background_color', function() {
			const controls = Array.prototype.slice.call( arguments, 0, 3 );

			function updateFooterColorsActive() {
				const value = hasFooterWidgets.get() || hasFooterMenus.get();

				controls.forEach( control => {
					control.active.set( value );
				});
			}

			updateFooterColorsActive();
			hasFooterWidgets.bind( updateFooterColorsActive );
			hasFooterMenus.bind( updateFooterColorsActive );
		});
	});

} )( window.wp, window.themeColorsControlsData );
