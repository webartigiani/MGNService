(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["main"],{

/***/ "/zBf":
/*!**************************************!*\
  !*** ./src/app/Classes/LocalData.ts ***!
  \**************************************/
/*! exports provided: LocalDataService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LocalDataService", function() { return LocalDataService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/*
  LocalDataService Class
  provides methods to store and read values, objects, array from/to localStorage

  USAGE:
    > in your "component" TS
      import {LocalDataService} from "../Classes/LocalData";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          LocalDataService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/


let LocalDataService = class LocalDataService {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor() {
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    writeValue(name, value) {
        localStorage.setItem(name, value);
    }
    readValue(name, defaultValue) {
        if (defaultValue === undefined)
            defaultValue = '';
        let value = localStorage.getItem(name);
        if (value === null)
            value = defaultValue;
        return value;
    }
    writeObject(name, value) {
        if (value === null)
            value = {};
        localStorage.setItem(name, JSON.stringify(value));
    }
    readObject(name, defaultObject) {
        if (defaultObject === undefined)
            defaultObject = '{}';
        let value = localStorage.getItem(name);
        if (value === null)
            value = defaultObject;
        value = JSON.parse(value);
        return value;
    }
    writeArray(name, value) {
        if (value === null)
            value = [];
        localStorage.setItem(name, JSON.stringify(value));
    }
    readArray(name, defaultArray) {
        if (defaultArray === undefined)
            defaultArray = [];
        let value = localStorage.getItem(name);
        if (value === null)
            return defaultArray;
        else
            return JSON.parse(value);
    }
    delete(name) {
        localStorage.removeItem(name);
    }
    clear() {
        localStorage.clear();
    }
};
LocalDataService.ctorParameters = () => [];
LocalDataService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], LocalDataService);



/***/ }),

/***/ 0:
/*!***************************!*\
  !*** multi ./src/main.ts ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/simonescigliuzzi/Documents/WebArtigiani/Progetti/MGN/APP/src/main.ts */"zUnb");


/***/ }),

/***/ "1ZYi":
/*!**********************************!*\
  !*** ./src/app/Classes/Utils.ts ***!
  \**********************************/
/*! exports provided: UtilsService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UtilsService", function() { return UtilsService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic-native/device/ngx */ "xS7M");
/* harmony import */ var _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic-native/network/ngx */ "kwrG");
/* harmony import */ var _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ionic-native/screen-orientation/ngx */ "0QAI");
/*
  UtilsService Class
  interacts with http://gestionale.mgnservice.it/ APIs

  USAGE:
    > in your "component" TS
      import {UtilsService} from "../Classes/Utils";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          UtilsService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/


// Platform
// see: https://ionicframework.com/docs/angular/platform

// Device
// see https://ionicframework.com/docs/v3/native/device/
// NOTES: requires  npm install --save @ionic-native/device@latest

// Network
// see  https://ionicframework.com/docs/native/network

// ScreenOrientation
// see https://ionicframework.com/docs/native/screen-orientation

/* NOT USED UniqueDeviceID
// see https://ionicframework.com/docs/native/unique-device-id
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';
*/
let UtilsService = class UtilsService {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor(platform, device, network, screenOrientation) {
        // constructor...
        this.platform = platform;
        this.device = device;
        this.network = network;
        this.screenOrientation = screenOrientation;
        // Lock screen orientation and listen for screen-orientation changes
        this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.PORTRAIT_PRIMARY);
        this.screenOrientation.onChange().subscribe(() => {
            console.log('Orientation Changed', this.screenOrientation.type);
        });
    }
    // #endregion Constructors
    // #region Public Methods
    isDebug() {
        // returns true if App is running on local webbrowser
        return (!this.platform.is('cordova'));
    }
    platformIs(platform) {
        // returns true if the platform is the one specified
        return (this.platform.is(platform));
    }
    getDeviceData() {
        // returns a full device-data object
        // NOTE: uuid is calculated by constructor
        let ret = {};
        if (this.isDebug()) {
            // running on webbrowser: creates dummy device data
            ret = {
                'platform': 'browser',
                'version': '0.0.0',
                'model': 'model',
                'manufacturer': 'manufacturer',
                'isVirtual': false,
                'serial': 'unknown',
                'uuid': 'debug_browser',
                'connection_type': 'ethernet'
            };
        }
        else {
            // running on device: returns device data
            ret = {
                'platform': this.device.platform,
                'version': this.device.version,
                'model': this.device.model,
                'manufacturer': this.device.manufacturer,
                'isVirtual': this.device.isVirtual,
                'serial': this.device.serial,
                'uuid': this.device.uuid,
                'connection_type': this.network.type.toLocaleLowerCase()
            };
        }
        console.log('getDeviceData()', ret);
        return ret;
    }
    isDeviceOnLine() {
        // returns true if the device is online
        return (this.network.type.toLocaleLowerCase() !== 'none');
    }
    openMapByAPP(latitude, longitude) {
        // open the Map APP (depending on the platform)
        // pointing to the specified coords
        // Android: geo:41.1954148,16.6165038
        // iOS:     maps://maps.apple.com/?q=41.1954148,16.6165038
        let url = '';
        if (this.platform.is('android')) {
            url = 'geo:' + latitude + ',' + longitude;
        }
        if (this.platform.is('ios')) {
            // Note: this links also works on iOS Mobile
            url = 'maps://maps.apple.com/?q=' + latitude + ',' + longitude;
        }
        if (url != '')
            url = 'https://www.google.it/maps/@' + latitude + ',' + longitude + ',15z';
        window.open(url);
    }
};
UtilsService.ctorParameters = () => [
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_2__["Platform"] },
    { type: _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_3__["Device"] },
    { type: _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_4__["Network"] },
    { type: _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_5__["ScreenOrientation"] }
];
UtilsService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], UtilsService);



