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
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic-native/device/ngx */ "xS7M");
/* harmony import */ var _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ionic-native/network/ngx */ "kwrG");
/* harmony import */ var _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @ionic-native/screen-orientation/ngx */ "0QAI");
/* harmony import */ var _ionic_native_insomnia_ngx__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @ionic-native/insomnia/ngx */ "pOfa");
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

// Insomina
// Prevent the screen of the mobile device from falling asleep.
// see  https://ionicframework.com/docs/native/insomnia
// NOTES:   requires    ionic cordova plugin add cordova-plugin-insomnia
//                      npm install @ionic-native/insomnia

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
    constructor(platform, device, network, screenOrientation, insomnia) {
        // constructor...
        this.platform = platform;
        this.device = device;
        this.network = network;
        this.screenOrientation = screenOrientation;
        this.insomnia = insomnia;
        // Lock screen orientation and listen for screen-orientation changes
        /*this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.PORTRAIT_PRIMARY)
        this.screenOrientation.onChange().subscribe(
          () => {
              console.log('Orientation Changed', this.screenOrientation.type)
          }
        );
        */
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
                'manufacter': 'DEMO',
                'model': 'DEMO',
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
                'manufacter': this.device.manufacturer,
                'model': this.device.model,
                'isVirtual': this.device.isVirtual,
                'serial': this.device.serial,
                'uuid': this.device.uuid,
                'connection_type': this.network.type.toLocaleLowerCase(),
                'app_version': src_environments_environment__WEBPACK_IMPORTED_MODULE_2__["environment"].APP_VERSION
            };
        }
        return ret;
    }
    isDeviceOnLine() {
        // returns true if the device is online
        if (this.isDebug())
            return true;
        else
            return (this.network.type.toLocaleLowerCase() !== 'none');
    }
    deviceConnectionType() {
        if (this.isDebug())
            return 'wifi';
        else
            return this.network.type.toLocaleLowerCase();
    }
    timestampToDateTime(ts) {
        return new Date(ts); //.toLocaleDateString("it-IT")
    }
    keepScreenAwake() {
        // prevent screen to fall asleep (requires insomnia plugin)
        if (!this.isDebug()) {
            this.insomnia.keepAwake()
                .then(() => {
                // onSuccess
            }, () => {
                // onError
            });
        }
    }
    allowScreenFallAsleep() {
        // allows screen to fall asleep (requires insomnia plugin)
        if (!this.isDebug()) {
            this.insomnia.allowSleepAgain()
                .then(() => {
                // onSuccess
            }, () => {
                // onError
            });
        }
    }
};
UtilsService.ctorParameters = () => [
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_3__["Platform"] },
    { type: _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_4__["Device"] },
    { type: _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_5__["Network"] },
    { type: _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_6__["ScreenOrientation"] },
    { type: _ionic_native_insomnia_ngx__WEBPACK_IMPORTED_MODULE_7__["Insomnia"] }
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
const environment = {
    production: false,
    APP_TITLE: 'MGN Service',
    APP_VERSION: '1.2.4',
    WEB_SITE_LOCAL: 'http://127.0.0.1:8000/',
    WEB_SITE: 'https://gestionale.mgnservice.it/',
    API_TOKEN: '5be65b9c-2902-4490-9640-45f8c6ad360b',
    API_LOGGER_ENABLED: false,
    API_USE_LOCAL: true,
    API_END_POINT_LOCAL: 'http://127.0.0.1:8000/api/app',
    API_END_POINT: 'https://gestionale.mgnservice.it/api/app',
    LOCATION_TIMEOUT: 10,
    LOCATION_INTERVAL: 5,
    MAX_PAUSE_TIMEOUT: 15,
    DEBUG_GPS: false,
    SOS_PHONE_NUMBER: '112',
    LOOK_FOR_UPDATES: true,
};


/***/ }),

/***/ "FNOQ":
/*!********************************!*\
  !*** ./src/app/Classes/App.ts ***!
  \********************************/
