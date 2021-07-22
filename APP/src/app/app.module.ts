/*
app.module.ts
src/app.module.ts
*/
import { NgModule, enableProdMode } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';

import { IonicModule, IonicRouteStrategy, NavController } from '@ionic/angular';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';

// geolocation and native-geocoder
import { Geolocation } from '@ionic-native/geolocation/ngx';
import { NativeGeocoder, NativeGeocoderResult, NativeGeocoderOptions } from '@ionic-native/native-geocoder/ngx';

// Device
// see https://ionicframework.com/docs/v3/native/device/
// NOTES: requires  npm install --save @ionic-native/device@latest
import { Device } from '@ionic-native/device/ngx';

// ScreenOrientation (see https://ionicframework.com/docs/native/screen-orientation)
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

// http requests
import { HttpClientModule } from '@angular/common/http';

// Network
// see  https://ionicframework.com/docs/native/network
import { Network } from '@ionic-native/network/ngx';

// CallNumber
// see  https://ionicframework.com/docs/native/call-number
import { CallNumber } from '@ionic-native/call-number/ngx'

// Insomina
// Prevent the screen of the mobile device from falling asleep.
// see  https://ionicframework.com/docs/native/insomnia
// NOTES:   requires    ionic cordova plugin add cordova-plugin-insomnia
//                      npm install @ionic-native/insomnia
import { Insomnia } from '@ionic-native/insomnia/ngx';

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
import { AppService } from './Classes/App';
import { ApiService } from './Classes/API';
import { UtilsService } from './Classes/Utils';
import { ComponentsService } from './Classes/Components';
import { GeoLocationService } from './Classes/GeoLocation';
import { LocalDataService } from './Classes/LocalData';
import { PhoneServices } from './Classes/Phone';

/* NOT USED
 UniqueDeviceID (see https://ionicframework.com/docs/native/unique-device-id)
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';
*/

enableProdMode()

@NgModule({
  declarations: [AppComponent],
  entryComponents: [],
  imports: [
    BrowserModule,
    IonicModule.forRoot(),
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [
    NavController,
    Geolocation,
    NativeGeocoder,
    {
      provide: RouteReuseStrategy,
      useClass: IonicRouteStrategy
    },
    Device,
    ScreenOrientation,
    Network,
    CallNumber,
    Insomnia,
    AppUpdate,

    // WebArtigiani
    AppService,
    ApiService,
    UtilsService,
    ComponentsService,
    GeoLocationService,
    LocalDataService,
    PhoneServices,
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
