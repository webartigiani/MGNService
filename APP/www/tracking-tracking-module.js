(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["tracking-tracking-module"],{

/***/ "9zfe":
/*!*****************************************************!*\
  !*** ./src/app/tracking/tracking-routing.module.ts ***!
  \*****************************************************/
/*! exports provided: TrackingPageRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TrackingPageRoutingModule", function() { return TrackingPageRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _tracking_page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./tracking.page */ "HVnp");




const routes = [
    {
        path: '',
        component: _tracking_page__WEBPACK_IMPORTED_MODULE_3__["TrackingPage"]
    }
];
let TrackingPageRoutingModule = class TrackingPageRoutingModule {
};
TrackingPageRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]],
    })
], TrackingPageRoutingModule);



/***/ }),

/***/ "HVnp":
/*!*******************************************!*\
  !*** ./src/app/tracking/tracking.page.ts ***!
  \*******************************************/
/*! exports provided: TrackingPage */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TrackingPage", function() { return TrackingPage; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_tracking_page_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./tracking.page.html */ "z3Av");
/* harmony import */ var _tracking_page_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./tracking.page.scss */ "SO6k");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");




let TrackingPage = class TrackingPage {
    constructor() { }
    ngOnInit() {
    }
};
TrackingPage.ctorParameters = () => [];
TrackingPage = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-tracking',
        template: _raw_loader_tracking_page_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_tracking_page_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], TrackingPage);



/***/ }),

/***/ "SO6k":
/*!*********************************************!*\
  !*** ./src/app/tracking/tracking.page.scss ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJ0cmFja2luZy5wYWdlLnNjc3MifQ== */");

/***/ }),

/***/ "ZyQ5":
/*!*********************************************!*\
  !*** ./src/app/tracking/tracking.module.ts ***!
  \*********************************************/
/*! exports provided: TrackingPageModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TrackingPageModule", function() { return TrackingPageModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "ofXK");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ "3Pt+");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _tracking_routing_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./tracking-routing.module */ "9zfe");
/* harmony import */ var _tracking_page__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./tracking.page */ "HVnp");







let TrackingPageModule = class TrackingPageModule {
};
TrackingPageModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
            _angular_forms__WEBPACK_IMPORTED_MODULE_3__["FormsModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicModule"],
            _tracking_routing_module__WEBPACK_IMPORTED_MODULE_5__["TrackingPageRoutingModule"]
        ],
        declarations: [_tracking_page__WEBPACK_IMPORTED_MODULE_6__["TrackingPage"]]
    })
], TrackingPageModule);



/***/ }),

/***/ "z3Av":
/*!***********************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/tracking/tracking.page.html ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header>\n  <ion-toolbar>\n    <ion-title>tracking</ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content>\n\n</ion-content>\n");

/***/ })

}]);
//# sourceMappingURL=tracking-tracking-module.js.map