/***/ }),

/***/ "AytR":
/*!*****************************************!*\
  !*** ./src/environments/environment.ts ***!
  \*****************************************/
/*! exports provided: environment */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "environment", function() { return environment; });
// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.
const environment = {
    production: false,
    API_TOKEN: '5be65b9c-2902-4490-9640-45f8c6ad360b',
    API_LOGGER_ENABLED: false,
    API_USE_LOCAL: false,
    API_END_POINT_LOCAL: 'http://127.0.0.1:8000/api/app',
    API_END_POINT: 'http://gestionale.mgnservice.it/api/app',
    LOCATION_TIMEOUT: 5,
    LOCATION_INERVAL: 15 // interval (in seconds)
};
/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.


/***/ }),

/***/ "Sy1n":
/*!**********************************!*\
  !*** ./src/app/app.component.ts ***!
  \**********************************/
/*! exports provided: AppComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppComponent", function() { return AppComponent; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_app_component_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./app.component.html */ "VzVu");
/* harmony import */ var _app_component_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app.component.scss */ "ynWL");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");




let AppComponent = class AppComponent {
    constructor() { }
    ngOnInit() {
        console.log('ngOnInit from AppComponent');
    }
};
AppComponent.ctorParameters = () => [];
AppComponent = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-root',
        template: _raw_loader_app_component_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_app_component_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], AppComponent);



/***/ }),

/***/ "Vw97":
/*!***************************************!*\
  !*** ./src/app/Classes/Components.ts ***!
  \***************************************/
/*! exports provided: ComponentsService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ComponentsService", function() { return ComponentsService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/*
  ComponentsService Class
  implements various components, such as loading, alert

  USAGE:
    > in your "component" TS
      import {UtilsService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: ComponentsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          ComponentsService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/



let ComponentsService = class ComponentsService {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor(alertController, loadingController) {
        this.alertController = alertController;
        this.loadingController = loadingController;
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    showAlert(title, subtitle, message) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // shows device native alert by alertController
            const alert = yield this.alertController.create({
                animated: true,
                backdropDismiss: false,
                header: title,
                subHeader: subtitle,
                message: message,
                buttons: ['OK']
            });
            yield alert.present();
        });
    }
    getLoader(message, duration) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // returns a loading object
            if (message == undefined)
                message = 'Please wait...';
            if (duration == undefined)
                duration = 10000;
            const loading = yield this.loadingController.create({
                message: message,
                duration: duration,
                showBackdrop: true
            });
            return loading;
        });
    }
};
ComponentsService.ctorParameters = () => [
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_2__["AlertController"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_2__["LoadingController"] }
];
ComponentsService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], ComponentsService);



/***/ }),

