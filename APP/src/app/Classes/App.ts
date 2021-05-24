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
   ) {
      // constructor...
   }
  // #endregion Constructors

  // #region Public Methods
  appName() {
    return environment.APP_TITLE
  }
  appVersion() {
    return environment.APP_VERSION
  }
  debugGPS() {
    return environment.DEBUG_GPS
  }

  checkUpdates() {
    // we do not update in debug (browser)
    if (this.utils.isDebug()) return

    const updateUrl = this.updateUrl()
    this.appUpdate.checkAppUpdate(updateUrl).then((result) => {
      /**
       * Returns
       *
        {"code": 202, "msg": "success, up to date."}          // when APP is updated
        {code: 201, msg: "success, need date."}               // when Update is needed
       */
      console.log('checkUpdates', result)
    }).catch((error) => {
      console.error('checkUpdates errore', error)
    })
  }

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
  // #endregion Public Methods
}
