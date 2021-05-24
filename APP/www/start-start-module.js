(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["start-start-module"],{

/***/ "/sr2":
/*!*************************************!*\
  !*** ./src/app/start/start.page.ts ***!
  \*************************************/
/*! exports provided: StartPage */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "StartPage", function() { return StartPage; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_start_page_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./start.page.html */ "1CUN");
/* harmony import */ var _start_page_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./start.page.scss */ "X/qK");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _Classes_App__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Classes/App */ "FNOQ");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../Classes/LocalData */ "/zBf");
/* harmony import */ var _Classes_Phone__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../Classes/Phone */ "JgwU");



/*
 * start/start.page
 * start/loading page
 * route: start (default route)
 *
 * NOTES:
 *  this is the 1st page loaded when APP starts
 *
 *  step 1: checks internet connection
 *  step 2: try to ping the MGN server API
 *  step 3: checks geo-location service
 *
 *  each step is shown into div#statusDesc
 *  step 4: if everything's ok registers/updates the device via API, then navigate to login page
 */


// WebArtigiani Classes







let StartPage = class StartPage {
    // #endregion Variables
    // #region Constructor
    constructor(
    // WebArtigiani
    app, api, utils, components, geolocation, localData, phone, 
    // Angular
    navCtrl) {
        this.app = app;
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.localData = localData;
        this.phone = phone;
        this.navCtrl = navCtrl;
        // #region Variables
        this.statusDesc = 'caricamento...';
        this.statusError = false;
        this.execDelay = 0.25; // numero di secondi di attesa esecuzione
        this.retryDelay = 3; // numero di secondi per retrial
        // Constructor code...
    }
    // #endregion Constructor
    // #region Component LifeCycle
    ngOnInit() {
        /*
        Initialize the directive or component
        after Angular first displays the data-bound properties and sets the directive or component's input properties.
        Called once
        */
        this.app.checkUpdates();
    }
    ngAfterViewInit() {
        console.log('start', 'ngAfterViewInit');
        // allows screen falling asleep (NOTE: here, we DO NOT keep APP in foreground)
        this.utils.allowScreenFallAsleep();
        //this.utils.keepForeground()
        // starts steps...
        setTimeout(() => {
            this.checkConnection();
        }, this.execDelay * 1000 * 2);
    }
    // #endregion Component LifeCycls
    // #region Public Methods
    checkConnection() {
        /**
         * step 1: checks internet connection
         */
        this.statusDesc = 'verifica connessione...';
        setTimeout(() => {
            // 0.5" before we really check connection
            if (this.utils.isDeviceOnLine()) {
                // device connected:
                this.statusDesc = 'connessione OK';
                setTimeout(() => {
                    this.pingServer();
                }, this.execDelay * 1000);
            }
            else {
                // device not connected: retry in 1"
                this.statusDesc = 'Connessione Assente.<br><br>Attiva la connessione dati del tuo dispositivo.';
                setTimeout(() => {
                    this.checkConnection(); // retry All in 3"
                }, this.retryDelay * 1000);
            }
        }, this.execDelay * 1000);
    }
    pingServer() {
        /**
         * step 2: try to ping server
         * */
        this.statusDesc = 'connessione al server MGN...';
        setTimeout(() => {
            this.api.ping().then((result) => {
                // ping OK
                this.statusDesc = 'Connessione al server MGN Ok';
                setTimeout(() => {
                    this.checkGeoLocationService();
                }, this.execDelay * 1000);
            }).catch((error) => {
                // ping Error
                this.statusDesc = 'Server MGN non raggiungibile.<br><br>Nuovo tentativo in ' + this.retryDelay + '"...';
                setTimeout(() => {
                    this.checkConnection(); // retry All in 3"
                }, this.retryDelay * 1000);
            });
        }, this.execDelay * 1000);
    }
    checkGeoLocationService() {
        /**
         * step 3: checks geo-location service
         */
        this.statusDesc = 'verifica servizio GPS...';
        setTimeout(() => {
            this.geolocation.checkService().then((data) => {
                // Geo-location service OK
                this.statusDesc = 'Avvio in corso...';
                this.registerDevice(data);
            }).catch((error) => {
                // geolocation.checkService() error
                // describes the error
                let m = '';
                switch (error.code) {
                    case 1:
                        m = 'Devi autorizzare la localizzazione';
                        break;
                    case 2:
                        m = 'Errore di rete GPS.';
                        break;
                    case 3:
                        m = 'Timeout GPS.';
                        break;
                    default:
                        m = 'Errore GPS ' + error.code + ', ' + error.message;
                        break;
                }
                this.statusDesc = m + '<br><br>Nuovo tentativo in ' + this.retryDelay + '"...';
                setTimeout(() => {
                    this.checkGeoLocationService();
                }, this.retryDelay * 1000);
            });
        }, this.execDelay * 1000);
    }
    registerDevice(data) {
        /**
         * step 4: register/updates the device via API
         */
        this.api.deviceAdd(this.utils.getDeviceData(), data).then((result) => {
            // device added/updated via API: navigate to login page
            setTimeout(() => {
                this.navCtrl.navigateRoot('login-veichle');
            }, this.execDelay * 1000);
        }).catch((error) => {
            // API Error
            this.components.showAlert(error['message'], 'Si è verificato un errore', error['message_details']);
            window.location.reload();
        });
    }
};
StartPage.ctorParameters = () => [
    { type: _Classes_App__WEBPACK_IMPORTED_MODULE_5__["AppService"] },
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_6__["ApiService"] },
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_7__["UtilsService"] },
    { type: _Classes_Components__WEBPACK_IMPORTED_MODULE_8__["ComponentsService"] },
    { type: _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_9__["GeoLocationService"] },
    { type: _Classes_LocalData__WEBPACK_IMPORTED_MODULE_10__["LocalDataService"] },
    { type: _Classes_Phone__WEBPACK_IMPORTED_MODULE_11__["PhoneServices"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["NavController"] }
];
StartPage = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-start',
        template: _raw_loader_start_page_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_start_page_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], StartPage);



