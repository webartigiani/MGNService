(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["home-home-module"],{

/***/ "A3+G":
/*!*********************************************!*\
  !*** ./src/app/home/home-routing.module.ts ***!
  \*********************************************/
/*! exports provided: HomePageRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomePageRoutingModule", function() { return HomePageRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "tyNb");
/* harmony import */ var _home_page__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./home.page */ "zpKS");




const routes = [
    {
        path: '',
        component: _home_page__WEBPACK_IMPORTED_MODULE_3__["HomePage"],
    }
];
let HomePageRoutingModule = class HomePageRoutingModule {
};
HomePageRoutingModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
        exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]]
    })
], HomePageRoutingModule);



/***/ }),

/***/ "WcN3":
/*!***************************************************************************!*\
  !*** ./node_modules/raw-loader/dist/cjs.js!./src/app/home/home.page.html ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header [translucent]=\"true\">\n  <ion-toolbar>\n    <ion-title>\n      <img src=\"assets/icon/favicon.png\" class=\"title-icon\">\n      MGN Service\n    </ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content [fullscreen]=\"true\">\n\n  <!-- form iniziale -->\n  <div id=\"startingForm\"\n    *ngIf=\"!isLocating()\"\n    >\n    <ion-list>\n      <ion-item>\n        <ion-label>Operatore</ion-label>  <!-- selezione operatore -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"operator\"\n          >\n          <ion-select-option *ngFor=\"let op of this.operators\" [value]=\"op\">{{ op.name }}</ion-select-option>\n        </ion-select>\n      </ion-item>\n      <ion-item>\n        <ion-label>Veicolo</ion-label>    <!-- selezione veicolo -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"veichle\"\n          >\n          <ion-select-option *ngFor=\"let v of this.veichles\" [value]=\"v\">{{ v.title }}</ion-select-option>\n        </ion-select>\n      </ion-item>\n    </ion-list>\n  </div>\n\n  <!-- geoLocaiton div -->\n  <div id=\"geoLocator\"\n    *ngIf=\"isLocating()\"\n    >\n\n    <!-- results -->\n    <div id=\"results\"\n      *ngIf=\"error_code === 0\"\n    >\n      <br><br><br>\n      <img src=\"assets/ani/locator.gif\" class=\"ani\">\n      <br><br>\n      <p>Procedi verso la tua destinazione...</p>\n\n      <br>\n      <p>{{ geoData.latitude }}<br>{{ geoData.longitude }}</p>\n      <br><p>accuracy: {{ geoData.accuracy }} mt</p>\n      <br><p>{{ timestampToDateTime(geoData.timestamp) }}</p>\n      <br><p>{{ locationProgress }}</p>\n    </div>\n\n    <!-- error -->\n    <div id=\"error\"\n      *ngIf=\"error_code > 0\"\n      >\n      <p>{{ error_code }}</p>\n      <p>{{ error_message }}</p>\n    </div>\n  </div>\n</ion-content>\n\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n\n          <!-- start button -->\n          <ion-button\n            *ngIf=\"!isLocating()\"\n            (click)=\"startLocating()\"\n            shape=\"round\"\n          >Avvia</ion-button>\n\n          <!-- stop button -->\n          <ion-button\n            *ngIf=\"isLocating()\"\n            (click)=\"stopLocating()\"\n            shape=\"round\"\n          >Stop</ion-button>\n\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

/***/ }),

/***/ "ct+p":
/*!*************************************!*\
  !*** ./src/app/home/home.module.ts ***!
  \*************************************/
/*! exports provided: HomePageModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomePageModule", function() { return HomePageModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "ofXK");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/forms */ "3Pt+");
/* harmony import */ var _home_page__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./home.page */ "zpKS");
/* harmony import */ var _home_routing_module__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./home-routing.module */ "A3+G");







let HomePageModule = class HomePageModule {
};
HomePageModule = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
        imports: [
            _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
            _angular_forms__WEBPACK_IMPORTED_MODULE_4__["FormsModule"],
            _ionic_angular__WEBPACK_IMPORTED_MODULE_3__["IonicModule"],
            _home_routing_module__WEBPACK_IMPORTED_MODULE_6__["HomePageRoutingModule"]
        ],
        declarations: [_home_page__WEBPACK_IMPORTED_MODULE_5__["HomePage"]]
    })
], HomePageModule);



/***/ }),