/***/ "VzVu":
/*!**************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/app.component.html ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<ion-app>\n  <ion-router-outlet></ion-router-outlet>\n</ion-app>\n");

/***/ }),

/***/ "YBWL":
/*!********************************!*\
  !*** ./src/app/Classes/API.ts ***!
  \********************************/
/*! exports provided: ApiService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ApiService", function() { return ApiService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/common/http */ "tk/3");
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/*
  ApiService Class
  interacts with http://gestionale.mgnservice.it/ APIs

  USAGE:
    > in your "component" TS
      import {ApiService} from "../Classes/API";

    > in your "component" TS constructor, add
      private api: ApiService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          ApiService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/



// Http Request


let ApiService = class ApiService {
    // #region Constructors
    constructor(platform, httpClient) {
        this.platform = platform;
        this.httpClient = httpClient;
        // constructor...
    }
    // #endregion Constructors
    // #region Public API Methods
    /**
     * USAGE:
     *      this.api.listWorkers().then((result) => {
     *        console.log(result)
     *        }
     *      ).catch((error) => {
     *        console.error(error)
     *      })
     */
    ping() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                this.get('/ping/').then((result) => {
                    if (result != undefined) {
                        resolve(result.data);
                    }
                    else {
                        // API Error
                    }
                });
            });
        });
    }
    listWorkers() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                this.get('/workers/list/').then((result) => {
                    if (result != undefined) {
                        resolve(result.data);
                    }
                    else {
                        // API Error
                        alert('errore API operatori');
                    }
                });
            });
        });
    }
    listVeichles() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                this.get('/veichles/list/').then((result) => {
                    if (result != undefined) {
                        resolve(result.data);
                    }
                    else {
                        // API Error
                        alert('errore API veicoli');
                    }
                });
            });
        });
    }
    // #region Public Methods
    // #region Private Methods
    endPoint() {
        // returns the API endpoint base url: depending on the effective environment
        // NOTE:   we could also use
        //           environment.production
        if (this.platform.is('cordova')) {
            // running on device
            return src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_END_POINT;
        }
        else {
            // running on localhost or public domain, depending on API_USE_LOCAL
            if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_USE_LOCAL)
                return src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_END_POINT_LOCAL;
            else
                return src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_END_POINT;
        }
    }
    // //#endregion Private Methods
    // #region Http Base Functions
    get(uri) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                const headers = new _angular_common_http__WEBPACK_IMPORTED_MODULE_3__["HttpHeaders"]()
                    .set('Access-Control-Allow-Origin', '*')
                    .set('Content-Type', 'application/json; charset=utf-8')
                    .set('Accept', 'application/json')
                    .set('Authorization', 'Bearer ' + src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_TOKEN);
                this.httpClient.get(this.endPoint() + uri, { 'headers': headers }).subscribe((response) => {
                    if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_LOGGER_ENABLED)
                        console.warn('API Debugger LOG', uri, JSON.stringify(response));
                    resolve(response);
                }, (err) => {
                    if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_LOGGER_ENABLED)
                        console.error('API Debug LOG', uri, JSON.stringify(err));
                    let xErr = this.envelopeError(err);
                    reject(xErr);
                });
            });
        });
    }
    envelopeError(err) {
        /* returns an error object
        {
          "http_status":{
            "code":403,
            "text":"Forbidden",
            "message":"Http failure response for http://127.0.0.1:8000/api/app/workers/list/: 403 Forbidden"
          },
          "message":"messaggio",
          "message_details":"dettaglio1, dettaglio2"
        }
        */
        let errObj = {
            "http_status": {
                'code': err.status,
                'text': err.statusText,
                'message': err.message
            },
            'message': (err.error.message == undefined) ? '' : err.error.message,
            'message_details': ''
        };
        if ((typeof err.error.data) == 'object') {
            err.error.data.forEach(element => {
                if (errObj.message_details != '')
                    errObj.message_details += ', ';
                errObj.message_details += element;
            });
        }
        return errObj;
    }
};
ApiService.ctorParameters = () => [
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_2__["Platform"] },
    { type: _angular_common_http__WEBPACK_IMPORTED_MODULE_3__["HttpClient"] }
];
ApiService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], ApiService);



/***/ }),

/***/ "ZAI4":
/*!*******************************!*\
  !*** ./src/app/app.module.ts ***!
  \*******************************/
