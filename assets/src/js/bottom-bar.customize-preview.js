/**
 * File bottom-bar.customize-preview.js.
 *
 * Theme Customizer handling for bottom bar preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	util.bindSetting( 'bottom_bar_justify_content', value => {
		const classes   = Object.keys( data.bottomBarJustifyContentChoices );
		const index     = classes.indexOf( value );
		const bottomBar = document.getElementById( 'site-bottom-bar' );

		if ( bottomBar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => bottomBar.classList.remove( cssClass ) );
			bottomBar.classList.add( value );
		}
	});

})( window.wp, window.themeBottomBarPreviewData );
