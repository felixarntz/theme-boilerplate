/**
 * File customize-controls-util.js.
 *
 * Class containing Customizer controls utility methods.
 */

class CustomizeControlsUtil {
	constructor( wpCustomize ) {
		this.customizer = wpCustomize || window.wp.customize;
	}

	bindSetting( settingId, callback ) {
		this.customizer.instance( settingId, setting => {
			callback( setting.get() );
			setting.bind( () => {
				callback( setting.get() );
			});
		});
	}

	bindSettingToComponents( settingId, componentIds, callback, componentType ) {
		const self = this;

		componentType = componentType || 'control';

		function listenToSetting() {
			const components = Array.prototype.slice.call( arguments, 0, componentIds.length );

			self.bindSetting( settingId, value => {
				components.forEach( component => {
					callback( value, component );
				});
			});
		}

		this.customizer[ componentType ].instance.apply( this.customizer[ componentType ], componentIds.concat( [ listenToSetting ] ) );
	}

	bindSettingToPanels( settingId, panelIds, callback ) {
		this.bindSettingToComponents( settingId, panelIds, callback, 'panel' );
	}

	bindSettingToSections( settingId, sectionIds, callback ) {
		this.bindSettingToComponents( settingId, sectionIds, callback, 'section' );
	}

	bindSettingToControls( settingId, controlIds, callback ) {
		this.bindSettingToComponents( settingId, controlIds, callback, 'control' );
	}

	bindSettings( settingIds, callback ) {
		function bindSettings() {
			const settings = Array.prototype.slice.call( arguments, 0, settingIds.length );
			let values     = {};

			function updateSetting( setting ) {
				values[ setting.id ] = setting.get();
			}

			settings.forEach( setting => {
				updateSetting( setting );
				setting.bind( () => {
					updateSetting( setting );
					callback( values );
				});
			});

			callback( values );
		}

		this.customizer.instance.apply( this.customizer, settingIds.concat( [ bindSettings ] ) );
	}

	bindSettingsToComponents( settingIds, componentIds, callback, componentType ) {
		const self = this;

		componentType = componentType || 'control';

		function listenToSettings() {
			const components = Array.prototype.slice.call( arguments, 0, componentIds.length );

			self.bindSettings( settingIds, values => {
				components.forEach( component => {
					callback( values, component );
				});
			});
		}

		this.customizer[ componentType ].instance.apply( this.customizer[ componentType ], componentIds.concat( [ listenToSettings ] ) );
	}

	bindSettingsToPanels( settingIds, panelIds, callback ) {
		this.bindSettingsToComponents( settingIds, panelIds, callback, 'panel' );
	}

	bindSettingsToSections( settingIds, sectionIds, callback ) {
		this.bindSettingsToComponents( settingIds, sectionIds, callback, 'section' );
	}

	bindSettingsToControls( settingIds, controlIds, callback ) {
		this.bindSettingsToComponents( settingIds, controlIds, callback, 'control' );
	}
}

export default CustomizeControlsUtil;
