/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	function getCurrentPostType() {
		const matches = document.body.getAttribute( 'class' ).match( /is-post-type-([a-z0-9-_]+)/ );

		if ( ! matches ) {
			return '';
		}

		return matches[1];
	}

	api.bind( 'preview-ready', () => {
		api.preview.bind( 'active', () => {
			api.preview.send( 'currentPostType', getCurrentPostType() );
			api.preview.send( 'hasPageHeader', document.body.classList.contains( 'has-page-header' ) );
		});
	});

	util.providePostPartial( api.selectiveRefresh, 'SuperAwesomeThemePostPartial' );
})( window.wp );