/***/ }),

/***/ "1CUN":
/*!*****************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/start/start.page.html ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<!--\n/*\n * start/start.page\n * start/loading page\n * route: start (default route)\n *\n * NOTES:\n *  this is the 1st page loaded when APP starts\n *\n *  step 1: checks internet connection\n *  step 2: try to ping the MGN server API\n *  step 3: checks geo-location service\n *\n *  each step is shown into div#statusDesc\n *  step 4: if everything's ok registers/updates the device via API, then navigate to login page\n */\n-->\n<ion-content [fullscreen]=\"true\" class=\"center\">\n  <img src=\"assets/ani/start.gif\" />\n  <br>\n  <div id=\"statusDesc\">\n    <p [innerHTML]=\"statusDesc\"></p>\n  </div>\n</ion-content>\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n          {{ app.appName() }} v.{{ app.appVersion() }}\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

/***/ }),

/***/ "X/qK":
/*!***************************************!*\
  !*** ./src/app/start/start.page.scss ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzdGFydC5wYWdlLnNjc3MifQ== */");

/***/ }),

/***/ "mEx7":
/*!***********************************************!*\
  !*** ./src/app/start/start-routing.module.ts ***!
  \***********************************************/
/*! exports provided: StartPageRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "StartPageRoutingModule", function() { return StartPageRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _start_page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./start.page */ "/sr2");




const routes = [
    {
        path: '',
        component: _start_page__WEBPACK_IMPORTED_MODULE_3__["StartPage"]
    }
];
let StartPageRoutingModule = class StartPageRoutingModule {
};
StartPageRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]],
    })
], StartPageRoutingModule);



/***/ }),

/***/ "qyyb":
/*!***************************************!*\
  !*** ./src/app/start/start.module.ts ***!
  \***************************************/
/*! exports provided: StartPageModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "StartPageModule", function() { return StartPageModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "ofXK");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ "3Pt+");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _start_routing_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./start-routing.module */ "mEx7");
/* harmony import */ var _start_page__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./start.page */ "/sr2");







let StartPageModule = class StartPageModule {
};
StartPageModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
            _angular_forms__WEBPACK_IMPORTED_MODULE_3__["FormsModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicModule"],
            _start_routing_module__WEBPACK_IMPORTED_MODULE_5__["StartPageRoutingModule"]
        ],
        declarations: [_start_page__WEBPACK_IMPORTED_MODULE_6__["StartPage"]]
    })
], StartPageModule);



/***/ })

}]);
//# sourceMappingURL=start-start-module.js.map