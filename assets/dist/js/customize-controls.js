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
	/******/return __webpack_require__(__webpack_require__.s = 21);
	/******/
})(
/************************************************************************/
/******/{

	/***/21:
	/***/function _(module, exports) {

		/**
   * File customize-controls.js.
   *
   * Theme Customizer handling for the interface.
   */

		(function (wp, data) {
			var api = wp.customize;

			data = data || {};

			function updateAvailableWidgets(collection, expanded) {
				collection.each(function (widget) {
					if (widget && !data.inlineWidgets.includes(widget.get('id_base'))) {
						widget.set('is_disabled', expanded);
					}
				});
			}

			api.bind('ready', function () {
				if (data.inlineWidgetAreas.length) {
					api.section.each(function (section) {
						if ('sidebar' !== section.params.type) {
							return;
						}

						if (!data.inlineWidgetAreas.includes(section.params.sidebarId)) {
							return;
						}

						section.expanded.bind(function (expanded) {
							updateAvailableWidgets(api.Widgets.availableWidgetsPanel.collection, expanded);
						});
					});
				}
			});
		})(window.wp, window.themeCustomizeData);

		/***/
	}

	/******/ });