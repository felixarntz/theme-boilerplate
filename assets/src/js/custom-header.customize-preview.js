/**
 * File custom-header.customize-preview.js.
 *
 * Theme Customizer handling for Custom Header preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	util.bindSetting( 'header_textcolor', value => {
		if ( 'blank' === value ) {
			Array.from( document.querySelectorAll( '.site-title, .site-description' ) ).forEach( element => {
				element.style.setProperty( 'clip', 'rect(1px, 1px, 1px, 1px)' );
				element.style.setProperty( 'position', 'absolute' );
			});
		} else {
			Array.from( document.querySelectorAll( '.site-title, .site-description' ) ).forEach( element => {
				element.style.setProperty( 'clip', 'auto' );
				element.style.setProperty( 'position', 'relative' );
			});
			Array.from( document.querySelectorAll( '.site-title a, .site-description' ) ).forEach( element => {
				element.style.setProperty( 'color', value );
			});
		}
	});

	util.bindSetting( 'header_textalign', value => {
		const classes = Object.keys( data.headerTextalignChoices );
		const index   = classes.indexOf( value );
		const header  = document.querySelector( '.site-custom-header' );

		if ( header && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => header.classList.remove( cssClass ) );
			header.classList.add( value );
		}
	});

})( window.wp, window.themeCustomHeaderPreviewData );
