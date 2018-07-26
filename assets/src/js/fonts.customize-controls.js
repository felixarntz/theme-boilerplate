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

			this.currentFontStack   = new api.Value( '' );
			this.currentFontWeights = new api.Value( [ '400' ] );

			this.initializeFontFamilySelect( $familySelect );
			this.initializeFontWeightSelect( $weightSelect );

			this.currentFontWeights.bind( () => {
				const currentFontWeights = this.currentFontWeights.get();
				const settingValue       = this.setting.get();

				$weightSelect.selectWoo( 'destroy' );
				$weightSelect.html( '' );

				this.initializeFontWeightSelect( $weightSelect );

				if ( ! currentFontWeights.includes( '' + settingValue.weight ) ) {
					$weightSelect.val( currentFontWeights[0] ).trigger( 'change' );
				}
			});

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
			const includedData = {};
			const excludedData = {};
			const settingValue = this.setting.get();

			data.fontFamilyGroups.forEach( group => {
				selectData[ group.id ] = {
					id:       group.id,
					text:     group.label,
					children: [],
				};

				includedData[ group.id ] = {
					id:       group.id,
					text:     group.label,
					children: [],
				};

				excludedData[ group.id ] = {
					id:       group.id,
					text:     group.label,
					children: [],
				};
			});

			data.fontFamilies.forEach( family => {
				const dataset = {
					id:          family.id,
					text:        family.label,
					fontStack:   family.stackString.replace( /"/g, '\'' ),
					fontWeights: family.weights,
				};

				if ( family.api ) {
					dataset.fontApi = family.api;
				}

				if ( ! selectData[ family.group ] ) {
					return;
				}

				selectData[ family.group ].children.push( dataset );

				if ( settingValue.family === family.id ) {
					this.currentFontStack.set( family.stackString.replace( /"/g, '\'' ) );
					this.currentFontWeights.set( family.weights );
				}

				if ( settingValue.family === family.id || family.include ) {
					includedData[ family.group ].children.push( dataset );
					return;
				}

				excludedData[ family.group ].children.push( dataset );
			});

			$element.selectWoo({
				data:               Object.values( selectData ),
				matcher:            ( params, data ) => {
					const term       = $.trim( params.term );
					const regexp     = new RegExp( term, 'i' );
					let filteredData = {};

					if ( ! data.id || ! data.text || ! data.children ) {
						return null;
					}

					filteredData.id       = data.id;
					filteredData.text     = data.text;
					filteredData.children = [];

					if ( term.length > 3 ) {
						filteredData.children = filteredData.children.concat( includedData[ data.id ].children.filter( dataset => {
							return !! dataset.id.match( regexp );
						}) );
						filteredData.children = filteredData.children.concat( excludedData[ data.id ].children.filter( dataset => {
							return !! dataset.id.match( regexp );
						}) );
					} else {
						filteredData.children = filteredData.children.concat( includedData[ data.id ].children );
					}

					if ( ! filteredData.children.length ) {
						return null;
					}

					return filteredData;
				},
				templateResult:     state => {
					let extraIndicator = '';

					if ( ! state.id || ! state.fontStack ) {
						return state.text;
					}

					if ( state.fontApi && data.apis[ state.fontApi ] ) {
						extraIndicator += ' <small>(' + data.apis[ state.fontApi ] + ')</small>';
					}

					return $( '<span style="font-family:' + state.fontStack + ';">' + state.text + '</span>' + extraIndicator );
				},
			});

			$element.on( 'select2:select', event => {
				if ( ! event.params.data.fontStack ) {
					return;
				}

				this.currentFontStack.set( event.params.data.fontStack );
				this.currentFontWeights.set( event.params.data.fontWeights );
			});
		},

		initializeFontWeightSelect: function( $element ) {
			function getSelectData( currentFontWeights ) {
				const selectData = [];

				data.fontWeights.forEach( weight => {
					if ( ! currentFontWeights.includes( '' + weight.id ) ) {
						return;
					}

					selectData.push({
						id:   weight.id,
						text: weight.label,
					});
				});

				return selectData;
			}

			$element.selectWoo({
				data:           getSelectData( this.currentFontWeights.get() ),
				templateResult: state => {
					if ( ! state.id ) {
						return state.text;
					}

					return $( '<span style="font-family:' + this.currentFontStack.get() + ';font-weight:' + state.id + ';">' + state.text + '</span>' );
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
