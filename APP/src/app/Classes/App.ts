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

import {Injectable} from "@angular/core";
import { environment } from "src/environments/environment";
import { Platform } from '@ionic/angular';

// WebArtigiani Classes
import { UtilsService } from '../Classes/Utils';
import { ApiService } from '../Classes/API';

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

/* Autostart
    This plugin automatically starts your Android app after every boot or auto-update.
    You can enable or disable the autostart function in your app.
        npm install @ionic-native/autostart
        see: https://ionicframework.com/docs/native/autostart
*/
import { Autostart } from '@ionic-native/autostart/ngx';

declare let window;

@Injectable()
export class AppService {

  // #region Variables
  // #endregion Variables


  // #region Constructors
   constructor(
      // WebArtigiani
      private utils: UtilsService,
      private api: ApiService,

      private platform: Platform,
      private appUpdate: AppUpdate,
      private autostart: Autostart
   ) {
      // constructor...
   }
  // #endregion Constructors

  // #region Public Methods
  appName() {
    return environment.APP_TITLE;
  }
  appVersion() {
    return environment.APP_VERSION;
  }
  debugGPS() {
    return environment.DEBUG_GPS;
  }
  setAutostart(enable) {
    console.log('setAutostart', enable)
    if (enable) {
      this.autostart.enable();
    } else {
      this.autostart.disable();
    }
  }
  exitKiosk() {
    /** exit KioskMode
     * requires cordova-plugin-kiosk
     * https://github.com/hkalina/cordova-plugin-kiosk
     */
    //window.KioskPlugin.exitKiosk();
  }
  // #endregion Public Methods

  // #region Private Methods
  // #endregion Private Methods
}
