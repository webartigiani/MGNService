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
/* harmony default export */ __webpack_exports__["default"] = ("<ion-header [translucent]=\"true\">\n  <ion-toolbar>\n    <ion-title>\n      <img src=\"assets/icon/favicon.png\" class=\"title-icon\">\n      MGN Service\n    </ion-title>\n  </ion-toolbar>\n</ion-header>\n\n<ion-content [fullscreen]=\"true\">\n  B\n  <!-- form iniziale -->\n  <div id=\"startingForm\"\n    *ngIf=\"true\"\n    >\n    <ion-list>\n      <ion-item>\n        <ion-label>Operatore</ion-label>  <!-- selezione operatore -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"operator\"\n          >\n          <ion-select-option *ngFor=\"let item of this.operators\" [value]=\"item\">{{ item.name }} {{ item.surname }}</ion-select-option>\n        </ion-select>\n      </ion-item>\n      <ion-item>\n        <ion-label>Veicolo</ion-label>    <!-- selezione veicolo -->\n        <ion-select value=\"\"\n          interface=\"action-sheet\"\n          cancel-text=\"Annulla\"\n          [(ngModel)]=\"veichle\"\n          >\n          <ion-select-option *ngFor=\"let item of this.veichles\" [value]=\"item\">{{ item.manufacter }} {{ item.model }} ({{ item.licence_plate }})</ion-select-option>\n        </ion-select>\n      </ion-item>\n    </ion-list>\n  </div>\n\n  <!-- geoLocaiton div -->\n  <div id=\"geoLocator\"\n    *ngIf=\"false\"\n    >\n\n    <!-- results -->\n    <div id=\"results\"\n      *ngIf=\"error_code === 0\"\n    >\n      <br><br><br>\n      <img src=\"assets/ani/locator.gif\" class=\"ani\">\n      <br><br>\n      <p>Procedi verso la tua destinazione...</p>\n    </div>\n\n  </div>\n</ion-content>\n\n<!-- Footer -->\n<ion-footer class=\"ion-no-border\">\n  <ion-grid>\n    <ion-row no-padding no-margin>\n        <ion-col col-12 no-padding class=\"center\">\n\n          <!-- start button -->\n          <ion-button\n            *ngIf=\"true\"\n            (click)=\"startLocating()\"\n            shape=\"round\"\n          >Avvia</ion-button>\n\n          <!-- stop button -->\n          <ion-button\n            *ngIf=\"false\"\n            (click)=\"dummy()\"\n            shape=\"round\"\n          >Stop</ion-button>\n\n        </ion-col>\n    </ion-row>\n  </ion-grid>\n</ion-footer>\n");

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
/* harmony import */ var _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ionic-native/network/ngx */ "kwrG");
/* harmony import */ var _Classes_API__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Classes/API */ "YBWL");
/* harmony import */ var _Classes_Utils__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Classes/Utils */ "1ZYi");
/* harmony import */ var _Classes_Components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Classes/Components */ "Vw97");
/* harmony import */ var _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../Classes/GeoLocation */ "vA/e");




// Network
// see  https://ionicframework.com/docs/native/network

// WebArtigiani Classes




let HomePage = class HomePage {
    // #endregion Variables
    // #region Constructors
    constructor(
    // WebArtigiani
    api, utils, components, geolocation, network) {
        // Constructor
        this.api = api;
        this.utils = utils;
        this.components = components;
        this.geolocation = geolocation;
        this.network = network;
        // #region Variables
        this.baseURL = 'https://jsonplaceholder.typicode.com'; // API End-point base url
        this.operators = []; // operatori
        this.operator = '';
        this.veichles = []; // targhe veicoli
        this.veichle = '';
        // clears console
        console.clear();
        // #region Network
        setInterval(() => {
            console.log('we are connected via ' + this.network.type);
            console.log(this.network);
        }, 1000);
        // #endregion Network
        // lists workers and veichles
        this.api.listWorkers().then((result) => {
            // list workers
            this.operators = result;
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
        this.geolocation.checkService().then((data) => {
        }).catch((err) => {
        });
    }
    // #endregion Constructors
    // #region View LifeCycle Events
    // see: https://angular.io/guide/lifecycle-hooks
    ngOnInit() {
        /*
        Initialize the directive or component
        after Angular first displays the data-bound properties and sets the directive or component's input properties.
        Called once
        */
        console.log('ngOnInit');
    }
    ngAfterContentInit() {
        /*
        Respond after Angular projects external content into the component's view, or into the view that a directive is in.
        Called once
        */
        console.log('ngAfterContentInit');
    }
    ngAfterContentChecked() {
        // Respond after Angular checks the content projected into the directive or component.
    }
    ngAfterViewInit() {
        /*
        Respond after Angular initializes the component's views and child views, or the view that contains the directive.
        Called once
        */
        console.log('ngAfterViewInit');
    }
    ngAfterViewChecked() {
        // Respond after Angular checks the component's views and child views, or the view that contains the directive.
    }
    ngOnDestroy() {
        /*
        Cleanup just before Angular destroys the directive or component.
        Unsubscribe Observables and detach event handlers to avoid memory leaks.
        */
        console.log('ngOnDestroy');
    }
    // #endregion View LifeCycle Events
    // #region Public/Private Methods
    // #region User Functions
    startLocating() {
        return Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__awaiter"])(this, void 0, void 0, function* () {
            // checks operator and veichle selection
            if ((typeof this.operator === 'string') || (typeof this.veichle === 'string')) {
                this.components.showAlert('Attenzione', 'Operatore e veicolo richiesti', 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo');
                return;
            }
            // shows loader then calls API
            this.components.getLoader('Verifica connessione...').then((loading) => {
                loading.present();
                loading.message = 'Verifica servizio GeoLocalizzazione...';
                this.geolocation.checkService()
                    .then((result) => {
                    // GeoLocation Service running
                    loading.dismiss();
                    /* start locating
                    this.locate()
                    this.tmr = setInterval( ()=>{
                      this.locate()
                    }, (this.locationInterval * 1000))
                    */
                }).catch((error) => {
                    // GeoLocation Error {code:%, message:$}
                    loading.dismiss();
                    alert(error.message);
                });
            });
        });
    }
    dummy() {
    }
    // #endregion User Functions
    // #region Location Functions
    isLocating() {
        return true;
    }
    // #endregion Location Functions
    // #endregion
    // #region Utils Functions
    timestampToDateTime(ts) {
        return new Date(ts); //.toLocaleDateString("it-IT")
    }
};
HomePage.ctorParameters = () => [
    { type: _Classes_API__WEBPACK_IMPORTED_MODULE_5__["ApiService"] },
    { type: _Classes_Utils__WEBPACK_IMPORTED_MODULE_6__["UtilsService"] },
    { type: _Classes_Components__WEBPACK_IMPORTED_MODULE_7__["ComponentsService"] },
    { type: _Classes_GeoLocation__WEBPACK_IMPORTED_MODULE_8__["GeoLocationService"] },
    { type: _ionic_native_network_ngx__WEBPACK_IMPORTED_MODULE_4__["Network"] }
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