/*! exports provided: AppService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppService", function() { return AppService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! src/environments/environment */ "AytR");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _ionic_native_app_update_ngx__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @ionic-native/app-update/ngx */ "u4kk");
/* harmony import */ var _ionic_native_autostart_ngx__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @ionic-native/autostart/ngx */ "F6t2");
/*
  AppService Class
  implements various components, such as loading, alert

  USAGE:
    > in your "component" TS
      import {AppService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: AppService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          AppService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/




// WebArtigiani Classes


// App Update
// does self-update for android
// The plugin will compare the app version and update it automatically if the API has a newer version to install.
// see      https://ionicframework.com/docs/v3/native/app-update/
// see      https://www.npmjs.com/package/cordova-plugin-app-update
// sample   https://www.freakyjolly.com/ionic-4-in-app-version-check-and-updater-dialog-using-app-update-native-plugin/#Host_XML_file_to_a_server
// NOTES:   requires    ionic cordova plugin add cordova-plugin-app-update
//                      npm install --save @ionic-native/app-update@latest
//          requires
//          platforms/android/app/src/main/AndroidManifest.xml
//          <uses-permission android:name="android.permission.REQUEST_INSTALL_PACKAGES" />
//
/*          requires
            a web url that returns an XML by
            # APP_NAME              same name as config.xml
            # APP_VERSION           version number without dots (eg. 5.2.1 => 50201)
            # APP_URI               the APK filename located into public/downloads (its url will be website/downloads/<APP_URI>)

            <update>
              <version>50201</version>      <!-- version 5.2.1  -->
              <name>MyApp</name>
              <url>http://gestionale.mgnservice.it/downloads/app.apk</url>
            </update>

            where APP Config.xml is
            <widget id="..." version="5.2.1" xmlns="http://www.w3.org/ns/widgets" xmlns:android="http://schemas.android.com/apk/res/android" xmlns:cdv="http://cordova.apache.org/ns/1.0">
              <name>MyApp</name>
            ...
*/

/* Autostart
    This plugin automatically starts your Android app after every boot or auto-update.
    You can enable or disable the autostart function in your app.
        npm install @ionic-native/autostart
        see: https://ionicframework.com/docs/native/autostart
*/

let AppService = class AppService {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor(
    // WebArtigiani
    utils, api, platform, appUpdate, autostart) {
        this.utils = utils;
        this.api = api;
        this.platform = platform;
        this.appUpdate = appUpdate;
        this.autostart = autostart;
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    appName() {
        return src_environments_environment__WEBPACK_IMPORTED_MODULE_2__["environment"].APP_TITLE;
    }
    appVersion() {
        return src_environments_environment__WEBPACK_IMPORTED_MODULE_2__["environment"].APP_VERSION;
    }
    debugGPS() {
        return src_environments_environment__WEBPACK_IMPORTED_MODULE_2__["environment"].DEBUG_GPS;
    }
    setAutostart(enable) {
        if (enable) {
            this.autostart.enable();
        }
        else {
            this.autostart.disable();
        }
    }
    enterPinnedMode() {
        /* enter pinned mode
            requires cordova-plugin-screen-pinning
            https://github.com/fedme/cordova-plugin-screen-pinning
        */
        console.log('enterPinnedMode...');
        window.cordova.plugins.screenPinning.enterPinnedMode(function () {
            console.log('Pinned mode activated!');
        }, function (errorMessage) {
            console.log('Error activating pinned mode:', errorMessage);
        });
    }
    enterImmersiveMode() {
        /* NO PLUGIN IS NEEDED HERE!
            NOTE:
            to set full screen
            1) edit config.xml by adding
                  <preference name="Fullscreen" value="true" />
    
            2) edit AndroidManifest.xml by specifyng theme
                  android:theme="@android:style/Theme.DeviceDefault.NoActionBar.Fullscreen"
    
                or edit config.xml by adding
                  <platform name="android">
                    <!-- edit activity theme into android manifest -->
                    <edit-config file="AndroidManifest.xml" target="/manifest/application/activity[@android:label='@string/activity_name']" mode="merge">
                        <activity android:theme="@android:style/Theme.DeviceDefault.NoActionBar.Fullscreen"></activity>
                    </edit-config>
                  </platform>
                to get this setting persistent, even when you remove/add Android platform
        */
    }
    exitKiosk() {
        /** exit KioskMode
         * requires cordova-plugin-kiosk
         * https://github.com/hkalina/cordova-plugin-kiosk
         */
        //window.KioskPlugin.exitKiosk();
    }
};
AppService.ctorParameters = () => [
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_4__["UtilsService"] },
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_5__["ApiService"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_3__["Platform"] },
    { type: _ionic_native_app_update_ngx__WEBPACK_IMPORTED_MODULE_6__["AppUpdate"] },
    { type: _ionic_native_autostart_ngx__WEBPACK_IMPORTED_MODULE_7__["Autostart"] }
];
AppService = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], AppService);



