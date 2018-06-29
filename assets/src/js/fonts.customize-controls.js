/**
 * File fonts.customize-controls.js.
 *
 * Theme Customizer handling for font controls.
 */

import getCustomizeAction from './customize/get-customize-action';

( ( wp, data, _, $ ) => {
	const api = wp.customize;

	api.SuperAwesomeThemeFontControl = api.Control.extend({
		ready: function() {
			const value         = this.setting.get();
			const $familySelect = this.container.find( '[data-setting-property="family"]' );
			const $weightSelect = this.container.find( '[data-setting-property="weight"]' );
			const $sizeInput    = this.container.find( '[data-setting-property="size"]' );

			this.initializeFontFamilySelect( $familySelect );
			this.initializeFontWeightSelect( $weightSelect );

			if ( value.family && value.family.length ) {
				$familySelect.val( value.family ).trigger( 'change' );
			}

			if ( value.weight && value.weight.length ) {
				$weightSelect.val( value.weight ).trigger( 'change' );
			}

			if ( value.size ) {
				$sizeInput.val( value.size ).trigger( 'change' );
			}

			$familySelect.on( 'change', () => {
				this.saveValue( 'family', $familySelect.val() );
			});

			$weightSelect.on( 'change', () => {
				this.saveValue( 'weight', $weightSelect.val() );
			});

			$sizeInput.on( 'change input', () => {
				this.saveValue( 'size', $sizeInput.val() );
			});
		},

		saveValue: function( prop, propVal ) {
			const value = _.clone( this.setting.get() );

			value[ prop ] = propVal;

			this.setting.set( value );
		},

		initializeFontFamilySelect: function( $element ) {
			const selectData   = {};
			const settingValue = this.setting.get();

			this.currentFontStack = '';

			data.fontFamilyGroups.forEach( group => {
				selectData[ group.id ] = {
					text:     group.label,
					children: [],
				};
			});

			data.fontFamilies.forEach( family => {
				if ( ! selectData[ family.group ] ) {
					return;
				}

				if ( settingValue === family.id ) {
					this.currentFontStack = family.stackString.replace( /"/g, '\'' );
				}

				selectData[ family.group ].children.push({
					id:        family.id,
					text:      family.label,
					fontStack: family.stackString.replace( /"/g, '\'' ),
				});
			});

			$element.selectWoo({
				data:           Object.values( selectData ),
				templateResult: state => {
					if ( ! state.id || ! state.fontStack ) {
						return state.text;
					}

					return $( '<span style="font-family:' + state.fontStack + ';">' + state.text + '</span>' );
				},
			});

			$element.on( 'select2:select', event => {
				if ( ! event.params.data.fontStack ) {
					return;
				}

				this.currentFontStack = event.params.data.fontStack;
			});
		},

		initializeFontWeightSelect: function( $element ) {
			const selectData = [];

			data.fontWeights.forEach( weight => {
				selectData.push({
					id:   weight.id,
					text: weight.label,
				});
			});

			$element.selectWoo({
				data:           selectData,
				templateResult: state => {
					if ( ! state.id ) {
						return state.text;
					}

					return $( '<span style="font-family:' + this.currentFontStack + ';font-weight:' + state.id + ';">' + state.text + '</span>' );
				},
			});
		},
	});

	api.bind( 'ready', () => {

		api.panel.instance( 'fonts', panel => {
			const customizeAction = getCustomizeAction( panel.id );

			data.groups.forEach( group => {
				if ( api.section.instance( group.id ) ) {
					return;
				}

				api.section.add( new api.Section( group.id, {
					panel:           panel.id,
					title:           group.title,
					customizeAction: customizeAction,
				}) );
			});

			data.fonts.forEach( font => {
				if ( font.live_preview ) {
					api.instance( font.id, setting => {
						setting.transport = 'postMessage';
					});
				}

				api.control.add( new api.SuperAwesomeThemeFontControl( font.id, {
					id:      font.id,
					setting: font.id,
					section: font.group,
					label:   font.title,
					type:    'super_awesome_theme_font',
				}) );
			});
		});
	});

} )( window.wp, window.themeFontsControlsData, window._, window.jQuery );
