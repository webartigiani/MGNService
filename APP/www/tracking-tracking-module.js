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
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _Classes_App__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Classes/App */ "FNOQ");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../Classes/LocalData */ "/zBf");






// WebArtigiani Classes






let TrackingPage = class TrackingPage {
    // #endregion Variables
    // #region Constructor
    constructor(
    // WebArtigiani
    app, api, utils, components, geolocation, localData, 
    // Angular
    platform, navCtrl) {
        // Constructor code...
        this.app = app;
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.localData = localData;
        this.platform = platform;
        this.navCtrl = navCtrl;
        // #region Variables
        this.counter = 0;
        this.sessionID = '';
        this.gpsData = {};
        // gets current session_id from storage
        this.sessionID = this.localData.readValue('session_id');
    }
    // #endregion Constructor
    // #region Component LifeCycle
    ngAfterViewInit() {
        this.geoLocate();
        setInterval(() => {
            this.geoLocate();
        }, src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].LOCATION_INERVAL * 1000);
    }
    // #endregion Component LifeCycls
    // #region Public Methods
    dummy() {
    }
    geoLocate() {
        /**
         * Geo-locate the device
         */
        this.geolocation.locate().then((data) => {
            // Geo-location OK
            if (data.valid) {
                this.gpsData = data;
                this.counter++;
            }
            console.log('Geo-location result', data);
            this.api.continueTracking(this.sessionID, data)
                .then((result) => {
                // tracking-data saved
                console.log('Geo-location API result', result);
            }).catch((error) => {
                // API Error
                console.error(error);
            });
        }).catch((error) => {
            // geo-location error
            console.error('Geo-location error', error);
        });
    }
};
TrackingPage.ctorParameters = () => [
    { type: _Classes_App__WEBPACK_IMPORTED_MODULE_6__["AppService"] },
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_7__["ApiService"] },
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_8__["UtilsService"] },
    { type: _Classes_Components__WEBPACK_IMPORTED_MODULE_9__["ComponentsService"] },
    { type: _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_10__["GeoLocationService"] },
    { type: _Classes_LocalData__WEBPACK_IMPORTED_MODULE_11__["LocalDataService"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_5__["Platform"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_5__["NavController"] }
];
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
/* harmony default export */ __webpack_exports__["default"] = ("div#debug {\n  position: absolute;\n  width: 100%;\n  height: 80px;\n  bottom: 80px;\n  background-color: orange;\n  color: blue;\n  font-size: 0.75em;\n  font-style: italic;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy4uL3RyYWNraW5nLnBhZ2Uuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLGtCQUFBO0VBQ0EsV0FBQTtFQUNBLFlBQUE7RUFDQSxZQUFBO0VBQ0Esd0JBQUE7RUFDQSxXQUFBO0VBQ0EsaUJBQUE7RUFDQSxrQkFBQTtBQUNGIiwiZmlsZSI6InRyYWNraW5nLnBhZ2Uuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbImRpdiNkZWJ1ZyB7XG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgd2lkdGg6MTAwJTtcbiAgaGVpZ2h0OjgwcHg7XG4gIGJvdHRvbTo4MHB4O1xuICBiYWNrZ3JvdW5kLWNvbG9yOiBvcmFuZ2U7XG4gIGNvbG9yOmJsdWU7XG4gIGZvbnQtc2l6ZTogLjc1ZW07XG4gIGZvbnQtc3R5bGU6IGl0YWxpYztcbn1cbiJdfQ== */");

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
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header [translucent]=\"true\">\n  <ion-toolbar>\n    <ion-title>\n      <img src=\"assets/icon/favicon.png\" class=\"title-icon\">\n      {{ app.appName() }}\n    </ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content [fullscreen]=\"true\" class=\"center\">\n\n  <!-- debug GPS data -->\n  <div id=\"debug\"\n    *ngIf=\"app.debugGPS()\"\n    >\n    {{ gpsData.latitude }}<br>\n    {{ gpsData.longitude }}<br>\n    {{ gpsData.accuracy }}<br>\n    {{ gpsData.timestamp }}<br>\n    {{ counter }}\n  </div>\n\n</ion-content>\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n\n          <!-- pause button -->\n          <ion-button\n            (click)=\"dummy()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app yellow\"\n          >\n            <ion-icon name=\"pause\"></ion-icon>\n          </ion-button>\n\n          <ion-button\n            (click)=\"dummy()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app red\"\n          ><ion-icon name=\"log-out\"></ion-icon></ion-button>\n\n          <ion-button\n            (click)=\"dummy()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app red\"\n          >SOS</ion-button>\n\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

/***/ })

}]);
//# sourceMappingURL=tracking-tracking-module.js.map