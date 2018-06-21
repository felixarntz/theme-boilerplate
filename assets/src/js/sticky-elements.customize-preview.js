/**
 * File sticky-elements.customize-preview.js.
 *
 * Theme Customizer handling for sticky element preview.
 */

import CustomizePreviewUtil from './customize/customize-preview-util';

( ( wp, data ) => {
	const api  = wp.customize;
	const util = new CustomizePreviewUtil( api );

	data.stickyElements.forEach( sticky => {
		util.bindSetting( sticky.setting, value => {
			if ( ! window.themeData ) {
				return;
			}

			window.themeData.components.sticky.addRemoveStickyContainer( sticky.selector, sticky.location, ! value );
		});
	});

})( window.wp, window.themeStickyElementsPreviewData );
