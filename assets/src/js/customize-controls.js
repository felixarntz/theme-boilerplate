/**
 * File customize-controls.js.
 *
 * Theme Customizer handling for the interface.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizeControlsUtil( api );

	data = data || {};

	function updateAvailableWidgets( collection, expanded ) {
		collection.each( widget => {
			if ( widget && ! data.inlineWidgets.includes( widget.get( 'id_base' ) ) ) {
				widget.set( 'is_disabled', expanded );
			}
		});
	}

	api.bind( 'ready', () => {
		if ( data.inlineWidgetAreas.length ) {
			api.section.each( section => {
				if ( 'sidebar' !== section.params.type ) {
					return;
				}

				if ( ! data.inlineWidgetAreas.includes( section.params.sidebarId ) ) {
					return;
				}

				section.expanded.bind( expanded => {
					updateAvailableWidgets(
						api.Widgets.availableWidgetsPanel.collection,
						expanded
					);
				});
			});
		}

		// Only show sidebar-related controls if a sidebar is enabled.
		util.bindSettingToControls( 'sidebar_mode', [ 'sidebar_size', 'blog_sidebar_enabled' ], ( value, control ) => {
			if ( 'no_sidebar' === value ) {
				control.container.slideUp( 180 );
			} else {
				control.container.slideDown( 180 );
			}
		});

		// Show sidebar section that is enabled.
		util.bindSettingToSections( 'blog_sidebar_enabled', [ 'sidebar-widgets-primary', 'sidebar-widgets-blog' ], ( value, section ) => {
			if ( value ) {
				if ( 'blog' === section.params.sidebarId ) {
					section.activate();
				} else {
					section.deactivate();
				}
			} else {
				if ( 'blog' === section.params.sidebarId ) {
					section.deactivate();
				} else {
					section.activate();
				}
			}
		});

		// Disable blog sidebar enabled control when not active.
		api.control( 'blog_sidebar_enabled', function( control ) {
			control.onChangeActive = function( active ) {
				var noticeCode = 'blog_sidebar_not_available';

				if ( active ) {
					control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', false );
					control.container.find( '.description' ).slideDown( 180 );
					control.notifications.remove( noticeCode );
				} else {
					control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', true );
					control.container.find( '.description' ).slideUp( 180 );
					control.notifications.add( noticeCode, new api.Notification( noticeCode, {
						type: 'info',
						message: data.blogSidebarEnabledNotice,
					}) );
				}
			};
		});
	});

} )( window.wp, window.themeCustomizeData );