/*! exports provided: AppModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppModule", function() { return AppModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/platform-browser */ "jhN1");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _app_component__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./app.component */ "Sy1n");
/* harmony import */ var _app_routing_module__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./app-routing.module */ "vY5A");
/* harmony import */ var _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @ionic-native/geolocation/ngx */ "Bfh1");
/* harmony import */ var _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @ionic-native/native-geocoder/ngx */ "h+qT");
/* harmony import */ var _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @ionic-native/device/ngx */ "xS7M");
/* harmony import */ var _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @ionic-native/screen-orientation/ngx */ "0QAI");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/common/http */ "tk/3");
/* harmony import */ var _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @ionic-native/network/ngx */ "kwrG");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ./Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./Classes/LocalData */ "/zBf");

/*
app.module.ts
src/app.module.ts
*/






// geolocation and native-geocoder


// Device
// see https://ionicframework.com/docs/v3/native/device/
// NOTES: requires  npm install --save @ionic-native/device@latest

// ScreenOrientation (see https://ionicframework.com/docs/native/screen-orientation)

// http requests

// Network
// see  https://ionicframework.com/docs/native/network

// WebArtigiani Classes





/* NOT USED
 UniqueDeviceID (see https://ionicframework.com/docs/native/unique-device-id)
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';
*/
Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["enableProdMode"])();
let AppModule = class AppModule {
};
AppModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        declarations: [_app_component__WEBPACK_IMPORTED_MODULE_5__["AppComponent"]],
        entryComponents: [],
        imports: [
            _angular_platform_browser__WEBPACK_IMPORTED_MODULE_2__["BrowserModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicModule"].forRoot(),
            _app_routing_module__WEBPACK_IMPORTED_MODULE_6__["AppRoutingModule"],
            _angular_common_http__WEBPACK_IMPORTED_MODULE_11__["HttpClientModule"]
        ],
        providers: [
            _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["NavController"],
            _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_7__["Geolocation"],
            _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_8__["NativeGeocoder"],
            {
                provide: _angular_router__WEBPACK_IMPORTED_MODULE_3__["RouteReuseStrategy"],
                useClass: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["IonicRouteStrategy"]
            },
            _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_9__["Device"],
            _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_10__["ScreenOrientation"],
            _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_12__["Network"],
            /*
            UniqueDeviceID,
            Uid,
            AndroidPermissions,
            */
            // WebArtigiani
            _Classes_API__WEBPACK_IMPORTED_MODULE_13__["ApiService"],
            _Classes_Utils__WEBPACK_IMPORTED_MODULE_14__["UtilsService"],
            _Classes_Components__WEBPACK_IMPORTED_MODULE_15__["ComponentsService"],
            _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_16__["GeoLocationService"],
            _Classes_LocalData__WEBPACK_IMPORTED_MODULE_17__["LocalDataService"]
        ],
        bootstrap: [_app_component__WEBPACK_IMPORTED_MODULE_5__["AppComponent"]],
    })
], AppModule);



/***/ }),

