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
	/******/return __webpack_require__(__webpack_require__.s = 30);
	/******/
})(
/************************************************************************/
/******/{

	/***/0:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/* harmony import */
		var __WEBPACK_IMPORTED_MODULE_0__common_find_parent__ = __webpack_require__(1);
		/**
   * File customize-preview-util.js.
   *
   * Class containing Customizer preview utility methods.
   */

		var CustomizePreviewUtil = function () {
			function CustomizePreviewUtil(wpCustomize) {
				_classCallCheck(this, CustomizePreviewUtil);

				this.customizer = wpCustomize || window.wp.customize;
			}

			_createClass(CustomizePreviewUtil, [{
				key: 'bindSetting',
				value: function bindSetting(settingId, callback) {
					this.customizer(settingId, function (setting) {
						setting.bind(callback);
					});
				}
			}, {
				key: 'providePostPartial',
				value: function providePostPartial(selectiveRefresh, partialName) {
					selectiveRefresh.partialConstructor[partialName] = selectiveRefresh.Partial.extend({
						placements: function placements() {
							var partial = this,
							    selector;

							selector = partial.params.selector || '';
							if (selector) {
								selector += ', ';
							}
							selector += '[data-customize-partial-id="' + partial.id + '"]';

							return Array.from(document.querySelectorAll(selector)).map(function (element) {
								return new selectiveRefresh.Placement({
									partial: partial,
									container: element,
									context: {
										post_id: parseInt(Object(__WEBPACK_IMPORTED_MODULE_0__common_find_parent__["a" /* default */])(element, 'article.hentry').id.replace('post-', ''), 10)
									}
								});
							});
						}
					});
				}
			}]);

			return CustomizePreviewUtil;
		}();

		/* harmony default export */

		__webpack_exports__["a"] = CustomizePreviewUtil;

		/***/
	},

	/***/1:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/* harmony export (immutable) */
		__webpack_exports__["a"] = findParent;
		/**
   * File find-parent.js.
   *
   * Exports a function to get a specific parent element of an element.
   */

		function findParent(element, selector) {
			while (element && element !== document) {
				element = element.parentElement;

				if (element.matches(selector)) {
					return element;
				}
			}

			return null;
		}

		/***/
	},

	/***/30:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_customize_preview_util__ = __webpack_require__(0);
		/**
   * File footer-widget-areas.customize-preview.js.
   *
   * Theme Customizer handling for footer widget area preview.
   */

		(function (wp) {
			var api = wp.customize;
			var util = new __WEBPACK_IMPORTED_MODULE_0__customize_customize_preview_util__["a" /* default */](api);

			util.bindSetting('wide_footer_widget_area', function (value) {
				Array.from(document.querySelectorAll('.footer-widget-column')).forEach(function (element) {
					if (value === element.id) {
						element.classList.add('footer-widget-column-wide');
					} else {
						element.classList.remove('footer-widget-column-wide');
					}
				});
			});
		})(window.wp);

		/***/
	}

	/******/ });