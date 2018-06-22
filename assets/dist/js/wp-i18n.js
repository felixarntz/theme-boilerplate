'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

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
  /******/return __webpack_require__(__webpack_require__.s = 39);
  /******/
})(
/************************************************************************/
/******/[,,,
/* 0 */
/* 1 */
/* 2 */
/* 3 */
/***/function (module, exports) {

  // https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
  var global = module.exports = typeof window != 'undefined' && window.Math == Math ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
  if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


  /***/
},
/* 4 */
/***/function (module, exports) {

  var core = module.exports = { version: '2.5.6' };
  if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


  /***/
},
/* 5 */
/***/function (module, exports) {

  module.exports = function (it) {
    return (typeof it === 'undefined' ? 'undefined' : _typeof(it)) === 'object' ? it !== null : typeof it === 'function';
  };

  /***/
},
/* 6 */
/***/function (module, exports, __webpack_require__) {

  // Thank's IE8 for his funny defineProperty
  module.exports = !__webpack_require__(7)(function () {
    return Object.defineProperty({}, 'a', { get: function get() {
        return 7;
      } }).a != 7;
  });

  /***/
},
/* 7 */
/***/function (module, exports) {

  module.exports = function (exec) {
    try {
      return !!exec();
    } catch (e) {
      return true;
    }
  };

  /***/
},
/* 8 */
/***/function (module, exports) {

  var hasOwnProperty = {}.hasOwnProperty;
  module.exports = function (it, key) {
    return hasOwnProperty.call(it, key);
  };

  /***/
},
/* 9 */
/***/function (module, exports, __webpack_require__) {

  // to indexed object, toObject with fallback for non-array-like ES3 strings
  var IObject = __webpack_require__(10);
  var defined = __webpack_require__(11);
  module.exports = function (it) {
    return IObject(defined(it));
  };

  /***/
},
/* 10 */
/***/function (module, exports, __webpack_require__) {

  // fallback for non-array-like ES3 and non-enumerable old V8 strings
  var cof = __webpack_require__(57);
  // eslint-disable-next-line no-prototype-builtins
  module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
    return cof(it) == 'String' ? it.split('') : Object(it);
  };

  /***/
},
/* 11 */
/***/function (module, exports) {

  // 7.2.1 RequireObjectCoercible(argument)
  module.exports = function (it) {
    if (it == undefined) throw TypeError("Can't call method on  " + it);
    return it;
  };

  /***/
},
/* 12 */
/***/function (module, exports) {

  // 7.1.4 ToInteger
  var ceil = Math.ceil;
  var floor = Math.floor;
  module.exports = function (it) {
    return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
  };

  /***/
},,,,,,,,,,,,,,,,,,,,,,,,,,,
/* 13 */
/* 14 */
/* 15 */
/* 16 */
/* 17 */
/* 18 */
/* 19 */
/* 20 */
/* 21 */
/* 22 */
/* 23 */
/* 24 */
/* 25 */
/* 26 */
/* 27 */
/* 28 */
/* 29 */
/* 30 */
/* 31 */
/* 32 */
/* 33 */
/* 34 */
/* 35 */
/* 36 */
/* 37 */
/* 38 */
/* 39 */
/***/function (module, __webpack_exports__, __webpack_require__) {

  "use strict";

  Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(40);
  /**
   * File wp-i18n.js.
   *
   * Implements i18n functions for WordPress in JavaScript through a
   * `wp.i18n` object. Only writes the object if it is not already set.
   */

  (function (wp) {

    wp = wp || {};

    if (wp.i18n) {
      return;
    }

    wp.i18n = {
      setLocaleData: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["f" /* setLocaleData */],
      getI18n: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["e" /* getI18n */],
      __: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["a" /* __ */],
      _x: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["d" /* _x */],
      _n: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["b" /* _n */],
      _nx: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["c" /* _nx */],
      sprintf: __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["g" /* sprintf */]
    };
  })(window.wp);

  /***/
},
/* 40 */
/***/function (module, __webpack_exports__, __webpack_require__) {

  "use strict";
  /* harmony export (immutable) */
  __webpack_exports__["f"] = setLocaleData;
  /* harmony export (immutable) */__webpack_exports__["e"] = getI18n;
  /* unused harmony export dcnpgettext */
  /* harmony export (immutable) */__webpack_exports__["a"] = __;
  /* harmony export (immutable) */__webpack_exports__["d"] = _x;
  /* harmony export (immutable) */__webpack_exports__["b"] = _n;
  /* harmony export (immutable) */__webpack_exports__["c"] = _nx;
  /* harmony export (immutable) */__webpack_exports__["g"] = sprintf;
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(41);
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_1_jed__ = __webpack_require__(69);
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_1_jed___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_jed__);
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_2_memize__ = __webpack_require__(70);
  /* harmony import */var __WEBPACK_IMPORTED_MODULE_2_memize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_memize__);

  /**
   * External dependencies
   */

  var i18n = void 0;

  /**
   * Log to console, once per message; or more precisely, per referentially equal
   * argument set. Because Jed throws errors, we log these to the console instead
   * to avoid crashing the application.
   *
   * @param {...*} args Arguments to pass to `console.error`
   */
  var logErrorOnce = __WEBPACK_IMPORTED_MODULE_2_memize___default()(console.error); // eslint-disable-line no-console

  /**
   * Merges locale data into the Jed instance by domain. Creates a new Jed
   * instance if one has not yet been assigned.
   *
   * @see http://messageformat.github.io/Jed/
   *
   * @param {?Object} localeData Locale data configuration.
   * @param {?string} domain     Domain for which configuration applies.
   */
  function setLocaleData() {
    var localeData = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { '': {} };
    var domain = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'default';

    if (!i18n) {
      i18n = new __WEBPACK_IMPORTED_MODULE_1_jed___default.a({
        domain: 'default',
        locale_data: {
          default: {}
        }
      });
    }

    i18n.options.locale_data[domain] = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, i18n.options.locale_data[domain], localeData);
  }

  /**
   * Returns the current Jed instance, initializing with a default configuration
   * if not already assigned.
   *
   * @return {Jed} Jed instance.
   */
  function getI18n() {
    if (!i18n) {
      setLocaleData();
    }

    return i18n;
  }

  /**
   * Wrapper for Jed's `dcnpgettext`, its most qualified function. Absorbs errors
   * which are thrown as the result of invalid translation.
   *
   * @param {?string} domain  Domain to retrieve the translated text.
   * @param {?string} context Context information for the translators.
   * @param {string}  single  Text to translate if non-plural. Used as fallback
   *                          return value on a caught error.
   * @param {?string} plural  The text to be used if the number is plural.
   * @param {?number} number  The number to compare against to use either the
   *                          singular or plural form.
   *
   * @return {string} The translated string.
   */
  var dcnpgettext = __WEBPACK_IMPORTED_MODULE_2_memize___default()(function () {
    var domain = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'default';
    var context = arguments[1];
    var single = arguments[2];
    var plural = arguments[3];
    var number = arguments[4];

    try {
      return getI18n().dcnpgettext(domain, context, single, plural, number);
    } catch (error) {
      logErrorOnce('Jed localization error: \n\n' + error.toString());

      return single;
    }
  });

  /**
   * Retrieve the translation of text.
   *
   * @see https://developer.wordpress.org/reference/functions/__/
   *
   * @param {string}  text   Text to translate.
   * @param {?string} domain Domain to retrieve the translated text.
   *
   * @return {string} Translated text.
   */
  function __(text, domain) {
    return dcnpgettext(domain, undefined, text);
  }

  /**
   * Retrieve translated string with gettext context.
   *
   * @see https://developer.wordpress.org/reference/functions/_x/
   *
   * @param {string}  text    Text to translate.
   * @param {string}  context Context information for the translators.
   * @param {?string} domain  Domain to retrieve the translated text.
   *
   * @return {string} Translated context string without pipe.
   */
  function _x(text, context, domain) {
    return dcnpgettext(domain, context, text);
  }

  /**
   * Translates and retrieves the singular or plural form based on the supplied
   * number.
   *
   * @see https://developer.wordpress.org/reference/functions/_n/
   *
   * @param {string}  single The text to be used if the number is singular.
   * @param {string}  plural The text to be used if the number is plural.
   * @param {number}  number The number to compare against to use either the
   *                         singular or plural form.
   * @param {?string} domain Domain to retrieve the translated text.
   *
   * @return {string} The translated singular or plural form.
   */
  function _n(single, plural, number, domain) {
    return dcnpgettext(domain, undefined, single, plural, number);
  }

  /**
   * Translates and retrieves the singular or plural form based on the supplied
   * number, with gettext context.
   *
   * @see https://developer.wordpress.org/reference/functions/_nx/
   *
   * @param {string}  single  The text to be used if the number is singular.
   * @param {string}  plural  The text to be used if the number is plural.
   * @param {number}  number  The number to compare against to use either the
   *                          singular or plural form.
   * @param {string}  context Context information for the translators.
   * @param {?string} domain  Domain to retrieve the translated text.
   *
   * @return {string} The translated singular or plural form.
   */
  function _nx(single, plural, number, context, domain) {
    return dcnpgettext(domain, context, single, plural, number);
  }

  /**
   * Returns a formatted string. If an error occurs in applying the format, the
   * original format string is returned.
   *
   * @param {string}   format  The format of the string to generate.
   * @param {string[]} ...args Arguments to apply to the format.
   *
   * @see http://www.diveintojavascript.com/projects/javascript-sprintf
   *
   * @return {string} The formatted string.
   */
  function sprintf(format) {
    try {
      for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }

      return __WEBPACK_IMPORTED_MODULE_1_jed___default.a.sprintf.apply(__WEBPACK_IMPORTED_MODULE_1_jed___default.a, [format].concat(args));
    } catch (error) {
      logErrorOnce('Jed sprintf error: \n\n' + error.toString());

      return format;
    }
  }

  /***/
},
/* 41 */
/***/function (module, exports, __webpack_require__) {

  module.exports = { "default": __webpack_require__(42), __esModule: true };

  /***/
},
/* 42 */
/***/function (module, exports, __webpack_require__) {

  __webpack_require__(43);
  module.exports = __webpack_require__(4).Object.assign;

  /***/
},
/* 43 */
/***/function (module, exports, __webpack_require__) {

  // 19.1.3.1 Object.assign(target, source)
  var $export = __webpack_require__(44);

  $export($export.S + $export.F, 'Object', { assign: __webpack_require__(54) });

  /***/
},
/* 44 */
/***/function (module, exports, __webpack_require__) {

  var global = __webpack_require__(3);
  var core = __webpack_require__(4);
  var ctx = __webpack_require__(45);
  var hide = __webpack_require__(47);
  var has = __webpack_require__(8);
  var PROTOTYPE = 'prototype';

  var $export = function $export(type, name, source) {
    var IS_FORCED = type & $export.F;
    var IS_GLOBAL = type & $export.G;
    var IS_STATIC = type & $export.S;
    var IS_PROTO = type & $export.P;
    var IS_BIND = type & $export.B;
    var IS_WRAP = type & $export.W;
    var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
    var expProto = exports[PROTOTYPE];
    var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
    var key, own, out;
    if (IS_GLOBAL) source = name;
    for (key in source) {
      // contains in native
      own = !IS_FORCED && target && target[key] !== undefined;
      if (own && has(exports, key)) continue;
      // export native or passed
      out = own ? target[key] : source[key];
      // prevent global pollution for namespaces
      exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
      // bind timers to global for call from export context
      : IS_BIND && own ? ctx(out, global)
      // wrap global constructors for prevent change them in library
      : IS_WRAP && target[key] == out ? function (C) {
        var F = function F(a, b, c) {
          if (this instanceof C) {
            switch (arguments.length) {
              case 0:
                return new C();
              case 1:
                return new C(a);
              case 2:
                return new C(a, b);
            }return new C(a, b, c);
          }return C.apply(this, arguments);
        };
        F[PROTOTYPE] = C[PROTOTYPE];
        return F;
        // make static versions for prototype methods
      }(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
      // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
      if (IS_PROTO) {
        (exports.virtual || (exports.virtual = {}))[key] = out;
        // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
        if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
      }
    }
  };
  // type bitmap
  $export.F = 1; // forced
  $export.G = 2; // global
  $export.S = 4; // static
  $export.P = 8; // proto
  $export.B = 16; // bind
  $export.W = 32; // wrap
  $export.U = 64; // safe
  $export.R = 128; // real proto method for `library`
  module.exports = $export;

  /***/
},
/* 45 */
/***/function (module, exports, __webpack_require__) {

  // optional / simple context binding
  var aFunction = __webpack_require__(46);
  module.exports = function (fn, that, length) {
    aFunction(fn);
    if (that === undefined) return fn;
    switch (length) {
      case 1:
        return function (a) {
          return fn.call(that, a);
        };
      case 2:
        return function (a, b) {
          return fn.call(that, a, b);
        };
      case 3:
        return function (a, b, c) {
          return fn.call(that, a, b, c);
        };
    }
    return function () /* ...args */{
      return fn.apply(that, arguments);
    };
  };

  /***/
},
/* 46 */
/***/function (module, exports) {

  module.exports = function (it) {
    if (typeof it != 'function') throw TypeError(it + ' is not a function!');
    return it;
  };

  /***/
},
/* 47 */
/***/function (module, exports, __webpack_require__) {

  var dP = __webpack_require__(48);
  var createDesc = __webpack_require__(53);
  module.exports = __webpack_require__(6) ? function (object, key, value) {
    return dP.f(object, key, createDesc(1, value));
  } : function (object, key, value) {
    object[key] = value;
    return object;
  };

  /***/
},
/* 48 */
/***/function (module, exports, __webpack_require__) {

  var anObject = __webpack_require__(49);
  var IE8_DOM_DEFINE = __webpack_require__(50);
  var toPrimitive = __webpack_require__(52);
  var dP = Object.defineProperty;

  exports.f = __webpack_require__(6) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
    anObject(O);
    P = toPrimitive(P, true);
    anObject(Attributes);
    if (IE8_DOM_DEFINE) try {
      return dP(O, P, Attributes);
    } catch (e) {/* empty */}
    if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
    if ('value' in Attributes) O[P] = Attributes.value;
    return O;
  };

  /***/
},
/* 49 */
/***/function (module, exports, __webpack_require__) {

  var isObject = __webpack_require__(5);
  module.exports = function (it) {
    if (!isObject(it)) throw TypeError(it + ' is not an object!');
    return it;
  };

  /***/
},
/* 50 */
/***/function (module, exports, __webpack_require__) {

  module.exports = !__webpack_require__(6) && !__webpack_require__(7)(function () {
    return Object.defineProperty(__webpack_require__(51)('div'), 'a', { get: function get() {
        return 7;
      } }).a != 7;
  });

  /***/
},
/* 51 */
/***/function (module, exports, __webpack_require__) {

  var isObject = __webpack_require__(5);
  var document = __webpack_require__(3).document;
  // typeof document.createElement is 'object' in old IE
  var is = isObject(document) && isObject(document.createElement);
  module.exports = function (it) {
    return is ? document.createElement(it) : {};
  };

  /***/
},
/* 52 */
/***/function (module, exports, __webpack_require__) {

  // 7.1.1 ToPrimitive(input [, PreferredType])
  var isObject = __webpack_require__(5);
  // instead of the ES6 spec version, we didn't implement @@toPrimitive case
  // and the second argument - flag - preferred type is a string
  module.exports = function (it, S) {
    if (!isObject(it)) return it;
    var fn, val;
    if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
    if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
    if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
    throw TypeError("Can't convert object to primitive value");
  };

  /***/
},
/* 53 */
/***/function (module, exports) {

  module.exports = function (bitmap, value) {
    return {
      enumerable: !(bitmap & 1),
      configurable: !(bitmap & 2),
      writable: !(bitmap & 4),
      value: value
    };
  };

  /***/
},
/* 54 */
/***/function (module, exports, __webpack_require__) {

  "use strict";

  // 19.1.2.1 Object.assign(target, source, ...)

  var getKeys = __webpack_require__(55);
  var gOPS = __webpack_require__(66);
  var pIE = __webpack_require__(67);
  var toObject = __webpack_require__(68);
  var IObject = __webpack_require__(10);
  var $assign = Object.assign;

  // should work with symbols and should have deterministic property order (V8 bug)
  module.exports = !$assign || __webpack_require__(7)(function () {
    var A = {};
    var B = {};
    // eslint-disable-next-line no-undef
    var S = Symbol();
    var K = 'abcdefghijklmnopqrst';
    A[S] = 7;
    K.split('').forEach(function (k) {
      B[k] = k;
    });
    return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
  }) ? function assign(target, source) {
    // eslint-disable-line no-unused-vars
    var T = toObject(target);
    var aLen = arguments.length;
    var index = 1;
    var getSymbols = gOPS.f;
    var isEnum = pIE.f;
    while (aLen > index) {
      var S = IObject(arguments[index++]);
      var keys = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S);
      var length = keys.length;
      var j = 0;
      var key;
      while (length > j) {
        if (isEnum.call(S, key = keys[j++])) T[key] = S[key];
      }
    }return T;
  } : $assign;

  /***/
},
/* 55 */
/***/function (module, exports, __webpack_require__) {

  // 19.1.2.14 / 15.2.3.14 Object.keys(O)
  var $keys = __webpack_require__(56);
  var enumBugKeys = __webpack_require__(65);

  module.exports = Object.keys || function keys(O) {
    return $keys(O, enumBugKeys);
  };

  /***/
},
/* 56 */
/***/function (module, exports, __webpack_require__) {

  var has = __webpack_require__(8);
  var toIObject = __webpack_require__(9);
  var arrayIndexOf = __webpack_require__(58)(false);
  var IE_PROTO = __webpack_require__(61)('IE_PROTO');

  module.exports = function (object, names) {
    var O = toIObject(object);
    var i = 0;
    var result = [];
    var key;
    for (key in O) {
      if (key != IE_PROTO) has(O, key) && result.push(key);
    } // Don't enum bug & hidden keys
    while (names.length > i) {
      if (has(O, key = names[i++])) {
        ~arrayIndexOf(result, key) || result.push(key);
      }
    }return result;
  };

  /***/
},
/* 57 */
/***/function (module, exports) {

  var toString = {}.toString;

  module.exports = function (it) {
    return toString.call(it).slice(8, -1);
  };

  /***/
},
/* 58 */
/***/function (module, exports, __webpack_require__) {

  // false -> Array#indexOf
  // true  -> Array#includes
  var toIObject = __webpack_require__(9);
  var toLength = __webpack_require__(59);
  var toAbsoluteIndex = __webpack_require__(60);
  module.exports = function (IS_INCLUDES) {
    return function ($this, el, fromIndex) {
      var O = toIObject($this);
      var length = toLength(O.length);
      var index = toAbsoluteIndex(fromIndex, length);
      var value;
      // Array#includes uses SameValueZero equality algorithm
      // eslint-disable-next-line no-self-compare
      if (IS_INCLUDES && el != el) while (length > index) {
        value = O[index++];
        // eslint-disable-next-line no-self-compare
        if (value != value) return true;
        // Array#indexOf ignores holes, Array#includes - not
      } else for (; length > index; index++) {
        if (IS_INCLUDES || index in O) {
          if (O[index] === el) return IS_INCLUDES || index || 0;
        }
      }return !IS_INCLUDES && -1;
    };
  };

  /***/
},
/* 59 */
/***/function (module, exports, __webpack_require__) {

  // 7.1.15 ToLength
  var toInteger = __webpack_require__(12);
  var min = Math.min;
  module.exports = function (it) {
    return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
  };

  /***/
},
/* 60 */
/***/function (module, exports, __webpack_require__) {

  var toInteger = __webpack_require__(12);
  var max = Math.max;
  var min = Math.min;
  module.exports = function (index, length) {
    index = toInteger(index);
    return index < 0 ? max(index + length, 0) : min(index, length);
  };

  /***/
},
/* 61 */
/***/function (module, exports, __webpack_require__) {

  var shared = __webpack_require__(62)('keys');
  var uid = __webpack_require__(64);
  module.exports = function (key) {
    return shared[key] || (shared[key] = uid(key));
  };

  /***/
},
/* 62 */
/***/function (module, exports, __webpack_require__) {

  var core = __webpack_require__(4);
  var global = __webpack_require__(3);
  var SHARED = '__core-js_shared__';
  var store = global[SHARED] || (global[SHARED] = {});

  (module.exports = function (key, value) {
    return store[key] || (store[key] = value !== undefined ? value : {});
  })('versions', []).push({
    version: core.version,
    mode: __webpack_require__(63) ? 'pure' : 'global',
    copyright: '© 2018 Denis Pushkarev (zloirock.ru)'
  });

  /***/
},
/* 63 */
/***/function (module, exports) {

  module.exports = true;

  /***/
},
/* 64 */
/***/function (module, exports) {

  var id = 0;
  var px = Math.random();
  module.exports = function (key) {
    return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
  };

  /***/
},
/* 65 */
/***/function (module, exports) {

  // IE 8- don't enum bug keys
  module.exports = 'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'.split(',');

  /***/
},
/* 66 */
/***/function (module, exports) {

  exports.f = Object.getOwnPropertySymbols;

  /***/
},
/* 67 */
/***/function (module, exports) {

  exports.f = {}.propertyIsEnumerable;

  /***/
},
/* 68 */
/***/function (module, exports, __webpack_require__) {

  // 7.1.13 ToObject(argument)
  var defined = __webpack_require__(11);
  module.exports = function (it) {
    return Object(defined(it));
  };

  /***/
},
/* 69 */
/***/function (module, exports, __webpack_require__) {

  /**
   * @preserve jed.js https://github.com/SlexAxton/Jed
   */
  /*
  -----------
  A gettext compatible i18n library for modern JavaScript Applications
  
  by Alex Sexton - AlexSexton [at] gmail - @SlexAxton
  
  MIT License
  
  A jQuery Foundation project - requires CLA to contribute -
  https://contribute.jquery.org/CLA/
  
  
  
  Jed offers the entire applicable GNU gettext spec'd set of
  functions, but also offers some nicer wrappers around them.
  The api for gettext was written for a language with no function
  overloading, so Jed allows a little more of that.
  
  Many thanks to Joshua I. Miller - unrtst@cpan.org - who wrote
  gettext.js back in 2008. I was able to vet a lot of my ideas
  against his. I also made sure Jed passed against his tests
  in order to offer easy upgrades -- jsgettext.berlios.de
  */
  (function (root, undef) {

    // Set up some underscore-style functions, if you already have
    // underscore, feel free to delete this section, and use it
    // directly, however, the amount of functions used doesn't
    // warrant having underscore as a full dependency.
    // Underscore 1.3.0 was used to port and is licensed
    // under the MIT License by Jeremy Ashkenas.
    var ArrayProto = Array.prototype,
        ObjProto = Object.prototype,
        slice = ArrayProto.slice,
        hasOwnProp = ObjProto.hasOwnProperty,
        nativeForEach = ArrayProto.forEach,
        breaker = {};

    // We're not using the OOP style _ so we don't need the
    // extra level of indirection. This still means that you
    // sub out for real `_` though.
    var _ = {
      forEach: function forEach(obj, iterator, context) {
        var i, l, key;
        if (obj === null) {
          return;
        }

        if (nativeForEach && obj.forEach === nativeForEach) {
          obj.forEach(iterator, context);
        } else if (obj.length === +obj.length) {
          for (i = 0, l = obj.length; i < l; i++) {
            if (i in obj && iterator.call(context, obj[i], i, obj) === breaker) {
              return;
            }
          }
        } else {
          for (key in obj) {
            if (hasOwnProp.call(obj, key)) {
              if (iterator.call(context, obj[key], key, obj) === breaker) {
                return;
              }
            }
          }
        }
      },
      extend: function extend(obj) {
        this.forEach(slice.call(arguments, 1), function (source) {
          for (var prop in source) {
            obj[prop] = source[prop];
          }
        });
        return obj;
      }
    };
    // END Miniature underscore impl

    // Jed is a constructor function
    var Jed = function Jed(options) {
      // Some minimal defaults
      this.defaults = {
        "locale_data": {
          "messages": {
            "": {
              "domain": "messages",
              "lang": "en",
              "plural_forms": "nplurals=2; plural=(n != 1);"
              // There are no default keys, though
            } }
        },
        // The default domain if one is missing
        "domain": "messages",
        // enable debug mode to log untranslated strings to the console
        "debug": false
      };

      // Mix in the sent options with the default options
      this.options = _.extend({}, this.defaults, options);
      this.textdomain(this.options.domain);

      if (options.domain && !this.options.locale_data[this.options.domain]) {
        throw new Error('Text domain set to non-existent domain: `' + options.domain + '`');
      }
    };

    // The gettext spec sets this character as the default
    // delimiter for context lookups.
    // e.g.: context\u0004key
    // If your translation company uses something different,
    // just change this at any time and it will use that instead.
    Jed.context_delimiter = String.fromCharCode(4);

    function getPluralFormFunc(plural_form_string) {
      return Jed.PF.compile(plural_form_string || "nplurals=2; plural=(n != 1);");
    }

    function Chain(key, i18n) {
      this._key = key;
      this._i18n = i18n;
    }

    // Create a chainable api for adding args prettily
    _.extend(Chain.prototype, {
      onDomain: function onDomain(domain) {
        this._domain = domain;
        return this;
      },
      withContext: function withContext(context) {
        this._context = context;
        return this;
      },
      ifPlural: function ifPlural(num, pkey) {
        this._val = num;
        this._pkey = pkey;
        return this;
      },
      fetch: function fetch(sArr) {
        if ({}.toString.call(sArr) != '[object Array]') {
          sArr = [].slice.call(arguments, 0);
        }
        return (sArr && sArr.length ? Jed.sprintf : function (x) {
          return x;
        })(this._i18n.dcnpgettext(this._domain, this._context, this._key, this._pkey, this._val), sArr);
      }
    });

    // Add functions to the Jed prototype.
    // These will be the functions on the object that's returned
    // from creating a `new Jed()`
    // These seem redundant, but they gzip pretty well.
    _.extend(Jed.prototype, {
      // The sexier api start point
      translate: function translate(key) {
        return new Chain(key, this);
      },

      textdomain: function textdomain(domain) {
        if (!domain) {
          return this._textdomain;
        }
        this._textdomain = domain;
      },

      gettext: function gettext(key) {
        return this.dcnpgettext.call(this, undef, undef, key);
      },

      dgettext: function dgettext(domain, key) {
        return this.dcnpgettext.call(this, domain, undef, key);
      },

      dcgettext: function dcgettext(domain, key /*, category */) {
        // Ignores the category anyways
        return this.dcnpgettext.call(this, domain, undef, key);
      },

      ngettext: function ngettext(skey, pkey, val) {
        return this.dcnpgettext.call(this, undef, undef, skey, pkey, val);
      },

      dngettext: function dngettext(domain, skey, pkey, val) {
        return this.dcnpgettext.call(this, domain, undef, skey, pkey, val);
      },

      dcngettext: function dcngettext(domain, skey, pkey, val /*, category */) {
        return this.dcnpgettext.call(this, domain, undef, skey, pkey, val);
      },

      pgettext: function pgettext(context, key) {
        return this.dcnpgettext.call(this, undef, context, key);
      },

      dpgettext: function dpgettext(domain, context, key) {
        return this.dcnpgettext.call(this, domain, context, key);
      },

      dcpgettext: function dcpgettext(domain, context, key /*, category */) {
        return this.dcnpgettext.call(this, domain, context, key);
      },

      npgettext: function npgettext(context, skey, pkey, val) {
        return this.dcnpgettext.call(this, undef, context, skey, pkey, val);
      },

      dnpgettext: function dnpgettext(domain, context, skey, pkey, val) {
        return this.dcnpgettext.call(this, domain, context, skey, pkey, val);
      },

      // The most fully qualified gettext function. It has every option.
      // Since it has every option, we can use it from every other method.
      // This is the bread and butter.
      // Technically there should be one more argument in this function for 'Category',
      // but since we never use it, we might as well not waste the bytes to define it.
      dcnpgettext: function dcnpgettext(domain, context, singular_key, plural_key, val) {
        // Set some defaults

        plural_key = plural_key || singular_key;

        // Use the global domain default if one
        // isn't explicitly passed in
        domain = domain || this._textdomain;

        var fallback;

        // Handle special cases

        // No options found
        if (!this.options) {
          // There's likely something wrong, but we'll return the correct key for english
          // We do this by instantiating a brand new Jed instance with the default set
          // for everything that could be broken.
          fallback = new Jed();
          return fallback.dcnpgettext.call(fallback, undefined, undefined, singular_key, plural_key, val);
        }

        // No translation data provided
        if (!this.options.locale_data) {
          throw new Error('No locale data provided.');
        }

        if (!this.options.locale_data[domain]) {
          throw new Error('Domain `' + domain + '` was not found.');
        }

        if (!this.options.locale_data[domain][""]) {
          throw new Error('No locale meta information provided.');
        }

        // Make sure we have a truthy key. Otherwise we might start looking
        // into the empty string key, which is the options for the locale
        // data.
        if (!singular_key) {
          throw new Error('No translation key found.');
        }

        var key = context ? context + Jed.context_delimiter + singular_key : singular_key,
            locale_data = this.options.locale_data,
            dict = locale_data[domain],
            defaultConf = (locale_data.messages || this.defaults.locale_data.messages)[""],
            pluralForms = dict[""].plural_forms || dict[""]["Plural-Forms"] || dict[""]["plural-forms"] || defaultConf.plural_forms || defaultConf["Plural-Forms"] || defaultConf["plural-forms"],
            val_list,
            res;

        var val_idx;
        if (val === undefined) {
          // No value passed in; assume singular key lookup.
          val_idx = 0;
        } else {
          // Value has been passed in; use plural-forms calculations.

          // Handle invalid numbers, but try casting strings for good measure
          if (typeof val != 'number') {
            val = parseInt(val, 10);

            if (isNaN(val)) {
              throw new Error('The number that was passed in is not a number.');
            }
          }

          val_idx = getPluralFormFunc(pluralForms)(val);
        }

        // Throw an error if a domain isn't found
        if (!dict) {
          throw new Error('No domain named `' + domain + '` could be found.');
        }

        val_list = dict[key];

        // If there is no match, then revert back to
        // english style singular/plural with the keys passed in.
        if (!val_list || val_idx > val_list.length) {
          if (this.options.missing_key_callback) {
            this.options.missing_key_callback(key, domain);
          }
          res = [singular_key, plural_key];

          // collect untranslated strings
          if (this.options.debug === true) {
            console.log(res[getPluralFormFunc(pluralForms)(val)]);
          }
          return res[getPluralFormFunc()(val)];
        }

        res = val_list[val_idx];

        // This includes empty strings on purpose
        if (!res) {
          res = [singular_key, plural_key];
          return res[getPluralFormFunc()(val)];
        }
        return res;
      }
    });

    // We add in sprintf capabilities for post translation value interolation
    // This is not internally used, so you can remove it if you have this
    // available somewhere else, or want to use a different system.

    // We _slightly_ modify the normal sprintf behavior to more gracefully handle
    // undefined values.

    /**
     sprintf() for JavaScript 0.7-beta1
     http://www.diveintojavascript.com/projects/javascript-sprintf
      Copyright (c) Alexandru Marasteanu <alexaholic [at) gmail (dot] com>
     All rights reserved.
      Redistribution and use in source and binary forms, with or without
     modification, are permitted provided that the following conditions are met:
         * Redistributions of source code must retain the above copyright
           notice, this list of conditions and the following disclaimer.
         * Redistributions in binary form must reproduce the above copyright
           notice, this list of conditions and the following disclaimer in the
           documentation and/or other materials provided with the distribution.
         * Neither the name of sprintf() for JavaScript nor the
           names of its contributors may be used to endorse or promote products
           derived from this software without specific prior written permission.
      THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
     ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
     WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
     DISCLAIMED. IN NO EVENT SHALL Alexandru Marasteanu BE LIABLE FOR ANY
     DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
     (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
     LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
     ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
     (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
     SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
    */
    var sprintf = function () {
      function get_type(variable) {
        return Object.prototype.toString.call(variable).slice(8, -1).toLowerCase();
      }
      function str_repeat(input, multiplier) {
        for (var output = []; multiplier > 0; output[--multiplier] = input) {/* do nothing */}
        return output.join('');
      }

      var str_format = function str_format() {
        if (!str_format.cache.hasOwnProperty(arguments[0])) {
          str_format.cache[arguments[0]] = str_format.parse(arguments[0]);
        }
        return str_format.format.call(null, str_format.cache[arguments[0]], arguments);
      };

      str_format.format = function (parse_tree, argv) {
        var cursor = 1,
            tree_length = parse_tree.length,
            node_type = '',
            arg,
            output = [],
            i,
            k,
            match,
            pad,
            pad_character,
            pad_length;
        for (i = 0; i < tree_length; i++) {
          node_type = get_type(parse_tree[i]);
          if (node_type === 'string') {
            output.push(parse_tree[i]);
          } else if (node_type === 'array') {
            match = parse_tree[i]; // convenience purposes only
            if (match[2]) {
              // keyword argument
              arg = argv[cursor];
              for (k = 0; k < match[2].length; k++) {
                if (!arg.hasOwnProperty(match[2][k])) {
                  throw sprintf('[sprintf] property "%s" does not exist', match[2][k]);
                }
                arg = arg[match[2][k]];
              }
            } else if (match[1]) {
              // positional argument (explicit)
              arg = argv[match[1]];
            } else {
              // positional argument (implicit)
              arg = argv[cursor++];
            }

            if (/[^s]/.test(match[8]) && get_type(arg) != 'number') {
              throw sprintf('[sprintf] expecting number but found %s', get_type(arg));
            }

            // Jed EDIT
            if (typeof arg == 'undefined' || arg === null) {
              arg = '';
            }
            // Jed EDIT

            switch (match[8]) {
              case 'b':
                arg = arg.toString(2);break;
              case 'c':
                arg = String.fromCharCode(arg);break;
              case 'd':
                arg = parseInt(arg, 10);break;
              case 'e':
                arg = match[7] ? arg.toExponential(match[7]) : arg.toExponential();break;
              case 'f':
                arg = match[7] ? parseFloat(arg).toFixed(match[7]) : parseFloat(arg);break;
              case 'o':
                arg = arg.toString(8);break;
              case 's':
                arg = (arg = String(arg)) && match[7] ? arg.substring(0, match[7]) : arg;break;
              case 'u':
                arg = Math.abs(arg);break;
              case 'x':
                arg = arg.toString(16);break;
              case 'X':
                arg = arg.toString(16).toUpperCase();break;
            }
            arg = /[def]/.test(match[8]) && match[3] && arg >= 0 ? '+' + arg : arg;
            pad_character = match[4] ? match[4] == '0' ? '0' : match[4].charAt(1) : ' ';
            pad_length = match[6] - String(arg).length;
            pad = match[6] ? str_repeat(pad_character, pad_length) : '';
            output.push(match[5] ? arg + pad : pad + arg);
          }
        }
        return output.join('');
      };

      str_format.cache = {};

      str_format.parse = function (fmt) {
        var _fmt = fmt,
            match = [],
            parse_tree = [],
            arg_names = 0;
        while (_fmt) {
          if ((match = /^[^\x25]+/.exec(_fmt)) !== null) {
            parse_tree.push(match[0]);
          } else if ((match = /^\x25{2}/.exec(_fmt)) !== null) {
            parse_tree.push('%');
          } else if ((match = /^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(_fmt)) !== null) {
            if (match[2]) {
              arg_names |= 1;
              var field_list = [],
                  replacement_field = match[2],
                  field_match = [];
              if ((field_match = /^([a-z_][a-z_\d]*)/i.exec(replacement_field)) !== null) {
                field_list.push(field_match[1]);
                while ((replacement_field = replacement_field.substring(field_match[0].length)) !== '') {
                  if ((field_match = /^\.([a-z_][a-z_\d]*)/i.exec(replacement_field)) !== null) {
                    field_list.push(field_match[1]);
                  } else if ((field_match = /^\[(\d+)\]/.exec(replacement_field)) !== null) {
                    field_list.push(field_match[1]);
                  } else {
                    throw '[sprintf] huh?';
                  }
                }
              } else {
                throw '[sprintf] huh?';
              }
              match[2] = field_list;
            } else {
              arg_names |= 2;
            }
            if (arg_names === 3) {
              throw '[sprintf] mixing positional and named placeholders is not (yet) supported';
            }
            parse_tree.push(match);
          } else {
            throw '[sprintf] huh?';
          }
          _fmt = _fmt.substring(match[0].length);
        }
        return parse_tree;
      };

      return str_format;
    }();

    var vsprintf = function vsprintf(fmt, argv) {
      argv.unshift(fmt);
      return sprintf.apply(null, argv);
    };

    Jed.parse_plural = function (plural_forms, n) {
      plural_forms = plural_forms.replace(/n/g, n);
      return Jed.parse_expression(plural_forms);
    };

    Jed.sprintf = function (fmt, args) {
      if ({}.toString.call(args) == '[object Array]') {
        return vsprintf(fmt, [].slice.call(args));
      }
      return sprintf.apply(this, [].slice.call(arguments));
    };

    Jed.prototype.sprintf = function () {
      return Jed.sprintf.apply(this, arguments);
    };
    // END sprintf Implementation

    // Start the Plural forms section
    // This is a full plural form expression parser. It is used to avoid
    // running 'eval' or 'new Function' directly against the plural
    // forms.
    //
    // This can be important if you get translations done through a 3rd
    // party vendor. I encourage you to use this instead, however, I
    // also will provide a 'precompiler' that you can use at build time
    // to output valid/safe function representations of the plural form
    // expressions. This means you can build this code out for the most
    // part.
    Jed.PF = {};

    Jed.PF.parse = function (p) {
      var plural_str = Jed.PF.extractPluralExpr(p);
      return Jed.PF.parser.parse.call(Jed.PF.parser, plural_str);
    };

    Jed.PF.compile = function (p) {
      // Handle trues and falses as 0 and 1
      function imply(val) {
        return val === true ? 1 : val ? val : 0;
      }

      var ast = Jed.PF.parse(p);
      return function (n) {
        return imply(Jed.PF.interpreter(ast)(n));
      };
    };

    Jed.PF.interpreter = function (ast) {
      return function (n) {
        var res;
        switch (ast.type) {
          case 'GROUP':
            return Jed.PF.interpreter(ast.expr)(n);
          case 'TERNARY':
            if (Jed.PF.interpreter(ast.expr)(n)) {
              return Jed.PF.interpreter(ast.truthy)(n);
            }
            return Jed.PF.interpreter(ast.falsey)(n);
          case 'OR':
            return Jed.PF.interpreter(ast.left)(n) || Jed.PF.interpreter(ast.right)(n);
          case 'AND':
            return Jed.PF.interpreter(ast.left)(n) && Jed.PF.interpreter(ast.right)(n);
          case 'LT':
            return Jed.PF.interpreter(ast.left)(n) < Jed.PF.interpreter(ast.right)(n);
          case 'GT':
            return Jed.PF.interpreter(ast.left)(n) > Jed.PF.interpreter(ast.right)(n);
          case 'LTE':
            return Jed.PF.interpreter(ast.left)(n) <= Jed.PF.interpreter(ast.right)(n);
          case 'GTE':
            return Jed.PF.interpreter(ast.left)(n) >= Jed.PF.interpreter(ast.right)(n);
          case 'EQ':
            return Jed.PF.interpreter(ast.left)(n) == Jed.PF.interpreter(ast.right)(n);
          case 'NEQ':
            return Jed.PF.interpreter(ast.left)(n) != Jed.PF.interpreter(ast.right)(n);
          case 'MOD':
            return Jed.PF.interpreter(ast.left)(n) % Jed.PF.interpreter(ast.right)(n);
          case 'VAR':
            return n;
          case 'NUM':
            return ast.val;
          default:
            throw new Error("Invalid Token found.");
        }
      };
    };

    Jed.PF.extractPluralExpr = function (p) {
      // trim first
      p = p.replace(/^\s\s*/, '').replace(/\s\s*$/, '');

      if (!/;\s*$/.test(p)) {
        p = p.concat(';');
      }

      var nplurals_re = /nplurals\=(\d+);/,
          plural_re = /plural\=(.*);/,
          nplurals_matches = p.match(nplurals_re),
          res = {},
          plural_matches;

      // Find the nplurals number
      if (nplurals_matches.length > 1) {
        res.nplurals = nplurals_matches[1];
      } else {
        throw new Error('nplurals not found in plural_forms string: ' + p);
      }

      // remove that data to get to the formula
      p = p.replace(nplurals_re, "");
      plural_matches = p.match(plural_re);

      if (!(plural_matches && plural_matches.length > 1)) {
        throw new Error('`plural` expression not found: ' + p);
      }
      return plural_matches[1];
    };

    /* Jison generated parser */
    Jed.PF.parser = function () {

      var parser = { trace: function trace() {},
        yy: {},
        symbols_: { "error": 2, "expressions": 3, "e": 4, "EOF": 5, "?": 6, ":": 7, "||": 8, "&&": 9, "<": 10, "<=": 11, ">": 12, ">=": 13, "!=": 14, "==": 15, "%": 16, "(": 17, ")": 18, "n": 19, "NUMBER": 20, "$accept": 0, "$end": 1 },
        terminals_: { 2: "error", 5: "EOF", 6: "?", 7: ":", 8: "||", 9: "&&", 10: "<", 11: "<=", 12: ">", 13: ">=", 14: "!=", 15: "==", 16: "%", 17: "(", 18: ")", 19: "n", 20: "NUMBER" },
        productions_: [0, [3, 2], [4, 5], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 3], [4, 1], [4, 1]],
        performAction: function anonymous(yytext, yyleng, yylineno, yy, yystate, $$, _$) {

          var $0 = $$.length - 1;
          switch (yystate) {
            case 1:
              return { type: 'GROUP', expr: $$[$0 - 1] };
              break;
            case 2:
              this.$ = { type: 'TERNARY', expr: $$[$0 - 4], truthy: $$[$0 - 2], falsey: $$[$0] };
              break;
            case 3:
              this.$ = { type: "OR", left: $$[$0 - 2], right: $$[$0] };
              break;
            case 4:
              this.$ = { type: "AND", left: $$[$0 - 2], right: $$[$0] };
              break;
            case 5:
              this.$ = { type: 'LT', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 6:
              this.$ = { type: 'LTE', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 7:
              this.$ = { type: 'GT', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 8:
              this.$ = { type: 'GTE', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 9:
              this.$ = { type: 'NEQ', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 10:
              this.$ = { type: 'EQ', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 11:
              this.$ = { type: 'MOD', left: $$[$0 - 2], right: $$[$0] };
              break;
            case 12:
              this.$ = { type: 'GROUP', expr: $$[$0 - 1] };
              break;
            case 13:
              this.$ = { type: 'VAR' };
              break;
            case 14:
              this.$ = { type: 'NUM', val: Number(yytext) };
              break;
          }
        },
        table: [{ 3: 1, 4: 2, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 1: [3] }, { 5: [1, 6], 6: [1, 7], 8: [1, 8], 9: [1, 9], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16] }, { 4: 17, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 5: [2, 13], 6: [2, 13], 7: [2, 13], 8: [2, 13], 9: [2, 13], 10: [2, 13], 11: [2, 13], 12: [2, 13], 13: [2, 13], 14: [2, 13], 15: [2, 13], 16: [2, 13], 18: [2, 13] }, { 5: [2, 14], 6: [2, 14], 7: [2, 14], 8: [2, 14], 9: [2, 14], 10: [2, 14], 11: [2, 14], 12: [2, 14], 13: [2, 14], 14: [2, 14], 15: [2, 14], 16: [2, 14], 18: [2, 14] }, { 1: [2, 1] }, { 4: 18, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 19, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 20, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 21, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 22, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 23, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 24, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 25, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 26, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 4: 27, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 6: [1, 7], 8: [1, 8], 9: [1, 9], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16], 18: [1, 28] }, { 6: [1, 7], 7: [1, 29], 8: [1, 8], 9: [1, 9], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16] }, { 5: [2, 3], 6: [2, 3], 7: [2, 3], 8: [2, 3], 9: [1, 9], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16], 18: [2, 3] }, { 5: [2, 4], 6: [2, 4], 7: [2, 4], 8: [2, 4], 9: [2, 4], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16], 18: [2, 4] }, { 5: [2, 5], 6: [2, 5], 7: [2, 5], 8: [2, 5], 9: [2, 5], 10: [2, 5], 11: [2, 5], 12: [2, 5], 13: [2, 5], 14: [2, 5], 15: [2, 5], 16: [1, 16], 18: [2, 5] }, { 5: [2, 6], 6: [2, 6], 7: [2, 6], 8: [2, 6], 9: [2, 6], 10: [2, 6], 11: [2, 6], 12: [2, 6], 13: [2, 6], 14: [2, 6], 15: [2, 6], 16: [1, 16], 18: [2, 6] }, { 5: [2, 7], 6: [2, 7], 7: [2, 7], 8: [2, 7], 9: [2, 7], 10: [2, 7], 11: [2, 7], 12: [2, 7], 13: [2, 7], 14: [2, 7], 15: [2, 7], 16: [1, 16], 18: [2, 7] }, { 5: [2, 8], 6: [2, 8], 7: [2, 8], 8: [2, 8], 9: [2, 8], 10: [2, 8], 11: [2, 8], 12: [2, 8], 13: [2, 8], 14: [2, 8], 15: [2, 8], 16: [1, 16], 18: [2, 8] }, { 5: [2, 9], 6: [2, 9], 7: [2, 9], 8: [2, 9], 9: [2, 9], 10: [2, 9], 11: [2, 9], 12: [2, 9], 13: [2, 9], 14: [2, 9], 15: [2, 9], 16: [1, 16], 18: [2, 9] }, { 5: [2, 10], 6: [2, 10], 7: [2, 10], 8: [2, 10], 9: [2, 10], 10: [2, 10], 11: [2, 10], 12: [2, 10], 13: [2, 10], 14: [2, 10], 15: [2, 10], 16: [1, 16], 18: [2, 10] }, { 5: [2, 11], 6: [2, 11], 7: [2, 11], 8: [2, 11], 9: [2, 11], 10: [2, 11], 11: [2, 11], 12: [2, 11], 13: [2, 11], 14: [2, 11], 15: [2, 11], 16: [2, 11], 18: [2, 11] }, { 5: [2, 12], 6: [2, 12], 7: [2, 12], 8: [2, 12], 9: [2, 12], 10: [2, 12], 11: [2, 12], 12: [2, 12], 13: [2, 12], 14: [2, 12], 15: [2, 12], 16: [2, 12], 18: [2, 12] }, { 4: 30, 17: [1, 3], 19: [1, 4], 20: [1, 5] }, { 5: [2, 2], 6: [1, 7], 7: [2, 2], 8: [1, 8], 9: [1, 9], 10: [1, 10], 11: [1, 11], 12: [1, 12], 13: [1, 13], 14: [1, 14], 15: [1, 15], 16: [1, 16], 18: [2, 2] }],
        defaultActions: { 6: [2, 1] },
        parseError: function parseError(str, hash) {
          throw new Error(str);
        },
        parse: function parse(input) {
          var self = this,
              stack = [0],
              vstack = [null],
              // semantic value stack
          lstack = [],
              // location stack
          table = this.table,
              yytext = '',
              yylineno = 0,
              yyleng = 0,
              recovering = 0,
              TERROR = 2,
              EOF = 1;

          //this.reductionCount = this.shiftCount = 0;

          this.lexer.setInput(input);
          this.lexer.yy = this.yy;
          this.yy.lexer = this.lexer;
          if (typeof this.lexer.yylloc == 'undefined') this.lexer.yylloc = {};
          var yyloc = this.lexer.yylloc;
          lstack.push(yyloc);

          if (typeof this.yy.parseError === 'function') this.parseError = this.yy.parseError;

          function popStack(n) {
            stack.length = stack.length - 2 * n;
            vstack.length = vstack.length - n;
            lstack.length = lstack.length - n;
          }

          function lex() {
            var token;
            token = self.lexer.lex() || 1; // $end = 1
            // if token isn't its numeric value, convert
            if (typeof token !== 'number') {
              token = self.symbols_[token] || token;
            }
            return token;
          }

          var symbol,
              preErrorSymbol,
              state,
              action,
              a,
              r,
              yyval = {},
              p,
              len,
              newState,
              expected;
          while (true) {
            // retreive state number from top of stack
            state = stack[stack.length - 1];

            // use default actions if available
            if (this.defaultActions[state]) {
              action = this.defaultActions[state];
            } else {
              if (symbol == null) symbol = lex();
              // read action for current state and first input
              action = table[state] && table[state][symbol];
            }

            // handle parse error
            _handle_error: if (typeof action === 'undefined' || !action.length || !action[0]) {

              if (!recovering) {
                // Report error
                expected = [];
                for (p in table[state]) {
                  if (this.terminals_[p] && p > 2) {
                    expected.push("'" + this.terminals_[p] + "'");
                  }
                }var errStr = '';
                if (this.lexer.showPosition) {
                  errStr = 'Parse error on line ' + (yylineno + 1) + ":\n" + this.lexer.showPosition() + "\nExpecting " + expected.join(', ') + ", got '" + this.terminals_[symbol] + "'";
                } else {
                  errStr = 'Parse error on line ' + (yylineno + 1) + ": Unexpected " + (symbol == 1 /*EOF*/ ? "end of input" : "'" + (this.terminals_[symbol] || symbol) + "'");
                }
                this.parseError(errStr, { text: this.lexer.match, token: this.terminals_[symbol] || symbol, line: this.lexer.yylineno, loc: yyloc, expected: expected });
              }

              // just recovered from another error
              if (recovering == 3) {
                if (symbol == EOF) {
                  throw new Error(errStr || 'Parsing halted.');
                }

                // discard current lookahead and grab another
                yyleng = this.lexer.yyleng;
                yytext = this.lexer.yytext;
                yylineno = this.lexer.yylineno;
                yyloc = this.lexer.yylloc;
                symbol = lex();
              }

              // try to recover from error
              while (1) {
                // check for error recovery rule in this state
                if (TERROR.toString() in table[state]) {
                  break;
                }
                if (state == 0) {
                  throw new Error(errStr || 'Parsing halted.');
                }
                popStack(1);
                state = stack[stack.length - 1];
              }

              preErrorSymbol = symbol; // save the lookahead token
              symbol = TERROR; // insert generic error symbol as new lookahead
              state = stack[stack.length - 1];
              action = table[state] && table[state][TERROR];
              recovering = 3; // allow 3 real symbols to be shifted before reporting a new error
            }

            // this shouldn't happen, unless resolve defaults are off
            if (action[0] instanceof Array && action.length > 1) {
              throw new Error('Parse Error: multiple actions possible at state: ' + state + ', token: ' + symbol);
            }

            switch (action[0]) {

              case 1:
                // shift
                //this.shiftCount++;

                stack.push(symbol);
                vstack.push(this.lexer.yytext);
                lstack.push(this.lexer.yylloc);
                stack.push(action[1]); // push state
                symbol = null;
                if (!preErrorSymbol) {
                  // normal execution/no error
                  yyleng = this.lexer.yyleng;
                  yytext = this.lexer.yytext;
                  yylineno = this.lexer.yylineno;
                  yyloc = this.lexer.yylloc;
                  if (recovering > 0) recovering--;
                } else {
                  // error just occurred, resume old lookahead f/ before error
                  symbol = preErrorSymbol;
                  preErrorSymbol = null;
                }
                break;

              case 2:
                // reduce
                //this.reductionCount++;

                len = this.productions_[action[1]][1];

                // perform semantic action
                yyval.$ = vstack[vstack.length - len]; // default to $$ = $1
                // default location, uses first token for firsts, last for lasts
                yyval._$ = {
                  first_line: lstack[lstack.length - (len || 1)].first_line,
                  last_line: lstack[lstack.length - 1].last_line,
                  first_column: lstack[lstack.length - (len || 1)].first_column,
                  last_column: lstack[lstack.length - 1].last_column
                };
                r = this.performAction.call(yyval, yytext, yyleng, yylineno, this.yy, action[1], vstack, lstack);

                if (typeof r !== 'undefined') {
                  return r;
                }

                // pop off stack
                if (len) {
                  stack = stack.slice(0, -1 * len * 2);
                  vstack = vstack.slice(0, -1 * len);
                  lstack = lstack.slice(0, -1 * len);
                }

                stack.push(this.productions_[action[1]][0]); // push nonterminal (reduce)
                vstack.push(yyval.$);
                lstack.push(yyval._$);
                // goto new state = table[STATE][NONTERMINAL]
                newState = table[stack[stack.length - 2]][stack[stack.length - 1]];
                stack.push(newState);
                break;

              case 3:
                // accept
                return true;
            }
          }

          return true;
        } }; /* Jison generated lexer */
      var lexer = function () {

        var lexer = { EOF: 1,
          parseError: function parseError(str, hash) {
            if (this.yy.parseError) {
              this.yy.parseError(str, hash);
            } else {
              throw new Error(str);
            }
          },
          setInput: function setInput(input) {
            this._input = input;
            this._more = this._less = this.done = false;
            this.yylineno = this.yyleng = 0;
            this.yytext = this.matched = this.match = '';
            this.conditionStack = ['INITIAL'];
            this.yylloc = { first_line: 1, first_column: 0, last_line: 1, last_column: 0 };
            return this;
          },
          input: function input() {
            var ch = this._input[0];
            this.yytext += ch;
            this.yyleng++;
            this.match += ch;
            this.matched += ch;
            var lines = ch.match(/\n/);
            if (lines) this.yylineno++;
            this._input = this._input.slice(1);
            return ch;
          },
          unput: function unput(ch) {
            this._input = ch + this._input;
            return this;
          },
          more: function more() {
            this._more = true;
            return this;
          },
          pastInput: function pastInput() {
            var past = this.matched.substr(0, this.matched.length - this.match.length);
            return (past.length > 20 ? '...' : '') + past.substr(-20).replace(/\n/g, "");
          },
          upcomingInput: function upcomingInput() {
            var next = this.match;
            if (next.length < 20) {
              next += this._input.substr(0, 20 - next.length);
            }
            return (next.substr(0, 20) + (next.length > 20 ? '...' : '')).replace(/\n/g, "");
          },
          showPosition: function showPosition() {
            var pre = this.pastInput();
            var c = new Array(pre.length + 1).join("-");
            return pre + this.upcomingInput() + "\n" + c + "^";
          },
          next: function next() {
            if (this.done) {
              return this.EOF;
            }
            if (!this._input) this.done = true;

            var token, match, col, lines;
            if (!this._more) {
              this.yytext = '';
              this.match = '';
            }
            var rules = this._currentRules();
            for (var i = 0; i < rules.length; i++) {
              match = this._input.match(this.rules[rules[i]]);
              if (match) {
                lines = match[0].match(/\n.*/g);
                if (lines) this.yylineno += lines.length;
                this.yylloc = { first_line: this.yylloc.last_line,
                  last_line: this.yylineno + 1,
                  first_column: this.yylloc.last_column,
                  last_column: lines ? lines[lines.length - 1].length - 1 : this.yylloc.last_column + match[0].length };
                this.yytext += match[0];
                this.match += match[0];
                this.matches = match;
                this.yyleng = this.yytext.length;
                this._more = false;
                this._input = this._input.slice(match[0].length);
                this.matched += match[0];
                token = this.performAction.call(this, this.yy, this, rules[i], this.conditionStack[this.conditionStack.length - 1]);
                if (token) return token;else return;
              }
            }
            if (this._input === "") {
              return this.EOF;
            } else {
              this.parseError('Lexical error on line ' + (this.yylineno + 1) + '. Unrecognized text.\n' + this.showPosition(), { text: "", token: null, line: this.yylineno });
            }
          },
          lex: function lex() {
            var r = this.next();
            if (typeof r !== 'undefined') {
              return r;
            } else {
              return this.lex();
            }
          },
          begin: function begin(condition) {
            this.conditionStack.push(condition);
          },
          popState: function popState() {
            return this.conditionStack.pop();
          },
          _currentRules: function _currentRules() {
            return this.conditions[this.conditionStack[this.conditionStack.length - 1]].rules;
          },
          topState: function topState() {
            return this.conditionStack[this.conditionStack.length - 2];
          },
          pushState: function begin(condition) {
            this.begin(condition);
          } };
        lexer.performAction = function anonymous(yy, yy_, $avoiding_name_collisions, YY_START) {

          var YYSTATE = YY_START;
          switch ($avoiding_name_collisions) {
            case 0:
              /* skip whitespace */
              break;
            case 1:
              return 20;
              break;
            case 2:
              return 19;
              break;
            case 3:
              return 8;
              break;
            case 4:
              return 9;
              break;
            case 5:
              return 6;
              break;
            case 6:
              return 7;
              break;
            case 7:
              return 11;
              break;
            case 8:
              return 13;
              break;
            case 9:
              return 10;
              break;
            case 10:
              return 12;
              break;
            case 11:
              return 14;
              break;
            case 12:
              return 15;
              break;
            case 13:
              return 16;
              break;
            case 14:
              return 17;
              break;
            case 15:
              return 18;
              break;
            case 16:
              return 5;
              break;
            case 17:
              return 'INVALID';
              break;
          }
        };
        lexer.rules = [/^\s+/, /^[0-9]+(\.[0-9]+)?\b/, /^n\b/, /^\|\|/, /^&&/, /^\?/, /^:/, /^<=/, /^>=/, /^</, /^>/, /^!=/, /^==/, /^%/, /^\(/, /^\)/, /^$/, /^./];
        lexer.conditions = { "INITIAL": { "rules": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17], "inclusive": true } };return lexer;
      }();
      parser.lexer = lexer;
      return parser;
    }();
    // End parser

    // Handle node, amd, and global systems
    if (true) {
      if (typeof module !== 'undefined' && module.exports) {
        exports = module.exports = Jed;
      }
      exports.Jed = Jed;
    } else {
      if (typeof define === 'function' && define.amd) {
        define(function () {
          return Jed;
        });
      }
      // Leak a global regardless of module system
      root['Jed'] = Jed;
    }
  })(this);

  /***/
},
/* 70 */
/***/function (module, exports, __webpack_require__) {

  /* WEBPACK VAR INJECTION */(function (process) {
    module.exports = function memize(fn, options) {
      var size = 0,
          maxSize,
          head,
          tail;

      if (options && options.maxSize) {
        maxSize = options.maxSize;
      }

      function memoized() /* ...args */{
        var node = head,
            len = arguments.length,
            args,
            i;

        searchCache: while (node) {
          // Perform a shallow equality test to confirm that whether the node
          // under test is a candidate for the arguments passed. Two arrays
          // are shallowly equal if their length matches and each entry is
          // strictly equal between the two sets. Avoid abstracting to a
          // function which could incur an arguments leaking deoptimization.

          // Check whether node arguments match arguments length
          if (node.args.length !== arguments.length) {
            node = node.next;
            continue;
          }

          // Check whether node arguments match arguments values
          for (i = 0; i < len; i++) {
            if (node.args[i] !== arguments[i]) {
              node = node.next;
              continue searchCache;
            }
          }

          // At this point we can assume we've found a match

          // Surface matched node to head if not already
          if (node !== head) {
            // As tail, shift to previous. Must only shift if not also
            // head, since if both head and tail, there is no previous.
            if (node === tail) {
              tail = node.prev;
            }

            // Adjust siblings to point to each other. If node was tail,
            // this also handles new tail's empty `next` assignment.
            node.prev.next = node.next;
            if (node.next) {
              node.next.prev = node.prev;
            }

            node.next = head;
            node.prev = null;
            head.prev = node;
            head = node;
          }

          // Return immediately
          return node.val;
        }

        // No cached value found. Continue to insertion phase:

        // Create a copy of arguments (avoid leaking deoptimization)
        args = new Array(len);
        for (i = 0; i < len; i++) {
          args[i] = arguments[i];
        }

        node = {
          args: args,

          // Generate the result from original function
          val: fn.apply(null, args)
        };

        // Don't need to check whether node is already head, since it would
        // have been returned above already if it was

        // Shift existing head down list
        if (head) {
          head.prev = node;
          node.next = head;
        } else {
          // If no head, follows that there's no tail (at initial or reset)
          tail = node;
        }

        // Trim tail if we're reached max size and are pending cache insertion
        if (size === maxSize) {
          tail = tail.prev;
          tail.next = null;
        } else {
          size++;
        }

        head = node;

        return node.val;
      }

      memoized.clear = function () {
        head = null;
        tail = null;
        size = 0;
      };

      if (process.env.NODE_ENV === 'test') {
        // Cache is not exposed in the public API, but used in tests to ensure
        // expected list progression
        memoized.getCache = function () {
          return [head, tail, size];
        };
      }

      return memoized;
    };

    /* WEBPACK VAR INJECTION */
  }).call(exports, __webpack_require__(71));

  /***/
},
/* 71 */
/***/function (module, exports) {

  // shim for using process in browser
  var process = module.exports = {};

  // cached from whatever global is present so that test runners that stub it
  // don't break things.  But we need to wrap it in a try catch in case it is
  // wrapped in strict mode code which doesn't define any globals.  It's inside a
  // function because try/catches deoptimize in certain engines.

  var cachedSetTimeout;
  var cachedClearTimeout;

  function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
  }
  function defaultClearTimeout() {
    throw new Error('clearTimeout has not been defined');
  }
  (function () {
    try {
      if (typeof setTimeout === 'function') {
        cachedSetTimeout = setTimeout;
      } else {
        cachedSetTimeout = defaultSetTimout;
      }
    } catch (e) {
      cachedSetTimeout = defaultSetTimout;
    }
    try {
      if (typeof clearTimeout === 'function') {
        cachedClearTimeout = clearTimeout;
      } else {
        cachedClearTimeout = defaultClearTimeout;
      }
    } catch (e) {
      cachedClearTimeout = defaultClearTimeout;
    }
  })();
  function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
      //normal enviroments in sane situations
      return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
      cachedSetTimeout = setTimeout;
      return setTimeout(fun, 0);
    }
    try {
      // when when somebody has screwed with setTimeout but no I.E. maddness
      return cachedSetTimeout(fun, 0);
    } catch (e) {
      try {
        // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
        return cachedSetTimeout.call(null, fun, 0);
      } catch (e) {
        // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
        return cachedSetTimeout.call(this, fun, 0);
      }
    }
  }
  function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
      //normal enviroments in sane situations
      return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
      cachedClearTimeout = clearTimeout;
      return clearTimeout(marker);
    }
    try {
      // when when somebody has screwed with setTimeout but no I.E. maddness
      return cachedClearTimeout(marker);
    } catch (e) {
      try {
        // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
        return cachedClearTimeout.call(null, marker);
      } catch (e) {
        // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
        // Some versions of I.E. have different rules for clearTimeout vs setTimeout
        return cachedClearTimeout.call(this, marker);
      }
    }
  }
  var queue = [];
  var draining = false;
  var currentQueue;
  var queueIndex = -1;

  function cleanUpNextTick() {
    if (!draining || !currentQueue) {
      return;
    }
    draining = false;
    if (currentQueue.length) {
      queue = currentQueue.concat(queue);
    } else {
      queueIndex = -1;
    }
    if (queue.length) {
      drainQueue();
    }
  }

  function drainQueue() {
    if (draining) {
      return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while (len) {
      currentQueue = queue;
      queue = [];
      while (++queueIndex < len) {
        if (currentQueue) {
          currentQueue[queueIndex].run();
        }
      }
      queueIndex = -1;
      len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
  }

  process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
      for (var i = 1; i < arguments.length; i++) {
        args[i - 1] = arguments[i];
      }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
      runTimeout(drainQueue);
    }
  };

  // v8 likes predictible objects
  function Item(fun, array) {
    this.fun = fun;
    this.array = array;
  }
  Item.prototype.run = function () {
    this.fun.apply(null, this.array);
  };
  process.title = 'browser';
  process.browser = true;
  process.env = {};
  process.argv = [];
  process.version = ''; // empty string to avoid regexp issues
  process.versions = {};

  function noop() {}

  process.on = noop;
  process.addListener = noop;
  process.once = noop;
  process.off = noop;
  process.removeListener = noop;
  process.removeAllListeners = noop;
  process.emit = noop;
  process.prependListener = noop;
  process.prependOnceListener = noop;

  process.listeners = function (name) {
    return [];
  };

  process.binding = function (name) {
    throw new Error('process.binding is not supported');
  };

  process.cwd = function () {
    return '/';
  };
  process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
  };
  process.umask = function () {
    return 0;
  };

  /***/
}]
/******/);