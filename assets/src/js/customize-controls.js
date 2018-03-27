/**
 * File customize-controls.js.
 *
 * Theme Customizer handling for the interface.
 */

( function() {

	wp.customize.bind( 'ready', function() {
		function updateAvailableWidgets( collection, expanded ) {
			collection.each( function( widget ) {
				if ( widget && ! themeCustomizeData.inlineWidgets.includes( widget.get( 'id_base' ) ) ) {
					widget.set( 'is_disabled', expanded );
				}
			});
		}

		if ( themeCustomizeData.inlineSidebars.length ) {
			wp.customize.section.each( function( section ) {
				if ( 'sidebar' !== section.params.type ) {
					return;
				}

				if ( ! themeCustomizeData.inlineSidebars.includes( section.params.sidebarId ) ) {
					return;
				}

				section.expanded.bind( function( expanded ) {
					updateAvailableWidgets(
						wp.customize.Widgets.availableWidgetsPanel.collection,
						expanded
					);
				});
			});
		}

		// Only show sidebar-related controls if a sidebar is enabled.
		wp.customize( 'sidebar_mode', function( setting ) {
			var toggleVisibility = function( control ) {
				var visibility = function() {
					if ( 'no-sidebar' === setting.get() ) {
						control.container.slideUp( 180 );
					} else {
						control.container.slideDown( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			};

			wp.customize.control( 'sidebar_size', toggleVisibility );
			wp.customize.control( 'blog_sidebar_enabled', toggleVisibility );
		});

		// Show sidebar section that is enabled.
		wp.customize( 'blog_sidebar_enabled', function( setting ) {
			var toggleActive = function( section ) {
				var active = function() {
					if ( setting.get() ) {
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
				};

				setting.bind( active );
			};

			wp.customize.section( 'sidebar-widgets-primary', toggleActive );
			wp.customize.section( 'sidebar-widgets-blog', toggleActive );
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
						message: themeCustomizeData.i18n.blogSidebarEnabledNotice,
					}) );
				}
			};
		});
	});
} )();
