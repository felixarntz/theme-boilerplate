/**
 * File top-bar.customize-preview.js.
 *
 * Theme Customizer handling for top bar preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	util.bindSetting( 'top_bar_justify_content', value => {
		const classes = Object.keys( data.topBarJustifyContentChoices );
		const index   = classes.indexOf( value );
		const topBar  = document.getElementById( 'site-top-bar' );

		if ( topBar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => topBar.classList.remove( cssClass ) );
			topBar.classList.add( value );
		}
	});

})( window.wp, window.themeTopBarPreviewData );
