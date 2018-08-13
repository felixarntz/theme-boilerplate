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
	/******/return __webpack_require__(__webpack_require__.s = 22);
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

	/***/22:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__ = __webpack_require__(2);
		/**
   * File bottom-bar.customize-controls.js.
   *
   * Theme Customizer handling for the bottom bar.
   */

		(function (wp, data) {
			var api = wp.customize;
			var __ = wp.i18n.__;


			api.bind('ready', function () {
				api.when('bottom_bar_justify_content', function (bottomBarJustifyContent) {
					bottomBarJustifyContent.transport = 'postMessage';
				});

				api.panel.instance('layout', function () {
					api.section.add(new api.Section('bottom_bar', {
						panel: 'layout',
						title: __('Bottom Bar', 'super-awesome-theme'),
						customizeAction: Object(__WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__["a" /* default */])('layout')
					}));

					api.control.add(new api.Control('bottom_bar_justify_content', {
						setting: 'bottom_bar_justify_content',
						section: 'bottom_bar',
						label: __('Bottom Bar Justify Content', 'super-awesome-theme'),
						description: __('Specify how the content in the bottom bar is aligned.', 'super-awesome-theme'),
						type: 'radio',
						choices: data.bottomBarJustifyContentChoices
					}));
				});
			});
		})(window.wp, window.themeBottomBarControlsData);

		/***/
	}

	/******/ });