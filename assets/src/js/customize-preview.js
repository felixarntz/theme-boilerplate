/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	api.bind( 'preview-ready', () => {
		api.preview.bind( 'active', () => {
			api.preview.send( 'hasWrappedLayout', document.body.classList.contains( 'wrapped-layout' ) );
		});
	});

	// Site title.
	util.bindSetting( 'blogname', value => {
		Array.from( document.querySelectorAll( '.site-title a' ) ).forEach( element => {
			element.textContent = value;
		});
	});

	// Site description.
	util.bindSetting( 'blogdescription', value => {
		Array.from( document.querySelectorAll( '.site-description' ) ).forEach( element => {
			element.textContent = value;
		});
	});
})( window.wp );
