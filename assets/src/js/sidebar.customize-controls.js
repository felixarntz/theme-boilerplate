/**
 * File sidebar.customize-controls.js.
 *
 * Theme Customizer handling for the sidebar.
 */

import CustomizeControlsUtil from './customize/customize-controls-util';
import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api    = wp.customize;
	const util   = new CustomizeControlsUtil( api );
	const { __ } = wp.i18n;

	api.bind( 'ready', () => {
		api.when( 'sidebar_mode', 'sidebar_size', 'blog_sidebar_enabled', ( sidebarMode, sidebarSize, blogSidebarEnabled ) => {
			sidebarMode.transport        = 'postMessage';
			sidebarSize.transport        = 'postMessage';
			blogSidebarEnabled.transport = 'postMessage';
		});

		api.panel.instance( 'layout', () => {
			api.section.add( new api.Section( 'sidebar', {
				panel:           'layout',
				title:           __( 'Sidebar', 'super-awesome-theme' ),
				customizeAction: getCustomizeAction( 'layout' ),
			}) );

			api.control.add( new api.Control( 'sidebar_mode', {
				setting:     'sidebar_mode',
				section:     'sidebar',
				label:       __( 'Sidebar Mode', 'super-awesome-theme' ),
				description: __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
				type:        'radio',
				choices:     data.sidebarModeChoices,
			}) );

			api.control.add( new api.Control( 'sidebar_size', {
				setting:     'sidebar_size',
				section:     'sidebar',
				label:       __( 'Sidebar Size', 'super-awesome-theme' ),
				description: __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
				type:        'radio',
				choices:     data.sidebarSizeChoices,
			}) );

			api.control.add( new api.Control( 'blog_sidebar_enabled', {
				setting:     'blog_sidebar_enabled',
				section:     'sidebar',
				label:       __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
				description: __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
				type:        'checkbox',
			}) );
		});

		// Handle visibility of the sidebar controls.
		util.bindSettingToControls( 'sidebar_mode', [ 'sidebar_size', 'blog_sidebar_enabled' ], ( value, control ) => {
			control.active.set( 'no_sidebar' !== value );
		});

		// Handle visibility of the actual sidebar widget area controls.
		util.bindSettingToSections( 'blog_sidebar_enabled', [ 'sidebar-widgets-primary', 'sidebar-widgets-blog' ], ( value, section ) => {
			if ( !! value === ( 'blog' === section.params.sidebarId ) ) {
				section.activate();
				return;
			}

			section.deactivate();
		});

		// Show a notification for the blog sidebar instead of hiding it.
		api.control( 'blog_sidebar_enabled', function( control ) {
			const origOnChangeActive = control.onChangeActive;
			let hasNotification      = false;

			control.onChangeActive = function( active ) {
				var noticeCode = 'blog_sidebar_not_available';

				if ( active ) {
					if ( hasNotification ) {
						hasNotification = false;
						control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', false );
						control.container.find( '.description' ).slideDown( 180 );
						control.notifications.remove( noticeCode );
					}

					origOnChangeActive.apply( this, arguments );
				} else {
					if ( 'no_sidebar' === api.instance( 'sidebar_mode' ).get() ) {
						origOnChangeActive.apply( this, arguments );
						return;
					}

					hasNotification = true;
					control.container.find( 'input[type="checkbox"]' ).prop( 'disabled', true );
					control.container.find( '.description' ).slideUp( 180 );
					control.notifications.add( noticeCode, new api.Notification( noticeCode, {
						type: 'info',
						message: __( 'This page doesn&#8217;t support the blog sidebar. Navigate to the blog page or another page that supports it.', 'super-awesome-theme' ),
					}) );
				}
			};
		});
	});

} )( window.wp, window.themeSidebarControlsData );
