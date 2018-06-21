/**
 * File navbar.customize-preview.js.
 *
 * Theme Customizer handling for navbar preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	function replaceNavbarClasses( navbar, isSide ) {
		const navbarExtra = navbar.querySelector( '#site-navigation-extra' );
		const addRemove   = isSide ? 'remove' : 'add';
		const widgetClass = isSide ? '.widget' : '.inline-widget';

		navbar.classList[ addRemove ]( 'is-flex' );

		if ( ! navbarExtra ) {
			return;
		}

		navbarExtra.classList[ addRemove ]( 'inline-widget-area' );
		navbarExtra.querySelectorAll( '.widget' === widgetClass ? '.inline-widget' : '.widget' ).forEach( widget => {
			widget.classList.remove( '.widget' === widgetClass ? 'inline-widget' : 'widget' );
			widget.classList.add( widgetClass );
		});
	}

	util.bindSetting( 'navbar_position', value => {
		const classes     = Object.keys( data.navbarPositionChoices ).map( setting => 'navbar-' + setting );
		const index       = classes.indexOf( 'navbar-' + value );
		const navbar      = document.querySelector( '#site-navbar' );

		value = 'navbar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );

			if ( ! navbar ) {
				return;
			}

			if ( [ 'navbar-left', 'navbar-right' ].includes( value ) ) {
				replaceNavbarClasses( navbar, true );
				return;
			}

			replaceNavbarClasses( navbar, false );
		}
	});

	util.bindSetting( 'navbar_justify_content', value => {
		const classes = Object.keys( data.navbarJustifyContentChoices );
		const index   = classes.indexOf( value );
		const navbar  = document.querySelector( '#site-navbar' );

		if ( navbar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => navbar.classList.remove( cssClass ) );
			navbar.classList.add( value );
		}
	});

})( window.wp, window.themeNavbarPreviewData );
