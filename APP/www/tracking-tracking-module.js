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
/* harmony import */ var _Classes_Phone__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ../Classes/Phone */ "JgwU");






// WebArtigiani Classes







let TrackingPage = class TrackingPage {
    // #endregion Variables
    // #region Constructor
    constructor(
    // WebArtigiani
    app, api, utils, components, geolocation, localData, phone, 
    // Angular
    platform, navCtrl) {
        // Constructor code...
        this.app = app;
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.localData = localData;
        this.phone = phone;
        this.platform = platform;
        this.navCtrl = navCtrl;
        // #region Variables
        this.current_worker = this.localData.readObject('current_worker', {}); // current worker and veichle
        this.current_veichle = this.localData.readObject('current_veichle', {});
        this.statusDesc = 'continua verso la tua destinazione...';
        this.instructions = [
            'raggiunta la tua destinazione, clicca "Stop"',
            'per fermarti lungo il tragitto, clicca "Pausa',
            'per emergenze, clicca "SOS"'
        ];
        this.counter = 0; // contatore tracciamenti
        this.sessionID = '';
        this.gpsData = {};
        this.isPaued = false;
        this.alreadyPaused = false;
        this.iTimer = null; // setInterval
        this.data = [];
        // gets current session_id from storage
        this.sessionID = this.localData.readValue('session_id');
    }
    // #endregion Constructor
    // #region Component LifeCycle
    ngAfterViewInit() {
        // keep screen awake
        this.utils.keepScreenAwake();
        // 1st geo-location, then geo-locate by 1" interval
        this.data = [];
        // 1st geo-location, then geo-locate by interval
        this.geoLocate();
        this.iTimer = setInterval(() => {
            this.geoLocate();
        }, 1 * 1000);
    }
    // #endregion Component LifeCycls
    // #region Public Methods
    pause() {
        /**
         * Do a Pause
         */
        if (this.alreadyPaused) {
            // pause already used
            this.components.showAlert('Pausa', 'Pausa non disponibile', 'Hai gi?? usufruito di una pausa lungo il tragitto.', 0, 'Ho capito');
            return;
        }
        // ask for confirmation
        this.components.showConfirm('Pausa', 'Hai a disposizione una sola pausa lungo il tragitto', 'Confermi di voler usufruire della tua pausa ora?', ['No', 'Si']).then((result) => {
            if (!result)
                return;
            this.isPaued = true;
            this.alreadyPaused = true; // sets pause already used
            this.components.showAlert('In Pausa', 'Tragitto in pausa', 'Per riprendere il tuo tragitto, clicca sul pulsante "Riprendi" al termine della pausa.', src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].MAX_PAUSE_TIMEOUT * 60 * 1000, 'Riprendi').then((result) => {
                this.isPaued = false;
            });
        });
    }
    stop() {
        /**
         * Stops Geo-Locate
         */
        this.components.showConfirm('Conferma', 'Hai raggiunto la destinazione?', 'Confermi di volere interrompere il tragitto?', ['No', 'Si']).then((result) => {
            if (result) {
                // shows loader then calls API to login
                this.components.getLoader('Attendi...').then((loading) => {
                    loading.present();
                    this.api.stopTracking(this.sessionID).then((result) => {
                        // stopTracking OK
                        loading.dismiss();
                        this.stopTracker();
                    }).catch((error) => {
                        // API Error
                        console.error(error);
                        loading.dismiss();
                    });
                });
            }
            else {
                // Do not stop!
            }
        });
    }
    stopTracker() {
        /**
         * Stops the tracker
         */
        clearInterval(this.iTimer); // stops interval
        this.iTimer = null;
        this.localData.delete('session_id');
        this.localData.delete('current_worker');
        this.localData.delete('current_veichle');
        this.navCtrl.navigateRoot('login-veichle');
    }
    SOS() {
        /**
         * starts a calling to the SOS number
         */
        this.components.showConfirm('SOS', 'Avvia chiamata SOS', 'Avviare una chiamata al numero di SOS ' + src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].SOS_PHONE_NUMBER + '?', ['Annulla', 'OK']).then((result) => {
            if (result)
                this.phone.call(src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].SOS_PHONE_NUMBER);
        });
    }
    geoLocate(retry) {
        /**
         * Geo-locate the device
         */
        this.geolocation.locate().then((data) => {
            /**
             * Geo-location OK
             * we call continueTracking API
             */
            if (data.valid) {
                this.gpsData = data;
                this.counter++;
            }
            /*
            Stores data into local array
            when we got N (environment.LOCATION_INTERVAL) points, we get the best by accuracy
            by sorting local array. Then we register the position, reset the local array,
            and redo it all
            */
            this.data.push(data);
            if (this.data.length === src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].LOCATION_INTERVAL) {
                // sorts array by accuracy, then gets the first, resets the local array
                this.data.sort((a, b) => parseInt(a.accuracy) - parseInt(b.accuracy));
                data = this.data[0]; // gets the first point by accuracy
                this.data = []; // resets local array
                const navigationStatus = this.isPaued ? 'pause' : 'running'; // status paused/running
                this.api.continueTracking(this.sessionID, data, navigationStatus)
                    .then((result) => {
                    // continueTracking OK
                }).catch((error) => {
                    // API Error
                    if (error.http_status.code === 404) {
                        // ERORR 404 returned by server
                        // tracking session stopped by admin
                        this.components.showAlert('Navigazione Interrotta', 'Navigazione interrotta da remoto', 'La navigazione di questo veicolo ?? stata interrotta da remoto dallo Staff di MGN.', 3000).then((result) => {
                            this.stopTracker();
                        });
                        return;
                    }
                    // other API errors
                    console.error(error);
                });
            } // if (this.data.length...)
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
    { type: _Classes_Phone__WEBPACK_IMPORTED_MODULE_12__["PhoneServices"] },
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
/* harmony default export */ __webpack_exports__["default"] = ("div#debug {\n  position: absolute;\n  width: 100%;\n  height: 80px;\n  bottom: 80px;\n  background-color: orange;\n  color: blue;\n  font-size: 0.75em;\n  font-style: italic;\n}\n\nul.instructions li {\n  text-align: left;\n  font-size: 0.75em;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy4uL3RyYWNraW5nLnBhZ2Uuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLGtCQUFBO0VBQ0EsV0FBQTtFQUNBLFlBQUE7RUFDQSxZQUFBO0VBQ0Esd0JBQUE7RUFDQSxXQUFBO0VBQ0EsaUJBQUE7RUFDQSxrQkFBQTtBQUNGOztBQUVBO0VBQ0UsZ0JBQUE7RUFDQSxpQkFBQTtBQUNGIiwiZmlsZSI6InRyYWNraW5nLnBhZ2Uuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbImRpdiNkZWJ1ZyB7XG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgd2lkdGg6MTAwJTtcbiAgaGVpZ2h0OjgwcHg7XG4gIGJvdHRvbTo4MHB4O1xuICBiYWNrZ3JvdW5kLWNvbG9yOiBvcmFuZ2U7XG4gIGNvbG9yOmJsdWU7XG4gIGZvbnQtc2l6ZTogLjc1ZW07XG4gIGZvbnQtc3R5bGU6IGl0YWxpYztcbn1cblxudWwuaW5zdHJ1Y3Rpb25zIGxpIHtcbiAgdGV4dC1hbGlnbjogbGVmdDtcbiAgZm9udC1zaXplOiAuNzVlbTtcbn1cbiJdfQ== */");

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
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header [translucent]=\"true\">\n  <ion-toolbar>\n    <ion-title>\n      <img src=\"assets/icon/favicon.png\" class=\"title-icon\">\n      {{ app.appName() }}\n    </ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<!-- content -->\n<ion-content [fullscreen]=\"true\" class=\"center\">\n  <h3>{{ current_worker.name }} {{ current_worker.surname }}</h3>\n  <img src=\"assets/ani/car.gif\" />\n  <br>\n  <div id=\"statusDesc\">\n    <p [innerHTML]=\"statusDesc\"></p>\n  </div>\n  <ul class=\"instructions\">\n    <li *ngFor=\"let sInstr of this.instructions\" [value]=\"sInstr\">{{ sInstr }}</li>\n  </ul>\n\n  <!-- SOS Caller -->\n  <ion-button\n    (click)=\"SOS()\"\n    shape=\"round\"\n    size=\"large\"\n    class=\"btn-app red\"\n  ><ion-icon name=\"call-outline\"></ion-icon>SOS</ion-button>\n\n  <!-- debug GPS data (if DEBUG_GPS==true) -->\n  <div id=\"debug\"\n    *ngIf=\"app.debugGPS()\"\n    >\n    {{ gpsData.latitude }}<br>\n    {{ gpsData.longitude }}<br>\n    accuracy: {{ gpsData.accuracy }}mt<br>\n    distance: {{ gpsData.distance }}mt<br>\n    {{ counter }}\n  </div>\n</ion-content>\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n          <!-- pause button -->\n          <ion-button\n            (click)=\"pause()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app orange\"\n          >\n            <ion-icon name=\"pause-circle-outline\"></ion-icon>\n          </ion-button>\n\n          <ion-button\n            (click)=\"stop()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app red\"\n          ><ion-icon name=\"stop-circle-outline\"></ion-icon></ion-button>\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

/***/ })

}]);
//# sourceMappingURL=tracking-tracking-module.js.map