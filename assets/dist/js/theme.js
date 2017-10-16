/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__skip_link_focus_fix__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__navigation__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__comments__ = __webpack_require__(3);




( function( themeData ) {
	Object(__WEBPACK_IMPORTED_MODULE_0__skip_link_focus_fix__["a" /* default */])();
	Object(__WEBPACK_IMPORTED_MODULE_1__navigation__["a" /* default */])();
	Object(__WEBPACK_IMPORTED_MODULE_2__comments__["a" /* default */])( themeData.comments );
})( themeData );


/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */

function skipLinkFocusFix() {
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1;
	var isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1;
	var isIe     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
}

/* harmony default export */ __webpack_exports__["a"] = (skipLinkFocusFix);


/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
function navigation() {
	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
}

/* harmony default export */ __webpack_exports__["a"] = (navigation);


/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * File comments.js.
 *
 * Handles comment submission via AJAX.
 */

function comments( themeData ) {
	var commentForm, comments, statusDiv, commentReplyLinks, currentList, i;

	if ( 'function' !== typeof window.fetch ) {
		return;
	}

	commentForm = document.getElementById( 'commentform' );
	if ( ! commentForm ) {
		return;
	}

	comments = document.getElementById( 'comments' );
	if ( ! comments ) {
		return;
	}

	commentForm.setAttribute( 'aria-live', 'polite' );

	statusDiv = document.createElement( 'div' );
	statusDiv.setAttribute( 'id', 'comment-status' );
	statusDiv.setAttribute( 'aria-live', 'assertive' );
	statusDiv.setAttribute( 'role', 'status' );
	statusDiv.setAttribute( 'tabindex', '-1' );

	commentForm.insertBefore( statusDiv, commentForm.childNodes[0] );

	commentReplyLinks = document.getElementsByClassName( 'comment-reply-link' );
	for ( i = 0; i < commentReplyLinks.length; i++ ) {
		commentReplyLinks[ i ].addEventListener( 'click', function() {
			var elem = this;

			do {
				elem = elem.parentElement;
			} while ( elem && ! elem.classList.contains( 'comment' ) );

			currentList = elem;
		});
	}

	commentForm.addEventListener( 'submit', function() {
		var formData, formUrl, hasError, fields, name, i;

		formData = {};
		formUrl = commentForm.getAttribute( 'action' );

		clearStatusNotices( statusDiv );
		clearFieldErrors( commentForm );

		hasError = false;

		fields = commentForm.querySelectorAll( 'input, textarea' );
		for ( i = 0; i < fields.length; i++ ) {
			name = fields[ i ].getAttribute( 'name' );

			if ( 'textarea' === fields[ i ].tagName.toLowerCase() ) {
				formData[ name ] = fields[ i ].value;
			} else {
				formData[ name ] = fields[ i ].getAttribute( 'value' );
			}

			if ( 'string' === typeof formData[ name ] ) {
				formData[ name ] = formData[ name ].trim();
			} else {
				formData[ name ] = '';
			}

			if ( 'true' === fields[ i ].getAttribute( 'aria-required' ) && ! formData[ name ].length ) {
				addFieldError( fields[ i ], themeData.i18n.required );

				hasError = true;
			} else if ( 'email' === name && formData[ name ].length && ! validateEmail( formData[ name ] ) ) {
				addFieldError( fields[ i ], themeData.i18n.emailInvalid );

				hasError = true;
			}
		}

		if ( hasError ) {
			addStatusNotice( statusDiv, 'comment-notice-error', themeData.i18n.error );

			return false;
		}

		addStatusNotice( statusDiv, 'comment-notice-processing', themeData.i18n.processing );

		window.fetch( formUrl, {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			body: formData, // TODO: Make this work.
		})
			.then( function( response ) {
				var contentType;

				if ( 200 !== response.status ) {
					throw new Error( themeData.i18n.badResponse );
				}

				contentType = response.headers.get( 'content-type' );

				if ( ! contentType || ! contentType.includes( 'application/json' ) ) {
					throw new TypeError( themeData.i18n.invalidJson );
				}

				return response.json();
			})
			.then( function( result ) {
				var commentList;

				clearStatusNotices( statusDiv );

				if ( result.success ) {
					addStatusNotice( statusDiv, 'comment-notice-success', result.status, true );

					if ( comments.querySelectorAll( 'ol.comment-list' ).length ) {
						commentList = comments.querySelector( 'ol.comment-list' );
					} else {
						commentList = document.createElement( 'ol' );
						commentList.classList.add( 'comment-list' );

						comments.appendChild( commentList );
					}

					if ( currentList ) {
						currentList.innerHTML = result.response + currentList.innerHTML;
					} else {
						commentList.innerHTML = commentList.innerHTML + result.response;
					}
				} else {
					addStatusNotice( statusDiv, 'comment-notice-error', result.status, true );
				}

				commentForm.querySelector( 'textarea[name="content"]' ).value = '';
			})
			.catch( function() {
				clearStatusNotices( statusDiv );
				addStatusNotice( statusDiv, 'comment-notice-error', themeData.i18n.flood, true );
			});

		return false;
	});
}

function clearStatusNotices( wrap ) {
	var notices = wrap.getElementsByClassName( 'comment-notice' );
	var i;

	for ( i = 0; i < notices.length; i++ ) {
		notices[ i ].parentElement.removeChild( notices[ i ] );
	}
}

function clearFieldErrors( form ) {
	var errors = form.getElementsByClassName( 'comment-field-error' );
	var i;

	for ( i = 0; i < errors.length; i++ ) {
		errors[ i ].parentElement.removeChild( errors[ i ] );
	}
}

function addStatusNotice( wrap, className, message, setFocus ) {
	var notice = document.createElement( 'p' );

	notice.classList.add( 'comment-notice', className );
	notice.innerHTML = message;

	wrap.appendChild( notice );

	if ( setFocus ) {
		wrap.focus();
	}
}

function addFieldError( field, errorMessage ) {
	var id, error;

	id = field.getAttribute( 'id' );

	field.setAttribute( 'aria-describedby', id + '-error' );

	error = document.createElement( 'span' );
	error.setAttribute( 'id', id + '-error' );
	error.classList.add( 'comment-field-error' );
	error.textContent = errorMessage;

	field.parentElement.appendChild( error );
}

function validateEmail( value ) {
	var filter = /^([\w-+.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if ( filter.test( value ) ) {
		return true;
	}

	return false;
}

/* harmony default export */ __webpack_exports__["a"] = (comments);


/***/ })
/******/ ]);