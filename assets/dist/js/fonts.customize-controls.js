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
	/******/return __webpack_require__(__webpack_require__.s = 30);
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

	/***/30:
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

					this.initializeFontFamilySelect($familySelect);
					this.initializeFontWeightSelect($weightSelect);

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
					var settingValue = this.setting.get();

					this.currentFontStack = '';

					data.fontFamilyGroups.forEach(function (group) {
						selectData[group.id] = {
							text: group.label,
							children: []
						};
					});

					data.fontFamilies.forEach(function (family) {
						if (!selectData[family.group]) {
							return;
						}

						if (settingValue === family.id) {
							_this2.currentFontStack = family.stackString.replace(/"/g, '\'');
						}

						selectData[family.group].children.push({
							id: family.id,
							text: family.label,
							fontStack: family.stackString.replace(/"/g, '\'')
						});
					});

					$element.selectWoo({
						data: Object.values(selectData),
						templateResult: function templateResult(state) {
							if (!state.id || !state.fontStack) {
								return state.text;
							}

							return $('<span style="font-family:' + state.fontStack + ';">' + state.text + '</span>');
						}
					});

					$element.on('select2:select', function (event) {
						if (!event.params.data.fontStack) {
							return;
						}

						_this2.currentFontStack = event.params.data.fontStack;
					});
				},

				initializeFontWeightSelect: function initializeFontWeightSelect($element) {
					var _this3 = this;

					var selectData = [];

					data.fontWeights.forEach(function (weight) {
						selectData.push({
							id: weight.id,
							text: weight.label
						});
					});

					$element.selectWoo({
						data: selectData,
						templateResult: function templateResult(state) {
							if (!state.id) {
								return state.text;
							}

							return $('<span style="font-family:' + _this3.currentFontStack + ';font-weight:' + state.id + ';">' + state.text + '</span>');
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