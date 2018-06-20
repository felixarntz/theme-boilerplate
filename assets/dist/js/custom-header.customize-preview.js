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
	/******/return __webpack_require__(__webpack_require__.s = 22);
	/******/
})(
/************************************************************************/
/******/{

	/***/0:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/**
   * File customize-util.js.
   *
   * Class containing Customizer utility methods.
   */

		var CustomizeUtil = function () {
			function CustomizeUtil(wpCustomize) {
				_classCallCheck(this, CustomizeUtil);

				this.customizer = wpCustomize || window.wp.customize;
			}

			_createClass(CustomizeUtil, [{
				key: 'bindSettingValue',
				value: function bindSettingValue(id, callback) {
					this.customizer(id, function (setting) {
						setting.bind(callback);
					});
				}
			}, {
				key: 'bindSettingValueToPanels',
				value: function bindSettingValueToPanels(id, panelIds, callback) {
					this.bindSettingValueToComponents(id, panelIds, callback, 'panel');
				}
			}, {
				key: 'bindSettingValueToSections',
				value: function bindSettingValueToSections(id, sectionIds, callback) {
					this.bindSettingValueToComponents(id, sectionIds, callback, 'section');
				}
			}, {
				key: 'bindSettingValueToControls',
				value: function bindSettingValueToControls(id, controlIds, callback) {
					this.bindSettingValueToComponents(id, controlIds, callback, 'control');
				}
			}, {
				key: 'bindSettingValueToComponents',
				value: function bindSettingValueToComponents(id, componentIds, callback, componentType) {
					var customizer = this.customizer;

					componentType = componentType || 'control';

					this.customizer(id, function (setting) {
						function bindComponent(component) {
							callback(setting.get(), component);
							setting.bind(function () {
								callback(setting.get(), component);
							});
						}

						componentIds.forEach(function (componentId) {
							customizer[componentType](componentId, bindComponent);
						});
					});
				}
			}]);

			return CustomizeUtil;
		}();

		/* harmony default export */

		__webpack_exports__["a"] = CustomizeUtil;

		/***/
	},

	/***/22:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_customize_util__ = __webpack_require__(0);
		/**
   * File custom-header.customize-preview.js.
   *
   * Theme Customizer handling for Custom Header preview.
   */

		(function (wp, data) {
			var customizeUtil = new __WEBPACK_IMPORTED_MODULE_0__customize_customize_util__["a" /* default */](wp.customize);

			customizeUtil.bindSettingValue('header_textcolor', function (value) {
				if ('blank' === value) {
					Array.from(document.querySelectorAll('.site-title, .site-description')).forEach(function (element) {
						element.style.setProperty('clip', 'rect(1px, 1px, 1px, 1px)');
						element.style.setProperty('position', 'absolute');
					});
				} else {
					Array.from(document.querySelectorAll('.site-title, .site-description')).forEach(function (element) {
						element.style.setProperty('clip', 'auto');
						element.style.setProperty('position', 'relative');
					});
					Array.from(document.querySelectorAll('.site-title a, .site-description')).forEach(function (element) {
						element.style.setProperty('color', value);
					});
				}
			});

			customizeUtil.bindSettingValue('header_textalign', function (value) {
				var classes = Object.keys(data.headerTextalignChoices);
				var index = classes.indexOf(value);
				var header = document.querySelector('.site-custom-header');

				if (header && index > -1) {
					classes.splice(index, 1);
					classes.forEach(function (cssClass) {
						return header.classList.remove(cssClass);
					});
					header.classList.add(value);
				}
			});
		})(window.wp, window.themeCustomHeaderPreviewData);

		/***/
	}

	/******/ });