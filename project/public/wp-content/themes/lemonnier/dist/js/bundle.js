/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/components/header.component.js":
/*!***********************************************!*\
  !*** ./src/js/components/header.component.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   Header: () => (/* binding */ Header)\n/* harmony export */ });\nfunction _typeof(o) { \"@babel/helpers - typeof\"; return _typeof = \"function\" == typeof Symbol && \"symbol\" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && \"function\" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? \"symbol\" : typeof o; }, _typeof(o); }\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, \"prototype\", { writable: false }); return Constructor; }\nfunction _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\nfunction _toPropertyKey(t) { var i = _toPrimitive(t, \"string\"); return \"symbol\" == _typeof(i) ? i : i + \"\"; }\nfunction _toPrimitive(t, r) { if (\"object\" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || \"default\"); if (\"object\" != _typeof(i)) return i; throw new TypeError(\"@@toPrimitive must return a primitive value.\"); } return (\"string\" === r ? String : Number)(t); }\nvar Header = /*#__PURE__*/function () {\n  function Header() {\n    _classCallCheck(this, Header);\n    _defineProperty(this, \"prevX\", 0);\n  }\n  return _createClass(Header, [{\n    key: \"_constructor\",\n    value: function _constructor() {}\n  }, {\n    key: \"init\",\n    value: function init() {\n      console.log('init header JS class OK');\n      this.listenScroll();\n      this.listenBurger();\n    }\n  }, {\n    key: \"listenScroll\",\n    value: function listenScroll() {\n      var _this = this;\n      document.addEventListener('scroll', function () {\n        _this.headerBehavior();\n      });\n    }\n  }, {\n    key: \"headerBehavior\",\n    value: function headerBehavior() {\n      var posy = window.scrollY;\n      var limit = document.querySelector('#header').clientHeight;\n      console.log('limit : ', limit);\n      console.log(this.prevX < posy, this.prevX, posy);\n      /// if down\n      if (this.prevX < posy || posy == 0) {\n        if (posy > limit) {\n          document.querySelector('body').classList.add('scrolled');\n          document.querySelector('body').classList.remove('scrolled-up');\n        } else if (posy == 0) {\n          document.querySelector('body').classList.remove('scrolled');\n          document.querySelector('body').classList.remove('scrolled-up');\n        }\n        this.prevX = posy;\n      } else if (this.prevX > posy) {\n        console.log('on remonte', this.prevX - posy);\n        if (this.prevX - posy > 100 && posy > limit) {\n          document.querySelector('body').classList.remove('scrolled');\n          document.querySelector('body').classList.add('scrolled-up');\n          this.prevX = posy;\n        } else if (posy < limit) {\n          document.querySelector('body').classList.add('scrolled');\n          document.querySelector('body').classList.remove('scrolled-up');\n          this.prevX = posy;\n        }\n      }\n    }\n  }, {\n    key: \"listenBurger\",\n    value: function listenBurger() {\n      document.querySelector('.burger').addEventListener('click', function () {\n        document.querySelector('#header').classList.toggle('menu-open');\n        document.querySelector('body').classList.toggle('menu-open');\n      });\n    }\n  }]);\n}();\n\n//# sourceURL=webpack://lemonnier/./src/js/components/header.component.js?");

/***/ }),

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/main.scss */ \"./src/scss/main.scss\");\n/* harmony import */ var _components_header_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/header.component */ \"./src/js/components/header.component.js\");\n// Import des modules ou des fichiers nécessaires\n// import { someFunction } from './utils';\n// import '../scss/main.scss';\n\n// Code JavaScript principal\n// document.addEventListener('DOMContentLoaded', function() {\n//     // Votre code JavaScript ici\n//     console.log('Le DOM est prêt');\n//     someFunction(); // Appel d'une fonction définie dans un autre fichier\n// });\n\n\n\nvar test = new _components_header_component__WEBPACK_IMPORTED_MODULE_1__.Header();\ntest.init();\n\n//# sourceURL=webpack://lemonnier/./src/js/main.js?");

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://lemonnier/./src/scss/main.scss?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/js/main.js");
/******/ 	
/******/ })()
;