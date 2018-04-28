/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import { findParent } from './utils';

( ( wp, data ) => {

	function bindCustomizerValue( id, callback ) {
		wp.customize( id, setting => {
			setting.bind( callback );
		});
	}

	// Site title.
	bindCustomizerValue( 'blogname', value => {
		Array.from( document.querySelectorAll( '.site-title a' ) ).forEach( element => {
			element.textContent = value;
		});
	});

	// Site description.
	bindCustomizerValue( 'blogdescription', value => {
		Array.from( document.querySelectorAll( '.site-description' ) ).forEach( element => {
			element.textContent = value;
		});
	});

	// Header text color.
	bindCustomizerValue( 'header_textcolor', value => {
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

	// Header text align.
	bindCustomizerValue( 'header_textalign', value => {
		const classes = Object.keys( data.headerTextalignChoices );
		const index   = classes.indexOf( value );
		const header  = document.querySelector( '.site-custom-header' );

		if ( header && index > -1 ) {
			classes.splice( index, 1 );

			header.classList.remove.apply( undefined, classes );
			header.classList.add( value );
		}
	});

	// Sidebar mode.
	bindCustomizerValue( 'sidebar_mode', value => {
		const classes = Object.keys( data.sidebarModeChoices );
		const index   = classes.indexOf( value );

		if ( index > -1 ) {
			classes.splice( index, 1 );

			document.body.classList.remove.apply( undefined, classes );
			document.body.classList.add( value );
		}
	});

	// Sidebar size.
	bindCustomizerValue( 'sidebar_size', value => {
		const classes = Object.keys( data.sidebarSizeChoices ).map( setting => 'sidebar-' + setting );
		const index   = classes.indexOf( 'sidebar-' + value );

		value = 'sidebar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );

			document.body.classList.remove.apply( undefined, classes );
			document.body.classList.add( value );
		}
	});

	// Top Bar Justify Content.
	bindCustomizerValue( 'top_bar_justify_content', value => {
		const classes = Object.keys( data.barJustifyContentChoices );
		const index   = classes.indexOf( value );
		const topBar  = document.getElementById( 'site-top-bar' );

		if ( topBar && index > -1 ) {
			classes.splice( index, 1 );

			topBar.classList.remove.apply( undefined, classes );
			topBar.classList.add( value );
		}
	});

	// Bottom Bar Justify Content.
	bindCustomizerValue( 'bottom_bar_justify_content', value => {
		const classes   = Object.keys( data.barJustifyContentChoices );
		const index     = classes.indexOf( value );
		const bottomBar = document.getElementById( 'site-bottom-bar' );

		if ( bottomBar && index > -1 ) {
			classes.splice( index, 1 );

			bottomBar.classList.remove.apply( undefined, classes );
			bottomBar.classList.add( value );
		}
	});

	// Wide footer widget area.
	bindCustomizerValue( 'wide_footer_widget_area', value => {
		Array.from( document.querySelectorAll( '.footer-widget-column' ) ).forEach( element => {
			if ( 'footer-widget-column-' + value === element.id ) {
				element.classList.add( 'footer-widget-column-wide' );
			} else {
				element.classList.remove( 'footer-widget-column-wide' );
			}
		});
	});

	wp.customize.selectiveRefresh.partialConstructor.SuperAwesomeThemePostPartial = wp.customize.selectiveRefresh.Partial.extend({
		placements: () => {
			var partial = this, selector;

			selector = partial.params.selector || '';
			if ( selector ) {
				selector += ', ';
			}
			selector += '[data-customize-partial-id="' + partial.id + '"]';

			return Array.from( document.querySelectorAll( selector ) ).map( element => {
				return new wp.customize.selectiveRefresh.Placement({
					partial: partial,
					container: element,
					context: {
						post_id: parseInt( findParent( element, 'article.hentry' ).id.replace( 'post-', '' ), 10 ),
					},
				});
			});
		},
	});
})( window.wp, window.themeCustomizeData );