/***/ }),

/***/ "JgwU":
/*!**********************************!*\
  !*** ./src/app/Classes/Phone.ts ***!
  \**********************************/
/*! exports provided: PhoneServices */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PhoneServices", function() { return PhoneServices; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_native_call_number_ngx__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic-native/call-number/ngx */ "Wwn5");
/*
  PhoneServices Class
  provides methods to store and read values, objects, array from/to localStorage

  USAGE:
    > in your "component" TS
      import {PhoneServices} from "../Classes/Phone";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          PhoneServices
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/



let PhoneServices = class PhoneServices {
    // #region Variables
    // #endregion Variables
    // #region Constructors
    constructor(callNumber) {
        this.callNumber = callNumber;
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    call(number) {
        /**
         * call a phone number
         * see: https://ionicframework.com/docs/native/call-number
           requires
             ionic cordova plugin add call-number
             npm install @ionic-native/call-number
         */
        this.callNumber.callNumber(number, true)
            .then(res => console.log('Launched dialer!', res))
            .catch(err => console.log('Error launching dialer', err));
    }
};
PhoneServices.ctorParameters = () => [
    { type: _ionic_native_call_number_ngx__WEBPACK_IMPORTED_MODULE_2__["CallNumber"] }
];
PhoneServices = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])()
], PhoneServices);



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
    // #region Constructor
    constructor() {
        /**
         * Constructor
         */
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
    showAlert(title, subtitle, message, timeout, buttonText) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // shows device native alert by alertController
            // default timeout 0"
            if (timeout === undefined)
                timeout = 0;
            if (buttonText === undefined)
                buttonText = 'OK';
            const msg = yield this.alertController.create({
                animated: true,
                backdropDismiss: false,
                header: title,
                subHeader: subtitle,
                message: message,
                buttons: [buttonText]
            });
            yield msg.present();
            // sets timeout
            if (timeout > 0) {
                setTimeout(() => {
                    msg.dismiss();
                    console.log('timeout scaduto');
                }, timeout);
            }
            yield msg.present();
            return new Promise((resolve, reject) => {
                msg.onDidDismiss().then((result) => {
                    resolve(true);
                });
            });
        });
    }
    showConfirm(title, subtitle, message, buttons) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // defaults buttons
            if (buttons === undefined) {
                buttons = [
                    'Cancel',
                    'OK'
                ];
            }
            // shows device native alert by alertController
            const msg = yield this.alertController.create({
                animated: true,
                backdropDismiss: false,
                header: title,
                subHeader: subtitle,
                message: message,
                buttons: [
                    {
                        text: buttons[0],
                        role: 'cancel',
                        handler: () => {
                            //console.log('Cancel clicked');
                        }
                    },
                    {
                        text: buttons[1],
                        role: 'ok',
                        handler: () => {
                            //console.log('OK clicked');
                        }
                    }
                ]
            });
            yield msg.present();
            return new Promise((resolve, reject) => {
                msg.onDidDismiss().then((result) => {
                    resolve(result.role === 'ok');
                });
            });
        });
    }
    getLoader(message, duration) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // returns a loading object
            if (message == undefined)
                message = 'Please wait...';
            if (duration == undefined)
                duration = 60000;
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
                    resolve(result.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    listWorkers() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * Lists Workers (enabled and not in use)
             */
            return new Promise((resolve, reject) => {
                this.get('/workers/list/').then((result) => {
                    resolve(result.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    listVeichles() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * Lists Veichles (enabled and not in use)
             */
            return new Promise((resolve, reject) => {
                this.get('/veichles/list/').then((result) => {
                    resolve(result.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    deviceAdd(deviceData, gpsData) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * Add/Updates device on server
            {
                "platform": "Android",
                "version": "10.0.0",
                "manufacter": "Samsung",
                "model": "S8",
                "is_virtual": false,
                "serial": "20c8bef9-3f86-4ddc-a8c6-xxx",
                "uuid": "x1234",
                "connection_type": "wifi",
                "app_version": "1.0.0"
                "latitude": "41.19317221071111",
                "longitude": "16.599785497822222",
                "accuracy": "10"
            }
            */
            const payload = {
                "platform": deviceData.platform,
                "version": deviceData.version,
                "manufacter": deviceData.manufacter,
                "model": deviceData.model,
                "is_virtual": deviceData.isVirtual,
                "serial": deviceData.serial,
                "uuid": deviceData.uuid,
                "connection_type": deviceData.connection_type,
                'app_version': src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].APP_VERSION,
                "latitude": gpsData.latitude,
                "longitude": gpsData.longitude,
                "accuracy": gpsData.accuracy,
            };
            return new Promise((resolve, reject) => {
                this.post('/devices/add/', payload).then((result) => {
                    resolve(result.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    startTrackingSession(deviceData, gpsData, worker, veichle, password) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * startTrackingSession
            {
              "device":{
                "platform":"browser",
                "version":"0.0.0",
                "manufacter":"manufacter",
                "model":"model",
                "isVirtual":false,
                "serial":"unknown",
                "uuid":"debug_browser",
                "connection_type":"ethernet"
              },
              "gps":{
                "latitude":44.6466223,
                "longitude":10.9308673,
                "accuracy":20,
                "timestamp":1621246509939,
                "valid":true
              },
              "worker":{
                "id":8,
                "name":"ANNA",
                "surname":"E. NACCAH"
              },
              "veichle":{
                "id":1,
                "manufacter":"Citroen",
                "model":"C3",
                "licence_plate":"XX123XX"
              },
              "password":"password"
            }
             */
            const payload = {
                "device": deviceData,
                "gps": gpsData,
                "worker": worker,
                "veichle": veichle,
                "password": password
            };
            return new Promise((resolve, reject) => {
                this.post('/workers/startTrackingSession/', payload).then((result) => {
                    resolve(result);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    continueTracking(sessionID, gpsData, navigationStatus) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * Continue Tracking
              {
                  "gps": {
                      "latitude": 44.6466223,
                      "longitude": 10.9308673,
                      "accuracy": 12,
                      "timestamp": 1621246509939,
                      "valid": true
                  },
                  "session_id": "20210518140719-1-1-2"
              }
             */
            const payload = {
                "gps": gpsData,
                "session_id": sessionID,
                "navigation_status": navigationStatus
            };
            return new Promise((resolve, reject) => {
                this.post('/workers/continueTracking/', payload).then((result) => {
                    resolve(result);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    stopTracking(sessionID) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * Stop Tracking
              {
                  "session_id": "20210518140719-1-1-2"
              }
             */
            const payload = {
                "session_id": sessionID
            };
            return new Promise((resolve, reject) => {
                this.post('/workers/stopTrackingSession/', payload).then((result) => {
                    resolve(result);
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    // #region Public Methods
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
                        console.warn('API Debugger LOG', 'GET', uri, JSON.stringify(response));
                    resolve(response);
                }, (err) => {
                    if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_LOGGER_ENABLED)
                        console.error('API Debug LOG', 'GET', uri, JSON.stringify(err));
                    let xErr = this.envelopeError(err);
                    reject(xErr);
                });
            });
        });
    }
    post(uri, data) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                const headers = new _angular_common_http__WEBPACK_IMPORTED_MODULE_3__["HttpHeaders"]()
                    .set('Access-Control-Allow-Origin', '*')
                    .set('Content-Type', 'application/json; charset=utf-8')
                    .set('Accept', 'application/json')
                    .set('Authorization', 'Bearer ' + src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_TOKEN);
                this.httpClient.post(this.endPoint() + uri, data, { 'headers': headers }).subscribe((response) => {
                    if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_LOGGER_ENABLED)
                        console.warn('API Debugger LOG', 'POST', uri, JSON.stringify(response));
                    resolve(response);
                }, (err) => {
                    if (src_environments_environment__WEBPACK_IMPORTED_MODULE_4__["environment"].API_LOGGER_ENABLED)
                        console.error('API Debug LOG', 'POST', uri, JSON.stringify(err));
                    let xErr = this.envelopeError(err);
                    reject(xErr);
                });
            });
        });
    }
    // #endregion Http Base Functions
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
/* harmony import */ var _ionic_native_call_number_ngx__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @ionic-native/call-number/ngx */ "Wwn5");
/* harmony import */ var _ionic_native_insomnia_ngx__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @ionic-native/insomnia/ngx */ "pOfa");
/* harmony import */ var _ionic_native_app_update_ngx__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @ionic-native/app-update/ngx */ "u4kk");
/* harmony import */ var _ionic_native_autostart_ngx__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @ionic-native/autostart/ngx */ "F6t2");
/* harmony import */ var _Classes_App__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./Classes/App */ "FNOQ");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! ./Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! ./Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! ./Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(/*! ./Classes/GeoLocation */ "vA/e");
/* harmony import */ var _Classes_LocalData__WEBPACK_IMPORTED_MODULE_22__ = __webpack_require__(/*! ./Classes/LocalData */ "/zBf");
/* harmony import */ var _Classes_Phone__WEBPACK_IMPORTED_MODULE_23__ = __webpack_require__(/*! ./Classes/Phone */ "JgwU");

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

// CallNumber
// see  https://ionicframework.com/docs/native/call-number

// Insomina
// Prevent the screen of the mobile device from falling asleep.
// see  https://ionicframework.com/docs/native/insomnia
// NOTES:   requires    ionic cordova plugin add cordova-plugin-insomnia
//                      npm install @ionic-native/insomnia

// App Update
// does self-update for android
// The plugin will compare the app version and update it automatically if the API has a newer version to install.
// see      https://ionicframework.com/docs/v3/native/app-update/
// see      https://www.npmjs.com/package/cordova-plugin-app-update
// sample   https://www.freakyjolly.com/ionic-4-in-app-version-check-and-updater-dialog-using-app-update-native-plugin/#Host_XML_file_to_a_server
// NOTES:   requires    ionic cordova plugin add cordova-plugin-app-update
//                      npm install --save @ionic-native/app-update@latest
//          requires
//          platforms/android/app/src/main/AndroidManifest.xml
//          <uses-permission android:name="android.permission.REQUEST_INSTALL_PACKAGES" />
//
/*          requires
            a web url that returns an XML by
            # APP_NAME              same name as config.xml
            # APP_VERSION           version number without dots (eg. 5.2.1 => 50201)
            # APP_URI               the APK filename located into public/downloads (its url will be website/downloads/<APP_URI>)

            <update>
              <version>50201</version>      <!-- version 5.2.1  -->
              <name>MyApp</name>
              <url>http://gestionale.mgnservice.it/downloads/app.apk</url>
            </update>

            where APP Config.xml is
            <widget id="..." version="5.2.1" xmlns="http://www.w3.org/ns/widgets" xmlns:android="http://schemas.android.com/apk/res/android" xmlns:cdv="http://cordova.apache.org/ns/1.0">
              <name>MyApp</name>
            ...
*/

/* Autostart
    This plugin automatically starts your Android app after every boot or auto-update.
    You can enable or disable the autostart function in your app.
        npm install @ionic-native/autostart
        see: https://ionicframework.com/docs/native/autostart
*/

// WebArtigiani Classes







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
            _ionic_native_call_number_ngx__WEBPACK_IMPORTED_MODULE_13__["CallNumber"],
            _ionic_native_insomnia_ngx__WEBPACK_IMPORTED_MODULE_14__["Insomnia"],
            _ionic_native_app_update_ngx__WEBPACK_IMPORTED_MODULE_15__["AppUpdate"],
            _ionic_native_autostart_ngx__WEBPACK_IMPORTED_MODULE_16__["Autostart"],
            // WebArtigiani
            _Classes_App__WEBPACK_IMPORTED_MODULE_17__["AppService"],
            _Classes_API__WEBPACK_IMPORTED_MODULE_18__["ApiService"],
            _Classes_Utils__WEBPACK_IMPORTED_MODULE_19__["UtilsService"],
            _Classes_Components__WEBPACK_IMPORTED_MODULE_20__["ComponentsService"],
            _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_21__["GeoLocationService"],
            _Classes_LocalData__WEBPACK_IMPORTED_MODULE_22__["LocalDataService"],
            _Classes_Phone__WEBPACK_IMPORTED_MODULE_23__["PhoneServices"],
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
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic-native/geolocation/ngx */ "Bfh1");
/* harmony import */ var _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic-native/native-geocoder/ngx */ "h+qT");
/* harmony import */ var src_environments_environment__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! src/environments/environment */ "AytR");
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
    // #endregion Variables
    // #region Constructors
    constructor(geolocation, nativeGeocoder, platform) {
        this.geolocation = geolocation;
        this.nativeGeocoder = nativeGeocoder;
        this.platform = platform;
        // #region Variables
        this.lastLat = null; // last coordinates detected
        this.lastLng = null;
        // constructor...
    }
    // #endregion Constructors
    // #region Public Methods
    checkService() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            /**
             * checks Geolocation service
             */
            return new Promise((resolve, reject) => {
                this.geolocation.getCurrentPosition(this.getOptions())
                    .then((data) => {
                    // result
                    resolve(this.envelopeData(data, 0));
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
              * geo-locate the device
              */
            return new Promise((resolve, reject) => {
                this.geolocation.getCurrentPosition(this.getOptions())
                    .then((data) => {
                    // getCurrentPosition result
                    // es: 41.1954148 16.6165038
                    if (data.timestamp > 0) {
                        // calculates distance from the latest point
                        let distance = 0;
                        if (this.lastLat !== null) {
                            distance = this.getDistance(data.coords.latitude, data.coords.longitude, this.lastLat, this.lastLng, 'haversine');
                            distance = Math.round(distance * 100) / 100; // rounds 2 decimals
                        }
                        this.lastLat = data.coords.latitude;
                        this.lastLng = data.coords.longitude;
                        resolve(this.envelopeData(data, distance));
                    }
                    else {
                        // location is empty
                    }
                }).catch((error) => {
                    reject(error);
                });
            });
        });
    }
    openMap(latitude, longitude) {
        // open the Map APP (depending on the platform)
        // pointing to the specified coords
        // Android:       geo:44.6318615,11.1861538
        // iOS:           maps://maps.apple.com/?q=40.943616,16.9213952
        // GoogleMaps:    https://www.google.it/maps/place/testo+ricerca/@44.6318615,11.1861538,17z
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
    getDistance(lat1, lon1, lat2, lon2, mode) {
        let R = 6371; // Earth radius in km
        switch (mode) {
            case 'spherical':
            default:
                var dLon = this.degToRad(lon2 - lon1);
                lat1 = this.degToRad(lat1);
                lat2 = this.degToRad(lat2);
                var d = Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * R;
                break;
            case 'haversine':
                var dLat = this.degToRad(lat2 - lat1);
                var dLon = this.degToRad(lon2 - lon1);
                lat1 = this.degToRad(lat1);
                lat2 = this.degToRad(lat2);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                break;
            case 'rectangle':
                var x = this.degToRad(lon2 - lon1) * Math.cos(this.degToRad(lat1 + lat2) / 2);
                var y = this.degToRad(lat2 - lat1);
                var d = Math.sqrt(x * x + y * y) * R;
                break;
        }
        return d;
    }
    // #endregion Public Methods
    // #region Private Methods
    getOptions() {
        // envelope geolocation options
        let ret = {
            timeout: (src_environments_environment__WEBPACK_IMPORTED_MODULE_5__["environment"].LOCATION_TIMEOUT * 1000),
            enableHighAccuracy: true,
            maximumAge: 0 // no cached position
        };
        return ret;
    }
    envelopeData(data, distance) {
        // evenlope getCurrentPosition result
        let ret;
        if (data.timestamp > 0) {
            ret = {
                "latitude": data.coords.latitude,
                "longitude": data.coords.longitude,
                "accuracy": data.coords.accuracy,
                "distance": distance,
                "timestamp": data.timestamp,
                "valid": true
            };
        }
        else {
            // not valid data
            ret = {
                "latitude": 0,
                "longitude": 0,
                "accuracy": 0,
                "distance": 0,
                "timestamp": 0,
                "valid": false
            };
        }
        return ret;
    }
    degToRad(n) {
        return n * Math.PI / 180;
    }
    radToDeg(n) {
        return n * 180 / Math.PI;
    }
};
GeoLocationService.ctorParameters = () => [
    { type: _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_3__["Geolocation"] },
    { type: _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_4__["NativeGeocoder"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_2__["Platform"] }
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
        redirectTo: 'start',
        pathMatch: 'full'
    },
    {
        path: 'start',
        loadChildren: () => __webpack_require__.e(/*! import() | start-start-module */ "start-start-module").then(__webpack_require__.bind(null, /*! ./start/start.module */ "qyyb")).then(m => m.StartPageModule)
    },
    {
        path: 'login-veichle',
        loadChildren: () => __webpack_require__.e(/*! import() | login-veichle-login-veichle-module */ "login-veichle-login-veichle-module").then(__webpack_require__.bind(null, /*! ./login-veichle/login-veichle.module */ "rH1d")).then(m => m.LoginVeichlePageModule)
    },
    {
        path: 'tracking',
        loadChildren: () => __webpack_require__.e(/*! import() | tracking-tracking-module */ "tracking-tracking-module").then(__webpack_require__.bind(null, /*! ./tracking/tracking.module */ "ZyQ5")).then(m => m.TrackingPageModule)
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