/***/ "kLfG":
/*!*****************************************************************************************************************************************!*\
  !*** ./node_modules/@ionic/core/dist/esm lazy ^\.\/.*\.entry\.js$ include: \.entry\.js$ exclude: \.system\.entry\.js$ namespace object ***!
  \*****************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./ion-action-sheet.entry.js": [
		"dUtr",
		"common",
		0
	],
	"./ion-alert.entry.js": [
		"Q8AI",
		"common",
		1
	],
	"./ion-app_8.entry.js": [
		"hgI1",
		"common",
		2
	],
	"./ion-avatar_3.entry.js": [
		"CfoV",
		"common",
		3
	],
	"./ion-back-button.entry.js": [
		"Nt02",
		"common",
		4
	],
	"./ion-backdrop.entry.js": [
		"Q2Bp",
		5
	],
	"./ion-button_2.entry.js": [
		"0Pbj",
		"common",
		6
	],
	"./ion-card_5.entry.js": [
		"ydQj",
		"common",
		7
	],
	"./ion-checkbox.entry.js": [
		"4fMi",
		"common",
		8
	],
	"./ion-chip.entry.js": [
		"czK9",
		"common",
		9
	],
	"./ion-col_3.entry.js": [
		"/CAe",
		10
	],
	"./ion-datetime_3.entry.js": [
		"WgF3",
		"common",
		11
	],
	"./ion-fab_3.entry.js": [
		"uQcF",
		"common",
		12
	],
	"./ion-img.entry.js": [
		"wHD8",
		13
	],
	"./ion-infinite-scroll_2.entry.js": [
		"2lz6",
		14
	],
	"./ion-input.entry.js": [
		"ercB",
		"common",
		15
	],
	"./ion-item-option_3.entry.js": [
		"MGMP",
		"common",
		16
	],
	"./ion-item_8.entry.js": [
		"9bur",
		"common",
		17
	],
	"./ion-loading.entry.js": [
		"cABk",
		"common",
		18
	],
	"./ion-menu_3.entry.js": [
		"kyFE",
		"common",
		19
	],
	"./ion-modal.entry.js": [
		"TvZU",
		"common",
		20
	],
	"./ion-nav_2.entry.js": [
		"vnES",
		"common",
		21
	],
	"./ion-popover.entry.js": [
		"qCuA",
		"common",
		22
	],
	"./ion-progress-bar.entry.js": [
		"0tOe",
		"common",
		23
	],
	"./ion-radio_2.entry.js": [
		"h11V",
		"common",
		24
	],
	"./ion-range.entry.js": [
		"XGij",
		"common",
		25
	],
	"./ion-refresher_2.entry.js": [
		"nYbb",
		"common",
		26
	],
	"./ion-reorder_2.entry.js": [
		"smMY",
		"common",
		27
	],
	"./ion-ripple-effect.entry.js": [
		"STjf",
		28
	],
	"./ion-route_4.entry.js": [
		"k5eQ",
		"common",
		29
	],
	"./ion-searchbar.entry.js": [
		"OR5t",
		"common",
		30
	],
	"./ion-segment_2.entry.js": [
		"fSgp",
		"common",
		31
	],
	"./ion-select_3.entry.js": [
		"lfGF",
		"common",
		32
	],
	"./ion-slide_2.entry.js": [
		"5xYT",
		33
	],
	"./ion-spinner.entry.js": [
		"nI0H",
		"common",
		34
	],
	"./ion-split-pane.entry.js": [
		"NAQR",
		35
	],
	"./ion-tab-bar_2.entry.js": [
		"knkW",
		"common",
		36
	],
	"./ion-tab_2.entry.js": [
		"TpdJ",
		"common",
		37
	],
	"./ion-text.entry.js": [
		"ISmu",
		"common",
		38
	],
	"./ion-textarea.entry.js": [
		"U7LX",
		"common",
		39
	],
	"./ion-toast.entry.js": [
		"L3sA",
		"common",
		40
	],
	"./ion-toggle.entry.js": [
		"IUOf",
		"common",
		41
	],
	"./ion-virtual-scroll.entry.js": [
		"8Mb5",
		42
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(function() {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(function() {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "kLfG";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "vA/e":
/*!****************************************!*\
  !*** ./src/app/Classes/GeoLocation.ts ***!
  \****************************************/
