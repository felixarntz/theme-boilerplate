'use strict';

/******/(function (modules) {
	// webpackBootstrap
	/******/ // The module cache
	/******/var installedModules = {};
	/******/
	/******/ // The require function
	/******/function __webpack_require__(moduleId) {
		/******/
		/******/ // Check if module is in cache
		/******/if (installedModules[moduleId]) {
			/******/return installedModules[moduleId].exports;
			/******/
		}
		/******/ // Create a new module (and put it into the cache)
		/******/var module = installedModules[moduleId] = {
			/******/i: moduleId,
			/******/l: false,
			/******/exports: {}
			/******/ };
		/******/
		/******/ // Execute the module function
		/******/modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
		/******/
		/******/ // Flag the module as loaded
		/******/module.l = true;
		/******/
		/******/ // Return the exports of the module
		/******/return module.exports;
		/******/
	}
	/******/
	/******/
	/******/ // expose the modules object (__webpack_modules__)
	/******/__webpack_require__.m = modules;
	/******/
	/******/ // expose the module cache
	/******/__webpack_require__.c = installedModules;
	/******/
	/******/ // define getter function for harmony exports
	/******/__webpack_require__.d = function (exports, name, getter) {
		/******/if (!__webpack_require__.o(exports, name)) {
			/******/Object.defineProperty(exports, name, {
				/******/configurable: false,
				/******/enumerable: true,
				/******/get: getter
				/******/ });
			/******/
		}
		/******/
	};
	/******/
	/******/ // getDefaultExport function for compatibility with non-harmony modules
	/******/__webpack_require__.n = function (module) {
		/******/var getter = module && module.__esModule ?
		/******/function getDefault() {
			return module['default'];
		} :
		/******/function getModuleExports() {
			return module;
		};
		/******/__webpack_require__.d(getter, 'a', getter);
		/******/return getter;
		/******/
	};
	/******/
	/******/ // Object.prototype.hasOwnProperty.call
	/******/__webpack_require__.o = function (object, property) {
		return Object.prototype.hasOwnProperty.call(object, property);
	};
	/******/
	/******/ // __webpack_public_path__
	/******/__webpack_require__.p = "";
	/******/
	/******/ // Load entry module and return exports
	/******/return __webpack_require__(__webpack_require__.s = 29);
	/******/
})(
/************************************************************************/
/******/{

	/***/2:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/**
   * File get-customize-action.js.
   *
   * Function to get the Customize action for a given panel.
   */

		/* harmony default export */
		__webpack_exports__["a"] = function (panel) {
			var _window$wp$i18n = window.wp.i18n,
			    __ = _window$wp$i18n.__,
			    sprintf = _window$wp$i18n.sprintf;

			var panelInstance = panel && panel.length ? window.wp.customize.panel.instance(panel) : undefined;

			if (panelInstance) {
				return sprintf(__('Customizing &#9656; %s', 'super-awesome-theme'), panelInstance.params.title);
			}

			return __('Customizing', 'super-awesome-theme');
		};

		/***/
	},

	/***/29:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__ = __webpack_require__(2);
		/**
   * File fonts.customize-controls.js.
   *
   * Theme Customizer handling for font controls.
   */

		(function (wp, data, _, $) {
			var api = wp.customize;

			api.SuperAwesomeThemeFontControl = api.Control.extend({
				ready: function ready() {
					var _this = this;

					var value = this.setting.get();
					var $familySelect = this.container.find('[data-setting-property="family"]');
					var $weightSelect = this.container.find('[data-setting-property="weight"]');
					var $sizeInput = this.container.find('[data-setting-property="size"]');

					this.currentFontStack = new api.Value('');
					this.currentFontWeights = new api.Value(['400']);

					this.initializeFontFamilySelect($familySelect);
					this.initializeFontWeightSelect($weightSelect);

					this.currentFontWeights.bind(function () {
						var currentFontWeights = _this.currentFontWeights.get();
						var settingValue = _this.setting.get();

						$weightSelect.selectWoo('destroy');
						$weightSelect.html('');

						_this.initializeFontWeightSelect($weightSelect);

						if (!currentFontWeights.includes('' + settingValue.weight)) {
							$weightSelect.val(currentFontWeights[0]).trigger('change');
						}
					});

					if (value.family && value.family.length) {
						$familySelect.val(value.family).trigger('change');
					}

					if (value.weight && value.weight.length) {
						$weightSelect.val(value.weight).trigger('change');
					}

					if (value.size) {
						$sizeInput.val(value.size).trigger('change');
					}

					$familySelect.on('change', function () {
						_this.saveValue('family', $familySelect.val());
					});

					$weightSelect.on('change', function () {
						_this.saveValue('weight', $weightSelect.val());
					});

					$sizeInput.on('change input', function () {
						_this.saveValue('size', $sizeInput.val());
					});
				},

				saveValue: function saveValue(prop, propVal) {
					var value = _.clone(this.setting.get());

					value[prop] = propVal;

					this.setting.set(value);
				},

				initializeFontFamilySelect: function initializeFontFamilySelect($element) {
					var _this2 = this;

					var selectData = {};
					var includedData = {};
					var excludedData = {};
					var settingValue = this.setting.get();

					data.fontFamilyGroups.forEach(function (group) {
						selectData[group.id] = {
							id: group.id,
							text: group.label,
							children: []
						};

						includedData[group.id] = {
							id: group.id,
							text: group.label,
							children: []
						};

						excludedData[group.id] = {
							id: group.id,
							text: group.label,
							children: []
						};
					});

					data.fontFamilies.forEach(function (family) {
						var dataset = {
							id: family.id,
							text: family.label,
							fontStack: family.stackString.replace(/"/g, '\''),
							fontWeights: family.weights
						};

						if (family.api) {
							dataset.fontApi = family.api;
						}

						if (!selectData[family.group]) {
							return;
						}

						selectData[family.group].children.push(dataset);

						if (settingValue.family === family.id) {
							_this2.currentFontStack.set(family.stackString.replace(/"/g, '\''));
							_this2.currentFontWeights.set(family.weights);
						}

						if (settingValue.family === family.id || family.include) {
							includedData[family.group].children.push(dataset);
							return;
						}

						excludedData[family.group].children.push(dataset);
					});

					$element.selectWoo({
						data: Object.values(selectData),
						matcher: function matcher(params, data) {
							var term = $.trim(params.term);
							var regexp = new RegExp(term, 'i');
							var filteredData = {};

							if (!data.id || !data.text || !data.children) {
								return null;
							}

							filteredData.id = data.id;
							filteredData.text = data.text;
							filteredData.children = [];

							if (term.length > 3) {
								filteredData.children = filteredData.children.concat(includedData[data.id].children.filter(function (dataset) {
									return !!dataset.id.match(regexp);
								}));
								filteredData.children = filteredData.children.concat(excludedData[data.id].children.filter(function (dataset) {
									return !!dataset.id.match(regexp);
								}));
							} else {
								filteredData.children = filteredData.children.concat(includedData[data.id].children);
							}

							if (!filteredData.children.length) {
								return null;
							}

							return filteredData;
						},
						templateResult: function templateResult(state) {
							var extraIndicator = '';

							if (!state.id || !state.fontStack) {
								return state.text;
							}

							if (state.fontApi && data.apis[state.fontApi]) {
								extraIndicator += ' <small>(' + data.apis[state.fontApi] + ')</small>';
							}

							return $('<span style="font-family:' + state.fontStack + ';">' + state.text + '</span>' + extraIndicator);
						}
					});

					$element.on('select2:select', function (event) {
						if (!event.params.data.fontStack) {
							return;
						}

						_this2.currentFontStack.set(event.params.data.fontStack);
						_this2.currentFontWeights.set(event.params.data.fontWeights);
					});
				},

				initializeFontWeightSelect: function initializeFontWeightSelect($element) {
					var _this3 = this;

					function getSelectData(currentFontWeights) {
						var selectData = [];

						data.fontWeights.forEach(function (weight) {
							if (!currentFontWeights.includes('' + weight.id)) {
								return;
							}

							selectData.push({
								id: weight.id,
								text: weight.label
							});
						});

						return selectData;
					}

					$element.selectWoo({
						data: getSelectData(this.currentFontWeights.get()),
						templateResult: function templateResult(state) {
							if (!state.id) {
								return state.text;
							}

							return $('<span style="font-family:' + _this3.currentFontStack.get() + ';font-weight:' + state.id + ';">' + state.text + '</span>');
						}
					});
				}
			});

			api.bind('ready', function () {

				api.panel.instance('fonts', function (panel) {
					var customizeAction = Object(__WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__["a" /* default */])(panel.id);

					data.groups.forEach(function (group) {
						if (api.section.instance(group.id)) {
							return;
						}

						api.section.add(new api.Section(group.id, {
							panel: panel.id,
							title: group.title,
							customizeAction: customizeAction
						}));
					});

					data.fonts.forEach(function (font) {
						if (font.live_preview) {
							api.instance(font.id, function (setting) {
								setting.transport = 'postMessage';
							});
						}

						api.control.add(new api.SuperAwesomeThemeFontControl(font.id, {
							id: font.id,
							setting: font.id,
							section: font.group,
							label: font.title,
							type: 'super_awesome_theme_font'
						}));
					});
				});
			});
		})(window.wp, window.themeFontsControlsData, window._, window.jQuery);

		/***/
	}

	/******/ });