/***/ "f6od":
/*!*************************************!*\
  !*** ./src/app/home/home.page.scss ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = (".center {\n  text-align: center;\n}\n\nimg.title-icon {\n  max-width: 32px;\n}\n\n#geoLocator {\n  text-align: center;\n  position: absolute;\n  left: 0;\n  right: 0;\n  top: 50%;\n  height: 100%;\n  transform: translateY(-50%);\n}\n\n#geoLocator img.ani {\n  width: 50%;\n  max-width: 200px;\n}\n\n#geoLocator p {\n  font-size: 16px;\n  line-height: 22px;\n  color: #8c8c8c;\n  margin: 0;\n}\n\n#geoLocator a {\n  text-decoration: none;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy4uL2hvbWUucGFnZS5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0Usa0JBQUE7QUFDRjs7QUFFQTtFQUNFLGVBQUE7QUFDRjs7QUFFQTtFQUNFLGtCQUFBO0VBQ0Esa0JBQUE7RUFDQSxPQUFBO0VBQ0EsUUFBQTtFQUNBLFFBQUE7RUFDQSxZQUFBO0VBQ0EsMkJBQUE7QUFDRjs7QUFDRTtFQUNFLFVBQUE7RUFDQSxnQkFBQTtBQUVKOztBQUFFO0VBQ0UsZUFBQTtFQUNBLGlCQUFBO0VBQ0EsY0FBQTtFQUNBLFNBQUE7QUFHSjs7QUFERTtFQUNFLHFCQUFBO0FBSUoiLCJmaWxlIjoiaG9tZS5wYWdlLnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIuY2VudGVyIHtcbiAgdGV4dC1hbGlnbjogY2VudGVyO1xufVxuXG5pbWcudGl0bGUtaWNvbiB7XG4gIG1heC13aWR0aDozMnB4O1xufVxuXG4jZ2VvTG9jYXRvciB7XG4gIHRleHQtYWxpZ246IGNlbnRlcjtcbiAgcG9zaXRpb246IGFic29sdXRlO1xuICBsZWZ0OiAwO1xuICByaWdodDogMDtcbiAgdG9wOiA1MCU7XG4gIGhlaWdodDoxMDAlO1xuICB0cmFuc2Zvcm06IHRyYW5zbGF0ZVkoLTUwJSk7XG59XG4gICNnZW9Mb2NhdG9yIGltZy5hbmkge1xuICAgIHdpZHRoOiA1MCU7XG4gICAgbWF4LXdpZHRoOiAyMDBweDtcbiAgfVxuICAjZ2VvTG9jYXRvciBwIHtcbiAgICBmb250LXNpemU6IDE2cHg7XG4gICAgbGluZS1oZWlnaHQ6IDIycHg7XG4gICAgY29sb3I6ICM4YzhjOGM7XG4gICAgbWFyZ2luOiAwO1xuICB9XG4gICNnZW9Mb2NhdG9yIGEge1xuICAgIHRleHQtZGVjb3JhdGlvbjogbm9uZTtcbiAgfVxuIl19 */");

/***/ }),

/***/ "zpKS":
/*!***********************************!*\
  !*** ./src/app/home/home.page.ts ***!
  \***********************************/
/*! exports provided: HomePage */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomePage", function() { return HomePage; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "mrSG");
/* harmony import */ var _raw_loader_home_page_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! raw-loader!./home.page.html */ "WcN3");
/* harmony import */ var _home_page_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./home.page.scss */ "f6od");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ "fXoL");
/* harmony import */ var _ionic_angular__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic/angular */ "TEn/");
/* harmony import */ var _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ionic-native/device/ngx */ "xS7M");
/* harmony import */ var _ionic_native_unique_device_id_ngx__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @ionic-native/unique-device-id/ngx */ "/+Rg");
/* harmony import */ var _ionic_native_uid_ngx__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @ionic-native/uid/ngx */ "JN8Z");
/* harmony import */ var _ionic_native_android_permissions_ngx__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @ionic-native/android-permissions/ngx */ "WOgW");
/* harmony import */ var _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @ionic-native/screen-orientation/ngx */ "0QAI");
/* harmony import */ var _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @ionic-native/geolocation/ngx */ "Bfh1");
/* harmony import */ var _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @ionic-native/native-geocoder/ngx */ "h+qT");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/common/http */ "tk/3");






// UniqueDeviceID (see https://ionicframework.com/docs/native/unique-device-id)
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/



// ScreenOrientation (see https://ionicframework.com/docs/native/screen-orientation)

// GeoLocation and GeoCoder


// Http Request

