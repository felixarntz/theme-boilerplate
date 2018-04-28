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
   * File customize-controls.js.
   *
   * Theme Customizer handling for the interface.
   */

		(function (wp, data) {

			function updateAvailableWidgets(collection, expanded) {
				collection.each(function (widget) {
					if (widget && !data.inlineWidgets.includes(widget.get('id_base'))) {
						widget.set('is_disabled', expanded);
					}
				});
			}

			function bindCustomizerValueToSections(id, sections, callback) {
				wp.customize(id, function (setting) {
					function bindSection(section) {
						callback(setting.get(), section);
						setting.bind(function () {
							callback(setting.get(), section);
						});
					}

					sections.forEach(function (section) {
						wp.customize.section(section, bindSection);
					});
				});
			}

			function bindCustomizerValueToControls(id, controls, callback) {
				wp.customize(id, function (setting) {
					function bindControl(control) {
						callback(setting.get(), control);
						setting.bind(function () {
							callback(setting.get(), control);
						});
					}

					controls.forEach(function (control) {
						wp.customize.control(control, bindControl);
					});
				});
			}

			wp.customize.bind('ready', function () {
				if (data.inlineSidebars.length) {
					wp.customize.section.each(function (section) {
						if ('sidebar' !== section.params.type) {
							return;
						}

						if (!data.inlineSidebars.includes(section.params.sidebarId)) {
							return;
						}

						section.expanded.bind(function (expanded) {
							updateAvailableWidgets(wp.customize.Widgets.availableWidgetsPanel.collection, expanded);
						});
					});
				}

				// Only show sidebar-related controls if a sidebar is enabled.
				bindCustomizerValueToControls('sidebar_mode', ['sidebar_size', 'blog_sidebar_enabled'], function (value, control) {
					if ('no-sidebar' === value) {
						control.container.slideUp(180);
					} else {
						control.container.slideDown(180);
					}
				});

				// Show sidebar section that is enabled.
				bindCustomizerValueToSections('blog_sidebar_enabled', ['sidebar-widgets-primary', 'sidebar-widgets-blog'], function (value, section) {
					if (value) {
						if ('blog' === section.params.sidebarId) {
							section.activate();
						} else {
							section.deactivate();
						}
					} else {
						if ('blog' === section.params.sidebarId) {
							section.deactivate();
						} else {
							section.activate();
						}
					}
				});

				// Disable blog sidebar enabled control when not active.
				wp.customize.control('blog_sidebar_enabled', function (control) {
					control.onChangeActive = function (active) {
						var noticeCode = 'blog_sidebar_not_available';

						if (active) {
							control.container.find('input[type="checkbox"]').prop('disabled', false);
							control.container.find('.description').slideDown(180);
							control.notifications.remove(noticeCode);
						} else {
							control.container.find('input[type="checkbox"]').prop('disabled', true);
							control.container.find('.description').slideUp(180);
							control.notifications.add(noticeCode, new wp.customize.Notification(noticeCode, {
								type: 'info',
								message: data.i18n.blogSidebarEnabledNotice
							}));
						}
					};
				});
			});
		})(window.wp, window.themeCustomizeData);

		/***/
	}

	/******/ });