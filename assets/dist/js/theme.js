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
	/* harmony import */var __WEBPACK_IMPORTED_MODULE_2__comment_form__ = __webpack_require__(3);
	/* harmony import */var __WEBPACK_IMPORTED_MODULE_3__modals__ = __webpack_require__(4);

	window.themeData = window.themeData || {};

	(function (themeData) {
		themeData.components = {
			skipLinkFocusFix: new __WEBPACK_IMPORTED_MODULE_0__skip_link_focus_fix__["a" /* default */](),
			navigation: new __WEBPACK_IMPORTED_MODULE_1__navigation__["a" /* default */]('site-navigation', themeData.navigation),
			commentForm: new __WEBPACK_IMPORTED_MODULE_2__comment_form__["a" /* default */]('commentform', 'comments', themeData.comments),
			modals: new __WEBPACK_IMPORTED_MODULE_3__modals__["a" /* default */]('.modal')
		};

		themeData.components.skipLinkFocusFix.initialize();
		themeData.components.navigation.initialize();
		themeData.components.commentForm.initialize();
		themeData.components.modals.initialize();
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

	function detectUserAgent() {
		var userAgents = ['webkit', 'opera', 'msie'];
		var userAgent = void 0;

		var _iteratorNormalCompletion = true;
		var _didIteratorError = false;
		var _iteratorError = undefined;

		try {
			for (var _iterator = userAgents[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
				userAgent = _step.value;

				if (navigator.userAgent.toLowerCase().indexOf(userAgent) > -1) {
					return userAgent;
				}
			}
		} catch (err) {
			_didIteratorError = true;
			_iteratorError = err;
		} finally {
			try {
				if (!_iteratorNormalCompletion && _iterator.return) {
					_iterator.return();
				}
			} finally {
				if (_didIteratorError) {
					throw _iteratorError;
				}
			}
		}

		return '';
	}

	var SkipLinkFocusFix = function () {
		function SkipLinkFocusFix() {
			_classCallCheck(this, SkipLinkFocusFix);

			this.userAgent = detectUserAgent();
		}

		_createClass(SkipLinkFocusFix, [{
			key: 'initialize',
			value: function initialize() {
				if (!this.userAgent.length) {
					return;
				}

				if (!document.getElementById || !window.addEventListener) {
					return;
				}

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
		}]);

		return SkipLinkFocusFix;
	}();

	/* harmony default export */

	__webpack_exports__["a"] = SkipLinkFocusFix;

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

	var currentList = void 0;

	function clearStatusNotice(wrap) {
		var notices = wrap.childNodes;

		Array.from(notices).forEach(function (notice) {
			notice.parentElement.removeChild(notice);
		});

		wrap.classList.remove('notice', 'notice-success', 'notice-info', 'notice-warning', 'notice-error');
	}

	function clearFieldErrors(form) {
		var errors = form.getElementsByClassName('field-notice');

		Array.from(errors).forEach(function (error) {
			error.parentElement.removeChild(error);
		});
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
		var error = document.createElement('span');
		var id = field.getAttribute('id');

		field.setAttribute('aria-describedby', id + '-field-error');

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

	var CommentForm = function () {
		function CommentForm(commentFormId, commentsId, options) {
			_classCallCheck(this, CommentForm);

			this.commentForm = document.getElementById(commentFormId);
			this.comments = document.getElementById(commentsId);
			this.options = options || {};
		}

		_createClass(CommentForm, [{
			key: 'initialize',
			value: function initialize() {
				var statusDiv = void 0;

				if (!this.commentForm) {
					return;
				}

				if (!this.comments) {
					return;
				}

				if ('function' !== typeof window.fetch || 'function' !== typeof window.FormData) {
					return;
				}

				statusDiv = this.createStatusDiv();

				this.initializeCommentReplyLinks(this.comments);
				this.initializeCommentForm(this.commentForm, this.comments, statusDiv);
			}
		}, {
			key: 'createStatusDiv',
			value: function createStatusDiv() {
				var statusDiv = document.createElement('div');

				statusDiv.setAttribute('id', 'comment-status');
				statusDiv.setAttribute('aria-live', 'assertive');
				statusDiv.setAttribute('role', 'status');
				statusDiv.setAttribute('tabindex', '-1');

				return statusDiv;
			}
		}, {
			key: 'initializeCommentReplyLinks',
			value: function initializeCommentReplyLinks(comments) {
				var commentReplyLinks = void 0;

				if (!comments) {
					return;
				}

				function setCurrentList() {
					var element = this;

					do {
						element = element.parentElement;
					} while (element && !element.classList.contains('comment'));

					currentList = element;
				}

				commentReplyLinks = comments.getElementsByClassName('comment-reply-link');

				Array.from(commentReplyLinks).forEach(function (commentReplyLink) {
					commentReplyLink.addEventListener('click', setCurrentList);
				});
			}
		}, {
			key: 'initializeCommentForm',
			value: function initializeCommentForm(commentForm, comments, statusDiv) {
				var options = this.options;

				if (!commentForm) {
					return;
				}

				if (!comments) {
					return;
				}

				if (!statusDiv) {
					return;
				}

				function preprocessResponse(response) {
					var contentType = void 0;

					if (200 !== response.status) {
						throw new Error(options.i18n.badResponse);
					}

					contentType = response.headers.get('content-type');

					if (!contentType || !contentType.includes('application/json')) {
						throw new TypeError(options.i18n.invalidJson);
					}

					return response.json();
				}

				function handleResponseSuccess(result) {
					var commentList = void 0,
					    commentListHeading = void 0;

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
							commentListHeading.innerHTML = options.i18n.commentsTitle;

							comments.insertBefore(commentListHeading, comments.childNodes.item(0));
						}

						if (currentList) {
							currentList.innerHTML = currentList.innerHTML + result.response;
						} else {
							commentList.innerHTML = commentList.innerHTML + result.response;
						}
					} else {
						addStatusNotice(statusDiv, 'error', result.status, true);
					}

					currentList = undefined;
					commentForm.querySelector('textarea[name="comment"]').value = '';
				}

				function handleResponseError() {
					clearStatusNotice(statusDiv);
					addStatusNotice(statusDiv, 'error', options.i18n.flood, true);
				}

				function handleSubmission(e) {
					var formUrl = commentForm.getAttribute('action') + (commentForm.getAttribute('action').indexOf('?') > -1 ? '&' : '?') + 'is_ajax=true';
					var fields = commentForm.querySelectorAll('input, textarea');

					var hasError = false;

					e.preventDefault();

					clearStatusNotice(statusDiv);
					clearFieldErrors(commentForm);

					Array.from(fields).forEach(function (field) {
						var name = field.getAttribute('name');
						var value = 'string' === typeof field.value ? field.value.trim() : '';

						if ('true' === field.getAttribute('aria-required') && !value.length) {
							addFieldError(field, options.i18n.required);

							hasError = true;
						} else if ('email' === name && value.length && !validateEmail(value)) {
							addFieldError(field, options.i18n.emailInvalid);

							hasError = true;
						}
					});

					if (hasError) {
						addStatusNotice(statusDiv, 'error', options.i18n.error);

						return false;
					}

					addStatusNotice(statusDiv, 'info', options.i18n.processing);

					window.fetch(formUrl, {
						method: 'POST',
						mode: 'same-origin',
						credentials: 'same-origin',
						body: new window.FormData(commentForm)
					}).then(preprocessResponse).then(handleResponseSuccess).catch(handleResponseError);

					return false;
				}

				commentForm.setAttribute('aria-live', 'polite');
				commentForm.insertBefore(statusDiv, commentForm.childNodes.item(0));
				commentForm.addEventListener('submit', handleSubmission);
			}
		}]);

		return CommentForm;
	}();

	/* harmony default export */

	__webpack_exports__["a"] = CommentForm;

	/***/
},
/* 4 */
/***/function (module, __webpack_exports__, __webpack_require__) {

	"use strict";
	/**
  * File modals.js.
  *
  * Handles modals in an accessible way.
  */

	var Modals = function () {
		function Modals(selector, options) {
			_classCallCheck(this, Modals);

			this.modals = Array.from(document.querySelectorAll(selector));
			this.options = options || {};
		}

		_createClass(Modals, [{
			key: 'initialize',
			value: function initialize() {
				if (!this.modals.length) {
					return;
				}

				this.initializeModalOpenButtons();
				this.initializeModalCloseButtons();
				this.initializeModalEscape();
				this.initializeModalTraps();
			}
		}, {
			key: 'initializeModalOpenButtons',
			value: function initializeModalOpenButtons() {
				var open = this.openModal;

				this.modals.forEach(function (modal) {
					var openButtons = Array.from(document.querySelectorAll('[data-toggle="modal"][data-target="#' + modal.getAttribute('id') + '"]'));

					function listenToOpen() {
						var id = this.getAttribute('id');

						if (id && id.length) {
							modal.dataset.lastTrigger = '#' + id;
						}

						open(modal);
					}

					openButtons.forEach(function (button) {
						button.addEventListener('click', listenToOpen);
					});
				});
			}
		}, {
			key: 'initializeModalCloseButtons',
			value: function initializeModalCloseButtons() {
				var close = this.closeModal;

				this.modals.forEach(function (modal) {
					var closeButtons = Array.from(modal.querySelectorAll('[data-dismiss="modal"]'));

					function listenToClose() {
						close(modal);

						if (modal.dataset.lastTrigger) {
							delete modal.dataset.lastTrigger;
						}
					}

					closeButtons.forEach(function (button) {
						button.addEventListener('click', listenToClose);
					});
				});
			}
		}, {
			key: 'initializeModalEscape',
			value: function initializeModalEscape() {
				var close = this.closeModal;

				this.modals.forEach(function (modal) {
					modal.addEventListener('keyup', function (event) {
						if (27 === (event.keyCode || event.which)) {
							close(modal);
						}
					});
				});
			}
		}, {
			key: 'initializeModalTraps',
			value: function initializeModalTraps() {
				this.modals.forEach(function (modal) {
					var content = modal.querySelector('[role="document"]');
					var focusables = Array.from(modal.querySelectorAll('button, input, textarea, select'));
					var firstFocusable = focusables.length ? focusables[0] : undefined;
					var lastFocusable = focusables.length ? focusables[focusables.length - 1] : undefined;

					if (firstFocusable) {
						firstFocusable.addEventListener('keydown', function (event) {
							if (event.shiftKey && 9 === (event.keyCode || event.which)) {
								content.focus();
								event.preventDefault();
							}
						});
					}

					if (lastFocusable) {
						lastFocusable.addEventListener('keydown', function (event) {
							if (!event.shiftKey && 9 === (event.keyCode || event.which)) {
								content.focus();
								event.preventDefault();
							}
						});
					}
				});
			}
		}, {
			key: 'openModal',
			value: function openModal(modal) {
				var focusable = modal.querySelector('button, input, textarea, select');

				modal.setAttribute('aria-hidden', 'false');

				if (focusable) {
					focusable.focus();
				}
			}
		}, {
			key: 'closeModal',
			value: function closeModal(modal) {
				var trigger = modal.dataset.lastTrigger;

				modal.setAttribute('aria-hidden', 'true');

				if (trigger) {
					document.querySelector(trigger).focus();
				}
			}
		}]);

		return Modals;
	}();

	/* harmony default export */

	__webpack_exports__["a"] = Modals;

	/***/
}]
/******/);