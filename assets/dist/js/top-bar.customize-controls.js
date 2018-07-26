'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

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
	/******/return __webpack_require__(__webpack_require__.s = 38);
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

	/***/3:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/**
   * File customize-controls-util.js.
   *
   * Class containing Customizer controls utility methods.
   */

		var CustomizeControlsUtil = function () {
			function CustomizeControlsUtil(wpCustomize) {
				_classCallCheck(this, CustomizeControlsUtil);

				this.customizer = wpCustomize || window.wp.customize;
			}

			_createClass(CustomizeControlsUtil, [{
				key: 'bindSetting',
				value: function bindSetting(settingId, callback) {
					this.customizer.instance(settingId, function (setting) {
						callback(setting.get());
						setting.bind(function () {
							callback(setting.get());
						});
					});
				}
			}, {
				key: 'bindSettingToComponents',
				value: function bindSettingToComponents(settingId, componentIds, callback, componentType) {
					var self = this;

					componentType = componentType || 'control';

					function listenToSetting() {
						var components = Array.prototype.slice.call(arguments, 0, componentIds.length);

						self.bindSetting(settingId, function (value) {
							components.forEach(function (component) {
								callback(value, component);
							});
						});
					}

					this.customizer[componentType].instance.apply(this.customizer[componentType], componentIds.concat([listenToSetting]));
				}
			}, {
				key: 'bindSettingToPanels',
				value: function bindSettingToPanels(settingId, panelIds, callback) {
					this.bindSettingToComponents(settingId, panelIds, callback, 'panel');
				}
			}, {
				key: 'bindSettingToSections',
				value: function bindSettingToSections(settingId, sectionIds, callback) {
					this.bindSettingToComponents(settingId, sectionIds, callback, 'section');
				}
			}, {
				key: 'bindSettingToControls',
				value: function bindSettingToControls(settingId, controlIds, callback) {
					this.bindSettingToComponents(settingId, controlIds, callback, 'control');
				}
			}, {
				key: 'bindSettings',
				value: function bindSettings(settingIds, callback) {
					function bindSettings() {
						var settings = Array.prototype.slice.call(arguments, 0, settingIds.length);
						var values = {};

						function updateSetting(setting) {
							values[setting.id] = setting.get();
						}

						settings.forEach(function (setting) {
							updateSetting(setting);
							setting.bind(function () {
								updateSetting(setting);
								callback(values);
							});
						});

						callback(values);
					}

					this.customizer.instance.apply(this.customizer, settingIds.concat([bindSettings]));
				}
			}, {
				key: 'bindSettingsToComponents',
				value: function bindSettingsToComponents(settingIds, componentIds, callback, componentType) {
					var self = this;

					componentType = componentType || 'control';

					function listenToSettings() {
						var components = Array.prototype.slice.call(arguments, 0, componentIds.length);

						self.bindSettings(settingIds, function (values) {
							components.forEach(function (component) {
								callback(values, component);
							});
						});
					}

					this.customizer[componentType].instance.apply(this.customizer[componentType], componentIds.concat([listenToSettings]));
				}
			}, {
				key: 'bindSettingsToPanels',
				value: function bindSettingsToPanels(settingIds, panelIds, callback) {
					this.bindSettingsToComponents(settingIds, panelIds, callback, 'panel');
				}
			}, {
				key: 'bindSettingsToSections',
				value: function bindSettingsToSections(settingIds, sectionIds, callback) {
					this.bindSettingsToComponents(settingIds, sectionIds, callback, 'section');
				}
			}, {
				key: 'bindSettingsToControls',
				value: function bindSettingsToControls(settingIds, controlIds, callback) {
					this.bindSettingsToComponents(settingIds, controlIds, callback, 'control');
				}
			}]);

			return CustomizeControlsUtil;
		}();

		/* harmony default export */

		__webpack_exports__["a"] = CustomizeControlsUtil;

		/***/
	},

	/***/38:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_customize_controls_util__ = __webpack_require__(3);
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_1__customize_get_customize_action__ = __webpack_require__(2);
		/**
   * File top-bar.customize-controls.js.
   *
   * Theme Customizer handling for the top bar.
   */

		(function (wp, data) {
			var api = wp.customize;
			var util = new __WEBPACK_IMPORTED_MODULE_0__customize_customize_controls_util__["a" /* default */](api);
			var __ = wp.i18n.__;


			api.bind('ready', function () {
				api.when('top_bar_justify_content', function (topBarJustifyContent) {
					topBarJustifyContent.transport = 'postMessage';
				});

				api.panel.instance('layout', function () {
					api.section.add(new api.Section('top_bar', {
						panel: 'layout',
						title: __('Top Bar', 'super-awesome-theme'),
						customizeAction: Object(__WEBPACK_IMPORTED_MODULE_1__customize_get_customize_action__["a" /* default */])('layout')
					}));

					api.control.add(new api.Control('top_bar_justify_content', {
						setting: 'top_bar_justify_content',
						section: 'top_bar',
						label: __('Top Bar Justify Content', 'super-awesome-theme'),
						description: __('Specify how the content in the top bar is aligned.', 'super-awesome-theme'),
						type: 'radio',
						choices: data.topBarJustifyContentChoices
					}));
				});

				// Handle visibility of the top bar controls.
				util.bindSettingToControls('sidebars_widgets[top]', ['top_bar_justify_content', 'sticky_top_bar', 'top_bar_text_color', 'top_bar_link_color', 'top_bar_background_color'], function (value, control) {
					control.active.set(!!value.length);
				});
			});
		})(window.wp, window.themeTopBarControlsData);

		/***/
	}

	/******/ });