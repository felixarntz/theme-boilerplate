/**
 * File customize-preview-util.js.
 *
 * Class containing Customizer preview utility methods.
 */

class CustomizePreviewUtil {
	constructor( wpCustomize ) {
		this.customizer = wpCustomize || window.wp.customize;
	}

	bindSetting( settingId, callback ) {
		this.customizer( settingId, setting => {
			setting.bind( callback );
		});
	}
}

export default CustomizePreviewUtil;
