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
	/******/return __webpack_require__(__webpack_require__.s = 0);
	/******/
})(
/************************************************************************/
/******/[
/* 0 */
/***/function (module, __webpack_exports__, __webpack_require__) {

	"use strict";

	Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
	/* harmony import */var __WEBPACK_IMPORTED_MODULE_0__skip_link_focus_fix__ = __webpack_require__(1);
	/* harmony import */var __WEBPACK_IMPORTED_MODULE_1__navigation__ = __webpack_require__(2);
	/* harmony import */var __WEBPACK_IMPORTED_MODULE_2__comments__ = __webpack_require__(3);

	window.themeData = window.themeData || {};

	(function (themeData) {
		themeData.components = {
			navigation: new __WEBPACK_IMPORTED_MODULE_1__navigation__["a" /* default */]('site-navigation', themeData.navigation)
		};

		Object(__WEBPACK_IMPORTED_MODULE_0__skip_link_focus_fix__["a" /* default */])();
		Object(__WEBPACK_IMPORTED_MODULE_2__comments__["a" /* default */])(themeData.comments || {});

		themeData.components.navigation.initialize();
	})(window.themeData);

	/***/
},
/* 1 */
/***/function (module, __webpack_exports__, __webpack_require__) {

	"use strict";
	/**
  * File skip-link-focus-fix.js.
  *
  * Helps with accessibility for keyboard only users.
  *
  * Learn more: https://git.io/vWdr2
  */

	function skipLinkFocusFix() {
		var isWebkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1;
		var isOpera = navigator.userAgent.toLowerCase().indexOf('opera') > -1;
		var isIe = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

		if ((isWebkit || isOpera || isIe) && document.getElementById && window.addEventListener) {
			window.addEventListener('hashchange', function () {
				var id = location.hash.substring(1),
				    element;

				if (!/^[A-z0-9_-]+$/.test(id)) {
					return;
				}

				element = document.getElementById(id);

				if (element) {
					if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			}, false);
		}
	}

	/* harmony default export */__webpack_exports__["a"] = skipLinkFocusFix;

	/***/
},
/* 2 */
/***/function (module, __webpack_exports__, __webpack_require__) {

	"use strict";
	/**
  * File navigation.js.
  *
  * Handles toggling the navigation menu for small screens and enables TAB key
  * navigation support for dropdown menus.
  */

	var Navigation = function () {
		function Navigation(containerId, options) {
			_classCallCheck(this, Navigation);

			this.container = document.getElementById(containerId);
			this.options = options || {};
		}

		_createClass(Navigation, [{
			key: 'initialize',
			value: function initialize() {
				if (!this.container) {
					return;
				}

				var menu = this.container.getElementsByTagName('ul')[0];
				var button = this.container.getElementsByTagName('button')[0];

				this.initializeMenuFocus(menu);
				this.initializeSubmenuFocus(menu);
				this.initializeDropdownMenus(menu);
				this.initializeMenuToggle(button, menu);
			}
		}, {
			key: 'initializeMenuFocus',
			value: function initializeMenuFocus(menu) {
				var links = void 0;

				if ('undefined' === typeof menu) {
					return;
				}

				if (!menu.classList.contains('nav-menu')) {
					menu.classList.add('nav-menu');
				}

				function toggleFocus() {
					var element = this;

					while (!element.classList.contains('nav-menu')) {
						if ('li' === element.tagName.toLowerCase()) {
							element.classList.toggle('focus');
						}

						element = element.parentElement;
					}
				}

				links = menu.getElementsByTagName('a');

				Array.from(links).forEach(function (link) {
					link.addEventListener('focus', toggleFocus, true);
					link.addEventListener('blur', toggleFocus, true);
				});
			}
		}, {
			key: 'initializeSubmenuFocus',
			value: function initializeSubmenuFocus(menu) {
				var parentLinks = void 0;

				if ('undefined' === typeof menu) {
					return;
				}

				if (!window.ontouchstart) {
					return;
				}

				function touchStartFocus(e) {
					var menuItem = this.parentNode;

					var menuItemSiblings = void 0;

					if (!menuItem.classList.contains('focus')) {
						e.preventDefault();

						menuItemSiblings = menuItem.parentNode.children;
						menuItemSiblings.forEach(function (menuItemSibling) {
							if (menuItem === menuItemSibling) {
								return;
							}

							menuItemSibling.classList.remove('focus');
						});

						menuItem.classList.add('focus');
					} else {
						menuItem.classList.remove('focus');
					}
				}

				parentLinks = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

				Array.from(parentLinks).forEach(function (parentLink) {
					parentLink.addEventListener('touchstart', touchStartFocus, false);
				});
			}
		}, {
			key: 'initializeDropdownMenus',
			value: function initializeDropdownMenus(menu) {
				var options = this.options;

				var parentLinks = void 0;

				if ('undefined' === typeof menu) {
					return;
				}

				function toggleDropdownMenu(e) {
					var screenReaderText = this.getElementsByClassName('screen-reader-text')[0];

					e.preventDefault();

					this.classList.toggle('toggled');
					this.nextElementSibling.classList.toggle('toggled');

					if ('false' === this.getAttribute('aria-expanded')) {
						this.setAttribute('aria-expanded', 'true');
					} else {
						this.setAttribute('aria-expanded', 'false');
					}

					if (options.i18n.expand === screenReaderText.textContent) {
						screenReaderText.textContent = options.i18n.collapse;
					} else {
						screenReaderText.textContent = options.i18n.expand;
					}
				}

				parentLinks = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

				Array.from(parentLinks).forEach(function (parentLink) {
					var dropdownToggle = document.createElement('button');
					var screenReaderText = document.createElement('span');

					dropdownToggle.classList.add('dropdown-toggle');
					dropdownToggle.innerHTML = options.icon;
					dropdownToggle.appendChild(screenReaderText);

					screenReaderText.classList.add('screen-reader-text');

					if (parentLink.parentNode.classList.contains('current-menu-ancestor')) {
						dropdownToggle.classList.add('toggled');
						dropdownToggle.setAttribute('aria-expanded', 'true');
						screenReaderText.textContent = options.i18n.collapse;

						parentLink.parentNode.getElementsByClassName('sub-menu')[0].classList.add('toggled');
					} else {
						dropdownToggle.setAttribute('aria-expanded', 'false');
						screenReaderText.textContent = options.i18n.expand;
					}

					dropdownToggle.onclick = toggleDropdownMenu;

					if (parentLink.nextSibling) {
						parentLink.parentNode.insertBefore(dropdownToggle, parentLink.nextSibling);
					} else {
						parentLink.parentNode.appendChild(dropdownToggle);
					}
				});
			}
		}, {
			key: 'initializeMenuToggle',
			value: function initializeMenuToggle(button, menu) {
				var container = this.container;

				if ('undefined' === typeof button) {
					return;
				}

				if ('undefined' === typeof menu) {
					button.style.display = 'none';
					return;
				}

				button.onclick = function () {
					var result = container.classList.toggle('toggled');

					if (result) {
						button.setAttribute('aria-expanded', 'true');
					} else {
						button.setAttribute('aria-expanded', 'false');
					}
				};
			}
		}]);

		return Navigation;
	}();

	/* harmony default export */

	__webpack_exports__["a"] = Navigation;

	/***/
},
/* 3 */
/***/function (module, __webpack_exports__, __webpack_require__) {

	"use strict";
	/**
  * File comments.js.
  *
  * Handles comment submission via AJAX.
  */

	function comments(themeData) {
		var commentForm, comments, statusDiv, commentReplyLinks, currentList, i;

		if ('function' !== typeof window.fetch || 'function' !== typeof window.FormData) {
			return;
		}

		commentForm = document.getElementById('commentform');
		if (!commentForm) {
			return;
		}

		comments = document.getElementById('comments');
		if (!comments) {
			return;
		}

		commentForm.setAttribute('aria-live', 'polite');

		statusDiv = document.createElement('div');
		statusDiv.setAttribute('id', 'comment-status');
		statusDiv.setAttribute('aria-live', 'assertive');
		statusDiv.setAttribute('role', 'status');
		statusDiv.setAttribute('tabindex', '-1');

		commentForm.insertBefore(statusDiv, commentForm.childNodes.item(0));

		commentReplyLinks = nodeListToArray(document.getElementsByClassName('comment-reply-link'));
		for (i = 0; i < commentReplyLinks.length; i++) {
			commentReplyLinks[i].addEventListener('click', function () {
				var elem = this;

				do {
					elem = elem.parentElement;
				} while (elem && !elem.classList.contains('comment'));

				currentList = elem;
			});
		}

		commentForm.addEventListener('submit', function (evt) {
			var formUrl, hasError, fields, field, name, value, i;

			evt.preventDefault();

			formUrl = commentForm.getAttribute('action');
			if (formUrl.indexOf('?') > -1) {
				formUrl += '&is_ajax=true';
			} else {
				formUrl += '?is_ajax=true';
			}

			clearStatusNotice(statusDiv);
			clearFieldErrors(commentForm);

			hasError = false;

			fields = nodeListToArray(commentForm.querySelectorAll('input, textarea'));
			for (i = 0; i < fields.length; i++) {
				field = fields[i];

				name = field.getAttribute('name');
				value = field.value;

				if ('string' === typeof value) {
					value = value.trim();
				} else {
					value = '';
				}

				if ('true' === field.getAttribute('aria-required') && !value.length) {
					addFieldError(field, themeData.i18n.required);

					hasError = true;
				} else if ('email' === name && value.length && !validateEmail(value)) {
					addFieldError(field, themeData.i18n.emailInvalid);

					hasError = true;
				}
			}

			if (hasError) {
				addStatusNotice(statusDiv, 'error', themeData.i18n.error);

				return false;
			}

			addStatusNotice(statusDiv, 'info', themeData.i18n.processing);

			window.fetch(formUrl, {
				method: 'POST',
				mode: 'same-origin',
				credentials: 'same-origin',
				body: new window.FormData(commentForm)
			}).then(function (response) {
				var contentType;

				if (200 !== response.status) {
					throw new Error(themeData.i18n.badResponse);
				}

				contentType = response.headers.get('content-type');

				if (!contentType || !contentType.includes('application/json')) {
					throw new TypeError(themeData.i18n.invalidJson);
				}

				return response.json();
			}).then(function (result) {
				var commentList, commentListHeading;

				clearStatusNotice(statusDiv);

				if (result.success) {
					addStatusNotice(statusDiv, 'success', result.status, true);

					if (comments.querySelectorAll('ol.comment-list').length) {
						commentList = comments.querySelector('ol.comment-list');
					} else {
						commentList = document.createElement('ol');
						commentList.classList.add('comment-list');

						comments.insertBefore(commentList, comments.childNodes.item(0));

						commentListHeading = document.createElement('h2');
						commentListHeading.classList.add('comments-title');
						commentListHeading.innerHTML = themeData.i18n.commentsTitle;

						comments.insertBefore(commentListHeading, comments.childNodes.item(0));
					}

					if (currentList) {
						currentList.innerHTML = result.response + currentList.innerHTML;
					} else {
						commentList.innerHTML = commentList.innerHTML + result.response;
					}
				} else {
					addStatusNotice(statusDiv, 'error', result.status, true);
				}

				commentForm.querySelector('textarea[name="comment"]').value = '';
			}).catch(function () {
				clearStatusNotice(statusDiv);
				addStatusNotice(statusDiv, 'error', themeData.i18n.flood, true);
			});

			return false;
		});
	}

	function clearStatusNotice(wrap) {
		var notices = nodeListToArray(wrap.childNodes);
		var i;

		for (i = 0; i < notices.length; i++) {
			notices[i].parentElement.removeChild(notices[i]);
		}

		wrap.classList.remove('notice', 'notice-success', 'notice-info', 'notice-warning', 'notice-error');
	}

	function clearFieldErrors(form) {
		var errors = nodeListToArray(form.getElementsByClassName('field-notice'));
		var i;

		for (i = 0; i < errors.length; i++) {
			errors[i].parentElement.removeChild(errors[i]);
		}
	}

	function addStatusNotice(wrap, type, message, setFocus) {
		var className = 'notice-' + type;
		var notice = document.createElement('p');

		notice.innerHTML = message;

		wrap.classList.add('notice', className);
		wrap.appendChild(notice);

		if (setFocus) {
			wrap.focus();
		}
	}

	function addFieldError(field, errorMessage) {
		var id, error;

		id = field.getAttribute('id');

		field.setAttribute('aria-describedby', id + '-field-error');

		error = document.createElement('span');
		error.setAttribute('id', id + '-field-error');
		error.classList.add('field-notice', 'notice-error');
		error.textContent = errorMessage;

		field.parentElement.appendChild(error);
	}

	function validateEmail(value) {
		var filter = /^([\w-+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		if (filter.test(value)) {
			return true;
		}

		return false;
	}

	function nodeListToArray(nodeList) {
		var nodeListArray = [];
		var i;

		for (i = 0; i < nodeList.length; i++) {
			nodeListArray.push(nodeList.item(i));
		}

		return nodeListArray;
	}

	/* harmony default export */__webpack_exports__["a"] = comments;

	/***/
}]
/******/);