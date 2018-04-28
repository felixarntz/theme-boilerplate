/**
 * File customize-controls.js.
 *
 * Theme Customizer handling for the interface.
 */

( ( wp, data ) => {

	function updateAvailableWidgets( collection, expanded ) {
		collection.each( widget => {
			if ( widget && ! data.inlineWidgets.includes( widget.get( 'id_base' ) ) ) {
				widget.set( 'is_disabled', expanded );
			}
		});
	}

	function bindCustomizerValueToSections( id, sections, callback ) {
		wp.customize( id, setting => {
			function bindSection( section ) {
				callback( setting.get(), section );
				setting.bind( () => {
					callback( setting.get(), section );
				});
			}

			sections.forEach( section => {
				wp.customize.section( section, bindSection );
			});
		});
	}

	function bindCustomizerValueToControls( id, controls, callback ) {
		wp.customize( id, setting => {
			function bindControl( control ) {
				callback( setting.get(), control );
				setting.bind( () => {
					callback( setting.get(), control );
				});
			}

			controls.forEach( control => {
				wp.customize.control( control, bindControl );
			});
		});
	}

	wp.customize.bind( 'ready', () => {
		if ( data.inlineSidebars.length ) {
			wp.customize.section.each( section => {
				if ( 'sidebar' !== section.params.type ) {
					return;
				}

				if ( ! data.inlineSidebars.includes( section.params.sidebarId ) ) {
					return;
				}

				section.expanded.bind( expanded => {
					updateAvailableWidgets(
						wp.customize.Widgets.availableWidgetsPanel.collection,
						expanded
					);
				});
			});
		}

		// Only show sidebar-related controls if a sidebar is enabled.
		bindCustomizerValueToControls( 'sidebar_mode', [ 'sidebar_size', 'blog_sidebar_enabled' ], ( value, control ) => {
			if ( 'no-sidebar' === value ) {
				control.container.slideUp( 180 );
			} else {
				control.container.slideDown( 180 );
			}
		});

		// Show sidebar section that is enabled.
		bindCustomizerValueToSections( 'blog_sidebar_enabled', [ 'sidebar-widgets-primary', 'sidebar-widgets-blog' ], ( value, section ) => {
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
		wp.customize.control( 'blog_sidebar_enabled', function( control ) {
			control.onChangeActive = function( active ) {
				var noticeCode = 'blog_sidebar_not_available';

				if ( active ) {
					control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', false );
					control.container.find( '.description' ).slideDown( 180 );
					control.notifications.remove( noticeCode );
				} else {
					control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', true );
					control.container.find( '.description' ).slideUp( 180 );
					control.notifications.add( noticeCode, new wp.customize.Notification( noticeCode, {
						type: 'info',
						message: data.i18n.blogSidebarEnabledNotice,
					}) );
				}
			};
		});
	});
} )( window.wp, window.themeCustomizeData );
