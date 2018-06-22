/**
 * File footer-widget-areas.customize-preview.js.
 *
 * Theme Customizer handling for footer widget area preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	util.bindSetting( 'wide_footer_widget_area', value => {
		Array.from( document.querySelectorAll( '.footer-widget-column' ) ).forEach( element => {
			if ( value === element.id ) {
				element.classList.add( 'footer-widget-column-wide' );
			} else {
				element.classList.remove( 'footer-widget-column-wide' );
			}
		});
	});

})( window.wp );
