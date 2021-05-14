(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["check-connection-check-connection-module"],{

/***/ "2Py1":
/*!*********************************************************************!*\
  !*** ./src/app/check-connection/check-connection-routing.module.ts ***!
  \*********************************************************************/
/*! exports provided: CheckConnectionPageRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CheckConnectionPageRoutingModule", function() { return CheckConnectionPageRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _check_connection_page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./check-connection.page */ "ooxZ");




const routes = [
    {
        path: '',
        component: _check_connection_page__WEBPACK_IMPORTED_MODULE_3__["CheckConnectionPage"]
    }
];
let CheckConnectionPageRoutingModule = class CheckConnectionPageRoutingModule {
};
CheckConnectionPageRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]],
    })
], CheckConnectionPageRoutingModule);



/***/ }),

/***/ "Dqt7":
/*!*************************************************************!*\
  !*** ./src/app/check-connection/check-connection.module.ts ***!
  \*************************************************************/
/*! exports provided: CheckConnectionPageModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CheckConnectionPageModule", function() { return CheckConnectionPageModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "ofXK");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ "3Pt+");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _check_connection_routing_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./check-connection-routing.module */ "2Py1");
/* harmony import */ var _check_connection_page__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./check-connection.page */ "ooxZ");







let CheckConnectionPageModule = class CheckConnectionPageModule {
};
CheckConnectionPageModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
            _angular_forms__WEBPACK_IMPORTED_MODULE_3__["FormsModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicModule"],
            _check_connection_routing_module__WEBPACK_IMPORTED_MODULE_5__["CheckConnectionPageRoutingModule"]
        ],
        declarations: [_check_connection_page__WEBPACK_IMPORTED_MODULE_6__["CheckConnectionPage"]]
    })
], CheckConnectionPageModule);



/***/ }),

/***/ "VwLQ":
/*!*************************************************************!*\
  !*** ./src/app/check-connection/check-connection.page.scss ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJjaGVjay1jb25uZWN0aW9uLnBhZ2Uuc2NzcyJ9 */");

/***/ }),

/***/ "ooxZ":
/*!***********************************************************!*\
  !*** ./src/app/check-connection/check-connection.page.ts ***!
  \***********************************************************/
/*! exports provided: CheckConnectionPage */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CheckConnectionPage", function() { return CheckConnectionPage; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_check_connection_page_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./check-connection.page.html */ "x+lS");
/* harmony import */ var _check_connection_page_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./check-connection.page.scss */ "VwLQ");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../Classes/LocalData */ "/zBf");





// WebArtigiani Classes





let CheckConnectionPage = class CheckConnectionPage {
    // #region Constructors
    constructor(
    // WebArtigiani
    api, utils, components, geolocation, localData, navCtrl) {
        // Constructor
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.localData = localData;
        this.navCtrl = navCtrl;
        // clears console
        console.clear();
    }
    // #endregion Constructors
    // #region View LifeCycle Events
    // see: https://angular.io/guide/lifecycle-hooks
    ngAfterViewChecked() {
        console.log('ngAfterViewInit');
        setTimeout(() => {
            this.navCtrl.navigateRoot('home');
        }, 3000);
    }
};
CheckConnectionPage.ctorParameters = () => [
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_5__["ApiService"] },
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_6__["UtilsService"] },
    { type: _Classes_Components__WEBPACK_IMPORTED_MODULE_7__["ComponentsService"] },
    { type: _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_8__["GeoLocationService"] },
    { type: _Classes_LocalData__WEBPACK_IMPORTED_MODULE_9__["LocalDataService"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["NavController"] }
];
CheckConnectionPage = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-check-connection',
        template: _raw_loader_check_connection_page_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_check_connection_page_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], CheckConnectionPage);



/***/ }),

/***/ "x+lS":
/*!***************************************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/check-connection/check-connection.page.html ***!
  \***************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header>\n  <ion-toolbar>\n    <ion-title>checkConnection</ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content>\n  loading...\n</ion-content>\n");

/***/ })

}]);
//# sourceMappingURL=check-connection-check-connection-module.js.map