let HomePage = class HomePage {
    // #endregion Variables
    // #region Constructors
    constructor(platform, uniqueDeviceID, uid, device, androidPermissions, screenOrientation, alertController, loadingController, geolocation, nativeGeocoder, httpClient) {
        // Constructor
        this.platform = platform;
        this.uniqueDeviceID = uniqueDeviceID;
        this.uid = uid;
        this.device = device;
        this.androidPermissions = androidPermissions;
        this.screenOrientation = screenOrientation;
        this.alertController = alertController;
        this.loadingController = loadingController;
        this.geolocation = geolocation;
        this.nativeGeocoder = nativeGeocoder;
        this.httpClient = httpClient;
        // #region Variables
        this.baseURL = 'https://jsonplaceholder.typicode.com'; // API End-point base url
        this.operators = []; // operatori
        this.operator = '';
        this.veichles = []; // targhe veicoli
        this.veichle = '';
        // device
        this.UUID = '';
        // Location and Map Settings
        this.locationInterval = 10; // interval to acquire GPS data
        this.locationTimeout = 5; // location timeout seconds
        this.tmr = null; // location timer
        // Location Data and results
        this.locationProgress = 0; // location progress: 0=stopped;
        this.locationErrors = 0; // location errors counter
        this.locationEmpty = 0; // location empty (coords 0,0)
        this.error_code = 0;
        this.error_message = '';
        this.geoData = {
            latitude: 0,
            longitude: 0,
            accuracy: 0,
            timestamp: 0 // timestamp
        };
        // Lock screen orientation
        this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.LANDSCAPE_PRIMARY);
        console.log('platform', this.device.platform);
        console.log('version', this.device.version);
        console.log('model', this.device.model);
        console.log('manufacturer', this.device.manufacturer);
        console.log('isVirtual', this.device.isVirtual);
        console.log('serial', this.device.serial);
        // detect orientation changes
        this.screenOrientation.onChange().subscribe(() => {
            console.log("Orientation Changed", this.screenOrientation.type);
        });
        // gets operators list
        this.apiGet('/users/').then((result) => {
            if (result != undefined) {
                // overwrites operatori
                result = [
                    {
                        name: 'BRANCHINI GIOVANNI MARIA'
                    },
                    {
                        name: 'ALBERTI LIDIA'
                    },
                    {
                        name: 'BICOCCHI STEFANIA'
                    }
                ];
                this.operators = result;
                // gets veichles list
                this.apiGet('/todos/').then((result) => {
                    if (result != undefined) {
                        // overwrites veichles
                        result = [
                            {
                                title: 'CITROEN C3 (XX123XX)'
                            },
                            {
                                title: 'Fiat Punto (YY000YY)'
                            }
                        ];
                        this.veichles = result;
                    }
                    else {
                        // API Error
                        alert('errore API veichles');
                    }
                });
            }
            else {
                // API Error
                alert('errore API operatori');
            }
        });
        // on Android, detects device UUID
        if (this.platform.is('android')) {
            this.uniqueDeviceID.get()
                .then((uuid) => this.UUID = uuid)
                .catch((error) => alert(JSON.stringify(error)));
        }
    }
    // #endregion Constructors
    // #region Public/Private Methods
    // #region User Functions
    startLocating() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // checks operator and veichle selection
            if ((typeof this.operator === 'string') || (typeof this.veichle === 'string')) {
                const alert = yield this.alertController.create({
                    animated: true,
                    backdropDismiss: false,
                    header: 'Attenzione',
                    subHeader: 'Operatore e veicolo richiesti',
                    message: 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo',
                    buttons: ['OK']
                });
                yield alert.present();
                return;
            }
            // start locating veichle
            this.locationErrors = 0;
            // shows loader then calls API
            this.getLoading('Verifica connessione...').then((loading) => {
                loading.present(),
                    this.apiGet('/todos/1')
                        .then((result) => {
                        if (result != undefined) {
                            // API OK: checks GeoLocation service
                            loading.message = 'Verifica servizio GeoLocalizzazione...';
                            this.checkGeoLocationService()
                                .then((result) => {
                                // GeoLocation Service running
                                loading.dismiss();
                                // start locating
                                this.locate();
                                this.tmr = setInterval(() => {
                                    this.locate();
                                }, (this.locationInterval * 1000));
                            }).catch((error) => {
                                // GeoLocation Error {code:%, message:$}
                                loading.dismiss();
                                alert(error.message);
                            });
                        }
                        else {
                            // API Error
                            loading.dismiss(); // closes loader
                        }
                    });
            });
        });
    }
    stopLocating() {
        // stop locating veichle
        this.locationProgress = 0;
        clearInterval(this.tmr);
        this.tmr = 0;
    }
    // #endregion User Functions
    // #region Location Functions
    isLocating() {
        return (this.tmr > 0);
    }
    locationStatus() {
        return this.locationProgress;
    }
    checkGeoLocationService() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // checks Geolocation service
            let geoLocationOptions = {
                timeout: (this.locationTimeout * 1000),
                enableHighAccuracy: true,
                maximumAge: 0 // no cached position
            };
            return new Promise((resolve, reject) => {
                this.geolocation.getCurrentPosition(geoLocationOptions)
                    .then((data) => {
                    // getCurrentPosition result
                    resolve(data);
                }).catch((error) => {
                    // getCurrentPosition error
                    reject(error);
                });
            });
        });
    }
    locate() {
        // locates the veichle
        this.resetLocationData();
        let geoLocationOptions = {
            timeout: (this.locationTimeout * 1000),
            enableHighAccuracy: true,
            maximumAge: 0 // no cached position
        };
        this.geolocation.getCurrentPosition(geoLocationOptions)
            .then((data) => {
            // getCurrentPosition result
            // es: 41.1954148 16.6165038
            console.log('geolocation result', data.coords.latitude, data.coords.longitude, data.timestamp);
            if (data.timestamp > 0) {
                this.geoData.latitude = data.coords.latitude;
                this.geoData.longitude = data.coords.longitude;
                this.geoData.accuracy = Math.round(data.coords.accuracy);
                this.geoData.timestamp = data.timestamp;
                this.locationErrors = 0;
                this.locationEmpty = 0;
                this.locationProgress += 1;
            }
            else {
                // location is empty
                this.error_code = 0;
                this.error_message = 'location empty';
            }
        }).catch((error) => {
            // getCurrentPosition error
            this.error_code = error.code;
            this.error_message = error.message;
            this.locationErrors += 1;
        });
    }
    resetLocationData() {
        // resets error
        this.error_code = 0;
        this.error_message = '';
        // resets data
        /*
        this.geoData.latitude = 0
        this.geoData.longitude = 0
        this.geoData.accuracy = 0
        this.geoData.timestamp = 0
        */
    }
    // #endregion Location Functions
    // #region Map Functions
    /*
    initMap(lat?: number, lng?:number) {
      // initializes map
      if (lat == undefined) lat = 0
      if (lng == undefined) lng = 0

      const map = new Map('geoLocator').setView([lat, lng], this.mapZoomLevel);

      this.mapInit = true
    }
    refreshMap(lat: number, lng:number) {
      // refresh map
      if (lat == undefined) lat = 0
      if (lng == undefined) lng = 0

      const map = Map('geoLocator')
      map.setView([lat, lng], 23)

      const m = new marker([lat, lng])
      m.addTo(map)
      console.log('refreshMap')
    }
    */
    openMapAPP() {
        // opens map APP
        // Android: geo:41.1954148,16.6165038
        // iOS:     maps://maps.apple.com/?q=41.1954148,16.6165038
        let url = '';
        if (this.platform.is('android')) {
            url = 'geo:' + this.geoData.latitude + ',' + this.geoData.longitude;
        }
        if (this.platform.is('desktop')) {
            url = 'maps://maps.apple.com/?q=' + this.geoData.latitude + ',' + this.geoData.longitude;
        }
        if (url != '')
            window.open(url);
        else
            alert('cannot open maps');
    }
    // #endregion
    // #region Http Functions
    apiGet(uri) {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            return new Promise((resolve, reject) => {
                this.httpClient.get(this.baseURL + uri).subscribe((response) => {
                    resolve(response);
                }, (err) => {
                    reject(err);
                });
            })
                .catch((err) => {
            });
        });
    }
    // #endregion Http Functions
    // #region Utils Functions
    getLoading(message, duration) {
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
    timestampToDateTime(ts) {
        return new Date(ts); //.toLocaleDateString("it-IT")
    }
};
HomePage.ctorParameters = () => [
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["Platform"] },
    { type: _ionic_native_unique_device_id_ngx__WEBPACK_IMPORTED_MODULE_6__["UniqueDeviceID"] },
    { type: _ionic_native_uid_ngx__WEBPACK_IMPORTED_MODULE_7__["Uid"] },
    { type: _ionic_native_device_ngx__WEBPACK_IMPORTED_MODULE_5__["Device"] },
    { type: _ionic_native_android_permissions_ngx__WEBPACK_IMPORTED_MODULE_8__["AndroidPermissions"] },
    { type: _ionic_native_screen_orientation_ngx__WEBPACK_IMPORTED_MODULE_9__["ScreenOrientation"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["AlertController"] },
    { type: _ionic_angular__WEBPACK_IMPORTED_MODULE_4__["LoadingController"] },
    { type: _ionic_native_geolocation_ngx__WEBPACK_IMPORTED_MODULE_10__["Geolocation"] },
    { type: _ionic_native_native_geocoder_ngx__WEBPACK_IMPORTED_MODULE_11__["NativeGeocoder"] },
    { type: _angular_common_http__WEBPACK_IMPORTED_MODULE_12__["HttpClient"] }
];
HomePage = Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_3__["Component"])({
        selector: 'app-home',
        template: _raw_loader_home_page_html__WEBPACK_IMPORTED_MODULE_1__["default"],
        styles: [_home_page_scss__WEBPACK_IMPORTED_MODULE_2__["default"]]
    })
], HomePage);



/***/ })

}]);
//# sourceMappingURL=home-home-module.js.map