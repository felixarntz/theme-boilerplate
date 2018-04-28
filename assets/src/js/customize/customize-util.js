/**
 * File customize-util.js.
 *
 * Class containing Customizer utility methods.
 */

class CustomizeUtil {
	constructor( wpCustomize ) {
		this.customizer = wpCustomize || window.wp.customize;
	}

	bindSettingValue( id, callback ) {
		this.customizer( id, setting => {
			setting.bind( callback );
		});
	}

	bindSettingValueToPanels( id, panelIds, callback ) {
		this.bindSettingValueToComponents( id, panelIds, callback, 'panel' );
	}

	bindSettingValueToSections( id, sectionIds, callback ) {
		this.bindSettingValueToComponents( id, sectionIds, callback, 'section' );
	}

	bindSettingValueToControls( id, controlIds, callback ) {
		this.bindSettingValueToComponents( id, controlIds, callback, 'control' );
	}

	bindSettingValueToComponents( id, componentIds, callback, componentType ) {
		const customizer = this.customizer;

		componentType = componentType || 'control';

		this.customizer( id, setting => {
			function bindComponent( component ) {
				callback( setting.get(), component );
				setting.bind( () => {
					callback( setting.get(), component );
				});
			}

			componentIds.forEach( componentId => {
				customizer[ componentType ]( componentId, bindComponent );
			});
		});
	}
}

export default CustomizeUtil;
