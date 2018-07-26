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
	/******/return __webpack_require__(__webpack_require__.s = 24);
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

	/***/24:
	/***/function _(module, __webpack_exports__, __webpack_require__) {

		"use strict";

		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__ = __webpack_require__(2);
		/**
   * File content-types.customize-controls.js.
   *
   * Theme Customizer handling for content type controls.
   */

		(function (wp, data) {
			var api = wp.customize;
			var _wp$i18n = wp.i18n,
			    __ = _wp$i18n.__,
			    _x = _wp$i18n._x,
			    sprintf = _wp$i18n.sprintf;

			var currentPostType = new api.Value('');
			var hasPageHeader = new api.Value(false);

			api.bind('ready', function () {
				api.panel.instance('content_types', function (panel) {
					var customizeAction = Object(__WEBPACK_IMPORTED_MODULE_0__customize_get_customize_action__["a" /* default */])(panel.id);

					data.postTypes.forEach(function (postType) {
						var sectionId = 'content_type_' + postType.slug;

						['supports', 'taxonomies', 'extraFields'].forEach(function (param) {
							postType[param] = postType[param].length ? postType[param] : [];
						});

						api.section.add(new api.Section(sectionId, {
							panel: panel.id,
							title: postType.label,
							customizeAction: customizeAction
						}));

						api.instance(postType.slug + '_use_page_header', function (setting) {
							api.control.add(new api.Control(setting.id, {
								setting: setting.id,
								section: sectionId,
								label: __('Use Page Header?', 'super-awesome-theme'),
								type: 'checkbox'
							}));
						});

						if (postType.supports.includes('excerpt')) {
							api.instance(postType.slug + '_use_excerpt', function (setting) {
								setting.transport = 'postMessage';

								api.control.add(new api.Control(setting.id, {
									setting: setting.id,
									section: sectionId,
									label: __('Use Excerpt in archives?', 'super-awesome-theme'),
									type: 'checkbox'
								}));
							});
						}

						api.instance(postType.slug + '_show_date', function (setting) {
							setting.transport = 'postMessage';

							api.control.add(new api.Control(setting.id, {
								setting: setting.id,
								section: sectionId,
								label: __('Show Date?', 'super-awesome-theme'),
								type: 'checkbox'
							}));
						});

						if (postType.supports.includes('author')) {
							api.instance(postType.slug + '_show_author', function (setting) {
								setting.transport = 'postMessage';

								api.control.add(new api.Control(setting.id, {
									setting: setting.id,
									section: sectionId,
									label: __('Show Author Name?', 'super-awesome-theme'),
									type: 'checkbox'
								}));
							});

							api.instance(postType.slug + '_show_authorbox', function (setting) {
								setting.transport = 'postMessage';

								api.control.add(new api.Control(setting.id, {
									setting: setting.id,
									section: sectionId,
									label: __('Show Author Box?', 'super-awesome-theme'),
									type: 'checkbox',
									priority: 120
								}));
							});
						}

						postType.taxonomies.forEach(function (taxonomy) {
							api.instance(postType.slug + '_show_terms_' + taxonomy.slug, function (setting) {
								setting.transport = 'postMessage';

								api.control.add(new api.Control(setting.id, {
									setting: setting.id,
									section: sectionId,
									label: sprintf(_x('Show %s?', 'taxonomy', 'super-awesome-theme'), taxonomy.label),
									type: 'checkbox',
									priority: 100
								}));
							});
						});

						postType.extraFields.forEach(function (extraField) {
							api.instance(extraField.slug, function (setting) {
								setting.transport = 'postMessage';

								api.control.add(new api.Control(setting.id, {
									setting: setting.id,
									section: sectionId,
									label: extraField.label,
									type: 'checkbox'
								}));
							});
						});
					});
				});

				// Handle the currentPostType value.
				api.previewer.bind('currentPostType', function (value) {
					currentPostType.set(value);
				});

				// Handle the hasPageHeader value.
				api.previewer.bind('hasPageHeader', function (value) {
					hasPageHeader.set(value);
				});
			});
		})(window.wp, window.themeContentTypesControlsData);

		/***/
	}

	/******/ });