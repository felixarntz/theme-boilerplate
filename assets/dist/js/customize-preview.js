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
	/******/return __webpack_require__(__webpack_require__.s = 7);
	/******/
})(
/************************************************************************/
/******/{

	/***/7:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		var _this = this;

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__utils__ = __webpack_require__(8);
		/**
   * File customize-preview.js.
   *
   * Theme Customizer handling for the preview.
   */

		(function (wp, data) {

			function bindCustomizerValue(id, callback) {
				wp.customize(id, function (setting) {
					setting.bind(callback);
				});
			}

			// Site title.
			bindCustomizerValue('blogname', function (value) {
				Array.from(document.querySelectorAll('.site-title a')).forEach(function (element) {
					element.textContent = value;
				});
			});

			// Site description.
			bindCustomizerValue('blogdescription', function (value) {
				Array.from(document.querySelectorAll('.site-description')).forEach(function (element) {
					element.textContent = value;
				});
			});

			// Header text color.
			bindCustomizerValue('header_textcolor', function (value) {
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

			// Header text align.
			bindCustomizerValue('header_textalign', function (value) {
				var classes = Object.keys(data.headerTextalignChoices);
				var index = classes.indexOf(value);
				var header = document.querySelector('.site-custom-header');

				if (header && index > -1) {
					classes.splice(index, 1);

					header.classList.remove.apply(undefined, classes);
					header.classList.add(value);
				}
			});

			// Sidebar mode.
			bindCustomizerValue('sidebar_mode', function (value) {
				var classes = Object.keys(data.sidebarModeChoices);
				var index = classes.indexOf(value);

				if (index > -1) {
					classes.splice(index, 1);

					document.body.classList.remove.apply(undefined, classes);
					document.body.classList.add(value);
				}
			});

			// Sidebar size.
			bindCustomizerValue('sidebar_size', function (value) {
				var classes = Object.keys(data.sidebarSizeChoices).map(function (setting) {
					return 'sidebar-' + setting;
				});
				var index = classes.indexOf('sidebar-' + value);

				value = 'sidebar-' + value;

				if (index > -1) {
					classes.splice(index, 1);

					document.body.classList.remove.apply(undefined, classes);
					document.body.classList.add(value);
				}
			});

			// Top Bar Justify Content.
			bindCustomizerValue('top_bar_justify_content', function (value) {
				var classes = Object.keys(data.barJustifyContentChoices);
				var index = classes.indexOf(value);
				var topBar = document.getElementById('site-top-bar');

				if (topBar && index > -1) {
					classes.splice(index, 1);

					topBar.classList.remove.apply(undefined, classes);
					topBar.classList.add(value);
				}
			});

			// Bottom Bar Justify Content.
			bindCustomizerValue('bottom_bar_justify_content', function (value) {
				var classes = Object.keys(data.barJustifyContentChoices);
				var index = classes.indexOf(value);
				var bottomBar = document.getElementById('site-bottom-bar');

				if (bottomBar && index > -1) {
					classes.splice(index, 1);

					bottomBar.classList.remove.apply(undefined, classes);
					bottomBar.classList.add(value);
				}
			});

			// Wide footer widget area.
			bindCustomizerValue('wide_footer_widget_area', function (value) {
				Array.from(document.querySelectorAll('.footer-widget-column')).forEach(function (element) {
					if ('footer-widget-column-' + value === element.id) {
						element.classList.add('footer-widget-column-wide');
					} else {
						element.classList.remove('footer-widget-column-wide');
					}
				});
			});

			wp.customize.selectiveRefresh.partialConstructor.SuperAwesomeThemePostPartial = wp.customize.selectiveRefresh.Partial.extend({
				placements: function placements() {
					var partial = _this,
					    selector;

					selector = partial.params.selector || '';
					if (selector) {
						selector += ', ';
					}
					selector += '[data-customize-partial-id="' + partial.id + '"]';

					return Array.from(document.querySelectorAll(selector)).map(function (element) {
						return new wp.customize.selectiveRefresh.Placement({
							partial: partial,
							container: element,
							context: {
								post_id: parseInt(Object(__WEBPACK_IMPORTED_MODULE_0__utils__["a" /* findParent */])(element, 'article.hentry').id.replace('post-', ''), 10)
							}
						});
					});
				}
			});
		})(window.wp, window.themeCustomizeData);

		/***/
	},

	/***/8:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/* harmony export (immutable) */
		__webpack_exports__["a"] = findParent;
		/* unused harmony export debounce */
		/**
   * File utils.js.
   *
   * Contains utility functions used by theme functionality.
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

		function debounce(func, wait, immediate) {
			var _this2 = this,
			    _arguments = arguments;

			var timeout = void 0;

			return function () {
				var context = _this2;
				var args = _arguments;
				var later = function later() {
					timeout = null;
					if (!immediate) {
						func.apply(context, args);
					}
				};
				var callNow = immediate && !timeout;

				clearTimeout(timeout);
				timeout = setTimeout(later, wait);

				if (callNow) {
					func.apply(context, args);
				}
			};
		}

		/***/
	}

	/******/ });