/**
 * File customize-preview-util.js.
 *
 * Class containing Customizer preview utility methods.
 */

import findParent from '../common/find-parent';

class CustomizePreviewUtil {
	constructor( wpCustomize ) {
		this.customizer = wpCustomize || window.wp.customize;
	}

	bindSetting( settingId, callback ) {
		this.customizer( settingId, setting => {
			setting.bind( callback );
		});
	}

	providePostPartial( selectiveRefresh, partialName ) {
		selectiveRefresh.partialConstructor[ partialName ] = selectiveRefresh.Partial.extend({
			placements: function() {
				var partial = this, selector;

				selector = partial.params.selector || '';
				if ( selector ) {
					selector += ', ';
				}
				selector += '[data-customize-partial-id="' + partial.id + '"]';

				return Array.from( document.querySelectorAll( selector ) ).map( element => {
					return new selectiveRefresh.Placement({
						partial: partial,
						container: element,
						context: {
							post_id: parseInt( findParent( element, 'article.hentry' ).id.replace( 'post-', '' ), 10 ),
						},
					});
				});
			},
		});
	}
}

export default CustomizePreviewUtil;
