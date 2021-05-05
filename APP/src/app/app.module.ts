import { NgModule, enableProdMode } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';

import { IonicModule, IonicRouteStrategy } from '@ionic/angular';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';

// geolocation and native-geocoder
import { Geolocation } from '@ionic-native/geolocation/ngx';
import { NativeGeocoder, NativeGeocoderResult, NativeGeocoderOptions } from '@ionic-native/native-geocoder/ngx';

// Device (see https://ionicframework.com/docs/v3/native/device/)
// NOTES: requires  npm install --save @ionic-native/device@latest
import { Device } from '@ionic-native/device/ngx';

// UniqueDeviceID (see https://ionicframework.com/docs/native/unique-device-id)
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';

// ScreenOrientation (see https://ionicframework.com/docs/native/screen-orientation)
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

// http requests
import { HttpClientModule } from '@angular/common/http';

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
    Geolocation,
    NativeGeocoder,
    {
      provide: RouteReuseStrategy,
      useClass: IonicRouteStrategy
    },
    Device,
    UniqueDeviceID,
    Uid,
    AndroidPermissions,
    ScreenOrientation
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
