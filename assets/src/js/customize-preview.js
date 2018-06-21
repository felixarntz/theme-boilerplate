/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';
import { findParent } from './common/utils';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	data = data || {};

	api.bind( 'preview-ready', () => {
		api.preview.bind( 'active', () => {
			api.preview.send( 'hasWrappedLayout', document.body.classList.contains( 'wrapped-layout' ) );
			api.preview.send( 'hasPageHeader', document.body.classList.contains( 'has-page-header' ) );
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

	// Sidebar mode.
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

	// Sidebar size.
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

	// Navbar position.
	util.bindSetting( 'navbar_position', value => {
		const classes = Object.keys( data.navbarPositionChoices ).map( setting => 'navbar-' + setting );
		const index   = classes.indexOf( 'navbar-' + value );

		value = 'navbar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

	// Navbar Justify Content.
	util.bindSetting( 'navbar_justify_content', value => {
		const classes = Object.keys( data.navbarJustifyContentChoices );
		const index   = classes.indexOf( value );
		const navbar  = document.getElementById( 'site-navbar' );

		if ( navbar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => navbar.classList.remove( cssClass ) );
			navbar.classList.add( value );
		}
	});

	// Wide footer widget area.
	util.bindSetting( 'wide_footer_widget_area', value => {
		Array.from( document.querySelectorAll( '.footer-widget-column' ) ).forEach( element => {
			if ( value === element.id ) {
				element.classList.add( 'footer-widget-column-wide' );
			} else {
				element.classList.remove( 'footer-widget-column-wide' );
			}
		});
	});

	api.selectiveRefresh.partialConstructor.SuperAwesomeThemePostPartial = api.selectiveRefresh.Partial.extend({
		placements: function() {
			var partial = this, selector;

			selector = partial.params.selector || '';
			if ( selector ) {
				selector += ', ';
			}
			selector += '[data-customize-partial-id="' + partial.id + '"]';

			return Array.from( document.querySelectorAll( selector ) ).map( element => {
				return new api.selectiveRefresh.Placement({
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
