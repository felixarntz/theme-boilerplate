/**
 * File custom-header.customize-preview.js.
 *
 * Theme Customizer handling for Custom Header preview.
 */

import CustomizeUtil from './customize/customize-util';

( ( wp, data ) => {
	const customizeUtil = new CustomizeUtil( wp.customize );

	customizeUtil.bindSettingValue( 'header_textcolor', value => {
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

	customizeUtil.bindSettingValue( 'header_textalign', value => {
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