/*! exports provided: GeoLocationService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "GeoLocationService", function() { return GeoLocationService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic-native/geolocation/ngx */ "Bfh1");
/* harmony import */ var _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic-native/native-geocoder/ngx */ "h+qT");
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/*
  GeoLocationService Class
  implements geo-location functions

  USAGE:
    > in your "component" TS
      import {GeoLocationService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: GeoLocationService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          GeoLocationService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/


// GeoLocation and GeoCoder



let GeoLocationService = class GeoLocationService {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor(geolocation, nativeGeocoder) {
        this.geolocation = geolocation;
        this.nativeGeocoder = nativeGeocoder;
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    checkService() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * checks Geolocation service
             */
            let geoLocationOptions = {
                timeout: (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].LOCATION_TIMEOUT * 1000),
                enableHighAccuracy: true,
                maximumAge: 0 // no cached position
            };
            return new Promise((resolve, reject) => {
                this.geolocation.getCurrentPosition(geoLocationOptions)
                    .then((data) => {
                    // result
                    resolve(data);
                }).catch((error) => {
                    /* error
                        possible errors
                          {code: 1, message: "User denied Geolocation"}       // on WebBrowser
                          {code: 1, message: "Illegal Access"}                // on Android
                          {code: 2, message: "Network location provider at 'https://www.googleapis.com/' : No response received."}
                          {code: 3, message: "Timeout expired"}
                    */
                    reject(error);
                });
            });
        });
    }
    locate() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * geo-locate the user
             */
            return new Promise((resolve, reject) => {
                let geoLocationOptions = {
                    timeout: (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].LOCATION_TIMEOUT * 1000),
                    enableHighAccuracy: true,
                    maximumAge: 0 // no cached position
                };
                this.geolocation.getCurrentPosition(geoLocationOptions)
                    .then((data) => {
                    // getCurrentPosition result
                    // es: 41.1954148 16.6165038
                    console.log('geolocation result', data.coords.latitude, data.coords.longitude, data.timestamp);
                    if (data.timestamp > 0) {
                        /*
                        this.geoData.latitude = data.coords.latitude
                        this.geoData.longitude = data.coords.longitude
                        this.geoData.accuracy = Math.round(data.coords.accuracy)
                        this.geoData.timestamp =  data.timestamp
                        */
                    }
                    else {
                        // location is empty
                    }
                }).catch((error) => {
                    // getCurrentPosition error
                    /*
                    this.error_code = error.code
                    this.error_message = error.message
                    this.locationErrors += 1
                    */
                });
            });
        });
    }
};
GeoLocationService.ctorParameters = () => [
    { type: _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_2__["Geolocation"] },
    { type: _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_3__["NativeGeocoder"] }
];
GeoLocationService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], GeoLocationService);



/***/ }),

/***/ "vY5A":
/*!***************************************!*\
  !*** ./src/app/app-routing.module.ts ***!
  \***************************************/
/*! exports provided: AppRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppRoutingModule", function() { return AppRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");



const routes = [
    {
        path: '',
        redirectTo: 'check-connection',
        pathMatch: 'full'
    },
    {
        path: 'home',
        loadChildren: () => __webpack_require__.e(/*! import() | home-home-module */ "home-home-module").then(__webpack_require__.bind(null, /*! ./home/home.module */ "ct+p")).then(m => m.HomePageModule)
    },
    {
        path: 'check-connection',
        loadChildren: () => __webpack_require__.e(/*! import() | check-connection-check-connection-module */ "check-connection-check-connection-module").then(__webpack_require__.bind(null, /*! ./check-connection/check-connection.module */ "Dqt7")).then(m => m.CheckConnectionPageModule)
    },
];
let AppRoutingModule = class AppRoutingModule {
};
AppRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forRoot(routes, { preloadingStrategy: _angular_router__WEBPACK_IMPORTED_MODULE_2__["PreloadAllModules"] })
        ],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]]
    })
], AppRoutingModule);



/***/ }),

/***/ "ynWL":
/*!************************************!*\
  !*** ./src/app/app.component.scss ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJhcHAuY29tcG9uZW50LnNjc3MifQ== */");

/***/ }),

/***/ "zUnb":
/*!*********************!*\
  !*** ./src/main.ts ***!
  \*********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_platform_browser_dynamic__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/platform-browser-dynamic */ "a3Wg");
/* harmony import */ var _app_app_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app/app.module */ "ZAI4");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./environments/environment */ "AytR");




if (_environments_environment__WEBPACK_IMPORTED_MODULE_3__["environment"].production) {
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["enableProdMode"])();
}
Object(_angular_platform_browser_dynamic__WEBPACK_IMPORTED_MODULE_1__["platformBrowserDynamic"])().bootstrapModule(_app_app_module__WEBPACK_IMPORTED_MODULE_2__["AppModule"])
    .catch(err => console.log(err));


/***/ }),

/***/ "zn8P":
/*!******************************************************!*\
  !*** ./$$_lazy_route_resource lazy namespace object ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function webpackEmptyAsyncContext(req) {
	// Here Promise.resolve().then() is used instead of new Promise() to prevent
	// uncaught exception popping up in devtools
	return Promise.resolve().then(function() {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	});
}
webpackEmptyAsyncContext.keys = function() { return []; };
webpackEmptyAsyncContext.resolve = webpackEmptyAsyncContext;
module.exports = webpackEmptyAsyncContext;
webpackEmptyAsyncContext.id = "zn8P";

/***/ })

},[[0,"runtime","vendor"]]]);
//# sourceMappingURL=main.js.map