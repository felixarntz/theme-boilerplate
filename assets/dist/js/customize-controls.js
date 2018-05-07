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
	/******/return __webpack_require__(__webpack_require__.s = 7);
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

	/***/7:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_customize_util__ = __webpack_require__(0);
		/**
   * File customize-controls.js.
   *
   * Theme Customizer handling for the interface.
   */

		(function (wp, data) {

			data = data || {};

			function updateAvailableWidgets(collection, expanded) {
				collection.each(function (widget) {
					if (widget && !data.inlineWidgets.includes(widget.get('id_base'))) {
						widget.set('is_disabled', expanded);
					}
				});
			}

			wp.customize.bind('ready', function () {
				var customizeUtil = new __WEBPACK_IMPORTED_MODULE_0__customize_customize_util__["a" /* default */](wp.customize);

				if (data.inlineWidgetAreas.length) {
					wp.customize.section.each(function (section) {
						if ('sidebar' !== section.params.type) {
							return;
						}

						if (!data.inlineWidgetAreas.includes(section.params.sidebarId)) {
							return;
						}

						section.expanded.bind(function (expanded) {
							updateAvailableWidgets(wp.customize.Widgets.availableWidgetsPanel.collection, expanded);
						});
					});
				}

				// Only show sidebar-related controls if a sidebar is enabled.
				customizeUtil.bindSettingValueToControls('sidebar_mode', ['sidebar_size', 'blog_sidebar_enabled'], function (value, control) {
					if ('no-sidebar' === value) {
						control.container.slideUp(180);
					} else {
						control.container.slideDown(180);
					}
				});

				// Show sidebar section that is enabled.
				customizeUtil.bindSettingValueToSections('blog_sidebar_enabled', ['sidebar-widgets-primary', 'sidebar-widgets-blog'], function (value, section) {
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