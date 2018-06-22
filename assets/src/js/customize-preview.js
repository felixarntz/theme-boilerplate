/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';
import { findParent } from './common/utils';

( ( wp ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

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
})( window.wp );
