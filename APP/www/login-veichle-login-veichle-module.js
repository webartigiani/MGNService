(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["login-veichle-login-veichle-module"],{

/***/ "bQul":
/*!*********************************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/login-veichle/login-veichle.page.html ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<!--\n/*\n * login-veichle/login-veichle.page\n * login page\n * roue: login-veichle\n *\n * NOTES:\n *  User has to\n *  - select its operator name\n *  - select the veichles he's using\n *  - type his \"password_timbratura\"\n *  - then tap the \"Avvia\" button\n *\n *  the \"Avvia\" button do:\n *  step 1: checks internet connection\n *  step 2: try to ping the MGN server API\n *  step 3: checks geo-location service\n *\n *  each step is shown into a loader \"Attendi...\"\n *\n *  step 4: if everything's ok:\n *  - calls the \"startTrackingSession\" MGN API to start a brend new tracking-session (for the user, with the selected veichles)\n *  - stores the new session_id into localStorage\n *  - navigate to \"tracking\"\n *\n *  step 4: if something goes wrong:\n *  - APP reloads workers and veichles list via MGN API\n *\n *  IMPORTANT:\n *  - backgroundMode is disabled on this view:\n *  - APP can't be set in background\n *  - APP is restored when paused in max 0.25\"\n *  - backButton is overrided\n *  - screen sleep is allowed\n */\n-->\n<ion-header [translucent]=\"true\">\n  <ion-toolbar>\n    <ion-title>\n      <img src=\"assets/icon/favicon.png\" class=\"title-icon\">\n      {{ app.appName() }}\n    </ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content [fullscreen]=\"true\">\n  <!-- form iniziale -->\n  <div id=\"startingForm\"\n    *ngIf=\"true\"\n    >\n    <ion-list>\n      <ion-item>\n        <ion-label>Operatore</ion-label>  <!-- selezione operatore -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"worker\"\n          >\n          <ion-select-option *ngFor=\"let item of this.workers\" [value]=\"item\">{{ item.name }} {{ item.surname }}</ion-select-option>\n        </ion-select>\n      </ion-item>\n      <ion-item>\n        <ion-label>Veicolo</ion-label>    <!-- selezione veicolo -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"veichle\"\n          >\n          <ion-select-option *ngFor=\"let item of this.veichles\" [value]=\"item\">{{ item.manufacter }} {{ item.model }} ({{ item.licence_plate }})</ion-select-option>\n        </ion-select>\n      </ion-item>\n      <ion-item>\n        <ion-label>Codice</ion-label>     <!-- codice timbrata -->\n        <ion-input\n        [(ngModel)]=\"code\"\n        placeholder=\"Codice timbrata\"\n        #codeID\n        ></ion-input>\n      </ion-item>\n    </ion-list>\n  </div>\n</ion-content>\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n\n          <!-- start button -->\n          <ion-button\n            (click)=\"start()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app\"\n          >Avvia</ion-button>\n\n          <!-- SOS Caller -->\n          <ion-button\n            (click)=\"SOS()\"\n            shape=\"round\"\n            size=\"large\"\n            class=\"btn-app red\"\n          >SOS</ion-button>\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

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
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _ionic_native_background_mode_ngx__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @ionic-native/background-mode/ngx */ "1xeP");
/* harmony import */ var _Classes_App__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Classes/App */ "FNOQ");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ../Classes/LocalData */ "/zBf");
/* harmony import */ var _Classes_Phone__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ../Classes/Phone */ "JgwU");



/*
 * login-veichle/login-veichle.page
 * login page
 * roue: login-veichle
 *
 * NOTES:
 *  User has to
 *  - select its operator name
 *  - select the veichles he's using
 *  - type his "password_timbratura"
 *  - then tap the "Avvia" button
 *
 *  the "Avvia" button do:
 *  step 1: checks internet connection
 *  step 2: try to ping the MGN server API
 *  step 3: checks geo-location service
 *
 *  each step is shown into a loader "Attendi..."
 *
 *  step 4: if everything's ok:
 *  - calls the "startTrackingSession" MGN API to start a brend new tracking-session (for the user, with the selected veichles)
 *  - stores the new session_id into localStorage
 *  - navigate to "tracking"
 *
 *  step 4: if something goes wrong:
 *  - APP reloads workers and veichles list via MGN API
 *
 *  IMPORTANT:
 *  - backgroundMode is disabled on this view:
 *  - APP can't be set in background
 *  - APP is restored when paused in max 0.25"
 *  - backButton is overrided
 *  - screen sleep is allowed
 */




// Background Mode
// see  https://ionicframework.com/docs/native/background-mode
// see  https://github.com/katzer/cordova-plugin-background-mode
// NOTES:   requires    ionic cordova plugin add cordova-plugin-background-mode
//                      npm install @ionic-native/background-mode
//          requires
//          platforms/android/app/src/main/AndroidManifest.xml
//          <uses-permission android:name="android.permission.FOREGROUND_SERVICE" />

// WebArtigiani Classes







