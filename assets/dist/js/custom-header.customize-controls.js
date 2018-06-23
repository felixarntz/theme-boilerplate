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
	/******/return __webpack_require__(__webpack_require__.s = 28);
	/******/
})(
/************************************************************************/
/******/{

	/***/28:
	/***/function _(module, exports) {

		/**
   * File custom-header.customize-controls.js.
   *
   * Theme Customizer handling for additional Custom Header controls.
   */

		(function (wp, data) {
			var api = wp.customize;
			var _wp$i18n = wp.i18n,
			    __ = _wp$i18n.__,
			    _x = _wp$i18n._x;


			api.bind('ready', function () {
				api.when('header_textalign', function (headerTextalign) {
					headerTextalign.transport = 'postMessage';
				});

				api.control.add(new api.Control('branding_location', {
					setting: 'branding_location',
					section: 'title_tagline',
					label: __('Display Location', 'super-awesome-theme'),
					description: __('Specify where to display the site logo, title and tagline.', 'super-awesome-theme'),
					type: 'radio',
					choices: data.brandingLocationChoices
				}));

				api.control.add(new api.Control('header_textalign', {
					setting: 'header_textalign',
					section: 'header_image',
					label: _x('Text Alignment', 'custom header', 'super-awesome-theme'),
					type: 'radio',
					choices: data.headerTextalignChoices
				}));
			});
		})(window.wp, window.themeCustomHeaderControlsData);

		/***/
	}

	/******/ });