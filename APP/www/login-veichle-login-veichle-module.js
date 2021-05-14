(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["login-veichle-login-veichle-module"],{

/***/ "bQul":
/*!*********************************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/login-veichle/login-veichle.page.html ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header>\n  <ion-toolbar>\n    <ion-title>login_veichle</ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content>\n\n</ion-content>\n");

/***/ }),

/***/ "cIYs":
/*!***************************************************************!*\
  !*** ./src/app/login-veichle/login-veichle-routing.module.ts ***!
  \***************************************************************/
/*! exports provided: LoginVeichlePageRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginVeichlePageRoutingModule", function() { return LoginVeichlePageRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _login_veichle_page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./login-veichle.page */ "fIVx");




const routes = [
    {
        path: '',
        component: _login_veichle_page__WEBPACK_IMPORTED_MODULE_3__["LoginVeichlePage"]
    }
];
let LoginVeichlePageRoutingModule = class LoginVeichlePageRoutingModule {
};
LoginVeichlePageRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]],
    })
], LoginVeichlePageRoutingModule);



/***/ }),

/***/ "fIVx":
/*!*****************************************************!*\
  !*** ./src/app/login-veichle/login-veichle.page.ts ***!
  \*****************************************************/
/*! exports provided: LoginVeichlePage */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginVeichlePage", function() { return LoginVeichlePage; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_login_veichle_page_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./login-veichle.page.html */ "bQul");
/* harmony import */ var _login_veichle_page_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./login-veichle.page.scss */ "y8+z");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");




let LoginVeichlePage = class LoginVeichlePage {
    constructor() { }
    ngOnInit() {
    }
};
LoginVeichlePage.ctorParameters = () => [];
LoginVeichlePage = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-login-veichle',
        template: _raw_loader_login_veichle_page_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_login_veichle_page_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], LoginVeichlePage);



/***/ }),

/***/ "rH1d":
/*!*******************************************************!*\
  !*** ./src/app/login-veichle/login-veichle.module.ts ***!
  \*******************************************************/
/*! exports provided: LoginVeichlePageModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginVeichlePageModule", function() { return LoginVeichlePageModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "ofXK");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ "3Pt+");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _login_veichle_routing_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./login-veichle-routing.module */ "cIYs");
/* harmony import */ var _login_veichle_page__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./login-veichle.page */ "fIVx");







let LoginVeichlePageModule = class LoginVeichlePageModule {
};
LoginVeichlePageModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
            _angular_forms__WEBPACK_IMPORTED_MODULE_3__["FormsModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicModule"],
            _login_veichle_routing_module__WEBPACK_IMPORTED_MODULE_5__["LoginVeichlePageRoutingModule"]
        ],
        declarations: [_login_veichle_page__WEBPACK_IMPORTED_MODULE_6__["LoginVeichlePage"]]
    })
], LoginVeichlePageModule);



/***/ }),

/***/ "y8+z":
/*!*******************************************************!*\
  !*** ./src/app/login-veichle/login-veichle.page.scss ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJsb2dpbi12ZWljaGxlLnBhZ2Uuc2NzcyJ9 */");

/***/ })

}]);
//# sourceMappingURL=login-veichle-login-veichle-module.js.map