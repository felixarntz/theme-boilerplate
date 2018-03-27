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
	/******/return __webpack_require__(__webpack_require__.s = 6);
	/******/
})(
/************************************************************************/
/******/{

	/***/6:
	/***/function _(module, exports) {

		/**
   * File customize-preview.js.
   *
   * Theme Customizer handling for the preview.
   */

		(function ($) {

			// Site title.
			wp.customize('blogname', function (value) {
				value.bind(function (to) {
					$('.site-title a').text(to);
				});
			});

			// Site description.
			wp.customize('blogdescription', function (value) {
				value.bind(function (to) {
					$('.site-description').text(to);
				});
			});

			// Header text color.
			wp.customize('header_textcolor', function (value) {
				value.bind(function (to) {
					if ('blank' === to) {
						$('.site-title, .site-description').css({
							'clip': 'rect(1px, 1px, 1px, 1px)',
							'position': 'absolute'
						});
					} else {
						$('.site-title, .site-description').css({
							'clip': 'auto',
							'position': 'relative'
						});
						$('.site-title a, .site-description').css({
							'color': to
						});
					}
				});
			});

			// Sidebar mode.
			wp.customize('sidebar_mode', function (value) {
				value.bind(function (to) {
					var classes = Object.keys(themeCustomizeData.sidebarModeChoices);
					var index = classes.indexOf(to);

					if (index > -1) {
						classes.splice(index, 1);

						$('body').removeClass(classes.join(' ')).addClass(to);
					}
				});
			});

			// Sidebar size.
			wp.customize('sidebar_size', function (value) {
				value.bind(function (to) {
					var classes = Object.keys(themeCustomizeData.sidebarSizeChoices).map(function (setting) {
						return 'sidebar-' + setting;
					});
					var index;

					to = 'sidebar-' + to;
					index = classes.indexOf(to);

					if (index > -1) {
						classes.splice(index, 1);

						$('body').removeClass(classes.join(' ')).addClass(to);
					}
				});
			});

			// Top Bar Justify Content.
			wp.customize('top_bar_justify_content', function (value) {
				value.bind(function (to) {
					var classes = Object.keys(themeCustomizeData.barJustifyContentChoices);
					var index = classes.indexOf(to);

					if (index > -1) {
						classes.splice(index, 1);

						$('#site-top-bar').removeClass(classes.join(' ')).addClass(to);
					}
				});
			});

			// Bottom Bar Justify Content.
			wp.customize('bottom_bar_justify_content', function (value) {
				value.bind(function (to) {
					var classes = Object.keys(themeCustomizeData.barJustifyContentChoices);
					var index = classes.indexOf(to);

					if (index > -1) {
						classes.splice(index, 1);

						$('#site-bottom-bar').removeClass(classes.join(' ')).addClass(to);
					}
				});
			});

			// Wide footer widget area.
			wp.customize('wide_footer_widget_area', function (value) {
				value.bind(function (to) {
					$('.footer-widget-column').each(function () {
						var $this = $(this);
						if ('footer-widget-column-' + to === $this.attr('id')) {
							$this.addClass('footer-widget-column-wide');
						} else {
							$this.removeClass('footer-widget-column-wide');
						}
					});
				});
			});

			wp.customize.selectiveRefresh.partialConstructor.SuperAwesomeThemePostPartial = wp.customize.selectiveRefresh.Partial.extend({
				placements: function placements() {
					var partial = this,
					    selector;

					selector = partial.params.selector || '';
					if (selector) {
						selector += ', ';
					}
					selector += '[data-customize-partial-id="' + partial.id + '"]';

					return $(selector).map(function () {
						var container = $(this),
						    context;

						context = {
							post_id: parseInt(container.parents('article.hentry').attr('id').replace('post-', ''), 10)
						};

						return new wp.customize.selectiveRefresh.Placement({
							partial: partial,
							container: container,
							context: context
						});
					}).get();
				}
			});
		})(jQuery);

		/***/
	}

	/******/ });