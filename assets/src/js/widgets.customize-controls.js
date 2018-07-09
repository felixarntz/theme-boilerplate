/**
 * File widgets.customize-controls.js.
 *
 * Theme Customizer handling for widget controls.
 */

( ( wp, data ) => {
	const api            = wp.customize;
	const { _x }         = wp.i18n;
	const style          = document.createElement( 'style' );
	const widgetUntested = document.createElement( 'div' );

	style.type        = 'text/css';
	style.textContent = '#available-widgets .widget-tpl.widget-tpl-inline-untested { background: #fafafa; border-left-color: #fafafa } .widget-tpl-inline-untested > .widget { opacity: 0.7; } .widget-tpl-notice { margin: 5px 0 0; }';

	widgetUntested.classList.add( 'widget-tpl-notice', 'notice', 'notice-warning' );
	widgetUntested.textContent = _x( 'Untested with this widget area.', 'widget notice', 'super-awesome-theme' );

	document.head.appendChild( style );

	function markUntestedWidgets( collection, expanded ) {
		collection.each( widget => {
			const widgetTpl       = document.querySelector( '#widget-tpl-' + widget.id );
			const widgetTplNotice = widgetTpl.querySelector( '.widget-tpl-notice' );

			if ( widget && ! data.inlineWidgets.includes( widget.get( 'id_base' ) ) ) {
				if ( expanded ) {
					widgetTpl.classList.add( 'widget-tpl-inline-untested' );
					if ( ! widgetTplNotice ) {
						widgetTpl.appendChild( widgetUntested.cloneNode( true ) );
					}
					return;
				}

				widgetTpl.classList.remove( 'widget-tpl-inline-untested' );
				if ( widgetTplNotice ) {
					widgetTpl.removeChild( widgetTplNotice );
				}
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
					markUntestedWidgets(
						api.Widgets.availableWidgetsPanel.collection,
						expanded
					);
				});

				api.instance( 'sidebars_widgets[' + section.params.sidebarId + ']', setting => {
					let hasNotification = false;

					function checkInlineWidgets() {
						const noticeCode      = 'inline_contains_untested_widgets';
						const widgets         = setting.get();
						let needsNotification = false;

						widgets.forEach( widgetId => {
							if ( ! data.inlineWidgets.includes( widgetId.replace( /-(\d+)$/, '' ) ) ) {
								needsNotification = true;
							}
						});

						if ( needsNotification && ! hasNotification ) {
							hasNotification = true;
							section.notifications.add( noticeCode, new api.Notification( noticeCode, {
								type: 'warning',
								message: _x( 'This inline widget area contains widgets that are untested with it and thus may display incorrectly.', 'widget notice', 'super-awesome-theme' ),
							}) );
							return;
						}

						if ( ! needsNotification && hasNotification ) {
							hasNotification = false;
							section.notifications.remove( noticeCode );
						}
					}

					checkInlineWidgets();
					setting.bind( checkInlineWidgets );
				});
			});
		}
	});

} )( window.wp, window.themeWidgetsControlsData );
