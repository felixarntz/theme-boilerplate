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
	/******/return __webpack_require__(__webpack_require__.s = 41);
	/******/
})(
/************************************************************************/
/******/{

	/***/41:
	/***/function _(module, exports) {

		/**
   * File widgets.customize-controls.js.
   *
   * Theme Customizer handling for widget controls.
   */

		(function (wp, data) {
			var api = wp.customize;
			var _x = wp.i18n._x;

			var style = document.createElement('style');
			var widgetUntested = document.createElement('div');

			style.type = 'text/css';
			style.textContent = '#available-widgets .widget-tpl.widget-tpl-inline-untested { background: #fafafa; border-left-color: #fafafa } .widget-tpl-inline-untested > .widget { opacity: 0.7; } .widget-tpl-notice { margin: 5px 0 0; }';

			widgetUntested.classList.add('widget-tpl-notice', 'notice', 'notice-warning');
			widgetUntested.textContent = _x('Untested with this widget area.', 'widget notice', 'super-awesome-theme');

			document.head.appendChild(style);

			function markUntestedWidgets(collection, expanded) {
				collection.each(function (widget) {
					var widgetTpl = document.querySelector('#widget-tpl-' + widget.id);
					var widgetTplNotice = widgetTpl.querySelector('.widget-tpl-notice');

					if (widget && !data.inlineWidgets.includes(widget.get('id_base'))) {
						if (expanded) {
							widgetTpl.classList.add('widget-tpl-inline-untested');
							if (!widgetTplNotice) {
								widgetTpl.appendChild(widgetUntested.cloneNode(true));
							}
							return;
						}

						widgetTpl.classList.remove('widget-tpl-inline-untested');
						if (widgetTplNotice) {
							widgetTpl.removeChild(widgetTplNotice);
						}
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
							markUntestedWidgets(api.Widgets.availableWidgetsPanel.collection, expanded);
						});

						api.instance('sidebars_widgets[' + section.params.sidebarId + ']', function (setting) {
							var hasNotification = false;

							function checkInlineWidgets() {
								var noticeCode = 'inline_contains_untested_widgets';
								var widgets = setting.get();
								var needsNotification = false;

								widgets.forEach(function (widgetId) {
									if (!data.inlineWidgets.includes(widgetId.replace(/-(\d+)$/, ''))) {
										needsNotification = true;
									}
								});

								if (needsNotification && !hasNotification) {
									hasNotification = true;
									section.notifications.add(noticeCode, new api.Notification(noticeCode, {
										type: 'warning',
										message: _x('This inline widget area contains widgets that are untested with it and thus may display incorrectly.', 'widget notice', 'super-awesome-theme')
									}));
									return;
								}

								if (!needsNotification && hasNotification) {
									hasNotification = false;
									section.notifications.remove(noticeCode);
								}
							}

							checkInlineWidgets();
							setting.bind(checkInlineWidgets);
						});
					});
				}
			});
		})(window.wp, window.themeWidgetsControlsData);

		/***/
	}

	/******/ });