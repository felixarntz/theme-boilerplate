/**
 * File sidebar.customize-preview.js.
 *
 * Theme Customizer handling for sidebar preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	util.bindSetting( 'sidebar_mode', value => {
		const classes = Object.keys( data.sidebarModeChoices ).map( setting => setting.replace( '_', '-' ) );
		const index   = classes.indexOf( value.replace( '_', '-' ) );

		value = value.replace( '_', '-' );

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

	util.bindSetting( 'sidebar_size', value => {
		const classes = Object.keys( data.sidebarSizeChoices ).map( setting => 'sidebar-' + setting );
		const index   = classes.indexOf( 'sidebar-' + value );

		value = 'sidebar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

})( window.wp, window.themeSidebarPreviewData );