let LoginVeichlePage = class LoginVeichlePage {
    // #endregion Variables
    // #region Constructor
    constructor(
    // WebArtigiani
    app, api, utils, components, geolocation, localData, phone, backgroundMode, 
    // Angular
    platform, navCtrl) {
        this.app = app;
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.localData = localData;
        this.phone = phone;
        this.backgroundMode = backgroundMode;
        this.platform = platform;
        this.navCtrl = navCtrl;
        // #region Variables
        this.workers = []; // dipendenti
        this.worker = '';
        this.veichles = []; // veicoli
        this.veichle = '';
        this.code = '';
        // Constructor code...
        this.loadData();
        // #region Device Event listners
        this.platform.backButton.subscribe(() => {
            //this.components.showAlert('Attenzione', 'operazione non consentita', 'Prima di terminare l\'applicazione, completa il tuo tragitto.')
            //console.log('Another handler was called!');
            //return;
            console.log('backbutton');
        });
        this.platform.pause.subscribe(() => {
            console.log('pause');
        });
        this.platform.resume.subscribe(() => {
            console.log('resume');
        });
        // #endregion Device Event listners
    }
    // #endregion Constructor
    // #region Component LifeCycle
    ngAfterViewInit() {
        console.log('ngAfterViewInit');
        console.log('this.utils.isDebug()', this.utils.isDebug());
        // allows screen falling asleep
        this.utils.allowScreenFallAsleep();
        // - enables background mode
        // - restores foreground when app is sent to background (background mode activated)
        // - restores foreground by a 500ms timer, if app is in background mode
        if (!this.utils.isDebug()) {
            this.backgroundMode.enable();
            this.backgroundMode.on('activate').subscribe(() => {
                console.log('enter background mode');
                this.backgroundMode.moveToForeground();
            });
            setInterval(() => {
                if (this.backgroundMode.isActive()) {
                    console.log('restore foreground');
                    this.backgroundMode.moveToForeground();
                }
            }, 250);
        }
    }
    ngAfterViewChecked() {
        /**
         * Respond after Angular checks the component's views and child views, or the view that contains the directive.
         */
    }
    // #endregion Component LifeCycls
    // #region Public Methods
    start() {
        /**
         * Starts tracking worker on veichle
         */
        // #region Validations
        // checks selections: worker and veichle are both required
        if ((typeof this.worker === 'string') || (typeof this.veichle === 'string')) {
            this.components.showAlert('Attenzione', 'Operatore e veicolo richiesti', 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo');
            return;
        }
        // Checks password
        if (this.code == '') {
            this.components.showAlert('Attenzione', 'Codice timbrata richiesto', 'Inserisci il codice timbrata del tuo operatore');
            this.codeEl.setFocus();
        }
        // #endregion Validations
        // shows loader then calls API to login
        this.components.getLoader('Attendi...').then((loading) => {
            loading.present();
            // checks if device is online
            if (this.utils.isDeviceOnLine()) {
                // try to ping server
                if (this.api.ping()) {
                    // try to geo-locate
                    this.geolocation.locate().then((data) => {
                        this.api.startTrackingSession(this.utils.getDeviceData(), data, this.worker, this.veichle, this.code)
                            .then((result) => {
                            // tracking-session created: gets session-id, saves it, and navigate to 'tracking' page
                            const sessionID = result['message'];
                            this.localData.writeValue('session_id', sessionID);
                            this.navCtrl.navigateRoot('tracking');
                            loading.dismiss();
                        }).catch((error) => {
                            // API Error
                            loading.dismiss();
                            this.components.showAlert(error['message'], 'Si è verificato un errore', error['message_details']);
                            this.loadData();
                        });
                    }).catch((error) => {
                        // geo-location error
                    });
                }
                else {
                    // ping failed
                    loading.dismiss();
                    this.components.showAlert('Connessione al server assente', 'Errore di connessione al server MGN', 'Si è verificato un errore di connessione al server MSGN. Prego, riprova.');
                    this.loadData();
                }
            }
            else {
                // device offline
                loading.dismiss();
                this.components.showAlert('Connessione Assente', 'Connessione alla rete assente', 'Prego, verifica la tua connessione quindi riprova');
            }
        });
    }
    SOS() {
        /**
         * starts a calling to the SOS number
         */
        this.components.showConfirm('SOS', 'Avvia chiamata SOS', 'Avviare una chiamata al numero di SOS ' + src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].SOS_PHONE_NUMBER + '?').then((result) => {
            if (result)
                this.phone.call(src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].SOS_PHONE_NUMBER);
        });
    }
    // #endregion Public Methods
    // #region Private Methods
    loadData() {
        // lists workers and veichles
        this.api.listWorkers().then((result) => {
            // list workers
            this.workers = result;
            this.api.listVeichles().then((result) => {
                // lists veichles
                this.veichles = result;
            }).catch((error) => {
                // error listing veichles
                console.error(error);
            });
        }).catch((error) => {
            // error listing workers
            console.error(error);
        });
    }
};
LoginVeichlePage.ctorParameters = () => [
    { type: _Classes_App__WEBPACK_IMPORTED_MODULE_7__["AppService"] },
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_8__["ApiService"] },
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_9__["UtilsService"] },
    { type: _Classes_Components__WEBPACK_IMPORTED_MODULE_10__["ComponentsService"] },
    { type: _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_11__["GeoLocationService"] },
    { type: _Classes_LocalData__WEBPACK_IMPORTED_MODULE_12__["LocalDataService"] },
    { type: _Classes_Phone__WEBPACK_IMPORTED_MODULE_13__["PhoneServices"] },
    { type: _ionic_native_background_mode_ngx__WEBPACK_IMPORTED_MODULE_6__["BackgroundMode"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_5__["Platform"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_5__["NavController"] }
];
LoginVeichlePage.propDecorators = {
    codeEl: [{ type: _angular_core__WEBPACK_IMPORTED_MODULE_3__["ViewChild"], args: ['codeID', { static: false },] }]
};
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