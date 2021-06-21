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
import { Component } from '@angular/core';
import { environment } from "src/environments/environment";

import { NavController } from '@ionic/angular';
import { Platform } from '@ionic/angular';

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
import { AppUpdate } from '@ionic-native/app-update/ngx';

// WebArtigiani Classes
import { AppService } from '../Classes/App';
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';
import { PhoneServices } from '../Classes/Phone';

@Component({
  selector: 'app-start',
  templateUrl: './start.page.html',
  styleUrls: ['./start.page.scss'],
})
export class StartPage {

  // #region Variables
  statusDesc: string = 'caricamento...'
  statusError: boolean = false
  execDelay: number = 0.25                        // numero di secondi di attesa esecuzione
  retryDelay: number = 3                          // numero di secondi per retrial
  // #endregion Variables

  // #region Constructor
  constructor(
      // WebArtigiani
      public app: AppService,
      private api: ApiService,
      private utils: UtilsService,
      private components: ComponentsService,

      private platform: Platform,
      private geolocation: GeoLocationService,
      private localData: LocalDataService,
      private phone: PhoneServices,

      // Angular
      public navCtrl: NavController,
      private appUpdate: AppUpdate,
  ) {
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
    console.log('ngOnInit')
    this.app.setAutostart(true)     // sets APP for auto-start
  }
  ngAfterViewInit() {
    console.log('start', 'ngAfterViewInit')

    // allows screen falling asleep (NOTE: here, we DO NOT keep APP in foreground)
    this.utils.allowScreenFallAsleep()
    //this.utils.keepForeground()

    // checks for App Updates
    if (!this.utils.isDebug()) {
      // running on Device
      const updateUrl = this.updateUrl()
      this.appUpdate.checkAppUpdate(updateUrl).then((result) => {
        /**
         * Returns
         *
          {"code": 202, "msg": "success, up to date."}          // when APP is updated
          {code: 201, msg: "success, need date."}               // when Update is needed
         */
        if (result.code === 201) {
          this.statusDesc = 'Aggiornamento APP in corso...';    // Update needed
          return
        } else {
          // other codes....
          this.startApp()
        }
      }).catch((error) => {
        // error getting update info
        console.error('checkUpdates errore', error);
        this.startApp()
      })
    } else {
      // DEBUG mode (browser)
      this.startApp()
    }
  }
  // #endregion Component LifeCycls

  // #region Public Methods
  startApp() {
    // starts steps...
    setTimeout(() => {
      this.checkConnection()
    }, this.execDelay * 1000 * 2);
  }
  checkConnection() {
    /**
     * step 1: checks internet connection
     */

    this.statusDesc = 'verifica connessione...'

    setTimeout(() => {
      // 0.5" before we really check connection

      if (this.utils.isDeviceOnLine()) {
        // device connected:
        this.statusDesc = 'connessione OK'
        setTimeout(() => {
          this.pingServer()
        }, this.execDelay * 1000);
      } else {
        // device not connected: retry in 1"
        this.statusDesc = 'Connessione Assente.<br><br>Attiva la connessione dati del tuo dispositivo.'
        setTimeout(() => {
          this.checkConnection()     // retry All in 3"
        }, this.retryDelay * 1000);
      }
    }, this.execDelay * 1000);
  }

  pingServer() {
    /**
     * step 2: try to ping server
     * */
    this.statusDesc = 'connessione al server MGN...'

    setTimeout(() => {
      this.api.ping().then((result) => {
        // ping OK
        this.statusDesc = 'Connessione al server MGN Ok'
        setTimeout(() => {
          this.checkGeoLocationService()
        }, this.execDelay * 1000);
      }).catch((error) => {
        // ping Error
        this.statusDesc = 'Server MGN non raggiungibile.<br><br>Nuovo tentativo in ' + this.retryDelay  + '"...'
        setTimeout(() => {
          this.checkConnection()      // retry All in 3"
        }, this.retryDelay * 1000);
      })
    }, this.execDelay * 1000);
  }

  checkGeoLocationService() {
    /**
     * step 3: checks geo-location service
     */
    this.statusDesc = 'verifica servizio GPS...'

    setTimeout(() => {
      this.geolocation.checkService().then((data) => {
        // Geo-location service OK

        this.statusDesc = 'Avvio in corso...'
        this.registerDevice(data);
      }).catch((error) => {
        // geolocation.checkService() error
        // describes the error
        let m = ''
        switch (error.code) {
          case 1:
            m= 'Devi autorizzare la localizzazione'
            break
          case 2:
            m = 'Errore di rete GPS.'
            break
          case 3:
            m = 'Timeout GPS.'
            break
          default:
            m = 'Errore GPS ' + error.code + ', ' + error.message
            break
        }
        this.statusDesc = m + '<br><br>Nuovo tentativo in ' + this.retryDelay  + '"...'
        setTimeout(() => {
          this.checkGeoLocationService()
        }, this.retryDelay * 1000)
      })
    }, this.execDelay * 1000);
  }

  registerDevice(data) {
    /**
     * step 4: register/updates the device via API
     */
     this.api.deviceAdd(this.utils.getDeviceData(), data).then((result) => {
      // device added/updated via API: navigate to login page
      setTimeout(() => {
        this.navCtrl.navigateRoot('login-veichle')
      }, this.execDelay * 1000);
    }).catch((error) => {
      // API Error
      this.components.showAlert(error['message'], 'Si è verificato un errore', error['message_details']);
      window.location.reload()
    });
  }
  // #endregion Public Methods

  // #region Private Methods
  private updateUrl() {
    // returns the App Update Url

    let ret = ''
    if (this.platform.is('cordova')) {
        // running on device
        ret = environment.WEB_SITE
    } else {
        // running on localhost or public domain, depending on API_USE_LOCAL
        if (environment.WEB_SITE)
          ret = environment.WEB_SITE_LOCAL
        else
          ret = environment.WEB_SITE
    }
    return ret += 'app/update/'
  }
  // #endregion Private Mehods
}
