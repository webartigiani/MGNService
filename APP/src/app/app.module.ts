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

// WebArtigiani Classes
import { ApiService } from './Classes/API';
import { UtilsService } from './Classes/Utils';
import { ComponentsService } from './Classes/Components';
import { GeoLocationService } from './Classes/GeoLocation';
import { LocalDataService } from './Classes/LocalData';

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
    /*
    UniqueDeviceID,
    Uid,
    AndroidPermissions,
    */

    // WebArtigiani
    ApiService,
    UtilsService,
    ComponentsService,
    GeoLocationService,
    LocalDataService
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
